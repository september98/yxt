-- --------------------------------------------------------

--
-- 表的结构 `yxt_slide`
-- 滑动效果页面
--

CREATE TABLE IF NOT EXISTS `yxt_slide` (
  `slide_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slide_cid` int(11) NOT NULL COMMENT '幻灯片分类 id',
  `slide_name` varchar(255) NOT NULL COMMENT '幻灯片名称',
  `slide_pic` varchar(255) DEFAULT NULL COMMENT '幻灯片图片',
  `slide_url` varchar(255) DEFAULT NULL COMMENT '幻灯片链接',
  `slide_des` varchar(255) DEFAULT NULL COMMENT '幻灯片描述',
  `slide_content` text COMMENT '幻灯片内容',
  `slide_status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  `listorder` int(10) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`slide_id`),
  KEY `slide_cid` (`slide_cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='幻灯片表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yxt_slide`
--

INSERT INTO `yxt_slide` (`slide_id`, `slide_cid`, `slide_name`, `slide_pic`, `slide_url`, `slide_des`, `slide_content`, `slide_status`, `listorder`) VALUES
(2, 1, '在线教育', '/data/upload/20161109/5822d235eeba2.jpg', 'http://www.yxtcmf.com', '在线教育', '在线教育', 1, 0),
(3, 1, '首页', '/data/upload/20161109/5822d2504109d.jpg', 'http://www.ruisi365.com', '首页', '', 1, 0);

