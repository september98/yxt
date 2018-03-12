-- --------------------------------------------------------

--
-- 表的结构 `yxt_course`
-- 教程信息
--

CREATE TABLE IF NOT EXISTS `yxt_course` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `cs_name` varchar(50) DEFAULT NULL,
  `ty_id` int(5) DEFAULT NULL,
  `cs_teacher` int(5) DEFAULT NULL,
  `cs_addtime` datetime DEFAULT NULL,
  `cs_state` int(2) DEFAULT NULL,
  `is_tuijian` int(2) DEFAULT NULL,
  `cs_price` int(5) DEFAULT NULL,
  `cs_picture` varchar(200) DEFAULT NULL,
  `listorder` int(10) DEFAULT NULL,
  `sec_numbers` int(5) DEFAULT NULL,
  `cs_xuni` int(5) DEFAULT NULL,
  `cs_brief` text,
  `top_id` int(5) DEFAULT NULL,
  `mubiao` text,
  `shihe` varchar(200) DEFAULT NULL,
  `labelid` int(2) DEFAULT NULL,
  `stu_numbers` int(5) DEFAULT NULL,
  `course_type` varchar(10) DEFAULT NULL,
  `isover` int(2) DEFAULT '0',
  `youxiaoqi` int(5) DEFAULT '90',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `yxt_course`
--

INSERT INTO `yxt_course` (`id`, `cs_name`, `ty_id`, `cs_teacher`, `cs_addtime`, `cs_state`, `is_tuijian`, `cs_price`, `cs_picture`, `listorder`, `sec_numbers`, `cs_xuni`, `cs_brief`, `top_id`, `mubiao`, `shihe`, `labelid`, `stu_numbers`, `course_type`, `isover`, `youxiaoqi`) VALUES
(1, '管理员使用教程', 2, 2, '2016-11-09 19:30:52', 1, 1, 0, '/data/upload/20161109/582308bb353af.png', 0, 5, 0, '<p>通过本课程的学习，网站管理员可以快速的了解此系统，快速的建立自己的网校！</p>', 1, ' 使用易学堂CMF，快速建立自己的在线培训系统！', '初次使用易学堂CMF的站长，对易学堂CMF不是很熟悉的站长。', 0, 0, 'doc', 0, 90),
(2, '教师使用教程', 3, 2, '2016-11-09 19:32:00', 1, 1, 9, '/data/upload/20161109/5823092dbd958.jpg', 0, 5, 10, '', 1, '学习如何使用CMF系统发布课程，发布考试等！', '初次只用系统的教师或是对系统不熟悉的教师！', 0, 0, 'doc', 0, 90),
(3, '视频课程测试', 3, 2, '2016-11-09 19:41:16', 1, 1, 9, '/data/upload/20161118/582f09934a214.jpg', 0, 3, 10, '', 1, '测试视频课程', '测试视频课程', 0, 0, 'normal', 0, 30),
(6, '直播课程', 2, 2, '2016-11-27 14:35:57', 1, 0, 0, '', 0, 1, 0, '', 1, '学习直播课程', '站长', 0, 0, 'live', 0, 90);

