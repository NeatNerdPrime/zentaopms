<?php
/**
 * The en file of crm block module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->block = new stdclass();
$lang->block->common = 'InfoBlock';
$lang->block->name   = 'Name';
$lang->block->style  = 'Style';
$lang->block->grid   = 'Gitter';
$lang->block->color  = 'Farbe';
$lang->block->reset  = 'Zurücksetzen';

$lang->block->account = 'Konto';
$lang->block->module  = 'Modul';
$lang->block->title   = 'Titel';
$lang->block->source  = 'Source module';
$lang->block->block   = 'Source block';
$lang->block->order   = 'Sortierung';
$lang->block->height  = 'Höhe';
$lang->block->role    = 'Rolle';

$lang->block->lblModule    = 'Modul';
$lang->block->lblBlock     = 'InfoBlock';
$lang->block->lblNum       = 'Nummer';
$lang->block->lblHtml      = 'HTML';
$lang->block->dynamic      = 'Verlauf';
$lang->block->assignToMe   = 'Mir zugewiesen';
$lang->block->done         = 'Done';
$lang->block->lblFlowchart = 'Workflow';
$lang->block->welcome      = 'Willkommen';
$lang->block->lblTesttask  = 'Test Request Detail';
$lang->block->contribute   = 'Personal Contribution';

$lang->block->leftToday      = 'Arbeit für Heute';
$lang->block->myTask         = 'Aufgaben';
$lang->block->myStory        = 'Story';
$lang->block->myBug          = 'Bugs';
$lang->block->myProject      = '' . $lang->projectCommon;
$lang->block->myProduct      = '' . $lang->productCommon;
$lang->block->delayed        = 'Verspätet';
$lang->block->noData         = 'Keine Daten für diesen Bericht.';
$lang->block->emptyTip       = 'Keine Information';
$lang->block->createdTodo    = 'The Number Of Todos Created';
$lang->block->createdStory   = 'The Number Of Stories Created';
$lang->block->finishedTask   = 'The Number Of Tasks Resolved';
$lang->block->resolvedBug    = 'The Number Of Bugs Resolved';
$lang->block->createdCase    = 'The Number Of Test Case Created';
$lang->block->waterfall      = 'CMMI 3';
$lang->block->scrum          = 'Scrum+';
$lang->block->allProject     = 'All ' . $lang->projectCommon;
$lang->block->doingProject   = 'Doning ' . $lang->projectCommon;
$lang->block->finishProject  = 'Finish ' . $lang->projectCommon;
$lang->block->estimatedHours = 'Estimated Hours';
$lang->block->consumedHours  = 'Consumed Hours';
$lang->block->time           = 'No';
$lang->block->week           = 'Week';
$lang->block->month          = 'Month';
$lang->block->selectProduct  = 'Product selection';

$lang->block->params = new stdclass();
$lang->block->params->name  = 'Name';
$lang->block->params->value = 'Wert';

$lang->block->createBlock        = 'InfoBlock erstellen';
$lang->block->editBlock          = 'Bearbeiten';
$lang->block->ordersSaved        = 'Sortierung gespeichert.';
$lang->block->confirmRemoveBlock = 'Möchten Sie den Block löschen?';
$lang->block->noticeNewBlock     = 'ZenTao 10.+ hat neue Layouts für jeden View. Möchten Sie die neue Ansicht nutzen?';
$lang->block->confirmReset       = 'Möchten Sie das Dashboard zurücksetzen?';
$lang->block->closeForever       = 'Dauerhaft schließen';
$lang->block->confirmClose       = 'Möchten Sie den Block dauerhaft schlißen? Nach der Ausführung ist der Block nicht mehr verfügbar. Er kann unter Admin->Custom aber wieder aktiviert werden.';
$lang->block->remove             = 'Entfernen';
$lang->block->refresh            = 'Aktualisieren';
$lang->block->nbsp               = '';  
$lang->block->hidden             = 'Verstecken';
$lang->block->dynamicInfo        = "<span class='timeline-tag'>%s</span> <span class='timeline-text'>%s <em>%s</em> %s <a href='%s'>%s</a></span>";

$lang->block->productName  = $lang->productCommon . ' Name';
$lang->block->totalStory   = 'The Total ' . $lang->storyCommon;
$lang->block->totalBug     = 'The Total Bug';
$lang->block->totalRelease = 'Release The Number';

$lang->block->totalInvestment = 'Total investment';
$lang->block->totalPeople     = 'Total number';
$lang->block->spent           = 'Has Been Spent';
$lang->block->budget          = 'Budget';
$lang->block->left            = 'Residuals';

$lang->block->default['waterfall']['program']['1']['title']  = $lang->projectCommon . 'Weekly';
$lang->block->default['waterfall']['program']['1']['block']  = 'Pmmireport';
$lang->block->default['waterfall']['program']['1']['source'] = 'Program';
$lang->block->default['waterfall']['program']['1']['grid']   = 8;

$lang->block->default['waterfall']['program']['2']['title']  = 'Estimate';
$lang->block->default['waterfall']['program']['2']['block']  = 'waterfallestimate';
$lang->block->default['waterfall']['program']['2']['source'] = 'program';
$lang->block->default['waterfall']['program']['2']['grid']   = 4;

$lang->block->default['waterfall']['program']['3']['title']  = 'Plan Gantt Chart';
$lang->block->default['waterfall']['program']['3']['block']  = 'waterfallgantt';
$lang->block->default['waterfall']['program']['3']['source'] = 'program';
$lang->block->default['waterfall']['program']['3']['grid']   = 8;

$lang->block->default['waterfall']['program']['4']['title']  = 'Progress Chart';
$lang->block->default['waterfall']['program']['4']['block']  = 'waterfallprogress';
$lang->block->default['waterfall']['program']['4']['grid']   = 4;

$lang->block->default['waterfall']['program']['5']['title']  = 'Program Issue';
$lang->block->default['waterfall']['program']['5']['block']  = 'waterfallissue';
$lang->block->default['waterfall']['program']['5']['source'] = 'program';
$lang->block->default['waterfall']['program']['5']['grid']   = 8;

$lang->block->default['waterfall']['program']['5']['params']['type']    = 'all';
$lang->block->default['waterfall']['program']['5']['params']['count']   = '15';
$lang->block->default['waterfall']['program']['5']['params']['orderBy'] = 'id_desc';

$lang->block->default['waterfall']['program']['6']['title']  = 'Dynamic';
$lang->block->default['waterfall']['program']['6']['block']  = 'dynamic';
$lang->block->default['waterfall']['program']['6']['grid']   = 4;
$lang->block->default['waterfall']['program']['6']['source'] = '';

$lang->block->default['waterfall']['program']['7']['title']  = $lang->projectCommon . 'Risk';
$lang->block->default['waterfall']['program']['7']['block']  = 'waterfallrisk';
$lang->block->default['waterfall']['program']['7']['source'] = 'program';
$lang->block->default['waterfall']['program']['7']['grid']   = 8;

$lang->block->default['waterfall']['program']['7']['params']['type']    = 'all';
$lang->block->default['waterfall']['program']['7']['params']['count']   = '15';
$lang->block->default['waterfall']['program']['7']['params']['orderBy'] = 'id_desc';

$lang->block->default['scrum']['program']['1']['title'] =  $lang->projectCommon . ' Overall';
$lang->block->default['scrum']['program']['1']['block'] = 'scrumoverall';
$lang->block->default['scrum']['program']['1']['grid']  = 8;

$lang->block->default['scrum']['program']['2']['title'] = $lang->projectCommon . ' List';
$lang->block->default['scrum']['program']['2']['block'] = 'scrumlist';
$lang->block->default['scrum']['program']['2']['grid']  = 8;

$lang->block->default['scrum']['program']['3']['title'] = $lang->productCommon . ' Road Map';
$lang->block->default['scrum']['program']['3']['block'] = 'scrumroadmap';
$lang->block->default['scrum']['program']['3']['grid']  = 8;

$lang->block->default['scrum']['program']['4']['title'] = 'Test Version';
$lang->block->default['scrum']['program']['4']['block'] = 'scrumtest';
$lang->block->default['scrum']['program']['4']['grid']  = 8;

$lang->block->default['scrum']['program']['4']['params']['type']    = 'all';
$lang->block->default['scrum']['program']['4']['params']['count']   = '15';
$lang->block->default['scrum']['program']['4']['params']['orderBy'] = 'id_desc';

$lang->block->default['scrum']['program']['5']['title'] = $lang->productCommon . ' Overview';
$lang->block->default['scrum']['program']['5']['block'] = 'scrumproduct';
$lang->block->default['scrum']['program']['5']['grid']  = 4;

$lang->block->default['scrum']['program']['6']['title'] = $lang->projectCommon . ' Overview';
$lang->block->default['scrum']['program']['6']['block'] = 'sprint';
$lang->block->default['scrum']['program']['6']['grid']  = 4;

$lang->block->default['scrum']['program']['7']['title'] = 'Dynamic';
$lang->block->default['scrum']['program']['7']['block'] = 'scrumdynamic';
$lang->block->default['scrum']['program']['7']['grid']  = 4;

$lang->block->default['product']['1']['title'] = $lang->productCommon . ' Berichte';
$lang->block->default['product']['1']['block'] = 'statistic';
$lang->block->default['product']['1']['grid']  = 8;

$lang->block->default['product']['1']['params']['type']  = 'all';
$lang->block->default['product']['1']['params']['count'] = 5;

$lang->block->default['product']['2']['title'] = $lang->productCommon . ' Übersicht';
$lang->block->default['product']['2']['block'] = 'overview';
$lang->block->default['product']['2']['grid']  = 4;

$lang->block->default['product']['3']['title'] = 'Offene ' . $lang->productCommon . 's';
$lang->block->default['product']['3']['block'] = 'list';
$lang->block->default['product']['3']['grid']  = 8;

$lang->block->default['product']['3']['params']['count'] = 15;
$lang->block->default['product']['3']['params']['type']  = 'noclosed';

$lang->block->default['product']['4']['title'] = 'Meine Story';
$lang->block->default['product']['4']['block'] = 'story';
$lang->block->default['product']['4']['grid']  = 4;

$lang->block->default['product']['4']['params']['count']   = 15;
$lang->block->default['product']['4']['params']['orderBy'] = 'id_desc';
$lang->block->default['product']['4']['params']['type']    = 'assignedTo';

$lang->block->default['project']['1']['title'] = $lang->projectCommon . ' Berichte';
$lang->block->default['project']['1']['block'] = 'statistic';
$lang->block->default['project']['1']['grid']  = 8;

$lang->block->default['project']['1']['params']['type']  = 'all';
$lang->block->default['project']['1']['params']['count'] = 5;

$lang->block->default['project']['2']['title'] = $lang->projectCommon . ' Übersicht';
$lang->block->default['project']['2']['block'] = 'overview';
$lang->block->default['project']['2']['grid']  = 4;

$lang->block->default['project']['3']['title'] = 'Aktive ' . $lang->projectCommon . 's';
$lang->block->default['project']['3']['block'] = 'list';
$lang->block->default['project']['3']['grid']  = 8;

$lang->block->default['project']['3']['params']['count']   = 15;
$lang->block->default['project']['3']['params']['orderBy'] = 'id_desc';
$lang->block->default['project']['3']['params']['type']    = 'undone';

$lang->block->default['project']['4']['title'] = 'Meine Aufgaben';
$lang->block->default['project']['4']['block'] = 'task';
$lang->block->default['project']['4']['grid']  = 4;

$lang->block->default['project']['4']['params']['count'] = 15;
$lang->block->default['project']['4']['params']['orderBy'] = 'id_desc';
$lang->block->default['project']['4']['params']['type']    = 'assignedTo';

$lang->block->default['qa']['1']['title'] = 'Test Report';
$lang->block->default['qa']['1']['block'] = 'statistic';
$lang->block->default['qa']['1']['grid']  = 8;

$lang->block->default['qa']['1']['params']['type']  = 'noclosed';
$lang->block->default['qa']['1']['params']['count'] = '20';

//$lang->block->default['qa']['2']['title'] = 'Testcase Overview';
//$lang->block->default['qa']['2']['block'] = 'overview';
//$lang->block->default['qa']['2']['grid']  = 4;

$lang->block->default['qa']['2']['title'] = 'Meine Bugs';
$lang->block->default['qa']['2']['block'] = 'bug';
$lang->block->default['qa']['2']['grid']  = 4;

$lang->block->default['qa']['2']['params']['count']   = 15;
$lang->block->default['qa']['2']['params']['orderBy'] = 'id_desc';
$lang->block->default['qa']['2']['params']['type']    = 'assignedTo';

$lang->block->default['qa']['3']['title'] = 'My Case';
$lang->block->default['qa']['3']['block'] = 'case';
$lang->block->default['qa']['3']['grid']  = 4;

$lang->block->default['qa']['3']['params']['count']   = 15;
$lang->block->default['qa']['3']['params']['orderBy'] = 'id_desc';
$lang->block->default['qa']['3']['params']['type']    = 'assigntome';

$lang->block->default['qa']['4']['title'] = 'Ausstehende Builds';
$lang->block->default['qa']['4']['block'] = 'testtask';
$lang->block->default['qa']['4']['grid']  = 4;

$lang->block->default['qa']['4']['params']['count']   = 15;
$lang->block->default['qa']['4']['params']['orderBy'] = 'id_desc';
$lang->block->default['qa']['4']['params']['type']    = 'wait';

$lang->block->default['full']['my']['1']['title']  = 'Willkommen';
$lang->block->default['full']['my']['1']['block']  = 'welcome';
$lang->block->default['full']['my']['1']['grid']   = 8;
$lang->block->default['full']['my']['1']['source'] = '';

$lang->block->default['full']['my']['2']['title']  = 'Verlauf';
$lang->block->default['full']['my']['2']['block']  = 'dynamic';
$lang->block->default['full']['my']['2']['grid']   = 4;
$lang->block->default['full']['my']['2']['source'] = '';

$lang->block->default['full']['my']['3']['title']           = 'My Todos';
$lang->block->default['full']['my']['3']['block']           = 'list';
$lang->block->default['full']['my']['3']['grid']            = 4;
$lang->block->default['full']['my']['3']['source']          = 'todo';
$lang->block->default['full']['my']['3']['params']['count'] = '20';

$lang->block->default['full']['my']['4']['title']  = $lang->projectCommon . ' Statistic';
$lang->block->default['full']['my']['4']['block']  = 'statistic';
$lang->block->default['full']['my']['4']['source'] = 'program';
$lang->block->default['full']['my']['4']['grid']   = 8;

$lang->block->default['full']['my']['5']['title']  = 'Personal Contribution';
$lang->block->default['full']['my']['5']['block']  = 'contribute';
$lang->block->default['full']['my']['5']['source'] = '';
$lang->block->default['full']['my']['5']['grid']   = 4;

$lang->block->default['full']['my']['6']['title']  = 'Recent ' . $lang->projectCommon;
$lang->block->default['full']['my']['6']['block']  = 'recentprogram';
$lang->block->default['full']['my']['6']['source'] = 'program';
$lang->block->default['full']['my']['6']['grid']   = 8;

$lang->block->default['full']['my']['7']['title']  = 'Assigned To Me';
$lang->block->default['full']['my']['7']['block']  = 'task';
$lang->block->default['full']['my']['7']['grid']   = 4;

$lang->block->default['full']['my']['7']['params']['orderBy'] = 'id_desc';
$lang->block->default['full']['my']['7']['params']['count']   = '15';
$lang->block->default['full']['my']['7']['params']['type']    = 'assignedTo';

$lang->block->default['full']['my']['8']['title'] = 'Human Input';
$lang->block->default['full']['my']['8']['block'] = 'programteam';
$lang->block->default['full']['my']['8']['grid']  = 8;

$lang->block->default['full']['my']['9']['title']  = $lang->projectCommon . ' List';
$lang->block->default['full']['my']['9']['block']  = 'program';
$lang->block->default['full']['my']['9']['source'] = 'program';
$lang->block->default['full']['my']['9']['grid']   = 8;

$lang->block->default['full']['my']['9']['params']['orderBy'] = 'id_desc';
$lang->block->default['full']['my']['9']['params']['count']   = '15';

$lang->block->count   = 'Count';
$lang->block->type    = 'Type';
$lang->block->orderBy = 'Order by';

$lang->block->availableBlocks = new stdclass();

$lang->block->availableBlocks->todo     = 'Meine Todos';
$lang->block->availableBlocks->task     = 'Meine Aufgaben';
$lang->block->availableBlocks->bug      = 'Meine Bugs';
$lang->block->availableBlocks->case     = 'Meine Fälle';
$lang->block->availableBlocks->story    = 'Meine Story';
$lang->block->availableBlocks->product  = $lang->productCommon . 'Liste';
$lang->block->availableBlocks->project  = $lang->projectCommon . 'Liste';
$lang->block->availableBlocks->plan     = 'Plan';
$lang->block->availableBlocks->release  = 'Release';
$lang->block->availableBlocks->build    = 'Build';
$lang->block->availableBlocks->testtask = 'Testaufgaben';
$lang->block->availableBlocks->risk     = 'My Risks';

$lang->block->moduleList['program'] = $lang->projectCommon;
$lang->block->moduleList['product'] = $lang->productCommon;
$lang->block->moduleList['project'] = $lang->projectCommon;
$lang->block->moduleList['qa']      = 'QA';
$lang->block->moduleList['todo']    = 'Todos';

$lang->block->modules['program'] = new stdclass();
$lang->block->modules['program']->availableBlocks = new stdclass();
$lang->block->modules['program']->availableBlocks->program       = $lang->projectCommon . ' List';
$lang->block->modules['program']->availableBlocks->recentprogram = 'Recent ' . $lang->projectCommon;
$lang->block->modules['program']->availableBlocks->statistic     = $lang->projectCommon . ' Statistic';
$lang->block->modules['program']->availableBlocks->programteam   = $lang->projectCommon . 'Human Input';

$lang->block->modules['scrum']['index'] = new stdclass();
$lang->block->modules['scrum']['index']->availableBlocks = new stdclass();
$lang->block->modules['scrum']['index']->availableBlocks->scrumoverview   = $lang->projectCommon . ' Overview';
$lang->block->modules['scrum']['index']->availableBlocks->scrumlist       = $lang->projectCommon . ' List';
$lang->block->modules['scrum']['index']->availableBlocks->scrumroadmap    = $lang->productCommon . ' Rode Map';
$lang->block->modules['scrum']['index']->availableBlocks->sprint          = $lang->projectCommon . ' Overview';
$lang->block->modules['scrum']['index']->availableBlocks->scrumproduct    = $lang->productCommon . ' Overview';
$lang->block->modules['scrum']['index']->availableBlocks->scrumtest       = 'Test Version';
$lang->block->modules['scrum']['index']->availableBlocks->programdynamic  = 'Dynamics';

$lang->block->modules['waterfall']['index'] = new stdclass();
$lang->block->modules['waterfall']['index']->availableBlocks = new stdclass();
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallreport    = $lang->projectCommon . ' Weekly';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallestimate  = 'Estimate';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallgantt     = 'Plan Gantt Chart';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallprogress  = 'Progress Chart';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallissue     = $lang->projectCommon . ' Issue';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallrisk      = $lang->projectCommon . ' Risk';

$lang->block->modules['product'] = new stdclass();
$lang->block->modules['product']->availableBlocks = new stdclass();
$lang->block->modules['product']->availableBlocks->statistic = $lang->productCommon . ' Berichte';
$lang->block->modules['product']->availableBlocks->overview  = $lang->productCommon . ' Übersicht';
$lang->block->modules['product']->availableBlocks->list      = $lang->productCommon . ' Liste';
$lang->block->modules['product']->availableBlocks->story     = 'Story';
$lang->block->modules['product']->availableBlocks->plan      = 'Plan';
$lang->block->modules['product']->availableBlocks->release   = 'Release';
$lang->block->modules['project'] = new stdclass();
$lang->block->modules['project']->availableBlocks = new stdclass();
$lang->block->modules['project']->availableBlocks->statistic = $lang->projectCommon . ' Berichte';
$lang->block->modules['project']->availableBlocks->overview  = $lang->projectCommon . ' Übersicht';
$lang->block->modules['project']->availableBlocks->list  = $lang->projectCommon . ' Liste';
$lang->block->modules['project']->availableBlocks->task  = 'Aufgaben';
$lang->block->modules['project']->availableBlocks->build = 'Build';
$lang->block->modules['qa'] = new stdclass();
$lang->block->modules['qa']->availableBlocks = new stdclass();
$lang->block->modules['qa']->availableBlocks->statistic = 'Test Berichte';
//$lang->block->modules['qa']->availableBlocks->overview  = 'Testcase Overview';
$lang->block->modules['qa']->availableBlocks->bug      = 'Bugs';
$lang->block->modules['qa']->availableBlocks->case     = 'Fälle';
$lang->block->modules['qa']->availableBlocks->testtask = 'Testaufgaben';
$lang->block->modules['todo'] = new stdclass();
$lang->block->modules['todo']->availableBlocks = new stdclass();
$lang->block->modules['todo']->availableBlocks->list = 'Todos';

$lang->block->orderByList = new stdclass();

$lang->block->orderByList->product = array();
$lang->block->orderByList->product['id_asc']      = 'ID Aufsteigend';
$lang->block->orderByList->product['id_desc']     = 'ID Absteigend';
$lang->block->orderByList->product['status_asc']  = 'Status Aufsteigend';
$lang->block->orderByList->product['status_desc'] = 'Status Absteigend';

$lang->block->orderByList->project = array();
$lang->block->orderByList->project['id_asc']      = 'ID Aufsteigend';
$lang->block->orderByList->project['id_desc']     = 'ID Absteigend';
$lang->block->orderByList->project['status_asc']  = 'Status Aufsteigend';
$lang->block->orderByList->project['status_desc'] = 'Status Absteigend';

$lang->block->orderByList->task = array();
$lang->block->orderByList->task['id_asc']        = 'ID Aufsteigend';
$lang->block->orderByList->task['id_desc']       = 'ID Absteigend';
$lang->block->orderByList->task['pri_asc']       = 'Prorität Aufsteigend';
$lang->block->orderByList->task['pri_desc']      = 'Prorität Absteigend';
$lang->block->orderByList->task['estimate_asc']  = 'Schätzung Aufsteigend';
$lang->block->orderByList->task['estimate_desc'] = 'Schätzung Absteigend';
$lang->block->orderByList->task['status_asc']    = 'Status Aufsteigend';
$lang->block->orderByList->task['status_desc']   = 'Status Absteigend';
$lang->block->orderByList->task['deadline_asc']  = 'Deadline Aufsteigend';
$lang->block->orderByList->task['deadline_desc'] = 'Deadline Absteigend';

$lang->block->orderByList->bug = array();
$lang->block->orderByList->bug['id_asc']        = 'ID Aufsteigend';
$lang->block->orderByList->bug['id_desc']       = 'ID Absteigend';
$lang->block->orderByList->bug['pri_asc']       = 'Priorität Aufsteigend';
$lang->block->orderByList->bug['pri_desc']      = 'Priorität Absteigend';
$lang->block->orderByList->bug['severity_asc']  = 'Dringlichkeit Aufsteigend';
$lang->block->orderByList->bug['severity_desc'] = 'Dringlichkeit Absteigend';

$lang->block->orderByList->case = array();
$lang->block->orderByList->case['id_asc']   = 'ID Aufsteigend';
$lang->block->orderByList->case['id_desc']  = 'ID Absteigend';
$lang->block->orderByList->case['pri_asc']  = 'Priorität Aufsteigend';
$lang->block->orderByList->case['pri_desc'] = 'Priorität Absteigend';

$lang->block->orderByList->story = array();
$lang->block->orderByList->story['id_asc']      = 'ID Aufsteigend';
$lang->block->orderByList->story['id_desc']     = 'ID Absteigend';
$lang->block->orderByList->story['pri_asc']     = 'Priorität Aufsteigend';
$lang->block->orderByList->story['pri_desc']    = 'Priorität Absteigend';
$lang->block->orderByList->story['status_asc']  = 'Status Aufsteigend';
$lang->block->orderByList->story['status_desc'] = 'Status Absteigend';
$lang->block->orderByList->story['stage_asc']   = 'Phase Aufsteigend';
$lang->block->orderByList->story['stage_desc']  = 'Phase Absteigend';

$lang->block->todoNum = 'Todos';
$lang->block->taskNum = 'Aufgaben';
$lang->block->bugNum  = 'Bugs';
$lang->block->riskNum = 'Risk';

$lang->block->typeList = new stdclass();

$lang->block->typeList->task['assignedTo'] = 'Mir zugewiesen';
$lang->block->typeList->task['openedBy']   = 'Von mir erstellt';
$lang->block->typeList->task['finishedBy'] = 'Von mir abgeschlossen';
$lang->block->typeList->task['closedBy']   = 'Von mir geschlossen';
$lang->block->typeList->task['canceledBy'] = 'Von mir abgebrochen';

$lang->block->typeList->bug['assignedTo'] = 'Mir zugewiesen';
$lang->block->typeList->bug['openedBy']   = 'Von mir erstellt';
$lang->block->typeList->bug['resolvedBy'] = 'Von mir gelöst';
$lang->block->typeList->bug['closedBy']   = 'Von mir geschlossen';

$lang->block->typeList->case['assigntome'] = 'Mir zugewiesen';
$lang->block->typeList->case['openedbyme'] = 'Von mir erstellt';

$lang->block->typeList->story['assignedTo'] = 'Mir zugewiesen';
$lang->block->typeList->story['openedBy']   = 'Von mir erstellt';
$lang->block->typeList->story['reviewedBy'] = 'Von mir überprüft';
$lang->block->typeList->story['closedBy']   = 'Von mir geschlossen' ;
 
$lang->block->typeList->product['noclosed'] = 'Offen';
$lang->block->typeList->product['closed']   = 'Geschlossen';
$lang->block->typeList->product['all']      = 'Alle';
$lang->block->typeList->product['involved'] = 'Beteiligt';

$lang->block->typeList->project['undone']   = 'Nicht abgeschlossen';
$lang->block->typeList->project['doing']    = 'In Arbeit';
$lang->block->typeList->project['all']      = 'Alle';
$lang->block->typeList->project['involved'] = 'Betieligt';

$lang->block->typeList->scrum['undone']   = 'Unfinished';
$lang->block->typeList->scrum['doing']    = 'Ongoing中';
$lang->block->typeList->scrum['all']      = 'All';
$lang->block->typeList->scrum['involved'] = 'Involved';

$lang->block->typeList->testtask['wait']    = 'Wartend';
$lang->block->typeList->testtask['doing']   = 'In Arbeit';
$lang->block->typeList->testtask['blocked'] = 'Blockiert';
$lang->block->typeList->testtask['done']    = 'Erledigt';
$lang->block->typeList->testtask['all']     = 'Alle';

$lang->block->modules['program']->moreLinkList = new stdclass();
$lang->block->modules['program']->moreLinkList->recentprogram  = 'program|browse|';
$lang->block->modules['program']->moreLinkList->statistic      = 'program|browse|';
$lang->block->modules['program']->moreLinkList->program        = 'program|browse|';
$lang->block->modules['program']->moreLinkList->cmmireport     = 'weekly|index|';
$lang->block->modules['program']->moreLinkList->cmmiestimate   = 'workestimation|index|';
$lang->block->modules['program']->moreLinkList->cmmiissue      = 'issue|browse|';
$lang->block->modules['program']->moreLinkList->cmmirisk       = 'risk|browse|';
$lang->block->modules['program']->moreLinkList->scrumlist      = 'project|all|';
$lang->block->modules['program']->moreLinkList->scrumtest      = 'testtask|browse|';
$lang->block->modules['program']->moreLinkList->scrumproduct   = 'product|all|';
$lang->block->modules['program']->moreLinkList->sprint         = 'project|all|';
$lang->block->modules['program']->moreLinkList->programdynamic = 'company|dynamic|';

$lang->block->modules['product']->moreLinkList        = new stdclass();
$lang->block->modules['product']->moreLinkList->list  = 'product|all|product=&line=0&status=%s';
$lang->block->modules['product']->moreLinkList->story = 'my|story|type=%s';

$lang->block->modules['project']->moreLinkList = new stdclass();
$lang->block->modules['project']->moreLinkList->list  = 'project|all|status=%s&project=';
$lang->block->modules['project']->moreLinkList->task  = 'my|task|type=%s';

$lang->block->modules['qa']->moreLinkList = new stdclass();
$lang->block->modules['qa']->moreLinkList->bug      = 'my|bug|type=%s';
$lang->block->modules['qa']->moreLinkList->case     = 'my|testcase|type=%s';
$lang->block->modules['qa']->moreLinkList->testtask = 'testtask|browse|type=%s';

$lang->block->modules['todo']->moreLinkList = new stdclass();
$lang->block->modules['todo']->moreLinkList->list = 'my|todo|type=all';

$lang->block->modules['common']               = new stdclass();
$lang->block->modules['common']->moreLinkList = new stdclass();
$lang->block->modules['common']->moreLinkList->dynamic = 'company|dynamic|';

$lang->block->welcomeList['06:00'] = 'Guten Morgen, %s';
$lang->block->welcomeList['11:30'] = 'Guten Tag, %s';
$lang->block->welcomeList['13:30'] = 'Guten Tag, %s';
$lang->block->welcomeList['19:00'] = 'Guten Abend, %s';

$lang->block->gridOptions[8] = 'Links';
$lang->block->gridOptions[4] = 'Rechts';

$lang->block->flowchart   = array();
$lang->block->flowchart['admin']   = array('Administrator', 'Abteilung erstellen', 'Benutzer erstellen', 'Rechte pflegen');
$lang->block->flowchart['product'] = array($lang->productCommon . ' Besitzer', $lang->productCommon . ' erstellen', 'Module pflegen', 'Pläne pflegen', 'Storys pflegen', 'Release erstellen');
$lang->block->flowchart['project'] = array('Scrum Master', $lang->projectCommon  . ' erstellen', 'Teams pflegen', $lang->productCommon . ' verknüpfen', 'Storys verknüpfen', 'Aufgaben aufteilen');
$lang->block->flowchart['dev']     = array('Entwickler', 'Aufgabe/Bugs anfordern', 'Update Status', 'Aufgaben/Bugs abschließen');
$lang->block->flowchart['tester']  = array('QS Team', 'Fälle erstellen', 'Fälle ausführen', 'Bug Berichte', 'Bugs überprüfen', 'Bugs schließen');
