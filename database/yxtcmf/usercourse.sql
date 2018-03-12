-- --------------------------------------------------------

--
-- 表的结构 `yxt_usercourse`
-- 用户课程表
--

CREATE TABLE IF NOT EXISTS `yxt_usercourse` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) DEFAULT NULL,
  `course_id` int(8) DEFAULT NULL,
  `teacher_id` int(6) DEFAULT NULL,
  `course_price` int(6) DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  `studied` varchar(1000) DEFAULT NULL,
  `pinglun` text,
  `pingluntime` datetime DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `youxiaoqi` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `yxt_usercourse`
--

INSERT INTO `yxt_usercourse` (`id`, `user_id`, `course_id`, `teacher_id`, `course_price`, `state`, `studied`, `pinglun`, `pingluntime`, `addtime`, `youxiaoqi`) VALUES
(4, 2, 1, 0, 0, 1, '1|2|3|', '', '0000-00-00 00:00:00', '2016-11-27 22:29:03', '0000-00-00 00:00:00'),
(3, 2, 6, 0, 0, 1, '20|', '', '0000-00-00 00:00:00', '2016-11-27 22:28:37', '0000-00-00 00:00:00'),
(5, 2, 2, 2, 9, 1, '', '', '0000-00-00 00:00:00', '2016-11-27 22:40:04', '0000-00-00 00:00:00');

