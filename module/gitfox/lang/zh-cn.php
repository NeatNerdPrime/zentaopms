<?php
$lang->gitfox->common            = 'GitFox';
$lang->gitfox->browse            = '浏览GitFox';
$lang->gitfox->search            = '搜索';
$lang->gitfox->create            = '添加GitFox';
$lang->gitfox->edit              = '编辑GitFox';
$lang->gitfox->view              = 'GitFox详情';
$lang->gitfox->bindUser          = '权限设置';
$lang->gitfox->webhook           = '接口：允许Webhook调用';
$lang->gitfox->importIssue       = '关联Issue';
$lang->gitfox->delete            = '删除GitFox';
$lang->gitfox->confirmDelete     = '确认删除该GitFox吗？';
$lang->gitfox->gitfoxAvatar      = '头像';
$lang->gitfox->gitfoxAccount     = 'GitFox用户';
$lang->gitfox->gitfoxEmail       = 'GitFox用户邮箱';
$lang->gitfox->zentaoEmail       = '禅道用户邮箱';
$lang->gitfox->zentaoAccount     = '禅道用户';
$lang->gitfox->accountDesc       = '(系统会将相同邮箱地址的用户自动匹配)';
$lang->gitfox->bindingStatus     = '绑定状态';
$lang->gitfox->all               = '全部';
$lang->gitfox->notBind           = '未绑定';
$lang->gitfox->binded            = '已绑定';
$lang->gitfox->bindedError       = '绑定的用户已删除或者已修改，请重新绑定';
$lang->gitfox->bindDynamic       = '%s与禅道用户%s';
$lang->gitfox->serverFail        = '连接GitFox服务器异常，请检查GitFox服务器。';
$lang->gitfox->lastUpdate        = '最后更新';
$lang->gitfox->confirmAddWebhook = '您确定创建Webhook吗？';
$lang->gitfox->addWebhookSuccess = 'Webhook创建成功';
$lang->gitfox->failCreateWebhook = 'Webhook创建失败，请查看日志';
$lang->gitfox->placeholderSearch = '请输入名称';

$lang->gitfox->bindStatus['binded']      = $lang->gitfox->binded;
$lang->gitfox->bindStatus['notBind']     = "<span class='text-danger'>{$lang->gitfox->notBind}</span>";
$lang->gitfox->bindStatus['bindedError'] = "<span class='text-danger'>{$lang->gitfox->bindedError}</span>";

$lang->gitfox->browseAction         = 'GitFox列表';
$lang->gitfox->deleteAction         = '删除GitFox';
$lang->gitfox->gitfoxProject        = "{$lang->gitfox->common}项目";
$lang->gitfox->browseProject        = "GitFox项目列表";
$lang->gitfox->browseUser           = "用户";
$lang->gitfox->browseGroup          = "GitFox群组列表";
$lang->gitfox->browseBranch         = "GitFox分支列表";
$lang->gitfox->browseTag            = "GitFox标签列表";
$lang->gitfox->browseTagPriv        = "标签保护管理";
$lang->gitfox->gitfoxIssue          = "{$lang->gitfox->common} issue";
$lang->gitfox->zentaoProduct        = '禅道产品';
$lang->gitfox->objectType           = '类型'; // task, bug, story
$lang->gitfox->manageProjectMembers = '项目成员管理';
$lang->gitfox->createProject        = '添加GitFox项目';
$lang->gitfox->editProject          = '编辑GitFox项目';
$lang->gitfox->deleteProject        = '删除GitFox项目';
$lang->gitfox->createGroup          = '添加群组';
$lang->gitfox->editGroup            = '编辑群组';
$lang->gitfox->deleteGroup          = '删除群组';
$lang->gitfox->createUser           = '添加用户';
$lang->gitfox->editUser             = '编辑用户';
$lang->gitfox->deleteUser           = '删除用户';
$lang->gitfox->createBranch         = '添加分支';
$lang->gitfox->manageGroupMembers   = '群组成员管理';
$lang->gitfox->createWebhook        = '创建Webhook';
$lang->gitfox->browseBranchPriv     = '分支保护管理';
$lang->gitfox->createTag            = '创建标签';
$lang->gitfox->deleteTag            = '删除标签';
$lang->gitfox->svaeFailed           = '『%s』保存失败';

$lang->gitfox->id             = 'ID';
$lang->gitfox->name           = "应用名称";
$lang->gitfox->url            = '服务器地址';
$lang->gitfox->token          = 'Token';
$lang->gitfox->defaultProject = '默认项目';
$lang->gitfox->private        = 'MD5验证';

$lang->gitfox->server        = "服务器列表";
$lang->gitfox->lblCreate     = '添加GitFox服务器';
$lang->gitfox->desc          = '描述';
$lang->gitfox->tokenFirst    = 'Token不为空时，优先使用Token。';
$lang->gitfox->tips          = '使用密码时，请在GitFox全局安全设置中禁用"防止跨站点请求伪造"选项。';
$lang->gitfox->emptyError    = "不能为空";
$lang->gitfox->createSuccess = "创建成功";
$lang->gitfox->mustBindUser  = '您还未绑定GitFox用户，请联系管理员进行绑定';
$lang->gitfox->noAccess      = '权限不足';
$lang->gitfox->notCompatible = '当前GitFox版本与禅道不兼容，请升级GitFox版本后重试';
$lang->gitfox->deleted       = '已删除';

$lang->gitfox->placeholder = new stdclass;
$lang->gitfox->placeholder->name        = '';
$lang->gitfox->placeholder->url         = "请填写GitFox Server首页的访问地址，如：https://gitfox.zentao.net。";
$lang->gitfox->placeholder->token       = "请填写具有root权限账户的access token";
$lang->gitfox->placeholder->projectPath = "项目标识串只能包含字母、数字、“_”、“-”和“.”。不能以“-”开头，以.git或者.atom结尾";

$lang->gitfox->noImportableIssues = "目前没有可供导入的issue。";
$lang->gitfox->tokenError         = "当前token非root权限。";
$lang->gitfox->tokenLimit         = "GitFox Token权限不足。请更换为有root权限的GitFox Token。";
$lang->gitfox->hostError          = "当前GitFox服务器地址无效或当前GitFox版本与禅道不兼容，请确认当前服务器可被访问或联系管理员升级GitFox至%s及以上版本后重试";
$lang->gitfox->bindUserError      = "不能重复绑定用户 %s";
$lang->gitfox->importIssueError   = "未选择该issue所属的执行。";
$lang->gitfox->importIssueWarn    = "存在导入失败的issue，可再次尝试导入。";

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
$lang->gitfox->apiError[5]  = 'Failed to save group {:path=>["has already been taken"]}';
$lang->gitfox->apiError[6]  = 'Failed to save group {:path=>["已经被使用"]}';
$lang->gitfox->apiError[7]  = '403 Forbidden';
$lang->gitfox->apiError[8]  = 'is invalid';
$lang->gitfox->apiError[9]  = 'admin is a reserved name';
$lang->gitfox->apiError[10] = 'has already been taken';
$lang->gitfox->apiError[11] = 'Missing CI config file';

$lang->gitfox->errorLang[0]  = '私有分组的项目，可见性级别不能设为内部。';
$lang->gitfox->errorLang[1]  = '私有分组的项目，可见性级别不能设为公开。';
$lang->gitfox->errorLang[2]  = '密码太短（最少8个字符）';
$lang->gitfox->errorLang[3]  = "只能包含字母、数字、'.'-'和'.'。不能以'-'开头、以'.git'结尾或以'.atom'结尾。";
$lang->gitfox->errorLang[4]  = '分支名已存在。';
$lang->gitfox->errorLang[5]  = '保存失败，群组URL路径已经被使用。';
$lang->gitfox->errorLang[6]  = '保存失败，群组URL路径已经被使用。';
$lang->gitfox->errorLang[7]  = $lang->gitfox->noAccess;
$lang->gitfox->errorLang[8]  = '格式错误';
$lang->gitfox->errorLang[9]  = 'admin是保留名';
$lang->gitfox->errorLang[10] = 'GitFox项目已存在';
$lang->gitfox->errorLang[11] = '缺少CI配置文件';

$lang->gitfox->errorResonse['Email has already been taken']    = '邮箱已存在';
$lang->gitfox->errorResonse['Username has already been taken'] = '用户名已存在';

$lang->gitfox->project = new stdclass;
$lang->gitfox->project->id                         = "项目ID";
$lang->gitfox->project->name                       = "项目名称";
$lang->gitfox->project->create                     = "添加GitFox项目";
$lang->gitfox->project->edit                       = "编辑GitFox项目";
$lang->gitfox->project->url                        = "项目 URL";
$lang->gitfox->project->path                       = "项目标识串";
$lang->gitfox->project->description                = "项目描述";
$lang->gitfox->project->visibility                 = "可见性级别";
$lang->gitfox->project->visibilityList['private']  = "私有(项目访问必须明确授予每个用户。 如果此项目是在一个群组中，群组成员将会获得访问权限)";
$lang->gitfox->project->visibilityList['internal'] = "内部(除外部用户外，任何登录用户均可访问该项目)";
$lang->gitfox->project->visibilityList['public']   = "公开(该项目允许任何人访问)";
$lang->gitfox->project->star                       = "星标";
$lang->gitfox->project->fork                       = "派生";
$lang->gitfox->project->mergeRequests              = "合并请求";
$lang->gitfox->project->issues                     = "议题";
$lang->gitfox->project->tagList                    = "主题";
$lang->gitfox->project->tagListTips                = "用逗号分隔主题。";
$lang->gitfox->project->emptyNameError             = "项目名称不能为空";
$lang->gitfox->project->emptyPathError             = "项目标识串不能为空";
$lang->gitfox->project->confirmDelete              = '确认删除该GitFox项目吗？';
$lang->gitfox->project->notbindedError             = '还没绑定GitFox用户，无法修改权限！';
$lang->gitfox->project->publicTip                  = '当前项目的可见性级别将修改为公开，该项目可以在GitFox中没有任何身份验证的情况下被访问';

$lang->gitfox->user = new stdclass;
$lang->gitfox->user->id             = "用户ID";
$lang->gitfox->user->name           = "名称";
$lang->gitfox->user->username       = "用户名";
$lang->gitfox->user->email          = "邮箱";
$lang->gitfox->user->password       = "密码";
$lang->gitfox->user->passwordRepeat = "请重复密码";
$lang->gitfox->user->projectsLimit  = "限制项目";
$lang->gitfox->user->canCreateGroup = "可创建组";
$lang->gitfox->user->external       = "外部人员";
$lang->gitfox->user->externalTip    = "除非明确授予访问权限，否则外部用户无法查看内部或私有项目。另外，外部用户无法创建项目，群组或个人代码片段。";
$lang->gitfox->user->bind           = "禅道用户";
$lang->gitfox->user->avatar         = "头像";
$lang->gitfox->user->skype          = "Skype";
$lang->gitfox->user->linkedin       = "Linkedin";
$lang->gitfox->user->twitter        = "Twitter";
$lang->gitfox->user->websiteUrl     = "网站地址";
$lang->gitfox->user->note           = "备注";
$lang->gitfox->user->createOn       = "创建于";
$lang->gitfox->user->lastActivity   = "上次活动";
$lang->gitfox->user->create         = "添加GitFox用户";
$lang->gitfox->user->edit           = "编辑GitFox用户";
$lang->gitfox->user->emptyError     = "不能为空";
$lang->gitfox->user->passwordError  = "二次密码不一致！";
$lang->gitfox->user->bindError      = "该用户已经被绑定！";
$lang->gitfox->user->confirmDelete  = '确认删除该GitFox用户吗？';

$lang->gitfox->group = new stdclass;
$lang->gitfox->group->id                                      = "群组ID";
$lang->gitfox->group->name                                    = "群组名称";
$lang->gitfox->group->path                                    = "群组URL";
$lang->gitfox->group->pathTip                                 = "更改群组URL可能会有意想不到的副作用。";
$lang->gitfox->group->description                             = "群组描述";
$lang->gitfox->group->avatar                                  = "群组头像";
$lang->gitfox->group->avatarTip                               = '文件最大支持200k.';
$lang->gitfox->group->visibility                              = "可见性级别";
$lang->gitfox->group->visibilityList['private']               = "私有(群组及其项目只能由成员查看)";
$lang->gitfox->group->visibilityList['internal']              = "内部(除外部用户外，任何登录用户均可查看该组和任何内部项目)";
$lang->gitfox->group->visibilityList['public']                = "公开(群组和任何公共项目可以在没有任何身份验证的情况下查看)";
$lang->gitfox->group->permission                              = '许可';
$lang->gitfox->group->requestAccessEnabledTip                 = "允许用户请求访问(如果可见性是公开或内部的)";
$lang->gitfox->group->lfsEnabled                              = '大文件存储';
$lang->gitfox->group->lfsEnabledTip                           = "允许该组内的项目使用 Git LFS(可以在每个项目中覆盖此设置)";
$lang->gitfox->group->projectCreationLevel                    = "创建项目权限";
$lang->gitfox->group->projectCreationLevelList['noone']       = "禁止";
$lang->gitfox->group->projectCreationLevelList['maintainer']  = "维护者";
$lang->gitfox->group->projectCreationLevelList['developer']   = "开发者 + 维护者";
$lang->gitfox->group->subgroupCreationLevel                   = "创建子群组权限";
$lang->gitfox->group->subgroupCreationLevelList['owner']      = "所有者";
$lang->gitfox->group->subgroupCreationLevelList['maintainer'] = "维护者";
$lang->gitfox->group->create                                  = "添加群组";
$lang->gitfox->group->edit                                    = "编辑群组";
$lang->gitfox->group->createOn                                = "创建于";
$lang->gitfox->group->members                                 = "群组成员";
$lang->gitfox->group->confirmDelete                           = '确认删除该GitFox群组吗？';
$lang->gitfox->group->emptyError                              = "不能为空";
$lang->gitfox->group->manageMembers                           = '群组成员管理';
$lang->gitfox->group->memberName                              = '账号';
$lang->gitfox->group->memberAccessLevel                       = '角色权限';
$lang->gitfox->group->memberExpiresAt                         = '过期时间';
$lang->gitfox->group->repeatError                             = "群组成员不能重复添加";
$lang->gitfox->group->publicTip                               = '当前群组的可见性级别将修改为公开，该群组可以在GitFox中没有任何身份验证的情况下被访问';

$lang->gitfox->branch = new stdclass();
$lang->gitfox->branch->name                        = '分支名';
$lang->gitfox->branch->from                        = '创建自';
$lang->gitfox->branch->create                      = '创建';
$lang->gitfox->branch->lastCommitter               = '最后提交';
$lang->gitfox->branch->lastCommittedDate           = '最后修改时间';
$lang->gitfox->branch->accessLevel                 = "分支保护列表";
$lang->gitfox->branch->mergeAllowed                = "允许合并";
$lang->gitfox->branch->pushAllowed                 = "允许推送";
$lang->gitfox->branch->placeholderSearch           = "请输入分支名称";
$lang->gitfox->branch->placeholderSelect           = "请选择分支";
$lang->gitfox->branch->confirmDelete               = '确定删除分支保护？';
$lang->gitfox->branch->branchCreationLevelList[40] = "维护者";
$lang->gitfox->branch->branchCreationLevelList[30] = "开发者 + 维护者";
$lang->gitfox->branch->branchCreationLevelList[0]  = "禁止";
$lang->gitfox->branch->emptyPrivNameError          = "分支不能为空";
$lang->gitfox->branch->issetPrivNameError          = "已存在该保护分支";

$lang->gitfox->tag = new stdclass();
$lang->gitfox->tag->name               = '标签名';
$lang->gitfox->tag->ref                = '创建自';
$lang->gitfox->tag->lastCommitter      = '最后提交';
$lang->gitfox->tag->lastCommittedDate  = '最后修改时间';
$lang->gitfox->tag->placeholderSearch  = "请输入标签名称";
$lang->gitfox->tag->message            = '信息';
$lang->gitfox->tag->emptyNameError     = "标签名不能为空";
$lang->gitfox->tag->emptyRefError      = "创建自不能为空";
$lang->gitfox->tag->issetNameError     = "已存在该标签";
$lang->gitfox->tag->confirmDelete      = '确认删除该GitFox标签吗？';
$lang->gitfox->tag->protected          = '受保护';
$lang->gitfox->tag->accessLevel        = '允许创建';
$lang->gitfox->tag->protectConfirmDel  = '确认删除该GitFox标签保护吗？';
$lang->gitfox->tag->emptyPrivNameError = "标签不能为空";
$lang->gitfox->tag->issetPrivNameError = "已存在该保护标签";

$lang->gitfox->featureBar['binduser']['all']     = $lang->gitfox->all;
$lang->gitfox->featureBar['binduser']['notBind'] = $lang->gitfox->notBind;
$lang->gitfox->featureBar['binduser']['binded']  = $lang->gitfox->binded;
