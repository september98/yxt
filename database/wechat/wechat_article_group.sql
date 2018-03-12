-- --------------------------------------------------------

--
-- 表的结构 `yxt_wechat_article_group`
-- 微信图文分组
--

CREATE TABLE IF NOT EXISTS `yxt_wechat_article_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_title` varchar(32) NOT NULL,
  `wechat_media_id` varchar(64) DEFAULT NULL,
  `enable` tinyint(4) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信图文分组' AUTO_INCREMENT=1 ;

