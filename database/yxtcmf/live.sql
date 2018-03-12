-- --------------------------------------------------------

--
-- 表的结构 `yxt_live`
--

CREATE TABLE IF NOT EXISTS `yxt_live` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `channelname` varchar(100) DEFAULT NULL,
  `outputsourcetype` int(2) DEFAULT NULL,
  `playerpassword` varchar(20) DEFAULT NULL,
  `upstream_address` varchar(200) DEFAULT NULL,
  `channelid` varchar(25) DEFAULT NULL,
  `appid` varchar(15) DEFAULT NULL,
  `sectionid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `yxt_live`
--

INSERT INTO `yxt_live` (`id`, `channelname`, `outputsourcetype`, `playerpassword`, `upstream_address`, `channelid`, `appid`, `sectionid`) VALUES
(1, '直播课程测试', 3, '', 'rtmp://3978.livepush.myqcloud.com/live/3978_988ce9d0b05a11e69776e435c87f075e?bizid=3978', '9896587163623775892', '', 8),
(2, '直播课程测试', 3, '', 'rtmp://3978.livepush.myqcloud.com/live/3978_dc9c9e8cb46b11e69776e435c87f075e?bizid=3978', '9896587163625708852', '', 20);

