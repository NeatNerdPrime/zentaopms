#!/usr/bin/env php
<?php

/**

title=rate_of_finished_story_in_project
timeout=0
cid=1

- 测试分组数。 @6
- 测试项目2。第0条的value属性 @0.25

*/
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zendata('product')->loadYaml('product', true, 4)->gen(10);
zendata('project')->loadYaml('project_close', true, 4)->gen(10);
zendata('story')->loadYaml('story_status_closedreason', true, 4)->gen(1000);
zendata('projectstory')->loadYaml('projectstory', true, 4)->gen(1000);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

r(count($calc->getResult())) && p('') && e('6'); // 测试分组数。

r($calc->getResult(array('project' => '4'))) && p('0:value') && e('0.25');  // 测试项目2。