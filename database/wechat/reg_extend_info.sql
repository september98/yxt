-- --------------------------------------------------------

--
-- 表的结构 `yxt_reg_extend_info`
-- 用户附加信息字段与值
-- 
--

CREATE TABLE IF NOT EXISTS `yxt_reg_extend_info` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `reg_field_id` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

