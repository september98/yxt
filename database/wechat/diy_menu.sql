-- --------------------------------------------------------

--
-- 表的结构 `yxt_diy_menu`
-- 自定义菜单
--

CREATE TABLE IF NOT EXISTS `yxt_diy_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `title` varchar(16) NOT NULL,
  `keyword` varchar(128) NOT NULL,
  `is_show` tinyint(1) NOT NULL,
  `sort` tinyint(3) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `menu_type` varchar(30) NOT NULL DEFAULT 'click',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='自定义菜单' AUTO_INCREMENT=1 ;

