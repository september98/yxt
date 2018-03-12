-- --------------------------------------------------------

--
-- 表的结构 `yxt_wechat_event`
-- 微信事件
--

CREATE TABLE IF NOT EXISTS `yxt_wechat_event` (
  `event_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(128) NOT NULL,
  `act` varchar(128) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `remark` varchar(128) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信事件' AUTO_INCREMENT=1 ;

