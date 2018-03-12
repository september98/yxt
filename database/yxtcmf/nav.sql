-- --------------------------------------------------------

--
-- 表的结构 `yxt_nav`
--

CREATE TABLE IF NOT EXISTS `yxt_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL COMMENT '导航分类 id',
  `parentid` int(11) NOT NULL COMMENT '导航父 id',
  `label` varchar(255) NOT NULL COMMENT '导航标题',
  `target` varchar(50) DEFAULT NULL COMMENT '打开方式',
  `href` varchar(255) NOT NULL COMMENT '导航链接',
  `icon` varchar(255) NOT NULL COMMENT '导航图标',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  `listorder` int(6) DEFAULT '0' COMMENT '排序',
  `path` varchar(255) NOT NULL DEFAULT '0' COMMENT '层级关系',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='前台导航表' AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `yxt_nav`
--

INSERT INTO `yxt_nav` (`id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path`) VALUES
(5, 2, 0, '我是教师', '', 'on', '', 1, 1, '0-5'),
(4, 1, 0, '关于我们', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"1";}}', '', 1, 2, '0-4'),
(8, 2, 5, '成为教师', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:2:"15";}}', '', 1, 0, '0-5-8'),
(7, 2, 5, '发布课程', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:2:"21";}}', '', 1, 0, '0-5-7'),
(9, 2, 5, '收益提成', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-5-9'),
(10, 2, 0, '我是学生', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-10'),
(11, 2, 10, '如何注册', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:2:"21";}}', '', 1, 0, '0-10-11'),
(12, 2, 10, '购买课程', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-10-12'),
(13, 2, 10, '如何学习', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-10-13'),
(14, 2, 0, '账户管理', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 2, '0-14'),
(15, 2, 14, '系统设置', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-14-15'),
(16, 2, 14, '课程设置', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-14-16'),
(17, 2, 14, '用户管理', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-14-17'),
(18, 2, 0, '加盟网上学院', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 3, '0-18'),
(19, 2, 18, '招商加盟', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-18-19'),
(20, 2, 18, '学习卡代理', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-18-20'),
(21, 2, 18, '入驻专家团队', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-18-21'),
(22, 2, 0, '关于我们', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 4, '0-22'),
(23, 2, 22, '关于我们', '', 'a:2:{s:6:"action";s:17:"Portal/Page/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-22-23'),
(24, 2, 22, '官方微博', '', 'home', '', 1, 0, '0-22-24'),
(25, 2, 22, '加入我们', '', 'home', '', 1, 0, '0-22-25');

