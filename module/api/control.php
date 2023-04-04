<?php
/**
 * The control file of api of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     api
 * @version     $Id: control.php 5143 2013-07-15 06:11:59Z thanatos thanatos915@163.com $
 * @link        http://www.zentao.net
 */
class api extends control
{
    public $objectType = 'nolink';
    public $objectID   = 0;

    public function __construct($moduleName = '', $methodName = '', $appName = '')
    {
        parent::__construct($moduleName, $methodName, $appName);
        $this->user   = $this->loadModel('user');
        $this->doc    = $this->loadModel('doc');
        $this->action = $this->loadModel('action');

        if($this->cookie->objectType) $this->objectType = $this->cookie->objectType;
        if($this->cookie->objectID)   $this->objectID   = $this->cookie->objectID;
    }

    /**
     * Api doc index page.
     *
     * @param  int    $libID
     * @param  int    $moduleID
     * @param  int    $apiID
     * @param  int    $version
     * @param  int    $release
     * @param  int    $appendLib
     * @param  string $browseType
     * @param  int    $param
     * @access public
     * @return void
     */
    public function index($libID = 0, $moduleID = 0, $apiID = 0, $version = 0, $release = 0, $appendLib = 0, $browseType = '', $param = 0)
    {
        $objectType = $this->objectType;
        $objectID   = $this->objectID;

        /* Get all api doc libraries. */
        $loadLib = false;
        $libs    = $this->doc->getApiLibs($appendLib, $objectType, $objectID);
        if(empty($libs) and $objectType != 'nolink')
        {
            $objectType = 'nolink';
            $objectID   = 0;
            $libs       = $this->doc->getApiLibs($appendLib, 'nolink');
        }

        if(empty($libs))
        {
            list($normalObjects, $closedObjects) = $this->api->getOrderedObjects();

            if(!empty($normalObjects))
            {
                $objectType = key($normalObjects);
                $objectID   = key($normalObjects[$objectType]);
                $libs       = $this->doc->getApiLibs($appendLib, $objectType, $objectID);
            }
            elseif(!empty($closedObjects))
            {
                $objectType = key($closedObjects);
                $objectID   = key($closedObjects[$objectType]);
                $libs       = $this->doc->getApiLibs($appendLib, $objectType, $objectID);
            }
        }

        if($libID == 0 and !empty($libs))
        {
            $lib        = current($libs);
            $libID      = $lib->id;
            $objectType = $lib->product ? 'product' : ($lib->project ? 'project' : '');
            $objectID   = $lib->product ? $lib->product : $lib->project;
            if($loadLib) $libs = $this->doc->getApiLibs($appendLib);
        }

        /* Get an api doc. */
        if($apiID > 0)
        {
            echo $this->fetch('api', 'view', "libID=$libID&apiID=$apiID&moduleID=$moduleID&release=$release&version=$version");
            return;
        }
        else
        {
            /* Get module api list. */
            $apiList = $this->api->getListByModuleId($libID, $moduleID, $release);

            $this->view->apiList  = $apiList;
            $this->view->typeList = $this->api->getTypeList($libID);
        }

        $lib       = $this->doc->getLibById($libID);
        $appendLib = (!empty($lib) and $lib->deleted == '1') ? $libID : 0;

        /* Build the search form. */
        $queryID   = $browseType == 'bySearch' ? (int)$param : 0;
        $actionURL = $this->createLink('api', 'index', "libID=$libID&moduleID=0&apiID=0&version=0&release=0&appendLib=0&browseType=bySearch&param=myQueryID");
        $this->api->buildSearchForm($lib,$queryID, $actionURL, $libs);

        if($browseType == 'bySearch')
        {
            $this->view->apiList  = $this->api->getApiListBySearch($libID, $queryID, '', array_keys($libs));
            $this->view->typeList = $this->api->getTypeList($libID);
        }

        $this->view->lib            = $lib;
        $this->view->release        = $release;
        $this->view->title          = $this->lang->api->pageTitle;
        $this->view->libID          = $libID;
        $this->view->apiID          = $apiID;
        $this->view->libs           = $libs;
        $this->view->browseType     = $browseType;
        $this->view->objectType     = $objectType;
        $this->view->objectID       = $objectID;
        $this->view->moduleID       = $moduleID;
        $this->view->libTree        = $this->api->getLibTree($libID, $libs, $moduleID, $objectID, $browseType);
        $this->view->users          = $this->user->getPairs('noclosed,noletter');
        $this->view->objectDropdown = isset($libs[$libID]) ? $this->generateLibsDropMenu($libs[$libID], $release) : '';

        $this->display();
    }

    /**
     * View api.
     *
     * @param  int    $libID
     * @param  int    $apiID
     * @param  int    $moduleID
     * @param  int    $release
     * @param  int    $version
     * @access public
     * @return void
     */
    public function view($libID, $apiID, $moduleID = 0, $release = 0, $version = 0)
    {
        /* Get all api doc libraries. */
        $libs = $this->doc->getApiLibs($libID);

        $api = $this->api->getLibById($apiID, $version, $release);
        if($api)
        {
            $moduleID  = $api->module;
            $libID     = $api->lib;
            $api->desc = htmlspecialchars_decode($api->desc);

            $this->view->api      = $api;
            $this->view->apiID    = $apiID;
            $this->view->version  = $version;
            $this->view->typeList = $this->api->getTypeList($api->lib);
            $this->view->actions  = $apiID ? $this->action->getList('api', $apiID) : array();
        }

        $this->view->title          = $this->lang->api->pageTitle;
        $this->view->libs           = $libs;
        $this->view->isRelease      = $release > 0;
        $this->view->release        = $release;
        $this->view->libID          = $libID;
        $this->view->apiID          = $apiID;
        $this->view->users          = $this->user->getPairs('noclosed,noletter');
        $this->view->moduleTree     = $this->doc->getApiModuleTree($libID, $apiID, $release, $moduleID);
        $this->view->objectDropdown = $this->generateLibsDropMenu($libs[$libID], $release);
        $this->display();
    }

    /**
     * Release list.
     *
     * @param  int $libID
     * @access public
     * @return void
     */
    public function releases($libID, $orderBy = 'id', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $libs = $this->doc->getApiLibs();
        $this->app->loadClass('pager', $static = true);
        $this->lang->modulePageNav = $this->generateLibsDropMenu($libs[$libID]);

        $pager = new pager($recTotal, $recPerPage, $pageID);

        /* Append id for secend sort. */
        $sort     = common::appendOrder($orderBy);
        $releases = $this->api->getReleaseByQuery($libID, $pager, $sort);

        $this->view->releases = $releases;
        $this->view->pager    = $pager;
        $this->view->orderBy  = $orderBy;
        $this->view->title    = $this->lang->api->managePublish;
        $this->view->libID    = $libID;
        $this->view->users    = $this->loadModel('user')->getPairs('noletter');
        $this->display();
    }

    /**
     * @param  int    $libID
     * @param  int    $id
     * @param  string $confirm
     */
    public function deleteRelease($libID, $id = 0, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->custom->notice->confirmDelete, $this->createLink('api', 'deleteRelease', "libID=$libID&id=$id&confirm=yes"), ''));
        }
        else
        {
            $this->api->deleteRelease($id);
            if(dao::isError()) return $this->sendError(dao::getError());
            return print(js::locate(inlink('releases', "libID=$libID"), 'parent'));
        }
    }

    /**
     * Create a api doc lib.
     *
     * @param  int $libID
     * @access public
     * @return void
     */
    public function createRelease($libID)
    {
        $lib = $this->doc->getLibById($libID);

        if(!empty($_POST))
        {
            $data = fixer::input('post')
                ->add('lib', $libID)
                ->add('addedBy', $this->app->user->account)
                ->add('addedDate', helper::now())
                ->get();

            /* Check version is exist. */
            if(!empty($data->version) and $this->api->getRelease($libID, 'byVersion', $data->version))
            {
                return $this->sendError($this->lang->api->noUniqueVersion);
            }
            $this->api->publishLib($data);
            if(dao::isError()) return $this->sendError(dao::getError());

            return $this->sendSuccess(array('locate' => $this->createLink('api', 'index', "libID=$libID")));
        }

        $libName = isset($lib->name) ? $lib->name : '';
        $this->view->title = $this->lang->api->createRelease . $libName;

        $this->display();
    }

    /**
     * Api doc global struct page.
     *
     * @param  int    $libID
     * @param  int    $releaseID
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function struct($libID = 0, $releaseID = 0, $orderBy = 'id', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $libs = $this->doc->getApiLibs();
        $this->app->loadClass('pager', $static = true);
        $this->lang->modulePageNav = $this->generateLibsDropMenu($libs[$libID], $releaseID);

        $pager = new pager($recTotal, $recPerPage, $pageID);

        /* Append id for secend sort. */
        $sort = common::appendOrder($orderBy);

        if($releaseID)
        {
            $release = $this->api->getRelease($libID, 'byId', $releaseID);
            $structs = $this->api->getStructListByRelease($release, '1 = 1 ', $sort);
        }
        else
        {
            $structs = $this->api->getStructByQuery($libID, $pager, $sort);
        }

        common::setMenuVars('doc', $libID);
        $this->view->libID     = $libID;
        $this->view->releaseID = $releaseID;
        $this->view->structs   = $structs;
        $this->view->orderBy   = $orderBy;
        $this->view->title     = $this->lang->api->struct;
        $this->view->pager     = $pager;
        $this->display();
    }

    /**
     * Create struct page.
     *
     * @param  int $libID
     * @access public
     * @return void
     */
    public function createStruct($libID = 0)
    {
        common::setMenuVars('doc', $libID);
        if(!empty($_POST))
        {
            $now    = helper::now();
            $userId = $this->app->user->account;
            $data   = fixer::input('post')
                ->add('lib', $libID)
                ->skipSpecial('attribute')
                ->add('addedBy', $userId)
                ->add('addedDate', $now)
                ->add('editedBy', $userId)
                ->add('editedDate', $now)
                ->get();


            $id = $this->api->createStruct($data);
            if(dao::isError()) return $this->sendError(dao::getError());

            $this->action->create('apistruct', $id, 'Created');

            return $this->sendSuccess(array('locate' => helper::createLink('api', 'struct', "libID=$libID")));
        }

        $options = array();
        foreach($this->lang->api->paramsTypeOptions as $key => $item)
        {
            $options[] = array('label' => $item, 'value' => $key);
        }
        $this->view->typeOptions = $options;
        $this->view->title       = $this->lang->api->createStruct;
        $this->view->gobackLink  = $this->createLink('api', 'struct', "libID=$libID");

        $this->display();
    }

    /**
     * Edit struct
     *
     * @param  int $libID
     * @param  int $structID
     * @access public
     * @return void
     */
    public function editStruct($libID, $structID)
    {
        common::setMenuVars('doc', $libID);
        $struct = $this->api->getStructByID($structID);

        if(!empty($_POST))
        {
            $changes = $this->api->updateStruct($structID);
            if(dao::isError()) return $this->sendError(dao::getError());
            $actionID = $this->action->create('apistruct', $structID, 'Edited');
            $this->action->logHistory($actionID, $changes);
            return $this->sendSuccess(array('locate' => helper::createLink('api', 'struct', "libID={$struct->lib}")));
        }

        $options = array();
        foreach($this->lang->api->paramsTypeOptions as $key => $item)
        {
            $options[] = array('label' => $item, 'value' => $key);
        }

        $this->view->struct      = $struct;
        $this->view->typeOptions = $options;
        $this->view->title       = $struct->name . $this->lang->api->edit;
        $this->display();
    }

    /**
     * Delete a struct.
     *
     * @param  int    $libID
     * @param  int    $structID
     * @param  string $confirm
     * @access public
     * @return void
     */
    public function deleteStruct($libID, $structID = 0, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->custom->notice->confirmDelete, $this->createLink('api', 'deleteStruct', "libID=$libID&structID=$structID&confirm=yes"), ''));
        }
        else
        {
            $this->api->delete(TABLE_APISTRUCT, $structID);
            if(dao::isError()) return $this->sendError(dao::getError());
            return print(js::locate(inlink('struct', "libID=$libID"), 'parent'));
        }
    }

    /**
     * Create a api doc library.
     *
     * @param  string $type project|product
     * @param  int    $objectID
     * @access public
     * @return void
     */
    public function createLib($type = 'product', $objectID = 0)
    {
        if(!in_array($type, array('product', 'project'))) $type = 'product';

        if(!empty($_POST))
        {
            $libID = $this->doc->createApiLib();
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            /* Record action for create api library. */
            $this->action->create('doclib', $libID, 'created');
            if(isonlybody()) return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'parent'));

            /* Set locate object data. */
            setCookie("objectType", $this->post->libType, $this->config->cookieLife, $this->config->webRoot);
            setCookie("objectID", $this->post->libType == 'project' ? $this->post->project : $this->post->product, $this->config->cookieLife, $this->config->webRoot);

            if(!helper::isAjaxRequest()) return print(js::locate($this->createLink('api', 'index', "libID=$libID"), 'parent.parent'));
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('api', 'index', "libID=$libID")));
        }

        $this->lang->api->aclList['default'] = sprintf($this->lang->api->aclList['default'], $this->lang->{$type}->common);

        $this->view->type     = $type;
        $this->view->objectID = $objectID;
        $this->view->groups   = $this->loadModel('group')->getPairs();
        $this->view->users    = $this->user->getPairs('nocode|noclosed');
        $this->view->projects = $this->loadModel('project')->getPairsByModel('scrum,waterfall,agileplus,waterfallplus');
        $this->view->products = $this->loadModel('product')->getPairs();

        $this->display();
    }

    /**
     * Edit an api doc library
     *
     * @param  int     $id
     * @access public
     * @return void
     */
    public function editLib($id)
    {
        if(!empty($_POST))
        {
            $this->doc->updateApiLib($id);

            if(dao::isError()) return $this->sendError(dao::getError());

            return $this->sendSuccess(array('message' => $this->lang->saveSuccess, 'closeModal' => true, 'callback' => "redirectParentWindow($id)"));
        }

        $lib  = $this->doc->getLibById($id);
        $type = 'nolink';
        if(!empty($lib->product))
        {
            $type = 'product';
            $this->view->object = $this->loadModel('product')->getByID($lib->product);
        }
        if(!empty($lib->project))
        {
            $type = 'project';
            $this->view->object = $this->loadModel('project')->getById($lib->project);
        }
        if($type != 'nolink') $this->lang->api->aclList['default'] = sprintf($this->lang->doclib->aclList['default'], $this->lang->{$type}->common);
        if($type == 'nolink') unset($this->lang->api->aclList['default']);

        $this->view->lib      = $lib;
        $this->view->type     = $type;
        $this->view->groups   = $this->loadModel('group')->getPairs();
        $this->view->users    = $this->user->getPairs('nocode|noclosed');
        $this->view->projects = $this->loadModel('project')->getPairsByModel();
        $this->view->products = $this->loadModel('product')->getPairs();

        $this->display();
    }


    /**
     * Delete api library.
     *
     * @param  int    $libID
     * @param  string $confirm
     * @access public
     * @return void
     */
    public function deleteLib($libID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->api->confirmDeleteLib, $this->createLink('api', 'deleteLib', "libID=$libID&confirm=yes")));
        }
        else
        {
            $this->doc->delete(TABLE_DOCLIB, $libID);
            if(isonlybody())
            {
                unset($_GET['onlybody']);
                return print(js::locate($this->createLink('api', 'index'), 'parent.parent'));
            }

            return print(js::locate($this->createLink('api', 'index'), 'parent'));
        }
    }

    /**
     * Edit library.
     *
     * @param  int     $apiID
     * @access public
     * @return void
     */
    public function edit($apiID)
    {
        if(helper::isAjaxRequest() && !empty($_POST))
        {
            $changes = $this->api->update($apiID);
            if(dao::isError()) return $this->sendError(dao::getError());

            if($changes)
            {
                $actionID = $this->action->create('api', $apiID, 'edited');
                $this->action->logHistory($actionID, $changes);
            }

            return $this->sendSuccess(array('locate' => helper::createLink('api', 'index', "libID=0&moduleID=0&apiID=$apiID")));
        }

        $api = $this->api->getLibById($apiID);
        if($api)
        {
            $this->view->api  = $api;
            $this->view->edit = true;
        }

        $this->setMenu($api->lib);

        $this->getTypeOptions($api->lib);

        $this->view->title            = $api->title . $this->lang->api->edit;
        $this->view->gobackLink       = $this->createLink('api', 'index', "libID={$api->lib}&moduleID={$api->module}&apiID=$apiID");
        $this->view->user             = $this->app->user->account;
        $this->view->allUsers         = $this->loadModel('user')->getPairs('devfirst|noclosed');;
        $this->view->moduleOptionMenu = $this->loadModel('tree')->getOptionMenu($api->lib, 'api', $startModuleID = 0);
        $this->view->moduleID         = $api->module ? (int)$api->module : (int)$this->cookie->lastDocModule;

        $this->display();
    }

    /**
     * Create an api doc.
     *
     * @param  int $libID
     * @param  int $moduleID
     * @access public
     * @return void
     */
    public function create($libID, $moduleID = 0)
    {
        if(!empty($_POST))
        {
            $api = $this->api->create();
            if($api === false) return $this->sendError(dao::getError());

            $this->action->create('api', $api->id, 'Created');

            if(isonlybody()) return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'parent'));
            return $this->sendSuccess(array('locate' => helper::createLink('api', 'index', "libID={$api->lib}&moduleID=0&apiID={$api->id}")));
        }

        $libs = $this->doc->getLibs('api', '', $libID);
        if(!$libID and !empty($libs)) $libID = key($libs);

        $this->setMenu($libID);

        $lib     = $this->doc->getLibByID($libID);
        $libName = isset($lib->name) ? $lib->name . $this->lang->colon : '';

        $this->getTypeOptions($libID);
        $this->view->gobackLink       = '';
        $this->view->user             = $this->app->user->account;
        $this->view->allUsers         = $this->loadModel('user')->getPairs('devfirst|noclosed');
        $this->view->libID            = $libID;
        $this->view->libName          = $lib->name;
        $this->view->moduleOptionMenu = $this->loadModel('tree')->getOptionMenu($libID, 'api', $startModuleID = 0);
        $this->view->moduleID         = $moduleID ? (int)$moduleID : (int)$this->cookie->lastDocModule;
        $this->view->libs             = $libs;
        $this->view->title            = $libName . $this->lang->api->create;
        $this->view->users            = $this->user->getPairs('nocode');

        $this->display();
    }

    /**
     * Delete an api.
     *
     * @param  int    $apiID
     * @param  string $confirm
     * @access public
     * @return void
     */
    public function delete($apiID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->api->confirmDelete, inlink('delete', "apiID=$apiID&confirm=yes")));
        }
        else
        {
            $api = $this->api->getLibById($apiID);
            $this->api->delete(TABLE_API, $apiID);

            if(dao::isError())
            {
                $this->sendError(dao::getError());
            }
            else
            {
                $this->sendSuccess(array('locate' => $this->createLink('api', 'index', "libID=$api->lib&module=$api->module")));
            }
        }
    }

    /**
     * AJAX: Get params type options by scope.
     *
     * @access public
     * @return void
     */
    public function ajaxGetParamsTypeOptions()
    {
        $options = array();
        foreach($this->lang->api->paramsTypeOptions as $key => $item)
        {
            $options[] = array('label' => $item, 'value' => $key);
        }
        $this->sendSuccess(array('data' => $options));
    }

    /**
     * AJAX: Get ref options.
     *
     * @param  int     $libID
     * @param  int     $structID
     * @access public
     * @return void
     */
    public function ajaxGetRefOptions($libID = 0, $structID = 0)
    {
        $res = $this->api->getStructListByLibID($libID);

        $options = array();
        foreach($res as $item)
        {
            if($item->id == $structID) continue;

            $options[$item->id] = $item->name;
        }

        echo html::select('refTarget', $options, '', "class='form-control'");
    }

    /**
     * AJAX: Get ref info.
     *
     * @param  int    $refID
     * @access public
     * @return void
     */
    public function ajaxGetRefInfo($refID = 0)
    {
        $info = $this->api->getStructByID($refID);
        $this->sendSuccess(array('info' => $info));
    }

    /**
     * AJAX: Get all child module.
     *
     * @param  int     $libID
     * @param  string  $type
     * @access public
     * @return void
     */
    public function ajaxGetChild($libID, $type = 'module')
    {
        $this->loadModel('tree');
        $childModules = $this->tree->getOptionMenu($libID, 'api');
        $select       = ($type == 'module') ? html::select('module', $childModules, '0', "class='form-control chosen'") : html::select('parent', $childModules, '0', "class='form-control chosen'");
        echo $select;
    }

    /**
     * Set doc menu by method name.
     *
     * @param  int    $libID
     * @param  int    $moduleID
     * @access public
     * @return void
     */
    private function setMenu($libID = 0, $moduleID = 0)
    {
        common::setMenuVars('doc', '');

        /* Global struct link. */
        $menu = '';

        if($libID and common::hasPriv('api', 'createRelease'))
        {
            $menu .= html::a(helper::createLink('api', 'createRelease', "libID=$libID"), $this->lang->api->createRelease, '', 'class="btn btn-link iframe"');
        }

        /* page of index menu. */
        if(common::hasPriv('api', 'create') or common::hasPriv('api', 'createLib'))
        {
            $menu .= "<div class='dropdown' id='createDropdown'>";
            $menu .= "<button class='btn btn-primary' type='button' data-toggle='dropdown'><i class='icon icon-plus'></i> " . $this->lang->api->createAB . " <span class='caret'></span></button>";
            $menu .= "<ul class='dropdown-menu pull-right'>";

            /* check has permission create api doc */
            if(intval($libID) > 0 and common::hasPriv('api', 'create'))
            {
                $menu .= "<li>";
                $menu .= html::a(helper::createLink('api', 'create', "libID=$libID&moduleID=$moduleID"), "<i class='icon-rich-text icon'></i> " . $this->lang->api->createApi, '', "data-app='{$this->app->tab}'");
                $menu .= "</li>";
            }

            /* check has permission create api doc lib */
            if(common::hasPriv('api', 'createLib'))
            {
                $menu .= '<li>' . html::a(helper::createLink('api', 'createLib'), "<i class='icon-doc-lib icon'></i> " . $this->lang->api->createLib, '', "class='iframe' data-width='70%'") . '</li>';

                $menu .= '<li class="divider"></li>';
                $menu .= '<li>' . html::a(helper::createLink('api', 'createLib', 'type=demo'), "<i class='icon-zentao icon'></i> " . $this->lang->api->createDemo, '', "class='iframe' data-width='70%'") . '</li>';
            }

            $menu .= "</ul></div>";
        }

        $this->lang->TRActions = $menu;
    }

    /**
     * Generate api doc index page dropMenu
     *
     * @param  object $lib
     * @param  int    $version
     * @access public
     * @return string
     */
    private function generateLibsDropMenu($lib, $version = 0)
    {
        if(empty($lib)) return '';

        $objectTitle = $this->lang->api->noLinked;
        $objectType  = 'nolink';
        $objectID    = 0;
        if($lib->product)
        {
            $objectType = 'product';
            $objectID   = $lib->product;
            $product    = $this->loadModel('product')->getByID($objectID);
            $objectTitle = zget($product, 'name', '');
        }
        elseif($lib->project)
        {
            $objectType  = 'project';
            $objectID    = $lib->project;
            $project     = $this->loadModel('project')->getByID($objectID);
            $objectTitle = zget($project, 'name', '');
        }

        $dropMenuLink = helper::createLink('api', 'ajaxGetDropMenu', "objectType=$objectType&objectID=$objectID&libID=$lib->id&version=$version");

        $output  = "<div class='btn-group selectBox' id='swapper'><button data-toggle='dropdown' type='button' class='btn' id='currentItem' title='{$objectTitle}'><span class='text'>{$objectTitle}</span> <span class='caret' style='margin-bottom: -1px'></span></button><div id='dropMenu' class='dropdown-menu search-list' data-ride='searchList' data-url='$dropMenuLink'>";
        $output .= '<div class="input-control search-box has-icon-left has-icon-right search-example"><input type="search" class="form-control search-input" /><label class="input-control-icon-left search-icon"><i class="icon icon-search"></i></label><a class="input-control-icon-right search-clear-btn"><i class="icon icon-close icon-sm"></i></a></div>';
        $output .= "</div></div>";
        return $output;
    }

    /**
     * Return session to the client.
     *
     * @access public
     * @return void
     */
    public function getSessionID()
    {
        $this->session->set('rand', mt_rand(0, 10000));
        $this->view->sessionName = session_name();
        $this->view->sessionID   = session_id();
        $this->view->rand        = $this->session->rand;
        $this->display();
    }

    /**
     * Execute a module's model's method, return the result.
     *
     * @param  string $moduleName
     * @param  string $methodName
     * @param  string $params param1=value1,param2=value2, don't use & to join them.
     * @access public
     * @return string
     */
    public function getModel($moduleName, $methodName, $params = '')
    {
        if(!$this->config->features->apiGetModel) return printf($this->lang->api->error->disabled, '$config->features->apiGetModel');

        $params    = explode(',', $params);
        $newParams = array_shift($params);
        foreach($params as $param)
        {
            $sign       = strpos($param, '=') !== false ? '&' : ',';
            $newParams .= $sign . $param;
        }

        parse_str($newParams, $params);
        $module = $this->loadModel($moduleName);
        $result = call_user_func_array(array(&$module, $methodName), $params);
        if(dao::isError()) return print(json_encode(dao::getError()));
        $output['status'] = $result ? 'success' : 'fail';
        $output['data']   = json_encode($result);
        $output['md5']    = md5($output['data']);
        $this->output     = json_encode($output);
        print($this->output);
    }

    /**
     * The interface of api.
     *
     * @param  int $filePath
     * @param  int $action
     * @access public
     * @return void
     */
    public function debug($filePath, $action)
    {
        $filePath    = helper::safe64Decode($filePath);
        $fileDirPath = realpath(dirname($filePath));
        if(strpos($fileDirPath, $this->app->getModuleRoot()) !== 0 and strpos($fileDirPath, $this->app->getExtensionRoot()) !== 0) return;
        if($action == 'extendModel')
        {
            $method = $this->api->getMethod($filePath, 'Model');
        }
        elseif($action == 'extendControl')
        {
            $method = $this->api->getMethod($filePath);
        }

        if(!empty($_POST))
        {
            $result  = $this->api->request($method->className, $method->methodName, $action);
            $content = json_decode($result['content']);
            $status  = zget($content, 'status', '');
            $data    = isset($content->data) ? json_decode($content->data) : '';
            $data    = '<xmp>' . print_r($data, true) . '</xmp>';

            $response['result'] = 'success';
            $response['status'] = $status;
            $response['url']    = $result['url'];
            $response['data']   = $data;
            return print(json_encode($response));
        }

        $this->view->method   = $method;
        $this->view->filePath = $filePath;
        $this->display();
    }

    /**
     * Query sql.
     *
     * @param  string $keyField
     * @access public
     * @return void
     */
    public function sql($keyField = '')
    {
        if(!$this->config->features->apiSQL) return printf($this->lang->api->error->disabled, '$config->features->apiSQL');

        $sql    = isset($_POST['sql']) ? $this->post->sql : '';
        $output = $this->api->sql($sql, $keyField);

        $output['sql'] = $sql;
        $this->output  = json_encode($output);
        print($this->output);
    }

    /**
     * Get options of type.
     *
     * @param  int   $libID
     * @access public
     * @return void
     */
    private function getTypeOptions($libID)
    {
        $options = array();
        foreach($this->lang->api->paramsTypeOptions as $key => $item)
        {
            $options[] = array('label' => $item, 'value' => $key);
        }

        /* Get all struct by libID. */
        $structs = $this->api->getStructListByLibID($libID);
        foreach($structs as $struct)
        {
            $options[] = array('label' => $struct->name, 'value' => $struct->id);
        }
        $this->view->typeOptions = $options;
    }

    /**
     * Ajax get objectType drop menu.
     *
     * @param  string $objectType
     * @param  int    $objectID
     * @param  string $module
     * @param  string $method
     * @access public
     * @return void
     */
    public function ajaxGetDropMenu($objectType, $objectID, $module, $method)
    {
        list($normalObjects, $closedObjects) = $this->api->getOrderedObjects();

        $titleList = array($this->lang->api->noLinked);
        if(!empty($normalObjects['product'])) $titleList += array_values($normalObjects['product']);
        if(!empty($normalObjects['project'])) $titleList += array_values($normalObjects['project']);
        if(!empty($closedObjects['product'])) $titleList += array_values($closedObjects['product']);
        if(!empty($closedObjects['project'])) $titleList += array_values($closedObjects['project']);

        $this->view->objectType    = $objectType;
        $this->view->objectID      = $objectID;
        $this->view->module        = $module;
        $this->view->method        = $method;
        $this->view->normalObjects = $normalObjects;
        $this->view->closedObjects = $closedObjects;
        $this->view->nolinkLibs    = $this->doc->getApiLibs(0, 'nolink');
        $this->view->objectsPinYin = common::convert2Pinyin($titleList);

        $this->display();
    }
}
