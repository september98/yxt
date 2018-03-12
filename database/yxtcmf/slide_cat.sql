-- --------------------------------------------------------

--
-- 表的结构 `yxt_slide_cat`
--

CREATE TABLE IF NOT EXISTS `yxt_slide_cat` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL COMMENT '幻灯片分类',
  `cat_idname` varchar(255) NOT NULL COMMENT '幻灯片分类标识',
  `cat_remark` text COMMENT '分类备注',
  `cat_status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  PRIMARY KEY (`cid`),
  KEY `cat_idname` (`cat_idname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='幻灯片分类表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `yxt_slide_cat`
--

INSERT INTO `yxt_slide_cat` (`cid`, `cat_name`, `cat_idname`, `cat_remark`, `cat_status`) VALUES
(1, '首页nav幻灯片(1600*430)', 'nav1_', '首页nav幻灯片', 1),
(2, '首页中部幻灯片(1920*250)', 'nav2_', '首页中部幻灯片', 1);

