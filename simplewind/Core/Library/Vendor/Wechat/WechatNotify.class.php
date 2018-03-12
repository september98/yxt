<?php

require_once(BASE_PATH . 'wxpay/WxPay.Api.php');
require_once(BASE_PATH . 'wxpay/WxPay.Notify.php');

class WechatNotify extends WxPayNotify
{
	private $logger = NULL;
	public function __construct(){
		$this->logger = classLogger::getInstance();
	}
	
	
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		$this->logger->Log(7,"Queryorder [$transaction_id]return:" . json_encode($result));
		if(array_key_exists("return_code", $result)
				&& array_key_exists("result_code", $result)
				&& $result["return_code"] == "SUCCESS"
				&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}

	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		$this->logger->Log(7,"PayNotifyCallBack call back return:" . json_encode($data));
		$notfiyOutput = array();

		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			$this->logger->Log(7, "NotifyProcess error,as prameter invlid." );
			return false;
		}

		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			$this->logger->Log(7, "NotifyProcess error,The order not exist." );
			return false;
		}
		else{
			$out_trade_no = explode('O', $data["out_trade_no"]);
			$log_id = $out_trade_no[1];
			model('WechatPayBase')->pay_success($data);
			if(WECHAT_PAY_ATTACH_FOR_FRIEND == $data['attach']){
			    model('CrowdLog')->order_paid($log_id);
			}
			else{
			    model('Payment')->order_paid($log_id, 2);
			}
		}
		return true;
	}
}

