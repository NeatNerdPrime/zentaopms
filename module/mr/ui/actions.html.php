<?php
declare(strict_types=1);
/**
 * The actions view file of mr module of ZenTaoPMS.
 * @copyright   Copyright 2009-2024 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yanyi Cao <caoyanyi@easycorp.ltd>
 * @package     mr
 * @link        https://www.zentao.net
 */
namespace zin;

$compileNotSuccess = !empty($compile->id) && $compile->status != 'success';

$mainActions   = array();
$suffixActions = array();
foreach($config->mr->view->operateList as $operate)
{
    if(!common::hasPriv('mr', $operate == 'reject' ? 'approval' : $operate)) continue;
    if($operate == 'reopen' && (!$MR->synced || $rawMR->state != 'closed')) continue;

    $action = $config->mr->actionList[$operate];
    if($operate === 'edit' || $operate === 'delete')
    {
        $suffixActions[] = $action;
        continue;
    }

    if($operate == 'accept' && ($MR->approvalStatus != 'approved' || $compileNotSuccess))
    {
        $action['disabled'] = true;
        $action['hint']     = $lang->mr->acceptTip;
    }
    if($operate == 'accept' && (!$MR->synced || $rawMR->state != 'opened' || $rawMR->has_conflicts))
    {
        $action['disabled'] = true;
        $action['hint']     = $lang->mr->conflictsTip;
    }

    if(in_array($operate, array('approval', 'reject', 'close', 'edit')))
    {
        if(!$MR->synced || $rawMR->state != 'opened') continue;
        if($operate == 'reject' && $MR->approvalStatus == 'rejected') $action['disabled'] = true;

        if($operate == 'approval')
        {
            if($rawMR->has_conflicts || $compileNotSuccess || $MR->approvalStatus == 'approved')
            {
                $action['disabled'] = true;
                if($rawMR->has_conflicts) $action['hint'] = $lang->mr->conflictsTip;
                if($compileNotSuccess)    $action['hint'] = $lang->mr->compileTip;
            }
        }
    }

    if($operate == 'delete' && !$projectOwner && !$this->app->user->admin) $action['disabled'] = true;
    if($operate == 'edit' && !$projectEdit && !$this->app->user->admin) $action['disabled'] = true;

    $mainActions[] = $action;
}

div
(
    setClass('detail-actions center sticky mt-4 bottom-4 z-10'),
    floatToolbar
    (
        set::object($MR),
        isAjaxRequest('modal') ? null : to::prefix(backBtn(set::icon('back'), $lang->goback)),
        set::main($mainActions),
        set::suffix($suffixActions)
    )
);
