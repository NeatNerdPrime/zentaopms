#!/usr/bin/env php
<?php

/**

title=测试 storyModel->updateTwins();
cid=0

- 不传入需求，也不传入产品。 @0
- 传入需求列表，检查twins字段。
 - 属性1 @:2:3:
 - 属性2 @:1:3:
 - 属性3 @:1:2:

*/
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/lib/story.unittest.class.php';

zenData('story')->gen(5);

$storyTest = new storyTest();

r($storyTest->updateTwinsTest(array(), 1)) && p() && e('0'); //不传入需求，也不传入产品。
r($storyTest->updateTwinsTest(array(1 => 1, 2 => 2, 3 => 3), 1)) && p('1,2,3') && e(':2:3:,:1:3:,:1:2:'); //传入需求列表，检查twins字段。
