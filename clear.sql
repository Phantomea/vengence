-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `title` varchar(50) NOT NULL,
  `preview` varchar(50) NOT NULL DEFAULT 'images/articles/default.png',
  `published` datetime NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `article_ibfk_3` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bank_account`;
CREATE TABLE `bank_account` (
  `bank_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `money` int(11) NOT NULL DEFAULT '1000',
  `diamonds` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`bank_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `bank_account` (`bank_account_id`, `money`, `diamonds`) VALUES
(1,	1000,	10),
(2,	1000,	10),
(3,	1000,	10),
(6,	1000,	10);

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE `equipment` (
  `equipment_id` int(11) NOT NULL AUTO_INCREMENT,
  `helmet_id` int(11) DEFAULT NULL,
  `mask_id` int(11) DEFAULT NULL,
  `necklace_id` int(11) DEFAULT NULL,
  `armor_id` int(11) DEFAULT NULL,
  `cloak_id` int(11) DEFAULT NULL,
  `ring_id` int(11) DEFAULT NULL,
  `belt_id` int(11) DEFAULT NULL,
  `glove_id` int(11) DEFAULT NULL,
  `trouser_id` int(11) DEFAULT NULL,
  `boot_id` int(11) DEFAULT NULL,
  `first_weapon_id` int(11) DEFAULT NULL,
  `second_weapon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`equipment_id`),
  KEY `id_helmet` (`helmet_id`),
  KEY `id_mask` (`mask_id`),
  KEY `id_necklace` (`necklace_id`),
  KEY `id_clothes` (`armor_id`),
  KEY `id_cloak` (`cloak_id`),
  KEY `id_gloves` (`glove_id`),
  KEY `id_pants` (`trouser_id`),
  KEY `id_boots` (`boot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `equipment` (`equipment_id`, `helmet_id`, `mask_id`, `necklace_id`, `armor_id`, `cloak_id`, `ring_id`, `belt_id`, `glove_id`, `trouser_id`, `boot_id`, `first_weapon_id`, `second_weapon_id`) VALUES
(1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(6,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `size` tinyint(4) NOT NULL DEFAULT '10',
  PRIMARY KEY (`inventory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `avatar` varchar(150) NOT NULL DEFAULT '/images/items/default.png',
  `strength` int(11) NOT NULL DEFAULT '0',
  `agility` int(11) NOT NULL DEFAULT '0',
  `intelligence` int(11) NOT NULL DEFAULT '0',
  `vitality` int(11) NOT NULL DEFAULT '0',
  `charisma` int(11) NOT NULL DEFAULT '0',
  `armor` int(11) NOT NULL DEFAULT '0',
  `first_damage` int(11) NOT NULL DEFAULT '0',
  `second_damage` int(11) NOT NULL DEFAULT '0',
  `health` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '1',
  `type` enum('helmet','mask','cloak','necklace','armor','glove','ring','belt','trousers','boot','first_weapon','second_weapon','potion') NOT NULL,
  `owner` enum('1','2') NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `item` (`item_id`, `name`, `avatar`, `strength`, `agility`, `intelligence`, `vitality`, `charisma`, `armor`, `first_damage`, `second_damage`, `health`, `level`, `type`, `owner`) VALUES
(3,	'Cape of Damned',	'images/items/Cape_of_Damned.png',	6,	0,	5,	0,	0,	0,	0,	0,	0,	1,	'helmet',	'1'),
(4,	'Normal hat',	'/images/items/default.png',	0,	0,	0,	0,	0,	20,	0,	0,	0,	1,	'helmet',	'2');

DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `avatar` varchar(200) NOT NULL DEFAULT 'images/locations/default.png',
  `minimum_level` varchar(200) NOT NULL,
  `maximum_level` tinyint(4) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `location_npc`;
CREATE TABLE `location_npc` (
  `location_npc_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) DEFAULT NULL,
  `npc_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`location_npc_id`),
  KEY `id_npc` (`npc_id`),
  KEY `id_locations` (`location_id`),
  CONSTRAINT `location_npc_ibfk_2` FOREIGN KEY (`npc_id`) REFERENCES `npc` (`npc_id`) ON DELETE NO ACTION,
  CONSTRAINT `location_npc_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `menu` (`menu_id`, `name`) VALUES
(1,	'Admin menu'),
(2,	'Player Menu'),
(3,	'Moderator menu');

DROP TABLE IF EXISTS `menu_item`;
CREATE TABLE `menu_item` (
  `menu_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  PRIMARY KEY (`menu_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `menu_item` (`menu_item_id`, `name`, `link`) VALUES
(1,	'User manager',	'User:default'),
(2,	'Menu manager',	'Menu:default'),
(7,	'Item manager',	'Item:default');

DROP TABLE IF EXISTS `menu_menu_item`;
CREATE TABLE `menu_menu_item` (
  `menu_menu_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_menu_item_id`),
  KEY `menu_id` (`menu_id`),
  KEY `menu_item_id` (`menu_item_id`),
  CONSTRAINT `menu_menu_item_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE,
  CONSTRAINT `menu_menu_item_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item` (`menu_item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `menu_menu_item` (`menu_menu_item_id`, `menu_id`, `menu_item_id`) VALUES
(1,	1,	1),
(2,	1,	2),
(7,	1,	7);

DROP TABLE IF EXISTS `spell`;
CREATE TABLE `spell` (
  `spell_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `info` varchar(255) NOT NULL,
  `damage` int(11) NOT NULL,
  `mana` int(11) NOT NULL,
  `avatar` varchar(200) NOT NULL DEFAULT 'images/spells/default.png',
  PRIMARY KEY (`spell_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `spell` (`spell_id`, `name`, `info`, `damage`, `mana`, `avatar`) VALUES
(1,	'Tackle',	'Use this spell to tackle the enemy and deal',	10,	1,	'images/spells/default.png');

DROP TABLE IF EXISTS `state`;
CREATE TABLE `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `strength` int(11) NOT NULL DEFAULT '0',
  `agility` int(11) NOT NULL DEFAULT '0',
  `intelligence` int(11) NOT NULL DEFAULT '0',
  `vitality` int(11) NOT NULL DEFAULT '0',
  `charisma` int(11) NOT NULL DEFAULT '0',
  `armor` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(200) NOT NULL,
  `role` enum('admin','guest','player','moderator','banned') NOT NULL DEFAULT 'player',
  `type` enum('1','2') DEFAULT NULL,
  `avatar` varchar(50) NOT NULL DEFAULT 'images/users/default.jpg',
  `user_state_id` int(11) NOT NULL,
  `equip_id` int(11) NOT NULL,
  `bank_account_id` int(11) NOT NULL,
  `user_spell` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `id_armors` (`equip_id`),
  KEY `user_stat_id` (`user_state_id`),
  KEY `bank_account_id` (`bank_account_id`),
  KEY `user_spell` (`user_spell`),
  KEY `inventory_id` (`inventory_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `user_ibfk_10` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_account` (`bank_account_id`) ON DELETE CASCADE,
  CONSTRAINT `user_ibfk_11` FOREIGN KEY (`user_spell`) REFERENCES `user_spell` (`user_spell_id`) ON DELETE CASCADE,
  CONSTRAINT `user_ibfk_13` FOREIGN KEY (`equip_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE CASCADE,
  CONSTRAINT `user_ibfk_14` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE NO ACTION,
  CONSTRAINT `user_ibfk_7` FOREIGN KEY (`user_state_id`) REFERENCES `user_state` (`user_state_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`user_id`, `username`, `password`, `birth_date`, `email`, `role`, `type`, `avatar`, `user_state_id`, `equip_id`, `bank_account_id`, `user_spell`, `menu_id`, `inventory_id`) VALUES
(1,	'Phantomea',	'$2y$10$ETVt05fO/AStHGSb9QBxSOCUsOe5fZ3nir0YihjZX/Sy/bpIAVHY6',	'2016-03-17',	'blend.miro@gmail.com',	'admin',	'2',	'/images/users/default.jpg',	1,	1,	1,	1,	1,	0),
(2,	'jemitojedno',	'$2y$10$ETVt05fO/AStHGSb9QBxSOCUsOe5fZ3nir0YihjZX/Sy/bpIAVHY6',	'1994-12-23',	'julius.gala@gmail.com',	'admin',	'1',	'/images/users/default.jpg',	2,	2,	2,	6,	1,	0),
(3,	'Lavitz',	'$2y$10$ETVt05fO/AStHGSb9QBxSOCUsOe5fZ3nir0YihjZX/Sy/bpIAVHY6',	'1994-12-29',	'palopetras.lavitz@gmail.com',	'admin',	'1',	'/images/users/default.jpg',	3,	3,	3,	7,	1,	0),
(4,	'Kanekii',	'$2y$10$YlLq6Xxc/jVZoP4glyCPdeKVf7OFj6LmrllGh2qFXjodYN24kGHZa',	'2000-01-01',	'email@gmail.com',	'player',	'1',	'/images/users/Kanekii.png',	7,	6,	6,	8,	2,	0);

DROP TABLE IF EXISTS `user_spell`;
CREATE TABLE `user_spell` (
  `user_spell_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_spell` int(11) DEFAULT '1',
  `second_spell` int(11) DEFAULT NULL,
  `third_spell` int(11) DEFAULT NULL,
  `fourt_spell` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_spell_id`),
  KEY `first_spell` (`first_spell`),
  CONSTRAINT `user_spell_ibfk_3` FOREIGN KEY (`first_spell`) REFERENCES `spell` (`spell_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_spell` (`user_spell_id`, `first_spell`, `second_spell`, `third_spell`, `fourt_spell`) VALUES
(1,	1,	NULL,	NULL,	NULL),
(6,	1,	NULL,	NULL,	NULL),
(7,	1,	NULL,	NULL,	NULL),
(8,	1,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `user_state`;
CREATE TABLE `user_state` (
  `user_state_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_damage` int(11) NOT NULL DEFAULT '1',
  `second_damage` int(11) NOT NULL DEFAULT '1',
  `dodge` int(11) NOT NULL DEFAULT '0',
  `critical_strike` int(11) NOT NULL DEFAULT '0',
  `double_chance` int(11) NOT NULL DEFAULT '0',
  `armor` int(11) NOT NULL DEFAULT '0',
  `strength` int(11) NOT NULL DEFAULT '10',
  `agility` int(11) NOT NULL DEFAULT '10',
  `intelligence` int(11) NOT NULL DEFAULT '10',
  `vitality` int(11) NOT NULL DEFAULT '10',
  `charisma` int(11) NOT NULL DEFAULT '10',
  `health` int(11) NOT NULL DEFAULT '300',
  `max_health` int(11) NOT NULL DEFAULT '300',
  `experiences` int(11) NOT NULL DEFAULT '1',
  `level` int(11) NOT NULL DEFAULT '1',
  `points` int(11) NOT NULL DEFAULT '10',
  `attacked` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`user_state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_state` (`user_state_id`, `first_damage`, `second_damage`, `dodge`, `critical_strike`, `double_chance`, `armor`, `strength`, `agility`, `intelligence`, `vitality`, `charisma`, `health`, `max_health`, `experiences`, `level`, `points`, `attacked`) VALUES
(1,	1,	1,	0,	0,	0,	0,	10,	10,	10,	10,	10,	300,	300,	1,	1,	10,	'00:00:00'),
(2,	1,	1,	0,	0,	0,	0,	10,	10,	10,	10,	10,	300,	300,	1,	1,	10,	'00:00:00'),
(3,	1,	1,	0,	0,	0,	0,	10,	10,	10,	10,	10,	300,	300,	1,	1,	10,	'00:00:00'),
(7,	1,	1,	0,	0,	0,	0,	10,	10,	10,	10,	10,	300,	300,	1,	1,	10,	'00:00:00');

-- 2016-10-06 10:52:43
