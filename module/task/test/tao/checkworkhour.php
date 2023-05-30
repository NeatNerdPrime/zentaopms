#!/usr/bin/env php
<?php
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/task.class.php';
su('admin');

/**

title=- 无消耗工时给出提示 @『ID \
timeout=0
cid=1

- 正常完成任务，是否通过检查 @1

- 不在团队中的人维护工时，返回false @0

- 在团队中的人维护工时，返回true @1

- 无消耗工时给出提示 @1

- 剩余不为数字，给出提示 @1

- 消耗不为数字，给出提示 @1

- 以记录工时的形式完成任务 @1

- 正常记录工时 @1

*/
$task = zdTable('task');
$task->id->range('1-7');
$task->execution->range('1-7');
$task->name->prefix("任务")->range('1-7');
$task->left->range('1-7');
$task->mode->range(" , multi, , , , ,");
$task->estStarted->range('2022\-01\-01');
$task->assignedTo->prefix("user")->range('1-7');
$task->status->range("wait,wait,doing,done,pause,cancel,closed");
$task->gen(7);

$taskteam = zdTable('taskteam');
$taskteam->id->range('1-5');
$taskteam->task->range('2');
$taskteam->account->prefix("user")->range('1-5');
$taskteam->estimate->range('5');
$taskteam->consumed->range('0');
$taskteam->left->range('5');
$taskteam->status->range("wait");
$taskteam->gen(5);

$effort = zdTable('effort');
$effort->gen(1);

$user = zdTable('user');
$user->gen(20);

$multiTaskEffort = array();
for($i = 1; $i <= 5; $i++)
{
    $multiTaskEffort[$i] = new stdclass();
    $multiTaskEffort[$i]->consumed = 2;
    $multiTaskEffort[$i]->left     = 1;
    $multiTaskEffort[$i]->work     = "工作内容$i";
    $multiTaskEffort[$i]->date     = "2022-01-01";
}

$finishTaskEffort = array();
$finishTaskEffort[1] = new stdclass();
$finishTaskEffort[1]->consumed = 5;
$finishTaskEffort[1]->left     = 0;
$finishTaskEffort[1]->work     = "完成了任务";
$finishTaskEffort[1]->date     = "2022-01-01";

$startTaskEffort = array();
$startTaskEffort[1] = new stdclass();
$startTaskEffort[1]->consumed = 5;
$startTaskEffort[1]->left     = 5;
$startTaskEffort[1]->work     = "开始了任务";
$startTaskEffort[1]->date     = "2022-01-01";

$normalTaskEffort = array();
$normalTaskEffort[1] = new stdclass();
$normalTaskEffort[1]->consumed = 5;
$normalTaskEffort[1]->left     = 5;
$normalTaskEffort[1]->work     = "记录了日志";
$normalTaskEffort[1]->date     = "2022-01-01";

$noconsumedTaskEffort = array();
$noconsumedTaskEffort[1] = new stdclass();
$noconsumedTaskEffort[1]->consumed = 0;
$noconsumedTaskEffort[1]->left     = 2;
$noconsumedTaskEffort[1]->work     = "无消耗的日志";
$noconsumedTaskEffort[1]->date     = "2022-01-01";

$consumedNotNumTaskEffort = array();
$consumedNotNumTaskEffort[1] = new stdclass();
$consumedNotNumTaskEffort[1]->consumed = 'test';
$consumedNotNumTaskEffort[1]->left     = 2;
$consumedNotNumTaskEffort[1]->work     = "消耗不为数字";
$consumedNotNumTaskEffort[1]->date     = "2022-01-01";

$leftNotNumTaskEffort = array();
$leftNotNumTaskEffort[1] = new stdclass();
$leftNotNumTaskEffort[1]->consumed = 2;
$leftNotNumTaskEffort[1]->left     = 'asd';
$leftNotNumTaskEffort[1]->work     = "剩余不为数字";
$leftNotNumTaskEffort[1]->date     = "2022-01-01";

$task = new taskTest();
r($task->checkWorkhourTest(1, $finishTaskEffort)) && p() && e('1'); // 正常完成任务，是否通过检查

su('admin');
r($task->checkWorkhourTest(2, $multiTaskEffort))  && p() && e('0'); // 不在团队中的人维护工时，返回false

su('user1');
r($task->checkWorkhourTest(2, $multiTaskEffort))  && p() && e('1'); // 在团队中的人维护工时，返回true

r(strpos($task->checkWorkhourTest(3, $noconsumedTaskEffort)[0], "工时』应当大于『0』") !== false)      && p() && e('1'); // 无消耗工时给出提示
r(strpos($task->checkWorkhourTest(4, $leftNotNumTaskEffort)[0], '"预计剩余"必须为数字') !== false)     && p() && e('1'); // 剩余不为数字，给出提示
r(strpos($task->checkWorkhourTest(6, $consumedNotNumTaskEffort)[0], '"总计消耗"必须为数字') !== false) && p() && e('1'); // 消耗不为数字，给出提示
r($task->checkWorkhourTest(5, $finishTaskEffort)) && p() && e('1'); // 以记录工时的形式完成任务
r($task->checkWorkhourTest(7, $normalTaskEffort)) && p() && e('1'); // 正常记录工时