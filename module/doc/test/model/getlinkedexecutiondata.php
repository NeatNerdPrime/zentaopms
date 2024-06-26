#!/usr/bin/env php
<?php
/**

title=测试 docModel->getLinkedExecutionData();
cid=1

- 获取系统中关联执行ID=106的数据属性2 @6,16
- 获取系统中关联执行ID=101的数据属性1 @1,11
- 获取系统中关联执行ID=0的数据 @~~
- 获取系统中关联执行ID=106的数量 @4
- 获取系统中关联执行ID=101的数量 @4
- 获取系统中关联执行ID=0的数量 @4

*/

include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/lib/doc.unittest.class.php';

$projectstoryTable = zenData('projectstory');
$projectstoryTable->project->range('101-110');
$projectstoryTable->gen(20);

$taskTable = zenData('task');
$taskTable->execution->range('101-110');
$taskTable->gen(20);

$buildTable = zenData('build');
$buildTable->execution->range('101-110');
$buildTable->gen(20);

zenData('project')->loadYaml('execution')->gen(10);
zenData('user')->gen(5);
su('admin');

$executions = array(0, 101, 106);

$docTester = new docTest();
r($docTester->getLinkedExecutionDataTest($executions[2])) && p('2', ';') && e('6,16'); // 获取系统中关联执行ID=106的数据
r($docTester->getLinkedExecutionDataTest($executions[1])) && p('1', ';') && e('1,11'); // 获取系统中关联执行ID=101的数据
r($docTester->getLinkedExecutionDataTest($executions[0])) && p('0')      && e('~~');   // 获取系统中关联执行ID=0的数据

r(count($docTester->getLinkedExecutionDataTest($executions[2]))) && p() && e('4'); // 获取系统中关联执行ID=106的数量
r(count($docTester->getLinkedExecutionDataTest($executions[1]))) && p() && e('4'); // 获取系统中关联执行ID=101的数量
r(count($docTester->getLinkedExecutionDataTest($executions[0]))) && p() && e('4'); // 获取系统中关联执行ID=0的数量
