#!/usr/bin/env php
<?php

/**

title=测试 storyModel->formatStories();
cid=0

- 获取处理title之前的需求列表数量 @2
- 获取处理title之前的需求列表数量 @2
- 获取处理title之前的需求title第2条的title属性 @软件需求2
- 获取处理title之前的需求title第6条的title属性 @软件需求6
- 获取处理title之后的需求列表数量 @2
- 获取处理title之后的需求列表数量 @2
- 获取处理title之后的需求title属性2 @2:软件需求2 (优先级:2,预计工时:2)
- 获取处理title之后的需求title属性6 @6:软件需求6 (优先级:2,预计工时:2)

*/
include dirname(__FILE__, 5) . '/test/lib/init.php';
su('admin');

zenData('product')->gen(10);
$story = zenData('story');
$story->estimate->range('1-4');
$story->product->range('1-100{4}');
$story->gen(20);

global $tester;
$tester->loadModel('story');
$stories1 = $tester->story->getProductStories(1);
$stories2 = $tester->story->getProductStories(2);

$formatStories1 = $tester->story->formatStories($stories1);
$formatStories2 = $tester->story->formatStories($stories2);

r(count($stories1))       && p()          && e('2');                                 // 获取处理title之前的需求列表数量
r(count($stories2))       && p()          && e('2');                                 // 获取处理title之前的需求列表数量
r($stories1)              && p('2:title') && e('软件需求2');                         // 获取处理title之前的需求title
r($stories2)              && p('6:title') && e('软件需求6');                         // 获取处理title之前的需求title
r(count($formatStories1)) && p()          && e('2');                                 // 获取处理title之后的需求列表数量
r(count($formatStories2)) && p()          && e('2');                                 // 获取处理title之后的需求列表数量
r($formatStories1)        && p('2', '|')  && e('2:软件需求2 (优先级:2,预计工时:2)'); // 获取处理title之后的需求title
r($formatStories2)        && p('6', '|')  && e('6:软件需求6 (优先级:2,预计工时:2)'); // 获取处理title之后的需求title
