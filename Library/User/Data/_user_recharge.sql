# Host: 192.168.1.40  (Version: 5.6.24-log)
# Date: 2016-09-22 11:51:59
# Generator: MySQL-Front 5.3  (Build 4.214)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "cff_user_recharge"
#

CREATE TABLE `ic_user_recharge` (
  `recharge_id` int(11) NOT NULL AUTO_INCREMENT,
  `recharge_sn` varchar(18) NOT NULL DEFAULT '' COMMENT '订单编号',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态（0：未付款；1：付款中；2：已付款）',
  `pay_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '支付方式（2：微信；3：支付宝；）',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `ctime` int(11) NOT NULL DEFAULT '0' COMMENT '充值时间',
  `utime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`recharge_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='充值表';
