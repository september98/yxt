-- --------------------------------------------------------

--
-- 表的结构 `yxt_exam_userpapers`
-- 用户试卷
--

CREATE TABLE IF NOT EXISTS `yxt_exam_userpapers` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `userid` int(8) DEFAULT NULL,
  `teacherid` int(6) DEFAULT NULL,
  `papersid` int(8) DEFAULT NULL,
  `choice` longtext,
  `fill` longtext,
  `determine` longtext,
  `essay` longtext,
  `material` longtext,
  `choicescore` int(3) DEFAULT '0',
  `fillscore` longtext,
  `determinescore` int(3) DEFAULT '0',
  `essayscore` longtext,
  `materialscore` longtext,
  `score` int(3) DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `readover` int(2) DEFAULT '0',
  `chacktime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

