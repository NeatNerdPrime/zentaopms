<?php
/**
 * 按全局统计的完成项目中按期完成项目数。
 * Count of undelayed finished project which finished.
 *
 * 范围：global
 * 对象：project
 * 目的：scale
 * 度量名称：按全局统计的完成项目中按期完成项目数
 * 单位：个
 * 描述：按全局统计的完成项目中按期关闭项目数是指按预定计划时间关闭的项目数量。这个度量项可以帮助团队评估项目的时间管理和执行能力。较高的按期关闭项目数表示团队能够按时交付项目，有助于保持项目进展和客户满意度。
 * 定义：所有的项目个数求和;状态为已关闭;完成日期<=项目启动时的计划截止日期;过滤已删除的项目;
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
class count_of_undelayed_finished_project_which_finished extends baseCalc
{
    public $dataset = 'getAllProjects';

    public $fieldList = array('status', 'closedDate', 'firstEnd');

    public $result = 0;

    public function calculate($row)
    {
        if(empty($row->closedDate) or empty($row->firstEnd)) return false;

        if($row->status == 'closed' and $row->closedDate <= $row->firstEnd) $this->result ++;
    }

    public function getResult($options = array())
    {
        return $this->filterByOptions($this->result, $options);
    }
}
