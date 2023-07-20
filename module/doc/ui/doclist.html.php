<?php
declare(strict_types=1);
/**
 * The doclist view file of doc module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Shujie Tian<tianshujie@easycorp.ltd>
 * @package     doc
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('iconList', $config->doc->iconList);
jsVar('draftText', $lang->doc->draft);
jsVar('canViewDoc', common::hasPriv('doc', 'view'));
jsVar('canCollect', common::hasPriv('doc', 'collect') && $libType && $libType != 'api');
jsVar('currentAccount', $app->user->account);

$cols = array();
foreach($config->doc->dtable->fieldList as $colName => $col)
{
    if($canExport && $colName == 'id') $col['type'] = 'checkID';
    if(!in_array($colName, array('id', 'title', 'addedBy', 'addedDate', 'editedBy', 'editedDate', 'actions'))) continue;

    $cols[$colName] = $col;
}

$params    = "objectID={$objectID}&libID={$libID}&moduleID={$moduleID}&browseType={$browseType}&orderBy={$orderBy}&param={$param}&recTotal={recTotal}&recPerPage={recPerPage}&pageID={page}";
$tableData = initTableData($docs, $cols);
dtable
(
    set::userMap($users),
    set::cols($cols),
    set::data($tableData),
    set::checkable($canExport),
    set::onRenderCell(jsRaw('window.rendDocCell')),
    set::footPager(
        usePager
        (
            array('linkCreator' => helper::createLink('doc', $app->rawMethod, $params)),
        ),
    ),
);
