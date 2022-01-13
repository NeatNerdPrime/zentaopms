<?php
/* Actions. */
$lang->kanban->create              = '创建看板';
$lang->kanban->createSpace         = '创建空间';
$lang->kanban->editSpace           = '设置空间';
$lang->kanban->closeSpace          = '关闭空间';
$lang->kanban->deleteSpace         = '删除空间';
$lang->kanban->sortSpace           = '空间排序';
$lang->kanban->edit                = '看板设置';
$lang->kanban->view                = '查看看板';
$lang->kanban->close               = '关闭看板';
$lang->kanban->delete              = '删除看板';
$lang->kanban->createRegion        = '新增区域';
$lang->kanban->editRegion          = '编辑区域';
$lang->kanban->sortRegion          = '区域排序';
$lang->kanban->sortGroup           = '泳道组排序';
$lang->kanban->deleteRegion        = '删除区域';
$lang->kanban->createLane          = '创建泳道';
$lang->kanban->editLane            = '泳道设置';
$lang->kanban->sortLane            = '泳道排序';
$lang->kanban->laneHeight          = '泳道高度';
$lang->kanban->setLaneHeight       = '设置泳道高度';
$lang->kanban->deleteLane          = '删除泳道';
$lang->kanban->createColumn        = '创建看板列';
$lang->kanban->editColumn          = '编辑看板列';
$lang->kanban->sortColumn          = '看板列排序';
$lang->kanban->deleteColumn        = '删除看板列';
$lang->kanban->createCard          = '创建卡片';
$lang->kanban->editCard            = '编辑卡片';
$lang->kanban->viewCard            = '查看卡片';
$lang->kanban->archiveCard         = '归档卡片';
$lang->kanban->sortCard            = '卡片排序';
$lang->kanban->copyCard            = '复制卡片';
$lang->kanban->moveCard            = '移动卡片';
$lang->kanban->cardColor           = '卡片颜色';
$lang->kanban->setCardColor        = '设置卡片颜色';
$lang->kanban->deleteCard          = '删除卡片';
$lang->kanban->assigntoCard        = '指派';
$lang->kanban->setting             = '设置';
$lang->kanban->splitColumn         = '新增子看板列';
$lang->kanban->createColumnOnLeft  = '左侧新增看板列';
$lang->kanban->createColumnOnRight = '右侧新增看板列';
$lang->kanban->copyColumn          = '复制看板列';
$lang->kanban->archiveColumn       = '归档看板列';
$lang->kanban->spaceCommon         = '看板空间';
$lang->kanban->styleCommon         = '样式';
$lang->kanban->copy                = '复制';
$lang->kanban->custom              = '自定义';
$lang->kanban->archived            = '已归档';
$lang->kanban->viewArchivedCard    = '查看已归档卡片';
$lang->kanban->viewArchivedColumn  = '查看已归档列';
$lang->kanban->archivedColumn      = '已归档的看板列';
$lang->kanban->archivedCard        = '已归档的卡片';
$lang->kanban->restoreColumn       = '还原看板列';
$lang->kanban->restoreCard         = '还原卡片';
$lang->kanban->restore             = '还原';
$lang->kanban->child               = '子';

/* Fields. */
$lang->kanban->space          = '所属空间';
$lang->kanban->name           = '看板名称';
$lang->kanban->archived       = '归档功能';
$lang->kanban->owner          = '负责人';
$lang->kanban->team           = '团队';
$lang->kanban->desc           = '看板描述';
$lang->kanban->acl            = '访问控制';
$lang->kanban->whitelist      = '白名单';
$lang->kanban->status         = '状态';
$lang->kanban->createdBy      = '由谁创建';
$lang->kanban->createdDate    = '创建日期';
$lang->kanban->lastEditedBy   = '最后修改';
$lang->kanban->lastEditedDate = '最后修改日期';
$lang->kanban->closed         = '已关闭';
$lang->kanban->closedBy       = '由谁关闭';
$lang->kanban->closedDate     = '关闭日期';
$lang->kanban->empty          = '暂时没有看板';
$lang->kanban->teamSumCount   = '共%s人';
$lang->kanban->cardCount      = '卡片数量';

$lang->kanban->createColumnOnLeft  = '在左侧添加看板列';
$lang->kanban->createColumnOnRight = '在右侧添加看板列';

$lang->kanban->accessDenied  = '您无权访问该看板';
$lang->kanban->confirmDelete = '您确认删除吗？';
$lang->kanban->cardCountTip  = '请输入卡片数量';

$lang->kanban->aclGroup['open']    = '公开';
$lang->kanban->aclGroup['private'] = '私有';
$lang->kanban->aclGroup['extend']  = '继承空间';

$lang->kanban->aclList['extend']  = '继承空间访问权限（能访问当前空间，即可访问）';
$lang->kanban->aclList['private'] = '私有（看板团队成员、白名单、空间负责人可访问）';

$lang->kanban->enableArchived['0'] = '不启用';
$lang->kanban->enableArchived['1'] = '启用';

$lang->kanban->type = array();
$lang->kanban->type['all']   = "综合看板";
$lang->kanban->type['story'] = "{$lang->SRCommon}看板";
$lang->kanban->type['task']  = "任务看板";
$lang->kanban->type['bug']   = "Bug看板";

$lang->kanban->group = new stdClass();

$lang->kanban->group->all = array();
$lang->kanban->group->story = array();
$lang->kanban->group->story['default']    = "默认方式";
$lang->kanban->group->story['pri']        = "需求优先级";
$lang->kanban->group->story['category']   = "需求类别";
$lang->kanban->group->story['module']     = "需求模块";
$lang->kanban->group->story['source']     = "需求来源";
$lang->kanban->group->story['assignedTo'] = "指派人员";

$lang->kanban->group->task = array();
$lang->kanban->group->task['default']    = "默认方式";
$lang->kanban->group->task['pri']        = "任务优先级";
$lang->kanban->group->task['type']       = "任务类型";
$lang->kanban->group->task['module']     = "任务所属模块";
$lang->kanban->group->task['assignedTo'] = "指派人员";
$lang->kanban->group->task['story']      = "{$lang->SRCommon}";

$lang->kanban->group->bug = array();
$lang->kanban->group->bug['default']    = "默认方式";
$lang->kanban->group->bug['pri']        = "Bug优先级";
$lang->kanban->group->bug['severity']   = "Bug严重程度";
$lang->kanban->group->bug['module']     = "Bug模块";
$lang->kanban->group->bug['type']       = "Bug类型";
$lang->kanban->group->bug['assignedTo'] = "指派人员";

$lang->kanban->WIP                = 'WIP';
$lang->kanban->setWIP             = '在制品设置';
$lang->kanban->WIPStatus          = '在制品状态';
$lang->kanban->WIPStage           = '在制品阶段';
$lang->kanban->WIPType            = '在制品类型';
$lang->kanban->WIPCount           = '在制品数量';
$lang->kanban->noLimit            = '不限制∞';
$lang->kanban->setLane            = '泳道设置';
$lang->kanban->laneName           = '泳道名称';
$lang->kanban->laneColor          = '泳道颜色';
$lang->kanban->setColumn          = '看板列设置';
$lang->kanban->columnName         = '看板列名称';
$lang->kanban->columnColor        = '看板列颜色';
$lang->kanban->noColumnUniqueName = '看板列名称已存在';
$lang->kanban->moveUp             = '泳道上移';
$lang->kanban->moveDown           = '泳道下移';
$lang->kanban->laneMove           = '泳道移动';
$lang->kanban->laneGroup          = '泳道分组';
$lang->kanban->cardsSort          = '卡片排序';
$lang->kanban->more               = '更多';
$lang->kanban->moreAction         = '更多操作';
$lang->kanban->noGroup            = '无';
$lang->kanban->limitExceeded      = '超出在制品限制';
$lang->kanban->fullScreen         = '全屏';
$lang->kanban->setting            = '设置';
$lang->kanban->my                 = '我的看板';
$lang->kanban->other              = '其他';

$lang->kanban->error = new stdclass();
$lang->kanban->error->mustBeInt       = '在制品数量必须是正整数。';
$lang->kanban->error->parentLimitNote = '父列的在制品数量不能小于子列在制品数量之和';
$lang->kanban->error->childLimitNote  = '子列在制品数量之和不能大于父列的在制品数量';

$lang->kanban->defaultColumn = array();
$lang->kanban->defaultColumn['wait']   = '未开始';
$lang->kanban->defaultColumn['doing']  = '进行中';
$lang->kanban->defaultColumn['done']   = '已完成';
$lang->kanban->defaultColumn['closed'] = '已关闭';

$this->lang->kanban->laneTypeList = array();
$this->lang->kanban->laneTypeList['story'] = $lang->SRCommon;
$this->lang->kanban->laneTypeList['bug']   = 'Bug';
$this->lang->kanban->laneTypeList['task']  = '任务';

$lang->kanban->storyColumn = array();
$lang->kanban->storyColumn['backlog']    = 'Backlog';
$lang->kanban->storyColumn['ready']      = '准备好';
$lang->kanban->storyColumn['develop']    = '开发';
$lang->kanban->storyColumn['developing'] = '进行中';
$lang->kanban->storyColumn['developed']  = '完成';
$lang->kanban->storyColumn['test']       = '测试';
$lang->kanban->storyColumn['testing']    = '进行中';
$lang->kanban->storyColumn['tested']     = '完成';
$lang->kanban->storyColumn['verified']   = '已验收';
$lang->kanban->storyColumn['released']   = '已发布';
$lang->kanban->storyColumn['closed']     = '已关闭';

$lang->kanban->bugColumn = array();
$lang->kanban->bugColumn['unconfirmed'] = '待确认';
$lang->kanban->bugColumn['confirmed']   = '已确认';
$lang->kanban->bugColumn['resolving']   = '解决中';
$lang->kanban->bugColumn['fixing']      = '进行中';
$lang->kanban->bugColumn['fixed']       = '完成';
$lang->kanban->bugColumn['test']        = '测试';
$lang->kanban->bugColumn['testing']     = '测试中';
$lang->kanban->bugColumn['tested']      = '测试完毕';
$lang->kanban->bugColumn['closed']      = '已关闭';

$lang->kanban->taskColumn = array();
$lang->kanban->taskColumn['wait']       = '未开始';
$lang->kanban->taskColumn['develop']    = '开发';
$lang->kanban->taskColumn['developing'] = '研发中';
$lang->kanban->taskColumn['developed']  = '研发完毕';
$lang->kanban->taskColumn['pause']      = '已暂停';
$lang->kanban->taskColumn['canceled']   = '已取消';
$lang->kanban->taskColumn['closed']     = '已关闭';

$lang->kanbanspace = new stdclass();
$lang->kanbanspace->common         = '看板空间';
$lang->kanbanspace->name           = '空间名称';
$lang->kanbanspace->owner          = '负责人';
$lang->kanbanspace->team           = '团队';
$lang->kanbanspace->desc           = '空间描述';
$lang->kanbanspace->acl            = '访问控制';
$lang->kanbanspace->whitelist      = '白名单';
$lang->kanbanspace->status         = '状态';
$lang->kanbanspace->createdBy      = '由谁创建';
$lang->kanbanspace->createdDate    = '创建日期';
$lang->kanbanspace->lastEditedBy   = '最后修改';
$lang->kanbanspace->lastEditedDate = '最后修改日期';
$lang->kanbanspace->closedBy       = '由谁关闭';
$lang->kanbanspace->closedDate     = '关闭日期';

$lang->kanbanspace->empty = '暂时没有空间';

$lang->kanbanspace->aclList['open']    = '公开（有看板空间视图权限即可访问）';
$lang->kanbanspace->aclList['private'] = '私有（只有看板空间负责人、团队成员、白名单可访问）';

$lang->kanbanspace->featureBar['all']    = '所有';
$lang->kanbanspace->featureBar['my']     = '我的空间';
$lang->kanbanspace->featureBar['other']  = '其他空间';
$lang->kanbanspace->featureBar['closed'] = '已关闭';

$lang->kanbancolumn = new stdclass();
$lang->kanbancolumn->name       = $lang->kanban->columnName;
$lang->kanbancolumn->limit      = $lang->kanban->WIPCount;
$lang->kanbancolumn->color      = '看板列颜色';
$lang->kanbancolumn->childName  = '子列名称';
$lang->kanbancolumn->childColor = '子状态颜色';
$lang->kanbancolumn->empty      = '暂时没有看板列';

$lang->kanbancolumn->confirmArchive = '您确认归档该列吗？归档列后，该列和列中所有卡片将被隐藏，您可以在区域-已归档中查看已归档的列。';
$lang->kanbancolumn->confirmDelete  = '您确认删除该列吗？删除列后，该列中所有卡片也会被删除。';
$lang->kanbancolumn->confirmRestore = '您确定要还原该看板列吗？还原看板列后，该看板列和看板列中所有的任务将同时还原到之前的位置。';

$lang->kanbanlane = new stdclass();
$lang->kanbanlane->name      = $lang->kanban->laneName;
$lang->kanbanlane->common    = '泳道';
$lang->kanbanlane->default   = '默认泳道';
$lang->kanbanlane->column    = '泳道看板列';
$lang->kanbanlane->otherlane = '选择共享看板列的泳道';
$lang->kanbanlane->color     = '泳道颜色';
$lang->kanbanlane->WIPType   = '泳道在制品类型';

$lang->kanbanlane->confirmDelete    = '您确认删除该泳道吗？删除泳道后，该泳道中所有数据（列、卡片）也会被删除。';
$lang->kanbanlane->confirmDeleteTip = '您确认删除该泳道吗？删除泳道后，该泳道中所有的%s将被隐藏。';

$lang->kanbanlane->modeList['sameAsOther'] = '与其他泳道使用相同看板列';
$lang->kanbanlane->modeList['independent'] = '采用独立的看板列';

$lang->kanbanlane->heightTypeList['auto']   = '自适应（根据卡片高度自适应）';
$lang->kanbanlane->heightTypeList['custom'] = '自定义（根据卡片数量自定义泳道高度）';

$lang->kanbanlane->error = new stdclass();
$lang->kanbanlane->error->mustBeInt = '卡片数量必须是大于2的正整数。';

$lang->kanbanregion = new stdclass();
$lang->kanbanregion->name    = '区域名称';
$lang->kanbanregion->default = '默认区域';
$lang->kanbanregion->style   = '区域样式';

$lang->kanbanregion->confirmDelete = '您确认删除该区域吗？删除该区域后，该区域中所有数据将会被删除。';

$lang->kanbancard = new stdclass();
$lang->kanbancard->create  = '创建卡片';
$lang->kanbancard->edit    = '编辑卡片';
$lang->kanbancard->view    = '查看卡片';
$lang->kanbancard->archive = '归档';
$lang->kanbancard->assign  = '指派';
$lang->kanbancard->copy    = '复制';
$lang->kanbancard->delete  = '删除';

$lang->kanbancard->name            = '卡片名称';
$lang->kanbancard->legendBasicInfo = '基本信息';
$lang->kanbancard->legendLifeTime  = '卡片的一生';
$lang->kanbancard->space           = '所属空间';
$lang->kanbancard->kanban          = '所属看板';
$lang->kanbancard->lane            = '所属泳道';
$lang->kanbancard->column          = '所属看板列';
$lang->kanbancard->assignedTo      = '指派给';
$lang->kanbancard->beginAndEnd     = '起止日期';
$lang->kanbancard->begin           = '预计开始';
$lang->kanbancard->end             = '截止日期';
$lang->kanbancard->pri             = '优先级';
$lang->kanbancard->desc            = '描述';
$lang->kanbancard->estimate        = '预计';
$lang->kanbancard->createdBy       = '由谁创建';
$lang->kanbancard->createdDate     = '由谁创建';
$lang->kanbancard->lastEditedBy    = '由谁编辑';
$lang->kanbancard->lastEditedDate  = '最后编辑时间';
$lang->kanbancard->archivedBy      = '由谁归档';
$lang->kanbancard->archivedDate    = '归档时间';
$lang->kanbancard->lblHour         = 'h';
$lang->kanbancard->noAssigned      = '未指派';
$lang->kanbancard->deadlineAB      = '截止';
$lang->kanbancard->beginAB         = '开始';
$lang->kanbancard->to              = '~';
$lang->kanbancard->archived        = '已归档';
$lang->kanbancard->empty           = '暂时没有卡片';

$lang->kanbancard->confirmArchive    = '您确认归档该卡片吗？归档卡片后，该卡片将从列中隐藏，您可以在区域-已归档中查看。';
$lang->kanbancard->confirmDelete     = '您确认删除该卡片吗？删除卡片后，该卡片将从看板中删除，您只能通过系统回收站查看。';
$lang->kanbancard->confirmRestore    = '您确定要还原该卡片吗？还原卡片后，该卡片将还原到“%s”看板列中。';
$lang->kanbancard->confirmRestoreTip = '该卡片所属的看板列已被归档或删除，请先还原“%s”看板列。';

$lang->kanbancard->priList[1] = 1;
$lang->kanbancard->priList[2] = 2;
$lang->kanbancard->priList[3] = 3;
$lang->kanbancard->priList[4] = 4;

$lang->kanbancard->colorList['#fff']    = '默认';
$lang->kanbancard->colorList['#b10b0b'] = '阻塞';
$lang->kanbancard->colorList['#cfa227'] = '警告';
$lang->kanbancard->colorList['#2a5f29'] = '加急';

$lang->kanbancard->error = new stdClass();
$lang->kanbancard->error->recordMinus = '预计不能为负数!';
$lang->kanbancard->error->endSmall    = '"截止日期"不能小于"预计开始"!';
