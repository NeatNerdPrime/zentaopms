<?php
/**
 * 度量项定义基类。
 * Base class of measurement func.
 *
 * @copyright Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @author    qixinzhi <qixinzhi@easycorp.ltd>
 * @package
 * @license   LGPL
 * @Link      https://www.zentao.net
 */
class baseMetric
{
    /**
     * 来源数据集。
     * dataset
     *
     * @var int
     * @access public
     */
    public $dataset;
    /**
     * 参数列表。
     * fieldList
     *
     * @var int
     * @access public
     */
    public $fieldList;

    /**
     * 数据主表。
     * Main table.
     *
     * @var string
     * @access public
     */
    public $mainTable;

    /**
     * 连接表。
     * Left join tables.
     *
     * @var array
     * @access public
     */
    public $subTables;

    /**
     * 过滤条件。
     * Filters of data.
     *
     * @var array
     * @access public
     */
    public $filters;

    /**
     * 指标结果。
     * Result of indicators.
     *
     * @var array|float
     * @access public
     */
    public $result;

    /**
     * 计算度量项。
     * Calculate metric.
     *
     * @param  object $data
     * @access public
     * @return void
     */
    public function calculate($data)
    {
        /* 1. 判断过滤条件是否满足，不满足则不计算。*/
        /* 2. 遍历指标，进行计算。*/
        /* 2.1 如果指标中包含了分组类型，则在result中维护分组。*/
        /* 2.2 指标包含了筛选条件，满足筛选条件时记录数据, 否则直接记录数据。*/
    }

    /**
     * 获取度量项结果。
     *
     * @access public
     * @return void
     */
    public function getResult()
    {
    }

    /**
     * 根据字段分组。
     * Group by field.
     *
     * @param  string $field
     * @param  object $data
     * @access public
     * @return void
     */
    public function groupBy($field, $data)
    {
        $value = $data->$field;
        if(empty($this->result[$value])) $this->result[$value] = array();
        $this->result[$value][] = $data;
    }
}
