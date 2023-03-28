<?php
namespace zin;

class historyrecord extends wg
{
    protected static $defineProps = array('actions:array,users:array,methodName:string');

    private function buildHistoriesList()
    {
        global $app, $lang;
        $actions    = $this->prop('actions');
        $users      = $this->prop('users');
        $methodName = $this->prop('methodName');
        $historiesListView = h::ol(setClass('histories-list'));
        $i = 1;
        foreach($actions as $action)
        {
            $canEditComment = (!isset($canBeChanged) || !empty($canBeChanged))
                && end($actions) == $action
                && trim($action->comment) !== ''
                && strpos(',view,objectlibs,viewcard,', ",$methodName,") !== false
                && $action->actor == $app->user->account
                && common::hasPriv('action', 'editComment');
                $action->actor = zget($users, $action->actor);

            if($action->action == 'assigned' || $action->action == 'toaudit') $action->extra = zget($users, $action->extra);
            if(strpos($action->actor, ':') !== false) $action->actor = substr($action->actor, strpos($action->actor, ':') + 1);

            $actionItemView = li
            (
                set::value($i++),
                html($app->loadTarget('action')->renderAction($action))
            );

            if(!empty($action->history))
            {
                $actionItemView->add
                (
                    button
                    (
                        setClass('btn btn-mini switch-btn btn-icon btn-expand'),
                        set::type('button'),
                        set::title($lang->switchDisplay),
                        h::i(setClass('change-show icon icon-plus icon-sm')),
                    )
                );
                $actionItemView->add
                (
                    div
                    (
                        setClass('history-changes'),
                        set::id("changeBox$i"),
                        html($app->loadTarget('action')->printChanges($action->objectType, $action->history)),
                    )
                );
            }
            if(strlen(trim(($action->comment))) !== 0)
            {
                if($canEditComment)
                {
                    $actionItemView->add
                    (
                        button
                        (
                            setClass('btn btn-link btn-icon btn-sm btn-edit-comment'),
                            set::title($lang->action->editComment),
                            h::i(setClass('icon icon-pencil')),
                        )
                    );
                }

                $comment = null;
                if(strpos($action->comment, '<pre class="prettyprint lang-html">') !== false)
                {
                    $before   = explode('<pre class="prettyprint lang-html">', $action->comment);
                    $after    = explode('</pre>', $before[1]);
                    $htmlCode = $after[0];
                    $comment  = $before[0] . htmlspecialchars($htmlCode) . $after[1];
                }
                else
                {
                    $comment = strip_tags($action->comment) == $action->comment
                        ? nl2br($action->comment)
                        : $action->comment;
                }

                $actionItemView->add
                (
                    div
                    (
                        setClass('article-content comment'),
                        div
                        (
                            setClass('comment-content'),
                            $comment,
                        ),
                    )
                );

                if($canEditComment)
                {
                    $actionItemView->add(
                        form
                        (
                            setClass('comment-edit-form'),
                            set::method('post'),
                            set::action(createLink('action', 'editComment', "actionID=$action->id")),
                            div
                            (
                                setClass('form-group'),
                                textarea
                                (
                                    htmlSpecialString($action->comment),
                                    set::name('lastComment'),
                                    set::rows('8'),
                                    set::autofocus('autofocus'),
                                ),
                            ),
                            div
                            (
                                setClass('form-group form-actions'),
                                button
                                (
                                    setClass('btn btn-wide btn-primary'),
                                    set::type('submit'),
                                    set::id('submit'),
                                    $lang->save,
                                ),
                                button
                                (
                                    setClass('btn btn-wide btn-hide-form'),
                                    $lang->close,
                                ),
                            ),
                        ),
                    );
                }
            }
            $historiesListView->add($actionItemView);
        }

        return $historiesListView;
    }

    protected function build()
    {
        global $lang;
        return div
        (
            setClass('detail histories'),
            set::id('actionbox'),
            set('data-textdiff', $lang->action->textDiff),
            set('data-original', $lang->action->original),
            div
            (
                setClass('detail-title'),
                span($lang->history),
                button
                (
                    setClass('btn btn-mini btn-icon btn-reverse'),
                    set::type('button'),
                    set::title($lang->reverse),
                    h::i(setClass('icon icon-arrow-up icon-sm')),
                    setStyle('margin-right', '4px'),
                ),
                button
                (
                    setClass('btn btn-mini btn-icon btn-expand-all'),
                    set::type('button'),
                    set::title($lang->switchDisplay),
                    h::i(setClass('icon icon-plus icon-sm')),
                ),
                button
                (
                    setClass('btn btn-link pull-right btn-comment'),
                    set::type('button'),
                    h::i(setClass('icon icon-chat-line'), ' ' . $lang->action->create)
                ),
            ),
            div(setClass('detail-content'), $this->buildHistoriesList())
        );
    }
}
