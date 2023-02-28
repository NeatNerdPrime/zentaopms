<?php
namespace zin;

\commonModel::setMainMenu();

$navItems = array();
foreach (\customModel::getMainMenu() as $menuItem)
{
    $navItems[] = array(
        'text'   => $menuItem->text,
        'url'    => \commonModel::createMenuLink($menuItem, $app->tab),
        'active' => $menuItem->order === 1,
    );
}

page(
    h::style(<<<END
    .w-360 { width: 360px; }
    .w-740 { width: 740px; }
    .w-166 { width: 166px; }
    .w-106 { width: 106px; }
    .w-60 { width: 60px;  }
    .form-label { width: 6rem !important; }
    END),
    set('title', $title),
    pageheader
    (
        pageheading
        (
            set('text', $lang->{$app->tab}->common),
            set('icon', $app->tab),
            set('url', \helper::createLink($app->tab, 'browse')),
        ),
        pagenavbar
        (
            setId('navbar'),
            set('items', $navItems)
        ),
        pagetoolbar
        (
            set('create',   array('href' => '#globalCreateMenu')),
            set('switcher', array('href' => '#switcherMenu', 'text' => '研发管理界面')),
            block('avatar', avatar(set('name', $app->user->account), set('avatar', $app->user->avatar), set('trigger', '#userMenu')))
        )
    ),
    div
    (
        setStyle(array('width' => '1000px', 'margin' => '0 auto', 'background' => '#fff')),
        div
        (
            setClass('px-8 py-6'),
            h2
            (
                setStyle(array('font-size' => '1.2rem', 'font-weight' => 'bold')),
                $lang->task->create
            ),
        ),
        div
        (
            setStyle(array('padding-left' => '3rem', 'padding-bottom' => '1rem')),
            formgrid
            (
                formgroup
                (
                    set('label', array('required' => true, 'text' => $lang->task->execution)),
                    select(
                        setClass('w-360'),
                        set('name', 'execution'),
                        set('items', array_map(function($v, $k) {return array('text' => $v, 'value' => $k, 'selected' => $k == $execution->id);}, $executions, array_keys($executions)))
                    )
                ),
                formgroup
                (
                    set('label', array('required' => true, 'text' => $lang->task->type)),
                    select
                    (
                        setClass('w-360'),
                        set('name', 'type'),
                        set('items', array_map(function($v, $k) {return array('text' => $v, 'value' => $k, 'selected' => $k === $task->type);}, $lang->task->typeList, array_keys($lang->task->typeList)))
                    )
                ),
                formgroup
                (
                    set('label', array('text' => $lang->task->module)),
                    formrow
                    (
                        setClass('items-center'),
                        select
                        (
                            setClass('w-360'),
                            set('name', 'module'),
                            set('items', array_map(function($v, $k) {return array('text' => $v, 'value' => $k, 'selected' => $k === $task->module);}, $moduleOptionMenu, array_keys($moduleOptionMenu)))
                        ),
                        checkbox
                        (
                            set('name', 'showAllModule'),
                            set(array('text' => $lang->task->allModule))
                        )
                    ),
                ),
                formgroup
                (
                    set('label', array('text' => $lang->task->story)),
                    select(
                        setClass('w-740'),
                        set('name', 'story'),
                        set('items', array_map(function($v, $k) {return array('text' => $v, 'value' => $k, 'selected' => $k === $task->story);}, $stories, array_keys($stories)))
                    )
                ),
                formgroup
                (
                    set('name', 'name'),
                    set('label', array('text' => $lang->task->name, 'required' => true)),
                    forminput(setClass('w-740')),
                ),
                formgroup
                (
                    set('name', 'pri'),
                    set('label', array('text' => $lang->task->pri)),
                    setClass('w-360'),
                    select
                    (
                        set('items', array_map(function($v, $k) {return array('text' => $v, 'value' => $k, 'selected' => $k === $task->pri);}, $lang->task->priList, array_keys($lang->task->priList)))
                    )
                ),
                formrow
                (
                    setClass('items-center'),
                    formgroup
                    (
                        set('label', array('text' => $lang->task->assignedTo)),
                        select
                        (
                            set('name', 'assignedTo[]'),
                            setClass('w-360'),
                            set('items', array_map(function($v, $k) {return array('text' => $v, 'value' => $k, 'selected' => $k === $task->assignedTo);}, $members, array_keys($members)))
                        )
                    ),
                    formgroup
                    (
                        set('label', array('text' => $lang->task->estimateAB, 'auto' => true)),
                        inputgroup
                        (
                            set('items', array(
                                array('type' => 'input', 'class' => 'w-60', 'name' => 'estimate'),
                                array('type' => 'addon', 'text' => 'H'),
                            ))
                        )
                    ),
                    formgroup
                    (
                        checkbox
                        (
                            set(array('text' => $lang->task->multiple)),
                            set('name', 'multiple')
                        )
                    )
                ),

                formgroup
                (
                    set('label', array('text' => $lang->task->desc)),
                    textarea
                    (
                        set('name', 'desc'),
                        setClass('form-control w-740'),
                        set(array(
                            'placeholder' => '可以在编辑器直接贴图。快捷键：Command C+V',
                            'rows' => '5'
                        ))
                    )
                ),
                formgroup
                (
                    set('label', array('text' => $lang->files)),
                    formrow
                    (
                        setClass('items-center'),
                        h::label
                        (
                            set('for', 'file'),
                            setClass('btn text-primary canvas'),
                            icon('plus'),
                            span($lang->file->addFile)
                        ),
                        h::file
                        (
                            setId('file'),
                            setStyle('display', 'none'),
                            set('name', 'files'),
                        ),
                        span('(不超过50M)')
                    )
                ),
                formgroup
                (
                    set('label', array('text' => $lang->task->datePlan)),
                    formrow
                    (
                        setClass('items-center'),
                        h::date
                        (
                            setClass('form-control w-166'),
                            set('name', 'estStarted')
                        ),
                        span('至'),
                        h::date
                        (
                            setClass('form-control w-166'),
                            set('name', 'deadline')
                        )
                    )
                ),
                formgroup
                (
                    set('label', array('text' => $lang->story->mailto)),
                    select
                    (
                        setClass('w-360'),
                        set('name', 'mailto[]'),
                        set('items', array_map(function($v, $k) {return array('text' => $v, 'value' => $k, 'selected' => $k === str_replace(' ', '', $task->mailto));}, $users, array_keys($users)))
                    )
                ),
                formgroup
                (
                    set('label', array('text' => $lang->task->afterSubmit)),
                    setClass('items-center'),
                    setStyle(array('align-items' => 'center')),
                    formrow
                    (
                        array_map(function($v, $k) {return radio(
                            set('name', 'after'),
                            set(array('text' => $v, 'value' => $k, 'checked' => $k === (empty($task->id) ? 'continueAdding' : 'toTaskList')))
                        );}, $lang->task->afterChoices, array_keys($lang->task->afterChoices))
                    )
                ),
                formgroup
                (
                    formrow
                    (
                        setClass('justify-center'),
                        btn
                        (
                            set('type', 'submit'),
                            setClass('primary w-106'),
                            $lang->save
                        ),
                        btn
                        (
                            set('url', 'javascript:history.go(-1)'),
                            setClass('w-106'),
                            $lang->goback
                        )
                    )
                )
            )
        )
    )
);
