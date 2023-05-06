<?php
declare(strict_types=1);

if(!isset($config->programplan->create)) $config->programplan->create = new stdclass;
$config->programplan->create->form       = array();
$config->programplan->create->formFields = array('planIDList', 'names', 'PM', 'percents', 'attributes', 'acl', 'milestone', 'begin', 'end', 'realBegan', 'realEnd', 'desc', 'orders', 'type');
foreach($config->programplan->create->formFields as $field) $config->programplan->create->form[$field] = array('required' => false, 'type' => 'array');

$config->programplan->edit = new stdClass();
$config->programplan->edit->form = array();
$config->programplan->edit->form['begin']     = array('required' => false, 'type' => 'string',     'default' => '0000-00-00');
$config->programplan->edit->form['end']       = array('required' => false, 'type' => 'string',     'default' => '0000-00-00');
$config->programplan->edit->form['realBegan'] = array('required' => false, 'type' => 'string',     'default' => '0000-00-00');
$config->programplan->edit->form['realEnd']   = array('required' => false, 'type' => 'string',     'default' => '0000-00-00');
$config->programplan->edit->form['output']    = array('required' => false, 'type' => 'array',      'default' => array());

