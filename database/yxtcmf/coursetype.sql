-- --------------------------------------------------------

--
-- 表的结构 `yxt_coursetype`
-- 课程分类
--

CREATE TABLE IF NOT EXISTS `yxt_coursetype` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(200) DEFAULT NULL COMMENT '分类名称',
  `slug` varchar(200) DEFAULT '',
  `description` longtext COMMENT '分类描述',
  `parent` bigint(20) unsigned DEFAULT '0' COMMENT '分类父id',
  `count` bigint(20) DEFAULT '0' COMMENT '分类文章数',
  `path` varchar(500) DEFAULT NULL COMMENT '分类层级关系路径',
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_keywords` varchar(500) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `listorder` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1发布，0不发布',
  PRIMARY KEY (`term_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yxt_coursetype`
--

INSERT INTO `yxt_coursetype` (`term_id`, `name`, `slug`, `description`, `parent`, `count`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `listorder`, `status`) VALUES
(1, '使用帮助', '', '', 0, 0, '0-1', '', '', '', 0, 1),
(2, '我是管理员', '', '', 1, 0, '0-1-2', '', '', '', 0, 1),
(3, '我是教师', '', '', 1, 0, '0-1-3', '', '', '', 0, 1),
(4, '我是学生', '', '', 1, 0, '0-1-4', '', '', '', 0, 1);

