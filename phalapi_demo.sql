-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-10-31 02:44:40
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phalapi_demo`
--

-- --------------------------------------------------------

--
-- 表的结构 `ic_site`
--

CREATE TABLE IF NOT EXISTS `ic_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '网站ID',
  `name` varchar(200) NOT NULL COMMENT '网站名称',
  `domain` varchar(50) NOT NULL COMMENT '网站域名',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '网站状态1.正常，2.禁用',
  `is_del` tinyint(1) NOT NULL COMMENT '是否删除，0.未删除，1.已删除',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ic_site_field_config`
--

CREATE TABLE IF NOT EXISTS `ic_site_field_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '参数字段配置',
  `site_url_id` int(11) NOT NULL COMMENT '把属性链接ID',
  `field_name` varchar(50) NOT NULL COMMENT '参数字段名',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '字段类型[1.string,2.int,3.float,4.boolean,5.date,6.array,7.enum,8.file,9.callable]',
  `is_require` tinyint(1) NOT NULL COMMENT '是否必填（1.必填，2，非必填）',
  `max` int(11) NOT NULL COMMENT '是大长度（字符长度，文件大小）',
  `min` int(11) NOT NULL COMMENT '最小长度（字符长度，文件大小）',
  `format` varchar(100) NOT NULL COMMENT '参数格式',
  `separator_symbol` varchar(20) NOT NULL COMMENT '分隔符（6.数组参数使用）',
  `range_value` varchar(255) NOT NULL COMMENT '范围（枚举，文件时使用，保存JSON数组）',
  `ext` int(255) NOT NULL COMMENT '支持的文件扩展名（文件类型使用保存json数组）',
  `default_value` varchar(255) NOT NULL COMMENT '默认值',
  `desc_info` int(255) NOT NULL COMMENT '字段描述',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态（1.正常，2.禁用）',
  `is_del` int(11) NOT NULL COMMENT '是否删除（0.未删除，1.已删除）',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ic_site_login_config`
--

CREATE TABLE IF NOT EXISTS `ic_site_login_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '登录配置ID',
  `site_url_id` int(11) NOT NULL COMMENT '所属地址ID（type=2）',
  `url_login` varchar(255) NOT NULL COMMENT '登录链接，即提交参数的链接',
  `url_logout` varchar(255) NOT NULL COMMENT '登出链接',
  `flag_check` varchar(255) NOT NULL COMMENT '是否登录（检查是否已经登录），登录成功后页面会显示的文字',
  `flag_login` varchar(255) NOT NULL COMMENT '是否登录成功（提交数据后检查是否登录成功），登录成功递交时会显示的文字',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（1.正常，2.禁用）',
  `is_del` tinyint(1) NOT NULL COMMENT '是否删除（0.未删除，1.已删除）',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录配置信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ic_site_url`
--

CREATE TABLE IF NOT EXISTS `ic_site_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'url地址ID',
  `site_id` int(11) NOT NULL COMMENT '对应的网站ID',
  `type` tinyint(4) NOT NULL COMMENT '链接类型：1.注册页面，2.登录页面 ,3.登录数据提交｜页面获取',
  `url` varchar(200) NOT NULL COMMENT 'URL地址',
  `name` varchar(200) NOT NULL COMMENT '链接名称（如登录页面，添加文章，评论页面）',
  `method_name` varchar(50) NOT NULL COMMENT '方法名',
  `class_name` varchar(50) NOT NULL COMMENT '类名',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（1.正常，2.禁用））',
  `is_del` tinyint(1) NOT NULL COMMENT '是否删除（0.未删除，1.已删除））',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站链接表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ic_users`
--

CREATE TABLE IF NOT EXISTS `ic_users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ic_users`
--

INSERT INTO `ic_users` (`user_id`, `mobile_phone`, `domain`, `key`, `pay_password`, `nickname`, `salt`, `status`, `ctime`, `utime`) VALUES
(1, '', 'www.baidu.com', '6df6501f14ec609e1f9748a791215ecb', '', '百度', '5521', 0, 0, 0),
(2, '', 'www.google.com', '3e58107cd690292f6ab9f1fba2002b2c', '', '谷歌', '8784', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ic_user_info`
--

CREATE TABLE IF NOT EXISTS `ic_user_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `source_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '来源类型（1：搜索引擎；2：论坛；3：线下；4：朋友推荐；5：其它）',
  `grade` tinyint(1) DEFAULT '0' COMMENT '用户等级',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ic_user_recharge`
--

CREATE TABLE IF NOT EXISTS `ic_user_recharge` (
  `recharge_id` int(11) NOT NULL AUTO_INCREMENT,
  `recharge_sn` varchar(18) NOT NULL DEFAULT '' COMMENT '订单编号',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态（0：未付款；1：付款中；2：已付款）',
  `pay_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '支付方式（2：微信；3：支付宝；）',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `ctime` int(11) NOT NULL DEFAULT '0' COMMENT '充值时间',
  `utime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`recharge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
