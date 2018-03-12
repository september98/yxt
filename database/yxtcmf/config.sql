-- --------------------------------------------------------

--
-- 表的结构 `yxt_config`
--

CREATE TABLE IF NOT EXISTS `yxt_config` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `type` int(2) DEFAULT NULL,
  `alipaycount` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `pid` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `key` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `AppId` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `SecretId` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `SecretKey` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

