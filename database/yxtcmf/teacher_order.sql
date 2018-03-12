-- --------------------------------------------------------

--
-- 表的结构 `yxt_teacher_order`
--

CREATE TABLE IF NOT EXISTS `yxt_teacher_order` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `u_id` int(4) DEFAULT NULL,
  `c_id` int(4) DEFAULT NULL,
  `money` float DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `yxt_teacher_order`
--

INSERT INTO `yxt_teacher_order` (`id`, `u_id`, `c_id`, `money`, `addtime`) VALUES
(1, 2, 3, 0.5, '2016-11-27 21:39:57'),
(2, 2, 2, 4.5, '2016-11-27 22:40:04');

