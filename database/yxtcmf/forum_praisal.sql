-- --------------------------------------------------------

--
-- 表的结构 `yxt_forum_praisal`
--

CREATE TABLE IF NOT EXISTS `yxt_forum_praisal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `replyid` int(11) DEFAULT NULL,
  `topicid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

