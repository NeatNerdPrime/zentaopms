#!/usr/bin/env php
<?php

/**

title=测试 fileModel->autoDelete();
cid=0

- 不传入任何数据。 @5
- 自动删除不使用的图片，有使用图片的数据。 @4
- 自动删除不使用的图片，没有使用图片的数据。 @2

*/

include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/lib/file.unittest.class.php';
su('admin');

$file = zenData('file');
$file->pathname->range('a.php');
$file->gen(5);

global $tester, $config;
$file = new fileTest();

$debug = $config->debug;
$config->debug = 0;

$uid = '1234';
$_SESSION['album'][$uid] = array(1, 2, 3);
$_SESSION['album']['used'][$uid] = array(1 => 1, 2 => 2);

r($file->autoDeleteTest(''))   && p() && e(5); //不传入任何数据。
r($file->autoDeleteTest($uid)) && p() && e(4); //自动删除不使用的图片，有使用图片的数据。

$_SESSION['album'][$uid] = array(1, 2, 3);
unset($_SESSION['album']['used']);
r($file->autoDeleteTest($uid)) && p() && e(2); //自动删除不使用的图片，没有使用图片的数据。

$config->debug = $debug;
