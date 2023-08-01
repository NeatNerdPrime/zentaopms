<?php
/**
 * 按产品统计的研发完成的研发需求数。
 * Count of developed story in product.
 *
 * 范围：product
 * 对象：story
 * 目的：scale
 * 度量名称：按产品统计的研发完成的研发需求数
 * 单位：个
 * 描述：按产品统计的研发完成的研发需求数是指产品中研发完成的研发需求的数量。这个度量项可以反映产品在开发过程中的进展和成就。研发完成的研发需求数越多，说明产品团队在该时间段内取得了更多的研发成果。
 * 定义：产品中所处阶段为研发完毕、测试中、测试完毕、已验收、已发布和关闭原因为已完成的研发需求个数求和;过滤已删除的研发需求;过滤已删除的产品;
 * 度量库：
 * 收集方式：realtime
 *
 * @copyright Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @author    zhouxin <zhouxin@easycorp.ltd>
 * @package
 * @uses      func
 * @license   ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @Link      https://www.zentao.net
 */
class count_of_developed_story_in_product extends baseCalc
{
    public function getStatement()
    {
        return $this->dao->select('t1.product,count(t1.id) as value')->from(TABLE_STORY)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.shadow')->eq(0)
            ->andWhere('t1.type')->eq('story')
            ->andWhere('t1.stage', true)->in('developed,testing,tested,verified,released')
            ->orWhere('t1.closedReason')->eq('done')
            ->markRight(1)
            ->groupBy('t1.product')
            ->query();
    }

    public function calculate($row)
    {
        if(!isset($this->result[$row->product])) $this->result[$row->product] = 0;
        $this->result[$row->product] += 1;
    }

    public function getResult($options = array())
    {
        $records = array();
        foreach($this->result as $product => $value) $records[] = array('product' => $product, 'value' => $value);
        return $this->filterByOptions($records, $options);
    }
}
