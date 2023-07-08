<?php
declare(strict_types=1);
/**
 * The managecontacts view file of my module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     my
 * @link        https://www.zentao.net
 */
namespace zin;

$myContactList     = array();
$publicContactList = array();
foreach($lists as $contactList)
{
    if($contactList->account == $app->user->account)
    {
        $myContactList[] = li
        (
            setClass('contact ellipsis pl-2 ' . ($list->id == $contactList->id ? 'active' : '')),
            set('data-id', $contactList->id),
            $contactList->listName
        );
    }
    else if($contactList->public)
    {
        $publicContactList[] = li
        (
            setClass('contact ellipsis pl-2'),
            set('data-id', $contactList->id),
            $contactList->listName
        );
    }
}

$userList = array();
if(!empty($list->userList))
{
    foreach(explode(',', $list->userList) as $account) $userList[] = zget($users, $account);
}

$manageTitle = $lang->my->createContacts;
if($canEdit && $list) $manageTitle = $lang->my->manageContacts;
if(!$canEdit) $manageTitle = $lang->my->viewContacts;

panel
(
    setClass('panel-form px-4 mx-auto size-lg'),
    on::click('#createContact', 'createContact'),
    on::click('.contact', 'getContact'),
    div
    (
        setID('manageContacts'),
        setClass('w-full flex'),
        cell
        (
            set::width('180px'),
            setClass('border-r overflow-hidden'),
            div
            (
                setClass('border-b py-3 pr-4'),
                div(span(setClass('text-gray'), $lang->my->contactList)),
                div
                (
                    setClass('pt-3'),
                    a
                    (
                        setID('createContact'),
                        setClass('btn primary-pale bd-primary w-full'),
                        icon('plus'),
                        $lang->my->createContacts
                    )
                )
            ),
            tabs
            (
                setID('contactTab'),
                setClass('pr-4'),
                tabPane
                (
                    set::key('my'),
                    set::title($lang->my->myContact),
                    set::active(true),
                    ul($myContactList)
                ),
                tabPane
                (
                    set::key('public'),
                    set::title($lang->my->publicContact),
                    ul($publicContactList)
                )
            )
        ),
        cell
        (
            setID('contactPanel'),
            setClass('flex-1 px-8'),
            div
            (
                set('class', 'panel-title text-lg flex w-full py-6'),
                $manageTitle
            ),
            $canEdit ? form
            (
                set::actions(array()),
                formRow
                (
                    formGroup
                    (
                        set::width('1/2'),
                        set::label($lang->user->contacts->listName),
                        input
                        (
                            set::name('listName'),
                            set::value(!empty($list->listName) ? $list->listName : '')
                        )
                    )
                ),
                formRow
                (
                    formGroup
                    (
                        set::label($lang->user->contacts->selectedUsers),
                        select
                        (
                            set::multiple(true),
                            set::name('userList[]'),
                            set::items($users),
                            set::value(!empty($list->userList) ? $list->userList : '')
                        )
                    )
                ),
                formRow
                (
                    formGroup
                    (
                        set::label(''),
                        set::width('1/1'),
                        checkbox
                        (
                            set::name('public'),
                            set::value(1),
                            set::checked(!empty($list->public)),
                            set::text($lang->my->shareContacts)
                        )
                    )
                ),
                formRow
                (
                    setClass('form-actions'),
                    formGroup
                    (
                        set::label(''),
                        button(setClass('btn primary'), set::type('submit'), $lang->save)
                    )
                )
            ) : tableData
            (
                item
                (
                    set::name($lang->user->contacts->listName),
                    $list->listName
                ),
                item
                (
                    set::name($lang->user->contacts->userList),
                    implode($lang->comma, array_filter($userList))
                )
            )
        )
    )
);

render();
