#!/usr/bin/env php
<?php
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zdTable('project')->config('project_type', $useCommon = true, $levels = 4)->gen(1000);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

/**

title=count_of_annual_closed_execution
cid=1
pid=1

*/

r(count($calc->getResult())) && p('') && e('10');                        // 测试年度关闭执行分组数。
r($calc->getResult(array('year' => '2017'))) && p('0:value') && e('32'); // 测试2017年关闭执行数
r($calc->getResult(array('year' => '2019'))) && p('0:value') && e('19'); // 测试2019年关闭执行数
r($calc->getResult(array('year' => '2023'))) && p('0:value') && e('0');  // 测试2023年关闭执行数
