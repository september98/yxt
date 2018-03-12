-- --------------------------------------------------------

--
-- 表的结构 `yxt_cardtype`
-- 点卡类型：课程激活卡，充值点卡
--

CREATE TABLE IF NOT EXISTS `yxt_cardtype` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `typename` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

