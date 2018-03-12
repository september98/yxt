-- --------------------------------------------------------

--
-- 表的结构 `yxt_red_packet`
-- 红包活动信息
--

CREATE TABLE IF NOT EXISTS `yxt_red_packet` (
  `packet_id` int(11) NOT NULL AUTO_INCREMENT,
  `packet_type` varchar(25) NOT NULL,
  `key_word` varchar(25) DEFAULT NULL,
  `nick_name` char(32) NOT NULL,
  `send_name` char(32) NOT NULL,
  `min_value` int(11) NOT NULL,
  `max_value` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `total_num` int(11) NOT NULL,
  `wishing` char(128) NOT NULL,
  `act_name` char(32) NOT NULL,
  `remark` char(254) NOT NULL,
  `logo_imgurl` char(128) DEFAULT NULL,
  `share_content` text,
  `share_url` char(128) DEFAULT NULL,
  `share_imgurl` char(128) DEFAULT NULL,
  `is_enable` tinyint(4) NOT NULL,
  `create_date` int(11) DEFAULT NULL,
  `update_date` int(11) DEFAULT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`packet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='红包活动' AUTO_INCREMENT=1 ;

