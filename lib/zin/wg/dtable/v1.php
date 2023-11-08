<?php
declare(strict_types=1);
namespace zin;

class dtable extends wg
{
    protected static array $defineProps = array(
        'className?:string="shadow-sm rounded"', // 表格样式。
        'id?:string',                         // ID。
        'customCols?: bool|array',            // 是否支持自定义列。
        'cols?:array',                        // 表格列配置
        'data?:array',                        // 表格数据源
        'module?:string',                     // 模块信息，主要是获取语言项
        'emptyTip?:string',                   // 表格数据源为空时显示的文本
        'createTip?:string',                  // 表格数据源为空时的创建文本
        'createLink?:array|string',           // 表格数据源为空时的创建链接
        'createAttr?:string',                 // 表格数据源为空时的创建链接属性
    );

    static $dtableID = 0;

    protected function created()
    {
        global $app;

        $defaultID = "table-{$app->rawModule}-{$app->rawMethod}";
        $this->setDefaultProps(array('id' => static::$dtableID ? ($defaultID . static::$dtableID) : $defaultID));
        static::$dtableID++;

        $customColsProp = $this->prop('customCols');
        if($customColsProp)
        {
            $app->loadLang('datatable');
            $customUrl = is_bool($customColsProp) || empty($customColsProp['url']) ? null : $customColsProp['url'];
            $this->setProp('customCols', array(
                'custom' => array(
                    'url' => $customUrl ? $customUrl : createLink('datatable', 'ajaxcustom', "module=$app->moduleName&method=$app->methodName"),
                    'text' => $app->lang->datatable->custom
                ),
                'setGlobal' => array(
                    'url' => createLink('datatable', 'ajaxsaveglobal', "module={$app->moduleName}&method={$app->methodName}"),
                    'text' => $app->lang->datatable->setGlobal,
                ),
                'reset' => array(
                    'url' => createLink('datatable', 'ajaxreset', "module={$app->moduleName}&method={$app->methodName}"),
                    'text' => $app->lang->datatable->reset,
                ),
                'resetGlobal' => array(
                    'url' => createLink('datatable', 'ajaxreset', "module={$app->moduleName}&method={$app->methodName}&system=1"),
                    'text' => $app->lang->datatable->resetGlobal,
                ),
            ));
        }

        $module = $this->prop('module', $app->rawModule);
        if(!isset($app->lang->$module)) $app->loadLang($module);

        /* Set col default name and title. */
        $colConfigs = $this->prop('cols');
        foreach($colConfigs as $field => &$config)
        {
            if(is_object($config)) $config = (array)$config;

            if(!isset($config['name']))  $config['name'] = $field;
            if(!isset($config['title'])) $config['title'] = zget($app->lang->{$module}, $config['name'], zget($app->lang, $config['name']));
            if(isset($config['link']) && is_array($config['link'])) $config['link'] = $this->getLink($config['link']);
            if(isset($config['assignLink']) && is_array($config['assignLink'])) $config['assignLink'] = $this->getLink($config['assignLink']);

            if(!empty($config['type']) && $config['type'] == 'control')
            {
                if(!empty($config['control']) && is_string($config['control'])) $config['control'] = array('type' => $config['control']);

                if(isset($config['controlItems']))
                {
                    if(empty($config['control'])) $config['control'] = array('type' => 'picker');

                    $items    = $config['controlItems'];
                    $newItems = array();
                    foreach($items as $key => $value)
                    {
                        if(is_numeric($key) && is_array($value)) $newItems[] = $value;
                        else $newItems[] = array('text' => $value, 'value' => $key);
                    }
                    $config['control']['props']['items'] = $newItems;
                    unset($config['controlItems']);

                    if(isset($config['defaultValue'])) $config['control']['props']['defaultValue'] = $config['defaultValue'];
                }
            }

            if(!empty($config['actionsMap']))
            {
                foreach($config['actionsMap'] as &$action)
                {
                    if(isset($action['data-toggle']) && !isset($action['data-position'])) $action['data-position'] = 'center';

                    $action['className'] = 'text-primary';
                    if(!empty($action['ajaxSubmit']))
                    {
                        if(empty($action['className']))     $action['className']   .= ' ajax-submit';
                        if(!isset($action['data-confirm'])) $action['data-confirm'] = zget($app->lang->$module, 'confirmDelete');
                    }
                }
            }
        }
        $this->setProp('cols', array_values($colConfigs));

        $tableData = $this->prop('data', array());
        $this->setProp('data', array_values($tableData));

        /* Add dtable load info to pager links. */
        $pager = $this->prop('footPager');
        if(!empty($pager) && isset($pager['items']))
        {
            if(!isset($pager['btnProps'])) $pager['btnProps'] = array('data-load' => 'table', 'type' => 'ghost', 'size' => 'sm');
            foreach($pager['items'] as $index => $item)
            {
                if($item['type'] !== 'size-menu') continue;
                if(isset($item['itemProps']))
                {
                    $pager['items'][$index]['itemProps']['data-load']   = 'table';
                    $pager['items'][$index]['itemProps']['data-target'] = $this->prop('id');
                }
                else
                {
                    $pager['items'][$index]['itemProps'] = array('data-load' => 'table', 'data-target' => $this->prop('id'));
                }
            }
            $this->setProp('footPager', $pager);
        }

        $orderBy = $this->prop('orderBy');
        if(is_string($orderBy))
        {
            list($orderByName, $orderByType) = explode('_', strpos($orderBy, '_') === false ? $orderBy . '_desc' : $orderBy);
            $this->setProp('orderBy', array($orderByName => $orderByType));
        }

        /* Support to set footToolbar with items array. */
        $footToolbar = $this->prop('footToolbar');
        if(!empty($footToolbar))
        {
            if(!is_array($footToolbar))     $footToolbar = array('items' => array($footToolbar));
            if(array_is_list($footToolbar)) $footToolbar = array('items' => $footToolbar);
            $footToolbarItems = array();
            if(isset($footToolbar['items']))
            {
                foreach($footToolbar['items'] as $item)
                {
                    if($item instanceof item) $item = $item->props->toJSON();
                    $footToolbarItems[] = $item;
                }
                $footToolbar['items'] = $footToolbarItems;
            }
            $this->setProp('footToolbar', $footToolbar);
        }
    }

    public static function getPageCSS(): string|false
    {
        return file_get_contents(__DIR__ . DS . 'css' . DS . 'v1.css');
    }

    /**
     * 获取字段链接。
     * Get link to the field.
     *
     * @param  array        $setting
     * @access protected
     * @return array|string
     */
    protected function getLink(array $setting): array|string
    {
        if(!empty($setting['url']))
        {
            $url = $setting['url'];
            if(!empty($url['module']) && !empty($url['method']))
            {
                $setting['url'] = '';
                if(hasPriv($url['module'], $url['method'])) $setting['url'] = createLink($url['module'], $url['method'], zget($url, 'params', ''), '', !empty($setting['onlybody']));
            }
            return $setting;
        }
        else if(!empty($setting['module']) && !empty($setting['method']))
        {
            if(!hasPriv($setting['module'], $setting['method'])) return '';
            $url = createLink($setting['module'], $setting['method'], zget($setting, 'params', ''), '', !empty($setting['onlybody']));
            if(empty($setting['target'])) return $url;

            return array('url' => $url, 'target' => $setting['target']);
        }
        return $setting;
    }

    protected function build(): wg
    {
        if(empty($this->prop('data')))
        {
            global $lang;
            $emptyTip   = $this->prop('emptyTip', $lang->noData);
            $createLink = !empty($this->prop('createLink')) ? $this->prop('createLink') : '';
            if(is_string($emptyTip))
            {
                if(!empty($createLink))
                {
                    $createTip  = $this->prop('createTip', $lang->create);
                    $createAttr = $this->prop('createAttr', '');
                    $emptyTip   = array('html' => "<div class='text-gray'>$emptyTip</div><a class='btn primary-pale border-primary' href='$createLink' $createAttr><i class='icon icon-plus'></i> $createTip</a>", 'className' => 'row gap-4 items-center');
                }
                else
                {
                    $emptyTip = array('html' => "$emptyTip", 'className' => 'text-gray');
                }
            }
            $this->setProp('emptyTip', $emptyTip);
            $this->setProp('customCols', false);
        }
        return zui::dtable(inherit($this));
    }
}
