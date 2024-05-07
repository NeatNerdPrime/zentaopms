<?php
/**
 * 按产品统计的处理中的工单数。
 * Count of doing ticket in product.
 *
 * 范围：product
 * 对象：ticket
 * 目的：scale
 * 度量名称：按产品统计的处理中的工单数
 * 单位：个
 * 描述：按产品统计的处理中的工单数表示产品中状态为处理中的工单数量之和。该数值越大，说明产品团队正在处理的工单数量较多，可以一定程度上反映团队的工作负载。
 * 计算规则：产品中所有工单个数求和，状态为处理中，过滤已删除的工单，过滤已删除的产品。
 *
 * @copyright Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @author    Tingting Dai <daitingting@easycorp.ltd>
 * @package
 * @uses      func
 * @license   ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @Link      https://www.zentao.net
 */
class count_of_doing_ticket_in_product extends baseCalc
{
    public $dataset = 'getTickets';

    public $fieldList = array('t1.product', 't1.status');

    public $result = array();

    public function calculate($row)
    {
        $product = $row->product;
        $status  = $row->status;

        if($status != 'doing') return false;

        if(!isset($this->result[$product])) $this->result[$product] = 0;
        $this->result[$product] += 1;
    }

    public function getResult($options = array())
    {
        $records = $this->getRecords(array('product', 'value'));
        return $this->filterByOptions($records, $options);
    }
}
