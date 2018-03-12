-- --------------------------------------------------------

--
-- 表的结构 `yxt_red_packet_log`
-- 发送红包的记录
--

CREATE TABLE IF NOT EXISTS `yxt_red_packet_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `user_openid` varchar(32) NOT NULL,
  `packet_id` int(11) NOT NULL,
  `return_code` varchar(32) DEFAULT NULL,
  `return_msg` varchar(32) DEFAULT NULL,
  `result_code` varchar(32) DEFAULT NULL,
  `err_code` varchar(32) DEFAULT NULL,
  `err_code_des` varchar(128) DEFAULT NULL,
  `mch_billno` varchar(32) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `send_listid` varchar(32) DEFAULT NULL,
  `wxappid` varchar(32) DEFAULT NULL,
  `mch_id` varchar(32) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `send_time` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='发送红包的记录' AUTO_INCREMENT=1 ;

