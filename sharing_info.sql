CREATE SCHEMA `sharing_info`;

DROP TABLE IF EXISTS `sharing_info`.`sharing_links`;
CREATE TABLE `sharing_info`.`sharing_links` (
    `token` VARCHAR(50) PRIMARY KEY NOT NULL,
    `url` VARCHAR(256) NOT NULL,
    `subscriber_id` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `active` INT(1) NOT NULL
);


DROP TABLE IF EXISTS `sharing_info`.`sharing_links_actions`;
CREATE TABLE `sharing_info`.`sharing_links_actions` (
    `token` VARCHAR(50) NOT NULL,
    `ip_address` VARCHAR(50) NOT NULL,
    `date` DATETIME NOT NULL,
    FOREIGN KEY (`token`) 
        REFERENCES `sharing_links`(`token`)
);



DELIMITER $$
DROP PROCEDURE IF EXISTS `sharing_links_create`$$
CREATE PROCEDURE `sharing_links_create`
	(IN `$token` VARCHAR(50), 
	IN `$url` VARCHAR(256), 
	IN `$subscriber_id` INT(20), 
	IN `$active` INT(1))
BEGIN
	INSERT INTO sharing_links (token,url,subscriber_id,active)
		VALUES (`$token`,
			`$url`,
			`$subscriber_id`,
			`$active`);
END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sharing_links_update`$$
CREATE PROCEDURE `sharing_links_update`
	(IN `$token` VARCHAR(50), 
	IN `$url` VARCHAR(256),  
	IN `$active` INT(1))
BEGIN
	UPDATE `sharing_links` 
		SET `url` = `$url`,
		`active` = `$active`
		WHERE `token` = `$token`;
END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sharing_links_delete`$$
CREATE PROCEDURE `sharing_links_delete`
	(IN `$token` VARCHAR(50))
BEGIN
	SET FOREIGN_KEY_CHECKS=0;
	DELETE FROM `sharing_links_actions` 
		WHERE `token` = `$token`;
	
END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sharing_links_lookup`$$
CREATE PROCEDURE `sharing_links_lookup`
	(IN `$token` VARCHAR(50),
	IN `$ip` VARCHAR(50),
	IN `$date` DATETIME)
BEGIN
	INSERT INTO `sharing_links_actions` 
	VALUES (`$token`, `$ip`, `$date`);
END$$
DELIMITER ;

