<?php
/**
 * The model file of vm module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      xiawenlong <xiawenlong@cnezsoft.com>
 * @package     ops
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class executionnodemodel extends model
{

    const STATUS_CREATED      = 'created';
    const STATUS_LAUNCH       = 'launch';
    const STATUS_FAIL_CREATE  = 'vm_fail_create';
    const STATUS_RUNNING      = 'running';
    const STATUS_SHUTOFF      = 'shutoff';
    const STATUS_BUSY         = 'busy';
    const STATUS_READY        = 'ready';
    const STATUS_UNKNOWN      = 'unknown';
    const STATUS_DESTROY      = 'destroy';
    const STATUS_DESTROY_FAIL = 'vim_destroy_fail';

    const KVM_CREATE_PATH = '/api/v1/kvm/create';
    const KVM_TOKEN_PATH  = '/api/v1/vnc/getToken';


    /**
     * Create an VM.
     *
     * @param  object $data
     * @param  int    $templateID
     * @access public
     * @return void
     */
    public function create()
    {
        $data = fixer::input('post')->get();

        /* Batch check fields. */
        $this->lang->vm = $this->lang->executionnode;
        $this->dao->update(TABLE_VM)->data($data)
            ->batchCheck($this->config->executionnode->create->requiredFields, 'notempty')
            ->check('name', 'unique');
        if(dao::isError()) return false;

        if(!preg_match("/^(?!_)(?!-)(?!\.)[a-zA-Z0-9\_\.\-]+$/", $data->name))
        {
            dao::$errors[] = $this->lang->executionnode->nameValid;
            return false;
        }

        /* Get Vmtemplate. */
        $vmTemplate = $this->getVmTemplateByID($data->templateID);
        $data->osCategory = $vmTemplate->osCategory;
        $data->osType     = $vmTemplate->osType;
        $data->osVersion  = $vmTemplate->osVersion;
        $data->osLang     = $vmTemplate->osLang;

        /* Get host info. */
        $host = $this->getHostByID($vmTemplate->hostID);

        /* Gen mac address */
        $macAddress = $this->genMacAddress();

        /* Prepare create params. */
        $agnetUrl = 'http://' . $host->publicIP . ':' . $this->config->executionnode->defaultPort;
        $param    = array(
            'vmMacAddress' => $macAddress,
            'osCategory'   => $vmTemplate->osCategory,
            'osType'       => $vmTemplate->osType,
            'osLang'       => $data->osLang,
            'osVersion'    => $vmTemplate->osVersion,
            'vmTemplate'   => $vmTemplate->imageName,
            'vmUniqueName' => $data->name,
            'vmCpu'        => (int)$data->osCpu,
            'vmDiskSize'   => (int)$data->osDisk,
            'vmMemorySize' => (int)$data->osMemory,
        );

        $result = json_decode(commonModel::http($agnetUrl . static::KVM_CREATE_PATH, json_encode($param), null));

        if(empty($result))
        {
            dao::$errors[] = $this->lang->executionnode->notFoundAgent;
            return false;
        }
        if($result->code != 1)
        {
            dao::$errors[] = $this->lang->executionnode->createVmFail;
            return false;
        }

        /* Prepare create execution node data. */
        $data->templateID  = $data->templateID;
        $data->hostID      = $host->id;
        $data->macAddress  = $macAddress;
        $data->status      = static::STATUS_RUNNING;
        $data->createdBy   = $this->app->user->account;
        $data->createdDate = helper::now();
        $data->osCategory  = $vmTemplate->osCategory;
        $data->osType      = $vmTemplate->osType;
        $data->osArch      = $vmTemplate->osArch;
        $data->vncPort     = (int)$result->data->vncPort;

        /* Save execution node. */
        $this->dao->insert(TABLE_VM)->data($data)->autoCheck()->exec();
        if(dao::isError()) return false;

        $nodeID = $this->dao->lastInsertID();

        /* update action log. */
        $this->loadModel('action')->create('executionnode', $nodeID, 'Created');
        return true;
    }

    /**
     * Action VM.
     *
     * @param  int $id
     * @param  string $type
     * @return string
     */
    public function handleVM($id, $type)
    {
        $node = $this->getVMByID($id);
        $host = $this->getHostByID($node->hostID);

        /* Prepare create params. */
        $agnetUrl = 'http://' . $host->publicIP . ':' . $this->config->executionnode->defaultPort;
        $path     = '/api/v1/kvm/' . $node->name . '/' . $type;
        $param    = array('vmUniqueName' => $node->name);

        $result = commonModel::http($agnetUrl . $path, $param);
        $data   = json_decode($result, true);
        if(empty($data)) return $this->lang->executionnode->notFoundAgent;

        if($data['code'] != 1) return zget($this->lang->executionnode->apiError, $data['code'], $data['msg']);

        if($type != 'reboot')
        {
            $status = $type == 'suspend' ? 'suspend' : 'running';
            $this->dao->update(TABLE_VM)->set('status')->eq($status)->where('id')->eq($id)->exec();
        }

        $this->loadModel('action')->create('executionnode', $id, ucfirst($type));
        return;
    }

    /**
     * Destroy VM.
     *
     * @param  int $id
     * @access public
     * @return void
     */
    public function destroy($id)
    {
        $node = $this->getVMByID($id);
        $host = $this->getHostByID($node->hostID);

        $req = array( 'vmUniqueName' => $node->name );

        /* Prepare create params. */
        if($host)
        {
            $agnetUrl = 'http://' . $host->publicIP . ':' . $this->config->executionnode->defaultPort;
            $result = commonModel::http($agnetUrl . '/api/v1/kvm/' . $node->name . '/destroy', json_encode($req));

            $data = json_decode($result, true);
            if(empty($data)) return $this->lang->executionnode->notFoundAgent;

            if($data['code'] != 1) return zget($this->lang->executionnode->apiError, $data['code'], $data['msg']);
        }

        /* delete execution node. */
        $this->dao->update(TABLE_VM)
            ->set('deleted')->eq(1)
            ->set('destroyAt')->eq(helper::now())
            ->where('id')->eq($id)
            ->exec();
        $this->loadModel('action')->create('executionnode', $id, 'destroy');
        return;
    }

    /**
     * Get execution node created action record by node ID.
     *
     * @param  int  $id
     * @access public
     * @return object
     */
    public function getNodeCreateActionByID($id)
    {
        return $this->dao->select('*')->from(TABLE_ACTION)
            ->where('objectType')->eq('executionnode')
            ->andWhere('objectID')->eq($id)
            ->andWhere('action')->eq('created')
            ->fetch();
    }

    /**
     * Callback update host data.
     *
     * @access public
     * @return mixed
     */
    public function updateHostByCallback()
    {
        $data = array();
        $data['status']    = isset($_POST['status']) ? $_POST['status'] : '';
        $data['agentPort'] = isset($_POST['port']) ? $_POST['port'] : '';
        $ip = isset($_POST['ip']) ? $_POST['ip'] : '';

        if(empty($ip)) return false;

        $host = $this->getHostByIP($ip);
        if(empty($host)) return 'Not Found';

        $this->dao->update(TABLE_ZAHOST)->data($data)
            ->where('id')->eq($host->id)
            ->exec();
        return true;
    }

    /**
     * Update VM attribute.
     *
     * @param  int $id
     * @param  array $data
     * @return void
     */
    public function update($id, $data)
    {
        $this->dao->update(TABLE_VM)->data($data)
            ->where('id')->eq($id)
            ->exec();
    }

    /**
     * Set vm name.
     *
     * @param  array $vm
     * @param  int $id
     * @access public
     * @return array
     */
    public function setVmName($vm, $id)
    {
        $name = sprintf('test-%s-%s-%s-%s-%d', $vm['osCategory'], $vm['osType'], $vm['osArch'], $vm['osLang'], $id);
        $this->dao->update(TABLE_VM)->data(array('name' => $name))
            ->where('id')->eq($id)
            ->exec();
        $vm['name'] = $name;
        return $vm;
    }

    /**
     * Get vm list.
     *
     * @param  string $browseType
     * @param  int    $param
     * @param  string $orderBy
     * @param  object $pager
     * @return void
     */
    public function getListByQuery($browseType = 'all', $param = 0, $orderBy = 'id_desc', $pager = null)
    {
        $query = '';
        if($browseType == 'bysearch')
        {
            if($param)
            {
                $query = $this->loadModel('search')->getQuery($param);
                if($query)
                {
                    $this->session->set('vmQuery', $query->sql);
                    $this->session->set('vmForm',  $query->form);
                }
                else
                {
                    $this->session->set('vmQuery', ' 1 = 1');
                }
            }
            else
            {
                if($this->session->vmQuery == false) $this->session->set('vmQuery', ' 1 = 1');
            }
            $query = $this->session->vmQuery;
            $query = str_replace('`id`', 't1.`id`', $query);
            $query = str_replace('`name`', 't1.`name`', $query);
            $query = str_replace('`status`', 't1.`status`', $query);
            $query = str_replace('`osCategory`', 't1.`osCategory`', $query);
            $query = str_replace('`osType`', 't1.`osType`', $query);
            $query = str_replace('`hostID`', 't1.`hostID`', $query);
            $query = str_replace('`osVersion`', 't4.`osVersion`', $query);
        }

        $orderBy = str_replace('osVersion', 't4.osVersion', $orderBy);

        return $this->dao->select('t1.*, t3.name as hostName, t2.publicIP as hostIP,t4.osVersion')->from(TABLE_VM)->alias('t1')
            ->leftJoin(TABLE_ZAHOST)->alias('t2')->on('t1.hostID = t2.id')
            ->leftJoin(TABLE_ASSET)->alias('t3')->on('t3.id = t2.assetID')
            ->leftJoin(TABLE_VMTEMPLATE)->alias('t4')->on('t4.id = t1.templateID')
            ->where('t1.deleted')->eq(0)
            ->andWhere("((t1.public = 1) OR (t1.createdBy = '{$this->app->user->account}'))")
            ->beginIF($query)->andWhere($query)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();
    }


    /**
     * Get Host by id.
     *
     * @param  int $id
     * @access public
     * @return object
     */
    public function getHostByID($id)
    {
        return $this->dao->select('*')->from(TABLE_ZAHOST)
            ->where('id')->eq($id)
            ->fetch();
    }

    /**
     * Get Host by IP.
     *
     * @param  string $ip
     * @access public
     * @return object
     */
    public function getHostByIP($ip)
    {
        return $this->dao->select('*')->from(TABLE_ZAHOST)
            ->where('publicIP')->eq($ip)
            ->fetch();
    }

    /**
     * Get BaseImage by name.
     *
     * @param  int $id
     * @access public
     * @return object
     */
    public function getBaseImageByID($id)
    {
        return $this->dao->select('*')->from(TABLE_BASEIMAGE)
            ->where('id')->eq($id)
            ->fetch();
    }

    /**
     * Get VM template.
     *
     * @param  int $id
     * @access public
     * @return object
     */
    public function getVmTemplateByID($id)
    {
        return $this->dao->select('*')->from(TABLE_VMTEMPLATE)
            ->where('id')->eq($id)
            ->fetch();
    }

    /**
     * Get os list by osCategory.
     *
     * @param  stirng $osCategory
     * @access public
     * @return void
     */
    public function getOsByOsType($osCategory)
    {
        $list = array();
        foreach($this->lang->vm->osTypeList as $item)
        {
            if($osCategory == $item['osType'])
            {
                $list[$item['value']] = $item['label'];
            }
        }
        return $list;
    }

    /**
     * Get baseImage list by params.
     *
     * @param  string $osCategory
     * @param  string $osType
     * @access public
     * @return array
     */
    public function getBaseImageList($osCategory = '', $osType = '')
    {
        return $this->dao->select('*')->from(TABLE_BASEIMAGE)
            ->where('osCategory')->eq($osCategory)
            ->andwhere('osType')->eq($osType)
            ->fetchAll('id');
    }

    /**
     * Get VM template list.
     *
     * @param  string $orderBy
     * @param  int    $pager
     * @access public
     * @return array
     */
    public function getVmTemplateList($orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_VMTEMPLATE)->orderBy($orderBy)->page($pager)->fetchAll();
    }

    /**
     * Get Vm Templaete pairs.
     *
     * @param  string $osCategory
     * @param  string $osType
     * @param  string $osVersion
     * @access public
     * @return array
     */
    public function getVmTemplatePairs($osCategory = '', $osType = '', $osVersion = '')
    {
        return $this->dao->select('id,name')->from(TABLE_VMTEMPLATE)
            ->where('osCategory')->eq($osCategory)
            ->andwhere('osType')->eq($osType)
            ->andwhere('osVersion')->eq($osVersion)
            ->fetchPairs();
    }

    /**
     * Get VM by id.
     *
     * @param  int $id
     * @return object
     */
    public function getVMByID($id)
    {
        return $this->dao->select('t1.*, t3.name as hostName, t2.publicIP as ip,t4.osVersion')->from(TABLE_VM)->alias('t1')
            ->leftJoin(TABLE_ZAHOST)->alias('t2')->on('t1.hostID = t2.id')
            ->leftJoin(TABLE_ASSET)->alias('t3')->on('t3.id = t2.assetID')
            ->leftJoin(TABLE_VMTEMPLATE)->alias('t4')->on('t4.id = t1.templateID')
            ->where('t1.id')->eq($id)
            ->fetch();
    }

    /**
     * Get VM by mac address.
     *
     * @param  string $mac
     * @return object
     */
    public function getVMByMac($mac)
    {
        return $this->dao->select('*')->from(TABLE_VM)
            ->where('macAddress')->eq($mac)
            ->fetch();
    }

    /**
     * Generage unique mac address.
     *
     * @return void
     */
    private function genMacAddress()
    {
        $buf = array(
            0x1C,
            0x1C,
            0x1C,
            mt_rand(0x00, 0x7f),
            mt_rand(0x00, 0xff),
            mt_rand(0x00, 0xff)
        );
        $mac = join(':',array_map(function($v)
        {
            return sprintf("%02X",$v);
        },$buf));

        $VM = $this->getVMByMac($mac);
        if(empty($VM))
        {
            return $mac;
        }
        $this->genMacAddress();
    }

    /**
     * Get vnc url.
     *
     * @param  int    $vmID
     * @access public
     * @return void
     */
    public function getVncUrl($vmID)
    {
        $vm = $this->getVMByID($vmID);
        if(empty($vm) or empty($vm->hostID) or empty($vm->vncPort)) return false;

        $host = $this->getHostByID($vm->hostID);
        if(empty($host)) return false;

        $agnetUrl = 'http://' . $host->publicIP . ':' . $host->agentPort . static::KVM_TOKEN_PATH;
        $result   = json_decode(commonModel::http("$agnetUrl?port={$vm->vncPort}"));

        if(empty($result) or $result->code != 1) return false;

        $returnData = new stdClass();
        $returnData->hostIP    = $host->publicIP;
        $returnData->agentPort = $host->agentPort;
        $returnData->vncPort   = $vm->vncPort;
        $returnData->token     = $result->data->token;
        return $returnData;
    }
}
