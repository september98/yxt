-- --------------------------------------------------------

--
-- 表的结构 `yxt_wechat_album`
-- 微信相册
--

CREATE TABLE IF NOT EXISTS `yxt_wechat_album` (
  `album_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `album_name` varchar(255) NOT NULL,
  `image_width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `image_height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `album_desc` varchar(255) NOT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图片资源分组' AUTO_INCREMENT=1 ;

