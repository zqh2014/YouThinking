# Host: 192.168.1.40  (Version: 5.6.24-log)
# Date: 2016-09-22 11:46:54
# Generator: MySQL-Front 5.3  (Build 4.214)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "cff_users"
#

CREATE TABLE `ic_users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID，自增',
  `mobile_phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `domain` varchar(100) NOT NULL DEFAULT '' COMMENT '+',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT '密匙',
  `pay_password` varchar(32) NOT NULL DEFAULT '' COMMENT '支付密码密码（MD32位加密）',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '公司名',
  `salt` varchar(10) NOT NULL DEFAULT '' COMMENT '密码加密字符戳（规则：0-10位数随机数字字符串）',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态（0：正常使用，1： 暂停使用，-1：管理员禁用）',
  `ctime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
