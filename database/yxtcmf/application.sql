-- --------------------------------------------------------

--
-- 表的结构 `yxt_application`
--

CREATE TABLE IF NOT EXISTS `yxt_application` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) DEFAULT NULL,
  `t_name` varchar(20) DEFAULT NULL,
  `zigezheng` varchar(200) DEFAULT NULL,
  `zichengzheng` varchar(200) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yxt_application`
--

INSERT INTO `yxt_application` (`id`, `user_id`, `t_name`, `zigezheng`, `zichengzheng`, `addtime`, `state`) VALUES
(1, 2, '王建明', '/data/upload/20161127/583a7c272e189.jpg', '', '2016-11-27 14:24:45', 1),
(2, 4, '云隐', '/data/upload/20161207/58481254227f0.png', '', '2016-12-07 21:44:54', 1),
(3, 5, '理科生福', '/data/upload/20161207/5848142f2bfbf.png', '', '2016-12-07 21:52:50', 1);

