#!/usr/bin/env php
<?php
include dirname(__FILE__, 5) . "/test/lib/init.php";
include dirname(__FILE__, 2) . '/execution.class.php';
su('admin');

/**

title=测试 executionModel->getLimitedExecution();
cid=1
pid=1

获取所有受限制的执行ID >> 1

*/

$execution = new executionTest();

r($execution->getLimitedExecutionTest()) && p() && e('1');  // 获取所有受限制的执行ID
