-- --------------------------------------------------------

--
-- 表的结构 `yxt_reply`
-- 微信自定义回复
--

CREATE TABLE IF NOT EXISTS `yxt_reply` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `key_word` char(255) NOT NULL COMMENT '关键字',
  `reply_type` varchar(25) NOT NULL COMMENT '回复类型',
  `match_type` varchar(25) NOT NULL COMMENT '匹配类型',
  `content` text NOT NULL COMMENT '回复内容',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(11) DEFAULT NULL COMMENT '更新时间',
  `click` int(11) NOT NULL DEFAULT '0' COMMENT '命中次数',
  `album_id` int(11) unsigned DEFAULT NULL COMMENT '相册ID',
  `img_media_id` varchar(64) DEFAULT NULL COMMENT '图片ID',
  `title` varchar(64) DEFAULT NULL COMMENT '回复标题',
  `link` varchar(255) DEFAULT NULL COMMENT '链接地址',
  PRIMARY KEY (`reply_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='自定义回复' AUTO_INCREMENT=1 ;

