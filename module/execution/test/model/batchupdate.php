#!/usr/bin/env php
<?php
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/lib/execution.unittest.class.php';
zenData('user')->gen(5);
su('admin');

$execution = zenData('project');
$execution->id->range('1-5');
$execution->name->range('项目集1,项目1,迭代1,阶段1,看板1');
$execution->type->range('program,project,sprint,stage,kanban');
$execution->model->range('{1},scrum,{3}');
$execution->parent->range('0,1,2{3}');
$execution->status->range('wait{3},suspended,closed,doing');
$execution->openedBy->range('admin,user1');
$execution->begin->range('20220112 000000:0')->type('timestamp')->format('YY/MM/DD');
$execution->end->range('20220212 000000:0')->type('timestamp')->format('YY/MM/DD');
$execution->gen(5);

/**

title=测试executionModel->batchUpdate();
cid=1
pid=1

测试批量修改任务 >> name,迭代1,批量修改执行一
测试name为空 >> 『执行名称』不能为空。

*/

$executionID = '3';
$name        = array($executionID => '批量修改执行一');
$code        = array($executionID => '批量修改执行一code');
$pms         = array($executionID => 'outside100');
$lifetimes   = array($executionID => 'short');
$statuses    = array($executionID => 'doing');
$days        = array($executionID => '5');

$normal  = array('name' => $name, 'status'=> $statuses, 'code' => $code, 'PM' => $pms, 'lifetime' => $lifetimes, 'days' => $days);
$noName  = array('status'=> $statuses, 'code' => $code, 'PM' => $pms, 'lifetime' => $lifetimes, 'days' => $days);

$execution = new executionTest();
r($execution->batchUpdateObject($normal, $executionID))  && p('0:field,old,new') && e('name,迭代1,批量修改执行一'); // 测试批量修改任务
r($execution->batchUpdateObject($noName, $executionID))  && p('name:0')          && e('~f:名称』不能为空。$~');     // 测试name为空
