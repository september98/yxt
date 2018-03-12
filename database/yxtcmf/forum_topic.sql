-- --------------------------------------------------------

--
-- 表的结构 `yxt_forum_topic`
--

CREATE TABLE IF NOT EXISTS `yxt_forum_topic` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `plateid` int(3) DEFAULT NULL,
  `userid` int(8) DEFAULT NULL,
  `topictltle` varchar(50) DEFAULT NULL,
  `topiccontent` longtext,
  `addtime` datetime DEFAULT NULL,
  `replytime` datetime DEFAULT NULL,
  `hits` int(7) DEFAULT '0',
  `istop` int(2) DEFAULT '0',
  `iscream` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yxt_forum_topic`
--

INSERT INTO `yxt_forum_topic` (`id`, `plateid`, `userid`, `topictltle`, `topiccontent`, `addtime`, `replytime`, `hits`, `istop`, `iscream`) VALUES
(1, 1, 4, '系统是开源的吗，免费使用吗？', '<p>系统是开源的吗，免费使用吗？做的不错，很想用！<br/></p>', '2016-10-16 09:28:46', '2016-11-09 17:26:39', 82, 1, 1),
(3, 1, 4, '如何开通云视频功能', '<p>如何开通云视频功能？</p>', '2016-10-16 09:30:28', '2016-10-16 22:21:17', 45, 1, 1);

