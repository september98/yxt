-- --------------------------------------------------------

--
-- 表的结构 `yxt_forum_reply`
--

CREATE TABLE IF NOT EXISTS `yxt_forum_reply` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `topicid` int(5) DEFAULT NULL,
  `userid` int(8) DEFAULT NULL,
  `content` longtext,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `yxt_forum_reply`
--

INSERT INTO `yxt_forum_reply` (`id`, `topicid`, `userid`, `content`, `addtime`) VALUES
(1, 3, 2, '<p>http://teach.yxtcmf.com/index.php?g=course&amp;m=course&amp;a=study&amp;id=3</p>', '2016-10-16 22:21:17'),
(2, 1, 2, '<p>开源，分为免费版和域名授权版，这两者的区别请参看官网说明http://www.yxtcmf.com/index.php/portal/list/baojia.shtml</p>', '2016-10-17 17:06:31');

