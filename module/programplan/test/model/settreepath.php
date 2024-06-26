#!/usr/bin/env php
<?php

/**

title=测试 programplanModel->setTreePath();
cid=0

- 给stageID=2没有子阶段不走if设置path,grade
 - 属性path @,1,2,
 - 属性grade @ 1
- 给stageID=9有子阶段走if设置path,grade
 - 属性path @,7,8,9,
 - 属性grade @ 3

*/
include dirname(__FILE__, 5) . '/test/lib/init.php';
su('admin');

zenData('project')->loadYaml('project')->gen(10);

global $tester;
$tester->loadModel('programplan');

$tester->programplan->setTreePath(2);
$tester->programplan->setTreePath(9);

r($tester->programplan->getByID(2)) && p('path|grade', '|') && e(',1,2,| 1');   // 给stageID=2没有子阶段不走if设置path,grade
r($tester->programplan->getByID(9)) && p('path|grade', '|') && e(',7,8,9,| 3'); // 给stageID=9有子阶段走if设置path,grade
