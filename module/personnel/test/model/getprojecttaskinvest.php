#!/usr/bin/env php
<?php
declare(strict_types=1);
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/lib/personnel.unittest.class.php';

zenData('project')->gen(50);
zenData('task')->gen(50);
zenData('team')->gen(50);
zenData('user')->gen(20);
zenData('effort')->gen(50);


/**

title=测试 personnelModel->getProjectTaskInvest();
cid=1
pid=1

*/

$personnel = new personnelTest('admin');

$projectID = array(array(11, 12), array(1000));

$account = array('admin' => 'admin', 'user1' => 'user1');

$result1 = $personnel->getProjectTaskInvestTest($projectID[0], $account);
$result2 = $personnel->getProjectTaskInvestTest($projectID[1], $account);

r($result1) && p('admin:createdTask,finishedTask,pendingTask,leftTask,consumedTask')  && e('2,0,0,0,1'); // 测试获取 admin 在项目 11 12 的 创建任务
r($result1) && p('user1:createdTask,finishedTask,pendingTask,leftTask,consumedTask')  && e('0,0,0,0,0'); // 测试获取 user1 在项目 11 12 的 创建任务

r($result2) && p('admin:createdTask,finishedTask,pendingTask,leftTask,consumedTask')  && e('0,0,0,0,0'); // 测试获取 admin 在 不存在的 项目的 创建任务
r($result2) && p('user1:createdTask,finishedTask,pendingTask,leftTask,consumedTask')  && e('0,0,0,0,0'); // 测试获取 user1 在 不存在的 项目的 创建任务
