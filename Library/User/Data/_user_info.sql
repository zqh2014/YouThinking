# Host: 192.168.1.40  (Version: 5.6.24-log)
# Date: 2016-09-22 11:48:51
# Generator: MySQL-Front 5.3  (Build 4.214)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "cff_user_info"
#

CREATE TABLE `ic_user_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `source_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '来源类型（1：搜索引擎；2：论坛；3：线下；4：朋友推荐；5：其它）',
  `grade` tinyint(1) DEFAULT '0' COMMENT '用户等级（对应cff_dictionary表type=''user_grade''匹配）',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `integral_frozen` int(11) NOT NULL DEFAULT '0' COMMENT '冻结的积分',
  `email` varchar(60) DEFAULT '' COMMENT '会员邮箱',
  `sex` tinyint(1) DEFAULT '1' COMMENT '性别（0：未知，1：男，2：女，3：其它）',
  `avatar_image` varchar(200) DEFAULT '' COMMENT '用户头像',
  `reg_time` int(11) DEFAULT '0' COMMENT '注册时间',
  `last_login_time` int(11) DEFAULT '0' COMMENT '最后登录时间',
  `ctime` int(11) DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
