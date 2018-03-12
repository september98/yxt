-- --------------------------------------------------------

--
-- 表的结构 `yxt_term_relationships`
--

CREATE TABLE IF NOT EXISTS `yxt_term_relationships` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'posts表里文章id',
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `listorder` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1发布，0不发布',
  PRIMARY KEY (`tid`),
  KEY `term_taxonomy_id` (`term_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Portal 文章分类对应表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `yxt_term_relationships`
--

INSERT INTO `yxt_term_relationships` (`tid`, `object_id`, `term_id`, `listorder`, `status`) VALUES
(1, 2, 1, 0, 1),
(2, 3, 1, 0, 1),
(3, 4, 1, 0, 1),
(4, 5, 1, 0, 1),
(5, 6, 1, 0, 1),
(6, 7, 1, 0, 1),
(7, 8, 1, 0, 1),
(8, 9, 1, 0, 1),
(9, 10, 2, 0, 1),
(10, 11, 2, 0, 1),
(11, 12, 2, 0, 1),
(12, 13, 2, 0, 1),
(13, 14, 2, 0, 1),
(14, 15, 2, 0, 1),
(15, 16, 2, 0, 1),
(16, 17, 4, 0, 1),
(17, 18, 4, 0, 1),
(18, 19, 4, 0, 1),
(19, 20, 4, 0, 1),
(20, 21, 4, 0, 1),
(21, 22, 4, 0, 1),
(22, 23, 4, 0, 1),
(23, 24, 4, 0, 1);

