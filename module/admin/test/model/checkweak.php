#!/usr/bin/env php
<?php
/**

title=测试 adminModel->checkWeak();
timeout=0
cid=1

- 测试密码使用123456 @1
- 测试密码与用户名相同 @1
- 测试密码与手机相同 @1
- 测试密码与电话相同 @1
- 测试密码与生日相同 @1
- 测试使用复杂密码 @0

*/
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/lib/admin.unittest.class.php';

zenData('user')->loadYaml('user')->gen(6);

global $config;
unset($config->safe->weak); // 防止数据库中设置的弱密码对单元测试造成影响，重置为空。

$admin = new adminTest();
r($admin->checkWeakTest('user1')) && p() && e('1'); //测试密码使用123456
r($admin->checkWeakTest('user2')) && p() && e('1'); //测试密码与用户名相同
r($admin->checkWeakTest('user3')) && p() && e('1'); //测试密码与手机相同
r($admin->checkWeakTest('user4')) && p() && e('1'); //测试密码与电话相同
r($admin->checkWeakTest('user5')) && p() && e('1'); //测试密码与生日相同
r($admin->checkWeakTest('user6')) && p() && e('0'); //测试使用复杂密码
