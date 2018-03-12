-- --------------------------------------------------------

--
-- 表的结构 `yxt_auth_access`
--

CREATE TABLE IF NOT EXISTS `yxt_auth_access` (
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色',
  `rule_name` varchar(255) NOT NULL COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) DEFAULT NULL COMMENT '权限规则分类，请加应用前缀,如admin_',
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限授权表';

--
-- 转存表中的数据 `yxt_auth_access`
--

INSERT INTO `yxt_auth_access` (`role_id`, `rule_name`, `type`) VALUES
(2, 'course/adminsection/index', 'admin_url'),
(2, 'course/admincourse/index', 'admin_url'),
(2, 'course/admincoursetype/index', 'admin_url'),
(2, 'admin/course/index', 'admin_url'),
(2, 'admin/setting/clearcache', 'admin_url'),
(2, 'admin/mailer/active_post', 'admin_url'),
(2, 'admin/mailer/active', 'admin_url'),
(2, 'admin/mailer/index_post', 'admin_url'),
(2, 'admin/mailer/index', 'admin_url'),
(2, 'admin/mailer/default', 'admin_url'),
(2, 'admin/route/listorders', 'admin_url'),
(2, 'admin/route/open', 'admin_url'),
(2, 'admin/route/ban', 'admin_url'),
(2, 'admin/route/delete', 'admin_url'),
(2, 'admin/route/edit_post', 'admin_url'),
(2, 'admin/route/edit', 'admin_url'),
(2, 'admin/route/add_post', 'admin_url'),
(2, 'admin/route/add', 'admin_url'),
(2, 'admin/route/index', 'admin_url'),
(2, 'admin/setting/site_post', 'admin_url'),
(2, 'admin/setting/site', 'admin_url'),
(2, 'admin/setting/password_post', 'admin_url'),
(2, 'admin/setting/password', 'admin_url'),
(2, 'admin/user/userinfo_post', 'admin_url'),
(2, 'admin/user/userinfo', 'admin_url'),
(2, 'admin/setting/userdefault', 'admin_url'),
(2, 'admin/setting/default', 'admin_url');

