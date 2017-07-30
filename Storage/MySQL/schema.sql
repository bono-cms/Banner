
DROP TABLE IF EXISTS `bono_module_banner`;
CREATE TABLE `bono_module_banner` (
	
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `category_id` INT NOT NULL,
	`lang_id` INT NOT NULL,
	`name` varchar(254) NOT NULL,
	`link` varchar(254) NOT NULL,
	`file` varchar(254) NOT NULL
	
) DEFAULT CHARSET = UTF8;


DROP TABLE IF EXISTS `bono_module_banner_categories`;
CREATE TABLE `bono_module_banner_categories` (

	`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`name` varchar(255) NOT NULL

) DEFAULT CHARSET = UTF8;