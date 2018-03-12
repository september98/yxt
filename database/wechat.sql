

CREATE TABLE IF NOT EXISTS `yxt_bonus_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(60) NOT NULL DEFAULT '',
  `type_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `send_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `min_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `max_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `send_start_date` int(11) NOT NULL DEFAULT '0',
  `send_end_date` int(11) NOT NULL DEFAULT '0',
  `use_start_date` int(11) NOT NULL DEFAULT '0',
  `use_end_date` int(11) NOT NULL DEFAULT '0',
  `min_goods_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `yxt_diy_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `title` varchar(16) NOT NULL,
  `keyword` varchar(128) NOT NULL,
  `is_show` tinyint(1) NOT NULL,
  `sort` tinyint(3) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `menu_type` varchar(30) NOT NULL DEFAULT 'click',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='自定义菜单' AUTO_INCREMENT=1 ;




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




CREATE TABLE IF NOT EXISTS `yxt_red_packet_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `packet_id` int(11) NOT NULL,
  `sent` int(11) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='红包分组' AUTO_INCREMENT=1 ;




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




CREATE TABLE IF NOT EXISTS `yxt_reg_extend_info` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `reg_field_id` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `yxt_reply` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `key_word` char(255) NOT NULL,
  `reply_type` varchar(25) NOT NULL,
  `match_type` varchar(25) NOT NULL,
  `content` text NOT NULL,
  `createtime` int(11) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `click` int(11) NOT NULL DEFAULT '0',
  `album_id` int(11) unsigned DEFAULT NULL,
  `img_media_id` varchar(64) DEFAULT NULL,
  `title` varchar(64) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`reply_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='自定义回复' AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `yxt_sys_config` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `code` varchar(30) NOT NULL DEFAULT '',
  `type` varchar(10) NOT NULL DEFAULT '',
  `store_range` varchar(255) NOT NULL DEFAULT '',
  `store_dir` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=167 ;


INSERT INTO `yxt_sys_config` (`id`, `parent_id`, `code`, `type`, `store_range`, `store_dir`, `value`, `sort_order`) VALUES
(1, 0, 'navigate', 'group', '', '', '', 1),
(2, 0, 'basic', 'group', '', '', '', 1),
(3, 0, 'display', 'group', '', '', '', 1),
(4, 0, 'shopping_flow', 'group', '', '', '', 1),
(5, 0, 'smtp', 'group', '', '', '', 1),
(6, 0, 'hidden', 'hidden', '', '', '', 1),
(7, 0, 'goods', 'group', '', '', '', 1),
(8, 0, 'sms', 'group', '', '', '', 1),
(9, 0, 'wap', 'group', '', '', '', 1),
(10, 0, 'wechat_acc', 'group', '', '', '', 1),
(11, 0, 'wechat_share', 'group', '', '', '', 1),
(12, 0, 'tpl_msg_config', 'group', '', '', '', 1),
(101, 1, 'shop_name', 'text', '', '', '爱微购微商城平台', 1),
(102, 1, 'shop_title', 'text', '', '', '爱微购微商城平台', 1),
(103, 1, 'shop_desc', 'text', '', '', '爱微购微商城平台，用户体验版', 1),
(104, 1, 'shop_keywords', 'text', '', '', '爱微购 微商城 平台 用户体验', 1),
(105, 1, 'shop_country', 'manual', '', '', '1', 1),
(106, 1, 'shop_province', 'manual', '', '', '2', 1),
(107, 1, 'shop_city', 'manual', '', '', '52', 1),
(108, 1, 'shop_address', 'text', '', '', '', 1),
(109, 1, 'qq', 'text', '', '', '', 1),
(110, 1, 'ww', 'text', '', '', '', 1),
(111, 1, 'skype', 'text', '', '', '', 1),
(112, 1, 'ym', 'text', '', '', '', 1),
(113, 1, 'msn', 'text', '', '', '', 1),
(114, 1, 'service_email', 'text', '', '', '', 1),
(115, 1, 'service_phone', 'text', '', '', '', 1),
(116, 1, 'shop_closed', 'select', '0,1', '', '0', 1),
(117, 1, 'close_comment', 'textarea', '', '', '', 1),
(118, 1, 'shop_logo', 'file', '', './themes/{$template}/images/', '', 1),
(119, 1, 'licensed', 'select', '0,1', '', '1', 1),
(120, 1, 'user_notice', 'textarea', '', '', '用户中心公告！', 1),
(121, 1, 'shop_notice', 'textarea', '', '', '', 1),
(122, 1, 'shop_reg_closed', 'select', '1,0', '', '0', 1),
(123, 1, 'shop_url', 'text', '', '', '/', 1),
(124, 1, 'show_asynclist', 'select', '1,0', '', '0', 1),
(125, 1, 'user_center_wrapper', 'file', '', './themes/{$template}/images/', '/themes/default/images/banner.jpg', 1),
(201, 2, 'lang', 'manual', '', '', 'zh_cn', 1),
(202, 2, 'icp_number', 'text', '', '', '', 1),
(203, 2, 'icp_file', 'file', '', '../cert/', '', 1),
(204, 2, 'watermark', 'file', '', '../images/', '', 1),
(205, 2, 'watermark_place', 'select', '0,1,2,3,4,5', '', '1', 1),
(206, 2, 'watermark_alpha', 'text', '', '', '65', 1),
(207, 2, 'use_storage', 'select', '1,0', '', '1', 1),
(208, 2, 'market_price_rate', 'text', '', '', '1.2', 1),
(209, 2, 'rewrite', 'select', '0,1,2', '', '0', 1),
(210, 2, 'integral_name', 'text', '', '', '积分', 1),
(211, 2, 'integral_scale', 'text', '', '', '1', 1),
(212, 2, 'integral_percent', 'text', '', '', '1', 1),
(213, 2, 'sn_prefix', 'text', '', '', 'ECS', 1),
(214, 2, 'comment_check', 'select', '0,1', '', '1', 1),
(215, 2, 'no_picture', 'file', '', './data/common/images/', '', 1),
(218, 2, 'stats_code', 'textarea', '', '', '', 1),
(219, 2, 'cache_time', 'text', '', '', '3600', 1),
(220, 2, 'register_points', 'text', '', '', '0', 1),
(221, 2, 'enable_gzip', 'select', '0,1', '', '0', 1),
(222, 2, 'top10_time', 'select', '0,1,2,3,4', '', '0', 1),
(223, 2, 'timezone', 'options', '-12,-11,-10,-9,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,5.75,6,6.5,7,8,9,9.5,10,11,12', '', '8', 1),
(224, 2, 'upload_size_limit', 'options', '-1,0,64,128,256,512,1024,2048,4096', '', '64', 1),
(226, 2, 'cron_method', 'select', '0,1', '', '0', 1),
(227, 2, 'comment_factor', 'select', '0,1,2,3', '', '0', 1),
(228, 2, 'enable_order_check', 'select', '0,1', '', '1', 1),
(229, 2, 'default_storage', 'text', '', '', '1', 1),
(230, 2, 'bgcolor', 'text', '', '', '#FFFFFF', 1),
(231, 2, 'visit_stats', 'select', 'on,off', '', 'on', 1),
(232, 2, 'send_mail_on', 'select', 'on,off', '', 'off', 1),
(233, 2, 'auto_generate_gallery', 'select', '1,0', '', '0', 1),
(234, 2, 'retain_original_img', 'select', '1,0', '', '1', 1),
(235, 2, 'member_email_validate', 'select', '1,0', '', '1', 1),
(236, 2, 'message_board', 'select', '1,0', '', '1', 1),
(239, 2, 'certificate_id', 'hidden', '', '', '', 1),
(240, 2, 'token', 'hidden', '', '', '', 1),
(241, 2, 'certi', 'hidden', '', '', '', 1),
(242, 2, 'send_verify_email', 'select', '1,0', '', '0', 1),
(243, 2, 'ent_id', 'hidden', '', '', '', 1),
(244, 2, 'ent_ac', 'hidden', '', '', '', 1),
(245, 2, 'ent_sign', 'hidden', '', '', '', 1),
(246, 2, 'ent_email', 'hidden', '', '', '', 1),
(301, 3, 'date_format', 'hidden', '', '', 'Y-m-d', 1),
(302, 3, 'time_format', 'text', '', '', 'Y-m-d H:i:s', 1),
(303, 3, 'currency_format', 'text', '', '', '￥%s', 1),
(304, 3, 'thumb_width', 'text', '', '', '295', 1),
(305, 3, 'thumb_height', 'text', '', '', '295', 1),
(306, 3, 'image_width', 'text', '', '', '620', 1),
(307, 3, 'image_height', 'text', '', '', '620', 1),
(312, 3, 'top_number', 'text', '', '', '10', 1),
(313, 3, 'history_number', 'text', '', '', '5', 1),
(314, 3, 'comments_number', 'text', '', '', '5', 1),
(315, 3, 'bought_goods', 'text', '', '', '3', 1),
(316, 3, 'article_number', 'text', '', '', '8', 1),
(317, 3, 'goods_name_length', 'text', '', '', '7', 1),
(318, 3, 'price_format', 'select', '0,1,2,3,4,5', '', '2', 1),
(319, 3, 'page_size', 'text', '', '', '10', 1),
(320, 3, 'sort_order_type', 'select', '0,1,2', '', '0', 1),
(321, 3, 'sort_order_method', 'select', '0,1', '', '0', 1),
(322, 3, 'show_order_type', 'select', '0,1,2', '', '1', 1),
(323, 3, 'attr_related_number', 'text', '', '', '5', 1),
(324, 3, 'goods_gallery_number', 'text', '', '', '5', 1),
(325, 3, 'article_title_length', 'text', '', '', '16', 1),
(326, 3, 'name_of_region_1', 'text', '', '', '国家', 1),
(327, 3, 'name_of_region_2', 'text', '', '', '省', 1),
(328, 3, 'name_of_region_3', 'text', '', '', '市', 1),
(329, 3, 'name_of_region_4', 'text', '', '', '区', 1),
(330, 3, 'search_keywords', 'text', '', '', 'apple,小米,电池', 0),
(332, 3, 'related_goods_number', 'text', '', '', '4', 1),
(333, 3, 'help_open', 'select', '0,1', '', '1', 1),
(334, 3, 'article_page_size', 'text', '', '', '10', 1),
(335, 3, 'page_style', 'select', '0,1', '', '1', 1),
(336, 3, 'recommend_order', 'select', '0,1', '', '0', 1),
(337, 3, 'index_ad', 'hidden', '', '', 'sys', 1),
(401, 4, 'can_invoice', 'select', '1,0', '', '1', 1),
(402, 4, 'use_integral', 'select', '1,0', '', '1', 1),
(403, 4, 'use_bonus', 'select', '1,0', '', '1', 1),
(404, 4, 'use_surplus', 'select', '1,0', '', '1', 1),
(405, 4, 'use_how_oos', 'select', '1,0', '', '1', 1),
(406, 4, 'send_confirm_email', 'select', '1,0', '', '0', 1),
(407, 4, 'send_ship_email', 'select', '1,0', '', '0', 1),
(408, 4, 'send_cancel_email', 'select', '1,0', '', '0', 1),
(409, 4, 'send_invalid_email', 'select', '1,0', '', '0', 1),
(410, 4, 'order_pay_note', 'select', '1,0', '', '1', 1),
(411, 4, 'order_unpay_note', 'select', '1,0', '', '1', 1),
(412, 4, 'order_ship_note', 'select', '1,0', '', '1', 1),
(413, 4, 'order_receive_note', 'select', '1,0', '', '1', 1),
(414, 4, 'order_unship_note', 'select', '1,0', '', '1', 1),
(415, 4, 'order_return_note', 'select', '1,0', '', '1', 1),
(416, 4, 'order_invalid_note', 'select', '1,0', '', '1', 1),
(417, 4, 'order_cancel_note', 'select', '1,0', '', '1', 1),
(418, 4, 'invoice_content', 'textarea', '', '', '办公用品', 1),
(419, 4, 'anonymous_buy', 'select', '1,0', '', '1', 1),
(420, 4, 'min_goods_amount', 'text', '', '', '0', 1),
(421, 4, 'one_step_buy', 'select', '1,0', '', '0', 1),
(422, 4, 'invoice_type', 'manual', '', '', 'a:2:{s:4:"type";a:3:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:0:"";}s:4:"rate";a:3:{i:0;d:1;i:1;d:1.5;i:2;d:0;}}', 1),
(423, 4, 'stock_dec_time', 'select', '1,0', '', '0', 1),
(424, 4, 'cart_confirm', 'options', '1,2,3,4', '', '3', 0),
(425, 4, 'send_service_email', 'select', '1,0', '', '0', 1),
(426, 4, 'show_goods_in_cart', 'select', '1,2,3', '', '3', 1),
(427, 4, 'show_attr_in_cart', 'select', '1,0', '', '1', 1),
(501, 5, 'smtp_host', 'text', '', '', 'localhost', 1),
(502, 5, 'smtp_port', 'text', '', '', '25', 1),
(503, 5, 'smtp_user', 'text', '', '', '', 1),
(504, 5, 'smtp_pass', 'password', '', '', '', 1),
(505, 5, 'smtp_mail', 'text', '', '', '', 1),
(506, 5, 'mail_charset', 'select', 'UTF8,GB2312,BIG5', '', 'UTF8', 1),
(507, 5, 'mail_service', 'select', '0,1', '', '0', 0),
(508, 5, 'smtp_ssl', 'select', '0,1', '', '0', 0),
(601, 6, 'integrate_code', 'hidden', '', '', 'ecshop', 1),
(602, 6, 'integrate_config', 'hidden', '', '', '', 1),
(603, 6, 'hash_code', 'hidden', '', '', '31693422540744c0a6b6da635b7a5a93', 1),
(604, 6, 'template', 'hidden', '', '', 'default', 1),
(605, 6, 'install_date', 'hidden', '', '', '1432893618', 1),
(606, 6, 'ecs_version', 'hidden', '', '', 'v2.7.3', 1),
(607, 6, 'sms_user_name', 'hidden', '', '', '', 1),
(608, 6, 'sms_password', 'hidden', '', '', '', 1),
(609, 6, 'sms_auth_str', 'hidden', '', '', '', 1),
(610, 6, 'sms_domain', 'hidden', '', '', '', 1),
(611, 6, 'sms_count', 'hidden', '', '', '', 1),
(612, 6, 'sms_total_money', 'hidden', '', '', '', 1),
(613, 6, 'sms_balance', 'hidden', '', '', '', 1),
(614, 6, 'sms_last_request', 'hidden', '', '', '', 1),
(616, 6, 'affiliate', 'hidden', '', '', 'a:3:{s:6:"config";a:7:{s:6:"expire";s:2:"24";s:11:"expire_unit";s:4:"hour";s:11:"separate_by";i:0;s:15:"level_point_all";s:2:"5%";s:15:"level_money_all";s:4:"100%";s:18:"level_register_all";i:2;s:17:"level_register_up";i:60;}s:4:"item";a:4:{i:0;a:2:{s:11:"level_point";s:3:"60%";s:11:"level_money";s:3:"60%";}i:1;a:2:{s:11:"level_point";s:3:"30%";s:11:"level_money";s:3:"30%";}i:2;a:2:{s:11:"level_point";s:2:"6%";s:11:"level_money";s:2:"6%";}i:3;a:2:{s:11:"level_point";s:2:"4%";s:11:"level_money";s:2:"4%";}}s:2:"on";i:1;}', 1),
(617, 6, 'captcha', 'hidden', '', '', '12', 1),
(618, 6, 'captcha_width', 'hidden', '', '', '100', 1),
(619, 6, 'captcha_height', 'hidden', '', '', '20', 1),
(620, 6, 'sitemap', 'hidden', '', '', 'a:6:{s:19:"homepage_changefreq";s:6:"hourly";s:17:"homepage_priority";s:3:"0.9";s:19:"category_changefreq";s:6:"hourly";s:17:"category_priority";s:3:"0.8";s:18:"content_changefreq";s:6:"weekly";s:16:"content_priority";s:3:"0.7";}', 0),
(621, 6, 'points_rule', 'hidden', '', '', '', 0),
(622, 6, 'flash_theme', 'hidden', '', '', 'dynfocus', 1),
(623, 6, 'stylename', 'hidden', '', '', '', 1),
(701, 7, 'show_goodssn', 'select', '1,0', '', '1', 1),
(702, 7, 'show_brand', 'select', '1,0', '', '1', 1),
(703, 7, 'show_goodsweight', 'select', '1,0', '', '1', 1),
(704, 7, 'show_goodsnumber', 'select', '1,0', '', '1', 1),
(705, 7, 'show_addtime', 'select', '1,0', '', '1', 1),
(706, 7, 'goodsattr_style', 'select', '1,0', '', '1', 1),
(707, 7, 'show_marketprice', 'select', '1,0', '', '1', 1),
(801, 8, 'sms_shop_mobile', 'text', '', '', '', 1),
(802, 8, 'sms_order_placed', 'select', '1,0', '', '0', 1),
(803, 8, 'sms_order_payed', 'select', '1,0', '', '0', 1),
(804, 8, 'sms_order_shipped', 'select', '1,0', '', '0', 1),
(901, 9, 'wap_config', 'select', '1,0', '', '0', 1),
(902, 9, 'wap_logo', 'file', '', '../images/', '', 1),
(903, 2, 'message_check', 'select', '1,0', '', '1', 1),
(910, 8, 'sms_ecmoban_user', 'text', '', '', '', 0),
(911, 8, 'sms_ecmoban_password', 'password', '', '', '', 0),
(912, 8, 'sms_signin', 'select', '1,0', '', '0', 1),
(1000, 10, 'app_token', 'text', '', '', 'awego2015versdr', 1),
(1001, 10, 'encoding_aes_key', 'text', '', '', 'Jp3X9mPEBANFE6jcbhaJPjN3XlmFkCxJZQr14ZWUTwl', 1),
(1002, 10, 'app_id', 'text', '', '', 'wx2656706809210767', 1),
(1003, 10, 'app_secret', 'text', '', '', 'cdac19b2352dc66cafe934cd35919895', 1),
(1010, 11, 'sub_img_url', 'text', '', '', '', 1),
(1011, 11, 'sub_btn_txt', 'text', '', '', '', 1),
(1012, 11, 'share_title', 'text', '', '', '', 1),
(1013, 11, 'share_desc', 'text', '', '', '', 1),
(1014, 11, 'share_imgUrl', 'text', '', '', '', 1),
(1031, 11, 'default_reply_txt', 'textarea', '', '', '阅读以下文章，玩赚商城，\r\n为您创造财富！\r\n\r\n输入“1”查看如何关注\r\n\r\n输入“2”如何分享我的二维码\r\n\r\n输入“3”如何开通微信支付\r\n\r\n输入“4”查看如何提现\r\n\r\n输入“5”查看如何确认收货\r\n\r\n输入“6”查看合伙模式说明\r\n\r\n输入“7”查看如何赚钱\r\n\r\n输入“8”查看什么是裂变\r\n\r\n输入“9”查看什么是传销', 1),
(1032, 11, 'default_reply_url', 'text', '', '', '', 1),
(1033, 12, 'admin_open_id', 'text', '', '', '', 1),
(1034, 12, 'new_user_in_tpl_id', 'text', '', '', '', 1),
(1035, 12, 'new_order_tpl_id', 'text', '', '', '', 1),
(1036, 12, 'pay_order_tpl_id', 'text', '', '', '', 1),
(1037, 12, 'get_rebate_tpl_id', 'text', '', '', '', 1),
(1038, 12, 'order_status_tpl_id', 'text', '', '', '', 1),
(1039, 12, 'user_logout_tpl_id', 'text', '', '', '', 1);



CREATE TABLE IF NOT EXISTS `yxt_wechat_album` (
  `album_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `album_name` varchar(255) NOT NULL,
  `image_width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `image_height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `album_desc` varchar(255) NOT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图片资源分组' AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `yxt_wechat_article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `article_index` tinyint(4) NOT NULL DEFAULT '0',
  `article_title` varchar(32) DEFAULT NULL,
  `thumb_media_id` varchar(64) DEFAULT NULL,
  `author` varchar(25) DEFAULT NULL,
  `digest` varchar(255) DEFAULT NULL,
  `content` text,
  `content_source_url` varchar(64) DEFAULT NULL,
  `show_cover_pic` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信图文' AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `yxt_wechat_article_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_title` varchar(32) NOT NULL,
  `wechat_media_id` varchar(64) DEFAULT NULL,
  `enable` tinyint(4) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信图文分组' AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `yxt_wechat_event` (
  `event_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(128) NOT NULL,
  `act` varchar(128) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `remark` varchar(128) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信事件' AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `yxt_wechat_media` (
  `media_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `wechat_media_id` varchar(64) DEFAULT NULL,
  `media_title` varchar(64) DEFAULT NULL,
  `media_desc` varchar(255) DEFAULT NULL,
  `media_url` varchar(255) DEFAULT NULL,
  `local_path` varchar(255) DEFAULT NULL,
  `media_size` int(11) unsigned DEFAULT NULL,
  `media_type` varchar(16) NOT NULL,
  `media_format` varchar(16) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `resource_type` tinyint(1) DEFAULT NULL,
  `expiry` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`media_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='媒体资源' AUTO_INCREMENT=1 ;




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



