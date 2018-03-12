-- --------------------------------------------------------

--
-- 表的结构 `yxt_route`
--

CREATE TABLE IF NOT EXISTS `yxt_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '路由id',
  `full_url` varchar(255) DEFAULT NULL COMMENT '完整url， 如：portal/list/index?id=1',
  `url` varchar(255) DEFAULT NULL COMMENT '实际显示的url',
  `listorder` int(5) DEFAULT '0' COMMENT '排序，优先级，越小优先级越高',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1：启用 ;0：不启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='url路由表' AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `yxt_route`
--

INSERT INTO `yxt_route` (`id`, `full_url`, `url`, `listorder`, `status`) VALUES
(1, 'user/login/index', 'login$', 0, 1),
(2, 'user/register/index', 'register$', 0, 1),
(3, 'course/course/coursecenter', 'course$', 0, 1),
(4, 'portal/page/index?id=1', 'about$', 0, 1),
(5, 'forum/plate/index', 'forum$', 0, 1),
(21, 'portal/index/article', 'article', 0, 1),
(24, 'course/course/courseinfo', 'courseinfo/:id\\d', 0, 1);

