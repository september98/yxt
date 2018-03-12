-- --------------------------------------------------------

--
-- 表的结构 `yxt_terms`
--

CREATE TABLE IF NOT EXISTS `yxt_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(200) DEFAULT NULL COMMENT '分类名称',
  `slug` varchar(200) DEFAULT '',
  `taxonomy` varchar(32) DEFAULT NULL COMMENT '分类类型',
  `description` longtext COMMENT '分类描述',
  `parent` bigint(20) unsigned DEFAULT '0' COMMENT '分类父id',
  `count` bigint(20) DEFAULT '0' COMMENT '分类文章数',
  `path` varchar(500) DEFAULT NULL COMMENT '分类层级关系路径',
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_keywords` varchar(500) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `list_tpl` varchar(50) DEFAULT NULL COMMENT '分类列表模板',
  `one_tpl` varchar(50) DEFAULT NULL COMMENT '分类文章页模板',
  `listorder` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1发布，0不发布',
  PRIMARY KEY (`term_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Portal 文章分类表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yxt_terms`
--

INSERT INTO `yxt_terms` (`term_id`, `name`, `slug`, `taxonomy`, `description`, `parent`, `count`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `listorder`, `status`) VALUES
(1, '学习经验', '', '', '学习经验', 0, 0, '0-1', '', '', '', 'list', 'article', 0, 1),
(2, '复习技巧', '', '', '复习技巧', 0, 0, '0-2', '', '', '', 'list', 'article', 0, 1),
(4, '专业分析', '', '', '专业分析', 0, 0, '0-4', '', '', '', 'list', 'article', 0, 1);

