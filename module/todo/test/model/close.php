#!/usr/bin/env php
<?php
declare(strict_types=1);

include dirname(__FILE__, 5) . "/test/lib/init.php";
su('admin');

/**
title=测试关闭待办 todoModel::close();
cid=1
*/

global $tester;
$tester->loadModel('todo');

zdTable('todo')->config('close')->gen(1);

r($tester->todo->getByID(1)) && p('status') && e('wait');   // 判断生成的待办的状态是等待状态
r($tester->todo->close(1))   && p()         && e(1);        // 关闭这个待办
r($tester->todo->getByID(1)) && p('status') && e('closed'); // 判断关闭了的待办的状态是关闭状态

r($tester->todo->close(1))   && p()         && e(1);        // 测试关闭已经关闭了的待办
r($tester->todo->getByID(1)) && p('status') && e('closed'); // 判断关闭了待办的状态是关闭状态
