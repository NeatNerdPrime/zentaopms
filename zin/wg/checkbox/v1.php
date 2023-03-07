<?php
namespace zin;

class checkbox extends wg
{
    protected static $defineProps = 'text?:string';

    public function onAddChild($child)
    {
        if(is_string($child) && !$this->props->has('text'))
        {
            $this->props->set('text', $child);
            return false;
        }
    }

    protected function build()
    {
        return h::label
        (
            setClass('pl-2 checkbox'),
            h::checkbox
            (
                setId($this->prop('id')),
                set($this->props->skip(array_keys(static::getDefinedProps(), true))),
                $this->prop('checked') ? set('checked', $this->prop('checked')) : null
            ),
            $this->prop('text')
        );
    }
}
