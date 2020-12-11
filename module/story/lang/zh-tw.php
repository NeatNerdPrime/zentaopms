<?php
/**
 * The story module zh-tw file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: zh-tw.php 5141 2013-07-15 05:57:15Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->story->create            = "提{$lang->productSRCommon}";
$lang->story->batchCreate       = "批量創建";
$lang->story->change            = "變更";
$lang->story->changeAction      = "變更{$lang->productSRCommon}";
$lang->story->changed           = "{$lang->productSRCommon}變更";
$lang->story->assignTo          = '指派';
$lang->story->assignAction      = "指派{$lang->productSRCommon}";
$lang->story->review            = '評審';
$lang->story->reviewAction      = "評審{$lang->productSRCommon}";
$lang->story->needReview        = '需要評審';
$lang->story->batchReview       = '批量評審';
$lang->story->edit              = "編輯";
$lang->story->batchEdit         = "批量編輯";
$lang->story->subdivide         = '細分';
$lang->story->subdivideAction   = "細分{$lang->productSRCommon}";
$lang->story->splitRequirent    = '拆分';
$lang->story->close             = '關閉';
$lang->story->closeAction       = "關閉{$lang->productSRCommon}";
$lang->story->batchClose        = '批量關閉';
$lang->story->activate          = '激活';
$lang->story->activateAction    = "激活{$lang->productSRCommon}";
$lang->story->delete            = "刪除";
$lang->story->deleteAction      = "刪除{$lang->productSRCommon}";
$lang->story->view              = "{$lang->productSRCommon}詳情";
$lang->story->setting           = "設置";
$lang->story->tasks             = "相關任務";
$lang->story->bugs              = "相關Bug";
$lang->story->cases             = "相關用例";
$lang->story->taskCount         = '任務數';
$lang->story->bugCount          = 'Bug數';
$lang->story->caseCount         = '用例數';
$lang->story->taskCountAB       = 'T';
$lang->story->bugCountAB        = 'B';
$lang->story->caseCountAB       = 'C';
$lang->story->linkStory         = "關聯{$lang->productSRCommon}";
$lang->story->unlinkStory       = "移除相關{$lang->productSRCommon}";
$lang->story->export            = "導出數據";
$lang->story->exportAction      = "導出{$lang->productSRCommon}";
$lang->story->zeroCase          = "零用例{$lang->productSRCommon}";
$lang->story->zeroTask          = "只列零任務{$lang->productSRCommon}";
$lang->story->reportChart       = "統計報表";
$lang->story->reportAction      = "統計報表";
$lang->story->copyTitle         = "同{$lang->productSRCommon}名稱";
$lang->story->batchChangePlan   = "批量修改計劃";
$lang->story->batchChangeBranch = "批量修改分支";
$lang->story->batchChangeStage  = "批量修改階段";
$lang->story->batchAssignTo     = "批量指派";
$lang->story->batchChangeModule = "批量修改模組";
$lang->story->viewAll           = '查看全部';
$lang->story->toTask            = '轉任務';
$lang->story->batchToTask       = '批量轉任務';
$lang->story->convertRelations  = '換算關係';

$lang->story->skipStory       = '需求：%s 為父需求，將不會被關閉。';
$lang->story->closedStory     = '需求：%s 已關閉，將不會被關閉。';
$lang->story->batchToTaskTips = "此操作會創建與所選{$lang->productSRCommon}同名的任務，並將{$lang->productSRCommon}關聯到任務中，已關閉的需求不會轉為任務。";
$lang->story->successToTask   = '批量轉任務成功';

$lang->story->common         = $lang->productSRCommon;
$lang->story->id             = '編號';
$lang->story->parent         = '父需求';
$lang->story->product        = "所屬{$lang->productCommon}";
$lang->story->branch         = "分支/平台";
$lang->story->module         = '所屬模組';
$lang->story->moduleAB       = '模組';
$lang->story->source         = "{$lang->productSRCommon}來源";
$lang->story->sourceNote     = '來源備註';
$lang->story->fromBug        = '來源Bug';
$lang->story->title          = "{$lang->productSRCommon}名稱";
$lang->story->type           = "{$lang->productSRCommon}類型";
$lang->story->color          = '標題顏色';
$lang->story->toBug          = '轉Bug';
$lang->story->spec           = "{$lang->productSRCommon}描述";
$lang->story->assign         = '指派給';
$lang->story->verify         = '驗收標準';
$lang->story->pri            = '優先順序';
$lang->story->estimate       = "預計{$lang->hourCommon}";
$lang->story->estimateAB     = '預計';
$lang->story->hour           = $lang->hourCommon;
$lang->story->status         = '當前狀態';
$lang->story->subStatus      = '子狀態';
$lang->story->stage          = '所處階段';
$lang->story->stageAB        = '階段';
$lang->story->stagedBy       = '設置階段者';
$lang->story->mailto         = '抄送給';
$lang->story->openedBy       = '由誰創建';
$lang->story->openedDate     = '創建日期';
$lang->story->assignedTo     = '指派給';
$lang->story->assignedDate   = '指派日期';
$lang->story->lastEditedBy   = '最後修改';
$lang->story->lastEditedDate = '最後修改日期';
$lang->story->closedBy       = '由誰關閉';
$lang->story->closedDate     = '關閉日期';
$lang->story->closedReason   = '關閉原因';
$lang->story->rejectedReason = '拒絶原因';
$lang->story->reviewedBy     = '由誰評審';
$lang->story->reviewedDate   = '評審時間';
$lang->story->version        = '版本號';
$lang->story->plan           = '所屬計劃';
$lang->story->planAB         = '計劃';
$lang->story->comment        = '備註';
$lang->story->children       = "子{$lang->productSRCommon}";
$lang->story->childrenAB     = "子";
$lang->story->linkStories    = "相關{$lang->productSRCommon}";
$lang->story->childStories   = "細分{$lang->productSRCommon}";
$lang->story->duplicateStory = "重複{$lang->productSRCommon}ID";
$lang->story->reviewResult   = '評審結果';
$lang->story->preVersion     = '之前版本';
$lang->story->keywords       = '關鍵詞';
$lang->story->newStory       = "繼續添加{$lang->productSRCommon}";
$lang->story->colorTag       = '顏色標籤';
$lang->story->files          = '附件';
$lang->story->copy           = "複製{$lang->productSRCommon}";
$lang->story->total          = "總{$lang->productSRCommon}";
$lang->story->allStories     = "所有{$lang->productSRCommon}";
$lang->story->unclosed       = '未關閉';
$lang->story->deleted        = '已刪除';
$lang->story->released       = "已發佈{$lang->productSRCommon}數";
$lang->story->one            = '一個';
$lang->story->field          = '同步的欄位';

$lang->story->ditto       = '同上';
$lang->story->dittoNotice = "該{$lang->productSRCommon}與上一{$lang->productSRCommon}不屬於同一產品！";

$lang->story->needNotReviewList[0] = '需要評審';
$lang->story->needNotReviewList[1] = '不需要評審';

$lang->story->useList[0] = '不使用';
$lang->story->useList[1] = '使用';

$lang->story->statusList['']          = '';
$lang->story->statusList['draft']     = '草稿';
$lang->story->statusList['active']    = '激活';
$lang->story->statusList['closed']    = '已關閉';
$lang->story->statusList['changed']   = '已變更';

$lang->story->stageList['']           = '';
$lang->story->stageList['wait']       = '未開始';
$lang->story->stageList['planned']    = '已計劃';
$lang->story->stageList['projected']  = '已立項';
$lang->story->stageList['developing'] = '研發中';
$lang->story->stageList['developed']  = '研發完畢';
$lang->story->stageList['testing']    = '測試中';
$lang->story->stageList['tested']     = '測試完畢';
$lang->story->stageList['verified']   = '已驗收';
$lang->story->stageList['released']   = '已發佈';
$lang->story->stageList['closed']     = '已關閉';

$lang->story->reasonList['']           = '';
$lang->story->reasonList['done']       = '已完成';
$lang->story->reasonList['subdivided'] = '已細分';
$lang->story->reasonList['duplicate']  = '重複';
$lang->story->reasonList['postponed']  = '延期';
$lang->story->reasonList['willnotdo']  = '不做';
$lang->story->reasonList['cancel']     = '已取消';
$lang->story->reasonList['bydesign']   = '設計如此';
//$lang->story->reasonList['isbug']      = '是個Bug';

$lang->story->reviewResultList['']        = '';
$lang->story->reviewResultList['pass']    = '確認通過';
$lang->story->reviewResultList['revert']  = '撤銷變更';
$lang->story->reviewResultList['clarify'] = '有待明確';
$lang->story->reviewResultList['reject']  = '拒絶';

$lang->story->reviewList[0] = '否';
$lang->story->reviewList[1] = '是';

$lang->story->sourceList['']           = '';
$lang->story->sourceList['customer']   = '客戶';
$lang->story->sourceList['user']       = '用戶';
$lang->story->sourceList['po']         = $lang->productCommon . '經理';
$lang->story->sourceList['market']     = '市場';
$lang->story->sourceList['service']    = '客服';
$lang->story->sourceList['operation']  = '運營';
$lang->story->sourceList['support']    = '技術支持';
$lang->story->sourceList['competitor'] = '競爭對手';
$lang->story->sourceList['partner']    = '合作夥伴';
$lang->story->sourceList['dev']        = '開發人員';
$lang->story->sourceList['tester']     = '測試人員';
$lang->story->sourceList['bug']        = 'Bug';
$lang->story->sourceList['forum']      = '論壇';
$lang->story->sourceList['other']      = '其他';

$lang->story->priList[]  = '';
$lang->story->priList[1] = '1';
$lang->story->priList[2] = '2';
$lang->story->priList[3] = '3';
$lang->story->priList[4] = '4';

$lang->story->legendBasicInfo      = '基本信息';
$lang->story->legendLifeTime       = "{$lang->productSRCommon}的一生";
$lang->story->legendRelated        = '相關信息';
$lang->story->legendMailto         = '抄送給';
$lang->story->legendAttatch        = '附件';
$lang->story->legendProjectAndTask = $lang->projectCommon . '任務';
$lang->story->legendBugs           = '相關Bug';
$lang->story->legendFromBug        = '來源Bug';
$lang->story->legendCases          = '相關用例';
$lang->story->legendLinkStories    = "相關{$lang->productSRCommon}";
$lang->story->legendChildStories   = "細分{$lang->productSRCommon}";
$lang->story->legendSpec           = "{$lang->productSRCommon}描述";
$lang->story->legendVerify         = '驗收標準';
$lang->story->legendMisc           = '其他相關';

$lang->story->lblChange            = "變更{$lang->productSRCommon}";
$lang->story->lblReview            = "評審{$lang->productSRCommon}";
$lang->story->lblActivate          = "激活{$lang->productSRCommon}";
$lang->story->lblClose             = "關閉{$lang->productSRCommon}";
$lang->story->lblTBC               = '任務Bug用例';

$lang->story->checkAffection       = '影響範圍';
$lang->story->affectedProjects     = '影響的' . $lang->projectCommon;
$lang->story->affectedBugs         = '影響的Bug';
$lang->story->affectedCases        = '影響的用例';

$lang->story->specTemplate          = "建議參考的模板：作為一名<某種類型的用戶>，我希望<達成某些目的>，這樣可以<開發的價值>。";
$lang->story->needNotReview         = '不需要評審';
$lang->story->successSaved          = "{$lang->productSRCommon}成功添加，";
$lang->story->confirmDelete         = "您確認刪除該{$lang->productSRCommon}嗎?";
$lang->story->errorEmptyChildStory  = "『細分{$lang->productSRCommon}』不能為空。";
$lang->story->errorNotSubdivide     = "狀態不是激活，或者階段不是未開始的{$lang->productSRCommon}，或者是子需求，則不能細分。";
$lang->story->mustChooseResult      = '必須選擇評審結果';
$lang->story->mustChoosePreVersion  = '必須選擇回溯的版本';
$lang->story->noStory               = "暫時沒有{$lang->productSRCommon}。";
$lang->story->noRequirement         = "暫時沒有{$lang->productURCommon}。";
$lang->story->ignoreChangeStage     = "{$lang->productSRCommon} %s 為草稿狀態或已關閉狀態，沒有修改其階段。";
$lang->story->cannotDeleteParent    = "不能刪除父{$lang->productSRCommon}";
$lang->story->moveChildrenTips      = "修改父{$lang->productSRCommon}的所屬產品會將其下的子{$lang->productSRCommon}也移動到所選產品下。";

$lang->story->form = new stdclass();
$lang->story->form->area      = "該{$lang->productSRCommon}所屬範圍";
$lang->story->form->desc      = "描述及標準，什麼{$lang->productSRCommon}？如何驗收？";
$lang->story->form->resource  = '資源分配，有誰完成？需要多少時間？';
$lang->story->form->file      = "附件，如果該{$lang->productSRCommon}有相關檔案，請點此上傳。";

$lang->story->action = new stdclass();
$lang->story->action->reviewed            = array('main' => '$date, 由 <strong>$actor</strong> 記錄評審結果，結果為 <strong>$extra</strong>。', 'extra' => 'reviewResultList');
$lang->story->action->closed              = array('main' => '$date, 由 <strong>$actor</strong> 關閉，原因為 <strong>$extra</strong> $appendLink。', 'extra' => 'reasonList');
$lang->story->action->linked2plan         = array('main' => '$date, 由 <strong>$actor</strong> 關聯到計劃 <strong>$extra</strong>。');
$lang->story->action->unlinkedfromplan    = array('main' => '$date, 由 <strong>$actor</strong> 從計劃 <strong>$extra</strong> 移除。');
$lang->story->action->linked2project      = array('main' => '$date, 由 <strong>$actor</strong> 關聯到' . $lang->projectCommon . ' <strong>$extra</strong>。');
$lang->story->action->unlinkedfromproject = array('main' => '$date, 由 <strong>$actor</strong> 從' . $lang->projectCommon . ' <strong>$extra</strong> 移除。');
$lang->story->action->linked2build        = array('main' => '$date, 由 <strong>$actor</strong> 關聯到版本 <strong>$extra</strong>。');
$lang->story->action->unlinkedfrombuild   = array('main' => '$date, 由 <strong>$actor</strong> 從版本 <strong>$extra</strong> 移除。');
$lang->story->action->linked2release      = array('main' => '$date, 由 <strong>$actor</strong> 關聯到發佈 <strong>$extra</strong>。');
$lang->story->action->unlinkedfromrelease = array('main' => '$date, 由 <strong>$actor</strong> 從發佈 <strong>$extra</strong> 移除。');
$lang->story->action->linkrelatedstory    = array('main' => "\$date, 由 <strong>\$actor</strong> 關聯相關{$lang->productSRCommon} <strong>\$extra</strong>。");
$lang->story->action->subdividestory      = array('main' => "\$date, 由 <strong>\$actor</strong> 細分為{$lang->productSRCommon}   <strong>\$extra</strong>。");
$lang->story->action->unlinkrelatedstory  = array('main' => "\$date, 由 <strong>\$actor</strong> 移除相關{$lang->productSRCommon} <strong>\$extra</strong>。");
$lang->story->action->unlinkchildstory    = array('main' => "\$date, 由 <strong>\$actor</strong> 移除細分{$lang->productSRCommon} <strong>\$extra</strong>。");

/* 統計報表。*/
$lang->story->report = new stdclass();
$lang->story->report->common = '報表';
$lang->story->report->select = '請選擇報表類型';
$lang->story->report->create = '生成報表';
$lang->story->report->value  = "{$lang->productSRCommon}數";

$lang->story->report->charts['storysPerProduct']        = $lang->productCommon . "{$lang->productSRCommon}數量";
$lang->story->report->charts['storysPerModule']         = "模組{$lang->productSRCommon}數量";
$lang->story->report->charts['storysPerSource']         = "按{$lang->productSRCommon}來源統計";
$lang->story->report->charts['storysPerPlan']           = '按計划進行統計';
$lang->story->report->charts['storysPerStatus']         = '按狀態進行統計';
$lang->story->report->charts['storysPerStage']          = '按所處階段進行統計';
$lang->story->report->charts['storysPerPri']            = '按優先順序進行統計';
$lang->story->report->charts['storysPerEstimate']       = "按預計{$lang->hourCommon}進行統計";
$lang->story->report->charts['storysPerOpenedBy']       = '按由誰創建來進行統計';
$lang->story->report->charts['storysPerAssignedTo']     = '按當前指派來進行統計';
$lang->story->report->charts['storysPerClosedReason']   = '按關閉原因來進行統計';
$lang->story->report->charts['storysPerChange']         = '按變更次數來進行統計';

$lang->story->report->options = new stdclass();
$lang->story->report->options->graph   = new stdclass();
$lang->story->report->options->type    = 'pie';
$lang->story->report->options->width   = 500;
$lang->story->report->options->height  = 140;

$lang->story->report->storysPerProduct      = new stdclass();
$lang->story->report->storysPerModule       = new stdclass();
$lang->story->report->storysPerSource       = new stdclass();
$lang->story->report->storysPerPlan         = new stdclass();
$lang->story->report->storysPerStatus       = new stdclass();
$lang->story->report->storysPerStage        = new stdclass();
$lang->story->report->storysPerPri          = new stdclass();
$lang->story->report->storysPerOpenedBy     = new stdclass();
$lang->story->report->storysPerAssignedTo   = new stdclass();
$lang->story->report->storysPerClosedReason = new stdclass();
$lang->story->report->storysPerEstimate     = new stdclass();
$lang->story->report->storysPerChange       = new stdclass();

$lang->story->report->storysPerProduct->item      = $lang->productCommon;
$lang->story->report->storysPerModule->item       = '模組';
$lang->story->report->storysPerSource->item       = '來源';
$lang->story->report->storysPerPlan->item         = '計劃';
$lang->story->report->storysPerStatus->item       = '狀態';
$lang->story->report->storysPerStage->item        = '階段';
$lang->story->report->storysPerPri->item          = '優先順序';
$lang->story->report->storysPerOpenedBy->item     = '由誰創建';
$lang->story->report->storysPerAssignedTo->item   = '指派給';
$lang->story->report->storysPerClosedReason->item = '原因';
$lang->story->report->storysPerEstimate->item     = "預計{$lang->hourCommon}";
$lang->story->report->storysPerChange->item       = '變更次數';

$lang->story->report->storysPerProduct->graph      = new stdclass();
$lang->story->report->storysPerModule->graph       = new stdclass();
$lang->story->report->storysPerSource->graph       = new stdclass();
$lang->story->report->storysPerPlan->graph         = new stdclass();
$lang->story->report->storysPerStatus->graph       = new stdclass();
$lang->story->report->storysPerStage->graph        = new stdclass();
$lang->story->report->storysPerPri->graph          = new stdclass();
$lang->story->report->storysPerOpenedBy->graph     = new stdclass();
$lang->story->report->storysPerAssignedTo->graph   = new stdclass();
$lang->story->report->storysPerClosedReason->graph = new stdclass();
$lang->story->report->storysPerEstimate->graph     = new stdclass();
$lang->story->report->storysPerChange->graph       = new stdclass();

$lang->story->report->storysPerProduct->graph->xAxisName      = $lang->productCommon;
$lang->story->report->storysPerModule->graph->xAxisName       = '模組';
$lang->story->report->storysPerSource->graph->xAxisName       = '來源';
$lang->story->report->storysPerPlan->graph->xAxisName         = '計劃';
$lang->story->report->storysPerStatus->graph->xAxisName       = '狀態';
$lang->story->report->storysPerStage->graph->xAxisName        = '所處階段';
$lang->story->report->storysPerPri->graph->xAxisName          = '優先順序';
$lang->story->report->storysPerOpenedBy->graph->xAxisName     = '由誰創建';
$lang->story->report->storysPerAssignedTo->graph->xAxisName   = '當前指派';
$lang->story->report->storysPerClosedReason->graph->xAxisName = '關閉原因';
$lang->story->report->storysPerEstimate->graph->xAxisName     = '預計時間';
$lang->story->report->storysPerChange->graph->xAxisName       = '變更次數';

$lang->story->placeholder = new stdclass();
$lang->story->placeholder->estimate = $lang->story->hour;

$lang->story->chosen = new stdClass();
$lang->story->chosen->reviewedBy = '選擇評審人...';

$lang->story->notice = new stdClass();
$lang->story->notice->closed = "您選擇的{$lang->productSRCommon}已經被關閉了！";

$lang->story->convertToTask = new stdClass();
$lang->story->convertToTask->fieldList = array();
$lang->story->convertToTask->fieldList['module']     = '所屬模組';
$lang->story->convertToTask->fieldList['spec']       = "{$lang->productSRCommon}描述";
$lang->story->convertToTask->fieldList['pri']        = '優先順序';
$lang->story->convertToTask->fieldList['mailto']     = '抄送給';
$lang->story->convertToTask->fieldList['assignedTo'] = '指派給';
