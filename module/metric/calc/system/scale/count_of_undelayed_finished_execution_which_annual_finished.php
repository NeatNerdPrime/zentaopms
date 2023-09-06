<?php
/**
 * 按全局统计的年度完成执行中按期完成执行数。
 * Count of undelayed finished execution which annual finished.
 *
 * 范围：global
 * 对象：execution
 * 目的：scale
 * 度量名称：按全局统计的年度完成执行中按期完成执行数
 * 单位：个
 * 描述：按全局统计的年度完成执行中按期完成执行数是指在某年度按预定计划时间关闭的执行数量，这个度量项可以用来衡量团队在某年度的按时完成能力。较高的按期完成执行数表明团队能够按期交付执行，有助于保持执行和项目的正常进行。
 * 定义：所有的关闭时间为某年的执行个数求和;关闭日期<=执行开始时计划截止日期;过滤已删除的执行;
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
class count_of_undelayed_finished_execution_which_annual_finished extends baseCalc
{
    public $dataset = 'getExecutions';

    public $fieldList = array('t1.status', 't1.closedDate', 't1.firstEnd');

    public function calculate($row)
    {
        if(empty($row->closedDate) || empty($row->firstEnd)) return false;

        $year = substr($row->closedDate, 0, 4);
        if($year == '0000') return false;

        if($row->status == 'closed' && $row->closedDate <= $row->firstEnd)
        {
            if(!isset($this->result[$year])) $this->result[$year] = 0;
            $this->result[$year] ++;
        }
    }

    public function getResult($options = array())
    {
        $records = $this->getRecords(array('year', 'value'));
        return $this->filterByOptions($records, $options);
    }
}
