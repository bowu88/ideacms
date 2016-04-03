-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `name` text NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `config` (`name`, `value`) VALUES
('title',	''),
('admin',	''),
('pass',	''),
('apikey',	''),
('date',	'');

DROP TABLE IF EXISTS `count`;
CREATE TABLE `count` (
  `year` int(10) unsigned NOT NULL,
  `month` int(10) unsigned NOT NULL,
  `day` int(10) unsigned NOT NULL,
  `time` text NOT NULL,
  `get` text NOT NULL,
  `referrer` text NOT NULL,
  `ip` text NOT NULL,
  `country` text NOT NULL,
  `province` text NOT NULL,
  `city` text NOT NULL,
  `district` text NOT NULL,
  `carrier` text NOT NULL,
  `os` text NOT NULL,
  `lang` text NOT NULL,
  `browser` text NOT NULL,
  `ua` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2016-03-11 05:59:56
