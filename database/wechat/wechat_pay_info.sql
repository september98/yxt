-- --------------------------------------------------------

--
-- 表的结构 `yxt_wechat_pay_info`
-- 微信支付信息
--

CREATE TABLE IF NOT EXISTS `yxt_wechat_pay_info` (
  `pay_id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(128) NOT NULL,
  `order_sn` varchar(32) NOT NULL,
  `pay_log_id` int(11) NOT NULL,
  `out_trade_no` varchar(32) NOT NULL,
  `appid` varchar(32) DEFAULT NULL,
  `mch_id` varchar(32) DEFAULT NULL,
  `device_info` varchar(32) DEFAULT NULL,
  `nonce_str` varchar(32) DEFAULT NULL,
  `prepay_id` varchar(64) DEFAULT NULL,
  `result_code` varchar(16) DEFAULT NULL,
  `return_code` varchar(16) NOT NULL,
  `return_msg` varchar(128) NOT NULL,
  `sign` varchar(32) DEFAULT NULL,
  `trade_type` varchar(16) DEFAULT NULL,
  `err_code` varchar(32) DEFAULT NULL,
  `err_code_des` varchar(128) DEFAULT NULL,
  `code_url` varchar(64) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL,
  `transaction_id` varchar(32) NULL,
  `attach` varchar(16) NULL,
  `bank_type` varchar(16) NULL,
  `cash_fee` int(11) NULL,
  `fee_type` varchar(8) NULL,
  `is_subscribe` varchar(1) NULL,
  `is_refund` varchar(1) NULL DEFAULT 'N',
  `refund_time` int(11) NULL,
  `pay_success_time` varchar(16) NULL,
  PRIMARY KEY (`pay_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信预支付信息' AUTO_INCREMENT=1 ;


