<?php
class toolbar
{
    private $children = array();

    public function __construct($text = '')
    {
    }

    public function append($item)
    {
        $this->children[] = $item;
    }

    public function toString()
    {
        $html = '<div class="btn-toolBar pull-left">';
        foreach($this->children as $child)
        {
            if(is_string($child))
            {
                $html .= $child;
                continue;
            }
            $html .= $child->toString();
        }
        return $html . '</div>';
    }
}
