<?php
declare(strict_types=1);
/**
 * The text element class file of zin of ZenTaoPMS.
 *
 * @copyright   Copyright 2023 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @author      Hao Sun <sunhao@easycorp.ltd>
 * @package     zin
 * @version     $Id
 * @link        https://www.zentao.net
 */

namespace zin;

require_once __DIR__ . DS . 'node.class.php';
require_once __DIR__ . DS . 'directive.class.php';
require_once __DIR__ . DS . 'context.func.php';

class htm extends node
{
    public function addToBlock(string $name, mixed $child, bool $prepend = false)
    {
        if(is_string($child))
        {
            $child = (object)array('html' => $child);
        }
        return parent::addToBlock($name, $child, $prepend);
    }
}

function html(mixed ...$codes): htm
{
    return new htm(...$codes);
}

function rawContent(): htm
{
    context()->rawContentCalled = true;
    return h::comment('{{RAW_CONTENT}}');
}

function hookContent(): htm
{
    context()->hookContentCalled = true;
    return h::comment('{{HOOK_CONTENT}}');
}
