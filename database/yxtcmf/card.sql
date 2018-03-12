-- --------------------------------------------------------

--
-- 表的结构 `yxt_card`
-- 点卡
--

CREATE TABLE IF NOT EXISTS `yxt_card` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `card_state` int(2) NOT NULL DEFAULT '0',
  `type_id` int(2) DEFAULT NULL,
  `card_price` int(5) DEFAULT NULL,
  `card_name` varchar(20) DEFAULT NULL,
  `card_pass` varchar(10) DEFAULT NULL,
  `cs_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `use_state` int(2) NOT NULL DEFAULT '0',
  `sale_state` int(2) NOT NULL DEFAULT '0',
  `viptime` int(5) NOT NULL DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `yxt_card`
--

INSERT INTO `yxt_card` (`id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime`) VALUES
(1, 0, 1, 20, 'PYJY6S4J24M4NK7', '', 0, 0, 0, 0, 0, '2016-11-27 14:02:42'),
(2, 0, 1, 20, 'BEJWRF9VCWS72B9', '', 0, 0, 0, 0, 0, '2016-11-27 14:02:42'),
(3, 0, 1, 20, 'KXFY6TPQ4DJSU28', '', 0, 0, 0, 0, 0, '2016-11-27 14:02:42'),
(4, 0, 1, 20, 'E4VWXQXYYKEP5DN', '', 0, 0, 0, 0, 0, '2016-11-27 14:02:42'),
(5, 0, 1, 20, 'HQRYKEGZBNU9ZHV', '', 0, 0, 0, 0, 0, '2016-11-27 14:02:42'),
(6, 0, 1, 20, 'ERR37CTVPWRT2EE', '', 0, 0, 0, 0, 0, '2016-11-27 14:02:42'),
(7, 0, 1, 20, '6592W2YHXEZRPRU', '', 0, 0, 0, 0, 0, '2016-11-27 14:02:42'),
(8, 0, 1, 20, 'JAC2QVHE7JURB6F', '', 0, 0, 0, 0, 0, '2016-11-27 14:02:42'),
(9, 0, 1, 20, '5BYAS8M3EMHJVWA', '', 0, 0, 0, 0, 0, '2016-11-27 14:02:42'),
(10, 0, 1, 20, 'W5F2UR65X7UBQQV', '', 0, 0, 0, 0, 0, '2016-11-27 14:02:42'),
(11, 0, 2, 10, '5DXJFAHEVMVHX25', '', 1, 0, 0, 0, 0, '2016-11-27 14:03:02'),
(12, 0, 2, 10, 'KDUJYG3YMQEFK4X', '', 1, 0, 0, 0, 0, '2016-11-27 14:03:02'),
(13, 0, 2, 10, '6QDAUH54WYE8DKN', '', 1, 0, 0, 0, 0, '2016-11-27 14:03:02'),
(14, 0, 2, 10, '94NNB78UDRCS4S7', '', 1, 0, 0, 0, 0, '2016-11-27 14:03:02'),
(15, 0, 2, 10, 'WWJBJGSKK4RMRQV', '', 1, 0, 0, 0, 0, '2016-11-27 14:03:02'),
(16, 0, 2, 10, 'PMVDVC5ZY9ZY9PU', '', 1, 0, 0, 0, 0, '2016-11-27 14:03:02'),
(17, 0, 2, 10, 'PD863VBU3B5PD7F', '', 1, 0, 0, 0, 0, '2016-11-27 14:03:02'),
(18, 0, 2, 10, 'TP5F7WED997M4UV', '', 1, 0, 0, 0, 0, '2016-11-27 14:03:02'),
(19, 0, 2, 10, '99Y75B9VQ2JZXVB', '', 1, 0, 0, 0, 0, '2016-11-27 14:03:02'),
(20, 0, 2, 10, 'JPDK6YAT6KUPQ3B', '', 1, 2, 1, 0, 0, '2016-11-27 14:03:02');

