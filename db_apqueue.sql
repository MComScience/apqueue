/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 100116
Source Host           : localhost:3306
Source Database       : db_apqueue

Target Server Type    : MYSQL
Target Server Version : 100116
File Encoding         : 65001

Date: 2017-02-03 11:27:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('Admin', '1', '1485945351');

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('/*', '2', null, null, null, '1485945342', '1485945342');
INSERT INTO `auth_item` VALUES ('/admin/*', '2', null, null, null, '1485945610', '1485945610');
INSERT INTO `auth_item` VALUES ('/site/*', '2', null, null, null, '1485945594', '1485945594');
INSERT INTO `auth_item` VALUES ('/user/*', '2', null, null, null, '1485945602', '1485945602');
INSERT INTO `auth_item` VALUES ('/user/settings/*', '2', null, null, null, '1485945663', '1485945663');
INSERT INTO `auth_item` VALUES ('Admin', '1', null, null, null, '1485945331', '1485945331');
INSERT INTO `auth_item` VALUES ('Dashboard', '2', null, null, null, '1485945584', '1485945584');
INSERT INTO `auth_item` VALUES ('จัดการข้อมูลส่วนตัว', '2', null, null, null, '1485945650', '1485945650');
INSERT INTO `auth_item` VALUES ('จัดการผู้ใช้งาน', '2', null, null, null, '1485945689', '1485945689');
INSERT INTO `auth_item` VALUES ('จัดการสิทธิ์', '2', null, null, null, '1485945708', '1485945708');

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('Admin', '/*');
INSERT INTO `auth_item_child` VALUES ('Admin', 'Dashboard');
INSERT INTO `auth_item_child` VALUES ('Admin', 'จัดการข้อมูลส่วนตัว');
INSERT INTO `auth_item_child` VALUES ('Admin', 'จัดการผู้ใช้งาน');
INSERT INTO `auth_item_child` VALUES ('Admin', 'จัดการสิทธิ์');
INSERT INTO `auth_item_child` VALUES ('Dashboard', '/site/*');
INSERT INTO `auth_item_child` VALUES ('จัดการข้อมูลส่วนตัว', '/user/settings/*');
INSERT INTO `auth_item_child` VALUES ('จัดการผู้ใช้งาน', '/user/*');
INSERT INTO `auth_item_child` VALUES ('จัดการสิทธิ์', '/admin/*');

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1485943619');
INSERT INTO `migration` VALUES ('m140209_132017_init', '1485944416');
INSERT INTO `migration` VALUES ('m140403_174025_create_account_table', '1485944416');
INSERT INTO `migration` VALUES ('m140504_113157_update_tables', '1485944417');
INSERT INTO `migration` VALUES ('m140504_130429_create_token_table', '1485944417');
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', '1485945225');
INSERT INTO `migration` VALUES ('m140830_171933_fix_ip_field', '1485944417');
INSERT INTO `migration` VALUES ('m140830_172703_change_account_table_name', '1485944417');
INSERT INTO `migration` VALUES ('m141022_115823_create_user_table', '1485943632');
INSERT INTO `migration` VALUES ('m141222_110026_update_ip_field', '1485944417');
INSERT INTO `migration` VALUES ('m141222_135246_alter_username_length', '1485944417');
INSERT INTO `migration` VALUES ('m150614_103145_update_social_account_table', '1485944418');
INSERT INTO `migration` VALUES ('m150623_212711_fix_username_notnull', '1485944418');
INSERT INTO `migration` VALUES ('m151218_234654_add_timezone_to_profile', '1485944418');
INSERT INTO `migration` VALUES ('m160929_103127_add_last_login_at_to_user_table', '1485944418');

-- ----------------------------
-- Table structure for profile
-- ----------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of profile
-- ----------------------------
INSERT INTO `profile` VALUES ('1', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'Asia/Bangkok');

-- ----------------------------
-- Table structure for session
-- ----------------------------
DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` char(40) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of session
-- ----------------------------
INSERT INTO `session` VALUES ('a2o671a79ben4065gn1k390ab4', '1485955311', 0x5F5F666C6173687C613A303A7B7D);

-- ----------------------------
-- Table structure for social_account
-- ----------------------------
DROP TABLE IF EXISTS `social_account`;
CREATE TABLE `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  UNIQUE KEY `account_unique_code` (`code`),
  KEY `fk_user_account` (`user_id`),
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of social_account
-- ----------------------------

-- ----------------------------
-- Table structure for token
-- ----------------------------
DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of token
-- ----------------------------
INSERT INTO `token` VALUES ('1', '0XPpX8nOG2ae1Rp0mkBsCtl7xZT30Izd', '1485945045', '0');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_login_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'admin@live.dev', '$2y$12$KnEmxKyvJFTgSulbRIYdZezAPOV6KRf.3iF5/W69cza1CNQd3Uy.m', 'KlFDZ6sVUjcGQ_wKobSaJ417PH4KCsss', '1485945045', null, null, '::1', '1485945045', '1485945045', '0', '1486002297');
