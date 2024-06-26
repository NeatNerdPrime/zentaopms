<?php
/**
 * 按产品统计的已交付研发需求数。
 * Count of delivered story in product.
 *
 * 范围：product
 * 对象：story
 * 目的：scale
 * 度量名称：按产品统计的已交付研发需求数
 * 单位：个
 * 描述：按产品统计的已交付研发需求数表示已交付给用户的研发需求的数量。该度量项反映了产品中已发布或关闭原因为已完成的研发需求的数量，可以用于评估产品的研发需求交付能力。
 * 定义：产品中研发需求个数求和;所处阶段为已发布或关闭原因为已完成;过滤已删除的研发需求;过滤已删除的产品;
 *
 * @copyright Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @author    qixinzhi <qixinzhi@easycorp.ltd>
 * @package
 * @uses      func
 * @license   ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @Link      https://www.zentao.net
 */
class count_of_delivered_story_in_product extends baseCalc
{
    public $dataset = 'getDevStories';

    public $fieldList = array('t1.product', 't1.stage', 't1.closedReason');

    public $result = array();

    public function calculate($row)
    {
        $stage        = $row->stage;
        $product      = $row->product;
        $closedReason = $row->closedReason;

        if($stage != 'released' && $closedReason != 'done') return false;

        if(!isset($this->result[$row->product])) $this->result[$row->product] = 0;
        $this->result[$row->product] += 1;
    }

    public function getResult($options = array())
    {
        $records = $this->getRecords(array('product', 'value'));
        return $this->filterByOptions($records, $options);
    }
}
