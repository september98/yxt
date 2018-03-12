-- --------------------------------------------------------

--
-- 表的结构 `yxt_nav_cat`
--

CREATE TABLE IF NOT EXISTS `yxt_nav_cat` (
  `navcid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '导航分类名',
  `active` int(1) NOT NULL DEFAULT '1' COMMENT '是否为主菜单，1是，0不是',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`navcid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='前台导航分类表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `yxt_nav_cat`
--

INSERT INTO `yxt_nav_cat` (`navcid`, `name`, `active`, `remark`) VALUES
(1, '主导航', 1, '主导航'),
(2, '底部导航', 0, '底部导航');

