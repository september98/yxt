-- --------------------------------------------------------

--
-- 表的结构 `yxt_user_favorites`
--

CREATE TABLE IF NOT EXISTS `yxt_user_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL COMMENT '用户 id',
  `title` varchar(255) DEFAULT NULL COMMENT '收藏内容的标题',
  `url` varchar(255) DEFAULT NULL COMMENT '收藏内容的原文地址，不带域名',
  `description` varchar(500) DEFAULT NULL COMMENT '收藏内容的描述',
  `table` varchar(50) DEFAULT NULL COMMENT '收藏实体以前所在表，不带前缀',
  `object_id` int(11) DEFAULT NULL COMMENT '收藏内容原来的主键id',
  `createtime` int(11) DEFAULT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户收藏表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yxt_user_favorites`
--

INSERT INTO `yxt_user_favorites` (`id`, `uid`, `title`, `url`, `description`, `table`, `object_id`, `createtime`) VALUES
(4, 2, '', '', '', '', 3, 0),
(3, 2, '', '', '', '', 1, 0);


