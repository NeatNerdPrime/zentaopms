<?php
/**
 * The task module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     task
 * @version     $Id: zh-cn.php 5040 2013-07-06 06:22:18Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->task->index               = "任务一览";
$lang->task->create              = "建任务";
$lang->task->batchCreate         = "批量创建";
$lang->task->batchCreateChildren = "批量建子任务";
$lang->task->batchEdit           = "批量编辑";
$lang->task->batchChangeModule   = "批量修改模块";
$lang->task->batchClose          = "批量关闭";
$lang->task->batchCancel         = "批量取消";
$lang->task->edit                = "编辑任务";
$lang->task->delete              = "删除";
$lang->task->deleteAction        = "删除任务";
$lang->task->deleted             = "已删除";
$lang->task->delayed             = '延期';
$lang->task->view                = "查看任务";
$lang->task->logEfforts          = "记录工时";
$lang->task->record              = "工时";
$lang->task->teamConsumed        = "团队工时";
$lang->task->start               = "开始";
$lang->task->startAction         = "开始任务";
$lang->task->restart             = "继续";
$lang->task->restartAction       = "继续任务";
$lang->task->finishAction        = "完成任务";
$lang->task->finish              = "完成";
$lang->task->pause               = "暂停";
$lang->task->pauseAction         = "暂停任务";
$lang->task->close               = "关闭";
$lang->task->closeAction         = "关闭任务";
$lang->task->cancel              = "取消";
$lang->task->cancelAction        = "取消任务";
$lang->task->activateAction      = "激活任务";
$lang->task->activate            = "激活";
$lang->task->activatedDate       = "激活日期";
$lang->task->export              = "导出数据";
$lang->task->exportAction        = "导出任务";
$lang->task->reportChart         = "报表统计";
$lang->task->fromBug             = '来源Bug';
$lang->task->case                = '相关用例';
$lang->task->confirmStoryChange  = "确认{$lang->SRCommon}变动";
$lang->task->storyChange         = "{$lang->SRCommon}变更";
$lang->task->progress            = '进度';
$lang->task->progressAB          = '进度';
$lang->task->progressTips        = '已消耗/(已消耗+剩余)';
$lang->task->copy                = '复制任务';
$lang->task->waitTask            = '未开始的任务';
$lang->task->allModule           = '所有模块';

$lang->task->common            = '任务';
$lang->task->id                = '编号';
$lang->task->project           = '所属项目';
$lang->task->execution         = '所属' . $lang->execution->common;
$lang->task->module            = '所属模块';
$lang->task->moduleAB          = '模块';
$lang->task->design            = '相关设计';
$lang->task->story             = "相关{$lang->SRCommon}";
$lang->task->storyAB           = $lang->SRCommon;
$lang->task->storySpec         = "{$lang->SRCommon}描述";
$lang->task->storyVerify       = '验收标准';
$lang->task->storyVersion      = "{$lang->SRCommon}版本";
$lang->task->designVersion     = "设计版本";
$lang->task->color             = '标题颜色';
$lang->task->name              = '任务名称';
$lang->task->type              = '任务类型';
$lang->task->typeAB            = '类型';
$lang->task->mode              = '任务模式';
$lang->task->sync2Gitlab       = '同步到GitLab';
$lang->task->pri               = '优先级';
$lang->task->mailto            = '抄送给';
$lang->task->estimate          = '最初预计';
$lang->task->estimateAB        = '预计';
$lang->task->left              = '预计剩余';
$lang->task->leftAB            = '剩余';
$lang->task->consumed          = '总计消耗';
$lang->task->currentConsumed   = '本次消耗';
$lang->task->myConsumed        = '我的总消耗';
$lang->task->consumedAB        = '消耗';
$lang->task->hour              = '小时';
$lang->task->consumedThisTime  = '工时';
$lang->task->leftThisTime      = '剩余';
$lang->task->datePlan          = '日程规划';
$lang->task->estStarted        = '预计开始';
$lang->task->realStarted       = '实际开始';
$lang->task->date              = '日期';
$lang->task->deadline          = '截止日期';
$lang->task->deadlineAB        = '截止';
$lang->task->status            = '任务状态';
$lang->task->subStatus         = '子状态';
$lang->task->desc              = '任务描述';
$lang->task->version           = '版本';
$lang->task->estimateStartDate = '预计开始日期';
$lang->task->actualStartDate   = '实际开始日期';
$lang->task->planDuration      = '计划持续天数';
$lang->task->realDuration      = '实际持续天数';
$lang->task->version           = '版本';
$lang->task->assign            = '指派';
$lang->task->assignAction      = '指派任务';
$lang->task->assignTo          = $lang->task->assign;
$lang->task->batchAssignTo     = '批量指派';
$lang->task->assignedTo        = '指派给';
$lang->task->assignedToAB      = '指派给';
$lang->task->assignedDate      = '指派日期';
$lang->task->openedBy          = '由谁创建';
$lang->task->openedDate        = '创建日期';
$lang->task->openedDateAB      = '创建';
$lang->task->finishedBy        = '由谁完成';
$lang->task->finishedByAB      = '完成者';
$lang->task->finishedDate      = '实际完成';
$lang->task->finishedDateAB    = '实际完成';
$lang->task->finishedList      = '完成者列表';
$lang->task->canceledBy        = '由谁取消';
$lang->task->canceledDate      = '取消时间';
$lang->task->closedBy          = '由谁关闭';
$lang->task->closedDate        = '关闭时间';
$lang->task->closedReason      = '关闭原因';
$lang->task->lastEditedBy      = '最后修改';
$lang->task->lastEditedDate    = '最后修改日期';
$lang->task->lastEdited        = '最后编辑';
$lang->task->recordEstimate    = '工时';
$lang->task->editEstimate      = '编辑工时';
$lang->task->deleteEstimate    = '删除工时';
$lang->task->repo              = '所属版本库';
$lang->task->mr                = '合并请求';
$lang->task->entry             = '代码路径';
$lang->task->lines             = '代码行';
$lang->task->v1                = '版本1';
$lang->task->v2                = '版本2';
$lang->task->vision            = '所属界面';
$lang->task->colorTag          = '颜色标签';
$lang->task->files             = '附件';
$lang->task->hasConsumed       = '之前消耗';
$lang->task->multiple          = '多人任务';
$lang->task->multipleAB        = '多人';
$lang->task->team              = '团队';
$lang->task->transfer          = '转交';
$lang->task->transferTo        = '转交给';
$lang->task->children          = '子任务';
$lang->task->childrenAB        = '子';
$lang->task->parent            = '父任务';
$lang->task->parentAB          = '父';
$lang->task->lblPri            = 'P';
$lang->task->lblHour           = '(h)';
$lang->task->lblTestStory      = "测试{$lang->SRCommon}";
$lang->task->teamMember        = '团队成员';

/* Fields of zt_taskestimate. */
$lang->task->task    = '任务';
$lang->task->account = '用户名';
$lang->task->work    = '工作内容';

$lang->task->recordEstimateAction = '添加工时';

$lang->task->ditto             = '同上';
$lang->task->dittoNotice       = "该任务与上一任务不属于同一%s！";
$lang->task->selectTestStory   = "选择测试{$lang->SRCommon}";
$lang->task->selectAllUser     = '全部';
$lang->task->noStory           = "无{$lang->SRCommon}";
$lang->task->noAssigned        = '未指派';
$lang->task->noFinished        = '未完成';
$lang->task->noClosed          = '未关闭';
$lang->task->yesterdayFinished = '昨日完成任务数';
$lang->task->allTasks          = '总任务';
$lang->task->linkMR            = '相关合并请求';

$lang->task->statusList['']       = '';
$lang->task->statusList['wait']   = '未开始';
$lang->task->statusList['doing']  = '进行中';
$lang->task->statusList['done']   = '已完成';
$lang->task->statusList['pause']  = '已暂停';
$lang->task->statusList['cancel'] = '已取消';
$lang->task->statusList['closed'] = '已关闭';

$lang->task->typeList['']        = '';
$lang->task->typeList['design']  = '设计';
$lang->task->typeList['devel']   = '开发';
$lang->task->typeList['request'] = '需求';
$lang->task->typeList['test']    = '测试';
$lang->task->typeList['study']   = '研究';
$lang->task->typeList['discuss'] = '讨论';
$lang->task->typeList['ui']      = '界面';
$lang->task->typeList['affair']  = '事务';
$lang->task->typeList['misc']    = '其他';

$lang->task->priList[0] = '';
$lang->task->priList[1] = '1';
$lang->task->priList[2] = '2';
$lang->task->priList[3] = '3';
$lang->task->priList[4] = '4';

$lang->task->reasonList['']       = '';
$lang->task->reasonList['done']   = '已完成';
$lang->task->reasonList['cancel'] = '已取消';

$lang->task->modeList['linear'] = '串行';
$lang->task->modeList['multi']  = '并行';

$lang->task->afterChoices['continueAdding'] = "继续为该{$lang->SRCommon}添加任务";
$lang->task->afterChoices['toTaskList']     = '返回任务列表';
$lang->task->afterChoices['toStoryList']    = "返回{$lang->SRCommon}列表";

$lang->task->legendBasic  = '基本信息';
$lang->task->legendEffort = '工时信息';
$lang->task->legendLife   = '任务的一生';
$lang->task->legendDesc   = '任务描述';
$lang->task->legendDetail = '任务详情';
$lang->task->legendMisc   = '其他相关';

$lang->task->confirmDelete             = "您确定要删除这个任务吗？";
$lang->task->confirmDeleteEstimate     = "您确定要删除这个记录吗？";
$lang->task->confirmDeleteLastEstimate = "您确定要删除该条日志吗？删除最后一条工时日志后，该任务状态将调整为未开始。";
$lang->task->copyStoryTitle            = "同{$lang->SRCommon}";
$lang->task->afterSubmit               = "添加之后";
$lang->task->successSaved              = "成功添加，";
$lang->task->delayWarning              = " <strong class='text-danger'> 延期%s天 </strong>";
$lang->task->remindBug                 = "该任务为Bug转化得到，是否更新Bug:%s ?";
$lang->task->remindIssue               = "该任务为问题转化得到，是否更新问题:%s ?";
$lang->task->confirmChangeExecution    = "修改{$lang->executionCommon}会导致相应的所属模块、相关{$lang->SRCommon}和指派人发生变化，确定吗？";
$lang->task->confirmFinish             = '"预计剩余"为0，确认将任务状态改为"已完成"吗？';
$lang->task->confirmRecord             = '"剩余"为0，任务将标记为"已完成"，您确定吗？';
$lang->task->confirmTransfer           = '"当前剩余"为0，任务将被转交，您确定吗？';
$lang->task->noticeTaskStart           = '"总计消耗"和"预计剩余"不能同时为0';
$lang->task->noticeLinkStory           = "没有可关联的相关{$lang->SRCommon}，您可以为当前项目%s，然后%s";
$lang->task->noticeSaveRecord          = '您有尚未保存的工时记录，请先将其保存。';
$lang->task->commentActions            = '%s. %s, 由 <strong>%s</strong> 添加备注。';
$lang->task->deniedNotice              = '当前任务只有%s才可以%s。';
$lang->task->noTask                    = '暂时没有任务。';
$lang->task->createDenied              = '你不能在该项目添加任务';
$lang->task->cannotDeleteParent        = '不能删除父任务。';
$lang->task->addChildTask              = '因该任务已经产生消耗，为保证数据一致性，我们会帮您创建一条同名子任务记录该消耗。';

$lang->task->error                    = new stdclass();
$lang->task->error->totalNumber       = '"总计消耗"必须为数字';
$lang->task->error->consumedNumber    = '"本次消耗"必须为数字';
$lang->task->error->estimateNumber    = '"最初预计"必须为数字';
$lang->task->error->recordMinus       = '工时不能为负数';
$lang->task->error->leftNumber        = '"预计剩余"必须为数字';
$lang->task->error->recordMinus       = '工时不能为负数';
$lang->task->error->consumedSmall     = '"总计消耗"必须大于之前消耗';
$lang->task->error->consumedThisTime  = '请填写"工时"';
$lang->task->error->left              = '请填写"剩余"';
$lang->task->error->work              = '"备注"必须小于%d个字符';
$lang->task->error->teamMember        = '团队成员必须不少于2人';
$lang->task->error->skipClose         = '任务：%s 不是“已完成”或“已取消”状态，确定要关闭吗？';
$lang->task->error->closeParent       = '任务：%s 是父任务，父任务在所有子任务关闭后会自动关闭，无法手动关闭。';
$lang->task->error->consumed          = '任务：%s工时不能小于0，忽略该任务工时的改动';
$lang->task->error->assignedTo        = '当前状态的多人任务不能指派给任务团队外的成员。';
$lang->task->error->consumedEmpty     = '总计消耗为0时不能完成任务，请填写本次消耗工时';
$lang->task->error->consumedEmptyAB   = '"本次消耗"为0，请确认是否提交。';
$lang->task->error->deadlineSmall     = '"截止日期"必须大于"预计开始"';
$lang->task->error->alreadyStarted    = '此任务已被启动，不能重复启动！';
$lang->task->error->realStartedEmpty  = '实际开始不能为空';
$lang->task->error->finishedDateEmpty = '实际完成不能为空';
$lang->task->error->finishedDateSmall = '实际完成不能小于实际开始';
$lang->task->error->alreadyConsumed   = '当前选中的父任务已有消耗。';
$lang->task->error->date              = '日期不能大于今天';
$lang->task->error->leftEmptyAB       = '任务状态为%s时，预计剩余不能为0';
$lang->task->error->leftEmpty         = 'Task#%s任务状态为%s时，剩余不能为0';

/* Report. */
$lang->task->report         = new stdclass();
$lang->task->report->common = '报表';
$lang->task->report->select = '请选择报表类型';
$lang->task->report->create = '生成报表';
$lang->task->report->value  = '任务数';

$lang->task->report->charts['tasksPerExecution']    = '按' . $lang->executionCommon . '任务数统计';
$lang->task->report->charts['tasksPerModule']       = '按模块任务数统计';
$lang->task->report->charts['tasksPerAssignedTo']   = '按指派给统计';
$lang->task->report->charts['tasksPerType']         = '按任务类型统计';
$lang->task->report->charts['tasksPerPri']          = '按优先级统计';
$lang->task->report->charts['tasksPerStatus']       = '按任务状态统计';
$lang->task->report->charts['tasksPerDeadline']     = '按截止日期统计';
$lang->task->report->charts['tasksPerEstimate']     = '按预计时间统计';
$lang->task->report->charts['tasksPerLeft']         = '按剩余时间统计';
$lang->task->report->charts['tasksPerConsumed']     = '按消耗时间统计';
$lang->task->report->charts['tasksPerFinishedBy']   = '按由谁完成统计';
$lang->task->report->charts['tasksPerClosedReason'] = '按关闭原因统计';
$lang->task->report->charts['finishedTasksPerDay']  = '按每天完成统计';

$lang->task->report->options         = new stdclass();
$lang->task->report->options->graph  = new stdclass();
$lang->task->report->options->type   = 'pie';
$lang->task->report->options->width  = 500;
$lang->task->report->options->height = 140;

$lang->task->report->tasksPerExecution    = new stdclass();
$lang->task->report->tasksPerModule       = new stdclass();
$lang->task->report->tasksPerAssignedTo   = new stdclass();
$lang->task->report->tasksPerType         = new stdclass();
$lang->task->report->tasksPerPri          = new stdclass();
$lang->task->report->tasksPerStatus       = new stdclass();
$lang->task->report->tasksPerDeadline     = new stdclass();
$lang->task->report->tasksPerEstimate     = new stdclass();
$lang->task->report->tasksPerLeft         = new stdclass();
$lang->task->report->tasksPerConsumed     = new stdclass();
$lang->task->report->tasksPerFinishedBy   = new stdclass();
$lang->task->report->tasksPerClosedReason = new stdclass();
$lang->task->report->finishedTasksPerDay  = new stdclass();

$lang->task->report->tasksPerExecution->item    = $lang->executionCommon;
$lang->task->report->tasksPerModule->item       = '模块';
$lang->task->report->tasksPerAssignedTo->item   = '用户';
$lang->task->report->tasksPerType->item         = '类型';
$lang->task->report->tasksPerPri->item          = '优先级';
$lang->task->report->tasksPerStatus->item       = '状态';
$lang->task->report->tasksPerDeadline->item     = '日期';
$lang->task->report->tasksPerEstimate->item     = '预计';
$lang->task->report->tasksPerLeft->item         = '剩余';
$lang->task->report->tasksPerConsumed->item     = '消耗';
$lang->task->report->tasksPerFinishedBy->item   = '用户';
$lang->task->report->tasksPerClosedReason->item = '原因';
$lang->task->report->finishedTasksPerDay->item  = '日期';

$lang->task->report->tasksPerExecution->graph    = new stdclass();
$lang->task->report->tasksPerModule->graph       = new stdclass();
$lang->task->report->tasksPerAssignedTo->graph   = new stdclass();
$lang->task->report->tasksPerType->graph         = new stdclass();
$lang->task->report->tasksPerPri->graph          = new stdclass();
$lang->task->report->tasksPerStatus->graph       = new stdclass();
$lang->task->report->tasksPerDeadline->graph     = new stdclass();
$lang->task->report->tasksPerEstimate->graph     = new stdclass();
$lang->task->report->tasksPerLeft->graph         = new stdclass();
$lang->task->report->tasksPerConsumed->graph     = new stdclass();
$lang->task->report->tasksPerFinishedBy->graph   = new stdclass();
$lang->task->report->tasksPerClosedReason->graph = new stdclass();
$lang->task->report->finishedTasksPerDay->graph  = new stdclass();

$lang->task->report->tasksPerExecution->graph->xAxisName    = $lang->executionCommon;
$lang->task->report->tasksPerModule->graph->xAxisName       = '模块';
$lang->task->report->tasksPerAssignedTo->graph->xAxisName   = '用户';
$lang->task->report->tasksPerType->graph->xAxisName         = '类型';
$lang->task->report->tasksPerPri->graph->xAxisName          = '优先级';
$lang->task->report->tasksPerStatus->graph->xAxisName       = '状态';
$lang->task->report->tasksPerDeadline->graph->xAxisName     = '日期';
$lang->task->report->tasksPerEstimate->graph->xAxisName     = '时间';
$lang->task->report->tasksPerLeft->graph->xAxisName         = '时间';
$lang->task->report->tasksPerConsumed->graph->xAxisName     = '时间';
$lang->task->report->tasksPerFinishedBy->graph->xAxisName   = '用户';
$lang->task->report->tasksPerClosedReason->graph->xAxisName = '关闭原因';

$lang->task->report->finishedTasksPerDay->type             = 'bar';
$lang->task->report->finishedTasksPerDay->graph->xAxisName = '日期';

$lang->taskestimate           = new stdclass();
$lang->taskestimate->consumed = '工时';

$lang->task->overEsStartDate = '已超出%s计划开始时间，请先修改%s计划开始时间';
$lang->task->overEsEndDate   = '已超出%s计划结束时间，请先修改%s计划结束时间';