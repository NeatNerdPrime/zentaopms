#!/usr/bin/env php
<?php
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/execution.class.php';

zdTable('project')->config('execution')->gen(30);
$team = zdTable('team')->config('team');
$team->account->range('admin');
$team->gen(30);

$task = zdTable('task')->config('task');
$task->project->range('11,60,100');
$task->execution->range('101,106,124');
$task->assignedTo->range('admin');
$task->gen(30);

zdTable('projectstory')->gen(0);
zdTable('story')->gen(0);

su('admin');

/**

title=测试executionModel->afterImportTask();
timeout=0
cid=1

*/

$executionIDList  = array(101, 106, 124);
$sprintTasks      = array(1, 3, 5, 10, 13, 19, 22, 28);
$stageTasks       = array(2, 4, 6, 7, 8, 11, 14, 16);
$kanbanTasks      = array(9, 12, 18);
$count            = array(0, 1);

$execution = new executionTest();
r($execution->afterImportTaskTest($executionIDList[0], $count[0], $sprintTasks)) && p('0:root,account') && e('101,admin'); // 敏捷执行导入任务后团队成员信息
r($execution->afterImportTaskTest($executionIDList[1], $count[0], $stageTasks))  && p('0:root,account') && e('106,admin'); // 瀑布执行导入任务后团队成员信息
r($execution->afterImportTaskTest($executionIDList[2], $count[0], $kanbanTasks)) && p('0:root,account') && e('124,admin'); // 看板执行导入任务后团队成员信息
r($execution->afterImportTaskTest($executionIDList[0], $count[1], $sprintTasks)) && p()                 && e('1');         // 敏捷执行导入任务后团队成员的数量
r($execution->afterImportTaskTest($executionIDList[1], $count[1], $stageTasks))  && p()                 && e('1');         // 瀑布执行导入任务后团队成员的数量
r($execution->afterImportTaskTest($executionIDList[2], $count[1], $kanbanTasks)) && p()                 && e('1');         // 看板执行导入任务后团队成员的数量
