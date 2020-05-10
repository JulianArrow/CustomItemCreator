CREATE TABLE `custom_form_log` (
	`account_id` MEDIUMINT(8) NOT NULL,
	`character_id` MEDIUMINT(8) NOT NULL,
	`weapon_entry` INT(8) NOT NULL,
	`costs` SMALLINT(5) NOT NULL,
	`name` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`description` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`receipt` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
	`log_id` MEDIUMINT(8) NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`log_id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
;

CREATE TABLE `item_custom_by_player` (
	`entry` MEDIUMINT(8) NOT NULL,
	PRIMARY KEY (`entry`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;