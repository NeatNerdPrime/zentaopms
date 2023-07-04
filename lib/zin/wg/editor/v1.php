<?php
namespace zin;

require_once dirname(__DIR__) . DS . 'textarea' . DS . 'v1.php';

class editor extends wg
{
    protected static $defineProps = array(
        'createInput?: bool=false',    // 是否创建一个隐藏的 input 存储编辑器内容
        'uploadUrl?: string=""',       // 图片上传链接
        'placeholder?: string=""',     // 占位文本
        'fullscreenable?: bool=false', // 是否可全屏
        'resizable?: bool=false',      // 是否可自适应
        'exposeEditor?: bool=true',    // 是否将编辑器实例挂载到 window
        'size?: string="sm"',          // 尺寸
        'hideMenubar?: bool=false',    // 是否隐藏 menubar
        'bubbleMenu?: bool=false',     // 是否启用菜单冒泡
        // 'collaborative?: bool=false',
        // 'hocuspocus?: string=""',
        // 'docName?: string=""',
        // 'username?: string=""',
        // 'userColor?: string="#ffcc00"'
    );

    protected function build()
    {
        $props = $this->props->pick(array('createInput', 'uploadUrl', 'placeholder', 'fullscreenable', 'resizable', 'exposeEditor', 'size', 'hideMenubar', 'bubbleMenu', 'collaborative', 'hocuspocus', 'docName', 'username', 'userColor'));
        $editor = new h(set::tagName('tiptap-editor'));
        foreach ($props as $key => $value)
        {
            if($value === true || (is_string($value) && !empty($value))) $editor->add(set(uncamelize($key), $value));
        }
        $editor->add(set($this->props->skip(array_keys(static::getDefinedProps()))));
        return $editor;
    }
}
