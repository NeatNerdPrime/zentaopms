<?php
declare(strict_types=1);
/**
* The UI file of productplan module of ZenTaoPMS.
*
* @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
* @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
* @author      zhouxin <zhouxin@easycorp.ltd>
* @package     productplan
* @link        https://www.zentao.net
*/

namespace zin;

formPanel
(
    set::title($lang->productplan->close),
    set::actions(array('submit')),
    set::submitBtnText($lang->productplan->closeAB),
    set::headingClass('status-heading'),
    set::titleClass('form-label .form-grid'),
    to::headingActions
    (
        entityLabel
        (
            setClass('my-3 gap-x-3'),
            set::entityID($productplan->id),
            set::text($productplan->title),
            set::level(1),
            set::reverse(true),
        )
    ),
    formGroup
    (
        set::id('closedReasonBox'),
        set::name('closedReason'),
        set::label($lang->productplan->closedReason),
        set::width('1/3'),
        set::strong(false),
        set::value(''),
        set::items($reasonList),
    ),
    formGroup
    (
        set::label($lang->comment),
        set::name('comment'),
        set::control('editor'),
        set::rows(6),
    ),
);

h::hr(set::class('mt-6'));
history();

render('modalDialog');
