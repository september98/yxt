-- --------------------------------------------------------

--
-- 表的结构 `yxt_chatmsg`
--

CREATE TABLE IF NOT EXISTS `yxt_chatmsg` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  `time` int(15) DEFAULT NULL,
  `sender` varchar(20) DEFAULT NULL,
  `pic` varchar(225) DEFAULT NULL,
  `timee` datetime DEFAULT NULL,
  `cs_id` int(6) DEFAULT NULL,
  `channel_id` varchar(40) DEFAULT NULL,
  `uid` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

