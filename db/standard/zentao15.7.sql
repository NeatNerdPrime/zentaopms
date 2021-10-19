CREATE TABLE `zt_acl`
(
    `id`         mediumint(9) NOT NULL AUTO_INCREMENT,
    `account`    char(30) NOT NULL,
    `objectType` char(30) NOT NULL,
    `objectID`   mediumint(9) NOT NULL DEFAULT 0,
    `type`       char(40) NOT NULL DEFAULT 'whitelist',
    `source`     char(30) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_action`
(
    `id`         mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `objectType` varchar(30)  NOT NULL DEFAULT '',
    `objectID`   mediumint(8) unsigned NOT NULL DEFAULT 0,
    `product`    varchar(255) NOT NULL,
    `project`    mediumint(8) unsigned NOT NULL,
    `execution`  mediumint(8) unsigned NOT NULL,
    `actor`      varchar(100) NOT NULL DEFAULT '',
    `action`     varchar(30)  NOT NULL DEFAULT '',
    `date`       datetime     NOT NULL,
    `comment`    text         NOT NULL,
    `extra`      text         NOT NULL,
    `read`       enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY          `date` (`date`),
    KEY          `actor` (`actor`),
    KEY          `project` (`project`),
    KEY          `action` (`action`),
    KEY          `objectID` (`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_api_lib_release`
(
    `id`        int UNSIGNED NOT NULL AUTO_INCREMENT,
    `lib`       int UNSIGNED NOT NULL DEFAULT 0,
    `desc`      varchar(255) NOT NULL DEFAULT '',
    `version`   varchar(255) NOT NULL DEFAULT '',
    `snap`      mediumtext   NOT NULL,
    `addedBy`   varchar(30)  NOT NULL DEFAULT 0,
    `addedDate` datetime     NOT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `zt_api`
(
    `id`              int UNSIGNED NOT NULL AUTO_INCREMENT,
    `product`         varchar(255) NOT NULL DEFAULT '',
    `lib`             int UNSIGNED NOT NULL DEFAULT 0,
    `module`          int UNSIGNED NOT NULL DEFAULT 0,
    `title`           varchar(100) NOT NULL DEFAULT '',
    `path`            varchar(255) NOT NULL DEFAULT '',
    `protocol`        varchar(10)  NOT NULL DEFAULT '',
    `method`          varchar(10)  NOT NULL DEFAULT '',
    `requestType`     varchar(100) NOT NULL DEFAULT '',
    `responseType`    varchar(100) NOT NULL DEFAULT '',
    `status`          varchar(20)  NOT NULL DEFAULT '',
    `owner`           varchar(30)  NOT NULl DEFAULT 0,
    `desc`            text NULL,
    `version`         smallint UNSIGNED NOT NULL DEFAULT 0,
    `params`          text NULL,
    `paramsExample`   text NUll,
    `responseExample` text NUll,
    `response`        text NULL,
    `commonParams`    text NULL,
    `addedBy`         varchar(30)  NOT NULL DEFAULT 0,
    `addedDate`       datetime     NOT NULL,
    `editedBy`        varchar(30)  NOT NULL DEFAULT 0,
    `editedDate`      datetime     NOT NULL,
    `deleted`         enum ('0', '1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
);
CREATE TABLE `zt_apispec`
(
    `id`              int UNSIGNED NOT NULL AUTO_INCREMENT,
    `doc`             int UNSIGNED NOT NULL DEFAULT 0,
    `module`          int UNSIGNED NOT NULL DEFAULT 0,
    `title`           varchar(100) NOT NULL DEFAULT '',
    `path`            varchar(255) NOT NULL DEFAULT '',
    `protocol`        varchar(10)  NOT NULL DEFAULT '',
    `method`          varchar(10)  NOT NULL DEFAULT '',
    `requestType`     varchar(100) NOT NULL DEFAULT '',
    `responseType`    varchar(100) NOT NULL DEFAULT '',
    `status`          varchar(20)  NOT NULL DEFAULT '',
    `owner`           varchar(255) NOT NULl DEFAULT 0,
    `desc`            text NULL,
    `version`         smallint UNSIGNED NOT NULL DEFAULT 0,
    `params`          text NULL,
    `paramsExample`   text NUll,
    `responseExample` text NUll,
    `response`        text NULL,
    `addedBy`         varchar(30)  NOT NULL DEFAULT 0,
    `addedDate`       datetime NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `zt_apistruct`
(
    `id`         int unsigned NOT NULL AUTO_INCREMENT,
    `lib`        int UNSIGNED NOT NULL DEFAULT 0,
    `name`       varchar(30)  NOT NULL DEFAULT '',
    `type`       varchar(50)  NOT NULL DEFAULT '',
    `desc`       varchar(255) NOT NULL DEFAULT '',
    `version`    smallint unsigned NOT NULL DEFAULT 0,
    `attribute`  text NULL,
    `addedBy`    varchar(30)  NOT NULL DEFAULT 0,
    `addedDate`  datetime     NOT NULL,
    `editEdBy`   varchar(30)  NOT NULL DEFAULT 0,
    `editedDate` datetime     NOT NULL,
    `deleted`    enum ('0', '1') NOT NULL DEFAULT '0',
    primary key (`id`)
);
CREATE TABLE `zt_apistruct_spec`
(
    `id`        int UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`      varchar(255) NOT NULL DEFAULT '',
    `type`      varchar(50)  NOT NULL DEFAULT '',
    `desc`      varchar(255) NOT NULL DEFAULT '',
    `attribute` text NULL,
    `version`   smallint unsigned NOT NULL DEFAULT 0,
    `addedBy`   varchar(30)  NOT NULL DEFAULT 0,
    `addedDate` datetime     NOT NULL,
    primary key (`id`)
);
CREATE TABLE `zt_block`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `account` char(30)     NOT NULL,
    `module`  varchar(20)  NOT NULL,
    `type`    char(30)     NOT NULL,
    `title`   varchar(100) NOT NULL,
    `source`  varchar(20)  NOT NULL,
    `block`   varchar(20)  NOT NULL,
    `params`  text         NOT NULL,
    `order`   tinyint(3) unsigned NOT NULL DEFAULT 0,
    `grid`    tinyint(3) unsigned NOT NULL DEFAULT 0,
    `height`  smallint(5) unsigned NOT NULL DEFAULT 0,
    `hidden`  tinyint(1) unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `account_module_type_order` (`account`,`module`,`type`,`order`),
    KEY       `account` (`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_branch`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `product` mediumint(8) unsigned NOT NULL,
    `name`    varchar(255) NOT NULL,
    `order`   smallint(5) unsigned NOT NULL,
    `deleted` enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY       `product` (`product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_bug`
(
    `id`             mediumint(8) NOT NULL AUTO_INCREMENT,
    `project`        mediumint(8) unsigned NOT NULL,
    `product`        mediumint(8) unsigned NOT NULL DEFAULT 0,
    `branch`         mediumint(8) unsigned NOT NULL DEFAULT 0,
    `module`         mediumint(8) unsigned NOT NULL DEFAULT 0,
    `execution`      mediumint(8) unsigned NOT NULL DEFAULT 0,
    `plan`           mediumint(8) unsigned NOT NULL DEFAULT 0,
    `story`          mediumint(8) unsigned NOT NULL DEFAULT 0,
    `storyVersion`   smallint(6) NOT NULL DEFAULT 1,
    `task`           mediumint(8) unsigned NOT NULL DEFAULT 0,
    `toTask`         mediumint(8) unsigned NOT NULL DEFAULT 0,
    `toStory`        mediumint(8) NOT NULL DEFAULT 0,
    `title`          varchar(255) NOT NULL,
    `keywords`       varchar(255) NOT NULL,
    `severity`       tinyint(4) NOT NULL DEFAULT 0,
    `pri`            tinyint(3) unsigned NOT NULL,
    `type`           varchar(30)  NOT NULL DEFAULT '',
    `os`             varchar(30)  NOT NULL DEFAULT '',
    `browser`        varchar(30)  NOT NULL DEFAULT '',
    `hardware`       varchar(30)  NOT NULL,
    `found`          varchar(30)  NOT NULL DEFAULT '',
    `steps`          text         NOT NULL,
    `status`         enum('active','resolved','closed') NOT NULL DEFAULT 'active',
    `subStatus`      varchar(30)  NOT NULL DEFAULT '',
    `color`          char(7)      NOT NULL,
    `confirmed`      tinyint(1) NOT NULL DEFAULT 0,
    `activatedCount` smallint(6) NOT NULL,
    `activatedDate`  datetime     NOT NULL,
    `mailto`         text                  DEFAULT NULL,
    `openedBy`       varchar(30)  NOT NULL DEFAULT '',
    `openedDate`     datetime     NOT NULL,
    `openedBuild`    varchar(255) NOT NULL,
    `assignedTo`     varchar(30)  NOT NULL DEFAULT '',
    `assignedDate`   datetime     NOT NULL,
    `deadline`       date         NOT NULL,
    `resolvedBy`     varchar(30)  NOT NULL DEFAULT '',
    `resolution`     varchar(30)  NOT NULL DEFAULT '',
    `resolvedBuild`  varchar(30)  NOT NULL DEFAULT '',
    `resolvedDate`   datetime     NOT NULL,
    `closedBy`       varchar(30)  NOT NULL DEFAULT '',
    `closedDate`     datetime     NOT NULL,
    `duplicateBug`   mediumint(8) unsigned NOT NULL,
    `linkBug`        varchar(255) NOT NULL,
    `case`           mediumint(8) unsigned NOT NULL,
    `caseVersion`    smallint(6) NOT NULL DEFAULT 1,
    `result`         mediumint(8) unsigned NOT NULL,
    `repo`           mediumint(8) unsigned NOT NULL,
    `entry`          varchar(255) NOT NULL,
    `lines`          varchar(10)  NOT NULL,
    `v1`             varchar(40)  NOT NULL,
    `v2`             varchar(40)  NOT NULL,
    `repoType`       varchar(30)  NOT NULL DEFAULT '',
    `testtask`       mediumint(8) unsigned NOT NULL,
    `lastEditedBy`   varchar(30)  NOT NULL DEFAULT '',
    `lastEditedDate` datetime     NOT NULL,
    `deleted`        enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY              `product` (`product`),
    KEY              `execution` (`execution`),
    KEY              `status` (`status`),
    KEY              `plan` (`plan`),
    KEY              `story` (`story`),
    KEY              `case` (`case`),
    KEY              `toStory` (`toStory`),
    KEY              `result` (`result`),
    KEY              `assignedTo` (`assignedTo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_build`
(
    `id`        mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `project`   mediumint(8) unsigned NOT NULL,
    `product`   mediumint(8) unsigned NOT NULL DEFAULT 0,
    `branch`    mediumint(8) unsigned NOT NULL DEFAULT 0,
    `execution` mediumint(8) unsigned NOT NULL DEFAULT 0,
    `name`      char(150) NOT NULL,
    `scmPath`   char(255) NOT NULL,
    `filePath`  char(255) NOT NULL,
    `date`      date      NOT NULL,
    `stories`   text      NOT NULL,
    `bugs`      text      NOT NULL,
    `builder`   char(30)  NOT NULL DEFAULT '',
    `desc`      text      NOT NULL,
    `deleted`   enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY         `product` (`product`),
    KEY         `execution` (`execution`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_burn`
(
    `execution`  mediumint(8) unsigned NOT NULL,
    `product`    mediumint(8) unsigned NOT NULL,
    `task`       mediumint(8) unsigned NOT NULL DEFAULT 0,
    `date`       date  NOT NULL,
    `estimate`   float NOT NULL,
    `left`       float NOT NULL,
    `consumed`   float NOT NULL,
    `storyPoint` float NOT NULL,
    PRIMARY KEY (`execution`, `date`, `task`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_case`
(
    `id`              mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `project`         mediumint(8) unsigned NOT NULL,
    `product`         mediumint(8) unsigned NOT NULL DEFAULT 0,
    `execution`       mediumint(8) unsigned NOT NULL,
    `branch`          mediumint(8) unsigned NOT NULL DEFAULT 0,
    `lib`             mediumint(8) unsigned NOT NULL DEFAULT 0,
    `module`          mediumint(8) unsigned NOT NULL DEFAULT 0,
    `path`            mediumint(8) unsigned NOT NULL DEFAULT 0,
    `story`           mediumint(30) unsigned NOT NULL DEFAULT 0,
    `storyVersion`    smallint(6) NOT NULL DEFAULT 1,
    `title`           varchar(255) NOT NULL,
    `precondition`    text         NOT NULL,
    `keywords`        varchar(255) NOT NULL,
    `pri`             tinyint(3) unsigned NOT NULL DEFAULT 3,
    `type`            char(30)     NOT NULL DEFAULT '1',
    `auto`            varchar(10)  NOT NULL DEFAULT 'no',
    `frame`           varchar(10)  NOT NULL,
    `stage`           varchar(255) NOT NULL,
    `howRun`          varchar(30)  NOT NULL,
    `scriptedBy`      varchar(30)  NOT NULL,
    `scriptedDate`    date         NOT NULL,
    `scriptStatus`    varchar(30)  NOT NULL,
    `scriptLocation`  varchar(255) NOT NULL,
    `status`          char(30)     NOT NULL DEFAULT '1',
    `subStatus`       varchar(30)  NOT NULL DEFAULT '',
    `color`           char(7)      NOT NULL,
    `frequency`       enum('1','2','3') NOT NULL DEFAULT '1',
    `order`           tinyint(30) unsigned NOT NULL DEFAULT 0,
    `openedBy`        char(30)     NOT NULL DEFAULT '',
    `openedDate`      datetime     NOT NULL,
    `reviewedBy`      varchar(255) NOT NULL,
    `reviewedDate`    date         NOT NULL,
    `lastEditedBy`    char(30)     NOT NULL DEFAULT '',
    `lastEditedDate`  datetime     NOT NULL,
    `version`         tinyint(3) unsigned NOT NULL DEFAULT 0,
    `linkCase`        varchar(255) NOT NULL,
    `fromBug`         mediumint(8) unsigned NOT NULL,
    `fromCaseID`      mediumint(8) unsigned NOT NULL,
    `fromCaseVersion` mediumint(8) unsigned NOT NULL DEFAULT 1,
    `deleted`         enum('0','1') NOT NULL DEFAULT '0',
    `lastRunner`      varchar(30)  NOT NULL,
    `lastRunDate`     datetime     NOT NULL,
    `lastRunResult`   char(30)     NOT NULL,
    PRIMARY KEY (`id`),
    KEY               `product` (`product`),
    KEY               `story` (`story`),
    KEY               `fromBug` (`fromBug`),
    KEY               `module` (`module`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_casestep`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `parent`  mediumint(8) unsigned NOT NULL DEFAULT 0,
    `case`    mediumint(8) unsigned NOT NULL DEFAULT 0,
    `version` smallint(3) unsigned NOT NULL DEFAULT 0,
    `type`    varchar(10) NOT NULL DEFAULT 'step',
    `desc`    text        NOT NULL,
    `expect`  text        NOT NULL,
    PRIMARY KEY (`id`),
    KEY       `case` (`case`),
    KEY       `version` (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_company`
(
    `id`       mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `name`     char(120) DEFAULT NULL,
    `phone`    char(20)  DEFAULT NULL,
    `fax`      char(20)  DEFAULT NULL,
    `address`  char(120) DEFAULT NULL,
    `zipcode`  char(10)  DEFAULT NULL,
    `website`  char(120) DEFAULT NULL,
    `backyard` char(120) DEFAULT NULL,
    `guest`    enum('1','0') NOT NULL DEFAULT '0',
    `admins`   char(255) DEFAULT NULL,
    `deleted`  enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_compile`
(
    `id`          mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(50)  NOT NULL,
    `job`         mediumint(8) unsigned NOT NULL,
    `queue`       mediumint(8) NOT NULL,
    `status`      varchar(255) NOT NULL,
    `logs`        text DEFAULT NULL,
    `atTime`      varchar(10)  NOT NULL,
    `testtask`    mediumint(8) unsigned NOT NULL,
    `tag`         varchar(255) NOT NULL,
    `times`       tinyint(3) unsigned NOT NULL DEFAULT 0,
    `createdBy`   varchar(30)  NOT NULL,
    `createdDate` datetime     NOT NULL,
    `updateDate`  datetime     NOT NULL,
    `deleted`     enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_config`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `owner`   char(30)    NOT NULL DEFAULT '',
    `module`  varchar(30) NOT NULL,
    `section` char(30)    NOT NULL DEFAULT '',
    `key`     char(30)    NOT NULL DEFAULT '',
    `value`   longtext    NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique` (`owner`,`module`,`section`,`key`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_cron`
(
    `id`       mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `m`        varchar(20)  NOT NULL,
    `h`        varchar(20)  NOT NULL,
    `dom`      varchar(20)  NOT NULL,
    `mon`      varchar(20)  NOT NULL,
    `dow`      varchar(20)  NOT NULL,
    `command`  text         NOT NULL,
    `remark`   varchar(255) NOT NULL,
    `type`     varchar(20)  NOT NULL,
    `buildin`  tinyint(1) NOT NULL DEFAULT 0,
    `status`   varchar(20)  NOT NULL,
    `lastTime` datetime     NOT NULL,
    PRIMARY KEY (`id`),
    KEY        `lastTime` (`lastTime`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_dept`
(
    `id`       mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `name`     char(60)  NOT NULL,
    `parent`   mediumint(8) unsigned NOT NULL DEFAULT 0,
    `path`     char(255) NOT NULL DEFAULT '',
    `grade`    tinyint(3) unsigned NOT NULL DEFAULT 0,
    `order`    smallint(4) unsigned NOT NULL DEFAULT 0,
    `position` char(30)  NOT NULL DEFAULT '',
    `function` char(255) NOT NULL DEFAULT '',
    `manager`  char(30)  NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    KEY        `parent` (`parent`),
    KEY        `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_doc`
(
    `id`         mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `project`    mediumint(8) unsigned NOT NULL,
    `product`    mediumint(8) unsigned NOT NULL,
    `execution`  mediumint(8) unsigned NOT NULL,
    `lib`        varchar(30)  NOT NULL,
    `module`     varchar(30)  NOT NULL,
    `title`      varchar(255) NOT NULL,
    `keywords`   varchar(255) NOT NULL,
    `type`       varchar(30)  NOT NULL,
    `views`      smallint(5) unsigned NOT NULL,
    `draft`      longtext     NOT NULL,
    `collector`  text         NOT NULL,
    `addedBy`    varchar(30)  NOT NULL,
    `addedDate`  datetime     NOT NULL,
    `editedBy`   varchar(30)  NOT NULL,
    `editedDate` datetime     NOT NULL,
    `mailto`     text                  DEFAULT NULL,
    `acl`        varchar(10)  NOT NULL DEFAULT 'open',
    `groups`     varchar(255) NOT NULL,
    `users`      text         NOT NULL,
    `version`    smallint(5) unsigned NOT NULL DEFAULT 1,
    `deleted`    enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY          `product` (`product`),
    KEY          `execution` (`execution`),
    KEY          `lib` (`lib`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_doccontent`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `doc`     mediumint(8) unsigned NOT NULL,
    `title`   varchar(255) NOT NULL,
    `digest`  varchar(255) NOT NULL,
    `content` longtext     NOT NULL,
    `files`   text         NOT NULL,
    `type`    varchar(10)  NOT NULL,
    `version` smallint(5) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `doc_version` (`doc`,`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_doclib`
(
    `id`        smallint(5) unsigned NOT NULL AUTO_INCREMENT,
    `type`      varchar(30)  NOT NULL,
    `product`   mediumint(8) unsigned NOT NULL,
    `project`   mediumint(8) unsigned NOT NULL,
    `execution` mediumint(8) unsigned NOT NULL,
    `name`      varchar(60)  NOT NULL,
    `baseUrl`   varchar(255) NOT NULL,
    `acl`       varchar(10)  NOT NULL DEFAULT 'open',
    `groups`    varchar(255) NOT NULL,
    `users`     text         NOT NULL,
    `main`      enum('0','1') NOT NULL DEFAULT '0',
    `collector` text         NOT NULL,
    `desc`      text         NOT NULL,
    `order`     tinyint(5) unsigned NOT NULL,
    `deleted`   enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY         `product` (`product`),
    KEY         `execution` (`execution`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_effort`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `user`    char(30)  NOT NULL DEFAULT '',
    `todo`    enum('1','0') NOT NULL DEFAULT '1',
    `date`    date      NOT NULL,
    `begin`   datetime  NOT NULL DEFAULT '0000-00-00 00:00:00',
    `end`     datetime  NOT NULL DEFAULT '0000-00-00 00:00:00',
    `type`    enum('1','2','3') NOT NULL DEFAULT '1',
    `idvalue` mediumint(8) unsigned NOT NULL DEFAULT 0,
    `name`    char(30)  NOT NULL DEFAULT '',
    `desc`    char(255) NOT NULL DEFAULT '',
    `status`  enum('1','2','3') NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`),
    KEY       `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_entry`
(
    `id`          mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(50)  NOT NULL,
    `account`     varchar(30)  NOT NULL DEFAULT '',
    `code`        varchar(20)  NOT NULL,
    `key`         varchar(32)  NOT NULL,
    `freePasswd`  enum('0','1') NOT NULL DEFAULT '0',
    `ip`          varchar(100) NOT NULL,
    `desc`        text         NOT NULL,
    `createdBy`   varchar(30)  NOT NULL,
    `createdDate` datetime     NOT NULL,
    `calledTime`  int(10) unsigned NOT NULL DEFAULT 0,
    `editedBy`    varchar(30)  NOT NULL,
    `editedDate`  datetime     NOT NULL,
    `deleted`     enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_expect`
(
    `id`          mediumint(8) NOT NULL AUTO_INCREMENT,
    `userID`      mediumint(8) NOT NULL,
    `project`     mediumint(8) NOT NULL DEFAULT 0,
    `expect`      text     NOT NULL,
    `progress`    text     NOT NULL,
    `createdBy`   char(30) NOT NULL,
    `createdDate` date     NOT NULL,
    `deleted`     enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_extension`
(
    `id`               mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `name`             varchar(150) NOT NULL,
    `code`             varchar(30)  NOT NULL,
    `version`          varchar(50)  NOT NULL,
    `author`           varchar(100) NOT NULL,
    `desc`             text         NOT NULL,
    `license`          text         NOT NULL,
    `type`             varchar(20)  NOT NULL DEFAULT 'extension',
    `site`             varchar(150) NOT NULL,
    `zentaoCompatible` varchar(100) NOT NULL,
    `installedTime`    datetime     NOT NULL,
    `depends`          varchar(100) NOT NULL,
    `dirs`             mediumtext   NOT NULL,
    `files`            mediumtext   NOT NULL,
    `status`           varchar(20)  NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `code` (`code`),
    KEY                `name` (`name`),
    KEY                `installedTime` (`installedTime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_file`
(
    `id`         mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `pathname`   char(50)     NOT NULL,
    `title`      char(255)    NOT NULL,
    `extension`  char(30)     NOT NULL,
    `size`       int(10) unsigned NOT NULL DEFAULT 0,
    `objectType` char(30)     NOT NULL,
    `objectID`   mediumint(9) NOT NULL,
    `addedBy`    char(30)     NOT NULL DEFAULT '',
    `addedDate`  datetime     NOT NULL,
    `downloads`  mediumint(8) unsigned NOT NULL DEFAULT 0,
    `extra`      varchar(255) NOT NULL,
    `deleted`    enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY          `objectType` (`objectType`),
    KEY          `objectID` (`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_group`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `project` mediumint(8) unsigned NOT NULL DEFAULT 0,
    `name`    char(30)  NOT NULL,
    `role`    char(30)  NOT NULL DEFAULT '',
    `desc`    char(255) NOT NULL DEFAULT '',
    `acl`     text               DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_grouppriv`
(
    `group`  mediumint(8) unsigned NOT NULL DEFAULT 0,
    `module` char(30) NOT NULL DEFAULT '',
    `method` char(30) NOT NULL DEFAULT '',
    UNIQUE KEY `group` (`group`,`module`,`method`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_history`
(
    `id`     mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `action` mediumint(8) unsigned NOT NULL DEFAULT 0,
    `field`  varchar(30) NOT NULL DEFAULT '',
    `old`    text        NOT NULL,
    `new`    text        NOT NULL,
    `diff`   mediumtext  NOT NULL,
    PRIMARY KEY (`id`),
    KEY      `action` (`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_job`
(
    `id`          mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(50)  NOT NULL,
    `repo`        mediumint(8) unsigned NOT NULL,
    `product`     mediumint(8) unsigned NOT NULL,
    `frame`       varchar(20)  NOT NULL,
    `engine`      varchar(20)  NOT NULL,
    `server`      mediumint(8) unsigned NOT NULL,
    `pipeline`    varchar(500) NOT NULL,
    `triggerType` varchar(255) NOT NULL,
    `svnDir`      varchar(255) NOT NULL,
    `atDay`       varchar(255) DEFAULT NULL,
    `atTime`      varchar(10)  DEFAULT NULL,
    `customParam` text         NOT NULL,
    `comment`     varchar(255) DEFAULT NULL,
    `createdBy`   varchar(30)  NOT NULL,
    `createdDate` datetime     NOT NULL,
    `editedBy`    varchar(30)  NOT NULL,
    `editedDate`  datetime     NOT NULL,
    `lastExec`    datetime     DEFAULT NULL,
    `lastStatus`  varchar(255) DEFAULT NULL,
    `lastTag`     varchar(255) DEFAULT NULL,
    `deleted`     enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_lang`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `lang`    varchar(30) NOT NULL,
    `module`  varchar(30) NOT NULL,
    `section` varchar(30) NOT NULL,
    `key`     varchar(60) NOT NULL,
    `value`   text        NOT NULL,
    `system`  enum('0','1') NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`),
    UNIQUE KEY `lang` (`lang`,`module`,`section`,`key`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
CREATE TABLE `zt_log`
(
    `id`          mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `objectType`  varchar(30)  NOT NULL,
    `objectID`    mediumint(8) unsigned NOT NULL,
    `action`      mediumint(8) unsigned NOT NULL,
    `date`        datetime     NOT NULL,
    `url`         varchar(255) NOT NULL,
    `contentType` varchar(30)  NOT NULL,
    `data`        text         NOT NULL,
    `result`      text         NOT NULL,
    PRIMARY KEY (`id`),
    KEY           `objectType` (`objectType`),
    KEY           `obejctID` (`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_module`
(
    `id`        mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `root`      mediumint(8) unsigned NOT NULL DEFAULT 0,
    `branch`    mediumint(8) unsigned NOT NULL DEFAULT 0,
    `name`      char(60)    NOT NULL DEFAULT '',
    `parent`    mediumint(8) unsigned NOT NULL DEFAULT 0,
    `path`      char(255)   NOT NULL DEFAULT '',
    `grade`     tinyint(3) unsigned NOT NULL DEFAULT 0,
    `order`     smallint(5) unsigned NOT NULL DEFAULT 0,
    `type`      char(30)    NOT NULL,
    `owner`     varchar(30) NOT NULL,
    `collector` text        NOT NULL,
    `short`     varchar(30) NOT NULL,
    `deleted`   enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY         `root` (`root`),
    KEY         `type` (`type`),
    KEY         `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_mr`
(
    `id`            mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `gitlabID`      mediumint(8) unsigned NOT NULL,
    `sourceProject` int unsigned NOT NULL,
    `sourceBranch`  varchar(100) NOT NULL,
    `targetProject` int unsigned NOT NULL,
    `targetBranch`  varchar(100) NOT NULL,
    `mriid`         int unsigned NOT NULL,
    `title`         varchar(255) NOT NULL,
    `description`   text         NOT NULL,
    `assignee`      varchar(255) NOT NULL,
    `reviewer`      varchar(255) NOT NULL,
    `createdBy`     varchar(30)  NOT NULL,
    `createdDate`   datetime     NOT NULL,
    `editedBy`      varchar(30)  NOT NULL,
    `editedDate`    datetime     NOT NULL,
    `deleted`       enum('0','1') NOT NULL DEFAULT '0',
    `status`        char(30)     NOT NULL,
    `mergeStatus`   char(30)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_notify`
(
    `id`          mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `objectType`  varchar(50)  NOT NULL,
    `objectID`    mediumint(8) unsigned NOT NULL,
    `action`      mediumint(9) NOT NULL,
    `toList`      varchar(255) NOT NULL,
    `ccList`      text         NOT NULL,
    `subject`     varchar(255) NOT NULL,
    `data`        text         NOT NULL,
    `createdBy`   char(30)     NOT NULL,
    `createdDate` datetime     NOT NULL,
    `sendTime`    datetime     NOT NULL,
    `status`      varchar(10)  NOT NULL DEFAULT 'wait',
    `failReason`  text         NOT NULL,
    PRIMARY KEY (`id`),
    KEY           `objectType_toList_status` (`objectType`,`toList`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_oauth`
(
    `account`      varchar(30)  NOT NULL,
    `openID`       varchar(255) NOT NULL,
    `providerType` varchar(30)  NOT NULL,
    `providerID`   mediumint(8) unsigned NOT NULL,
    KEY            `account` (`account`),
    KEY            `providerType` (`providerType`),
    KEY            `providerID` (`providerID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_pipeline`
(
    `id`          smallint(8) unsigned NOT NULL AUTO_INCREMENT,
    `type`        char(30)     NOT NULL,
    `name`        varchar(50)  NOT NULL,
    `url`         varchar(255) DEFAULT NULL,
    `account`     varchar(30)  DEFAULT NULL,
    `password`    varchar(255) NOT NULL,
    `token`       varchar(255) DEFAULT NULL,
    `private`     char(32)     DEFAULT NULL,
    `createdBy`   varchar(30)  NOT NULL,
    `createdDate` datetime     NOT NULL,
    `editedBy`    varchar(30)  NOT NULL,
    `editedDate`  datetime     NOT NULL,
    `deleted`     enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_planstory`
(
    `plan`  mediumint(8) unsigned NOT NULL,
    `story` mediumint(8) unsigned NOT NULL,
    `order` mediumint(9) NOT NULL,
    UNIQUE KEY `plan_story` (`plan`,`story`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_product`
(
    `id`             mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `program`        mediumint(8) unsigned NOT NULL,
    `name`           varchar(90) NOT NULL,
    `code`           varchar(45) NOT NULL,
    `bind`           enum('0','1') NOT NULL DEFAULT '0',
    `line`           mediumint(8) NOT NULL,
    `type`           varchar(30) NOT NULL DEFAULT 'normal',
    `status`         varchar(30) NOT NULL DEFAULT '',
    `subStatus`      varchar(30) NOT NULL DEFAULT '',
    `desc`           text        NOT NULL,
    `PO`             varchar(30) NOT NULL,
    `QD`             varchar(30) NOT NULL,
    `RD`             varchar(30) NOT NULL,
    `acl`            enum('open','private','custom') NOT NULL DEFAULT 'open',
    `whitelist`      text        NOT NULL,
    `createdBy`      varchar(30) NOT NULL,
    `createdDate`    datetime    NOT NULL,
    `createdVersion` varchar(20) NOT NULL,
    `order`          mediumint(8) unsigned NOT NULL,
    `deleted`        enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY              `acl` (`acl`),
    KEY              `order` (`order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_productplan`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `product` mediumint(8) unsigned NOT NULL,
    `branch`  mediumint(8) unsigned NOT NULL,
    `parent`  mediumint(9) NOT NULL DEFAULT 0,
    `title`   varchar(90) NOT NULL,
    `desc`    text        NOT NULL,
    `begin`   date        NOT NULL,
    `end`     date        NOT NULL,
    `order`   text        NOT NULL,
    `deleted` enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY       `product` (`product`),
    KEY       `end` (`end`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_project`
(
    `id`             mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `project`        mediumint(8) NOT NULL DEFAULT 0,
    `model`          char(30)     NOT NULL,
    `type`           char(30)     NOT NULL DEFAULT 'sprint',
    `lifetime`       char(30)     NOT NULL DEFAULT '',
    `budget`         varchar(30)  NOT NULL DEFAULT '0',
    `budgetUnit`     char(30)     NOT NULL DEFAULT 'CNY',
    `attribute`      varchar(30)  NOT NULL DEFAULT '',
    `percent`        float unsigned NOT NULL DEFAULT 0,
    `milestone`      enum('0','1') NOT NULL DEFAULT '0',
    `output`         text         NOT NULL,
    `auth`           char(30)     NOT NULL,
    `parent`         mediumint(8) unsigned NOT NULL DEFAULT 0,
    `path`           varchar(255) NOT NULL,
    `grade`          tinyint(3) unsigned NOT NULL,
    `name`           varchar(90)  NOT NULL,
    `code`           varchar(45)  NOT NULL,
    `begin`          date         NOT NULL,
    `end`            date         NOT NULL,
    `realBegan`      date         NOT NULL,
    `realEnd`        date         NOT NULL,
    `days`           smallint(5) unsigned NOT NULL,
    `status`         varchar(10)  NOT NULL,
    `subStatus`      varchar(30)  NOT NULL DEFAULT '',
    `pri`            enum('1','2','3','4') NOT NULL DEFAULT '1',
    `desc`           text         NOT NULL,
    `version`        smallint(6) NOT NULL,
    `parentVersion`  smallint(6) NOT NULL,
    `planDuration`   int(11) NOT NULL,
    `realDuration`   int(11) NOT NULL,
    `openedBy`       varchar(30)  NOT NULL DEFAULT '',
    `openedDate`     datetime     NOT NULL,
    `openedVersion`  varchar(20)  NOT NULL,
    `lastEditedBy`   varchar(30)  NOT NULL DEFAULT '',
    `lastEditedDate` datetime     NOT NULL,
    `closedBy`       varchar(30)  NOT NULL DEFAULT '',
    `closedDate`     datetime     NOT NULL,
    `canceledBy`     varchar(30)  NOT NULL DEFAULT '',
    `canceledDate`   datetime     NOT NULL,
    `PO`             varchar(30)  NOT NULL DEFAULT '',
    `PM`             varchar(30)  NOT NULL DEFAULT '',
    `QD`             varchar(30)  NOT NULL DEFAULT '',
    `RD`             varchar(30)  NOT NULL DEFAULT '',
    `team`           varchar(90)  NOT NULL,
    `acl`            char(30)     NOT NULL DEFAULT 'open',
    `whitelist`      text         NOT NULL,
    `order`          mediumint(8) unsigned NOT NULL,
    `deleted`        enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY              `parent` (`parent`),
    KEY              `begin` (`begin`),
    KEY              `end` (`end`),
    KEY              `status` (`status`),
    KEY              `acl` (`acl`),
    KEY              `order` (`order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_projectcase`
(
    `project` mediumint(8) unsigned NOT NULL DEFAULT 0,
    `product` mediumint(8) unsigned NOT NULL DEFAULT 0,
    `case`    mediumint(8) unsigned NOT NULL DEFAULT 0,
    `count`   mediumint(8) unsigned NOT NULL DEFAULT 1,
    `version` smallint(6) NOT NULL DEFAULT 1,
    `order`   smallint(6) unsigned NOT NULL,
    UNIQUE KEY `project` (`project`,`case`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_projectproduct`
(
    `project` mediumint(8) unsigned NOT NULL,
    `product` mediumint(8) unsigned NOT NULL,
    `branch`  mediumint(8) unsigned NOT NULL,
    `plan`    mediumint(8) unsigned NOT NULL,
    PRIMARY KEY (`project`, `product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_projectspec`
(
    `project`   mediumint(8) NOT NULL,
    `version`   smallint(6) NOT NULL,
    `name`      varchar(255) NOT NULL,
    `milestone` enum('0','1') NOT NULL DEFAULT '0',
    `begin`     date         NOT NULL,
    `end`       date         NOT NULL,
    UNIQUE KEY `project` (`project`,`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_projectstory`
(
    `project` mediumint(8) unsigned NOT NULL DEFAULT 0,
    `product` mediumint(8) unsigned NOT NULL,
    `story`   mediumint(8) unsigned NOT NULL DEFAULT 0,
    `version` smallint(6) NOT NULL DEFAULT 1,
    `order`   smallint(6) unsigned NOT NULL,
    UNIQUE KEY `project` (`project`,`story`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_relation`
(
    `id`        int(8) NOT NULL AUTO_INCREMENT,
    `project`   mediumint(8) NOT NULL,
    `product`   mediumint(8) NOT NULL,
    `execution` mediumint(8) NOT NULL,
    `AType`     char(30) NOT NULL,
    `AID`       mediumint(8) NOT NULL,
    `AVersion`  char(30) NOT NULL,
    `relation`  char(30) NOT NULL,
    `BType`     char(30) NOT NULL,
    `BID`       mediumint(8) NOT NULL,
    `BVersion`  char(30) NOT NULL,
    `extra`     char(30) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `relation` (`product`,`relation`,`AType`,`BType`,`AID`,`BID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_release`
(
    `id`        mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `project`   mediumint(8) unsigned NOT NULL,
    `product`   mediumint(8) unsigned NOT NULL DEFAULT 0,
    `branch`    mediumint(8) unsigned NOT NULL DEFAULT 0,
    `build`     mediumint(8) unsigned NOT NULL,
    `name`      varchar(255) NOT NULL DEFAULT '',
    `marker`    enum('0','1') NOT NULL DEFAULT '0',
    `date`      date         NOT NULL,
    `stories`   text         NOT NULL,
    `bugs`      text         NOT NULL,
    `leftBugs`  text         NOT NULL,
    `desc`      text         NOT NULL,
    `mailto`    text,
    `notify`    varchar(255),
    `status`    varchar(20)  NOT NULL DEFAULT 'normal',
    `subStatus` varchar(30)  NOT NULL DEFAULT '',
    `deleted`   enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY         `product` (`product`),
    KEY         `build` (`build`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_repo`
(
    `id`       mediumint(9) NOT NULL AUTO_INCREMENT,
    `product`  varchar(255) NOT NULL,
    `name`     varchar(255) NOT NULL,
    `path`     varchar(255) NOT NULL,
    `prefix`   varchar(100) NOT NULL,
    `encoding` varchar(20)  NOT NULL,
    `SCM`      varchar(10)  NOT NULL,
    `client`   varchar(100) NOT NULL,
    `commits`  mediumint(8) unsigned NOT NULL,
    `account`  varchar(30)  NOT NULL,
    `password` varchar(30)  NOT NULL,
    `encrypt`  varchar(30)  NOT NULL DEFAULT 'plain',
    `acl`      text         NOT NULL,
    `synced`   tinyint(1) NOT NULL DEFAULT 0,
    `lastSync` datetime     NOT NULL,
    `desc`     text         NOT NULL,
    `extra`    char(30)     NOT NULL,
    `deleted`  tinyint(1) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_repobranch`
(
    `repo`     mediumint(8) unsigned NOT NULL,
    `revision` mediumint(8) unsigned NOT NULL,
    `branch`   varchar(255) NOT NULL,
    UNIQUE KEY `repo_revision_branch` (`repo`,`revision`,`branch`),
    KEY        `branch` (`branch`),
    KEY        `revision` (`revision`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_repofiles`
(
    `id`       int(10) unsigned NOT NULL AUTO_INCREMENT,
    `repo`     mediumint(8) unsigned NOT NULL,
    `revision` mediumint(8) unsigned NOT NULL,
    `path`     varchar(255) NOT NULL,
    `parent`   varchar(255) NOT NULL,
    `type`     varchar(20)  NOT NULL,
    `action`   char(1)      NOT NULL,
    PRIMARY KEY (`id`),
    KEY        `path` (`path`),
    KEY        `parent` (`parent`),
    KEY        `repo` (`repo`),
    KEY        `revision` (`revision`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_repohistory`
(
    `id`        mediumint(9) NOT NULL AUTO_INCREMENT,
    `repo`      mediumint(9) NOT NULL,
    `revision`  varchar(40)  NOT NULL,
    `commit`    mediumint(8) unsigned NOT NULL,
    `comment`   text         NOT NULL,
    `committer` varchar(100) NOT NULL,
    `time`      datetime     NOT NULL,
    PRIMARY KEY (`id`),
    KEY         `repo` (`repo`),
    KEY         `revision` (`revision`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_score`
(
    `id`      bigint(12) unsigned NOT NULL AUTO_INCREMENT,
    `account` varchar(30)  NOT NULL,
    `module`  varchar(30)  NOT NULL DEFAULT '',
    `method`  varchar(30)  NOT NULL,
    `desc`    varchar(250) NOT NULL DEFAULT '',
    `before`  int(11) NOT NULL DEFAULT 0,
    `score`   int(11) NOT NULL DEFAULT 0,
    `after`   int(11) NOT NULL DEFAULT 0,
    `time`    datetime     NOT NULL,
    PRIMARY KEY (`id`),
    KEY       `account` (`account`),
    KEY       `model` (`module`),
    KEY       `method` (`method`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_searchdict`
(
    `key`   smallint(5) unsigned NOT NULL,
    `value` char(3) NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_searchindex`
(
    `id`         mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `objectType` char(20) NOT NULL,
    `objectID`   mediumint(9) NOT NULL,
    `title`      text     NOT NULL,
    `content`    text     NOT NULL,
    `addedDate`  datetime NOT NULL,
    `editedDate` datetime NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `object` (`objectType`,`objectID`),
    KEY          `addedDate` (`addedDate`),
    FULLTEXT KEY `content` (`content`),
    FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_stakeholder`
(
    `id`          mediumint(8) NOT NULL AUTO_INCREMENT,
    `objectID`    mediumint(8) NOT NULL,
    `objectType`  char(30) NOT NULL,
    `user`        char(30) NOT NULL,
    `type`        char(30) NOT NULL,
    `key`         enum('0','1') NOT NULL,
    `from`        char(30) NOT NULL,
    `createdBy`   char(30) NOT NULL,
    `createdDate` date     NOT NULL,
    `editedBy`    char(30) NOT NULL,
    `editedDate`  date     NOT NULL,
    `deleted`     enum('0','1') NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_story`
(
    `id`             mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `parent`         mediumint(9) NOT NULL DEFAULT 0,
    `product`        mediumint(8) unsigned NOT NULL DEFAULT 0,
    `branch`         mediumint(8) unsigned NOT NULL DEFAULT 0,
    `module`         mediumint(8) unsigned NOT NULL DEFAULT 0,
    `plan`           text                  DEFAULT NULL,
    `source`         varchar(20)  NOT NULL,
    `sourceNote`     varchar(255) NOT NULL,
    `fromBug`        mediumint(8) unsigned NOT NULL DEFAULT 0,
    `title`          varchar(255) NOT NULL,
    `keywords`       varchar(255) NOT NULL,
    `type`           varchar(30)  NOT NULL DEFAULT 'story',
    `category`       varchar(30)  NOT NULL DEFAULT 'feature',
    `pri`            tinyint(3) unsigned NOT NULL DEFAULT 3,
    `estimate`       float unsigned NOT NULL,
    `status`         enum('','changed','active','draft','closed') NOT NULL DEFAULT '',
    `subStatus`      varchar(30)  NOT NULL DEFAULT '',
    `color`          char(7)      NOT NULL,
    `stage`          enum('','wait','planned','projected','developing','developed','testing','tested','verified','released','closed') NOT NULL DEFAULT 'wait',
    `stagedBy`       char(30)     NOT NULL,
    `mailto`         text                  DEFAULT NULL,
    `openedBy`       varchar(30)  NOT NULL DEFAULT '',
    `openedDate`     datetime     NOT NULL,
    `assignedTo`     varchar(30)  NOT NULL DEFAULT '',
    `assignedDate`   datetime     NOT NULL,
    `lastEditedBy`   varchar(30)  NOT NULL DEFAULT '',
    `lastEditedDate` datetime     NOT NULL,
    `reviewedBy`     varchar(255) NOT NULL,
    `reviewedDate`   datetime     NOT NULL DEFAULT '0000-00-00 00:00:00',
    `closedBy`       varchar(30)  NOT NULL DEFAULT '',
    `closedDate`     datetime     NOT NULL,
    `closedReason`   varchar(30)  NOT NULL,
    `toBug`          mediumint(8) unsigned NOT NULL,
    `childStories`   varchar(255) NOT NULL,
    `linkStories`    varchar(255) NOT NULL,
    `duplicateStory` mediumint(8) unsigned NOT NULL,
    `version`        smallint(6) NOT NULL DEFAULT 1,
    `URChanged`      enum('0','1') NOT NULL DEFAULT '0',
    `deleted`        enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY              `product` (`product`),
    KEY              `status` (`status`),
    KEY              `assignedTo` (`assignedTo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_storyestimate`
(
    `story`      mediumint(9) NOT NULL,
    `round`      smallint(6) NOT NULL,
    `estimate`   text        NOT NULL,
    `average`    float       NOT NULL,
    `openedBy`   varchar(30) NOT NULL,
    `openedDate` datetime    NOT NULL,
    UNIQUE KEY `story` (`story`,`round`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_storyreview`
(
    `story`      mediumint(9) NOT NULL,
    `version`    smallint(6) NOT NULL,
    `reviewer`   varchar(30) NOT NULL,
    `result`     varchar(30) NOT NULL,
    `reviewDate` datetime    NOT NULL,
    UNIQUE KEY `story` (`story`,`version`,`reviewer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_storyspec`
(
    `story`   mediumint(9) NOT NULL,
    `version` smallint(6) NOT NULL,
    `title`   varchar(255) NOT NULL,
    `spec`    text         NOT NULL,
    `verify`  text         NOT NULL,
    UNIQUE KEY `story` (`story`,`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_storystage`
(
    `story`    mediumint(8) unsigned NOT NULL,
    `branch`   mediumint(8) unsigned NOT NULL,
    `stage`    varchar(50) NOT NULL,
    `stagedBy` char(30)    NOT NULL,
    UNIQUE KEY `story_branch` (`story`,`branch`),
    KEY        `story` (`story`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_suitecase`
(
    `suite`   mediumint(8) unsigned NOT NULL,
    `product` mediumint(8) unsigned NOT NULL,
    `case`    mediumint(8) unsigned NOT NULL,
    `version` smallint(5) unsigned NOT NULL,
    UNIQUE KEY `suitecase` (`suite`,`case`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_task`
(
    `id`             mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `project`        mediumint(8) unsigned NOT NULL,
    `parent`         mediumint(8) NOT NULL DEFAULT 0,
    `execution`      mediumint(8) unsigned NOT NULL DEFAULT 0,
    `module`         mediumint(8) unsigned NOT NULL DEFAULT 0,
    `design`         mediumint(8) unsigned NOT NULL,
    `story`          mediumint(8) unsigned NOT NULL DEFAULT 0,
    `storyVersion`   smallint(6) NOT NULL DEFAULT 1,
    `designVersion`  smallint(6) unsigned NOT NULL,
    `fromBug`        mediumint(8) unsigned NOT NULL DEFAULT 0,
    `name`           varchar(255) NOT NULL,
    `type`           varchar(20)  NOT NULL,
    `pri`            tinyint(3) unsigned NOT NULL DEFAULT 0,
    `estimate`       float unsigned NOT NULL,
    `consumed`       float unsigned NOT NULL,
    `left`           float unsigned NOT NULL,
    `deadline`       date         NOT NULL,
    `status`         enum('wait','doing','done','pause','cancel','closed') NOT NULL DEFAULT 'wait',
    `subStatus`      varchar(30)  NOT NULL DEFAULT '',
    `color`          char(7)      NOT NULL,
    `mailto`         text                  DEFAULT NULL,
    `desc`           text         NOT NULL,
    `version`        smallint(6) NOT NULL,
    `openedBy`       varchar(30)  NOT NULL,
    `openedDate`     datetime     NOT NULL,
    `assignedTo`     varchar(30)  NOT NULL,
    `assignedDate`   datetime     NOT NULL,
    `estStarted`     date         NOT NULL,
    `realStarted`    datetime     NOT NULL,
    `finishedBy`     varchar(30)  NOT NULL,
    `finishedDate`   datetime     NOT NULL,
    `finishedList`   text         NOT NULL,
    `canceledBy`     varchar(30)  NOT NULL,
    `canceledDate`   datetime     NOT NULL,
    `closedBy`       varchar(30)  NOT NULL,
    `closedDate`     datetime     NOT NULL,
    `planDuration`   int(11) NOT NULL,
    `realDuration`   int(11) NOT NULL,
    `closedReason`   varchar(30)  NOT NULL,
    `lastEditedBy`   varchar(30)  NOT NULL,
    `lastEditedDate` datetime     NOT NULL,
    `activatedDate`  date         NOT NULL,
    `deleted`        enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY              `execution` (`execution`),
    KEY              `story` (`story`),
    KEY              `parent` (`parent`),
    KEY              `assignedTo` (`assignedTo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_taskestimate`
(
    `id`       mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `task`     mediumint(8) unsigned NOT NULL DEFAULT 0,
    `date`     date     NOT NULL,
    `left`     float unsigned NOT NULL DEFAULT 0,
    `consumed` float unsigned NOT NULL,
    `account`  char(30) NOT NULL DEFAULT '',
    `work`     text              DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY        `task` (`task`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_taskspec`
(
    `task`       mediumint(8) NOT NULL,
    `version`    smallint(6) NOT NULL,
    `name`       varchar(255) NOT NULL,
    `estStarted` date         NOT NULL,
    `deadline`   date         NOT NULL,
    UNIQUE KEY `task` (`task`,`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_team`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `root`    mediumint(8) unsigned NOT NULL DEFAULT 0,
    `type`    enum('project','task','execution') NOT NULL DEFAULT 'project',
    `account` char(30) NOT NULL DEFAULT '',
    `role`    char(30) NOT NULL DEFAULT '',
    `limited` char(8)  NOT NULL DEFAULT 'no',
    `join`    date     NOT NULL DEFAULT '0000-00-00',
    `days`    smallint(5) unsigned NOT NULL,
    `hours`   float(3, 1
) unsigned NOT NULL DEFAULT 0.0,
  `estimate` decimal(12,2) unsigned NOT NULL DEFAULT 0.00,
  `consumed` decimal(12,2) unsigned NOT NULL DEFAULT 0.00,
  `left` decimal(12,2) unsigned NOT NULL DEFAULT 0.00,
  `order` tinyint(3) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team` (`root`,`type`,`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_testreport`
(
    `id`          mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `project`     mediumint(8) unsigned NOT NULL,
    `product`     mediumint(8) unsigned NOT NULL,
    `execution`   mediumint(8) unsigned NOT NULL,
    `tasks`       varchar(255) NOT NULL,
    `builds`      varchar(255) NOT NULL,
    `title`       varchar(255) NOT NULL,
    `begin`       date         NOT NULL,
    `end`         date         NOT NULL,
    `owner`       char(30)     NOT NULL,
    `members`     text         NOT NULL,
    `stories`     text         NOT NULL,
    `bugs`        text         NOT NULL,
    `cases`       text         NOT NULL,
    `report`      text         NOT NULL,
    `objectType`  varchar(20)  NOT NULL,
    `objectID`    mediumint(8) unsigned NOT NULL,
    `createdBy`   char(30)     NOT NULL,
    `createdDate` datetime     NOT NULL,
    `deleted`     enum('0','1') NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_testresult`
(
    `id`          mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `run`         mediumint(8) unsigned NOT NULL,
    `case`        mediumint(8) unsigned NOT NULL,
    `version`     smallint(5) unsigned NOT NULL,
    `job`         mediumint(8) unsigned NOT NULL,
    `compile`     mediumint(8) unsigned NOT NULL,
    `caseResult`  char(30)    NOT NULL,
    `stepResults` text        NOT NULL,
    `lastRunner`  varchar(30) NOT NULL,
    `date`        datetime    NOT NULL,
    `duration`    float       NOT NULL,
    `xml`         text        NOT NULL,
    PRIMARY KEY (`id`),
    KEY           `case` (`case`),
    KEY           `version` (`version`),
    KEY           `run` (`run`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_testrun`
(
    `id`            mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `task`          mediumint(8) unsigned NOT NULL DEFAULT 0,
    `case`          mediumint(8) unsigned NOT NULL DEFAULT 0,
    `version`       tinyint(3) unsigned NOT NULL DEFAULT 0,
    `assignedTo`    char(30)    NOT NULL DEFAULT '',
    `lastRunner`    varchar(30) NOT NULL,
    `lastRunDate`   datetime    NOT NULL,
    `lastRunResult` char(30)    NOT NULL,
    `status`        char(30)    NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `task` (`task`,`case`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_testsuite`
(
    `id`             mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `project`        mediumint(8) unsigned NOT NULL,
    `product`        mediumint(8) unsigned NOT NULL,
    `name`           varchar(255) NOT NULL,
    `desc`           text         NOT NULL,
    `type`           varchar(20)  NOT NULL,
    `addedBy`        char(30)     NOT NULL,
    `addedDate`      datetime     NOT NULL,
    `lastEditedBy`   char(30)     NOT NULL,
    `lastEditedDate` datetime     NOT NULL,
    `deleted`        enum('0','1') NOT NULL,
    PRIMARY KEY (`id`),
    KEY              `product` (`product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_testtask`
(
    `id`               mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `project`          mediumint(8) unsigned NOT NULL,
    `product`          mediumint(8) unsigned NOT NULL,
    `name`             char(90)     NOT NULL,
    `execution`        mediumint(8) unsigned NOT NULL DEFAULT 0,
    `build`            char(30)     NOT NULL,
    `type`             varchar(255) NOT NULL DEFAULT '',
    `owner`            varchar(30)  NOT NULL,
    `pri`              tinyint(3) unsigned NOT NULL DEFAULT 0,
    `begin`            date         NOT NULL,
    `end`              date         NOT NULL,
    `realFinishedDate` datetime     NOT NULL,
    `mailto`           text                  DEFAULT NULL,
    `desc`             text         NOT NULL,
    `report`           text         NOT NULL,
    `status`           enum('blocked','doing','wait','done') NOT NULL DEFAULT 'wait',
    `testreport`       mediumint(8) unsigned NOT NULL,
    `auto`             varchar(10)  NOT NULL DEFAULT 'no',
    `subStatus`        varchar(30)  NOT NULL DEFAULT '',
    `deleted`          enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY                `product` (`product`),
    KEY                `build` (`build`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_todo`
(
    `id`           mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `account`      char(30)     NOT NULL,
    `date`         date         NOT NULL,
    `begin`        smallint(4) unsigned zerofill NOT NULL,
    `end`          smallint(4) unsigned zerofill NOT NULL,
    `type`         char(10)     NOT NULL,
    `cycle`        tinyint(3) unsigned NOT NULL DEFAULT 0,
    `idvalue`      mediumint(8) unsigned NOT NULL DEFAULT 0,
    `pri`          tinyint(3) unsigned NOT NULL,
    `name`         char(150)    NOT NULL,
    `desc`         text         NOT NULL,
    `status`       enum('wait','doing','done','closed') NOT NULL DEFAULT 'wait',
    `private`      tinyint(1) NOT NULL,
    `config`       varchar(255) NOT NULL,
    `assignedTo`   varchar(30)  NOT NULL DEFAULT '',
    `assignedBy`   varchar(30)  NOT NULL DEFAULT '',
    `assignedDate` datetime     NOT NULL,
    `finishedBy`   varchar(30)  NOT NULL DEFAULT '',
    `finishedDate` datetime     NOT NULL,
    `closedBy`     varchar(30)  NOT NULL DEFAULT '',
    `closedDate`   datetime     NOT NULL,
    `deleted`      enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY            `account` (`account`),
    KEY            `assignedTo` (`assignedTo`),
    KEY            `finishedBy` (`finishedBy`),
    KEY            `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_user`
(
    `id`         mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `company`    mediumint(8) unsigned NOT NULL,
    `type`       char(30)     NOT NULL DEFAULT 'inside',
    `dept`       mediumint(8) unsigned NOT NULL DEFAULT 0,
    `account`    char(30)     NOT NULL DEFAULT '',
    `password`   char(32)     NOT NULL DEFAULT '',
    `role`       char(10)     NOT NULL DEFAULT '',
    `realname`   varchar(100) NOT NULL DEFAULT '',
    `nickname`   char(60)     NOT NULL DEFAULT '',
    `commiter`   varchar(100) NOT NULL,
    `avatar`     text         NOT NULL,
    `birthday`   date         NOT NULL DEFAULT '0000-00-00',
    `gender`     enum('f','m') NOT NULL DEFAULT 'f',
    `email`      char(90)     NOT NULL DEFAULT '',
    `skype`      char(90)     NOT NULL DEFAULT '',
    `qq`         char(20)     NOT NULL DEFAULT '',
    `mobile`     char(11)     NOT NULL DEFAULT '',
    `phone`      char(20)     NOT NULL DEFAULT '',
    `weixin`     varchar(90)  NOT NULL DEFAULT '',
    `dingding`   varchar(90)  NOT NULL DEFAULT '',
    `slack`      varchar(90)  NOT NULL DEFAULT '',
    `whatsapp`   varchar(90)  NOT NULL DEFAULT '',
    `address`    char(120)    NOT NULL DEFAULT '',
    `zipcode`    char(10)     NOT NULL DEFAULT '',
    `nature`     text         NOT NULL,
    `analysis`   text         NOT NULL,
    `strategy`   text         NOT NULL,
    `join`       date         NOT NULL DEFAULT '0000-00-00',
    `visits`     mediumint(8) unsigned NOT NULL DEFAULT 0,
    `ip`         char(15)     NOT NULL DEFAULT '',
    `last`       int(10) unsigned NOT NULL DEFAULT 0,
    `fails`      tinyint(5) NOT NULL DEFAULT 0,
    `locked`     datetime     NOT NULL DEFAULT '0000-00-00 00:00:00',
    `ranzhi`     char(30)     NOT NULL DEFAULT '',
    `score`      int(11) NOT NULL DEFAULT 0,
    `scoreLevel` int(11) NOT NULL DEFAULT 0,
    `deleted`    enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    UNIQUE KEY `account` (`account`),
    KEY          `dept` (`dept`),
    KEY          `email` (`email`),
    KEY          `commiter` (`commiter`),
    KEY          `deleted` (`deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_usercontact`
(
    `id`       mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `account`  char(30)    NOT NULL,
    `listName` varchar(60) NOT NULL,
    `userList` text        NOT NULL,
    PRIMARY KEY (`id`),
    KEY        `account` (`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_usergroup`
(
    `account` char(30) NOT NULL DEFAULT '',
    `group`   mediumint(8) unsigned NOT NULL DEFAULT 0,
    `project` text     NOT NULL,
    UNIQUE KEY `account` (`account`,`group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_userquery`
(
    `id`       mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `account`  char(30)    NOT NULL,
    `module`   varchar(30) NOT NULL,
    `title`    varchar(90) NOT NULL,
    `form`     text        NOT NULL,
    `sql`      text        NOT NULL,
    `shortcut` enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY        `account` (`account`),
    KEY        `module` (`module`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_usertpl`
(
    `id`      mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `account` char(30)     NOT NULL,
    `type`    char(30)     NOT NULL,
    `title`   varchar(150) NOT NULL,
    `content` text         NOT NULL,
    `public`  enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY       `account` (`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_userview`
(
    `account`  char(30)   NOT NULL,
    `programs` mediumtext NOT NULL,
    `products` mediumtext NOT NULL,
    `projects` mediumtext NOT NULL,
    `sprints`  mediumtext NOT NULL,
    UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_webhook`
(
    `id`          mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `type`        varchar(15)  NOT NULL DEFAULT 'default',
    `name`        varchar(50)  NOT NULL,
    `url`         varchar(255) NOT NULL,
    `domain`      varchar(255) NOT NULL,
    `secret`      varchar(255) NOT NULL,
    `contentType` varchar(30)  NOT NULL DEFAULT 'application/json',
    `sendType`    enum('sync','async') NOT NULL DEFAULT 'sync',
    `products`    text         NOT NULL,
    `executions`  text         NOT NULL,
    `params`      varchar(100) NOT NULL,
    `actions`     text         NOT NULL,
    `desc`        text         NOT NULL,
    `createdBy`   varchar(30)  NOT NULL,
    `createdDate` datetime     NOT NULL,
    `editedBy`    varchar(30)  NOT NULL,
    `editedDate`  datetime     NOT NULL,
    `deleted`     enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
