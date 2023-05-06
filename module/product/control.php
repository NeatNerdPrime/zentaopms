<?php
/**
 * The control file of product module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id: control.php 5144 2013-07-15 06:37:03Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
class product extends control
{
    public $products = array();

    /**
     * Construct function.
     *
     * @param  string moduleName
     * @param  string methodName
     * @access public
     * @return void
     */
    public function __construct(string $moduleName = '', string $methodName = '')
    {
        parent::__construct($moduleName, $methodName);

        if(!isset($this->app->user)) return;

        /* Load need modules. */
        $this->loadModel('story');
        $this->loadModel('release');
        $this->loadModel('tree');
        $this->loadModel('user');

        /* Get all products, if no, goto the create page. */
        $this->products = $this->product->getPairs('nocode', 0, '', 'all');
        if($this->product->checkLocateCreate($this->products)) $this->locate($this->createLink('product', 'create'));

        $this->view->products = $this->products;
    }

    /**
     * Index page, to browse.
     *
     * @param  string $locate     locate to browse page or not. If not, display all products.
     * @param  int    $productID
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function index($locate = 'auto', $productID = 0, $status = 'noclosed', $orderBy = 'order_desc', $recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        if($locate == 'yes') $this->locate($this->createLink($this->moduleName, 'browse'));

        if($this->app->getViewType() != 'mhtml') unset($this->lang->product->menu->index);
        $productID = $this->productZen->saveVisitState($productID, $this->products);
        $branch    = (int)$this->cookie->preBranch;

        if($this->app->viewType == 'mhtml') $this->productZen->setMenu($productID, $branch);

        if(common::hasPriv('product', 'create')) $this->lang->TRActions = html::a($this->createLink('product', 'create'), "<i class='icon icon-sm icon-plus'></i> " . $this->lang->product->create, '', "class='btn btn-primary'");

        $this->view->title      = $this->lang->product->index;
        $this->view->position[] = $this->lang->product->index;
        $this->display();
    }

    /**
     * The projects which linked the product.
     *
     * @param  string $status
     * @param  string $productID
     * @param  string $branch
     * @param  string $involved
     * @param  string $orderBy
     * @param  string $recTotal
     * @param  string $recPerPage
     * @param  string $pageID
     * @access public
     * @return void
     */
    public function project(string $status = 'all', string $productID = '0', string $branch = '', string $involved = '0', string $orderBy = 'order_desc', string $recTotal = '0', string $recPerPage = '20', string $pageID = '1')
    {
        $productID = (int)$productID;
        $involved  = ($this->cookie->involved or $involved);
        $this->productZen->setProjectMenu($productID, $branch, $this->cookie->preBranch);

        /* Load pager. */
        $this->app->loadClass('pager', true);
        $pager = new pager((int)$recTotal, (int)$recPerPage, (int)$pageID);

        /* Set view variables and display. */
        $this->productZen->displayProjectPage($productID, $branch, $status, $involved, $orderBy, $pager);
    }

    /**
     * 产品研发需求列表。
     * Browse requirements list of product.
     *
     * @param  int         $productID
     * @param  int|stirng  $branch
     * @param  string      $browseType
     * @param  int         $param
     * @param  string      $storyType requirement|story
     * @param  string      $orderBy
     * @param  int         $recTotal
     * @param  int         $recPerPage
     * @param  int         $pageID
     * @param  int         $projectID
     * @access public
     * @return void
     */
    public function browse(string $productID = '0', string $branch = '', string $browseType = '', string $param = '0', string $storyType = 'story', string $orderBy = '', string $recTotal = '0', string $recPerPage = '20', $pageID = '1', $projectID = '0')
    {
        $productID  = (int)$productID;
        $param      = (int)$param;
        $recTotal   = (int)$recTotal;
        $recPerPage = (int)$recPerPage;
        $pageID     = (int)$pageID;
        $projectID  = (int)$projectID;

        $productID = $this->app->tab != 'project' ? $this->saveVisitState($productID, $this->products) : $productID;
        $product   = $this->product->getById($productID);

        if($product && !isset($this->products[$product->id])) $this->products[$product->id] = $product->name;

        if($product and $product->type != 'normal')
        {
            $branchPairs = $this->loadModel('branch')->getPairs($productID, 'all');
            $branch      = ($this->cookie->preBranch !== '' and $branch === '' and isset($branchPairs[$this->cookie->preBranch])) ? $this->cookie->preBranch : $branch;
            $branchID    = $branch;
        }
        else
        {
            $branchID = $branch = 'all';
        }

        /* Set menu. */
        if($this->app->tab == 'project')
        {
            $this->session->set('storyList', $this->app->getURI(true), 'project');
            $this->loadModel('project')->setMenu($projectID);
        }
        else
        {
            $this->session->set('storyList',   $this->app->getURI(true), 'product');
            $this->session->set('productList', $this->app->getURI(true), 'product');

            $this->productZen->setMenu($productID, $branch, 0, '', "storyType=$storyType");
        }

        /* Lower browse type. */
        $browseType = strtolower($browseType);

        /* Load datatable and execution. */
        $this->loadModel('datatable');
        $this->loadModel('execution');

        /* Set product, module and query. */
        setcookie('preProductID', $productID, $this->config->cookieLife, $this->config->webRoot, '', $this->config->cookieSecure, true);
        setcookie('preBranch', $branch, $this->config->cookieLife, $this->config->webRoot, '', $this->config->cookieSecure, true);

        if($this->cookie->preProductID != $productID or $this->cookie->preBranch != $branch or $browseType == 'bybranch')
        {
            $_COOKIE['storyModule'] = 0;
            setcookie('storyModule', 0, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
        }

        if($browseType == 'bymodule' or $browseType == '')
        {
            setcookie('storyModule', (int)$param, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
            if($this->app->tab == 'project') setcookie('storyModuleParam', (int)$param, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
            $_COOKIE['storyBranch'] = 'all';
            setcookie('storyBranch', 'all', 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
            if($browseType == '') setcookie('treeBranch', $branch, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
        }
        if($browseType == 'bybranch') setcookie('storyBranch', $branch, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);

        $cookieModule = $this->app->tab == 'project' ? $this->cookie->storyModuleParam : $this->cookie->storyModule;

        $moduleID = 0;
        if($browseType == 'bymodule') $moduleID = (int)$param;
        elseif($browseType != 'bysearch' and $browseType != 'bybranch' and $cookieModule) $moduleID = $cookieModule;

        $queryID = ($browseType == 'bysearch') ? (int)$param : 0;

        /* Set moduleTree. */
        $createModuleLink = $storyType == 'story' ? 'createStoryLink' : 'createRequirementLink';
        if($browseType == '')
        {
            setcookie('treeBranch', $branch, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
            $browseType = 'unclosed';
        }
        else
        {
            $branch = $this->cookie->treeBranch;
        }

        $isProjectStory = $this->app->rawModule == 'projectstory';

        /* If in project story and not chose product, get project story mdoules. */
        if($isProjectStory and empty($productID))
        {
            $moduleTree = $this->tree->getProjectStoryTreeMenu($projectID, 0, array('treeModel', $createModuleLink));
        }
        else
        {
            $moduleTree = $this->tree->getTreeMenu($productID, 'story', $startModuleID = 0, array('treeModel', $createModuleLink), array('projectID' => $projectID, 'productID' => $productID), $branch, "&param=$param&storyType=$storyType");
        }

        if($browseType != 'bymodule' and $browseType != 'bybranch') $this->session->set('storyBrowseType', $browseType);
        if(($browseType == 'bymodule' or $browseType == 'bybranch') and $this->session->storyBrowseType == 'bysearch') $this->session->set('storyBrowseType', 'unclosed');

        /* Process the order by field. */
        if(!$orderBy) $orderBy = $this->cookie->productStoryOrder ? $this->cookie->productStoryOrder : 'id_desc';
        setcookie('productStoryOrder', $orderBy, 0, $this->config->webRoot, '', $this->config->cookieSecure, true);

        /* Append id for secend sort. */
        $sort = common::appendOrder($orderBy);
        if(strpos($sort, 'pri_') !== false) $sort = str_replace('pri_', 'priOrder_', $sort);

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        if($this->app->getViewType() == 'xhtml') $recPerPage = 10;
        $pager = new pager($recTotal, $recPerPage, $pageID);

        /* Display of branch label. */
        $showBranch = $this->loadModel('branch')->showBranch($productID);

        /* Get stories. */
        $projectProducts = array();
        if($isProjectStory and $storyType == 'story')
        {
            $showBranch = $this->loadModel('branch')->showBranch($productID, 0, $projectID);

            if(!empty($product)) $this->session->set('currentProductType', $product->type);

            $this->products  = $this->product->getProducts($projectID, 'all', '', false);
            $projectProducts = $this->product->getProducts($projectID);
            $productPlans    = $this->execution->getPlans($projectProducts, 'skipParent,unexpired,noclosed', $projectID);

            if($browseType == 'bybranch') $param = $branchID;
            $stories = $this->story->getExecutionStories($projectID, $productID, $branchID, $sort, $browseType, $param, $storyType, '', $pager);
        }
        else
        {
            $stories = $this->product->getStories($productID, $branchID, $browseType, $queryID, $moduleID, $storyType, $sort, $pager);
        }
        $queryCondition = $this->story->dao->get();

        /* Display status of branch. */
        $branchOption    = array();
        $branchTagOption = array();
        if(!$product and $isProjectStory)
        {
            /* Get branch display under multiple products. */
            $branchOptions = array();
            foreach($projectProducts as $projectProduct)
            {
                if($projectProduct and $projectProduct->type != 'normal')
                {
                    $branches = $this->loadModel('branch')->getList($projectProduct->id, $projectID, 'all');
                    foreach($branches as $branchInfo) $branchOptions[$projectProduct->id][$branchInfo->id] = $branchInfo->name;
                }
            }

            $this->view->branchOptions = $branchOptions;
        }
        else
        {
            if($product and $product->type != 'normal')
            {
                $branches = $this->loadModel('branch')->getList($productID, $projectID, 'all');
                foreach($branches as $branchInfo)
                {
                    $branchOption[$branchInfo->id]    = $branchInfo->name;
                    $branchTagOption[$branchInfo->id] = $branchInfo->name . ($branchInfo->status == 'closed' ? ' (' . $this->lang->branch->statusList['closed'] . ')' : '');
                }
            }
        }

        /* Process the sql, get the conditon partion, save it to session. */
        $this->loadModel('common')->saveQueryCondition($queryCondition, 'story', (strpos('bysearch,reviewbyme,bymodule', $browseType) === false and !$isProjectStory));

        if(!empty($stories)) $stories = $this->story->mergeReviewer($stories);

        /* Get related tasks, bugs, cases count of each story. */
        $storyIdList = array();
        foreach($stories as $story)
        {
            $storyIdList[$story->id] = $story->id;
            if(!empty($story->children))
            {
                foreach($story->children as $child) $storyIdList[$child->id] = $child->id;
            }
        }
        $storyTasks = $this->loadModel('task')->getStoryTaskCounts($storyIdList);
        $storyBugs  = $this->loadModel('bug')->getStoryBugCounts($storyIdList);
        $storyCases = $this->loadModel('testcase')->getStoryCaseCounts($storyIdList);

        /* Change for requirement story title. */
        if($storyType == 'requirement')
        {
            $this->lang->story->title  = str_replace($this->lang->SRCommon, $this->lang->URCommon, $this->lang->story->title);
            $this->lang->story->create = str_replace($this->lang->SRCommon, $this->lang->URCommon, $this->lang->story->create);
            $this->config->product->search['fields']['title'] = $this->lang->story->title;
            unset($this->config->product->search['fields']['plan']);
            unset($this->config->product->search['fields']['stage']);
        }

        $project = $this->loadModel('project')->getByID($projectID);
        if(isset($project->hasProduct) && empty($project->hasProduct))
        {
            if($isProjectStory && !$productID && !empty($this->products)) $productID = key($this->products);    // If toggle a project by the #swapper component on the story page of the projectstory module, the $productID may be empty. Make sure it has value.
            unset($this->config->product->search['fields']['product']);                                         // The none-product project don't need display the product in the search form.
            if($project->model != 'scrum') unset($this->config->product->search['fields']['plan']);             // The none-product and none-scrum project don't need display the plan in the search form.
        }

        /* Build search form. */
        $params    = $isProjectStory ? "projectID=$projectID&" : '';
        $actionURL = $this->createLink($this->app->rawModule, $this->app->rawMethod, $params . "productID=$productID&branch=$branch&browseType=bySearch&queryID=myQueryID&storyType=$storyType");

        $this->config->product->search['onMenuBar'] = 'yes';
        $this->product->buildSearchForm($productID, $this->products, $queryID, $actionURL, $branch, $projectID);

        $showModule = !empty($this->config->datatable->productBrowse->showModule) ? $this->config->datatable->productBrowse->showModule : '';

        $productName = ($isProjectStory and empty($productID)) ? $this->lang->product->all : $this->products[$productID];

        /* Assign. */
        $this->view->title           = $productName . $this->lang->colon . ($storyType === 'story' ? $this->lang->product->browse : $this->lang->product->requirement);
        $this->view->position[]      = $productName;
        $this->view->position[]      = $this->lang->product->browse;
        $this->view->productID       = $productID;
        $this->view->product         = $product;
        $this->view->productName     = $productName;
        $this->view->moduleID        = $moduleID;
        $this->view->stories         = $stories;
        $this->view->plans           = $this->loadModel('productplan')->getPairs($productID, ($branch === 'all' or empty($branch)) ? '' : $branch, 'unexpired,noclosed', true);
        $this->view->productPlans    = isset($productPlans) ? array(0 => '') + $productPlans : array();
        $this->view->summary         = $this->product->summary($stories, $storyType);
        $this->view->moduleTree      = $moduleTree;
        $this->view->parentModules   = $this->tree->getParents($moduleID);
        $this->view->pager           = $pager;
        $this->view->users           = $this->user->getPairs('noletter|pofirst|nodeleted');
        $this->view->orderBy         = $orderBy;
        $this->view->browseType      = $browseType;
        $this->view->modules         = $this->tree->getOptionMenu($productID, 'story', 0, $branchID);
        $this->view->moduleID        = $moduleID;
        $this->view->moduleName      = ($moduleID and $moduleID !== 'all') ? $this->tree->getById($moduleID)->name : $this->lang->tree->all;
        $this->view->branch          = $branch;
        $this->view->branchID        = $branchID;
        $this->view->branchOption    = $branchOption;
        $this->view->branchTagOption = $branchTagOption;
        $this->view->showBranch      = $showBranch;
        $this->view->storyStages     = $this->product->batchGetStoryStage($stories);
        $this->view->setModule       = true;
        $this->view->storyTasks      = $storyTasks;
        $this->view->storyBugs       = $storyBugs;
        $this->view->storyCases      = $storyCases;
        $this->view->param           = $param;
        $this->view->projectID       = $projectID;
        $this->view->products        = $this->products;
        $this->view->projectProducts = isset($projectProducts) ? $projectProducts : array();
        $this->view->storyType       = $storyType;
        $this->view->from            = $this->app->tab;
        $this->view->modulePairs     = $showModule ? $this->tree->getModulePairs($productID, 'story', $showModule) : array();
        $this->view->project         = $project;
        $this->view->recTotal        = $pager->recTotal;

        $this->render();
    }

    /**
     * Create a product.
     * 创建产品。可以是顶级产品，也可以是项目集下的产品。
     *
     * @param  string $programID
     * @param  string $extra
     * @access public
     * @return void
     */
    public function create(string $programID = '0', string $extra = '')
    {
        $programID = (int)$programID;

        if(!empty($_POST))
        {
            $formConfig = $this->productZen->appendFlowFields($this->config->product->form->create);
            $data       = form::data($formConfig);
            $product    = $this->productZen->prepareCreateExtras($data, $this->post->acl, $this->post->uid);

            $productID = $this->product->create($product, $this->post->uid, zget($_POST, 'lineName', ''));
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $response = $this->productZen->responseAfterCreate($productID, (int)$product->program);
            $this->send($response);
        }

        $this->productZen->setCreateMenu($programID);
        $this->productZen->buildCreateForm($programID, $extra);
    }

    /**
     * Edit a product.
     *
     * @param  int       $productID
     * @param  string    $action
     * @param  string    $extra
     * @param  int       $programID
     * @access public
     * @return void
     */
    public function edit(string $productID, string $action = 'edit', string $extra = '', string $programID = '0')
    {
        $productID = (int)$productID;
        $programID = (int)$programID;

        if(!empty($_POST))
        {
            $formConfig = $this->productZen->appendFlowFields($this->config->product->form->edit);
            $data       = form::data($formConfig);
            $product    = $this->productZen->prepareEditExtras($data, $this->post->acl, $this->post->uid);

            $changes = $this->product->update($productID, $product, $this->post->uid);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($action == 'undelete') $this->loadModel('action')->undelete((int)$extra);
            $response = $this->productZen->responseAfterEdit($productID, $programID, $changes);
            $this->send($response);
        }

        $this->productZen->setEditMenu($productID, $programID);

        $product   = $this->product->getByID($productID);
        $productID = $this->productZen->saveVisitState($productID, $this->products);

        $this->productZen->buildEditForm($product);
    }

    /**
     * 根据POST过来的ID列表，批量编辑相应产品。
     * Batch edit products.
     *
     * @param  string    $programID
     * @access public
     * @return void
     */
    public function batchEdit(string $programID = '0')
    {
        $programID = (int)$programID;

        $_POST['productIdList'][1] = 1;
        $_POST['name'][1]   = '公司企业网站建设';
        $_POST['PO'][1]     = 'productManager';
        $_POST['QD'][1]     = 'testManager';
        $_POST['RD'][1]     = 'productManager';
        $_POST['type'][1]   =  'normal';
        $_POST['status'][1] =  'normal';
        $_POST['desc'][1]   = '建立公司企业网站，可以更好对外展示。<br />';
        $_POST['acl'][1]    = 'open';

        if($this->post->name)
        {
            $formConfig = $this->productZen->appendFlowFields($this->config->product->form->batchEdit, 'batch');
            $data       = form::data($formConfig);
            $products   = $this->productZen->prepareBatchEditExtras($data);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $allChanges = $this->product->batchUpdate($products);


            if(!empty($allChanges))
            {
                foreach($allChanges as $productID => $changes)
                {
                    if(empty($changes)) continue;

                    $actionID = $this->loadModel('action')->create('product', $productID, 'Edited');
                    $this->action->logHistory($actionID, $changes);
                }
            }

            $locate = $this->app->tab == 'product' ? $this->createLink('product', 'all') : $this->createLink('program', 'product', "programID=$programID");
            return print(js::locate($locate, 'parent'));
        }

        /* 获取要修改的产品ID列表。*/
        $productIdList = $this->post->productIDList;
        $productIdList = '79,40,68';
        if(empty($productIdList)) return print(js::locate($this->session->productList, 'parent'));

        /* Set menu when page come from program. */
        if($this->app->tab == 'program') $this->loadModel('program')->setMenu(0);

        /* 构造批量编辑页面表单配置数据。*/
        $this->productZen->buildBatchEditForm($programID, explode(',', $productIdList));
    }

    /**
     * Close product.
     *
     * @param  int    $productID
     * @access public
     * @return void
     */
    public function close($productID)
    {
        $product = $this->product->getById($productID);
        $actions = $this->loadModel('action')->getList('product', $productID);

        if(!empty($_POST))
        {
            $changes = $this->product->close($productID);
            if(dao::isError()) return print(js::error(dao::getError()));

            if($this->post->comment != '' or !empty($changes))
            {
                $actionID = $this->action->create('product', $productID, 'Closed', $this->post->comment);
                $this->action->logHistory($actionID, $changes);
            }

            $this->executeHooks($productID);

            return print(js::reload('parent.parent'));
        }

        $this->productZen->setMenu($productID);

        $this->view->product    = $product;
        $this->view->title      = $this->view->product->name . $this->lang->colon .$this->lang->close;
        $this->view->position[] = $this->lang->close;
        $this->view->actions    = $actions;
        $this->view->users      = $this->loadModel('user')->getPairs('noletter');
        $this->display();
    }

    /**
     * View a product.
     *
     * @param  int    $productID
     * @access public
     * @return void
     */
    public function view($productID)
    {
        $productID = (int)$productID;
        $product   = $this->product->getStatByID($productID);

        if(!$product)
        {
            if(defined('RUN_MODE') && RUN_MODE == 'api') return $this->send(array('status' => 'fail', 'code' => 404, 'message' => '404 Not found'));
            return print(js::error($this->lang->notFound) . js::locate($this->createLink('product', 'index')));
        }

        $product->desc = $this->loadModel('file')->setImgSize($product->desc);
        $this->productZen->setMenu($productID);

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, 30, 1);

        $this->executeHooks($productID);

        $this->view->title      = $product->name . $this->lang->colon . $this->lang->product->view;
        $this->view->position[] = html::a($this->createLink($this->moduleName, 'browse'), $product->name);
        $this->view->position[] = $this->lang->product->view;

        $this->view->product    = $product;
        $this->view->actions    = $this->loadModel('action')->getList('product', $productID);
        $this->view->users      = $this->user->getPairs('noletter');
        $this->view->groups     = $this->loadModel('group')->getPairs();
        $this->view->branches   = $this->loadModel('branch')->getPairs($productID);
        $this->view->reviewers  = explode(',', $product->reviewer);

        $this->display();
    }

    /**
     * Delete a product.
     *
     * @param  int    $productID
     * @param  string $confirm    yes|no
     * @access public
     * @return void
     */
    public function delete($productID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->product->confirmDelete, $this->createLink('product', 'delete', "productID=$productID&confirm=yes")));
        }
        else
        {
            $this->product->delete(TABLE_PRODUCT, $productID);
            $this->dao->update(TABLE_DOCLIB)->set('deleted')->eq(1)->where('product')->eq($productID)->exec();
            $this->session->set('product', '');
            $message = $this->executeHooks($productID);
            if($message) $this->lang->saveSuccess = $message;

            if($this->viewType == 'json') return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
            return print(js::locate($this->createLink('product', 'all'), 'parent'));
        }
    }

    /**
     * Road map of a product.
     *
     * @param  int        $productID
     * @param  int|string $branch
     * @access public
     * @return void
     */
    public function roadmap($productID, $branch = 'all')
    {
        $this->productZen->setMenu($productID, $branch);

        $this->session->set('releaseList',     $this->app->getURI(true), 'product');
        $this->session->set('productPlanList', $this->app->getURI(true), 'product');

        $product = $this->dao->findById($productID)->from(TABLE_PRODUCT)->fetch();
        if(empty($product)) $this->locate($this->createLink('product', 'showErrorNone', 'fromModule=product'));

        $this->view->title      = $product->name . $this->lang->colon . $this->lang->product->roadmap;
        $this->view->position[] = html::a($this->createLink($this->moduleName, 'browse'), $product->name);
        $this->view->position[] = $this->lang->product->roadmap;
        $this->view->product    = $product;
        $this->view->roadmaps   = $this->product->getRoadmap($productID, $branch);
        $this->view->branches   = $product->type == 'normal' ? array(0 => '') : $this->loadModel('branch')->getPairs($productID);

        $this->display();
    }

    /**
     * Product dynamic.
     *
     * @param  int    $productID
     * @param  string $type
     * @param  string $param
     * @param  int    $recTotal
     * @param  string $date
     * @param  string $direction    next|pre
     * @access public
     * @return void
     */
    public function dynamic($productID = 0, $type = 'today', $param = '', $recTotal = 0, $date = '', $direction = 'next')
    {
        /* Save session. */
        $uri = $this->app->getURI(true);
        $this->session->set('productList',     $uri, 'product');
        $this->session->set('productPlanList', $uri, 'product');
        $this->session->set('releaseList',     $uri, 'product');
        $this->session->set('storyList',       $uri, 'product');
        $this->session->set('projectList',     $uri, 'project');
        $this->session->set('executionList',   $uri, 'execution');
        $this->session->set('taskList',        $uri, 'execution');
        $this->session->set('buildList',       $uri, 'execution');
        $this->session->set('bugList',         $uri, 'qa');
        $this->session->set('caseList',        $uri, 'qa');
        $this->session->set('testtaskList',    $uri, 'qa');

        $this->productZen->setMenu($productID, 0, 0, '', $type);

        /* Append id for secend sort. */
        $orderBy = $direction == 'next' ? 'date_desc' : 'date_asc';

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage = 50, $pageID = 1);

        /* Set the user and type. */
        $account = 'all';
        if($type == 'account')
        {
            $user = $this->loadModel('user')->getById((int)$param, 'id');
            if($user) $account = $user->account;
        }
        $period  = $type == 'account' ? 'all'  : $type;
        $date    = empty($date) ? '' : date('Y-m-d', $date);
        $actions = $this->loadModel('action')->getDynamic($account, $period, $orderBy, $pager, $productID, 'all', 'all', $date, $direction);
        if(empty($recTotal)) $recTotal = count($actions);

        /* The header and position. */
        $this->view->title      = $this->products[$productID] . $this->lang->colon . $this->lang->product->dynamic;
        $this->view->position[] = html::a($this->createLink($this->moduleName, 'browse'), $this->products[$productID]);
        $this->view->position[] = $this->lang->product->dynamic;

        $this->view->userIdPairs  = $this->loadModel('user')->getPairs('noletter|nodeleted|noclosed|useid');
        $this->view->accountPairs = $this->user->getPairs('noletter|nodeleted|noclosed');

        /* Assign. */
        $this->view->productID  = $productID;
        $this->view->type       = $type;
        $this->view->orderBy    = $orderBy;
        $this->view->account    = $account;
        $this->view->user       = isset($user) ? $user : '';
        $this->view->param      = $param;
        $this->view->pager      = $pager;
        $this->view->dateGroups = $this->action->buildDateGroup($actions, $direction, $type);
        $this->view->direction  = $direction;
        $this->view->recTotal   = $recTotal;
        $this->display();
    }

    /**
     * Product dashboard.
     *
     * @param  int    $productID
     * @access public
     * @return void
     */
    public function dashboard($productID = 0)
    {
        $uri = $this->app->getURI(true);
        $this->session->set('productPlanList', $uri, 'product');
        $this->session->set('releaseList',     $uri, 'product');

        $productID = $this->productZen->saveVisitState($productID, $this->products);
        $product   = $this->product->getStatByID($productID);
        if(!$product) return print(js::locate('product', 'all'));

        $product->desc = $this->loadModel('file')->setImgSize($product->desc);
        $this->productZen->setMenu($productID);

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, 30, 1);

        $this->view->title      = $product->name . $this->lang->colon . $this->lang->product->view;
        $this->view->position[] = html::a($this->createLink($this->moduleName, 'browse'), $product->name);
        $this->view->position[] = $this->lang->product->view;

        $this->view->product  = $product;
        $this->view->actions  = $this->loadModel('action')->getList('product', $productID);
        $this->view->users    = $this->user->getPairs('noletter');
        $this->view->lines    = array('') + $this->product->getLinePairs();
        $this->view->dynamics = $this->action->getDynamic('all', 'all', 'date_desc', $pager, $productID);
        $this->view->roadmaps = $this->product->getRoadmap($productID, 0, 6);

        $this->display();
    }

    /**
     * Update order.
     *
     * @access public
     * @return void
     */
    public function updateOrder()
    {
        /* Init vars. */
        $idList  = explode(',', trim($this->post->products, ','));
        $orderBy = $this->post->orderBy;
        if(strpos($orderBy, 'program') === false) return false;

        /* Remove programID. */
        foreach($idList as $i => $id)
        {
            if(!is_numeric($id)) unset($idList[$i]);
        }

        /* Update order. */
        $products = $this->dao->select('t1.`order`, t1.id')->from(TABLE_PRODUCT)->alias('t1')
            ->leftJoin(TABLE_PROGRAM)->alias('t2')->on('t1.program = t2.id')
            ->where('t1.id')->in($idList)
            ->orderBy('t2.order_asc, t1.line_desc, t1.order_asc')
            ->fetchPairs('order', 'id');

        foreach($products as $order => $id)
        {
            $newID = array_shift($idList);
            if($id == $newID) continue;
            $this->dao->update(TABLE_PRODUCT)->set('`order`')->eq($order)->where('id')->eq($newID)->exec();
        }
    }

    /**
     * 访问与测试相关模块或方法时，又没有相关产品，或者没有产品，会跳转到该方法。例如：qa。
     * Show error no product when visit qa.
     *
     * @param  string $moduleName   project|qa|execution
     * @param  string $activeMenu
     * @param  string $objectID     The format of this parameter should be integer.
     * @access public
     * @return void
     */
    public function showErrorNone(string $moduleName = 'qa', string $activeMenu = 'index', string $objectID = ''): void
    {
        $objectID = (int)$objectID;
        $this->productZen->setShowErrorNoneMenu($moduleName, $activeMenu, $objectID);

        $this->view->title    = $this->lang->$moduleName->common;
        $this->view->objectID = $objectID;
        $this->display();
    }

    /**
     * Products under project set.
     *
     * @param  string $browseType
     * @param  string $orderBy
     * @param  int    $param
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @param  int    $programID
     * @access public
     * @return void
     */
    public function all(string $browseType = 'noclosed', string $orderBy = 'program_asc', string $param = '0', string $recTotal = '0', string $recPerPage = '20', string $pageID = '1', string $programID = '0')
    {
        /* Convert string to int. */
        $param      = (int)$param;
        $recTotal   = (int)$recTotal;
        $recPerPage = (int)$recPerPage;
        $pageID     = (int)$pageID;
        $programID  = (int)$programID;

        /* Set env data. */
        $this->productZen->setEnvAll();

        /* Generate statistics of products and program. */
        $this->app->loadClass('pager', true);
        $pager   = new pager($recTotal, $recPerPage, $pageID);
        $queryID = ($browseType == 'bySearch' or !empty($param)) ? $param : 0;
        if($this->config->systemMode == 'light' and $orderBy == 'program_asc') $orderBy = 'order_asc';

        $productStats     = $this->product->getStats($orderBy, $pager, $browseType, 0, 'story', 0, $queryID);
        $productStructure = $this->productZen->statisticProgram($productStats);

        /* Save search form. */
        $actionURL = $this->createLink('product', 'all', "browseType=bySearch&orderBy=order_asc&queryID=myQueryID");
        $this->product->buildProductSearchForm($param, $actionURL);

        /* Get product lines. */
        list($productLines, $programLines) = $this->productZen->getProductLines();

        $this->view->title            = $this->lang->productCommon;
        $this->view->position[]       = $this->lang->productCommon;
        $this->view->recTotal         = $pager->recTotal;
        $this->view->productStats     = $productStats;
        $this->view->productStructure = $productStructure;
        $this->view->productLines     = $productLines;
        $this->view->programLines     = $programLines;
        $this->view->users            = $this->user->getPairs('noletter');
        $this->view->userIdPairs      = $this->user->getPairs('noletter|showid');
        $this->view->usersAvatar      = $this->user->getAvatarPairs('');
        $this->view->orderBy          = $orderBy;
        $this->view->browseType       = $browseType;
        $this->view->pager            = $pager;
        $this->view->showBatchEdit    = $this->cookie->showProductBatchEdit;
        $this->view->param            = $param;
        $this->view->recPerPage       = $recPerPage;
        $this->view->pageID           = $pageID;
        $this->view->programID        = $programID;

        $this->display();
    }

    /**
     * Product kanban.
     *
     * @access public
     * @return void
     */
    public function kanban()
    {
        $this->session->set('projectList', $this->app->getURI(true), 'project');
        $this->session->set('productPlanList', $this->app->getURI(true), 'product');
        $this->session->set('releaseList', $this->app->getURI(true), 'product');

        $kanbanGroup = $this->product->getStats4Kanban();
        extract($kanbanGroup);

        $programPairs  = $this->loadModel('program')->getPairs(true);
        $myProducts    = array();
        $otherProducts = array();
        foreach($productList as $productID => $product)
        {
            if($product->status != 'normal') continue;
            if($product->PO == $this->app->user->account) $myProducts[$product->program][] = $productID;
            else $otherProducts[$product->program][] = $productID;
        }

        $kanbanList = array();
        if(!empty($myProducts))    $kanbanList['my']    = $myProducts;
        if(!empty($otherProducts)) $kanbanList['other'] = $otherProducts;

        $emptyHour = new stdclass();
        $emptyHour->totalEstimate = 0;
        $emptyHour->totalConsumed = 0;
        $emptyHour->totalLeft     = 0;
        $emptyHour->progress      = 0;

        $this->view->title            = $this->lang->product->kanban;
        $this->view->kanbanList       = $kanbanList;
        $this->view->programList      = array(0 => $this->lang->product->emptyProgram) + $programPairs;
        $this->view->productList      = $productList;
        $this->view->planList         = $planList;
        $this->view->projectList      = $projectList;
        $this->view->projectProduct   = $projectProduct;
        $this->view->latestExecutions = $projectLatestExecutions;
        $this->view->executionList    = $executionList;
        $this->view->hourList         = $hourList;
        $this->view->emptyHour        = $emptyHour;
        $this->view->releaseList      = $releaseList;

        $this->display();
    }

    /**
     * Manage product line.
     *
     * @access public
     * @return void
     */
    public function manageLine()
    {
        $this->app->loadLang('tree');
        if($_POST)
        {
            $this->product->manageLine();
            if(dao::isError()) return print(js::error(dao::getError()));
            return print(js::reload('parent'));
        }

        $this->view->title      = $this->lang->product->line;
        $this->view->position[] = $this->lang->product->line;

        $this->view->programs = array('') + $this->loadModel('program')->getTopPairs('', 'withDeleted');
        $this->view->lines    = $this->product->getLines();
        $this->display();
    }

    /**
     * Get white list personnel.
     *
     * @param  int    $productID
     * @param  string $module
     * @param  string $objectType
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function whitelist($productID = 0, $module = 'product', $objectType = 'product', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->productZen->setMenu($productID, 0);
        $this->lang->modulePageNav = '';

        echo $this->fetch('personnel', 'whitelist', "objectID=$productID&module=product&browseType=$objectType&orderBy=$orderBy&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID");
    }

    /**
     * Adding users to the white list.
     *
     * @param  int     $productID
     * @param  int     $deptID
     * @param  int     $copyID
     * @param  string  $branch
     * @access public
     * @return void
     */
    public function addWhitelist($productID = 0, $deptID = 0, $copyID = 0)
    {
        $this->productZen->setMenu($productID);
        $this->lang->modulePageNav = '';

        echo $this->fetch('personnel', 'addWhitelist', "objectID=$productID&dept=$deptID&copyID=$copyID&objectType=product&module=product");
    }

    /*
     * Removing users from the white list.
     *
     * @param  int     $id
     * @param  string  $confirm
     * @access public
     * @return void
     */
    public function unbindWhitelist($id = 0, $confirm = 'no')
    {
        echo $this->fetch('personnel', 'unbindWhitelist', "id=$id&confirm=$confirm");
    }

    /**
     * Export product.
     *
     * @param  string    $status
     * @param  string    $orderBy
     * @access public
     * @return void
     */
    public function export($status, $orderBy)
    {
        if($_POST)
        {
            $productLang   = $this->lang->product;
            $productConfig = $this->config->product;

            /* Create field lists. */
            $fields = $this->post->exportFields ? $this->post->exportFields : explode(',', $productConfig->list->exportFields);
            foreach($fields as $key => $fieldName)
            {
                $fieldName = trim($fieldName);
                $fields[$fieldName] = zget($productLang, $fieldName);

                unset($fields[$key]);
                if($this->config->systemMode == 'light' and ($fieldName == 'line' or $fieldName == 'program')) unset($fields[$fieldName]);
            }

            $lastProgram  = $lastLine = '';
            $lines        = $this->product->getLinePairs();
            $users        = $this->user->getPairs('noletter');
            $productStats = $this->product->getStats($orderBy, null, $status);
            foreach($productStats as $i => $product)
            {
                $product->line              = zget($lines, $product->line, '');
                $product->manager           = zget($users, $product->PO, '');
                $product->draftStories      = (int)$product->stories['draft'];
                $product->activeStories     = (int)$product->stories['active'];
                $product->changedStories    = (int)$product->stories['changing'];
                $product->reviewingStories  = (int)$product->stories['reviewing'];
                $product->closedStories     = (int)$product->stories['closed'];
                $product->totalStories      = $product->activeStories + $product->changedStories + $product->draftStories + $product->closedStories + $product->reviewingStories;
                $product->storyCompleteRate = ($product->totalStories == 0 ? 0 : round($product->closedStories / $product->totalStories, 3) * 100) . '%';
                $product->unResolvedBugs    = (int)$product->unResolved;
                $product->assignToNullBugs  = (int)$product->assignToNull;
                $product->bugFixedRate      = (($product->unResolved + $product->fixedBugs) == 0 ? 0 : round($product->fixedBugs / ($product->unResolved + $product->fixedBugs), 3) * 100) . '%';
                $product->program           = $product->programName;

                /* get rowspan data */
                if($lastProgram == '' or $product->program != $lastProgram)
                {
                    $rowspan[$i]['rows']['program'] = 1;
                    $programI = $i;
                }
                else
                {
                    $rowspan[$programI]['rows']['program'] ++;
                }
                if($lastLine == '' or $product->line != $lastLine)
                {
                    $rowspan[$i]['rows']['line'] = 1;
                    $lineI = $i;
                }
                else
                {
                    $rowspan[$lineI]['rows']['line'] ++;
                }
                $lastProgram = $product->program;
                $lastLine    = $product->line;

                if($this->post->exportType == 'selected')
                {
                    $checkedItem = $this->cookie->checkedItem;
                    if(strpos(",$checkedItem,", ",{$product->id},") === false) unset($productStats[$i]);
                }
            }
            if($this->config->edition != 'open') list($fields, $productStats) = $this->loadModel('workflowfield')->appendDataFromFlow($fields, $productStats);

            if(isset($rowspan)) $this->post->set('rowspan', $rowspan);
            $this->post->set('fields', $fields);
            $this->post->set('rows', $productStats);
            $this->post->set('kind', 'product');
            $this->fetch('file', 'export2' . $this->post->fileType, $_POST);
        }
        $this->display();
    }

    /**
     * Story track.
     *
     * @param  int         $productID
     * @param  int|string  $branch
     * @param  int         $projectID
     * @param  int         $recTotal
     * @param  int         $recPerPage
     * @param  int         $pageID
     * @access public
     * @return void
     */
    public function track($productID, $branch = '', $projectID = 0, $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $branch = ($this->cookie->preBranch !== '' and $branch === '') ? $this->cookie->preBranch : $branch;
        setcookie('preBranch', $branch, $this->config->cookieLife, $this->config->webRoot, '', $this->config->cookieSecure, true);

        /* Set menu. The projectstory module does not execute. */
        if(!$projectID)
        {
            $products  = $this->product->getPairs();
            $productID = $this->productZen->saveVisitState($productID, $products);
            $this->product->products = $this->productZen->saveVisitState($productID, $products);
            $this->productZen->setMenu($productID, $branch);
        }

        /* Save session. */
        $this->session->set('storyList',    $this->app->getURI(true), 'product');
        $this->session->set('taskList',     $this->app->getURI(true), 'execution');
        $this->session->set('designList',   $this->app->getURI(true), 'project');
        $this->session->set('bugList',      $this->app->getURI(true), 'qa');
        $this->session->set('caseList',     $this->app->getURI(true), 'qa');
        $this->session->set('revisionList', $this->app->getURI(true), 'repo');

        /* Load pager and get tracks. */
        $this->app->loadClass('pager', $static = true);
        $pager  = new pager($recTotal, $recPerPage, $pageID);
        $tracks = $this->story->getTracks($productID, $branch, $projectID, $pager);

        if($projectID)
        {
            $this->loadModel('project')->setMenu($projectID);
            $projectProducts = $this->product->getProducts($projectID);
        }

        $this->view->title      = $this->lang->story->track;
        $this->view->position[] = $this->lang->story->track;

        $this->view->tracks          = $tracks;
        $this->view->pager           = $pager;
        $this->view->productID       = $productID;
        $this->view->projectProducts = isset($projectProducts) ? $projectProducts : array();
        $this->display();
    }

    /**
     * Ajax set show setting.
     *
     * @access public
     * @return void
     */
    public function ajaxSetShowSetting()
    {
        $data = fixer::input('post')->get();
        $this->loadModel('setting')->updateItem("{$this->app->user->account}.product.showAllProjects", $data->showAllProjects);
    }

    /**
     * Ajax get products.
     *
     * @param  int    $executionID
     * @access public
     * @return void
     */
    public function ajaxGetProducts($executionID)
    {
        $this->loadModel('build');
        if(!$executionID) return print(html::select('product', array(), '', "class='form-control chosen' required"));
        $status   = empty($this->config->CRProduct) ? 'noclosed' : '';
        $products = $this->product->getProductPairsByProject($executionID, $status);
        if(empty($products))
        {
            return printf($this->lang->build->noProduct, $this->createLink('execution', 'manageproducts', "executionID=$executionID&from=buildCreate", '', 'true'), 'project');
        }

        return print(html::select('product', $products, '', "onchange='loadBranches(this.value);' class='form-control chosen' required data-toggle='modal' data-type='iframe'"));
    }

    /**
     * Ajax get product by id.
     *
     * @param  int    $productID
     * @access public
     * @return void
     */
    public function ajaxGetProductById($productID)
    {
        $product = $this->product->getById($productID);

        $product->branchSourceName = sprintf($this->lang->product->branch, $this->lang->product->branchName[$product->type]);
        $product->branchName       = $this->lang->product->branchName[$product->type];
        echo json_encode($product);
    }

    /**
     * AJAX: get projects of a product in html select.
     *
     * @param  int    $productID
     * @param  int    $branch
     * @param  int    $projectID
     * @access public
     * @return void
     */
    public function ajaxGetProjects($productID, $branch = 0, $projectID = 0)
    {
        $projects  = array('' => '');
        $projects += $this->product->getProjectPairsByProduct($productID, $branch);
        if($this->app->getViewType() == 'json') return print(json_encode($projects));

        return print(html::select('project', $projects, $projectID, "class='form-control' onchange='loadProductExecutions({$productID}, this.value)'"));
    }

     /**
     * AJAX: get projects of a product in html select.
     *
     * @param  int    $productID
     * @param  int    $branch
     * @param  int    $number
     * @access public
     * @return void
     */
    public function ajaxGetProjectsByBranch($productID, $branch = 0, $number = 0)
    {
        $projects  = array('' => '');
        $projects += $this->product->getProjectPairsByProduct($productID, $branch);

        return print(html::select('projects' . "[$number]", array('' => '') + $projects, 0, "class='form-control' onchange='loadProductExecutionsByProject($productID, this.value, $number)'"));
    }

    /**
     * AJAX: get executions of a product in html select.
     *
     * @param  int    $productID
     * @param  int    $projectID
     * @param  int    $branch
     * @param  string $number
     * @param  int    $executionID
     * @param  string $from showImport
     * @param  string mode
     * @access public
     * @return void
     */
    public function ajaxGetExecutions($productID, $projectID = 0, $branch = 0, $number = '', $executionID = 0, $from = '', $mode = '')
    {
        if($this->app->tab == 'execution' and $this->session->execution)
        {
            $execution = $this->loadModel('execution')->getByID($this->session->execution);
            if($execution->type == 'kanban') $projectID = $execution->project;
        }

        if($projectID) $project = $this->loadModel('project')->getById($projectID);
        $mode .= ($from == 'bugToTask' or empty($this->config->CRExecution)) ? 'noclosed' : '';
        $mode .= !$projectID ? ',multiple' : '';
        $executions = $from == 'showImport' ? $this->product->getAllExecutionPairsByProduct($productID, $branch, $projectID) : $this->product->getExecutionPairsByProduct($productID, $branch, 'id_desc', $projectID, $mode);
        if($this->app->getViewType() == 'json') return print(json_encode($executions));

        if($number === '')
        {
            $event = $from == 'bugToTask' ? '' : " onchange='loadExecutionRelated(this.value)'";
            $datamultiple = !empty($project) ? "data-multiple={$project->multiple}" : '';
            return print(html::select('execution', array('' => '') + $executions, $executionID, "class='form-control' $datamultiple $event"));
        }
        else
        {
            $executions     = empty($executions) ? array('' => '') : $executions;
            $executionsName = $from == 'showImport' ? "execution[$number]" : "executions[$number]";
            $misc           = $from == 'showImport' ? "class='form-control' onchange='loadImportExecutionRelated(this.value, $number)'" : "class='form-control' onchange='loadExecutionBuilds($productID, this.value, $number)'";
            return print(html::select($executionsName, $executions, '', $misc));
        }
    }

    /**
     * AJAX: get executions of a product in html select.
     *
     * @param  int    $productID
     * @param  int    $projectID
     * @param  int    $branch
     * @param  int    $number
     * @access public
     * @return void
     */
    public function ajaxGetExecutionsByProject($productID, $projectID = 0, $branch = 0, $number = 0)
    {
        $noMultipleExecutionID = $projectID ? $this->loadModel('execution')->getNoMultipleID($projectID) : '';
        $executions            = $this->product->getExecutionPairsByProduct($productID, $branch, 'id_desc', $projectID, 'multiple,stagefilter');

        $disabled = $noMultipleExecutionID ? "disabled='disabled'" : '';
        $html = html::select("executions[{$number}]", array('' => '') + $executions, 0, "class='form-control' onchange='loadExecutionBuilds($productID, this.value, $number)' $disabled");

        if($noMultipleExecutionID) $html .= html::hidden("executions[{$number}]", $noMultipleExecutionID, "id=executions{$number}");

        return print($html);
    }

    /**
     * AJAX: get plans of a product in html select.
     *
     * @param  int    $productID
     * @param  int    $planID
     * @param  bool   $needCreate
     * @param  string $expired
     * @param  string $param
     * @access public
     * @return void
     */
    public function ajaxGetPlans($productID, $branch = 0, $planID = 0, $fieldID = '', $needCreate = false, $expired = '', $param = '')
    {
        $param    = strtolower($param);
        if(strpos($param, 'forstory') === false)
        {
            $plans = $this->loadModel('productplan')->getPairs($productID, empty($branch) ? 'all' : $branch, $expired, strpos($param, 'skipparent') !== false);
        }
        else
        {
            $plans = $this->loadModel('productplan')->getPairsForStory($productID, $branch == '0' ? 'all' : $branch, $param);
        }
        $field    = $fieldID !== '' ? "plans[$fieldID]" : 'plan';
        $multiple = strpos($param, 'multiple') === false ? '' : 'multiple';
        $output   = html::select($field, $plans, $planID, "class='form-control chosen' $multiple");

        if($branch == 0 and strpos($param, 'edit') and (strpos($param, 'forstory') === false)) $output = html::select($field, $plans, $planID, "class='form-control chosen' multiple");

        if(count($plans) == 1 and $needCreate and $needCreate !== 'false')
        {
            $output .= "<div class='input-group-btn'>";
            $output .= html::a($this->createLink('productplan', 'create', "productID=$productID&branch=$branch", '', true), "<i class='icon icon-plus'></i>", '', "class='btn btn-icon' data-toggle='modal' data-type='iframe' data-width='95%' title='{$this->lang->productplan->create}'");
            $output .= '</div>';
            $output .= "<div class='input-group-btn'>";
            $output .= html::a("javascript:void(0)", "<i class='icon icon-refresh'></i>", '', "class='btn btn-icon refresh' data-toggle='tooltip' title='{$this->lang->refresh}' onclick='loadProductPlans($productID)'");
            $output .= '</div>';
        }
        echo $output;
    }

    /**
     * Ajax get product lines.
     *
     * @param  int    $programID
     * @param  int    $productID
     * @access public
     * @return void
     */
    public function ajaxGetLine($programID, $productID = 0)
    {
        $lines = array();
        if(empty($productID) or $programID) $lines = $this->product->getLinePairs($programID);

        if($productID)  return print(html::select("lines[$productID]", array('' => '') + $lines, '', "class='form-control picker-select'"));
        if(!$productID) return print(html::select('line', array('' => '') + $lines, '', "class='form-control picker-select'"));
    }

    /**
     * Ajax get reviewers.
     *
     * @param  int    $productID
     * @param  int    $storyID
     * @access public
     * @return void
     */
    public function ajaxGetReviewers($productID, $storyID = 0)
    {
        /* Get product reviewers. */
        $product          = $this->product->getByID($productID);
        $productReviewers = $product->reviewer;
        if(!$productReviewers and $product->acl != 'open') $productReviewers = $this->loadModel('user')->getProductViewListUsers($product, '', '', '', '');

        $storyReviewers = '';
        if($storyID)
        {
            $story          = $this->loadModel('story')->getByID($storyID);
            $storyReviewers = $this->story->getReviewerPairs($story->id, $story->version);
            $storyReviewers = implode(',', array_keys($storyReviewers));
        }

        $reviewers = $this->loadModel('user')->getPairs('noclosed|nodeleted', $storyReviewers, 0, $productReviewers);

        echo html::select("reviewer[]", $reviewers, $storyReviewers, "class='form-control chosen' multiple");
    }

    /**
     * Drop menu page.
     *
     * @param  int    $productID
     * @param  string $module
     * @param  string $method
     * @param  string $extra
     * @param  string $from
     * @access public
     * @return void
     */
    public function ajaxGetDropMenu(string $productID, string $module, string $method, string $extra = '', string $from = '')
    {
        $productID = (int)$productID;
        $shadow    = 0;
        if($from == 'qa')
        {
            $shadow = 'all';
            $this->app->loadConfig('qa');
            foreach($this->config->qa->menuList as $menu) $this->lang->navGroup->$menu = 'qa';
        }

        $programProducts = array();

        if($this->app->tab == 'project')
        {
            $products = $this->product->getProducts($this->session->project);
        }
        elseif($this->app->tab == 'feedback')
        {
            $products = $this->loadModel('feedback')->getGrantProducts(false);
        }
        else
        {
            $products = $this->product->getList(0, 'all', 0, 0, $shadow);
        }

        $programProducts = array();
        foreach($products as $product) $programProducts[$product->program][] = $product;

        $this->view->link      = $this->product->getProductLink($module, $method, $extra);
        $this->view->productID = $productID;
        $this->view->module    = $module;
        $this->view->method    = $method;
        $this->view->extra     = $extra;
        $this->view->products  = $programProducts;
        $this->view->projectID = $this->app->tab == 'project' ? $this->session->project : 0;
        $this->view->programs  = $this->loadModel('program')->getPairs(true);
        $this->view->lines     = $this->product->getLinePairs();
        $this->display();
    }

    /**
     * Set product id to session in ajax
     *
     * @param  int    $productID
     * @access public
     * @return void
     */
    public function ajaxSetState(string $productID)
    {
        $this->session->set('product', (int)$productID, $this->app->tab);
        $this->send(array('result' => 'success', 'productID' => $this->session->product));
    }
}
