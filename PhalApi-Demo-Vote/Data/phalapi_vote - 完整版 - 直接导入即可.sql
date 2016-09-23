/*
Navicat MySQL Data Transfer

Source Server         : win7-localhost
Source Server Version : 50703
Source Host           : 127.0.0.1:3306
Source Database       : phalapi_vote

Target Server Type    : MYSQL
Target Server Version : 50703
File Encoding         : 65001

Date: 2015-09-13 17:44:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `phalapi_user`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user`;
CREATE TABLE `phalapi_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UID',
  `username` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(50) DEFAULT '' COMMENT '昵称',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(32) DEFAULT NULL COMMENT '随机加密因子',
  `reg_time` int(11) DEFAULT '0' COMMENT '注册时间',
  `avatar` varchar(255) DEFAULT '' COMMENT '头像',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_unique_key` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_login_qq`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_login_qq`;
CREATE TABLE `phalapi_user_login_qq` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `qq_openid` varchar(28) DEFAULT '' COMMENT 'QQ的OPENID',
  `qq_token` varchar(150) DEFAULT '' COMMENT 'QQ的TOKEN',
  `qq_expires_in` int(10) DEFAULT '0' COMMENT 'QQ的失效时间',
  `user_id` bigint(10) DEFAULT '0' COMMENT '绑定的用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_login_qq
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_login_sina`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_login_sina`;
CREATE TABLE `phalapi_user_login_sina` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `sina_openid` varchar(28) DEFAULT '' COMMENT '新浪微博的OPENID',
  `sina_token` varchar(150) DEFAULT '' COMMENT '新浪微博的TOKEN',
  `sina_expires_in` int(10) DEFAULT '0' COMMENT '新浪微博的失效时间',
  `user_id` bigint(10) DEFAULT '0' COMMENT '绑定的用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_login_sina
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_login_weixin`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_login_weixin`;
CREATE TABLE `phalapi_user_login_weixin` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `wx_openid` varchar(28) DEFAULT '' COMMENT '微信OPENID',
  `wx_token` varchar(150) DEFAULT '' COMMENT '微信TOKEN',
  `wx_expires_in` int(10) DEFAULT '0' COMMENT '微信失效时间',
  `user_id` bigint(10) DEFAULT '0' COMMENT '绑定的用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_login_weixin
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_session_0`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_session_0`;
CREATE TABLE `phalapi_user_session_0` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0' COMMENT '用户id',
  `token` varchar(64) DEFAULT '' COMMENT '登录token',
  `client` varchar(32) DEFAULT '' COMMENT '客户端来源',
  `times` int(6) DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `expires_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `ext_data` text COMMENT 'json data here',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_session_0
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_session_1`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_session_1`;
CREATE TABLE `phalapi_user_session_1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0' COMMENT '用户id',
  `token` varchar(64) DEFAULT '' COMMENT '登录token',
  `client` varchar(32) DEFAULT '' COMMENT '客户端来源',
  `times` int(6) DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `expires_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `ext_data` text COMMENT 'json data here',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_session_1
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_session_2`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_session_2`;
CREATE TABLE `phalapi_user_session_2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0' COMMENT '用户id',
  `token` varchar(64) DEFAULT '' COMMENT '登录token',
  `client` varchar(32) DEFAULT '' COMMENT '客户端来源',
  `times` int(6) DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `expires_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `ext_data` text COMMENT 'json data here',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_session_2
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_session_3`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_session_3`;
CREATE TABLE `phalapi_user_session_3` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0' COMMENT '用户id',
  `token` varchar(64) DEFAULT '' COMMENT '登录token',
  `client` varchar(32) DEFAULT '' COMMENT '客户端来源',
  `times` int(6) DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `expires_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `ext_data` text COMMENT 'json data here',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_session_3
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_session_4`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_session_4`;
CREATE TABLE `phalapi_user_session_4` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0' COMMENT '用户id',
  `token` varchar(64) DEFAULT '' COMMENT '登录token',
  `client` varchar(32) DEFAULT '' COMMENT '客户端来源',
  `times` int(6) DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `expires_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `ext_data` text COMMENT 'json data here',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_session_4
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_session_5`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_session_5`;
CREATE TABLE `phalapi_user_session_5` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0' COMMENT '用户id',
  `token` varchar(64) DEFAULT '' COMMENT '登录token',
  `client` varchar(32) DEFAULT '' COMMENT '客户端来源',
  `times` int(6) DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `expires_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `ext_data` text COMMENT 'json data here',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_session_5
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_session_6`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_session_6`;
CREATE TABLE `phalapi_user_session_6` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0' COMMENT '用户id',
  `token` varchar(64) DEFAULT '' COMMENT '登录token',
  `client` varchar(32) DEFAULT '' COMMENT '客户端来源',
  `times` int(6) DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `expires_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `ext_data` text COMMENT 'json data here',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_session_6
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_session_7`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_session_7`;
CREATE TABLE `phalapi_user_session_7` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0' COMMENT '用户id',
  `token` varchar(64) DEFAULT '' COMMENT '登录token',
  `client` varchar(32) DEFAULT '' COMMENT '客户端来源',
  `times` int(6) DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `expires_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `ext_data` text COMMENT 'json data here',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_session_7
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_session_8`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_session_8`;
CREATE TABLE `phalapi_user_session_8` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0' COMMENT '用户id',
  `token` varchar(64) DEFAULT '' COMMENT '登录token',
  `client` varchar(32) DEFAULT '' COMMENT '客户端来源',
  `times` int(6) DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `expires_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `ext_data` text COMMENT 'json data here',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_session_8
-- ----------------------------

-- ----------------------------
-- Table structure for `phalapi_user_session_9`
-- ----------------------------
DROP TABLE IF EXISTS `phalapi_user_session_9`;
CREATE TABLE `phalapi_user_session_9` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0' COMMENT '用户id',
  `token` varchar(64) DEFAULT '' COMMENT '登录token',
  `client` varchar(32) DEFAULT '' COMMENT '客户端来源',
  `times` int(6) DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `expires_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `ext_data` text COMMENT 'json data here',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phalapi_user_session_9
-- ----------------------------
