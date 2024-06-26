#!/usr/bin/env php
<?php
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/lib/screen.unittest.class.php';

/**

title=测试 screenModel->getByID();
timeout=0
cid=1

- 测试是否能正常处理横坐标为日期，类型为日期，对象类型为bug的情况。
 - 属性2023-11-03 @2023-11-03
 - 属性2023-11-07 @2023-11-07
 - 属性2023-11-13 @2023-11-13
 - 属性2023-11-15 @2023-11-15

*/

$screen = new screenTest();

$xlabel = array('2023-11-03', '2023-11-07', '2023-11-13', '2023-11-15');
$type = 'date';
$object = 'bug';
$field = '日期';

$result = $screen->processXLabelTest($xlabel, $type, $object, $field);

r($result) && p('2023-11-03,2023-11-07,2023-11-13,2023-11-15') && e('2023-11-03,2023-11-07,2023-11-13,2023-11-15');  //测试是否能正常处理横坐标为日期，类型为日期，对象类型为bug的情况。