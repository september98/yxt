-- --------------------------------------------------------

--
-- 表的结构 `yxt_red_packet_group`
-- 红包分组
--

CREATE TABLE IF NOT EXISTS `yxt_red_packet_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `packet_id` int(11) NOT NULL,
  `sent` int(11) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='红包分组' AUTO_INCREMENT=1 ;

