-- --------------------------------------------------------

--
-- 表的结构 `yxt_wechat_media`
-- 微信媒体资源
--

CREATE TABLE IF NOT EXISTS `yxt_wechat_media` (
  `media_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `wechat_media_id` varchar(64) DEFAULT NULL,
  `media_title` varchar(64) DEFAULT NULL,
  `media_desc` varchar(255) DEFAULT NULL,
  `media_url` varchar(255) DEFAULT NULL,
  `local_path` varchar(255) DEFAULT NULL,
  `media_size` int(11) unsigned DEFAULT NULL,
  `media_type` varchar(16) NOT NULL,
  `media_format` varchar(16) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `resource_type` tinyint(1) DEFAULT NULL,
  `expiry` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`media_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='媒体资源' AUTO_INCREMENT=1 ;

