-- --------------------------------------------------------

--
-- 表的结构 `yxt_forum_plate`
--

CREATE TABLE IF NOT EXISTS `yxt_forum_plate` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `pic` varchar(100) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `brief` varchar(200) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yxt_forum_plate`
--

INSERT INTO `yxt_forum_plate` (`id`, `name`, `pic`, `brief`) VALUES
(1, '管理员专区', '/data/upload/20161129/583d2d11d94f3.png', '<p>管理员专区，各网站负责人，管理员可以来这里交流。</p>'),
(2, '教师专区', '/data/upload/20161129/583d2d47420ff.png', '<p>教师在发布课程，课件，考试中遇到的问题，可以来这里交流！</p>'),
(3, '学员专区', '/data/upload/20161129/583d2d3093671.png', '<p>学员交流聚集地，广交天下朋友！</p>');

