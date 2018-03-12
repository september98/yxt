-- --------------------------------------------------------

--
-- 表的结构 `yxt_exam_baoming`
-- 考试报名
--

CREATE TABLE IF NOT EXISTS `yxt_exam_baoming` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) DEFAULT NULL COMMENT '用户姓名',
  `userid` int(7) DEFAULT NULL,
  `top_id` int(6) DEFAULT '0' COMMENT '一级目录',
  `type_id` int(6) DEFAULT '0' COMMENT '二级目录',
  `sex` int(2) DEFAULT '0' COMMENT '1男，2女',
  `idnumber` varchar(20) DEFAULT '0' COMMENT '身份证',
  `mobilephone` varchar(13) DEFAULT '0' COMMENT '手机号',
  `fixedphone` varchar(13) DEFAULT '0' COMMENT '固定电话',
  `qq` varchar(13) DEFAULT '0' COMMENT 'qq号',
  `patriarchal` varchar(10) DEFAULT '0' COMMENT '家长姓名',
  `patriarchalphone` varchar(13) DEFAULT '0' COMMENT '家长电话',
  `addtime` datetime DEFAULT NULL,
  `chinese` int(11) DEFAULT NULL COMMENT '语文成绩',
  `maths` int(11) DEFAULT NULL COMMENT '数学成绩',
  `english` int(11) DEFAULT NULL COMMENT '外语成绩',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

