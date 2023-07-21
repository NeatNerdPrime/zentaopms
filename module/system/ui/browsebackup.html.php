<?php
declare(strict_types=1);
/**
 * The browsebackup view file of system module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Zeng Gang<zenggang@easycorp.ltd>
 * @package     system
 * @link        https://www.zentao.net
 */
namespace zin;

foreach($backups as $backup)
{
    $backup->backupPerson = isset($backup->sqlSummary['account']) ? $backup->sqlSummary['account'] : '';
    if(empty($backup->sqlSummary['backupType'])) $backup->sqlSummary['backupType'] = '';
    $backup->type = $backup->sqlSummary['backupType'];
}
$backups = initTableData($backups, $config->system->dtable->backup->fieldList, $this->system);

detailHeader();

panel
(
    set::size('lg'),
    set::title($lang->system->backup->systemInfo),
    div
    (
        setStyle('width', '66.6%'),
        dtable
        (
            set::cols($config->system->dtable->backup->fieldList),
            set::data($backups),
        ),
    ),
);

render();

