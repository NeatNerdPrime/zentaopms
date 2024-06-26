<?php
$lang->gitfox->common            = 'GitFox';
$lang->gitfox->browse            = 'GitFox Browse';
$lang->gitfox->search            = 'Search';
$lang->gitfox->create            = 'Create GitFox';
$lang->gitfox->edit              = 'Edit GitFox';
$lang->gitfox->view              = 'GitFox Details';
$lang->gitfox->bindUser          = 'Permission Setting';
$lang->gitfox->webhook           = 'Interface: Allow Webhook Call';
$lang->gitfox->importIssue       = 'Import Issue';
$lang->gitfox->delete            = 'Delete GitFox';
$lang->gitfox->confirmDelete     = 'Do you want to delete this GitFox server?';
$lang->gitfox->gitfoxAvatar      = 'Avatar';
$lang->gitfox->gitfoxAccount     = 'GitFox Account';
$lang->gitfox->gitfoxEmail       = 'GitFox User\'s Email';
$lang->gitfox->zentaoEmail       = 'Zentao User\'s Email';
$lang->gitfox->zentaoAccount     = 'Zentao Account';
$lang->gitfox->accountDesc       = '(System will automatically match users with the same email address)';
$lang->gitfox->bindingStatus     = 'Binding Status';
$lang->gitfox->all               = 'All';
$lang->gitfox->notBind           = 'Not bind';
$lang->gitfox->binded            = 'Binded';
$lang->gitfox->bindedError       = 'The bound user has been deleted or modified. Please bind again.';
$lang->gitfox->bindDynamic       = '%s and Zentao user %s';
$lang->gitfox->serverFail        = 'Connect to GitFox server failed, please check the GitFox server.';
$lang->gitfox->lastUpdate        = 'Last Update';
$lang->gitfox->confirmAddWebhook = 'Are you sure about creating Webhook？';
$lang->gitfox->addWebhookSuccess = 'Webhook created successfully';
$lang->gitfox->failCreateWebhook = 'Failed to create Webhook, please view the log';
$lang->gitfox->placeholderSearch = 'Enter name';

$lang->gitfox->bindStatus['binded']      = $lang->gitfox->binded;
$lang->gitfox->bindStatus['notBind']     = "<span class='text-danger'>{$lang->gitfox->notBind}</span>";
$lang->gitfox->bindStatus['bindedError'] = "<span class='text-danger'>{$lang->gitfox->bindedError}</span>";

$lang->gitfox->browseAction         = 'GitFox List';
$lang->gitfox->deleteAction         = 'Delete GitFox';
$lang->gitfox->gitfoxProject        = "GitFox Project";
$lang->gitfox->browseProject        = "GitFox Project List";
$lang->gitfox->browseUser           = "User";
$lang->gitfox->browseGroup          = "GitFox Group List";
$lang->gitfox->browseBranch         = "GitFox Branch List";
$lang->gitfox->browseTag            = "GitFox Tag List";
$lang->gitfox->browseTagPriv        = "Protected tag";
$lang->gitfox->gitfoxIssue          = "GitFox Issue";
$lang->gitfox->zentaoProduct        = 'Zentao Product';
$lang->gitfox->objectType           = 'Type'; // task, bug, story
$lang->gitfox->manageProjectMembers = 'Manage project member';
$lang->gitfox->createProject        = 'Create GitFox project';
$lang->gitfox->editProject          = 'Edit GitFox project';
$lang->gitfox->deleteProject        = 'Delete GitFox project';
$lang->gitfox->createGroup          = 'Create group';
$lang->gitfox->editGroup            = 'Edit group';
$lang->gitfox->deleteGroup          = 'Delete group';
$lang->gitfox->createUser           = 'Create user';
$lang->gitfox->editUser             = 'Edit user';
$lang->gitfox->deleteUser           = 'Delete user';
$lang->gitfox->createBranch         = 'Add branch';
$lang->gitfox->manageGroupMembers   = 'Manage group member';
$lang->gitfox->createWebhook        = 'Create Webhook';
$lang->gitfox->browseBranchPriv     = 'Protect branch';
$lang->gitfox->createTag            = 'Create Tag';
$lang->gitfox->deleteTag            = 'Delete tag';
$lang->gitfox->saveFailed           = '『%s』save failed';

$lang->gitfox->id             = 'ID';
$lang->gitfox->name           = "Server Name";
$lang->gitfox->url            = 'Server URL';
$lang->gitfox->token          = 'Token';
$lang->gitfox->defaultProject = 'Default Project';
$lang->gitfox->private        = 'MD5 Verify';

$lang->gitfox->server        = "Server List";
$lang->gitfox->lblCreate     = 'Create GitFox Server';
$lang->gitfox->desc          = 'Description';
$lang->gitfox->tokenFirst    = 'When the Token is not empty, the Token will be used first';
$lang->gitfox->tips          = 'When using a password, please disable the "Prevent cross-site request forgery" option in the GitFox global security settings.';
$lang->gitfox->emptyError    = " cannot be empty";
$lang->gitfox->createSuccess = "Create success";
$lang->gitfox->mustBindUser  = 'You have not registered the GitFox account, please contact the administrator to register.';
$lang->gitfox->noAccess      = 'Permission denied';
$lang->gitfox->notCompatible = 'The current GitFox version is not compatible with ZenTao, please upgrade the GitFox version and try again';
$lang->gitfox->deleted       = 'Deleted';

$lang->gitfox->placeholder = new stdclass;
$lang->gitfox->placeholder->name        = '';
$lang->gitfox->placeholder->url         = "Please fill in the access address of the GitFox Server homepage, as: https://gitfox.zentao.net.";
$lang->gitfox->placeholder->token       = "Please fill in the access token of an account with root privileges.";
$lang->gitfox->placeholder->projectPath = "It should contain only letters, digits, underscore, hyphen and period.  It should not start with hypen, or end with .git or .atom.";

$lang->gitfox->noImportableIssues = "There are currently no issues available for import.";
$lang->gitfox->tokenError         = "The current token is not root rights.";
$lang->gitfox->tokenLimit         = "The current token has no admin privilege. Please regenerate one with root user in GitFox.";
$lang->gitfox->hostError          = "So the current GitFox server address is invalid or the current GitFox version is not compatible with ZenTao, please confirm that the current server can be accessed or contact the administrator to upgrade the GitFox version to %s or above and try again.";
$lang->gitfox->bindUserError      = "Can not bind users repeatedly %s";
$lang->gitfox->importIssueError   = "The execution to which this issue belongs is not selected.";
$lang->gitfox->importIssueWarn    = "There is a problem of import failure, you can try to import again.";

$lang->gitfox->accessLevels[10] = 'Guest';
$lang->gitfox->accessLevels[20] = 'Reporter';
$lang->gitfox->accessLevels[30] = 'Developer';
$lang->gitfox->accessLevels[40] = 'Maintainer';
$lang->gitfox->accessLevels[50] = 'Owner';

$lang->gitfox->apiError[0]  = 'internal is not allowed in a private group.';
$lang->gitfox->apiError[1]  = 'public is not allowed in a private group.';
$lang->gitfox->apiError[2]  = 'is too short (minimum is 8 characters)';
$lang->gitfox->apiError[3]  = "can contain only letters, digits, '_', '-' and '.'. Cannot start with '-', end in '.git' or end in '.atom'";
$lang->gitfox->apiError[4]  = 'Branch already exists';
$lang->gitfox->apiError[5]  = 'Failed to save group {:path                                                                                  = >["has already been taken"]}';
$lang->gitfox->apiError[6]  = 'Failed to save group {:path                                                                                  = >["已经被使用"]}';
$lang->gitfox->apiError[7]  = '403 Forbidden';
$lang->gitfox->apiError[8]  = 'is invalid';
$lang->gitfox->apiError[9]  = 'admin is a reserved name';
$lang->gitfox->apiError[10] = 'has already been taken';
$lang->gitfox->apiError[11] = 'Missing CI config file';

$lang->gitfox->errorLang[0]  = 'You cannot set Internal as its Visibility Level, if it is private in GitFox.';
$lang->gitfox->errorLang[1]  = 'You cannot set Public as its Visibility Level, if it is private in GitFox.';
$lang->gitfox->errorLang[2]  = 'Password is too short (minimum is 8 characters)';
$lang->gitfox->errorLang[3]  = 'It should contain only letters, digits, underscore, hyphen and period.  It should not start with hypen, or end with .git or .atom.';
$lang->gitfox->errorLang[4]  = 'Branch already exists.';
$lang->gitfox->errorLang[5]  = 'Failed to save group, path has already been taken.';
$lang->gitfox->errorLang[6]  = 'Failed to save group, path has already been taken.';
$lang->gitfox->errorLang[7]  = $lang->gitfox->noAccess;
$lang->gitfox->errorLang[8]  = "Is invalid";
$lang->gitfox->errorLang[9]  = 'admin is a reserved name';
$lang->gitfox->errorLang[10] = 'has already been taken';
$lang->gitfox->errorLang[11] = 'Missing CI config file';

$lang->gitfox->errorResonse['Email has already been taken']    = 'Email has already been taken';
$lang->gitfox->errorResonse['Username has already been taken'] = 'Username has already been taken';

$lang->gitfox->featureBar['binduser']['all']     = $lang->gitfox->all;
$lang->gitfox->featureBar['binduser']['notBind'] = $lang->gitfox->notBind;
$lang->gitfox->featureBar['binduser']['binded']  = $lang->gitfox->binded;
