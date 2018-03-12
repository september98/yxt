-- --------------------------------------------------------

--
-- 表的结构 `yxt_exam_shiti`
-- 试题
--

CREATE TABLE IF NOT EXISTS `yxt_exam_shiti` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `cs_id` int(4) DEFAULT '0',
  `typeid` int(4) DEFAULT '0',
  `teacherid` int(5) DEFAULT '0',
  `uncertain` int(1) DEFAULT '0',
  `stem` varchar(800) DEFAULT '0',
  `xa` varchar(800) DEFAULT '0',
  `xb` varchar(800) DEFAULT '0',
  `xc` varchar(800) DEFAULT '0',
  `xd` varchar(800) DEFAULT '0',
  `daan` text,
  `analysis` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `yxt_exam_shiti`
--

INSERT INTO `yxt_exam_shiti` (`id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis`) VALUES
(1, 1, 1, 2, 0, '<p>易学堂CMF的官方网站是什么？</p>', '<p>www.yxtcmf.com</p>', '<p>www.ruisi365.com</p>', '<p>demo.yxtcmf.com</p>', '<p>teach.yxtcmf.com</p>', 'a,', '<p>易学堂的官方网站是www.yxtcmf.com</p>'),
(2, 1, 1, 2, 0, '<p>易学堂CMF的demo网址是什么？</p>', '<p>www.yxtcmf.com &nbsp; &nbsp;</p>', '<p>demo.yxtcmf.com</p>', '<p>www.ruisi365.com</p>', '<p>teach.yxtcmf.com</p>', 'b,', '<p>易学堂的demo网址是demo.yxtcmf.com</p>'),
(3, 1, 1, 2, 0, '<p>易学堂CMF的教学网址是什么？</p>', '<p>www.yxtcmf.com</p>', '<p>www.ruisi365.com</p>', '<p>demo.yxtcmf.com</p>', '<p>teach.yxtcmf.com</p>', 'd,', '<p>易学堂CMF的教学网址是teach.yxtcmf.com</p>'),
(4, 1, 2, 2, 0, '<p>易学堂CMF是一个yxt____系统</p>', '0', '0', '0', '0', '<p><strong><p>在线教学</p></strong></p>', '<p><strong><p>在线教学</p></strong></p>'),
(5, 1, 2, 2, 0, '<p>易学堂CMF是用yxt__语言编写的</p>', '0', '0', '0', '0', '<p><strong><p>php+mysql</p></strong></p>', '<p><strong><p>php+mysql</p></strong></p>'),
(6, 1, 2, 2, 0, '<p>易学堂CMF使用的是yxt___短信验证码平台。</p>', '0', '0', '0', '0', '<p><strong><p>阿里大于</p></strong></p>', '<p><strong><p>阿里大于</p></strong></p>'),
(7, 1, 3, 2, 0, '<p>易学堂CMF是属于企业开发的</p>', '0', '0', '0', '0', '1', '<p>易学堂CMF是属于个人开发。</p>'),
(8, 1, 3, 2, 0, '<p>易学堂CMF是用thinkphp 框架编写的一个在线学习平台</p>', '0', '0', '0', '0', '1', '<p>易学堂CMF是用thinkphp 框架编写的一个在线学习平台</p>'),
(9, 1, 3, 2, 0, '<p>易学堂CMF没有直播功能</p>', '0', '0', '0', '0', '2', '<p>易学堂CMF集成了腾讯直播和万视无忧直播</p>'),
(10, 1, 4, 2, 0, '<p>易学堂CMF是做什么的？</p>', '0', '0', '0', '0', '<p><strong><p>帮助培训机构和个人以最低成本、最快速度建立自己的在线教学网站，无需担心技术问题。</p></strong></p>', '<p><strong><p>帮助培训机构和个人以最低成本、最快速度建立自己的在线教学网站，无需担心技术问题。</p></strong></p>'),
(11, 1, 4, 2, 0, '<p>想搭建网校，需要哪些资源？</p>', '0', '0', '0', '0', '<p><strong><p></p></strong><p>想搭建网校，1、域名，2、主机空间（可以是虚拟主机，可以是vps，也可以是独立服务器，这IDC厂商出购买，建议用云主机，腾讯云云主机，阿里云主机等都是不错的选择），3、系统平台，也就是YxtCMF源码。还有就是腾讯云的云存储cos（可以到腾讯云获取，一个月免费50G,网站流量不大的话，绰绰有余），若是用直播功能的话，还需要腾讯云的直播服务</p><strong><p></p></strong></p>', '<p><strong><p></p></strong><p>想搭建网校，1、域名，2、主机空间（可以是虚拟主机，可以是vps，也可以是独立服务器，这IDC厂商出购买，建议用云主机，腾讯云云主机，阿里云主机等都是不错的选择），3、系统平台，也就是YxtCMF源码。还有就是腾讯云的云存储cos（可以到腾讯云获取，一个月免费50G,网站流量不大的话，绰绰有余），若是用直播功能的话，还需要腾讯云的直播服务</p></p>'),
(12, 1, 4, 2, 0, '<p>易学堂CMF集成了哪些第三方云存储？</p>', '0', '0', '0', '0', '<p><strong><p></p></strong><p>腾讯云COS和万视无忧云视频</p><strong><p></p></strong></p>', '<p><strong><p></p></strong><p>腾讯云COS和万视无忧云视频</p><strong><p></p></strong></p>'),
(14, 3, 1, 2, 0, '测试导入选择', 'a', 'b', 'c', 'd', 'a', '试题分析'),
(15, 3, 2, 2, 0, '测试导入填空', '', '', '', '', '测试导入填空答案', '试题分析'),
(16, 3, 3, 2, 0, '测试导入判断', '', '', '', '', '测试导入判断答案', '试题分析'),
(17, 3, 4, 2, 0, '测试导入解答', '', '', '', '', '测试导入解答答案', '试题分析'),
(18, 3, 5, 2, 0, '测试导入材料', '', '', '', '', '测试导入材料答案', '试题分析');

