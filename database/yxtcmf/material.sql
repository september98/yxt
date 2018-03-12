-- --------------------------------------------------------

--
-- 表的结构 `yxt_material`
--

CREATE TABLE IF NOT EXISTS `yxt_material` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cs_id` int(10) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `url` varchar(600) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `sc_id` int(10) DEFAULT NULL,
  `downname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

