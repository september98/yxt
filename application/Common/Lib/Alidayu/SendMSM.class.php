<?php
	namespace Common\Lib\Alidayu;
	include('TopSdk.php');
	use TopClient; 
	use AlibabaAliqinFcSmsNumSendRequest;
	class SendMSM {
		
		public function send($recNum='', $smsParam=''){
			$c = new TopClient;
			$c->format = "json";
			$c->appkey = C('alidayu_app_key');
			$c->secretKey = C('alidayu_app_secret');
			$req = new AlibabaAliqinFcSmsNumSendRequest;
			$req->setSmsType("normal");
			$req->setSmsFreeSignName(C('smsFreeSignName'));
			$req->setSmsParam($smsParam);
			$req->setRecNum($recNum);
			$req->setSmsTemplateCode(C('smsTemplateCode'));
			$resp = $c->execute($req);
			return $resp;
		}
		
}