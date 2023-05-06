<?php
$config->task->form = new stdclass();

global $app;
$config->task->form->create = array();
$config->task->form->create['execution']    = array('type' => 'int', 'required' => true);
$config->task->form->create['type']         = array('type' => 'string', 'required' => true, 'default' => '');
$config->task->form->create['module']       = array('type' => 'int', 'required' => false);
$config->task->form->create['story']        = array('type' => 'int', 'required' => false);
$config->task->form->create['mode']         = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->create['color']        = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->create['name']         = array('type' => 'string', 'required' => true, 'default' => '');
$config->task->form->create['pri']          = array('type' => 'int', 'required' => false, 'default' => 3);
$config->task->form->create['estimate']     = array('type' => 'float', 'required' => false, 'default' => 0);
$config->task->form->create['desc']         = array('type' => 'string', 'required' => false);
$config->task->form->create['estStarted']   = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->create['deadline']     = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->create['vision']       = array('type' => 'string', 'required' => false, 'default' => $config->vision);
$config->task->form->create['status']       = array('type' => 'string', 'required' => false, 'default' => 'wait');
$config->task->form->create['openedBy']     = array('type' => 'string', 'required' => false, 'default' => $app->user->account);
$config->task->form->create['openedDate']   = array('type' => 'string', 'required' => false, 'default' => helper::now());
$config->task->form->create['mailto']       = array('type' => 'array', 'required' => false, 'default' => array());
$config->task->form->create['version']      = array('type' => 'int', 'required' => false, 'default' => 1);

$config->task->form->assign = array();
$config->task->form->assign['assignedTo']     = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->assign['left']           = array('type' => 'float', 'required' => true);
$config->task->form->assign['lastEditedBy']   = array('type' => 'string', 'required' => false, 'default' => $app->user->account);
$config->task->form->assign['lastEditedDate'] = array('type' => 'string', 'required' => false, 'default' => helper::now());
$config->task->form->assign['assignedDate']   = array('type' => 'string', 'required' => false, 'default' => helper::now());

$config->task->form->edit = array();
$config->task->form->edit['name']         = array('type' => 'string', 'required' => true);
$config->task->form->edit['color']        = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['desc']         = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['lastEditedBy'] = array('type' => 'string', 'required' => false, 'default' => $app->user->account);
$config->task->form->edit['execution']    = array('type' => 'int', 'required' => true);
$config->task->form->edit['story']        = array('type' => 'int', 'required' => false, 'default' => 0);
$config->task->form->edit['module']       = array('type' => 'int', 'required' => false, 'default' => 0);
$config->task->form->edit['parent']       = array('type' => 'int', 'required' => false, 'default' => 0);
$config->task->form->edit['mailto']       = array('type' => 'array', 'required' => false, 'default' => array());
$config->task->form->edit['mode']         = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['assignedTo']   = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['type']         = array('type' => 'string', 'required' => true);
$config->task->form->edit['status']       = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['pri']          = array('type' => 'int', 'required' => false, 'default' => 0);
$config->task->form->edit['estStarted']   = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['deadline']     = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['estimate']     = array('type' => 'float', 'required' => false, 'default' => 0);
$config->task->form->edit['left']         = array('type' => 'float', 'required' => false, 'default' => 0);
$config->task->form->edit['consumed']     = array('type' => 'float', 'required' => false, 'default' => 0);
$config->task->form->edit['realStarted']  = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['finishedBy']   = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['finishedDate'] = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['canceledBy']   = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['canceledDate'] = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['closedBy']     = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['closedReason'] = array('type' => 'string', 'required' => false, 'default' => '');
$config->task->form->edit['closedDate']   = array('type' => 'string', 'required' => false, 'default' => '');
