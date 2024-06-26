#!/usr/bin/env php
<?php

/**

title=count_of_monthly_created_task
timeout=0
cid=1

- 测试分组数。 @95
- 测试2014年10月。第0条的value属性 @3
- 测试2014年11月。第0条的value属性 @3
- 测试2017年2月。第0条的value属性 @0
- 测试2017年3月。第0条的value属性 @1
- 测试不存在。 @0

*/
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/lib/calc.unittest.class.php';

zendata('project')->loadYaml('project_close', true, 4)->gen(10);
zendata('project')->loadYaml('execution', true, 4)->gen(20, false);
zendata('task')->loadYaml('task', true, 4)->gen(1000);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

r(count($calc->getResult())) && p('') && e('95'); // 测试分组数。

r($calc->getResult(array('year' => '2014', 'month' => '10'))) && p('0:value') && e('3'); // 测试2014年10月。
r($calc->getResult(array('year' => '2014', 'month' => '11'))) && p('0:value') && e('3'); // 测试2014年11月。
r($calc->getResult(array('year' => '2017', 'month' => '02'))) && p('0:value') && e('0'); // 测试2017年2月。
r($calc->getResult(array('year' => '2017', 'month' => '03'))) && p('0:value') && e('1'); // 测试2017年3月。
r($calc->getResult(array('year' => '2021', 'month' => '04'))) && p('')        && e('0'); // 测试不存在。