-- --------------------------------------------------------

--
-- 表的结构 `yxt_wechat_article`
-- 微信图文
--

CREATE TABLE IF NOT EXISTS `yxt_wechat_article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `article_index` tinyint(4) NOT NULL DEFAULT '0',
  `article_title` varchar(32) DEFAULT NULL,
  `thumb_media_id` varchar(64) DEFAULT NULL,
  `author` varchar(25) DEFAULT NULL,
  `digest` varchar(255) DEFAULT NULL,
  `content` text,
  `content_source_url` varchar(64) DEFAULT NULL,
  `show_cover_pic` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信图文' AUTO_INCREMENT=1 ;

