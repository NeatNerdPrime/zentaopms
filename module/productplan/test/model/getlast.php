#!/usr/bin/env php
<?php
/**

title=productpanModel->getLast();
timeout=0
cid=1

*/
include dirname(__FILE__, 5) . '/test/lib/init.php';
include dirname(__FILE__, 2) . '/productplan.class.php';

zdTable('productplan')->config('productplan')->gen(6);

$productIdList = array(1, 2, 100);
$branchIdList  = array('', '1');
$parentList    = array(0, 1);

global $tester;
$tester->loadModel('productplan');
r($tester->productplan->getLast($productIdList[0], $branchIdList[0], $parentList[0])) && p('title') && e('计划3'); //获取产品1的最后一个创建的计划
r($tester->productplan->getLast($productIdList[1], $branchIdList[0], $parentList[0])) && p('title') && e('计划4'); //获取产品2的最后一个创建的计划
r($tester->productplan->getLast($productIdList[2], $branchIdList[0], $parentList[0])) && p('title') && e('0');     //获取不存在产品的最后一个创建的计划
r($tester->productplan->getLast($productIdList[0], $branchIdList[1], $parentList[0])) && p('title') && e('0');     //获取产品1下分支1的最后一个创建的计划
r($tester->productplan->getLast($productIdList[1], $branchIdList[1], $parentList[0])) && p('title') && e('0');     //获取产品2下分支1的最后一个创建的计划
r($tester->productplan->getLast($productIdList[2], $branchIdList[1], $parentList[0])) && p('title') && e('0');     //获取不存在产品下分支1的最后一个创建的计划
r($tester->productplan->getLast($productIdList[0], $branchIdList[0], $parentList[1])) && p('title') && e('计划2'); //获取产品1下父计划为计划1的最后一个创建的计划
r($tester->productplan->getLast($productIdList[1], $branchIdList[0], $parentList[1])) && p('title') && e('0');     //获取产品2下父计划为计划1的最后一个创建的计划
r($tester->productplan->getLast($productIdList[2], $branchIdList[0], $parentList[1])) && p('title') && e('0');     //获取不存在产品下父计划为计划1的最后一个创建的计划
