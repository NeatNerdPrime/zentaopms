UPDATE `zt_doc` SET `type` = 'text' WHERE `type` = 'url';

UPDATE `zt_doclib` SET `acl` = 'private' WHERE `type` = 'custom' and `acl` = 'custom';
UPDATE `zt_doclib` SET `acl` = 'private' WHERE `type` = 'product' AND `acl` = 'custom';
UPDATE `zt_doclib` SET `acl` = 'private' WHERE `type` = 'project' AND `acl` = 'custom';
UPDATE `zt_doclib` SET `acl` = 'default' WHERE `type` = 'project' AND `acl` IN ('open', 'private');

ALTER TABLE `zt_doclib` ADD `addedBy` varchar(30) NOT NULL AFTER `order`;
ALTER TABLE `zt_doclib` ADD `addedDate` datetime NOT NULL AFTER `addedBy`;

/* Update doc lib. */
UPDATE zt_doclib AS t1
INNER JOIN (SELECT * FROM zt_action WHERE `objectType` = 'doclib' AND `action` = 'created') AS t2 ON t1.`id` = t2.`objectID`
SET t1.`addedDate` = t2.`date`, t1.`addedBy` = t2.`actor`;

/* Update the product master library. */
UPDATE zt_doclib AS t1
INNER JOIN zt_product AS t2 ON t1.`product` = t2.`id`
SET t1.`addedDate` = t2.`createdDate`, t1.`addedBy` = t2.`createdBy`
WHERE t1.`type` = 'product' AND t1.`main` = '1';

/* Update the project master library. */
UPDATE zt_doclib AS t1
INNER JOIN  zt_project AS t2 ON t1.`project` = t2.`id`
SET t1.`addedDate` = t2.`openedDate`, t1.`addedBy` = t2.`openedBy`
WHERE t1.`type` = 'project' AND t1.`main` = '1';

/* Update the execution master library. */
UPDATE zt_doclib AS t1
INNER JOIN  zt_project AS t2 ON t1.`execution` = t2.`id`
SET t1.`addedDate` = t2.`openedDate`, t1.`addedBy` = t2.`openedBy`
WHERE t1.`type` = 'execution' AND t1.`main` = '1';
