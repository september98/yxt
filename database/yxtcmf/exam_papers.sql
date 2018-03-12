-- --------------------------------------------------------

--
-- 表的结构 `yxt_exam_papers`
-- 试卷
--

CREATE TABLE IF NOT EXISTS `yxt_exam_papers` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `cs_id` int(6) DEFAULT NULL,
  `teacherid` int(2) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `limitedTime` int(4) DEFAULT '0',
  `single_choice_id` longtext,
  `single_choice_score` int(3) DEFAULT NULL,
  `fill_id` longtext,
  `fill_score` int(3) DEFAULT NULL,
  `determine_id` longtext,
  `determine_score` int(3) DEFAULT NULL,
  `essay_id` longtext,
  `essay_score` int(3) DEFAULT NULL,
  `material_id` longtext,
  `material_score` int(3) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `yxt_exam_papers`
--

INSERT INTO `yxt_exam_papers` (`id`, `cs_id`, `teacherid`, `title`, `limitedTime`, `single_choice_id`, `single_choice_score`, `fill_id`, `fill_score`, `determine_id`, `determine_score`, `essay_id`, `essay_score`, `material_id`, `material_score`, `addtime`, `state`) VALUES
(2, 1, 2, '管理员使用教程', 15, '1,2,3', 5, '4,5,6', 5, '7,8,9', 5, '10,11,12', 5, '', 0, '2016-11-09 21:42:46', 0);

