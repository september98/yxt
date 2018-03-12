-- --------------------------------------------------------

--
-- 表的结构 `yxt_tixian`
-- 提现
--

CREATE TABLE IF NOT EXISTS `yxt_tixian` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `u_id` int(4) DEFAULT NULL,
  `money` int(6) DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `turename` varchar(10) DEFAULT NULL,
  `count` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

