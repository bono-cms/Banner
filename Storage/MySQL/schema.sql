/* Optional categories */
DROP TABLE IF EXISTS `bono_module_banner_categories`;
CREATE TABLE `bono_module_banner_categories` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* Banners */
DROP TABLE IF EXISTS `bono_module_banner`;
CREATE TABLE `bono_module_banner` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `category_id` INT, -- Removed NOT NULL to allow SET NULL
    `lang_id` INT NOT NULL,
    `name` VARCHAR(254) NOT NULL,
    `link` VARCHAR(254) NOT NULL,
    `file` VARCHAR(254) NOT NULL,
    `clicks` INT DEFAULT 0 COMMENT 'Click counter',
    `max_clicks` INT DEFAULT 0 COMMENT 'Maximal allowed clicks',
    `views` INT DEFAULT 0 COMMENT 'View counter',
    `max_views` INT DEFAULT 0 COMMENT 'Maximal allowed views',
    `datetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Uploading date and time',
    `max_datetime` TIMESTAMP NULL DEFAULT NULL COMMENT 'Ending date and time',
    `expiration_type` SMALLINT(1) DEFAULT 0 COMMENT '0 - Never, 1 - clicks, 2 - views, 3 - datetime',

    CONSTRAINT fk_banner_lang FOREIGN KEY (lang_id) 
        REFERENCES bono_module_cms_languages(id) 
        ON DELETE CASCADE,
        
    CONSTRAINT fk_banner_category FOREIGN KEY (category_id) 
        REFERENCES bono_module_banner_categories(id) 
        ON DELETE SET NULL 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
