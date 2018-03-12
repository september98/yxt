-- --------------------------------------------------------

--
-- 表的结构 `yxt_users`
-- 用户表
--

CREATE TABLE IF NOT EXISTS `yxt_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码；sp_password加密',
  `user_nicename` varchar(50) NOT NULL DEFAULT '' COMMENT '用户美名',
  `user_email` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `user_url` varchar(100) NOT NULL DEFAULT '' COMMENT '用户个人网站',
  `avatar` varchar(255) DEFAULT NULL COMMENT '用户头像，相对于upload/avatar目录',
  `sex` smallint(1) DEFAULT '0' COMMENT '性别；0：保密，1：男；2：女',
  `birthday` date DEFAULT '2000-01-01' COMMENT '生日',
  `signature` varchar(255) DEFAULT NULL COMMENT '个性签名',
  `last_login_ip` varchar(16) DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` datetime NOT NULL DEFAULT '2000-01-01 00:00:00' COMMENT '最后登录时间',
  `create_time` datetime NOT NULL DEFAULT '2000-01-01 00:00:00' COMMENT '注册时间',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '' COMMENT '激活码',
  `user_status` int(11) NOT NULL DEFAULT '1' COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `user_type` smallint(1) DEFAULT '1' COMMENT '用户类型，1:admin ;2:会员;3教师',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '金币',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `prov` varchar(20) DEFAULT '' COMMENT '省',
  `city` varchar(20) DEFAULT '' COMMENT '市',
  `dist` varchar(20) DEFAULT '' COMMENT '县',
  `weiixn` varchar(40) DEFAULT '' COMMENT '微信',
  `qq` int(15) DEFAULT NULL COMMENT 'QQ',
  `teacstate` int(2) DEFAULT '0' COMMENT '申请教师的状态',
  `chatstate` int(2) DEFAULT '0' COMMENT '直播聊天室的状态0不在线，1在线',

  `zhicheng` varchar(60) DEFAULT NULL COMMENT '教师职称',
  `tcProfile` varchar(600) DEFAULT NULL COMMENT '教师简介',
  `adminplate` int(2) DEFAULT NULL,
  `folderid` int(10) DEFAULT NULL,
  `coins` int(11) NOT NULL DEFAULT '0' COMMENT '金币',
  `openid` varchar(50) DEFAULT NULL,
  `aite_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `yxt_users`
--

INSERT INTO `yxt_users` (`id`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `avatar`, `sex`, `birthday`, `signature`, `last_login_ip`, `last_login_time`, `create_time`, `user_activation_key`, `user_status`, `score`, `user_type`, `coin`, `mobile`, `prov`, `city`, `dist`, `weiixn`, `qq`, `teacstate`, `chatstate`, `zhicheng`, `tcProfile`, `adminplate`, `folderid`, `coins`) VALUES
(2, '', '###932480be6b2bad8c56fb6555c55e2e17', '禅心如月', '', '', '583ee9cfc53cf.jpg', '1', '0000-00-00', '我就是我，不一样的烟火！', '222.132.80.29', '2016-12-02 07:40:19', '2016-11-27 14:22:29', '', 1, 0, 3, 0, '15853789278', '山东', '', '', '378146005', 378146005, 0, 0, '中学高级教师', '中学高级教师', 1, 0, 0),
(3, '', '###932480be6b2bad8c56fb6555c55e2e17', '学习哥', '', '', '', '0', '0000-00-00', '', '222.132.80.29', '2016-12-01 20:47:29', '2016-11-30 07:48:32', '', 1, 0, 2, 0, '15562315180', '', '', '', '', 0, 0, 0, '', '', 0, 0, 0),
(4, '', '###932480be6b2bad8c56fb6555c55e2e17', '云隐', '', '', '', '0', '0000-00-00', '', '111.14.134.33', '2016-12-07 21:43:35', '2016-12-07 21:43:35', '', 1, 0, 3, 0, '1585378000', '', '', '', '', 0, 0, 0, '', '', 0, 0, 0),
(5, '', '###932480be6b2bad8c56fb6555c55e2e17', '理科生福', '', '', '', '0', '0000-00-00', '', '111.14.134.33', '2016-12-07 21:52:17', '2016-12-07 21:52:17', '', 1, 0, 3, 0, '15562124356', '', '', '', '', 0, 0, 0, '', '', 0, 0, 0),
(1, 'admin', '###73798b14ee2d050c0d0bcb98bb7a99cf', 'admin', 'shaojun_d@126.com', '', NULL, '0', NULL, NULL, '127.0.0.1', '2018-03-03 11:56:40', '2018-03-01 11:57:17', '', 1, 0, 1, 0, '', '', '', '', '', NULL, 0, 0, NULL, NULL, NULL, NULL, 0);

