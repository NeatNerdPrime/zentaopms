#!/usr/bin/env php
<?php
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/lib/compile.unittest.class.php';

zenData('compile')->gen(1);
zenData('job')->loadYaml('job')->gen(1);
su('admin');

/**

title=测试 compileModel->getListByJobID();
timeout=0
cid=1

- 检查是否能拿到数据第1条的name属性 @构建1
- 检查传一个不存在的jobid会返回什么 @0

*/

$compile = new compileTest();

r($compile->getListByJobIDTest('1')) && p('1:name') && e('构建1'); //检查是否能拿到数据
r($compile->getListByJobIDTest('3')) && p()         && e('0');     //检查传一个不存在的jobid会返回什么