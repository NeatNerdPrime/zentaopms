<?php
declare(strict_types=1);
global $lang, $app;

$config->bug->form = new stdclass();

$config->bug->form->create = array();
$config->bug->form->create['title']       = array('required' => true,  'type' => 'string', 'filter' => 'trim');
$config->bug->form->create['openedBuild'] = array('required' => true,  'type' => 'array',  'filter' => 'join');
$config->bug->form->create['product']     = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['branch']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['module']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['project']     = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['execution']   = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['assignedTo']  = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->create['deadline']    = array('required' => false, 'type' => 'date',   'default' => null);
$config->bug->form->create['feedbackBy']  = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->create['notifyEmail'] = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->create['type']        = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->create['os']          = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->create['browser']     = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->create['relatedBug']  = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->create['color']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->create['severity']    = array('required' => false, 'type' => 'int',    'default' => 3);
$config->bug->form->create['pri']         = array('required' => false, 'type' => 'int',    'default' => 3);
$config->bug->form->create['steps']       = array('required' => false, 'type' => 'string', 'default' => $lang->bug->tplStep . $lang->bug->tplResult . $lang->bug->tplExpect, 'control' => 'editor');
$config->bug->form->create['story']       = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['task']        = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['case']        = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['caseVersion'] = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['result']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['testtask']    = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->create['mailto']      = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->create['keywords']    = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->create['status']      = array('required' => false, 'type' => 'string', 'default' => 'active');
$config->bug->form->create['issueKey']    = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->create['openedBy']    = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->bug->form->create['openedDate']  = array('required' => false, 'type' => 'date',   'default' => helper::now());

$config->bug->form->edit = array();
$config->bug->form->edit['title']          = array('required' => true,  'type' => 'string', 'filter'  => 'trim');
$config->bug->form->edit['openedBuild']    = array('required' => true,  'type' => 'array',  'filter'  => 'join');
$config->bug->form->edit['product']        = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['branch']         = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['project']        = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['execution']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['plan']           = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['module']         = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['story']          = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['task']           = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['case']           = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['testtask']       = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['duplicateBug']   = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->edit['severity']       = array('required' => false, 'type' => 'int',    'default' => 3);
$config->bug->form->edit['pri']            = array('required' => false, 'type' => 'int',    'default' => 3);
$config->bug->form->edit['type']           = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['status']         = array('required' => false, 'type' => 'string', 'default' => 'active');
$config->bug->form->edit['keywords']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['steps']          = array('required' => false, 'type' => 'string', 'default' => $lang->bug->tplStep . $lang->bug->tplResult . $lang->bug->tplExpect, 'control' => 'editor');
$config->bug->form->edit['resolution']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['resolvedBuild']  = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['assignedTo']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['feedbackBy']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['resolvedBy']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['closedBy']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['notifyEmail']    = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['uid']            = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['color']          = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->edit['os']             = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->edit['browser']        = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->edit['relatedBug']     = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->edit['mailto']         = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->edit['deadline']       = array('required' => false, 'type' => 'date',   'default' => null);
$config->bug->form->edit['resolvedDate']   = array('required' => false, 'type' => 'date',   'default' => null);
$config->bug->form->edit['closedDate']     = array('required' => false, 'type' => 'date',   'default' => null);
$config->bug->form->edit['lastEditedDate'] = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->edit['comment']        = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

global $app;
$config->bug->form->close = array();
$config->bug->form->close['status']         = array('required' => false, 'type' => 'string', 'default' => 'closed');
$config->bug->form->close['confirmed']      = array('required' => false, 'type' => 'int',    'default' => 1);
$config->bug->form->close['assignedDate']   = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->close['lastEditedBy']   = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->bug->form->close['lastEditedDate'] = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->close['closedBy']       = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->bug->form->close['closedDate']     = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->close['comment']        = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->bug->form->assignTo = array();
$config->bug->form->assignTo['assignedTo']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->assignTo['assignedDate']   = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->assignTo['lastEditedBy']   = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->bug->form->assignTo['lastEditedDate'] = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->assignTo['mailto']         = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->assignTo['comment']        = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->bug->form->resolve = array();
$config->bug->form->resolve['status']         = array('required' => false, 'type' => 'string', 'default' => 'resolved');
$config->bug->form->resolve['confirmed']      = array('required' => false, 'type' => 'int',    'default' => 1);
$config->bug->form->resolve['resolvedBuild']  = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->resolve['resolution']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->resolve['resolvedBy']     = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->bug->form->resolve['resolvedDate']   = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->resolve['assignedTo']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->resolve['assignedDate']   = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->resolve['lastEditedBy']   = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->bug->form->resolve['lastEditedDate'] = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->resolve['duplicateBug']   = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->resolve['buildName']      = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->resolve['createBuild']    = array('required' => false, 'type' => 'string', 'default' => 'off');
$config->bug->form->resolve['buildExecution'] = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->resolve['comment']        = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->bug->form->activate = array();
$config->bug->form->activate['assignedTo']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->activate['openedBuild']    = array('required' => false, 'type' => 'array',  'default' => array(), 'filter' => 'join');
$config->bug->form->activate['assignedDate']   = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->activate['lastEditedBy']   = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->bug->form->activate['lastEditedDate'] = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->activate['activatedDate']  = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->activate['resolution']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->activate['status']         = array('required' => false, 'type' => 'string', 'default' => 'active');
$config->bug->form->activate['resolvedBy']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->activate['resolvedBuild']  = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->activate['closedBy']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->activate['duplicateBug']   = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->activate['toTask']         = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->activate['toStory']        = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->activate['comment']        = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->bug->form->batchActivate = common::formConfig('bug', 'batchActivate');
$config->bug->form->batchActivate['id']             = array('required' => false, 'type' => 'int',    'base'    => true);
$config->bug->form->batchActivate['status']         = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchActivate['assignedTo']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchActivate['openedBuild']    = array('required' => true,  'type' => 'array',  'default' => '', 'filter' => 'join');
$config->bug->form->batchActivate['comment']        = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->bug->form->batchActivate['activatedDate']  = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->batchActivate['assignedDate']   = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->batchActivate['resolution']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchActivate['resolvedBy']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchActivate['resolvedDate']   = array('required' => false, 'type' => 'date',   'default' => null);
$config->bug->form->batchActivate['resolvedBuild']  = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchActivate['closedBy']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchActivate['closedDate']     = array('required' => false, 'type' => 'date',   'default' => null);
$config->bug->form->batchActivate['duplicateBug']   = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchActivate['toTask']         = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchActivate['toStory']        = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchActivate['lastEditedBy']   = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->bug->form->batchActivate['lastEditedDate'] = array('required' => false, 'type' => 'date',   'default' => helper::now());

$config->bug->form->batchCreate = common::formConfig('bug', 'batchCreate');
$config->bug->form->batchCreate['module']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchCreate['project']     = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchCreate['execution']   = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchCreate['branch']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchCreate['laneID']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchCreate['openedBuild'] = array('required' => true,  'type' => 'array',  'default' => '', 'filter' => 'join');
$config->bug->form->batchCreate['title']       = array('required' => true,  'type' => 'string', 'default' => '', 'base' => true);
$config->bug->form->batchCreate['deadline']    = array('required' => false, 'type' => 'date',   'default' => null);
$config->bug->form->batchCreate['steps']       = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->bug->form->batchCreate['type']        = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchCreate['color']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchCreate['pri']         = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchCreate['severity']    = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchCreate['os']          = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->bug->form->batchCreate['browser']     = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->bug->form->batchCreate['keywords']    = array('required' => false, 'type' => 'string', 'default' => '');

$config->bug->form->batchEdit = array();
$config->bug->form->batchEdit['id']             = array('required' => false, 'type' => 'int',    'base' => true);
$config->bug->form->batchEdit['type']           = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchEdit['severity']       = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchEdit['pri']            = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchEdit['title']          = array('required' => true,  'type' => 'string', 'default' => '');
$config->bug->form->batchEdit['color']          = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchEdit['branch']         = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchEdit['module']         = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchEdit['plan']           = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchEdit['assignedTo']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchEdit['deadline']       = array('required' => false, 'type' => 'date',   'default' => null);
$config->bug->form->batchEdit['os']             = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->bug->form->batchEdit['browser']        = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->bug->form->batchEdit['keywords']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchEdit['resolvedBy']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchEdit['resolution']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->batchEdit['duplicateBug']   = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->batchEdit['lastEditedBy']   = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->bug->form->batchEdit['lastEditedDate'] = array('required' => false, 'type' => 'date',   'default' => helper::now());

$config->bug->form->confirm = array();
$config->bug->form->confirm['pri']            = array('required' => false, 'type' => 'int',    'default' => 3);
$config->bug->form->confirm['deadline']       = array('required' => false, 'type' => 'date',   'default' => '');
$config->bug->form->confirm['type']           = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->confirm['status']         = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->confirm['mailto']         = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->confirm['assignedTo']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->confirm['assignedDate']   = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->confirm['lastEditedBy']   = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->bug->form->confirm['lastEditedDate'] = array('required' => false, 'type' => 'date',   'default' => helper::now());
$config->bug->form->confirm['comment']        = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
