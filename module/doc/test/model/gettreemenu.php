#!/usr/bin/env php
<?php
include dirname(__FILE__, 5) . "/test/lib/init.php";
include dirname(__FILE__, 2) . '/doc.class.php';
su('admin');

/**

title=测试 docModel->getTreeMenu();
cid=1
pid=1



*/

$doc = new docTest();

r($doc->getTreeMenuTest()) && p() && e();