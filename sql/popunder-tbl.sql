CREATE TABLE IF NOT EXISTS `popunderpopup` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `width` INT unsigned NOT NULL default '75',
  `height` INT unsigned NOT NULL default '75',
  `expiration` datetime NOT NULL default '9999-12-31 00:00:00',
  `starttime` datetime NOT NULL default '2014-05-01 00:00:00',
  `group` VARCHAR(10) NOT NULL default 'Category1',
  `timeout` VARCHAR(6) NOT NULL default '2000',
  `type` VARCHAR(10) NOT NULL default 'url',
  `htmltext` TEXT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;