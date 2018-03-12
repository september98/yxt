<?php

$data = array();
$data['cfg_name'] = array();
$data['cfg_desc'] = array();
$data['cfg_range'] = array();

$data['num_order'] = '编号';
$data['wechat'] = '公众平台';
$data['wechat_number'] = '微信号';
$data['errcode'] = '错误代码：';
$data['errmsg'] = '错误信息：';
//公众平台
$data['wechat_num'] = '公众平台帐号';
$data['wechat_name'] = '公众号名称';
$data['wechat_type'] = '公众号类型';
$data['wechat_add_time'] = '添加时间';
$data['wechat_status'] = '状态';
$data['wechat_manage'] = '功能管理';
$data['wechat_type0'] = '未认证的公众号';
$data['wechat_type1'] = '订阅号';
$data['wechat_type2'] = '服务号';
$data['wechat_type3'] = '认证服务号';
$data['wechat_open'] = '开启';
$data['wechat_close'] = '关闭';
$data['wechat_register'] = '暂时还没有公众号，模板堂邀您尝试%s添加一个公众号</a>。';
$data['wechat_id'] = '公众号原始id';
$data['token'] = 'Token';
$data['appid'] = 'AppID';
$data['appsecret'] = 'AppSecret';
$data['wechat_add'] = '新增';
$data['wechat_help1'] = '如：ecmoban';
$data['wechat_help2'] = '请认真填写，如：gh_845581623321';
$data['wechat_help3'] = '自定义的Token值';
$data['wechat_help4'] = '用于自定义菜单等高级功能（订阅号不需要填写）';
$data['wechat_help5'] = '认证服务号是指向微信官方交过300元认证费的服务号';
$data['must_name'] = '请填写公众号名称';
$data['must_id'] = '请填写公众号原始ID';
$data['must_token'] = '请填写公众号Token';
$data['wechat_empty'] = '公众号不存在';
$data['open_wechat'] = '请开启公众号';

//关注用户
$data['sub_title'] = '关注用户列表';
$data['sub_search'] = '请输入昵称、省、市搜索';
$data['sub_headimg'] = '头像';
$data['sub_openid'] = '微信用户唯一标识(openid)';
$data['sub_nickname'] = '昵称';
$data['sub_sex'] = '性别';
$data['sub_province'] = '省(直辖市)';
$data['sub_city'] = '城市';
$data['sub_time'] = '关注时间';
$data['sub_move'] = '转移';
$data['sub_move_sucess'] = '转移成功';
$data['sub_group'] = '所在分组';
$data['sub_update_user'] = '更新用户信息';
$data['send_custom_message'] = '发送客服消息';
$data['custom_message_list'] = '客服消息列表';
$data['message_content'] = '消息内容';
$data['message_time'] = '发送时间';
$data['button_send'] = '发送';
$data['select_openid'] = '请选择微信用户';
$data['sub_help1'] = '只有48小时内给公众号发送过信息的粉丝才能接收到信息';
$data['sub_binduser'] = '绑定用户';
//分组
$data['group_sys'] = '同步分组信息';
$data['group_title'] = '分组管理';
$data['group_num'] = '公众平台中的编号';
$data['group_name'] = '分组名称';
$data['group_fans'] = '粉丝量';
$data['group_add'] = '添加分组';
$data['group_edit'] = '编辑分组';
$data['group_update'] = '更新';
$data['group_move'] = '将选中粉丝转移到分组中';
//菜单
$data['menu'] = '微信菜单';
$data['menu_add'] = '菜单添加';
$data['menu_edit'] = '菜单编辑';
$data['menu_name'] = '菜单名称';
$data['menu_type'] = '菜单类型';
$data['menu_parent'] = '父级菜单';
$data['menu_select'] = '请选择菜单';
$data['menu_click'] = 'click';
$data['menu_view'] = 'view';
$data['menu_keyword'] = '菜单关键词';
$data['menu_url'] = '外链URL';
$data['menu_create'] = '生成自定义菜单';
$data['menu_show'] = '显示';
$data['menu_select_del'] = '请选择需要删除的菜单';
$data['menu_help1'] = '如无特殊需要，这里请不要填写 (如果要实现一键拨号，请填写"tel:您的电话号码")';
//二维码
$data['qrcode'] = '二维码';
$data['qrcode_scene'] = '应用场景';
$data['qrcode_scene_value'] = '应用场景值';
$data['qrcode_scene_limit'] = '场景值已存在，请重新填写';
$data['qrcode_type'] = '二维码类型';
$data['qrcode_function'] = '功能';
$data['qrcode_short'] = '临时二维码';
$data['qrcode_forever'] = '永久二维码';
$data['qrcode_get'] = '获取二维码';
$data['qrcode_valid_time'] = '有效时间';
$data['qrcode_help1'] = '以秒为单位，最大不超过1800，默认1800（永久二维码无效）';
$data['qrcode_help2'] = '临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）';
//图文回复
$data['article'] = '图文回复';
$data['title'] = '标题';
$data['please_upload'] = '请上传图片';
$data['content'] = '正文';
$data['link_err'] = '链接格式不正确';
//扫码引荐
$data['share'] = '扫码引荐';
$data['share_name'] = '推荐人';
$data['share_userid'] = '推荐人ID';
$data['share_account'] = '现金分成';
$data['scan_num'] = '扫描量';
$data['expire_seconds'] = '有效时间';
$data['share_help'] = '不填则为无限制';
$data['interactive_user'] = '交互用户';
$data['official'] = '官方';

$data['cfg_name']['wechat'] = '微信设置';
$data['cfg_name']['app_token'] = 'Token';
$data['cfg_name']['encoding_aes_key'] = 'EncodingAESKey';
$data['cfg_name']['app_id'] = 'AppID';
$data['cfg_name']['app_secret'] = 'AppSecret';

$data['cfg_desc']['app_token'] = '(令牌)';
$data['cfg_desc']['encoding_aes_key'] = '(消息加解密密钥)';
$data['cfg_desc']['app_id'] = '(应用ID)';
$data['cfg_desc']['app_secret'] = '(应用密钥)';

$data['cfg_name']['wechat_acc'] = '微信帐号';
$data['cfg_name']['subscribe'] = '关注消息';
$data['cfg_name']['sub_reply'] = '关注自动回复';
$data['cfg_name']['wechat_share'] = '分享设置';
$data['cfg_name']['sub_img_url'] = '关注单图文链接';
$data['cfg_name']['sub_btn_txt'] = '关注按钮文字';
$data['cfg_name']['share_title'] = '发送给朋友的 标题';
$data['cfg_name']['share_desc'] = '发送给朋友的描述';
$data['cfg_name']['share_imgUrl'] = '发送给朋友的Logo';
$data['cfg_name']['default_reply_txt'] = '默认回复信息';
$data['cfg_name']['default_reply_url'] = '默认图文回复链接';
$data['cfg_name']['tpl_msg_config'] = '模板消息配置';
$data['cfg_name']['admin_open_id'] = '管理员微信号';
$data['cfg_name']['admin_user_id_arr'] = '订阅支付消息的用户ID';
$data['cfg_name']['new_user_in_tpl_id'] = '新客户加入通知';
$data['cfg_name']['new_order_tpl_id'] = '订单提交成功';
$data['cfg_name']['pay_order_tpl_id'] = '订单支付通知';
$data['cfg_name']['get_rebate_tpl_id'] = '返利到帐提醒';
$data['cfg_name']['order_status_tpl_id'] = '订单状态更新';
$data['cfg_name']['user_logout_tpl_id'] = '用户注销通知';


return $data;