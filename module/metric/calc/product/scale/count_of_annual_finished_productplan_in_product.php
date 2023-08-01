<?php
/**
 * 按产品统计的年度完成计划数。
 * Count of annual finished productplan in product.
 *
 * 范围：product
 * 对象：productplan
 * 目的：scale
 * 度量名称：按产品统计的年度完成计划数
 * 单位：个
 * 描述：按产品统计的年度完成计划数是指在某年度，产品团队实际完成的计划数量。这个度量项可以反映产品团队在规划和执行过程中的效率和执行能力。完成计划数越多，说明产品团队在该年度内取得了更多的成果和交付物。
 * 定义：产品中完成时间为某年的计划个数求和;过滤已删除的计划;过滤已删除的产品;
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
class count_of_annual_finished_productplan_in_product extends baseCalc
{
    public function getStatement()
    {
        return $this->dao->select('t1.id,t1.product,year(t1.finishedDate) as year')->from(TABLE_PRODUCTPLAN)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.shadow')->eq(0)
            ->query();
    }

    public function calculate($row)
    {
        if(!empty($row->year))
        {
            if(!isset($this->result[$row->year])) $this->result[$row->year] = array();
            if(!isset($this->result[$row->year][$row->product])) $this->result[$row->year][$row->product] = 0;
            $this->result[$row->year][$row->product] ++;
        }
    }

    public function getResult($options = array())
    {
        $records = array();
        foreach($this->result as $year => $products)
        {
            foreach($products as $product => $count)
            {
                $records[] = (object)array(
                    'year'    => $year,
                    'product' => $product,
                    'value'   => $count,
                );
            }
        }

        return $this->filterByOptions($records, $options);
    }
}
