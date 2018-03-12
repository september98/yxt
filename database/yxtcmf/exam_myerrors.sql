-- --------------------------------------------------------

--
-- 表的结构 `yxt_exam_myerrors`
-- 我的错题集
--

CREATE TABLE IF NOT EXISTS `yxt_exam_myerrors` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `uid` int(8) DEFAULT NULL,
  `shitiid` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

