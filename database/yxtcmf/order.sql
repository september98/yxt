-- --------------------------------------------------------

--
-- 表的结构 `yxt_order`
-- 订单
--

CREATE TABLE IF NOT EXISTS `yxt_order` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) DEFAULT NULL,
  `course_id` int(8) DEFAULT NULL,
  `order` varchar(20) DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `total` int(5) DEFAULT NULL,
  `alipayorder` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

