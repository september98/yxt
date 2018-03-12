-- --------------------------------------------------------

--
-- 表的结构 `yxt_label`
-- 标签
--

CREATE TABLE IF NOT EXISTS `yxt_label` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `c_id` int(2) DEFAULT NULL,
  `labelname` varchar(50) DEFAULT NULL,
  `listorder` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

