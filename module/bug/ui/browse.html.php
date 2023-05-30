<?php
declare(strict_types=1);
/**
 * The browse view file of bug module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Tingting Dai <daitingting@easycorp.ltd>
 * @package     bug
 * @link        https://www.zentao.net
 */
namespace zin;
jsVar('productID', $product->id);
jsVar('branch',    $branch);

$this->bug->buildOperateMenu(null, 'browse');

foreach($bugs as $bug)
{
    $bug->productName  = zget($products, $bug->product);
    $bug->storyName    = zget($stories, $bug->story);
    $bug->taskName     = zget($tasks, $bug->task);
    $bug->toTaskName   = zget($tasks, $bug->toTask);
    $bug->module       = zget($modulePairs, $bug->module);
    $bug->branch       = zget($branchTagOption, $bug->branch);
    $bug->project      = zget($projectPairs, $bug->project);
    $bug->execution    = zget($executions, $bug->execution);
    if(!empty($bug->openedBy))     $bug->openedBy     = zget($users, $bug->openedBy);
    if(!empty($bug->assignedTo))   $bug->assignedTo   = zget($users, $bug->assignedTo);
    if(!empty($bug->resolvedBy))   $bug->resolvedBy   = zget($users, $bug->resolvedBy);
    if(!empty($bug->mailto))       $bug->mailto       = zget($users, $bug->mailto);
    if(!empty($bug->closedBy))     $bug->closedBy     = zget($users, $bug->closedBy);
    if(!empty($bug->lastEditedBy)) $bug->lastEditedBy = zget($users, $bug->lastEditedBy);
    $bug->type         = zget($lang->bug->typeList, $bug->type);
    $bug->confirmed    = zget($lang->bug->confirmedList, $bug->confirmed);
    $bug->resolution   = zget($lang->bug->resolutionList, $bug->resolution);
    $bug->os           = zget($lang->bug->osList, $bug->os);
    $bug->browser      = zget($lang->bug->browserList, $bug->browser);

    $actions = array();
    foreach($this->config->bug->dtable->fieldList['actions']['actionsMap'] as $actionCode => $actionMap)
    {
        $isClickable = $this->bug->isClickable($bug, $actionCode);

        $actions[] = $isClickable ? $actionCode : array('name' => $actionCode, 'disabled' => true);
    }
    $bug->actions = $actions;
}

$cols = array_values($config->bug->dtable->fieldList);
$data = array_values($bugs);

$canCreate      = false;
$canBatchCreate = false;
if(common::canModify('product', $product))
{
    $canCreate      = hasPriv('bug', 'create');
    $canBatchCreate = hasPriv('bug', 'batchCreate');

    $selectedBranch  = $branch != 'all' ? $branch : 0;
    $createLink      = $this->createLink('bug', 'create', "productID={$product->id}&branch=$selectedBranch&extra=moduleID=$currentModuleID");
    $batchCreateLink = $this->createLink('bug', 'batchCreate', "productID={$product->id}&branch=$branch&executionID=0&moduleID=$currentModuleID");
    if(commonModel::isTutorialMode())
    {
        $wizardParams = helper::safe64Encode("productID={$product->id}&branch=$branch&extra=moduleID=$currentModuleID");
        $createLink   = $this->createLink('tutorial', 'wizard', "module=bug&method=create&params=$wizardParams");
    }

    $createItem      = array('text' => $lang->bug->create,      'url' => $createLink);
    $batchCreateItem = array('text' => $lang->bug->batchCreate, 'url' => $batchCreateLink);
}

featureBar
(
    set::current($browseType),
    set::linkParams("product=$product->id&branch=$branch&browseType={key}"),
    li(searchToggle())
);

if(!isonlybody())
{
    toolbar
    (
        hasPriv('bug', 'report') ? item(set(array
        (
            'icon'  => 'bar-chart',
            'text'  => $lang->bug->report->common,
            'class' => 'ghost',
            'url'   => createLink('bug', 'report', "productID=$product->id&browseType=$browseType&branch=$branch&module=$currentModuleID")
        ))) : null,
        hasPriv('bug', 'export') ? item(set(array
        (
            'text'  => $lang->bug->export,
            'icon'  => 'export',
            'class' => 'ghost',
            'url'   => createLink('bug', 'export', "productID={$product->id}&orderBy=$orderBy&browseType=$browseType"),
            'data-toggle' => 'modal'
        ))) : null,
        $canCreate && $canBatchCreate ? btngroup
        (
            btn(setClass('btn primary'), set::icon('plus'), set::url($createLink), $lang->bug->create),
            dropdown
            (
                btn(setClass('btn primary dropdown-toggle'), setStyle(array('padding' => '6px', 'border-radius' => '0 2px 2px 0'))),
                set::items(array($createItem, $batchCreateItem)),
                set::placement('bottom-end'),
            )
        ) : null,
        $canCreate && !$canBatchCreate ? item(set($createItem)) : null,
        $canBatchCreate && !$canCreate ? item(set($batchCreateItem)) : null,
    );
}

sidebar
(
    moduleMenu(set(array
    (
        'modules'   => $moduleTree,
        'activeKey' => $currentModuleID,
        'closeLink' => createLink('bug', 'browse', "productID=$product->id&branch=$branch")
    )))
);

$footToolbar = array('items' => array
(
    array('type' => 'btn-group', 'items' => array
    (
        array('text' => $lang->edit, 'className' => 'batch-btn', 'data-url' => createLink('bug', 'batchEdit', "productID={$product->id}&branch=$branch")),
        array('caret' => 'up', 'btnType' => 'primary', 'url' => '#navActions', 'data-toggle' => 'dropdown', 'data-placement' => 'top-start'),
    )),
    array('caret' => 'up', 'text' => $lang->product->branchName[$this->session->currentProductType], 'className' => $this->session->currentProductType == 'normal' ? 'hidden' : '' , 'btnType' => 'primary', 'url' => '#navBranch', 'data-toggle' => 'dropdown', 'data-placement' => 'top-start'),
    array('caret' => 'up', 'text' => $lang->bug->abbr->module, 'btnType' => 'primary', 'url' => '#navModule', 'data-toggle' => 'dropdown', 'data-placement' => 'top-start'),
    array('caret' => 'up', 'text' => $lang->bug->assignedTo, 'btnType' => 'primary', 'url' => '#navAssignedTo','data-toggle' => 'dropdown'),
));

$resolveItems = array();
foreach($lang->bug->resolutionList as $key => $resolution)
{
    if($key == 'duplicate' || $key == 'tostory') continue;
    if($key == 'fixed')
    {
        $buildItems = array();
        foreach($builds as $key => $build) $buildItems[] = array('text' => $build, 'class' => 'batch-btn ajax-btn', 'data-url' => helper::createLink('bug', 'batchResolve', "resolution=fixed&resolvedBuild=$key"));

        $resolveItems[] = array('text' => $resolution, 'class' => 'not-hide-menu', 'items' => $buildItems);
    }
    else
    {
        $resolveItems[] = array('text' => $resolution, 'class' => 'batch-btn ajax-btn', 'data-url' => helper::createLink('bug', 'batchResolve', "resolution=$key"));
    }
}

zui::menu
(
    set::id('navActions'),
    set::class('menu dropdown-menu'),
    set::items(array
    (
        array('text' => $lang->bug->confirm, 'class' => 'batch-btn ajax-btn', 'data-url' => helper::createLink('bug', 'batchConfirm')),
        array('text' => $lang->bug->close, 'class' => 'batch-btn ajax-btn', 'data-url' => helper::createLink('bug', 'batchClose')),
        array('text' => $lang->bug->activate, 'class' => 'batch-btn', 'data-url' => helper::createLink('bug', 'batchActivate', "productID=$product->id&branch=$branch")),
        array('text' => $lang->bug->resolve, 'class' => 'not-hide-menu', 'items' => $resolveItems),
    ))
);

$branchItems = array();
foreach($branchTagOption as $branchID => $branchName)
{
    $branchItems[] = array('text' => $branchName, 'class' => 'batch-btn ajax-btn', 'data-url' => helper::createLink('bug', 'batchChangeBranch', "branchID=$branchID"));
}

menu
(
    set::id('navBranch'),
    set::class('dropdown-menu'),
    set::items($branchItems)
);

$moduleItems = array();
foreach($modules as $moduleID => $module)
{
    $moduleItems[] = array('text' => $module, 'class' => 'batch-btn ajax-btn', 'data-url' => helper::createLink('bug', 'batchChangeModule', "moduleID=$moduleID"));
}

menu
(
    set::id('navModule'),
    set::class('dropdown-menu'),
    set::items($moduleItems)
);

$assignedToItems = array();
foreach ($memberPairs as $key => $value)
{
    $assignedToItems[] = array('text' => $value, 'class' => 'batch-btn ajax-btn', 'data-url' => helper::createLink('bug', 'batchAssignTo', "assignedTo=$key&productID={$product->id}&type=product"));
}

menu
(
    set::id('navAssignedTo'),
    set::class('dropdown-menu'),
    set::items($assignedToItems)
);

dtable
(
    set::cols($cols),
    set::data($data),
    set::footPager(usePager()),
    set::checkable(true),
    set::footToolbar($footToolbar),
    set::footPager(
        usePager(),
        set::page($pager->pageID),
        set::recPerPage($pager->recPerPage),
        set::recTotal($pager->recTotal),
        set::linkCreator(helper::createLink('bug', 'browse', "productID={$product->id}&branch={$branch}&browseType={$browseType}&param={$param}&orderBy=$orderBy&recTotal={$pager->recTotal}&recPerPage={recPerPage}&page={page}"))
    ),
);

render();
