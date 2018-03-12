-- --------------------------------------------------------

--
-- 表的结构 `yxt_exam_shitidone`
-- 做完的试题集
--

CREATE TABLE IF NOT EXISTS `yxt_exam_shitidone` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `userid` int(8) DEFAULT NULL,
  `shitiid` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `yxt_exam_shitidone`
--

INSERT INTO `yxt_exam_shitidone` (`id`, `userid`, `shitiid`) VALUES
(1, 2, '["2","14"]');

