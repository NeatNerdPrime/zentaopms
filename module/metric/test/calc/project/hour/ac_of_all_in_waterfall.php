#!/usr/bin/env php
<?php
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zdTable('project')->config('waterfall', $useCommon = true, $levels = 4)->gen(10);
zdTable('project')->config('stage', $useCommon = true, $levels = 4)->gen(40, false);
zdTable('effort')->config('effort', $useCommon = true, $levels = 4)->gen(1000);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

/**

title=ac_of_all_in_waterfall
cid=1
pid=1

*/

r(count($calc->getResult())) && p('') && e('5'); // 测试分组数。

r($calc->getResult(array('project' => '7'))) && p('0:value') && e('209'); // 测试项目7。
