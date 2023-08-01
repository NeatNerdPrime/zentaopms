<?php
/**
 * 按产品统计的发布上线后的Bug数。
 * Count of released bug in product.
 *
 * 范围：product
 * 对象：release
 * 目的：qc
 * 度量名称：按产品统计的发布上线后的Bug数
 * 单位：个
 * 描述：按产品统计的发布上线后的Bug数是指在产品发布到线上后，发现的Bug数量。这个度量项可以反映产品团队在发布后的质量控制能力和产品稳定性。发布上线后的Bug数越少，说明产品团队在发布前经过了充分的测试和优化，产品质量和用户体验更好。
 * 定义：产品中Bug创建时间为某个发布上线后且关联到这个发布版本的Bug个数求和;过滤已删除的计划;过滤已删除的产品;
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
class count_of_released_bug_in_product extends baseMetric
{
    public $dataset = '';

    public $fieldList = array();

    public $result = array();

    //public function getStatement()
    //{
    //}

    //public function calculate($data)
    //{
    //}

    //public function getResult()
    //{
    //}
}