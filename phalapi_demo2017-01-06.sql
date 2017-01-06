-- phpMyAdmin SQL Dump
-- version 4.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 01 月 06 日 09:19
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
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `path_name` varchar(100) NOT NULL COMMENT '目录名',
  `type_id` int(11) NOT NULL COMMENT '类型ID',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态（1.正常，2.禁用）',
  `is_show` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否在官网显示（0，不显示 1，显示）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `ic_article`
--

INSERT INTO `ic_article` (`id`, `title`, `path_name`, `type_id`, `ctime`, `status`, `is_show`) VALUES
(7, '李克强：下一步要坚决整治“红顶中介”', '121638', 1, 1483691389, 1, 0),
(8, '女星颜值速报杨幂的发际线怎么了?', '131532', 1, 1483691408, 1, 0),
(9, '难道你不觉得99%的相亲真人秀都是下三滥', '146857', 1, 1483691895, 1, 0),
(10, '看看别人用你撸的时间学会了什么?', '152463', 1, 1483692101, 1, 0),
(11, '这南墙我是撞了 自己的感情我得自己收拾', '165160', 1, 1483692177, 1, 0),
(12, '刚会说话的小女孩学会了一个新单词，说个没完，哥哥拦都拦不住!', '178751', 1, 1483692242, 1, 0),
(13, '漂亮又能干的老婆+20万级最可靠的SUV，人生圆满!', '180315', 1, 1483692513, 1, 0),
(14, '当12星座这样做，就说明在向你发送爱的电波呢!', '193285', 1, 1483693614, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ic_article_cat_links`
--

CREATE TABLE IF NOT EXISTS `ic_article_cat_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `type_id` int(4) NOT NULL COMMENT '所属文章类型',
  `url_type` varchar(50) NOT NULL COMMENT '链接类型，链接属于哪个网站（wx:微信，lookmw：www.lookmw.cn',
  `cj_times` int(11) NOT NULL DEFAULT '0' COMMENT '采集次数',
  `note` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='微信分类目录链接，' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ic_article_cat_links`
--

INSERT INTO `ic_article_cat_links` (`id`, `url`, `type_id`, `url_type`, `cj_times`, `note`) VALUES
(1, 'http://weixin.sogou.com/pcindex/pc/pc_0/1.html', 1, 'wx', 1, NULL),
(2, 'http://weixin.sogou.com/pcindex/pc/pc_0/2.html', 1, 'wx', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ic_article_temp`
--

CREATE TABLE IF NOT EXISTS `ic_article_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL COMMENT '文章标题',
  `path_name` varchar(100) DEFAULT NULL COMMENT '文件目录',
  `original_url` varchar(250) DEFAULT NULL,
  `type_id` int(11) NOT NULL COMMENT '文章类型',
  `url_type` varchar(50) NOT NULL COMMENT '链接类型，链接属于哪个网站（wx:微信，lookmw：www.lookmw.cn',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态(0.未采集1.已采集并显示，2已采集不显示，3采集失败)',
  `is_show` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否在官网显示（1.是，2.否）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `file_name` (`path_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- 转存表中的数据 `ic_article_temp`
--

INSERT INTO `ic_article_temp` (`id`, `title`, `path_name`, `original_url`, `type_id`, `url_type`, `ctime`, `status`, `is_show`) VALUES
(1, '污丫讲段子：戴眼镜的女教师2', '12703', 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=BX7fCkXKcdRlBkAOenphiVGBV9onm97hqSp7tBu4Tp6mjEEN5BgublzC5*J5ESzc7AUl4YHYF-DWje6YRybL6G7mXy8GXTsFm20Xf60Ch*p1pPQyPBPXLlJAbNWl2OWwyA4PveaK*sYYMnsT9mS7GpI2Oesn5LUGs-nW43Wrslo=', 1, 'wx', 1483687101, 1, 2),
(3, '一场夺取一万多人性命的雾霾，几乎让最高领导人下台……', '39128', 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=mypQC7UreLruuFFXtF43Gc0yrW4sL-AEZzCaAJwFReK9rZO9ElMvqiiaNW7vKl8ealwAap0oLy1boD7U0nG41WkYkMlvx0omDnDTCL0EOn1OeoCDFGDEK4M5ReA019oxJ5HXEs3KUkWqK-yM8VJhLydZtK8v9PO9cA7MLWx*Yyk=', 1, 'wx', 1483687101, 1, 2),
(4, '姑娘爱吃醋，谁也挡不住', '48759', 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=JwgAstBPYRu3m*ZE3FOHL-0AFB0R5ZdXIRmbAoqXZNuTFclxr*LDqqQgCm1aKwxluoM9rkQristcpZ7qHAQNIxMf6Kxor*b7x3CrJeW4Ez5g1eq094YEkthxt-NLoodRHSVXZrDYcB0dr0gzAzAhya-kPbpjiHqsCBie3QNwtR4=', 1, 'wx', 1483687101, 1, 2),
(5, 'YSL唇釉美翻天!各种鸡年限定竟然很值得买!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=33Q3ssILIRa8WYBEWeD17KtfxTB0NJSHRJgMoX6lAD0LOv5PB4YnyvqrCfbHKB0a6OCbCGr7ohyirLsz8PqJNNemPaMzLIsn4MLqQ*gbGDfkH8Iw6IunK9TScP8O7s-DyRnL42WA9Fk-Z3EJ9Wb4L7wbjlN7GN7kzw67aONlspY=', 1, 'wx', 1483687101, 1, 2),
(6, '不开玩笑!这款新来的SUV卖5万的价格至少有10万的水准!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=2Ui56lfdJ7txnkcz0Y0tXtfKXX8Dnh2Thra4pQ*iyV*EV7jtcbCmEW0N3pE9fWZNbGh4UhQyNlQuppD*r3KSVTGJ5NSC*ZctDN9qtWLZBIBiHLXCgDBV*dAirBmbISxlXE-DDdCcf5K38KK-DRx-JX6UuaCNcWc4KFeiqv-*xA8=', 1, 'wx', 1483687101, 1, 2),
(7, '魏晨能在娱乐圈零绯闻整整10年，是谁让他一秒破功?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=YuOqZNUFvBs9FCcEOd9SU1YNgJNgyb3QuFLlqAK9ojMQew7Rg8ut6fPwDVc28Cppj8emrY*7LYN0j4JZWdLoBO5hzhLsbxhKWbhOCzRAaIjAy8JpAck5pzZyUvij-8zHGJ936otHq873YhG3n7Dpw7DAKc0X9DrREJHQopPhcKo=', 1, 'wx', 1483687101, 1, 2),
(8, '不说不知道，很多香港导演靠抄它起家', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=F*O6*KQt0HPzYXXlEcidxKesHfNVqEEOkDRF*fq0oYL5*JjyC1vTIocXM7n79E2tGDc2D8J7kgUnXSbDLQ0K3PKhIgzpS6GPHBNo*hlBtH80ICM-ICzIjdhAdjCydE*cCsAiCDvDK91sJhek1VP-y6h4fuGR0COlnZIcKfKuMeU=', 1, 'wx', 1483687101, 1, 2),
(9, '被这部上司和后背都暗恋我的神剧笑出腹肌，小花们快向大叔学演技', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=GLV2hqhfra-4g*5fSdbNXXcLgmOuY*SaBlDIsb46dgNgOS5PiLaMGcYB8Tl6LNjwaYmF0pGQo9lrklPQxzcPSud0W7ORUrCmNsATRfzMZan6wuHwIyA8qTklgOOBr12Pk6SDuUTa7RORIYV-rkkCcyIjJeexge9WHDPSUJEHbZU=', 1, 'wx', 1483687101, 1, 2),
(10, '感谢三石哥!这下可以过个肥年了', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=g8uD36iJdYYnkHRPcUbiDQNjuzsWgaIX3VUCofNGe5Hjr8mQfDAZAPNvO9KuuwmdH2AUQPjNuvMEBY9p4HZ45j4Z2JYs4-UygsVgEMXAjpC66au8rJaWuzmlhnDDeYmEvrTJlhIYtuWwKfK9zKzOOEv5L3AiJTdhZl1*FLunAyo=', 1, 'wx', 1483687101, 1, 2),
(11, '安倍悠闲度假，中国强势下棋，这三大信号将令小日本痛不欲生!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=fGZ6v*TjN*QPSW1Ububs4nDeQjwgaBINGk87BhtYQ1Ew1Yva6r5uoiVVJo8gh2R3ZdvouzYj9E6TujGp4SsPxfB-VqFdKKV5Y9VcpYSgC3XEEWB-UDyY3AFOaL9WcdjdpXeuSjzy-kW1xrUsFotNVru3WXM6F7C21iykksVdV0c=', 1, 'wx', 1483687101, 1, 2),
(20, '老公破产负债11亿，代言的品牌遭下架封杀，徐若瑄的人生真是艰辛惹', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686786&ver=1&signature=w33Z*Bmk2JD0*ESOcS**kKamefqHrg0NLzDqMAUoAJLBLQubQyA89VkhRELd6cvbknNIWQSM0qkJb4xIzklubcHgB3ne8kY4NDJ2v1EKsT22ZeHeaMOqsY2lFUCmCpg6jz0uMfYtGzy-NAc8yFztJV1j9Gp54x13fmeO9Ej--zc=', 1, 'wx', 1483687101, 0, 2),
(21, '15万左右最火的合资SUV出新款了，究竟有啥变化?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=8ymboW2EShgCmFhOPbhjW8OKf81t*bz70D3tWEkhXo32aIj4eKNDXlk39OheqOFK4x5Pd8nkqvQEH73RUqvaS2zuZZu1NKlG4ExiVz*Vs7g8tNLS06TTfHm9RYy6W1C9eWBrXTEe5WSyU-EYtLDXjKPBNdUhJAQqo5MDK-10OmY=', 1, 'wx', 1483687103, 0, 2),
(22, '低调奢华有内涵的男人喜欢这些车 你是吗?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=765x7Yplx91jMNhaGdIFncIr057GsJk523R9QIOPYi5lO2DmCgZW-cpd4-4jJUvfURgdNaC*v6MrVs2VOJFUf*xMrbT5Yi4tpANuK9UCL-limQKNtlEgVeOrBfI-44nDLGaC72bWDFSGl-HpROYwN2e0HAKwMLaiOiOXaf-umCk=', 1, 'wx', 1483687103, 0, 2),
(23, '很重要!多部门晒2017"小目标"!与养老、买房息息相关..', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=dq5uRAZtApH*LTNGtCNzLjhdhhya5IkuBokD8JmkzPQG9iyqHjuvlTMoQ54rDOlXtOSh4y*9BkFtB0Y*dOThsr1bFFbZIR5g-ImGdklwio1mqGvAv1i01yvxrUFfx2kPlVuiDCjea9gnuRhaEy-Q4Q2XyCQrJoF*UPa7s5AWrHg=', 1, 'wx', 1483687103, 0, 2),
(24, '大屠杀!人民币空头遭血洗，市场发生了一个可怕的变化!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=4kJn7hp1CiVd5SpfK23zOrOHGtsDmQvW4LGFficBbvK4p-2dDdAznJ6M66YhXdL22y5DqwQMl6KR8MpCcJopWALLPdRSrWyo*HxnirUvyeWt2i-ZmgIDt*imVic-OiuKM*zOYJVElXc9EzP*CAOHa0ZyssETu2wzD9uNt2XL3jE=', 1, 'wx', 1483687103, 0, 2),
(25, '上了年纪，这些重要的身体部位，要这么保养才好', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=Vi99sXXJHwbltRCHo5EiNjwtqU-AjaJOfm2Ie0c6jnGXMzf2HoLDXn2p58G09Gxl8P1*rpgjMZEl5Ax-b88MQAQI5Qt-YXAtHrRzVizRY*9fPwd1IAIdYxA1PzGyACxaMU3Fdq1yyywxAGdIjEUYaN8bTegCRH0Lm2d*r6WA8h4=', 1, 'wx', 1483687103, 0, 2),
(26, '[解局]这代人，注定与雾霾相伴?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=M4bwOhj5Ydpa3o64knPQyWfQVMuAisJTAYGvokshUw7xkQ5olvRi1ZZe7Nofe1NPpRV-MCBkGolRgFEmUfzPcwKFgL7U1LXRBHUoGhHRgu196k6F3hUWbd3d7D0p*JD-2-DE-yCgPvwtmQba7Y5R50d6EiDtk3B2PbQ9Ky-nusQ=', 1, 'wx', 1483687103, 0, 2),
(27, '小昕爆料 高等级玩家宝图收益提升!灵墟迎来新boss层!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=IsiUNVHvsnCKRa-lEEw9vyG*4EicDtYLgyF3qIYVBnTEPFTyt55eOX0eoaNx1vci9iHJrPjTBqLKq-lzVhiZHeAg0UHywMCGHJl8zLFOTLfolwUZwWf5COm3Ubx8GHQ2*wER6TKca23b1gsU-NYkmG9aqjCeRw5p8lslRnqf2JI=', 1, 'wx', 1483687103, 0, 2),
(28, '斩男“人鱼妆”的秘密你知道吗?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=BJDhcFtT9EjdNdaAWpPi45Wb5N87cTEObxa7GAbWTxmmJF*wW33vXVUIXV9tOBypmGpr3P65xOvb2SFx51ViMogvn-Ep1b4GX5RiIgcDESg-oyFyJvNrZEgG6p00keBPtFktnJzpYz7DO*RNac5JMQWNxoLTpwn0GGRrHbs4S48=', 1, 'wx', 1483687103, 0, 2),
(29, '肾不虚的男人必看，20多万最适合撩妹的车都在这!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=wuHKelj7G-MRUpQ4Rhwh56okkwzlUydmmjXyVPLWfre60zcH7Bv5xBBKkhgwRRN47KnW-CgiA1JtbjCNsIZwl6XpXWkcHBzYIF8jl3TgzdQd7cqcpK2uIYR86KSk284N2p*NazYG7avroMQMBb9OTh5Ojn1OD73xdHP3AfkPCh8=', 1, 'wx', 1483687103, 0, 2),
(30, '今日聚焦：天哪!不敢相信!中国竟成了枪支泛滥的国家!原因竟然是……', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=30V*U5yQ1*szGR0n6lueREvDoEy3bQ-fxrYnlpUKDTBsPgh8aOix-pSJbO9G4pfsRp3q5HiIrRrUxOcEg5suz2X7ryHDcptLEIshttzHZzXq*gmQGt31aLaw0vCGlcOTgC-oJmQRMPOlyswPqTVgTRk2ZmO9LaTi2B6i6OteE2k=', 1, 'wx', 1483687103, 0, 2),
(31, '宝宝总生病?因为你没做好这件小事', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=qV4hzwkugwSXElWJXKWbmmAim3ET9PwNDscrOMzFGSEnj3-ynHwMwNgR2VC1YzkAfw9ji6QjA*xtqVt9PclIl9kM7t3HFZUH-JM7Y6iRtC1UL-jmKavO6ah*9F3xsp1Vont9-2HUuKE7wgd4ka2kiku6IKoJSewvFEVnaKCkqME=', 1, 'wx', 1483687103, 0, 2),
(32, '2017年，和正确的人在一起', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=d51JeFiTEpq4CtGBZLBX-cUNWIFa04rsV-E4lHYcsQ3cuB7DI1Yn**DfykHYmw1QI2uxDRz6443oLVjlrpDMDoXhMzaWcpMdKIS9wyDgQamF1ueocYwhMogwJXahHXBtyjqE6ECumZRfuo10R*VBNT9Nrf02yEbjg3OZf-D9L50=', 1, 'wx', 1483687103, 0, 2),
(33, '头条 外媒：日本驻台机构改名引中方不满', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=nFHo91cVFOMQkUlT6gyJvI22hwbAjSLR--CuAIG5JMBoFYNai0KuKOj5SsPmXl84qd8dYalyFJUhy1JJQ85zm1Ar2isAo--9eOhggKpcKHSX*gmMXpsrGlC7fe4hdkjl9WLcSKlMPcfu*62G7B3EnIuNSdPXtdNBSG-zhEAURVY=', 1, 'wx', 1483687103, 0, 2),
(34, '给力!农民朋友注意了!这些增收红包请查收!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=dq5uRAZtApH*LTNGtCNzLjhdhhya5IkuBokD8JmkzPTHyT41fxIQkR02lz0h7Rr32gN5eLtBBxHB3xT5K3qVXhoC62jgYJ744EbVNeQ5*FAXoTgZnD8Tur-ycjXHMWRmf*6922ifm0o0pjoVarr6BAmcGDOnMFAkNipxjkPJGSY=', 1, 'wx', 1483687103, 0, 2),
(35, '啥，林更新微博被薛之谦盗号了?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=8121GEQzyGnJh689VdQSpz-qbsIIyCfJcmIWX6bEhShOPGJsF3AHxEDKAuJ49S3qGKbHTVzgA9BIzE-NcQbglX3SbPkxXOrWJdkiOdQWjg5zDR7EdoyVXGjz-temIP4RSSAxcpI1aTpPCGYq3wODFQGQmt*sHoX61saknoRlOUM=', 1, 'wx', 1483687103, 0, 2),
(36, '图说 杨洋身段软到逆天!剪了新刘海的秦岚像个男的?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=ib*JHxSxC7FbbuetvJRRFxC9FgcluZcvAKNCbduVCPM9QU36nlat0L12dkEH3Il2nokD5wfuIBmqQrZqqKcO-SlBRgxSL1hx98ex3gOYwNF0sx7jODTxk4rzJikmjq7y-H8ca4dE9FHYdeSVTFUJ2QLQLc44ekyTFG1lhcInHCk=', 1, 'wx', 1483687103, 0, 2),
(37, '十二星女都是哪种男生的迷妹?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=FNA7solBCtw8AtJwbeWAxOsrkC6dSTa*sHCMdOCYNBj-lixyZFFj9KlCu*xvq*Psn1UOACVGOnKPyud5cGIZ6PSun*IbkamWnT1W2sKx8oRHhE2zc9JaV-U7FGsawDjqHxNT0YfThElTGqMq-153j2jMQZGYTvM5JfdOiDqWMtI=', 1, 'wx', 1483687103, 0, 2),
(38, '被玩坏了：这个小品一不小心就上了春晚!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=ijW80pkMTCh5DhLICncSXRrfOX12m6egy9qyQQ4XJFQHUutRd*i-0ZaCMB3u87mhKrmgd8pzKObW9bYaxLdUKtXKCb7r0Vl3OVqEHT0l92z6k6BYnZ1idamQ7dV9co17P7rq-1pVSyK37MZujqxzvC6-a0jmxe4tK*KymwbbOvw=', 1, 'wx', 1483687103, 0, 2),
(39, '10万买个超值的家轿，这3款当首选!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=aA5NIHV0mAUDu6tl84GqmYFcwJv7F45pxDjEUCgjsTxpsnCgEjE4qk7P0bS6PhpLsiMhzstpa77kuNlixz-TCge5*Rf7mlzOYIo3jtlFa4-E8*Dsl6GSpmVWYqDKJGLMKt5Q8ZRllXICCqYg-Clr2m6--dlfI1gwiysGSL-qF2k=', 1, 'wx', 1483687103, 0, 2),
(40, '非娱乐圈情侣分手却轻松上热搜，贵圈混乱的感情关系网又更新了', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483686785&ver=1&signature=GLV2hqhfra-4g*5fSdbNXXcLgmOuY*SaBlDIsb46dgNgOS5PiLaMGcYB8Tl6LNjwGd76qLkrvLo5fPBLfbVpVeyNvLDJy5jj9CRcbDKNdnZpIds59Dl7fmQ23*zG0Wlj82jqN09V5KTLEVclLTchUs878N2kYn5stz-xOQHrsco=', 1, 'wx', 1483687103, 0, 2),
(41, '恭迎释迦牟尼佛成道日', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483692185&ver=1&signature=edJaJzlcFjnahxXTW4XH6Ekx1zqrdoyiO5DN04R0HpGNbirWgZ2sltVbNeYdjq8Wa4sicaMQqGe7mCIPEz1SPGh9-4Z4GQkA468eB-MgrduO9hCKXGINk*GU5Argvv-MvPZ21WIcVn6XEl*o8Ipk-V7E0uQ5f4vpntRcWn5oK2M=', 1, 'wx', 1483693071, 0, 2),
(42, '独立很累，不独立更累', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483692185&ver=1&signature=qLQZwJ-KBt27ZsQtAQSooBQFBk1MEIqZNYNcZLR6d*bFFx8LdVto*71KZAp1XDvWHHNvapkEFVLrgreIBGfmdSwuyTGBKwbmhFOdJ7LF7VJErgXnl2DL5a3Pd1bEKZ1k3e0xNNXm7mwyK5PXciaETDlcn9vKZiiMXRvAXBx*WKo=', 1, 'wx', 1483693071, 0, 2),
(43, '五种费钱且油耗上升的开法，快看自己是否中枪!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483692185&ver=1&signature=K8tuG5VTr-yuJos9*TKTWvNWW5MJKudxkakBhxbN4yoG1mYKnyYWRhzNSB7iQ-lpBa4MQNRYrEYspTf0R7qSxHcV8*jYjmtKNsttPL2GK1w3ij5saExjGxDnMQH7qIqqHfT3HhuNt2dqrPlY6n7iErQv8nCYygFX*q0bY-mK0g8=', 1, 'wx', 1483693071, 0, 2),
(44, '三星新旗舰S8产能曝光 太恐怖!还有手写笔?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483692185&ver=1&signature=RbnX4tUBODpql9qsvp4jJRDrtHc-LSXXm9gSM*BNY*NXNVJPYdDvd7lXqL0c2OQNZH7KKNcYxtsibFQgLfgbAW2ZguAbc5kH4vSPaSYrONlgMzg*j*Y1hf*MR-A2O6nmL8h3i8wK5gbjF5RmUQoXS1o-tWraCuGjqinicEhZ9fI=', 1, 'wx', 1483693071, 0, 2),
(45, '槽多无口 ▏表妹相亲后说她不能控制寄几了', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483692185&ver=1&signature=VaXsZyFGFFZ5bNrcUwB2-qWnxY5fFgga6Jxppl53rO2vBaFqa4DNFcy3N2hBRYCKlCwIPogqvnls6invUpFjUKZZIuAfdAxhxFQnSqNlxofsIj63hjNWYhjJ9TNxb09ZmBqho9sizJcqEWWhu4DxzY6G0g1AHhPUj3HmlhIrQu4=', 1, 'wx', 1483693071, 0, 2),
(46, '新年首发：2017这个女人一下唱火了!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483692185&ver=1&signature=ijW80pkMTCh5DhLICncSXRrfOX12m6egy9qyQQ4XJFQHUutRd*i-0ZaCMB3u87mhj1zUuPQsXdyP-ZXcd4tXraSZPr5U0i*O-iQo7vP4UbZtjC-gVrnS36VudoTNlMB2NsTiCTjC9GoOHGAGqsZ*hhMWSF4veqbzJ5ZPRMLXo9Y=', 1, 'wx', 1483693071, 0, 2),
(47, '今天到保质期的产品，明天就一定不能用吗?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483692185&ver=1&signature=d11v3RzpGrZ4ohLY5t0P3KlaCI24disXNuBsIA0ME57LcCIlvqhNuuo9xZV*YbsL3vhHnb7Shr3o98l*dWNzB9knQ6S4XDHeO3h-RneA7UFQxjJMtMKLrf*7y7XsEeb8KN5C6pG6SAUcA3DgkwBTJhSkQHGyaed0RsGYGCyfNxY=', 1, 'wx', 1483693071, 0, 2),
(48, '终于有人说出了“雾霾的真相”!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483692185&ver=1&signature=Ib0sEXY5tLR0vhWGIIIcohaWabtFFfg8tvSvn73010DbqR5btMDbpwlEYSskB*vB2*QqdGML-jqJqv84ryvowHC5xjrRfSN8jI1l1ybDHYD4V7whYGtlV1rK11zKIw1TarJxAdVhpt2skDXui8ytpLbvHapVDcoP0M-YmAsteyo=', 1, 'wx', 1483693071, 0, 2),
(49, '十字路口，男子倒在轿车旁!死亡原因，跟这事有关?发生在大庆!', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483692185&ver=1&signature=-AD*8YPfuJQMiXK2EG2-DrOPyRbFCRMU2*fyj2w9-kROYg2qalb9urmeMh2ApxuLi8kGPx5bwspFmjkkHKvpUgCg9Us5YoU0xJmMMHhPWTGZ4RpQGG14QR*F5eUW0cvfIzS97n-OwvGl4sA*2*TpZj34kMDyuSwZCUaTjwxNZus=', 1, 'wx', 1483693071, 0, 2),
(50, '[荐读]你住几层楼?', NULL, 'http://mp.weixin.qq.com/s?src=3&timestamp=1483692185&ver=1&signature=HLumD31p7Ox5k-9UJUYn4X4j-aO3JXNNu7ATNqIRAVOA-Mf-U7SeYqYEd0oALdY3i-c5Oyn8jCYrbVo-vXdG12cKAx-BJ48paCJcnxHdRuFH7xul6bQGY4iQQVFM36DqtdTXrW-qtIzEl4FM7cWV0QEpZ*oGmyqwPSmTCYnmIyg=', 1, 'wx', 1483693071, 0, 2);

-- --------------------------------------------------------

--
-- 表的结构 `ic_article_type`
--

CREATE TABLE IF NOT EXISTS `ic_article_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL COMMENT '类型名',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用，2.未审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `ic_article_type`
--

INSERT INTO `ic_article_type` (`id`, `pid`, `type`, `status`) VALUES
(1, 20, '热门文章', 1),
(2, 20, '官方推荐', 1),
(3, 20, '经典段子', 1),
(4, 20, '健康养生', 1),
(5, 20, '生活哲理', 1),
(6, 20, '明星八卦', 1),
(7, 20, '时尚生活', 1),
(8, 20, '财经', 1),
(9, 20, '汽车', 1),
(10, 20, '科技', 1),
(11, 20, '时尚潮流', 1),
(12, 20, '家庭教育', 1),
(13, 20, '旅行', 1),
(14, 20, '职场', 1),
(15, 20, '美食', 1),
(16, 20, '历史古今', 1),
(17, 20, '学霸', 1),
(18, 20, '星坐', 1),
(19, 20, '体育', 1),
(20, 0, '微信精选', 1),
(21, 0, '原创美文', 1);

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
  `user_group_id` int(11) NOT NULL COMMENT '用户组',
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

INSERT INTO `ic_users` (`user_id`, `user_group_id`, `mobile_phone`, `domain`, `key`, `pay_password`, `nickname`, `salt`, `status`, `ctime`, `utime`) VALUES
(1, 0, '', 'http://192.168.1.249:106', '6df6501f14ec609e1f9748a791215ecb', '', '百度', '5521', 0, 0, 0),
(2, 0, '', 'www.google.com', '3e58107cd690292f6ab9f1fba2002b2c', '', '谷歌', '8784', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ic_user_group`
--

CREATE TABLE IF NOT EXISTS `ic_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) NOT NULL COMMENT '分组名',
  `permission_ids` varchar(250) NOT NULL COMMENT '权限ID如（1，2，3）以分号分开',
  `note` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
-- 表的结构 `ic_user_permission`
--

CREATE TABLE IF NOT EXISTS `ic_user_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api` int(11) NOT NULL COMMENT '接口名（如：site.get_contents_post）',
  `api_name` varchar(200) NOT NULL COMMENT '接口名称',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='功能权限表' AUTO_INCREMENT=1 ;

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
