<?php
$lang->zahost->id             = 'ID';
$lang->zahost->common         = 'ZAhost';
$lang->zahost->browse         = 'Host List';
$lang->zahost->create         = 'Add Host';
$lang->zahost->view           = 'Host View';
$lang->zahost->edit           = 'Edit';
$lang->zahost->editAction     = 'Edit Host';
$lang->zahost->delete         = 'Delete';
$lang->zahost->deleteAction   = 'Delete Host';
$lang->zahost->byQuery        = 'Search';
$lang->zahost->all            = 'All';
$lang->zahost->browseNode     = 'ExecutionNode Browse';
$lang->zahost->browseTemplate = 'Template Browse';
$lang->zahost->createTemplate = 'Create Template';
$lang->zahost->editTemplate   = 'Edit Template';
$lang->zahost->deleteTemplate = 'Delete Template';

$lang->zahost->name        = 'Name';
$lang->zahost->IP          = 'IP/Domain';
$lang->zahost->extranet    = 'IP';
$lang->zahost->cpuCores    = 'CPU Cores';
$lang->zahost->memory      = 'Memory Size';
$lang->zahost->diskSize    = 'diskSize Size';
$lang->zahost->desc        = 'Description';
$lang->zahost->type        = 'Type';
$lang->zahost->status      = 'Status';

$lang->zahost->createdBy    = 'CreatedBy';
$lang->zahost->createdDate  = 'CreatedDate';
$lang->zahost->editedBy     = 'EditedBy';
$lang->zahost->editedDate   = 'EditedDate';
$lang->zahost->registerDate = 'RegisterDate';

$lang->zahost->memorySize = $lang->zahost->memory;
$lang->zahost->cpuCoreNum = $lang->zahost->cpuCores;
$lang->zahost->osType     = 'Os Version';
$lang->zahost->os         = 'System';
$lang->zahost->osVersion  = 'Os Version No';
$lang->zahost->osLang     = 'Language';
$lang->zahost->imageName  = 'Image File';

$lang->zahost->initHost = new stdclass;
$lang->zahost->initHost->checkStatus = "Check Service Status";
$lang->zahost->initHost->not_install = "Not installed";
$lang->zahost->initHost->not_available = "Installed, Not Started";
$lang->zahost->initHost->ready = "Ready";
$lang->zahost->initHost->next = "Next";
$lang->zahost->initHost->initSuccessNotice = "The initialization was successful, click Next to complete the next steps.";
$lang->zahost->initHost->initFailNoticeTitle = "Initialization failed, check the init script execution log and try the following two solutions:";
$lang->zahost->initHost->initFailNoticeDesc = "1. Re-execute the script <br/>2. Review the initialization FAQ";
$lang->zahost->initHost->serviceStatus = [
    "kvm" => 'not_install',
    "novnc" => 'not_install',
    "websockify" => 'not_install',
];
$lang->zahost->initHost->title = "Initialize Host";
$lang->zahost->initHost->descTitle = "Follow these steps to complete the initialization on the host:";
$lang->zahost->initHost->descLi = [
    "Download the init script to the host：wget https://pkg.qucheng.com/zenagent/zagentenv",
    "Execute the init script on the host and execute the command example under Ubuntu：./zagentenv"
];
$lang->zahost->initHost->statusTitle = "Service Status";

$lang->zahost->image = new stdclass;
$lang->zahost->image->list          = 'Image List';
$lang->zahost->image->browseImage   = 'Image List';
$lang->zahost->image->createImage   = 'Create Image';
$lang->zahost->image->choseImage    = 'Select Image';
$lang->zahost->image->downloadImage = 'Download Image';
$lang->zahost->image->startDowload  = 'Start Download';

$lang->zahost->image->common     = 'Image';
$lang->zahost->image->name       = 'Name';
$lang->zahost->image->desc       = 'Description';
$lang->zahost->image->memory     = $lang->zahost->memory;
$lang->zahost->image->disk       = $lang->zahost->diskSize;
$lang->zahost->image->osType     = $lang->zahost->osType;
$lang->zahost->image->os         = $lang->zahost->os;
$lang->zahost->image->osVersion  = $lang->zahost->osVersion;
$lang->zahost->image->osLang     = $lang->zahost->osLang;
$lang->zahost->image->imageName  = $lang->zahost->imageName;

$lang->zahost->image->statusList['created']    = 'Created';
$lang->zahost->image->statusList['canceled']   = 'Canceled';
$lang->zahost->image->statusList['inprogress'] = 'Inprogress';
$lang->zahost->image->statusList['completed']  = 'Completed';
$lang->zahost->image->statusList['failed']     = 'Failed';

$lang->zahost->empty         = 'No Host';

$lang->zahost->statusList['ready']  = 'Ready';
$lang->zahost->statusList['online'] = 'Online';

$lang->zahost->vsoft = 'VM Software';
$lang->zahost->softwareList['kvm'] = 'KVM';

$lang->zahost->unitList['GB'] = 'GB';
$lang->zahost->unitList['TB'] = 'TB';

$lang->zahost->zaHostType                 = 'Type';
$lang->zahost->zaHostTypeList['physical'] = 'Physical';

$lang->zahost->confirmDelete           = 'Do you want to delete this host?';

$lang->zahost->notice = new stdclass();
$lang->zahost->notice->ip              = '『%s』incorrect format!';
$lang->zahost->notice->registerCommand = 'Register command: ./zagent-host -t host -s http://%s:%s -i %s -p 8086 -secret %s';
$lang->zahost->notice->loading         = 'loading...';
$lang->zahost->notice->noImage         = 'No available image';
