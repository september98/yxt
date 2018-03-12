<?php



require_once(VENDOR_PATH . 'WxPay/WxPay.Api.php');


/* 访问控制 */
defined('ENTRANCE') or die('Deny Access');

$payment_lang = dirname(__FILE__) . '/language/' . C('lang') . '/' . basename(__FILE__);

if (file_exists($payment_lang)) {
    include_once ($payment_lang);
    L($_LANG);
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE) {
    $i = isset($modules) ? count($modules) : 0;
    /* 代码 */
    $modules[$i]['code'] = basename(__FILE__, '.php');
    /* 描述对应的语言项 */
    $modules[$i]['desc'] = 'weixin_desc';
    /* 是否支持货到付款 */
    $modules[$i]['is_cod'] = '0';
    /* 是否支持在线支付 */
    $modules[$i]['is_online'] = '1';
    /* 作者 */
    $modules[$i]['author'] = 'AWEGO TEAM';
    /* 网址 */
    $modules[$i]['website'] = 'http://www.awego.cn';
    /* 版本号 */
    $modules[$i]['version'] = '1.0.0';
    /* 配置信息 */
    $modules[$i]['config'] = array(
        array(
            'name' => 'weixin_appid',
            'type' => 'text',
            'value' => ''
        ),
        array(
            'name' => 'weixin_key',
            'type' => 'text',
            'value' => ''
        ),
        array(
            'name' => 'weixin_mchid',
            'type' => 'text',
            'value' => ''
        ),
        array(
            'name' => 'weixin_secret',
            'type' => 'text',
            'value' => ''
        )
    );
    
    return;
}

/**
 * 支付插件类
 */
class wxpay
{
	private $_redis = null;
	public $weixinpay_mchid;
	public $weixinpay_appid;
	public $weixinpay_key;
	public $weixinpay_secret;
	public $weixinpay_appkey;
	private $logger;
	
	public function __construct(){
	}
	
	
    /**
     * 生成支付代码
     *
     * @param array $order
     *            订单信息
     * @param array $payment
     *            支付方式信息
     */
	function get_code($order, $payment)
	{
	 	ToLog(7,"order=" . var_export($order,true));
	 	ToLog(7,"payment=" . var_export($payment,true));
	 	
	 	$prepay_info = $this->get_prepay_info($order, $payment);
	 	if(empty($prepay_info)){
	 		$goto = U('index');
	 		return '<div><input type="button" id="chooseWXPay" class="btn btn-info ect-btn-info ect-colorf ect-bg"  onclick="location.href=' . "'$goto';" .'" value="' . L('pay_fault') . '"  /></div>';
	 	}
	 	
	 	$jsApiParameters = $this->GetJsApiParameters($prepay_info);	 	
	 	$detail_url = url('user/order_detail', array('order_id' => $order ['order_id']));
	 	ToLog(7,"get_code return=" . json_encode($jsApiParameters));
		
		$rejs = '<script type="text/javascript">
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				"getBrandWCPayRequest",
				'. $jsApiParameters .',
				function(res){
					window.location.href="' . $detail_url . '";
				}
			);
		}
	
		function callpay()
		{
			if (typeof WeixinJSBridge == "undefined"){
			    if( document.addEventListener ){
			        document.addEventListener("WeixinJSBridgeReady", jsApiCall, false);
			    }else if (document.attachEvent){
			        document.attachEvent("WeixinJSBridgeReady", jsApiCall); 
			        document.attachEvent("onWeixinJSBridgeReady", jsApiCall);
			    }
			}else{
			    jsApiCall();
			}
		}		
		</script>';
				
		$button = $rejs.' <div><input type="button" id="chooseWXPay" class="btn btn-info ect-btn-info ect-colorf ect-bg"  onclick="callpay();" value="' . L('pay_button') . '"  /></div>';
		return $button;
	}
	
	/**
	 * 生成收货地址共享接口代码
	 *
	 */
	function get_address_code($goto_url)
	{
		if(!isset($_SESSION['user_token'])){
			return 'function get_share_addr(){window.location.href="' . $goto_url . '";}';
		}
		
		$editAddress = $this->GetEditAddressParameters($_SESSION['user_token']);
		$rejs = '
		function editAddress()
		{
			WeixinJSBridge.invoke(
				"editAddress",
				'. $editAddress .',
				function(res){
					if("edit_address:ok" == res.err_msg){
						set_addr_info(res);
					}
				}
			);
		}

		function get_share_addr(){
			if (typeof WeixinJSBridge == "undefined"){
			    if( document.addEventListener ){
			        document.addEventListener("WeixinJSBridgeReady", editAddress, false);
			    }else if (document.attachEvent){
			        document.attachEvent("WeixinJSBridgeReady", editAddress);
			        document.attachEvent("onWeixinJSBridgeReady", editAddress);
			    }
			}else{
				editAddress();
			}
		};';
		
		return $rejs;
	}
	
	function get_api_param($order){
	    ToLog(7,"get_api_param order=" . var_export($order,true));
	    	
	    $prepay_info = $this->get_prepay_info($order, null);
	    if(empty($prepay_info)){
	        return false;
	    }
	    	
	    $jsApiParameters = $this->GetJsApiParameters($prepay_info);
	    ToLog(7,"get_code return=" . json_encode($jsApiParameters));
	    return $jsApiParameters;
	}

 	public function notify($data)
    {
        $this->callback($data);
    }
    
    public function callback($data)
    {	
    	$notify = new WechatNotify();
		$notify->Handle(false);
	}
	
	function get_prepay_info($order, $payment){
		$openId = $_SESSION['openid'];
		if(empty($openId)){
		    ToLog(7, 'get_prepay_info session=' . json_encode($_SESSION));
			ToLog(3, "get_prepay_info fail,as the openid is invlid.");
			return false;
		}
		$out_trade_no = $order['order_sn'] . 'O' . $order['log_id'] . 'O' . gmtime();
		$prepay_info = model('WechatPayBase')->query_prepay_info($openId, $order['order_sn'], $order['log_id']);
		if($prepay_info){
			if(gmtime() - intval($prepay_info['create_time']) < WECHAT_PAY_PREPAY_EFFECTIVE_TIME && empty($order['force_new_pay'])){
				return $prepay_info;
			}
			else{
			    // 如果已经超时，则不需要关闭订单
				// $this->close_order($prepay_info['out_trade_no']);
			}
		}

		return $this->create_order($openId, $order['order_sn'], $order['log_id'], $out_trade_no, $order);

	}

	public function create_order($openId, $order_sn, $pay_log_id, $out_trade_no, $order){
		$total_fee = floatval($order['order_amount']);
		$attach = empty($order['attach']) ? WECHAT_PAY_ATTACH_NORMAL : $order['attach'];
		$total_fee = intval($total_fee * 100);
		$notify_url = __URL__ . url('wechat/notify');
		
		$body = '微信购物';
		if(isset($order['attach']) && WECHAT_PAY_ATTACH_FOR_FRIEND == $order['attach']){
		    $body = model('CrowdLog')->get_order_goods_name($order['log_id']);
		}
		else if(isset($order['order_id'])){
		    $body = model('Order')->get_order_goods_name($order['order_id']);
		}
		 
		$input = new WxPayUnifiedOrder();
		$input->SetBody($body);
		$input->SetAttach($attach);
		$input->SetOut_trade_no($out_trade_no);
		$input->SetTotal_fee($total_fee);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + WECHAT_PAY_PREPAY_EFFECTIVE_TIME));
		$input->SetGoods_tag("test_Goods_tag");
		$input->SetNotify_url($notify_url);
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		$prepay_info = WxPayApi::unifiedOrder($input);
		ToLog(7,"prepay_info=" . var_export($prepay_info,true));
		
		return model('WechatPayBase')->save_prepay_info($openId, $order_sn, $pay_log_id, $out_trade_no, $prepay_info);
	}
	
	/**
	 * 查询微信订单
	 * @param string $transaction_id 微信订单号
	 * @param string $out_trade_no 商户订单号
	 * @uses 微信订单号和商户订单号选少填一个，微信订单号优先
	 * @return
	 * */
	public function query_order($transaction_id, $out_trade_no=''){
		$input = new WxPayOrderQuery();
		if(empty($transaction_id)){
			$input->SetTransaction_id($transaction_id);
		}
		else{
			$input->SetOut_trade_no($out_trade_no);
		}
	
		$rlt = WxPayApi::orderQuery($input);
	}
	/**
	 * 退款
	 * @param string $transaction_id 微信订单号
	 * @param string $out_trade_no 商户订单号
	 * @param string $total_fee 订单总金额(分)
	 * @param string $refund_fee 退款金额(分)
	 * @uses 微信订单号和商户订单号选少填一个，微信订单号优先
	 * */
	public function refund($order_sn, $pay_log_id, $refund_fee=0){
	    $order = model('WechatPayBase')->query_refund_info($order_sn, $pay_log_id);
	    if(empty($order)){
	    	return false;
	    }
	    
	    if(empty($refund_fee)){
	        $refund_fee = $order['cash_fee'];
	    }
	    $input = new WxPayRefund();
	    $input->SetTransaction_id($order['transaction_id']);
		
		$input->SetTotal_fee($order['cash_fee']);
		$input->SetRefund_fee($refund_fee);
		$input->SetOut_refund_no(WxPayConfig::MCHID . $order_sn . $pay_log_id);
		$input->SetOp_user_id(WxPayConfig::MCHID);
		$rlt = WxPayApi::refund($input);
		ToLog(7, 'refund return=' . json_encode($rlt));
		if($rlt['result_code'] == 'SUCCESS'){
		    model('WechatPayBase')->refund_success($order['transaction_id']);
		}
		else{
			return $rlt;
		}		
	}
	
	/**
	 * 查询退款
	 * @param string $transaction_id 微信订单号
	 * @param string $out_trade_no 商户订单号
	 * @param string $out_refund_no 商户退款单号
	 * @param string $refund_id 微信退款单号
	 * @uses 微信订单号、商户订单号、微信订单号、微信退款单号选填至少一个，微信退款单号优先
	 * */
	public function query_refund($transaction_id, $out_trade_no, $out_refund_no, $refund_id){
		$input = new WxPayRefundQuery();
		$input->SetTransaction_id($transaction_id);
		$input->SetOut_refund_no($out_refund_no);
		$input->SetOut_trade_no($out_trade_no);
		$input->SetRefund_id($refund_id);
		$rlt = WxPayApi::refundQuery($input);
	}
	
	
	/**
	 * 下载账单
	 * @param string $bill_date 对账日期
	 * @param mixed $bill_type (ALL|SUCCESS|REFUND|REVOKED)
	 * (所有订单信息 | 成功支付的订单 | 退款订单| 撤销的订单)
	 * */
	public function download_bill($bill_date, $bill_type){
		$input = new WxPayDownloadBill();
		$input->SetBill_date($bill_date);
		$input->SetBill_type($bill_type);
		$file = WxPayApi::downloadBill($input);
		echo $file;
	}
	
	/**
	 * 关闭订单
	 * @param string $out_trade_no 商户订单号
	 * */
	public function close_order($out_trade_no){
		model('WechatPayBase')->disable_prepay_info($out_trade_no);
		
		$input = new WxPayCloseOrder();
		$input->SetOut_trade_no($out_trade_no);
		$rlt = WxPayApi::closeOrder($input);
		ToLog(7,"close_order [$out_trade_no]return=" . var_export($rlt, true));	
	}
	
	/**
	 *
	 * 获取jsapi支付的参数
	 * @param array $UnifiedOrderResult 统一支付接口返回的数据
	 * @throws WxPayException
	 *
	 * @return json数据，可直接填入js函数作为参数
	 */
	public function GetJsApiParameters($UnifiedOrderResult)
	{
		if(!array_key_exists("appid", $UnifiedOrderResult)
				|| !array_key_exists("prepay_id", $UnifiedOrderResult)
				|| $UnifiedOrderResult['prepay_id'] == "")
		{
			throw new WxPayException("参数错误");
		}
		$jsapi = new WxPayJsApiPay();
		$jsapi->SetAppid($UnifiedOrderResult["appid"]);
		$timeStamp = time();
		$jsapi->SetTimeStamp(strval($timeStamp));
		$jsapi->SetNonceStr(WxPayApi::getNonceStr());
		$jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);
		$jsapi->SetSignType("MD5");
		$jsapi->SetPaySign($jsapi->MakeSign());
		return $jsapi->GetValues();
	}
	
	/**
	 *
	 * 通过code从工作平台获取openid机器access_token
	 * @param string $code 微信跳转回来带上的code
	 *
	 * @return openid
	 * @todo 这个函数是不需要的
	 */
	public function GetOpenidFromMp($code)
	{
		$url = $this->__CreateOauthUrlForOpenid($code);
		//初始化curl
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOP_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
				&& WxPayConfig::CURL_PROXY_PORT != 0){
			curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
			curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
		}
		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		$this->data = $data;
		$openid = $data['openid'];
		return $openid;
	}
	
	/**
	 *
	 * 拼接签名字符串
	 * @param array $urlObj
	 *
	 * @return 返回已经拼接好的字符串
	 */
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
	
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 *
	 * 获取地址js参数
	 *
	 * @return 获取共享收货地址js函数需要的参数，json格式可以直接做参数使用
	 */
	public function GetEditAddressParameters($access_token)
	{
		$data = array();
		$data["appid"] = WxPayConfig::APPID;
		$data["url"] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$time = time();
		$data["timestamp"] = "$time";
		$data["noncestr"] = WxPayApi::getNonceStr();
		$data["accesstoken"] = $access_token;
		ToLog(7,"GetEditAddressParameters data=" . json_encode($data));
		ksort($data);
		$params = $this->ToUrlParams($data);
		$addrSign = sha1($params);
	
		$afterData = array(
				"addrSign" => $addrSign,
				"signType" => "sha1",
				"scope" => "jsapi_address",
				"appId" => WxPayConfig::APPID,
				"timeStamp" => $data["timestamp"],
				"nonceStr" => $data["noncestr"]
		);
		$parameters = json_encode($afterData);
		return $parameters;
	}
	
	/**
	 *
	 * 构造获取code的url连接
	 * @param string $redirectUrl 微信服务器回跳的url，需要url编码
	 *
	 * @return 返回构造好的url
	 */
	private function __CreateOauthUrlForCode($redirectUrl)
	{
		$urlObj["appid"] = WxPayConfig::APPID;
		$urlObj["redirect_uri"] = "$redirectUrl";
		$urlObj["response_type"] = "code";
		$urlObj["scope"] = "snsapi_base";
		$urlObj["state"] = "STATE"."#wechat_redirect";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
	}
	
	/**
	 *
	 * 构造获取open和access_toke的url地址
	 * @param string $code，微信跳转带回的code
	 *
	 * @return 请求的url
	 */
	private function __CreateOauthUrlForOpenid($code)
	{
		$urlObj["appid"] = WxPayConfig::APPID;
		$urlObj["secret"] = WxPayConfig::APPSECRET;
		$urlObj["code"] = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
	}
	
	

	function get_real_ip()
	{
		$ip=false;
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if($ip){
				array_unshift($ips, $ip); $ip = FALSE;
			}
			for($i = 0; $i < count($ips); $i++){
				if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])){
				$ip = $ips[$i];
				break;
				}
		  }
		}
		return($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}

	public function sent_red_packet($re_openid, $info){
		$input = new WxPayRedPack();
		$mch_billno = $input->genera_mch_billno();
		$rlt = model('RedPacketBase')->create_send_log($re_openid,$mch_billno,$info);
		if(!$rlt){
			ToLog(4,"sent_red_packet cancel,as[create_send_log fail].");
			return $rlt;
		}
		
		$input->SetMch_billno($mch_billno);
		$input->SetAct_name($info['act_name']);
		$input->SetNick_name($info['nick_name']);
		$input->SetSend_name($info['send_name']);
		$input->SetMin_value($info['min_value']);
		$input->SetMax_value($info['max_value']);
		$input->SetTotal_amount($info['total_amount']);
		$input->SetTotal_num($info['total_num']);
		$input->SetWishing($info['wishing']);		
		$input->SetRemark($info['remark']);
// 		$input->SetLogo_imgurl($info['logo_imgurl']);
// 		$input->SetShare_content($info['share_content']);
// 		$input->SetShare_url($info['share_url']);
// 		$input->SetShare_imgurl($info['share_imgurl']);
		$input->SetReceiveOpenid($re_openid);
		$rlt = WxPayApi::sendredpack($input);
		ToLog(7,"sent_red_pack return=" . var_export($rlt,true));
		return model('RedPacketBase')->update_send_log($rlt);
	}
	
	/**
	 * 通过企业支付发放小红包
	 * @param 用户的openid： $re_openid
	 * @param 红包信息： $info
	 * @return unknown
	 */
	public function sent_small_red_packet($re_openid, $info){
		$input = new WxPayTransfer();
		$mch_billno = $input->genera_mch_billno();
		$rlt = model('RedPacketBase')->create_send_log($re_openid,$mch_billno,$info);
		if(!$rlt){
			ToLog(4,"sent_small_red_packet cancel,as[create_send_log fail].");
			return $rlt;
		}
		
		$input->SetPartner_trade_no($mch_billno);
		//$input->SetDevice_info($info['act_name']);
		$input->SetOpenID($re_openid);
		$input->SetCheck_name('NO_CHECK');
		//$input->SetRe_user_name('');
		$input->SetAmount($info['total_amount']);
		$input->SetDesc($info['remark']);
		
		$rlt = WxPayApi::transfer($input);
		ToLog(7,"sent_small_red_packet return=" . var_export($rlt,true));
		return model('RedPacketBase')->update_transfer_log($mch_billno, $rlt);
	}

}


