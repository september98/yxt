<?php
//require_once( dirname(__FILE__) . '../EcCache.class.php' );
require_once (VENDOR_PATH . 'payment/wxpay.php');

class GWechat extends Wechat {
	
	protected static $_instance = null;

	protected function __clone()
	{
		//disallow clone
	}
	
	public static function getInstance()
	{
		if (self::$_instance === null) {
			$c=__CLASS__;
			self::$_instance = new $c;
		}
		return self::$_instance;
	}
	
	protected function __construct()
	{
		$options = array(
				'token'=> C('app_token'),
				'encodingaeskey'=>C('encoding_aes_key'),
				'appid'=>C('app_id'),
				'appsecret'=>C('app_secret')
		);
		parent::__construct($options);
		ToLog(7,"weixin cfg=" . var_export($options,true));
		$this->cache = new EcCache();
		//$this->debug = true;
	}
	
	public function initCache() {
		if (is_object($this->cache)) {
			return true;
		} else {
			$this->cache = new EcCache();
			return true;
		}
	}
	
	/**
	 * 设置缓存，按需重载
	 * @param string $cachename
	 * @param mixed $value
	 * @param int $expired
	 * @return boolean
	 */
	protected function setCache($cachename,$value,$expired){
		//TODO: set cache implementation
		if($this->initCache()){
			return $this->cache->set($cachename,$value,$expired);
		}
		return false;
	}
	
	/**
	 * 获取缓存，按需重载
	 * @param string $cachename
	 * @return mixed
	 */
	protected function getCache($cachename){
		if($this->initCache()){
			return $this->cache->get($cachename);
		}
		return false;
	}
	
	/**
	 * 清除缓存，按需重载
	 * @param string $cachename
	 * @return boolean
	 */
	protected function removeCache($cachename){
		if($this->initCache()){
			return $this->cache->del($cachename);
		}
		return false;
	}
	
	/**
	 * 新客户加入通知
	 * 发给推荐人
	 * 编号:OPENTM203447669
	 * 标题:新客户加入通知
	 * 行业:消费品 - 消费品
	 * @see 消息格式
	 * {{first.DATA}}
		 会员编号：{{keyword1.DATA}}
		 微信昵称：{{keyword2.DATA}}
		 时间：{{keyword3.DATA}}
	 {{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_new_user_msg($to_name, $to_openid, $nickname, $user_no){
		ToLog(1,"send_new_user_msg to[$to_name] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>'尊敬的'.$to_name.'，您好，您有新的客户加入！','color'=>$color),
				'keyword1'=>array('value'=>$user_no,'color'=>$color),
				'keyword2'=>array('value'=>$nickname,'color'=>$color),
				'keyword3'=>array('value'=>date('Y-m-d H:i:s',time()),'color'=>$color),
				'remark'=>array('value'=>'好东西分享给好朋友，感谢您的分享！','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$to_openid,
				'template_id'=> C('new_user_in_tpl_id'),
				'url'=> __URL__ . U('default/user/my_share'),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_new_user_msg to[$to_name] success");
		}
		else{
			ToLog(1,"send_new_user_msg to[$to_name] fail,as[$this->errMsg]");
		}
		// 发放推荐红包
		$pay = new wxpay();
		$packet_list = model('RedPacketBase')->get_recommend_red_packet($to_openid);
		if($packet_list){
			foreach ($packet_list as $open_id => $packet){
				$pay->sent_red_packet($open_id, $packet);
			}
		}
	}
	
	/**
	 * 新用户关注微信公众号通知
	 * 发送给推荐人
	 * 编号:OPENTM203447669
	 * 标题:新客户加入通知
	 * 行业:消费品 - 消费品
	 * @see 消息格式
	 * {{first.DATA}}
		 会员编号：{{keyword1.DATA}}
		 微信昵称：{{keyword2.DATA}}
		 时间：{{keyword3.DATA}}
		 {{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_add_contact_msg($to_name, $to_openid, $nickname, $user_no){
		ToLog(1,"send_add_contact_msg to[$to_name] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>'尊敬的' . $to_name.'，您好，您推荐的朋友关注了我们的公众号！','color'=>$color),
				'keyword1'=>array('value'=>$user_no,'color'=>$color),
				'keyword2'=>array('value'=>$nickname,'color'=>$color),
				'keyword3'=>array('value'=>date('Y-m-d H:i:s',time()),'color'=>$color),
				'remark'=>array('value'=>'好东西分享给好朋友，感谢您的分享！','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$to_openid,
				'template_id'=> C('new_user_in_tpl_id'),
				'url'=> __URL__ . U('default/user/my_share'),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_add_contact_msg to[$to_name] success");
		}
		else{
			ToLog(1,"send_add_contact_msg to[$to_name] fail,as[$this->errMsg]");
		}
	}
	
	/**
	 * 新用户关注微信公众号通知
	 * 发送给管理员
	 * 编号:OPENTM203447669
	 * 标题:新客户加入通知
	 * 行业:消费品 - 消费品
	 * @see 消息格式
	 * {{first.DATA}}
		 会员编号：{{keyword1.DATA}}
		 微信昵称：{{keyword2.DATA}}
		 时间：{{keyword3.DATA}}
		 {{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_add_contact_msg_admin($to_name, $to_openid, $nickname, $user_no){
		ToLog(1,"send_add_contact_msg_admin to[$to_name] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>"又有新朋友关注了公众号！",'color'=>$color),
				'keyword1'=>array('value'=>$user_no,'color'=>$color),
				'keyword2'=>array('value'=>$nickname,'color'=>$color),
				'keyword3'=>array('value'=>date('Y-m-d H:i:s',time()),'color'=>$color),
				'remark'=>array('value'=>'继续加油！','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$to_openid,
				'template_id'=> C('new_user_in_tpl_id'),
				'url'=> __URL__ . U('default/user/my_share'),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_add_contact_msg_admin to[$to_name] success");
		}
		else{
			ToLog(1,"send_add_contact_msg_admin to[$to_name] fail,as[$this->errMsg]");
		}
	}
	
	/**
	 * 用户取消关注微信公众号通知
	 * 发送给管理员
	 * 编号:OPENTM203447669
	 * 标题:新客户加入通知
	 * 行业:消费品 - 消费品
	 * @see 消息格式
	 * {{first.DATA}}
		 会员编号：{{keyword1.DATA}}
		 微信昵称：{{keyword2.DATA}}
		 时间：{{keyword3.DATA}}
		 {{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_un_subscript_msg_admin($to_name, $to_openid, $nickname, $user_no){
		ToLog(1,"send_un_subscript_msg_admin to[$to_name] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>"一位客户取消关注了公众号！",'color'=>$color),
				'keyword1'=>array('value'=>$user_no,'color'=>$color),
				'keyword2'=>array('value'=>$nickname,'color'=>$color),
				'keyword3'=>array('value'=>date('Y-m-d H:i:s',time()),'color'=>$color),
				'remark'=>array('value'=>'太可惜了，是我们什么地方没有做好吗？','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$to_openid,
				'template_id'=> C('new_user_in_tpl_id'),
				'url'=> __URL__ . U('default/user/my_share'),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_un_subscript_msg_admin to[$to_name] success");
		}
		else{
			ToLog(1,"send_un_subscript_msg_admin to[$to_name] fail,as[$this->errMsg]");
		}
	}
	
	/**
	 * 用户取消关注微信公众号通知
	 * 发送给推荐人
	 * 编号:OPENTM203447669
	 * 标题:新客户加入通知
	 * 行业:消费品 - 消费品
	 * @see 消息格式
	 * {{first.DATA}}
		 会员编号：{{keyword1.DATA}}
		 微信昵称：{{keyword2.DATA}}
		 时间：{{keyword3.DATA}}
		 {{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_un_subscript_msg($to_name, $to_openid, $nickname, $user_no){
		ToLog(7,"send_un_subscript_msg to[$to_name] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>"您推荐的朋友取消了关注公众号！",'color'=>$color),
				'keyword1'=>array('value'=>$user_no,'color'=>$color),
				'keyword2'=>array('value'=>$nickname,'color'=>$color),
				'keyword3'=>array('value'=>date('Y-m-d H:i:s',time()),'color'=>$color),
				'remark'=>array('value'=>'太可惜了，是我们什么地方没有做好吗？','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$to_openid,
				'template_id'=> C('new_user_in_tpl_id'),
				'url'=> __URL__ . U('default/user/my_share'),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
		
		ToLog(7,"send_un_subscript_msg msg=" . json_encode($msg));
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_un_subscript_msg to[$to_name] success");
		}
		else{
			ToLog(1,"send_un_subscript_msg to[$to_name] fail,as[$this->errMsg]");
		}
	}
	
	/**
	 * 订单提交成功
	 * 编号:TM00016
	 * 标题:订单提交成功
	 * 行业:IT科技 - 互联网|电子商务
	 * @see 消息格式
	 * {{first.DATA}}
		订单号：{{orderID.DATA}}
		待付金额：{{orderMoneySum.DATA}}
		{{backupFieldName.DATA}}{{backupFieldData.DATA}}
		{{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_order_remind($open_id, $order_id, $order_sn, $amount){
		ToLog(1,"send_order_remind to[$open_id] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>'您好，您的订单已提交成功！','color'=>$color),
				'orderID'=>array('value'=>$order_sn,'color'=>$color),
				'orderMoneySum'=>array('value'=>$amount,'color'=>$color),
				'backupFieldName'=>array('value'=>'提交时间','color'=>$color),
				'backupFieldData'=>array('value'=>date('Y-m-d H:i:s',time()),'color'=>$color),
				'remark'=>array('value'=>'如有问题请直接在微信留言，我们会在第一时间为您服务！','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$open_id,
				'template_id'=> C('new_order_tpl_id'),
				'url'=>__URL__ . U('default/user/order_detail',array('order_id'=>$order_id)),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
		ToLog(7,"send_order_remind msg=" . json_encode($msg));
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_order_remind to[$open_id] success");
		}
		else{
			ToLog(1,"send_order_remind to[$open_id] fail,as[$this->errMsg]");
		}
	}
	
	/**
	 * 未支付提醒
	 * 编号:OPENTM200449480
	 * 标题:订单支付通知
	 * 行业:消费品 - 消费品
	 * @see 消息格式
	 * {{first.DATA}}
		订单号码：{{keyword1.DATA}}
		商品名称：{{keyword2.DATA}}
		商品数量：{{keyword3.DATA}}
		支付金额：{{keyword4.DATA}}
		{{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_pay_remind($open_id, $order_id, $cmo_name, $cmo_no, $amount){
		ToLog(1,"send_pay_remind to[$open_id] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>'您有一笔订单已经生成但尚未支付，请尽快到“我的订单”支付。','color'=>$color),
				'keyword1'=>array('value'=>$order_id,'color'=>$color),
				'keyword2'=>array('value'=>$cmo_name,'color'=>$color),
				'keyword3'=>array('value'=>$cmo_no,'color'=>$color),
				'keyword4'=>array('value'=>$amount,'color'=>$color),
				'remark'=>array('value'=>'订单8小时后自动取消，若有疑虑，请在微信留言。','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$open_id,
				'template_id'=> C('pay_order_tpl_id'),
				'url'=>__URL__ . U('default/user/order_detail',array('order_id'=>$order_id)),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_order_remind to[$open_id] success");
		}
		else{
			ToLog(1,"send_order_remind to[$open_id] fail,as[$this->errMsg]");
		}
	}
	
	/**
	 * 支付成功通知
	 * 编号:OPENTM200449480
	 * 标题:订单支付通知
	 * 行业:消费品 - 消费品
	 * @see 消息格式
	 * {{first.DATA}}
		 订单号码：{{keyword1.DATA}}
		 商品名称：{{keyword2.DATA}}
		 商品数量：{{keyword3.DATA}}
		 支付金额：{{keyword4.DATA}}
	 {{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_pay_success_remind($open_id, $order_id, $order_sn, $cmo_name, $cmo_no, $amount){
		ToLog(1,"send_pay_success_remind to[$open_id] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>'您的订单已经完成支付。','color'=>$color),
				'keyword1'=>array('value'=>$order_sn,'color'=>$color),
				'keyword2'=>array('value'=>$cmo_name,'color'=>$color),
				'keyword3'=>array('value'=>$cmo_no,'color'=>$color),
				'keyword4'=>array('value'=>$amount,'color'=>$color),
				'remark'=>array('value'=>'我们会尽快为您发货，感谢您的惠顾。','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$open_id,
				'template_id'=> C('pay_order_tpl_id'),
				'url'=>__URL__ . U('default/user/order_detail',array('order_id'=>$order_id)),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_pay_success_remind to[$open_id] success");
		}
		else{
			ToLog(1,"send_pay_success_remind to[$open_id] fail,as[$this->errMsg]");
		}
	}
	
	/**
	 * 支付成功通知
	 * 编号:OPENTM200449480
	 * 标题:订单支付通知
	 * 行业:消费品 - 消费品
	 * @see 消息格式
	 * {{first.DATA}}
		 订单号码：{{keyword1.DATA}}
		 商品名称：{{keyword2.DATA}}
		 商品数量：{{keyword3.DATA}}
		 支付金额：{{keyword4.DATA}}
	 {{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_pay_success_remind_admin($open_id, $nick_name, $order_id, $order_sn, $cmo_name, $cmo_no, $amount, $consignee){
		ToLog(1,"send_pay_success_remind to[$open_id] in");
		$color = '#173177';
		$msg = sprintf('联系人：%s(%s)                     地址：%s',$consignee['consignee'],$consignee['mobile'],$consignee['address']);
		$data = array(
				'first'=>array('value'=>'管理员，您好，'.$nick_name.'的订单已经完成支付。','color'=>$color),
				'keyword1'=>array('value'=>$order_sn,'color'=>$color),
				'keyword2'=>array('value'=>$cmo_name,'color'=>$color),
				'keyword3'=>array('value'=>$cmo_no,'color'=>$color),
				'keyword4'=>array('value'=>$amount,'color'=>$color),
				'remark'=>array('value'=>$msg,'color'=>$color),
		);
	
		$msg = array(
				'touser'=>$open_id,
				'template_id'=> C('pay_order_tpl_id'),
				'url'=>__URL__ . U('default/user/order_detail',array('order_id'=>$order_id)),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_pay_success_remind to[$open_id] success");
		}
		else{
			ToLog(1,"send_pay_success_remind to[$open_id] fail,as[$this->errMsg]");
		}
	}
	
	/**
	 * 佣金通知
	 * 编号:OPENTM201353202
	 * 标题:返利到帐提醒
	 * 行业:消费品 - 消费品
	 * @see 消息格式
	 * {{first.DATA}}
		金额：{{keyword1.DATA}}
		时间：{{keyword2.DATA}}
		{{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_commision_remind($open_id, $nick_name, $amount){
		ToLog(1,"send_commision_remind to[$open_id] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>'您推荐的朋友'.$nick_name.'刚支付了一个订单，收货之后，您将收到一笔返利，请知悉！','color'=>$color),
				'keyword1'=>array('value'=>$amount,'color'=>$color),
				'keyword2'=>array('value'=>date('Y-m-d H:i:s',time()),'color'=>$color),
				'remark'=>array('value'=>'感谢您的分享！','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$open_id,
				'template_id'=> C('get_rebate_tpl_id'),
				'url'=>__URL__ . U('default/user/my_share'),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_commision_remind to[$open_id] success");
		}
		else{
			ToLog(1,"send_commision_remind to[$open_id] fail,as[$this->errMsg]");
		}
	}
	
	/**
	 * 佣金到账通知
	 * 编号:OPENTM201353202
	 * 标题:返利到帐提醒
	 * 行业:消费品 - 消费品
	 * @see 消息格式
	 * {{first.DATA}}
	 金额：{{keyword1.DATA}}
	 时间：{{keyword2.DATA}}
	 {{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_pay_commision_msg($open_id, $amount){
		ToLog(1,"send_pay_commision_msg to[$open_id] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>'您有一笔返利到账，请知悉！','color'=>$color),
				'keyword1'=>array('value'=>$amount,'color'=>$color),
				'keyword2'=>array('value'=>date('Y-m-d H:i:s',time()),'color'=>$color),
				'remark'=>array('value'=>'感谢您的分享！。','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$open_id,
				'template_id'=> C('get_rebate_tpl_id'),
				'url'=>__URL__ . U('default/user/my_share'),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_pay_commision_msg to[$open_id] success");
		}
		else{
			ToLog(1,"send_pay_commision_msg to[$open_id] fail,as[$this->errMsg]");
		}
	}

	/**
	 * 订单状态更新通知
	 * 发送给管理员
	 * 编号:TM00017
	 * 标题:订单状态更新
	 * 行业:IT科技 - 互联网|电子商务
	 * @see 消息格式
	 * {{first.DATA}}
	 订单编号: {{OrderSn.DATA}}
	 订单状态: {{OrderStatus.DATA}}
	 {{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_order_status_msg_admin($open_id, $nick_name, $order_sn, $cmo_name, $cmo_no, $amount, $status, $consignee){
		ToLog(1,"send_order_status_msg_admin to[$open_id] in");
		$color = '#173177';
		$first = sprintf('您好，收到%s的订单，购买了%s等%s件商品，请跟进。',$nick_name,$cmo_name,$cmo_no);
		$remark = sprintf('联系人：%s(%s)                                             地址：%s', $consignee['consignee'], $consignee['mobile'],$consignee['address']);
		$first = str_replace(array("\r\n", "\r", "\n"), '', $first);
		$remark = str_replace(array("\r\n", "\r", "\n"), '', $remark);
		$data = array(
				'first'=>array('value'=>$first,'color'=>$color),
				'OrderSn'=>array('value'=>$order_sn,'color'=>$color),
				'OrderStatus'=>array('value'=>$status,'color'=>$color),
				'remark'=>array('value'=>$remark, 'color'=>$color),
		);
	
		$msg = array(
				'touser'=>$open_id,
				'template_id'=> C('order_status_tpl_id'),
				'url'=>__URL__ . U('default/user/my_share'),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_order_status_msg_admin to[$open_id] success");
		}
		else{
			ToLog(1,"send_order_status_msg_admin to[$open_id] fail,as[$this->errMsg][$this->errCode]");
		}
	}
	
	/**
	 * 订单状态更新通知
	 * 发送给直接推荐人
	 * 编号:TM00017
	 * 标题:订单状态更新
	 * 行业:IT科技 - 互联网|电子商务
	 * @see 消息格式
	 * {{first.DATA}}
	 订单编号: {{OrderSn.DATA}}
	 订单状态: {{OrderStatus.DATA}}
	 {{remark.DATA}}
	 * @param
	 * @return boolean|array
	 */
	public function send_order_status_msg($open_id,$nick_name, $order_sn, $status){
		ToLog(1,"send_order_status_msg to[$open_id] in");
		$color = '#173177';
		$data = array(
				'first'=>array('value'=>'您好，您推荐的好友'.$nick_name.'，刚刚提交了一个订单，请知悉。','color'=>$color),
				'OrderSn'=>array('value'=>$order_sn,'color'=>$color),
				'OrderStatus'=>array('value'=>$status,'color'=>$color),
				'remark'=>array('value'=>'好东西分享给好朋友！','color'=>$color),
		);
	
		$msg = array(
				'touser'=>$open_id,
				'template_id'=> C('order_status_tpl_id'),
				'url'=>__URL__ . U('default/user/my_share'),
				'topcolor'=>'#FF0000',
				'data'=>$data
		);
	
		$rlt = $this->sendTemplateMessage($msg);
		if($rlt){
			ToLog(6,"send_order_status_msg to[$open_id] success");
		}
		else{
			ToLog(1,"send_order_status_msg to[$open_id] fail,as[$this->errMsg]");
		}
	}
	
	/**
	 * 日志记录，可被重载。
	 * @param mixed $log 输入日志
	 * @return mixed
	 */
	protected function log($log){
		if($this->debug){
			if (is_array($log)){
				$log = print_r($log,true);
			}
			ToLog(7,"wechat log:" . $log);
		}
	}
	
	public function response(){
		$type = $this->getRev()->getRevType();
		switch($type) {
			case Wechat::MSGTYPE_TEXT:
				return $this->on_text_msg();
				break;
			case Wechat::MSGTYPE_IMAGE:
				$this->on_image_msg();
				break;
			case Wechat::MSGTYPE_LOCATION:
				$this->on_location_msg();
				break;
			case Wechat::MSGTYPE_LINK:
				$this->on_link_msg();
				break;
			case Wechat::MSGTYPE_MUSIC:
				$this->on_music_msg();
				break;
			case Wechat::MSGTYPE_NEWS:
				$this->on_news_msg();
				break;			
			case Wechat::MSGTYPE_VOICE:
				$this->on_voice_msg();
				break;
			case Wechat::MSGTYPE_VIDEO:
				$this->on_video_msg();
				break;
			case Wechat::MSGTYPE_EVENT:
				return $this->on_event_msg();
				break;
			default:
				$this->text("help info")->reply();
		}
	}
	
	private function on_image_msg(){
		ToLog(4,"wechat on_image_msg in.");
		$pic_data = $this->getRevData();
		$data = $this->getMedia($pic_data['MediaId']);
		if($data){
		    $filename = ROOT_PATH . 'data/attached/wechat/image/'. $pic_data['MsgId'] . '.' . $data['1'];
			file_put_contents($filename, $data['0']);
		}
		else{
		    ToLog(4,"wechat on_image_msg fail.");
		}
	}
	
	private function on_location_msg(){
		ToLog(4,"wechat on_location_msg in.");
	}
	
	private function on_link_msg(){
		ToLog(4,"wechat on_link_msg in.");
	}
	
	private function on_music_msg(){
		ToLog(4,"wechat on_music_msg in.");
	}
	
	private function on_news_msg(){
		ToLog(4,"wechat on_news_msg in.");
	}
	
	private function on_voice_msg(){
		ToLog(4,"wechat on_voice_msg in.");
	}
	
	private function on_video_msg(){
		ToLog(4,"wechat on_video_msg in.");
	}
	
	public function on_text_msg(){
		$txt =$this->getRevContent();
		$openid = $this->getRevFrom();
		$rlt = model('RedPacketBase')->get_reply_red_packet($openid, $txt);
		if($rlt){
			$pay = new wxpay();
			$pay->sent_red_packet($openid, $rlt);
		}
		
		$this->reply_text_msg($txt);
	}
	
	private function reply_text_msg($msg){
		$cfg = model('Reply')->get_reply_content($msg);
		if(empty($cfg)){
			$content = C('default_reply_txt');
			if(!$content){
				$content = L('pop_key_words') . model('Reply')->get_pop_keys();
			}
			$this->text($content)->reply();
		}
		elseif('text' == $cfg['reply_type']){
			$this->text($cfg['content'])->reply();
		}
		elseif('image' == $cfg['reply_type']){
			$this->text($cfg['img_media_id'])->reply();
		}
		elseif('article' == $cfg['reply_type']){
			ToLog(7,"on_text_msg msg=" . json_encode($cfg));
			$news = array(
					'Title'=>$cfg['title'],
					'Description'=>$cfg['content'],
					'PicUrl'=>$cfg['media_url'],
					'Url'=>$cfg['link']
			);
		
			$this->news(array($news))->reply();
		}
		else{
			ToLog(5,"on_text_msg unknow reply_type");
		}
	}
	
	public function on_event_msg(){
		$event = $this->getRevEvent();
		if($event == false){
			ToLog(4,"on_event_msg receive event info fail.");
			return 'invlid event';
		}
		
		$event_type = $event['event'];
		switch ($event_type){
			//订阅
			case Wechat::EVENT_SUBSCRIBE:
				return $this->on_subscribe();
				break;
			// 取消订阅
			case Wechat::EVENT_UNSUBSCRIBE:
				return $this->on_unsubscribe();
				break;
			// 扫描带参数二维码
			case Wechat::EVENT_SCAN:
				return $this->on_scan();
				break;
			// 上报地理位置
			case Wechat::EVENT_LOCATION:
				return $this->on_location();
				break;
			// 菜单 - 点击菜单跳转链接
			case Wechat::EVENT_MENU_VIEW:
				return $this->on_menu_view();
				break;
			// 菜单 - 点击菜单拉取消息
			case Wechat::EVENT_MENU_CLICK:
				return $this->on_menu_click();
				break;
			// 菜单 - 扫码推事件(客户端跳URL)
			case Wechat::EVENT_MENU_SCAN_PUSH:
				return $this->on_scancode_push();
				break;
			// 菜单 - 扫码推事件(客户端不跳URL)
			case Wechat::EVENT_MENU_SCAN_WAITMSG:
				return $this->on_scancode_waitmsg();
				break;
			// 菜单 - 弹出系统拍照发图
			case Wechat::EVENT_MENU_PIC_SYS:
				return $this->on_pic_sysphoto();
				break;
			// 菜单 - 弹出拍照或者相册发图
			case Wechat::EVENT_MENU_PIC_PHOTO:
				return $this->on_pic_photo_or_album();
				break;
			// 菜单 - 弹出微信相册发图器
			case Wechat::EVENT_MENU_PIC_WEIXIN:
				return $this->on_pic_weixin();
				break;
			// 菜单 - 弹出地理位置选择器
			case Wechat::EVENT_MENU_LOCATION:
				return $this->on_location_select();
				break;
			// 发送结果 - 高级群发完成
			case Wechat::EVENT_SEND_MASS:
				return $this->on_send_mass();
				break;
			// 发送结果 - 模板消息发送结果
			case Wechat::EVENT_SEND_TEMPLATE:
				return $this->on_send_template();
				break;
			// 多客服 - 接入会话
			case Wechat::EVENT_KF_SEESION_CREATE:
				return $this->on_kf_create_session();
				break;
			// 多客服 - 关闭会话
			case Wechat::EVENT_KF_SEESION_CLOSE:
				return $this->on_kf_close_session();
				break;
			// 多客服 - 转接会话
			case Wechat::EVENT_KF_SEESION_SWITCH:
				return $this->on_kf_switch_session();
				break;
			// 卡券 - 审核通过
			case Wechat::EVENT_CARD_PASS:
				return $this->on_card_pass_check();
				break;
			// 卡券 - 审核未通过
			case Wechat::EVENT_CARD_NOTPASS:
				return $this->on_card_not_pass_check();
				break;
			// 卡券 - 用户领取卡券
			case Wechat::EVENT_CARD_USER_GET:
				return $this->on_user_get_card();
				break;
			// 卡券 - 用户删除卡券
			case Wechat::EVENT_CARD_USER_DEL:
				return $this->on_user_del_card();
				break;

			default:
				ToLog(7,"on_event_msg event type=$event_type");
				return $this->un_unknown_event($event);
		}
	}
	
	public function on_subscribe(){
		$openid = $this->getRevFrom();
		model('WechatEventBase')->subscribe($openid);
		$rlt = model('RedPacketBase')->get_available_red_packet($openid, RED_PACKET_SUBSRIBE);
		if($rlt){
			$pay = new wxpay();
			$pay->sent_red_packet($openid, $rlt);
		}
		$user = model('Users')->get_user_info_by_openid($openid);
		ToLog(7,"on_subscribe get_user_info_by_openid return=" . json_encode($user));
		if(!empty($user['up_openid'])){
			$this->send_add_contact_msg($user['up_nick_name'], $user['up_openid'],$user['user_name'],$user['user_no']);
		}
		$user_name = isset($user['user_name']) ? $user['user_name'] : '';
		
		$this->send_add_contact_msg_admin('管理员', C('admin_open_id'), $user_name, $user['user_no']);
		
		$this->reply_text_msg(ON_SUBSCRIPT_MSG);
	}
	
	public function on_unsubscribe(){
		ToLog(4,"on_unsubscribe in.");
		$openid = $this->getRevFrom();
		model('WechatEventBase')->unsubscribe($openid);
		$user = model('Users')->get_user_info_by_openid($openid);
		ToLog(7,"on_unsubscribe get_user_info_by_openid return=" . json_encode($user));
		if(!empty($user['up_openid'])){
			$this->send_un_subscript_msg($user['up_nick_name'], $user['up_openid'],$user['user_name'],$user['user_no']);
		}
		
		$this->send_un_subscript_msg_admin('管理员', C('admin_open_id'), $user['user_name'],$user['user_no']);
		return false;
	}
	
	public function on_scan(){
		ToLog(4,"wechat on_scan in.");
	}
	
	public function on_location(){
		ToLog(4,"wechat on_location in.");

	}
	
	public function on_menu_view(){
		ToLog(4,"on_menu_view in.");
	}
	
	public function on_menu_click(){
		ToLog(4,"on_menu_click in.");
	}
	
	public function on_scancode_push(){
		ToLog(4,"on_scancode_push in.");
	}
	
	public function on_scancode_waitmsg(){
		ToLog(4,"on_scancode_waitmsg in.");
	}
	
	public function on_pic_sysphoto(){
		ToLog(4,"on_pic_sysphoto in.");
	}
	
	public function on_pic_photo_or_album(){
		ToLog(4,"on_pic_photo_or_album in.");
	}
	
	public function on_pic_weixin(){
		ToLog(4,"on_pic_weixin in.");
	}
	
	public function on_location_select(){
		ToLog(4,"on_location_select in.");
		$data = $this->getRevSendGeoInfo();
		$openid = $this->getRevFrom();
		$create_time = $this->getRevCtime();
		$loc_id = model('UserLocation')->create_location_record($data['Poiname'], $data['Label'], $create_time, $data['Location_X'], $data['Location_Y'], $openid);
			
	}
	
	public function on_send_mass(){
		ToLog(4,"on_send_mass in.");
	}
	
	public function on_send_template(){
		ToLog(4,"on_send_template in.");
	}
	
	public function on_kf_create_session(){
		ToLog(4,"on_kf_create_session in.");
	}
	
	public function on_kf_close_session(){
		ToLog(4,"on_kf_close_session in.");
	}
	
	public function on_kf_switch_session(){
		ToLog(4,"on_kf_switch_session in.");
	}
	
	public function on_card_pass_check(){
		ToLog(4,"on_card_pass_check in.");
	}
	
	public function on_card_not_pass_check(){
		ToLog(4,"on_card_not_pass_check in.");
	}
	
	public function on_user_get_card(){
		ToLog(4,"on_user_get_card in.");
	}
	
	public function on_user_del_card(){
		ToLog(4,"on_user_del_card in.");
	}
	
	public function un_unknown_event($event){
		ToLog(4,"un_unknown_event in.");
	}
	
	public function get_addr_code($goto_url){
		$pay = new wxpay();
		return $pay->get_address_code($goto_url);
	}
	
	public function getResult(){
		return "[$this->errMsg][$this->errCode]";
	}
	
	
	/**
	 * GET 请求
	 * @param string $url
	 */
	private function http_get_file($url){
	    $oCurl = curl_init();
	    if(stripos($url,"https://")!==FALSE){
	        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
	        curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
	    }
	    curl_setopt($oCurl, CURLOPT_URL, $url);
	    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );	    
	    curl_setopt($oCurl, CURLOPT_HEADER, 1);
	    curl_setopt($oCurl, CURLOPT_BINARYTRANSFER, 1);
	    
	    $tmpInfo = curl_exec($oCurl);
	    $aStatus = curl_getinfo($oCurl);
	    curl_close($oCurl);
	    if(intval($aStatus["http_code"])==200){
	        list($headers, $body) = explode("\r\n\r\n", $tmpInfo, 2);
	        
	        $patten = '/filename=".*"/';
	        preg_match($patten, $headers, $result);
	        
	        if(!empty($result)){
		        $fileArr = pathinfo($result['0']);
		        $file_extension = trim($fileArr['extension'] , "\"");
	        } else{
	        	ToLog(4,"get file extension fail.");
	        	$file_extension = 'jpeg';
	        }
	        //$file_type = $headers['Content-Type'];
	        return array($body, $file_extension);
	    }else{
	        return false;
	    }
	}
	
	/**
	 * 获取缓存，按需重载
	 * @param string $cachename
	 * @return mixed
	 */
	protected function getCache($cachename){
		//TODO: get cache implementation
		$cache_dir = ROOT_PATH . 'data/cache/filecache/';
		$file = $cache_dir . $cachename . '.cache';
		if(!is_file($file)){
			return false;	
		}
		
		$content = file_get_contents($file);
		$data = unserialize($content);
		if (!is_array($data) || !isset($data['value']) || (!empty($data['value']) && $data['expired']<time())) {
            @unlink($file);
            return false;
        }
        return $data['value'];
	}

	/**
	 * 清除缓存，按需重载
	 * @param string $cachename
	 * @return boolean
	 */
	protected function removeCache($cachename){
		//TODO: remove cache implementation
		$cache_dir = ROOT_PATH . 'data/cache/filecache/';
		$file = $cache_dir . $cachename . '.cache';
		if(is_file($file)){
			@unlink($file);
		}
		return true;
	}
	
	
}

?>