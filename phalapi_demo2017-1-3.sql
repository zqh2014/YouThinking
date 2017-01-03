-- phpMyAdmin SQL Dump
-- version 4.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 01 月 03 日 02:13
-- 服务器版本: 5.5.31
-- PHP 版本: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `phalapi_demo`
--

-- --------------------------------------------------------

--
-- 表的结构 `ic_article`
--

CREATE TABLE IF NOT EXISTS `ic_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL COMMENT '文章标题',
  `file_name` varchar(100) NOT NULL COMMENT '文件名',
  `file_url` int(100) NOT NULL COMMENT '文件地址',
  `original_url` varchar(250) NOT NULL,
  `type` int(11) NOT NULL COMMENT '文章类型',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  `status` tinyint(4) NOT NULL COMMENT '状态(0.未采集1.已采集并显示，2已采集不显示)',
  `is_ready` tinyint(4) NOT NULL COMMENT '该项是否可以以采集（0.不可以，1可以（参数准备完毕））',
  `is_show` tinyint(4) NOT NULL COMMENT '是否在官网显示（1.是，2.否）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_name` (`file_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ic_article`
--

INSERT INTO `ic_article` (`id`, `title`, `file_name`, `file_url`, `original_url`, `type`, `ctime`, `status`, `is_ready`, `is_show`) VALUES
(1, '1', '1', 1, '1', 1, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ic_article_type`
--

CREATE TABLE IF NOT EXISTS `ic_article_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `type` varchar(100) NOT NULL COMMENT '类型名',
  `status` tinyint(4) NOT NULL COMMENT '1.启用，2.未审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ic_site`
--

CREATE TABLE IF NOT EXISTS `ic_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '网站ID',
  `name` varchar(200) NOT NULL COMMENT '网站名称',
  `domain` varchar(50) NOT NULL COMMENT '网站域名',
  `site_logo` varchar(200) NOT NULL COMMENT '网站logo',
  `login_url_id` int(11) NOT NULL COMMENT '对应site_url_id(type=2,登录链接)',
  `sort` int(11) NOT NULL COMMENT '排序,数字越大越靠前',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '网站状态1.正常，2.禁用',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除，0.未删除，1.已删除',
  `ctime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='网站表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ic_site`
--

INSERT INTO `ic_site` (`id`, `name`, `domain`, `site_logo`, `login_url_id`, `sort`, `status`, `is_del`, `ctime`) VALUES
(1, 'icoord', 'http://www.icoord.com', '', 1, 0, 1, 0, 0),
(2, '新浪博客', 'http://blog.sina.com.cn', '', 0, 0, 1, 0, 0);

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
  `ext` varchar(255) NOT NULL COMMENT '支持的文件扩展名（文件类型使用保存json数组）',
  `default_value` varchar(255) NOT NULL COMMENT '默认值',
  `desc_info` varchar(255) NOT NULL COMMENT '字段描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（1.正常，2.禁用）',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0.未删除，1.已删除）',
  `ctime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `ic_site_field_config`
--

INSERT INTO `ic_site_field_config` (`id`, `site_url_id`, `field_name`, `type`, `is_require`, `max`, `min`, `format`, `separator_symbol`, `range_value`, `ext`, `default_value`, `desc_info`, `status`, `is_del`, `ctime`) VALUES
(1, 1, 'username', 1, 1, 0, 0, '', '', '', '0', '', '用户名', 1, 0, 0),
(2, 1, 'password', 1, 1, 0, 0, '', '', '', '0', '', '密码', 1, 0, 0),
(3, 2, 'nickname', 1, 1, 0, 0, '', '', '', '', '', '昵称', 1, 0, 0),
(4, 2, 'sex', 1, 0, 0, 0, '', '', '', '', '', '性别', 1, 0, 0),
(5, 2, 'province', 1, 0, 0, 0, '', '', '', '', '', '', 1, 0, 0),
(6, 2, 'city', 1, 0, 0, 0, '', '', '', '', '', '', 1, 0, 0),
(7, 2, 'district', 1, 0, 0, 0, '', '', '', '', '', '', 1, 0, 0),
(8, 2, 'signature', 1, 0, 0, 0, '', '', '', '', '', '', 1, 0, 0),
(9, 2, 'cdult', 1, 0, 0, 0, '', '', '', '', '', '', 1, 0, 0);

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
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0.未删除，1.已删除）',
  `ctime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='登录配置信息' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ic_site_login_config`
--

INSERT INTO `ic_site_login_config` (`id`, `site_url_id`, `url_login`, `url_logout`, `flag_check`, `flag_login`, `status`, `is_del`, `ctime`) VALUES
(1, 1, '/index.php?s=/ucenter/member/login.html', '/index.php?s=/ucenter/system/logout.html', '未读', '未读', 1, 0, 1111111),
(2, 3, 'https://login.sina.com.cn/sso/login.php?client=ssologin.js(v1.4.15)&_=1478513461378', 'https://login.sina.com.cn/sso/login.php?client=ssologin.js(v1.4.15)&_=1478513461378', '"retcode":"0"', '博客年龄', 1, 0, 0);

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
  `success_keyword` varchar(100) NOT NULL COMMENT '成功显示的文字。',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（1.正常，2.禁用））',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0.未删除，1.已删除））',
  `ctime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='网站链接表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ic_site_url`
--

INSERT INTO `ic_site_url` (`id`, `site_id`, `type`, `url`, `name`, `success_keyword`, `status`, `is_del`, `ctime`) VALUES
(1, 1, 2, '/index.php?s=/ucenter/member/login.html', 'icoord登录页面', '', 1, 0, 0),
(2, 1, 3, '/index.php?s=/ucenter/config/index.html', 'icoord个人信息修改', '设置成功', 1, 0, 0),
(3, 2, 2, 'https://login.sina.com.cn/sso/login.php?client=ssologin.js(v1.4.15)&_=1478513461378', '新浪博客登录', '"retcode":"0"', 1, 0, 0);

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
(1, '', 'http://192.168.1.249:106', '6df6501f14ec609e1f9748a791215ecb', '', '百度', '5521', 0, 0, 0),
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
