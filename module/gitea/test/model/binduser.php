#!/usr/bin/env php
<?php

/**

title=测试 giteaModel::bindUser();
timeout=0
cid=1

- 用户列表为空 @0
- 用户列表不为空
 - 第0条的account属性 @user1
 - 第2条的account属性 @user3
- 用户列表不为空，但有重复 @不能重复绑定用户 用户1
- 用户列表不为空，且绑定关系发生变化
 - 第0条的account属性 @user1
 - 第2条的account属性 @user4
- 用户列表不为空，且删除了一个用户绑定
 - 第0条的account属性 @user1
 - 第1条的account属性 @user4

*/
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/lib/gitea.unittest.class.php';

zenData('user')->gen(10);
zenData('oauth')->loadYaml('oauth')->gen(10);
su('admin');

$gitea = new giteaTest();

$userList = array();
r($gitea->bindUserTester($userList)) && p() && e('0'); // 用户列表为空

$userList = array(
    1 => 'user1',
    2 => 'user2',
    3 => 'user3',
);
r($gitea->bindUserTester($userList)) && p('0:account;2:account') && e('user1,user3'); // 用户列表不为空

$userList[3] = 'user1';
r($gitea->bindUserTester($userList)) && p() && e('不能重复绑定用户 用户1'); // 用户列表不为空，但有重复

$userList[3] = 'user4';
r($gitea->bindUserTester($userList)) && p('0:account;2:account') && e('user1,user4'); // 用户列表不为空，且绑定关系发生变化

$userList[2] = '';
r($gitea->bindUserTester($userList)) && p('0:account;1:account') && e('user1,user4'); // 用户列表不为空，且删除了一个用户绑定