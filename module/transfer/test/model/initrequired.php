#!/usr/bin/env php
<?php
include dirname(__FILE__, 5) . '/test/lib/init.php';

su('admin');

/**

title=测试 transfer->initRequired();
timeout=0
cid=1

- 测试Task模块execution字段是否必填 @1
- 测试获取bug模块title字段是否必填 @1
- 测试获取bug模块desc字段是否必填 @0
- 测试当字段不存时 @0
- 当field为空时 @0

*/
global $tester;
$transfer = $tester->loadModel('transfer');

r($transfer->initRequired('task', 'execution')) && p('') && e('1'); // 测试Task模块execution字段是否必填
r($transfer->initRequired('bug',  'title'))     && p('') && e('1'); // 测试获取bug模块title字段是否必填
r($transfer->initRequired('bug',  'desc'))      && p('') && e('0'); // 测试获取bug模块desc字段是否必填
r($transfer->initRequired('task', 'notIsset'))  && p('') && e('0'); // 测试当字段不存时
r($transfer->initRequired('task', ''))          && p('') && e('0'); // 当field为空时
