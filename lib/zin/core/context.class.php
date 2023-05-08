<?php
/**
 * The context class file of zin of ZenTaoPMS.
 *
 * @copyright   Copyright 2023 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @author      Hao Sun <sunhao@easycorp.ltd>
 * @package     zin
 * @version     $Id
 * @link        https://www.zentao.net
 */

namespace zin;

require_once dirname(__DIR__) . DS . 'utils' . DS . 'dataset.class.php';
require_once dirname(__DIR__) . DS . 'utils' . DS . 'flat.func.php';

class context extends \zin\utils\dataset
{
    public function addImport()
    {
        return $this->addToList('import', func_get_args());
    }

    public function getImportList()
    {
        return $this->getList('import');
    }

    public function addCSS()
    {
        return $this->addToList('css', func_get_args());
    }

    public function getCssList()
    {
        return $this->getList('css');
    }

    public function addJS()
    {
        return $this->addToList('js', func_get_args());
    }

    public function addJSVar($name, $value)
    {
        return $this->addToList('jsVar', h::createJsVarCode($name, $value));
    }

    public function addWgWithEvents($wg)
    {
        $list = $this->getWgWithEventsList();
        if(in_array($wg, $list)) return $this;
        return $this->addToList('wgWithEvents', $wg);
    }

    public function getWgWithEventsList()
    {
        return $this->getList('wgWithEvents');
    }

    public function addJSCall()
    {
        $code = call_user_func_array('\zin\h::createJsCallCode', func_get_args());
        return $this->addToList('jsCall', $code);
    }

    public function getEventsBindings()
    {
        $wgs   = $this->getList('wgWithEvents');
        $codes = [];
        foreach($wgs as $wg)
        {
            if(!method_exists($wg, 'buildEvents'))
            {
                continue;
            }
            $code = $wg->buildEvents();
            if(!empty($code)) $codes[] = $code;
        }
        return $codes;
    }

    public function getJsList()
    {
        return array_merge($this->getList('jsVar'), $this->getList('js'), $this->getEventsBindings(), $this->getList('jsCall'));
    }

    public static $map = array();

    public static function js(/* string ...$code */)
    {
        $context = static::current();
        call_user_func_array(array($context, 'addJS'), \zin\utils\flat(func_get_args()));
    }

    public static function jsCall(/* string ...$code */)
    {
        $context = static::current();
        call_user_func_array(array($context, 'addJSCall'), func_get_args());
    }


    public static function jsVar($name, $value)
    {
        $context = static::current();
        $context->addJSVar($name, $value);
    }

    public static function css(/* string ...$code */)
    {
        $context = static::current();
        call_user_func_array(array($context, 'addCSS'), \zin\utils\flat(func_get_args()));
    }

    public static function import(/* string ...$files */)
    {
        $context = static::current();
        call_user_func_array(array($context, 'addImport'), func_get_args());
    }

    /**
     * Get current context
     * @return context
     */
    public static function current()
    {
        if(empty(static::$map)) static::$map['current'] = new context(NULL);
        return static::$map['current'];
    }

    public static function create($wg)
    {
        $gid = $wg->gid;
        if(isset(static::$map[$gid])) return static::$map[$gid];
        $context = new context($wg);
        static::$map[$gid] = $context;
        return $context;
    }

    public static function destroy($gid)
    {
        if($gid instanceof wg) $gid = $gid->gid;
        if(isset(static::$map[$gid])) unset(static::$map[$gid]);
    }
}
