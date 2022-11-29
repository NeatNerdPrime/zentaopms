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
class zanodemodel extends model
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
    const KVM_TOKEN_PATH  = '/api/v1/virtual/getVncToken';


    /**
     * Create an Node.
     *
     * @param  object $data
     * @access public
     * @return void
     */
    public function create()
    {
        $data = fixer::input('post')->get();

        /* Batch check fields. */
        $this->lang->vm = $this->lang->zanode;
        $data->type = 'node';
        $this->dao->update(TABLE_ZAHOST)->data($data)
            ->batchCheck($this->config->zanode->create->requiredFields, 'notempty')
            ->check('name', 'unique');
        if(dao::isError()) return false;

        if(!preg_match("/^(?!_)(?!-)(?!\.)[a-zA-Z0-9\_\.\-]+$/", $data->name))
        {
            dao::$errors[] = $this->lang->zanode->nameValid;
            return false;
        }

        /* Get image. */
        $image = $this->getImageByID($data->image);

        /* Get host info. */
        $host = $this->getHostByID($data->parent);

        /* Gen mac address */
        $mac = $this->genmac();

        /* Prepare create params. */
        $agnetUrl = 'http://' . $host->extranet . ':' . $this->config->zanode->defaultPort;
        $param    = array(
            'os'           => $image->os,
            'path'         => $image->path,
            'name'         => $data->name,
            'cpu'          => (int)$data->cpu,
            'disk'         => (int)$data->disk,
            'memory'       => (int)$data->memory,
        );

        $result = json_decode(commonModel::http($agnetUrl . static::KVM_CREATE_PATH, json_encode($param), null));

        if(empty($result))
        {
            dao::$errors[] = $this->lang->zanode->notFoundAgent;
            return false;
        }
        if($result->code != 'success')
        {
            dao::$errors[] = $this->lang->zanode->createVmFail;
            return false;
        }

        /* Prepare create execution node data. */
        $data->image       = $data->image;
        $data->parent      = $host->id;
        $data->mac         = $mac;
        $data->status      = static::STATUS_RUNNING;
        $data->createdBy   = $this->app->user->account;
        $data->createdDate = helper::now();
        $data->vnc         = (int)$result->data->vnc;

        /* Save execution node. */
        $this->dao->insert(TABLE_ZAHOST)->data($data)->autoCheck()->exec();
        if(dao::isError()) return false;

        $nodeID = $this->dao->lastInsertID();

        /* update action log. */
        $this->loadModel('action')->create('zanode', $nodeID, 'Created');
        return true;
    }

    /**
     * Action Node.
     *
     * @param  int $id
     * @param  string $type
     * @return string
     */
    public function handleNode($id, $type)
    {
        $node = $this->getNodeByID($id);
        $host = $this->getHostByID($node->parent);

        /* Prepare create params. */
        $agnetUrl = 'http://' . $host->extranet . ':' . $this->config->zanode->defaultPort;
        $path     = '/api/v1/kvm/' . $node->name . '/' . $type;
        $param    = array('vmUniqueName' => $node->name);

        $result = commonModel::http($agnetUrl . $path, $param);
        $data   = json_decode($result, true);
        if(empty($data)) return $this->lang->zanode->notFoundAgent;

        if($data['code'] != 'success') return zget($this->lang->zanode->apiError, $data['code'], $data['msg']);

        if($type != 'reboot')
        {
            $status = $type == 'suspend' ? 'suspend' : 'running';
            $this->dao->update(TABLE_ZAHOST)->set('status')->eq($status)->where('id')->eq($id)->exec();
        }

        $this->loadModel('action')->create('zanode', $id, ucfirst($type));
        return;
    }

    /**
     * Destroy Node.
     *
     * @param  int $id
     * @access public
     * @return void
     */
    public function destroy($id)
    {
        $node = $this->getNodeByID($id);
        $host = $this->getHostByID($node->parent);

        $req = array( 'name' => $node->name );

        /* Prepare create params. */
        if($host)
        {
            $agnetUrl = 'http://' . $host->extranet . ':' . $this->config->zanode->defaultPort;
            $result = commonModel::http($agnetUrl . '/api/v1/kvm/remove', json_encode($req));

            $data = json_decode($result, true);
            if(empty($data)) return $this->lang->zanode->notFoundAgent;

            if($data['code'] != 'success') return zget($this->lang->zanode->apiError, $data['code'], $data['msg']);
        }

        /* delete execution node. */
        $this->dao->update(TABLE_ZAHOST)
            ->set('deleted')->eq(1)
            ->where('id')->eq($id)
            ->exec();
        $this->loadModel('action')->create('zanode', $id, 'destroy');
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
            ->where('objectType')->eq('zanode')
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
     * Update Node attribute.
     *
     * @param  int $id
     * @param  array $data
     * @return void
     */
    public function update($id, $data)
    {
        $this->dao->update(TABLE_ZAHOST)->data($data)
            ->where('id')->eq($id)
            ->exec();
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
    public function getListByQuery($browseType = 'all', $param = 0, $orderBy = 't1.id_desc', $pager = null)
    {
        $query = '';
        if($browseType == 'bysearch')
        {
            if($param)
            {
                $query = $this->loadModel('search')->getQuery($param);
                if($query)
                {
                    $this->session->set('nodeQuery', $query->sql);
                    $this->session->set('nodeForm',  $query->form);
                }
                else
                {
                    $this->session->set('nodeQuery', ' 1 = 1');
                }
            }
            else
            {
                if($this->session->zanodeQuery == false) $this->session->set('zanodeQuery', ' 1 = 1');
            }
            $query = $this->session->zanodeQuery;
            $query = str_replace('`id`', 't1.`id`', $query);
            $query = str_replace('`name`', 't1.`name`', $query);
            $query = str_replace('`status`', 't1.`status`', $query);
            $query = str_replace('`os`', 't1.`os`', $query);
            $query = str_replace('`parent`', 't1.`parent`', $query);
            $query = str_replace('`hostID`', 't2.`id`', $query);
        }

        return $this->dao->select('t1.*, t1.name as hostName, t2.extranet,t3.osName')->from(TABLE_ZAHOST)->alias('t1')
            ->leftJoin(TABLE_ZAHOST)->alias('t2')->on('t1.parent = t2.id')
            ->leftJoin(TABLE_IMAGE)->alias('t3')->on('t3.id = t1.image')
            ->where('t1.deleted')->eq(0)
            ->andWhere("t1.type")->eq("node")
            ->andWhere("(t1.createdBy = '{$this->app->user->account}')")
            ->beginIF($query)->andWhere($query)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Get node list by hostID.
     *
     * @param  string $browseType
     * @param  int    $param
     * @param  string $orderBy
     * @param  object $pager
     * @return void
     */
    public function getListByHost($hostID, $orderBy = 'id_desc')
    {
        return $this->dao->select('id, name, vnc, cpuCores, memory, diskSize, osName, status')->from(TABLE_ZAHOST)
            ->where('deleted')->eq(0)
            ->andWhere("parent")->eq($hostID)
            ->orderBy($orderBy)
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
            ->where('extranet')->eq($ip)
            ->fetch();
    }

    /**
     * Get Image.
     *
     * @param  int $id
     * @access public
     * @return object
     */
    public function getImageByID($id)
    {
        return $this->dao->select('*')->from(TABLE_IMAGE)
            ->where('id')->eq($id)
            ->fetch();
    }

    /**
     * Get Node image list.
     *
     * @param  string $orderBy
     * @param  int    $pager
     * @access public
     * @return array
     */
    public function getimageList($orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_IMAGE)->orderBy($orderBy)->page($pager)->fetchAll();
    }

    /**
     * Get Node by id.
     *
     * @param  int $id
     * @return object
     */
    public function getNodeByID($id)
    {
        return $this->dao->select('t1.*, t1.name as hostName, t2.extranet as ip,t3.osName')->from(TABLE_ZAHOST)->alias('t1')
            ->leftJoin(TABLE_ZAHOST)->alias('t2')->on('t1.parent = t2.id')
            ->leftJoin(TABLE_IMAGE)->alias('t3')->on('t3.id = t1.image')
            ->where('t1.id')->eq($id)
            ->fetch();
    }

    /**
     * Get Node by mac address.
     *
     * @param  string $mac
     * @return object
     */
    public function getNodeByMac($mac)
    {
        return $this->dao->select('*')->from(TABLE_ZAHOST)
            ->where('mac')->eq($mac)
            ->andWhere("type")->eq('node')
            ->fetch();
    }

    /**
     * Generage unique mac address.
     *
     * @return void
     */
    private function genmac()
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

        $Node = $this->getNodeByMac($mac);
        if(empty($Node))
        {
            return $mac;
        }
        $this->genmac();
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
        $vm = $this->getNodeByID($vmID);
        if(empty($vm) or empty($vm->parent) or empty($vm->vnc)) return false;

        $host = $this->getHostByID($vm->parent);
        if(empty($host)) return false;

        $agnetUrl = 'http://' . $host->extranet . ':8086' . static::KVM_TOKEN_PATH;
        $result   = json_decode(commonModel::http("$agnetUrl?port={$vm->vnc}", array(), array(CURLOPT_CUSTOMREQUEST => 'GET'), array(), 'json'));

        if(empty($result) or $result->code != 'success') return false;

        $returnData = new stdClass();
        $returnData->hostIP    = $host->extranet;
        $returnData->agentPort = $host->agentPort;
        $returnData->vnc       = $vm->vnc;
        $returnData->token     = $result->data->token;
        return $returnData;
    }

    public function buildOperateMenu($node)
    {
        if($node->deleted) return '';

        $menu   = '';
        $params = "id=$node->id";

        $menu .= $this->buildMenu('zanode', 'edit',   $params, $node, 'view');

        $params = "id=$node->id";
        $menu .= $this->buildMenu('zanode', 'delete', $params, $node, 'view', 'trash', 'hiddenwin');

        return $menu;
    }
}
