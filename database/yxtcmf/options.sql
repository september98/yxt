-- --------------------------------------------------------

--
-- 表的结构 `yxt_options`
--

CREATE TABLE IF NOT EXISTS `yxt_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL COMMENT '配置名',
  `option_value` longtext NOT NULL COMMENT '配置值',
  `autoload` int(2) NOT NULL DEFAULT '1' COMMENT '是否自动加载',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='全站配置表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `yxt_options`
--

INSERT INTO `yxt_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'site_options', '            {\n            		"site_name":"YxtCMF网络课堂",\n            		"site_host":"http://yxt.jack.com/",\n            		"site_root":"",\n            		"site_icp":"",\n            		"site_admin_email":"shaojun_d@126.com",\n            		"site_tongji":"",\n            		"site_copyright":"",\n            		"site_seo_title":"YxtCMF网络课堂",\n            		"site_seo_keywords":"YxtCMF,网络课堂，微课，翻转课堂",\n            		"site_seo_description":"YxtCMF是易学堂发布的一款用于快速建立网校的内容管理框架"\n        }', 1);

