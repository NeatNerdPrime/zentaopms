<?php
declare(strict_types=1);
namespace zin;

class severityLabel extends wg
{
    protected static array $defineProps = array(
        'level: string|int',     // 严重程度等级。
        'text?: string|array',   // 标签文本或标签文本映射对象，如果不指定从 $lang->$moduleName->severityList 中获取。
        'isIcon?: bool'          // 是否显示为图标。
    );

    protected function onAddChild(mixed $child)
    {
        if(is_string($child) || is_int($child))
        {
            if(!$this->props->has('level'))
            {
                $this->props->set('level', $child);
                return false;
            }
            if(!$this->props->has('text') && is_string($child))
            {
                $this->props->set('text', $child);
                return false;
            }
        }
        return $child;
    }

    protected function build()
    {
        $level  = $this->prop('level', 0);
        $text   = $this->prop('text');
        $isIcon = $this->prop('isIcon');

        if(is_null($text))
        {
            global $app, $lang;
            $moduleName = $app->getModuleName();
            if(isset($lang->$moduleName->severityList)) $text = $lang->$moduleName->severityList;
        }

        if(is_array($text)) $text = isset($text[$level]) ? $text[$level] : null;

        $level = trim("$level");
        if($text === null)   $text   = ($level === '0' || $level === '') ? '' : $level;
        if($isIcon === null) $isIcon = is_numeric($text);

        return span
        (
            set($this->getRestProps()),
            setClass($isIcon ? 'severity' : 'severity severity-label'),
            set('data-severity', $level),
            $isIcon ? '' : $text
        );
    }
}
