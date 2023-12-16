<?php
declare(strict_types=1);
/**
 * The control file of transfer module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Tang Hucheng <tanghucheng@cnezsoft.com>
 * @package     transfer
 * @link        https://www.zentao.net
 */
class transferModel extends model
{
    /* transfer Module configs. */
    public $transferConfig;

    /* From module configs. */
    public $moduleConfig;

    /* From module lang. */
    public $moduleLang;

    public $maxImport;

    public $moduleFieldList;

    public $templateFields;

    public $exportFields;

    public $moduleListFields;

    /**
     * The construc method, to do some auto things.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->maxImport  = isset($_COOKIE['maxImport']) ? $_COOKIE['maxImport'] : 0;
        $this->transferConfig = $this->config->transfer;
    }

    /**
     * Transfer 公共方法（格式化模块语言项，Config，字段）。
     * Common actions.
     *
     * @param  int    $module
     * @access public
     * @return void
     */
    public function commonActions(string $module = '')
    {
        if($module)
        {
            $this->loadModel($module);
            $this->moduleConfig     = $this->config->$module;
            $this->moduleLang       = $this->lang->$module;
            $this->moduleFieldList  = $this->config->$module->dtable->fieldList ?? array();
            $this->moduleListFields = explode(',', $this->config->$module->listFields ?? '');
        }
    }

    /**
     * 生成导出数据
     * Export module data.
     *
     * @param  string $module
     * @access public
     * @return void
     */
    public function export(string $module = '')
    {
        /* 设置PHP最大运行内存和最大执行时间。 */
        /* Set PHP max running memory and max execution time. */
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time','100');

        $fields = $this->post->exportFields;

        /* Init config fieldList. */
        $fieldList = $this->initFieldList($module, $fields);

        /* 生成该模块的导出数据。 */
        /* Generate export datas. */
        $rows = $this->getRows($module, $fieldList);
        if($module == 'story')
        {
            $product = $this->loadModel('product')->getByID((int)$this->session->storyTransferParams['productID']);
            if($product and $product->shadow) foreach($rows as $id => $row) $rows[$id]->product = '';
        }

        /* 设置Excel下拉数据。 */
        /* Set Excel dropdown data. */
        $list = $this->setListValue($module, $fieldList);
        if($list) foreach($list as $listName => $listValue) $this->post->set($listName, $listValue);

        /* Get export rows and fields datas. */
        $exportDatas = $this->getExportDatas($fieldList, $rows);

        $fields = $exportDatas['fields'];
        $rows   = !empty($exportDatas['rows']) ? $exportDatas['rows'] : array();

        if($this->config->edition != 'open') list($fields, $rows) = $this->loadModel('workflowfield')->appendDataFromFlow($fields, $rows, $module);

        $this->post->set('rows',   $rows);
        $this->post->set('fields', $fields);
        $this->post->set('kind',   $module);
    }

    /**
     * Init FieldList.
     *
     * @param  string $module
     * @param  string $fields
     * @param  bool   $withKey
     * @access public
     * @return array
     */
    public function initFieldList($module, $fields = '', $withKey = true)
    {
        $this->commonActions($module);
        $this->mergeConfig($module);

        $this->transferConfig->sysDataList = $this->initSysDataFields();
        $transferFieldList = $this->transferConfig->fieldList;

        if(empty($fields)) return false;

        if(!is_array($fields)) $fields = explode(',', $fields);

        $fieldList = array();
        /* build module fieldList. */
        foreach($fields as $field)
        {
            $field = trim($field);
            if($module == 'bug' and $this->session->currentProductType == 'normal' and $field == 'branch') continue;

            $moduleFieldList = isset($this->moduleFieldList[$field]) ? $this->moduleFieldList[$field] : array();

            foreach($transferFieldList as $transferField => $value)
            {
                if((!isset($moduleFieldList[$transferField])) or $transferField == 'title')
                {
                    $moduleFieldList[$transferField] = $this->transferConfig->fieldList[$transferField];

                    if(strpos($this->transferConfig->initFunction, $transferField) !== false)
                    {
                        $funcName = 'init' . ucfirst($transferField);
                        $moduleFieldList[$transferField] = $this->$funcName($module, $field);
                    }
                }
            }

            $moduleFieldList['values'] = $this->initValues($module, $field, $moduleFieldList, $withKey);
            $fieldList[$field] = $moduleFieldList;
        }

        if(!empty($fieldList['mailto']))
        {
            $fieldList['mailto']['control'] = 'multiple';
            $fieldList['mailto']['values']  = $this->transferConfig->sysDataList['user'];
        }

        if($this->config->edition != 'open')
        {
            /* Set workflow fields. */
            $workflowFields = $this->dao->select('*')->from(TABLE_WORKFLOWFIELD)
                ->where('module')->eq($module)
                ->andWhere('buildin')->eq(0)
                ->fetchAll('id');

            foreach($workflowFields as $field)
            {
                if(!in_array($field->control, array('select', 'radio', 'multi-select'))) continue;
                if(!isset($fields[$field->field]) and !array_search($field->field, $fields)) continue;
                if(empty($field->options)) continue;

                $field   = $this->loadModel('workflowfield')->processFieldOptions($field);
                $options = $this->workflowfield->getFieldOptions($field, true);
                if($options)
                {
                    $control = $field->control == 'multi-select' ? 'multiple' : 'select';
                    $fieldList[$field->field]['title']   = $field->name;
                    $fieldList[$field->field]['control'] = $control;
                    $fieldList[$field->field]['values']  = $options;
                    $fieldList[$field->field]['from']    = 'workflow';
                    $this->config->$module->listFields .=  ',' . $field->field;
                }
            }
        }

        return $fieldList;
    }

    /**
     * Init Values.
     *
     * @param  int    $model
     * @param  int    $field
     * @param  string $fieldValue
     * @param  int    $withKey
     * @access public
     * @return void
     */
    public function initValues($model, $field, $fieldValue = '', $withKey = true)
    {
        $values = $fieldValue['values'];

        if($values and (strpos($this->transferConfig->sysDataFields, $values) !== false)) return $this->transferConfig->sysDataList[$values];

        if(!$fieldValue['dataSource']) return $values;

        extract($fieldValue['dataSource']); // $module, $method, $params, $pairs, $sql, $lang

        if(!empty($Module) and !empty($method))
        {
            $params = !empty($params) ? $params : '';
            $pairs  = !empty($pairs)  ? $pairs : '';
            $values = $this->transferTao->getSourceByModuleMethod($model, $Module, $method, $params, $pairs);
        }
        elseif(!empty($lang))
        {
            $values = isset($this->moduleLang->$lang) ? $this->moduleLang->$lang : '';
        }

        /* If empty values put system datas. */
        if(empty($values))
        {
            if(strpos($this->moduleConfig->sysLangFields, $field) !== false and !empty($this->moduleLang->{$field.'List'})) return $this->moduleLang->{$field.'List'};
            if(strpos($this->moduleConfig->sysDataFields, $field) !== false and !empty($this->transferConfig->sysDataList[$field])) return $this->transferConfig->sysDataList[$field];
        }

        if(is_array($values) and $withKey)
        {
            unset($values['']);
            foreach($values as $key => $value) $values[$key] = $value . "(#$key)";
        }

        return $values;
    }

    /**
     * Init system datafields list.
     *
     * @access public
     * @return array
     */
    public function initSysDataFields()
    {
        $this->commonActions();
        $dataList = array();

        $sysDataFields = explode(',', $this->transferConfig->sysDataFields);

        foreach($sysDataFields as $field)
        {
            $dataList[$field] = $this->loadModel($field)->getPairs();
            if(!isset($dataList[$field][0])) $dataList[$field][0] = '';

            sort($dataList[$field]);

            if($field == 'user')
            {
                $dataList[$field] = $this->loadModel($field)->getPairs('noclosed|nodeleted|noletter');

                unset($dataList[$field]['']);

                if(!in_array(strtolower($this->app->methodName), array('ajaxgettbody', 'ajaxgetoptions', 'showimport'))) foreach($dataList[$field] as $key => $value) $dataList[$field][$key] = $value . "(#$key)";
            }
        }

        return $dataList;
    }

    /**
     * Get showImport datas.
     *
     * @param  string $module
     * @param  string $filter
     * @access public
     * @return array
     */
    public function format($module = '', $filter = '')
    {
        /* Bulid import paris (field => name). */
        $fields  = $this->getImportFields($module);

        /* Check tmpfile. */
        $tmpFile = $this->transferZen->checkTmpFile();

        /* If tmpfile not isset create tmpfile. */
        if(!$tmpFile)
        {
            $rows       = $this->transferZen->getRowsFromExcel();
            $moduleData = $this->processRows4Fields($rows, $fields);
            $moduleData = $this->getNatureDatas($module, $moduleData, $filter, $fields);

            $this->transferZen->createTmpFile($moduleData);
        }
        else
        {
            $moduleData = unserialize(file_get_contents($file));
        }

        $this->mergeConfig($module);
        $moduleData = $this->processDate($moduleData);
        if(isset($fields['id'])) unset($fields['id']);
        $this->session->set($module . 'TemplateFields',  implode(',', array_keys($fields)));

        return $moduleData;
    }

    /**
     * 将被操作模块与Transfer模块的配置合并。
     * Merge config.
     *
     * @param  string $module
     * @access public
     * @return void
     */
    public function mergeConfig(string $module)
    {
        $this->commonActions($module);
        $transferConfig = $this->transferConfig;
        $moduleConfig   = $this->moduleConfig;
        if(!isset($moduleConfig->export)) $moduleConfig->export = new stdClass();
        if(!isset($moduleConfig->import)) $moduleConfig->export = new stdClass();

        $this->moduleConfig->dateFields     = isset($moduleConfig->dateFields)     ? $moduleConfig->dateFields     : $transferConfig->dateFields;
        $this->moduleConfig->listFields     = isset($moduleConfig->listFields)     ? $moduleConfig->listFields     : $transferConfig->listFields;
        $this->moduleConfig->sysLangFields  = isset($moduleConfig->sysLangFields)  ? $moduleConfig->sysLangFields  : $transferConfig->sysLangFields;
        $this->moduleConfig->sysDataFields  = isset($moduleConfig->sysDataFields)  ? $moduleConfig->sysDataFields  : $transferConfig->sysDataFields;
        $this->moduleConfig->datetimeFields = isset($moduleConfig->datetimeFields) ? $moduleConfig->datetimeFields : $transferConfig->datetimeFields;
    }

    /**
     * Process datas, convert date to YYYY-mm-dd, convert datetime to YYYY-mm-dd HH:ii:ss.
     *
     * @param  array   $datas
     * @access public
     * @return array
     */
    public function processDate($datas)
    {
        foreach($datas as $index => $data)
        {
            foreach($data as $field => $value)
            {
                if(strpos($this->moduleConfig->dateFields, $field) !== false or strpos($this->moduleConfig->datetimeFields, $field) !== false) $data->$field = $this->loadModel('common')->formatDate($value);
            }
            $datas[$index] = $data;
        }
        return $datas;
    }

    /**
     * Get ExportDatas.
     *
     * @param  array  $fieldList
     * @param  array  $rows
     * @access public
     * @return array
     */
    public function getExportDatas($fieldList, $rows = array())
    {
        if(empty($fieldList)) return array();

        $exportDatas    = array();
        $dataSourceList = array();

        foreach($fieldList as $key => $field)
        {
            $exportDatas['fields'][$key] = $field['title'];
            if($field['values'])
            {
                $exportDatas[$key] = $field['values'];
                $dataSourceList[]  = $key;
            }
        }

        if(empty($rows)) return $exportDatas;

        $exportDatas['user'] = $this->loadModel('user')->getPairs('noclosed|nodeleted|noletter');

        foreach($rows as $id => $values)
        {
            foreach($values as $field => $value)
            {
                if(isset($fieldList[$field]['from']) and $fieldList[$field]['from'] == 'workflow') continue;
                if(in_array($field, $dataSourceList))
                {
                    if($fieldList[$field]['control'] == 'multiple')
                    {
                        $multiple     = '';
                        $separator    = $field == 'mailto' ? ',' : "\n";
                        $multipleLsit = explode(',', $value);

                        foreach($multipleLsit as $key => $tmpValue) $multipleLsit[$key] = zget($exportDatas[$field], $tmpValue);
                        $multiple = implode($separator, $multipleLsit);
                        $rows[$id]->$field = $multiple;
                    }
                    else
                    {
                        $rows[$id]->$field = zget($exportDatas[$field], $value, $value);
                    }
                }
                elseif(strpos($this->config->transfer->userFields, $field) !== false)
                {
                    /* if user deleted when export set userFields is itself. */
                    $rows[$id]->$field = zget($exportDatas['user'], $value);
                }

                /* if value = 0 or value = 0000:00:00 set value = ''. */
                if(is_string($value) and ($value == '0' or substr($value, 0, 4) == '0000')) $rows[$id]->$field = '';
            }
        }

        $exportDatas['rows'] = array_values($rows);
        return $exportDatas;
    }

    /**
     * Get files by module.
     *
     * @param  string $module
     * @param  array  $datas
     * @access public
     * @return void
     */
    public function getFiles($module, $datas)
    {
        $this->loadModel('file');
        $relatedFiles = $this->dao->select('id, objectID, pathname, title')->from(TABLE_FILE)
            ->where('objectType')->eq($module)
            ->andWhere('objectID')->in(@array_keys($datas))
            ->andWhere('extra')
            ->ne('editor')
            ->fetchGroup('objectID');

        if(empty($datas) and empty($relatedFiles)) return $datas;

        /* Set related files. */
        foreach($datas as $data)
        {
            $data->files = '';
            if(isset($relatedFiles[$data->id]))
            {
                foreach($relatedFiles[$data->id] as $file)
                {
                    $fileURL      = common::getSysURL() . helper::createLink('file', 'download', "fileID={$file->id}");
                    $data->files .= html::a($fileURL, $file->title, '_blank') . '<br />';
                }
            }
        }
        return $datas;
    }

    /**
     * Set list value.
     *
     * @param  int    $module
     * @param  int    $fieldList
     * @access public
     * @return void/array
     */
    public function setListValue($module, $fieldList)
    {
        $lists = array();
        $this->commonActions($module);
        if(!empty($this->moduleListFields))
        {
            $listFields = $this->moduleListFields;
            foreach($listFields as $field)
            {
                if(empty($field)) continue;
                $listName = $field . 'List';
                if(!empty($_POST[$listName])) continue;
                if(!empty($fieldList[$field]))
                {
                    $lists[$listName] = $fieldList[$field]['values'];
                    if(strpos($this->config->$module->sysLangFields, $field)) $lists[$listName] = implode(',', $fieldList[$field]['values']);
                }
                if(is_array($lists[$listName])) $this->config->excel->sysDataField[] = $field;
            }

            $lists['listStyle'] = $listFields;
        }

        if(!empty($this->moduleConfig->cascade))
        {
            $lists = $this->getCascadeList($module, $lists);
            $lists['cascade'] = $this->moduleConfig->cascade;
        }

        return $lists;
    }

    /**
     * Get cascade list for export excel.
     *
     * @param  int    $module
     * @param  int    $lists
     * @access public
     * @return void
     */
    public function getCascadeList($module, $lists)
    {
        $this->commonActions($module);
        if(!isset($this->moduleConfig->cascade)) return $lists;

        $cascadeArray = $this->moduleConfig->cascade;

        foreach($cascadeArray as $field => $linkFiled)
        {
            $fieldList     = $field . 'List';
            $linkFieldList = $linkFiled . 'List';
            $tmpFieldList  = array();
            if(!empty($lists[$fieldList]) and !empty($lists[$linkFieldList]))
            {
                $table = zget($this->config->objectTables, $field);
                if(empty($table)) continue;

                $fieldIDList     = array_keys($lists[$fieldList]);
                $fieldDatas      = $this->dao->select("id, $linkFiled")->from($table)->where('id')->in($fieldIDList)->fetchPairs();

                if(empty($fieldDatas)) continue;
                foreach($fieldDatas as $id => $linkFieldID)
                {
                    $tmpFieldList[$linkFieldID][$id] = $lists[$fieldList][$id];
                }

                $lists[$fieldList] = $tmpFieldList;
            }
        }

        return $lists;
    }

    /**
     * Get Rows.
     *
     * @param  string        $module
     * @param  object|string|array $fieldList
     * @access public
     * @return void
     */
    public function getRows(string $module, object|string|array $fieldList)
    {
        $moduleDatas = $this->getQueryDatas($module);

        if(is_object($fieldList)) $fieldList = (array) $fieldList;
        if(isset($fieldList['files'])) $moduleDatas = $this->getFiles($module, $moduleDatas);

        $rows = !empty($_POST['rows']) ? $_POST['rows'] : '';
        if($rows)
        {
            foreach($rows as $id => $row)
            {
                $moduleDatas[$id] = (object) array_merge((array)$moduleDatas[$id], (array)$row);
            }
        }

        /* Deal children datas and multiple tasks. */
        if($moduleDatas) $moduleDatas = $this->updateChildDatas($moduleDatas);

        /* Deal linkStories datas. */
        if($moduleDatas and isset($fieldList['linkStories'])) $moduleDatas = $this->updateLinkStories($moduleDatas);

        return $moduleDatas;
    }

    /**
     * Update LinkStories datas.
     *
     * @param  array $stories
     * @access public
     * @return array
     */
    public function updateLinkStories($stories)
    {
        $productIDList = array();
        foreach($stories as $story) $productIDList[] = $story->product;
        $productIDList = array_unique($productIDList);

        $storyDatas = end($stories);
        $lastType   = $storyDatas->type;

        if($storyDatas->type == 'requirement')
        {
            $stories = $this->loadModel('story')->mergePlanTitleAndChildren($productIDList, $stories, $lastType);
        }
        elseif($storyDatas->type == 'story')
        {
            return $stories;
        }

        return $stories;
    }

    /**
     * Get query datas.
     *
     * @param  string $module
     * @access public
     * @return void
     */
    public function getQueryDatas($module = '')
    {
        $queryCondition    = $this->session->{$module . 'QueryCondition'};
        $onlyCondition     = $this->session->{$module . 'OnlyCondition'};
        $transferCondition = $this->session->{$module . 'TransferCondition'};

        $moduleDatas = array();

        if($transferCondition)
        {
            $selectKey = 'id';
            $stmt = $this->dbh->query($transferCondition);
            while($row = $stmt->fetch())
            {
                if($selectKey !== 't1.id' and isset($row->$module) and isset($row->id)) $row->id = $row->$module;
                $moduleDatas[$row->id] = $row;
            }

            return $moduleDatas;
        }

        /* Fetch the scene's cases. */
        if($module == 'testcase') $queryCondition = preg_replace("/AND\s+t[0-9]\.scene\s+=\s+'0'/i", '', $queryCondition);

        $checkedItem = $this->post->checkedItem ? $this->post->checkedItem : $this->cookie->checkedItem;

        if($onlyCondition and $queryCondition)
        {
            $table = zget($this->config->objectTables, $module);
            if(isset($this->config->$module->transfer->table)) $table = $this->config->$module->transfer->table;
            if($module == 'story') $queryCondition = str_replace('story', 'id', $queryCondition);
            $moduleDatas = $this->dao->select('*')->from($table)->alias('t1')
                ->where($queryCondition)
                ->beginIF($this->post->exportType == 'selected')->andWhere('t1.id')->in($checkedItem)->fi()
                ->fetchAll('id');
        }
        elseif($queryCondition)
        {
            $selectKey = 'id';
            if($module == 'testcase') $module = 'case';
            preg_match_all('/[`"]' . $this->config->db->prefix . $module .'[`"] AS ([\w]+) /', $queryCondition, $matches);
            if(isset($matches[1][0])) $selectKey = "{$matches[1][0]}.id";

            $stmt = $this->dbh->query($queryCondition . ($this->post->exportType == 'selected' ? " AND $selectKey IN(" . ($checkedItem ? $checkedItem : '0') . ")" : ''));
            while($row = $stmt->fetch())
            {
                if($selectKey !== 't1.id' and isset($row->$module) and isset($row->id)) $row->id = $row->$module;
                $moduleDatas[$row->id] = $row;
            }
        }
        return $moduleDatas;
    }

    /**
     * Get related objects pairs.
     *
     * @param  string $module
     * @param  string $object
     * @param  string $pairs
     * @access public
     * @return void
     */
    public function getRelatedObjects($module = '', $object = '', $pairs = '')
    {
        /* Get objects. */
        $datas = $this->getQueryDatas($module);

        /* Get related objects id lists. */
        $relatedObjectIdList = array();
        $relatedObjects      = array();

        foreach($datas as $data) $relatedObjectIdList[$data->$object] = $data->$object;

        if($object == 'openedBuild') $object = 'build';

        /* Get related objects title or names. */
        $table = $this->config->objectTables[$object];
        if($table) $relatedObjects = $this->dao->select($pairs)->from($table) ->where('id')->in($relatedObjectIdList)->fetchPairs();

        if($object == 'build') $relatedObjects = array('trunk' => $this->lang->trunk) + $relatedObjects;

        return $relatedObjects;
    }

    /**
     * Get nature datas.
     *
     * @param  int    $module
     * @param  int    $datas
     * @param  string $filter
     * @param  string $fields
     * @access public
     * @return void
     */
    public function getNatureDatas($module, $datas, $filter = '', $fields = '')
    {
        $fieldList = $this->initFieldList($module, array_keys($fields), false);
        $lang = $this->lang->$module;

        foreach($datas as $key => $data)
        {
            foreach($data as $field => $cellValue)
            {
                if(empty($cellValue)) continue;
                if(strpos($this->transferConfig->dateFields, $field) !== false and helper::isZeroDate($cellValue)) $datas[$key]->$field = '';
                if(is_array($cellValue)) continue;

                if(!empty($fieldList[$field]['from']) and in_array($fieldList[$field]['control'], array('select', 'multiple')))
                {
                    $control = $fieldList[$field]['control'];
                    if($control == 'multiple')
                    {
                        $cellValue = explode("\n", $cellValue);
                        foreach($cellValue as &$value) $value = array_search($value, $fieldList[$field]['values'], true);
                        $datas[$key]->$field = implode(',', $cellValue);
                    }
                    else
                    {
                        $datas[$key]->$field = array_search($cellValue, $fieldList[$field]['values']);
                    }
                }
                elseif(strrpos($cellValue, '(#') === false)
                {
                    if(!isset($lang->{$field . 'List'}) or !is_array($lang->{$field . 'List'})) continue;

                    /* When the cell value is key of list then eq the key. */
                    $listKey = array_keys($lang->{$field . 'List'});
                    unset($listKey[0]);
                    unset($listKey['']);

                    $fieldKey = array_search($cellValue, $lang->{$field . 'List'});
                    if($fieldKey) $datas[$key]->$field = array_search($cellValue, $lang->{$field . 'List'});
                }
                else
                {
                    $id = trim(substr($cellValue, strrpos($cellValue,'(#') + 2), ')');
                    $datas[$key]->$field = $id;
                    $control = !empty($this->moduleFieldList[$field]['control']) ? $this->moduleFieldList[$field]['control'] : '';
                    if($control == 'multiple')
                    {
                        $cellValue = explode("\n", $cellValue);
                        foreach($cellValue as &$value)
                        {
                            $value = trim(substr($value, strrpos($value,'(#') + 2), ')');
                        }
                        $cellValue = array_filter($cellValue, function($v) {return (empty($v) && $v == '0') || !empty($v);});
                        $datas[$key]->$field = implode(',', $cellValue);
                    }
                }
            }

        }
        return $datas;
    }

    /**
     * Get pagelist for datas.
     *
     * @param  int    $datas
     * @param  int    $pagerID
     * @access public
     * @return void
     */
    public function getPageDatas($datas, $pagerID = 1)
    {
        $result = new stdClass();
        $result->allCount = count($datas);
        $result->allPager = 1;
        $result->pagerID  = $pagerID;

        $maxImport = $this->maxImport;
        if($result->allCount > $this->config->file->maxImport)
        {
            if(empty($maxImport))
            {
                $result->maxImport = $maxImport;
                $result->datas     = $datas;
                return $result;
            }

            $result->allPager = ceil($result->allCount / $maxImport);
            $datas = array_slice($datas, ($pagerID - 1) * $maxImport, $maxImport, true);
        }

        if(!$maxImport) $this->maxImport = $result->allCount;
        $result->maxImport = $maxImport;
        $result->isEndPage = $pagerID >= $result->allPager;
        $result->datas     = $datas;

        $this->session->set('insert', true);

        foreach($datas as $data)
        {
            if(isset($data->id)) $this->session->set('insert', false);
        }

        if(empty($datas)) return print(js::locate('back'));
        return $result;
    }

    /**
     * Get import fields.
     *
     * @param  string $module
     * @access public
     * @return void
     */
    public function getImportFields($module = '')
    {
        $this->commonActions($module);
        $moduleLang = $this->lang->$module;
        $fields    = explode(',', $this->moduleConfig->templateFields);

        array_unshift($fields, 'id');
        foreach($fields as $key => $fieldName)
        {
            $fieldName = trim($fieldName);
            $fields[$fieldName] = isset($moduleLang->$fieldName) ? $moduleLang->$fieldName : $fieldName;
            unset($fields[$key]);
        }

        if($this->config->edition != 'open')
        {
            $appendFields = $this->loadModel('workflowaction')->getFields($module, 'showimport', false);
            foreach($appendFields as $appendField)
            {
                if(!$appendField->buildin and $appendField->show) $fields[$appendField->field] = $appendField->name;
            }
        }

        return $fields;
    }

    /**
     * Update children datas.
     *
     * @param  int    $datas
     * @access public
     * @return void
     */
    public function updateChildDatas($datas)
    {
        $children = array();
        foreach($datas as $data)
        {
            if(!empty($data->parent) and isset($datas[$data->parent]))
            {
                if(!empty($data->name)) $data->name = '>' . $data->name;
                elseif(!empty($data->title)) $data->title = '>' . $data->title;
                $children[$data->parent][$data->id] = $data;
                unset($datas[$data->id]);
            }
            if(!empty($data->mode))
            {
                $datas[$data->id]->name = '[' . $this->lang->task->multipleAB . '] ' . $data->name;
            }
        }

        /* Move child data after parent data. */
        if(!empty($children))
        {
            $position = 0;
            foreach($datas as $data)
            {
                $position ++;
                if(isset($children[$data->id]))
                {
                    array_splice($datas, $position, 0, $children[$data->id]);
                    $position += count($children[$data->id]);
                }
            }
        }

        return $datas;
    }

    /**
     * Process rows for fields.
     *
     * @param  array  $rows
     * @param  array  $fields
     * @access public
     * @return void
     */
    public function processRows4Fields($rows = array(), $fields = array())
    {
        $objectDatas = array();

        foreach($rows as $currentRow => $row)
        {
            $tmpArray = new stdClass();
            foreach($row as $currentColumn => $cellValue)
            {
                if($currentRow == 1)
                {
                    $field = array_search($cellValue, $fields);
                    $columnKey[$currentColumn] = $field ? $field : '';
                    continue;
                }

                if(empty($columnKey[$currentColumn]))
                {
                    $currentColumn++;
                    continue;
                }

                $field = $columnKey[$currentColumn];
                $currentColumn++;

                /* Check empty data. */
                if(empty($cellValue))
                {
                    $tmpArray->$field = '';
                    continue;
                }

                $tmpArray->$field = $cellValue;
            }

            if(!empty($tmpArray->title) and !empty($tmpArray->name)) $objectDatas[$currentRow] = $tmpArray;
            unset($tmpArray);
        }

        if(empty($objectDatas))
        {
            if(file_exists($this->session->fileImportFileName)) unlink($this->session->fileImportFileName);
            unset($_SESSION['fileImportFileName']);
            unset($_SESSION['fileImportExtension']);
            echo js::alert($this->lang->excel->noData);
            return print(js::locate('back'));
        }

        return $objectDatas;
    }
}
