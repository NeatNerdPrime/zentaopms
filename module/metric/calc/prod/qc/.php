<?php
/**
 * 按产品统计的参与评审的研发需求评审通过率。
 * .
 *
 * 范围：prod
 * 对象：story
 * 目的：qc
 * 度量名称：按产品统计的参与评审的研发需求评审通过率
 * 单位：%
 * 描述：研发需求评审通过率=评审结果为确认通过的研发需求数/有评审结果的研发需求数
过滤已删除的研发需求
过滤已删除的产品
 * 度量库：
 * 收集方式：realtime
 *
 * @copyright Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @author    qixinzhi <qixinzhi@easycorp.ltd>
 * @package
 * @uses      func
 * @license   ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @Link      https://www.zentao.net
 */
class  extends baseMetric
{
    public $dataset = '';

    public $fieldList = array();

    public $result = array();

    //public funtion getStatement($dao)
    //{
    //}

    //public function calculate($data)
    //{
    //}

    //public function getResult()
    //{
    //}
}