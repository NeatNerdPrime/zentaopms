#!/usr/bin/env php
<?php

/**

title=测试 userModel->create();
cid=0

- 使用系统预留用户名，返回 false。属性result @0
- 使用系统预留用户名，提示错误信息。第errors条的account属性 @用户名已被系统预留
- 密码为空，返回 false。属性result @0
- 密码为空，提示错误信息。第errors条的password1属性 @『密码』不能为空。
- 密码长度不够，返回 false。属性result @0
- 密码长度不够，提示错误信息。第errors条的password1属性 @密码须6位及以上。
- 两次密码不同，返回 false。属性result @0
- 两次密码不同，提示错误信息。第errors条的password1属性 @两次密码应该相同。
- 当前用户登录密码不正确，返回 false。属性result @0
- 当前用户登录密码不正确，提示错误信息。第errors条的verifyPassword属性 @验证失败，请检查您的系统登录密码是否正确
- 创建外部公司，公司名称为空，返回 false。属性result @0
- 创建外部公司，公司名称为空，提示错误信息。第errors条的newCompany属性 @『所属公司』不能为空。
- 创建外部公司，公司名称不为空，返回创建的用户 id。属性result @2
- 创建外部公司，公司名称不为空，没有错误信息。第errors条的newCompany属性 @~~
- 必填项为空，返回 false。属性result @0
- 用户名为空，提示错误信息。第errors条的account属性 @『用户名』不能为空。
- 姓名为空，提示错误信息。第errors条的realname属性 @『姓名』不能为空。
- 密码为空，提示错误信息。第errors条的password属性 @『密码』不能为空。
- 界面类型为空，提示错误信息。第errors条的visions属性 @『界面类型』不能为空。
- 用户名重复，返回 false。属性result @0
- 用户名重复，提示错误信息。第errors条的account属性 @『用户名』已经有『user1』这条记录了。如果您确定该记录已删除，请到后台-系统设置-回收站还原。
- 用户名不符合格式要求，返回 false。属性result @0
- 用户名不符合格式要求，提示错误信息。第errors条的account属性 @『用户名』只能是字母、数字或下划线的组合三位以上。
- 邮箱不符合格式要求，返回 false。属性result @0
- 邮箱不符合格式要求，提示错误信息。第errors条的email属性 @『邮箱』应当为合法的EMAIL。
- 字段不符合数据库设置，返回 false。属性result @0
- 字符串字段长度超过数据库设置，提示错误信息。第errors条的type属性 @『用户类型』长度应当不超过『30』，且大于『0』。
- 数字字段类型不符合数据库设置，提示错误信息。第errors条的company属性 @『所属公司』应当是数字。
- 日期字段类型不符合数据库设置，提示错误信息。第errors条的join属性 @『入职日期』应当为合法的日期。
- 枚举字段类型不符合数据库设置，提示错误信息。第errors条的gender属性 @『性别』不符合格式，应当为:『/f|m/』。
- 创建外部公司成功，用户名重复，返回 false。属性result @0
- 创建外部公司成功，用户名重复，提示错误信息。第errors条的account属性 @『用户名』已经有『user1』这条记录了。如果您确定该记录已删除，请到后台-系统设置-回收站还原。
- 事务回滚成功，没有创建公司。 @0
- 创建用户成功，返回创建的用户 id。属性result @3
- 创建用户成功，没有错误信息。第errors条的account属性 @~~
- 生成用户权限组成功，返回 2 条记录。 @2
- 第 1 条记录的用户名是 user2，权限组 id 是 1。
 - 第0条的account属性 @user2
 - 第0条的group属性 @1
- 第 2 条记录的用户名是 user2，权限组 id 是 2。
 - 第1条的account属性 @user2
 - 第1条的group属性 @2
- 创建日志成功，最后一条日志的对象类型是 user，对象 id 是 3，操作是 created。
 - 属性objectType @user
 - 属性objectID @3
 - 属性action @created
- 事务提交成功，能查询到创建的用户。
 - 属性id @3
 - 属性account @user2

*/
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/lib/user.unittest.class.php';

zenData('user')->gen(1);
zenData('company')->gen(1);
zenData('usergroup')->gen(0);

su('admin');

global $app;

/* 安全配置相关功能在 checkPassword 单元测试用例中有详细测试，此处重置为默认值以减少对当前用例的影响。*/
unset($config->safe->mode);
unset($config->safe->weak);

$random   = updateSessionRandom();
$password = md5('123456');
$verify   = md5($app->user->password . $random);

$template = new stdclass();
$template->type             = 'inside';
$template->account          = 'user1';
$template->realname         = 'user1';
$template->password         = $password;
$template->password1        = $password;
$template->password2        = $password;
$template->visions          = 'rnd';
$template->company          = 0;
$template->dept             = 0;
$template->new              = 0;
$template->newCompany       = '';
$template->join             = null;
$template->role             = '';
$template->group            = array();
$template->email            = '';
$template->commiter         = '';
$template->gender           = 'm';
$template->verifyPassword   = $verify;
$template->passwordLength   = 6;
$template->passwordStrength = 0;

$userTest = new userTest();

/* 检测系统预留用户名。*/
$user1 = clone $template;
$user1->account = 'guest';
$result = $userTest->createTest($user1);
r($result) && p('result')           && e(0);                    // 使用系统预留用户名，返回 false。
r($result) && p('errors:account')   && e('用户名已被系统预留'); // 使用系统预留用户名，提示错误信息。

/* 检测密码是否为空。*/
$user2 = clone $template;
$user2->password1 = '';
$result = $userTest->createTest($user2);
r($result) && p('result')           && e(0);                    // 密码为空，返回 false。
r($result) && p('errors:password1') && e('『密码』不能为空。'); // 密码为空，提示错误信息。

/* 检测密码长度。*/
$user3 = clone $template;
$user3->password1      = $password;
$user3->passwordLength = 5;
$result = $userTest->createTest($user3);
r($result) && p('result')           && e(0);                   // 密码长度不够，返回 false。
r($result) && p('errors:password1') && e('密码须6位及以上。'); // 密码长度不够，提示错误信息。

/* 检测两次密码是否相同。*/
$user4 = clone $template;
$user4->password2      = '';
$user4->passwordLength = 6;
$result = $userTest->createTest($user4);
r($result) && p('result')           && e(0);                    // 两次密码不同，返回 false。
r($result) && p('errors:password1') && e('两次密码应该相同。'); // 两次密码不同，提示错误信息。

/* 检测当前用户登录密码。*/
$user5 = clone $template;
$user5->verifyPassword = '';
$result = $userTest->createTest($user5);
r($result) && p('result')                && e(0);                                          // 当前用户登录密码不正确，返回 false。
r($result) && p('errors:verifyPassword') && e('验证失败，请检查您的系统登录密码是否正确'); // 当前用户登录密码不正确，提示错误信息。

/* 检测创建外部公司。*/
$user6 = clone $template;
$user6->type = 'outside';
$user6->new  = 1;
$result = $userTest->createTest($user6);
r($result) && p('result')            && e(0);                        // 创建外部公司，公司名称为空，返回 false。
r($result) && p('errors:newCompany') && e('『所属公司』不能为空。'); // 创建外部公司，公司名称为空，提示错误信息。

$user6->newCompany = 'newCompany';
$result = $userTest->createTest($user6);
r($result) && p('result')            && e(2);    // 创建外部公司，公司名称不为空，返回创建的用户 id。
r($result) && p('errors:newCompany') && e('~~'); // 创建外部公司，公司名称不为空，没有错误信息。

/* 检测必填项。*/
$user7 = clone $template;
$user7->account  = '';
$user7->realname = '';
$user7->password = '';
$user7->visions  = '';
$result = $userTest->createTest($user7);
r($result) && p('result')          && e(0);                        // 必填项为空，返回 false。
r($result) && p('errors:account')  && e('『用户名』不能为空。');   // 用户名为空，提示错误信息。
r($result) && p('errors:realname') && e('『姓名』不能为空。');     // 姓名为空，提示错误信息。
r($result) && p('errors:password') && e('『密码』不能为空。');     // 密码为空，提示错误信息。
r($result) && p('errors:visions')  && e('『界面类型』不能为空。'); // 界面类型为空，提示错误信息。

/* 检测用户名唯一性。*/
$user8 = clone $template;
$result = $userTest->createTest($user8);
r($result) && p('result')         && e(0);                                                                                             // 用户名重复，返回 false。
r($result) && p('errors:account') && e('『用户名』已经有『user1』这条记录了。如果您确定该记录已删除，请到后台-系统设置-回收站还原。'); // 用户名重复，提示错误信息。

/* 检测用户名是否符合格式要求。*/
$user9 = clone $template;
$user9->account = 'user 8';
$result = $userTest->createTest($user9);
r($result) && p('result')         && e(0);                                                    // 用户名不符合格式要求，返回 false。
r($result) && p('errors:account') && e('『用户名』只能是字母、数字或下划线的组合三位以上。'); // 用户名不符合格式要求，提示错误信息。

/* 检测邮箱是否符合格式要求。*/
$user10 = clone $template;
$user10->email = 'email@';
$result = $userTest->createTest($user10);
r($result) && p('result')       && e(0);                             // 邮箱不符合格式要求，返回 false。
r($result) && p('errors:email') && e('『邮箱』应当为合法的EMAIL。'); // 邮箱不符合格式要求，提示错误信息。

/* 检测字段是否符合数据库设置。*/
$user11 = clone $template;
$user11->type    = '这是一个很长的用户类型。到底有多长呢？长到超出了数据库设置的长度。';
$user11->company = 'company';
$user11->join    = 'join';
$user11->gender  = 'gender';
$result = $userTest->createTest($user11);
r($result) && p('result')         && e(0);                                                 // 字段不符合数据库设置，返回 false。
r($result) && p('errors:type')    && e('『用户类型』长度应当不超过『30』，且大于『0』。'); // 字符串字段长度超过数据库设置，提示错误信息。
r($result) && p('errors:company') && e('『所属公司』应当是数字。');                        // 数字字段类型不符合数据库设置，提示错误信息。
r($result) && p('errors:join')    && e('『入职日期』应当为合法的日期。');                  // 日期字段类型不符合数据库设置，提示错误信息。
r($result) && p('errors:gender')  && e('『性别』不符合格式，应当为:『/f|m/』。');          // 枚举字段类型不符合数据库设置，提示错误信息。

/* 检查事务回滚功能。*/
$user12 = clone $template;
$user12->type       = 'outside';
$user12->new        = 1;
$user12->newCompany = 'newCompany2';
$result = $userTest->createTest($user12);
r($result) && p('result')         && e(0);                                                                                             // 创建外部公司成功，用户名重复，返回 false。
r($result) && p('errors:account') && e('『用户名』已经有『user1』这条记录了。如果您确定该记录已删除，请到后台-系统设置-回收站还原。'); // 创建外部公司成功，用户名重复，提示错误信息。

$company = $tester->dao->select('*')->from(TABLE_COMPANY)->where('name')->eq($user11->newCompany)->fetch();
r($company) && p() && e(0); // 事务回滚成功，没有创建公司。

/* 检查生成用户权限组。*/
$users13 = clone $template;
$users13->account = 'user2';
$users13->group   = array(0, 1, 2);
$result = $userTest->createTest($users13);
r($result) && p('result')         && e(3);    // 创建用户成功，返回创建的用户 id。
r($result) && p('errors:account') && e('~~'); // 创建用户成功，没有错误信息。

$groups = $tester->dao->select('*')->from(TABLE_USERGROUP)->fetchAll();
r(count($groups)) && p()                  && e(2);         // 生成用户权限组成功，返回 2 条记录。
r($groups)        && p('0:account,group') && e('user2,1'); // 第 1 条记录的用户名是 user2，权限组 id 是 1。
r($groups)        && p('1:account,group') && e('user2,2'); // 第 2 条记录的用户名是 user2，权限组 id 是 2。

/* 检查生成用户视图。*/
// TODO：computeUserView() 单元测试完成后，补充此处的测试代码。

/* 检查是否创建日志。*/
$action = $tester->dao->select('*')->from(TABLE_ACTION)->orderBy('id_desc')->limit(1)->fetch();
r($action) && p('objectType,objectID,action') && e('user,3,created'); // 创建日志成功，最后一条日志的对象类型是 user，对象 id 是 3，操作是 created。

/* 检查事务提交功能。*/
$user = $userTest->getByIdTest('user2');
r($user) && p('id,account') && e('3,user2'); // 事务提交成功，能查询到创建的用户。
