<?php

/* 访问控制 */
defined('ENTRANCE') or die('Deny Access');

namespace Wechat\Controller;
use Common\Controller\MemberbaseController;

class WechatController extends MemberbaseController {
	private $we = NULL;
	private $back_act = NULL;
	private $wxuser = NULL;
	private $openid = NULL;
	
	public function __construct() {
		parent::_initialize();
		$this->we = GWechat::getInstance();
	}
	
	//发送
	public function get_avatar($user_id) {
		if($user_id){
			return model('Users')->get_user_avatar($user_id);
		}
		return false;
	}
	
	public function oauth(){
		$scope = 'snsapi_base';
		$code = isset($_GET['code'])?$_GET['code']:'';
		$token_time = isset($_SESSION['token_time'])?$_SESSION['token_time']:0;
		if(!$code && isset($_SESSION['openid']) && isset($_SESSION['user_token']) && $token_time>time()-3600)
		{
			$this->openid = $_SESSION['openid'];
			$jump_url = empty($_SESSION['wx_redirect']) ? U('default/index/index') : $_SESSION['wx_redirect'];
			$this->redirect($jump_url);
		}
		else
		{
			if ($code) {
				$json = $this->we->getOauthAccessToken();
				if (!$json) {
					unset($_SESSION['wx_redirect']);
					die('获取用户授权失败，请重新确认');
				}
				$_SESSION['openid'] = $this->openid = $json["openid"];
				$access_token = $json['access_token'];
				$_SESSION['user_token'] = $access_token;
				$_SESSION['token_time'] = time();
				$_SESSION['is_subscript'] = 0;
				$userinfo = $this->we->getUserInfo($this->openid);
				if ($userinfo && !empty($userinfo['nickname'])) {
					$_SESSION['is_subscript'] = 1;
					$this->wxuser = array(
							'openid'=>$this->openid,
							'nickname'=>$userinfo['nickname'],
							'sex'=>intval($userinfo['sex']),
							'location'=>$userinfo['province'].'-'.$userinfo['city'],
							'headimgurl'=>$userinfo['headimgurl']
					);
				} elseif (strstr($json['scope'],'snsapi_userinfo')!==false) {
					$userinfo = $this->we->getOauthUserinfo($access_token,$this->openid);
					if ($userinfo && !empty($userinfo['nickname'])) {
						$this->wxuser = array(
								'openid'=>$this->openid,
								'nickname'=>$userinfo['nickname'],
								'sex'=>intval($userinfo['sex']),
								'location'=>$userinfo['province'].'-'.$userinfo['city'],
								'headimgurl'=>$userinfo['headimgurl']
						);
					} else {
						return $this->openid;
					}
				}
				if ($this->wxuser) {
					$this->weixin_login($this->wxuser);
					unset($_SESSION['wx_redirect']);
					return $this->openid;
				}
				$scope = 'snsapi_userinfo';
			}
			if ($scope=='snsapi_base') {
				$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				$_SESSION['wx_redirect'] = $url;
			} else {
				$url = $_SESSION['wx_redirect'];
			}
			if (!$url) {
				unset($_SESSION['wx_redirect']);
				die('获取用户授权失败');
			}
			$oauth_url = $this->we->getOauthRedirect($url,"wxbase",$scope);
			header('Location: ' . $oauth_url);
		}
	}
	
	function weixin_login($userinfo){
		$userinfo['aite_id'] = $userinfo['openid']; // 添加登录标示
		ToLog(5,"weixin_login in:" . $this->openid);
		$userdata = model('Users')->get_one_user($userinfo['aite_id']);
		if ($userdata) {
			ToLog(5,"weixin_login user exist:" . $userdata['user_name']);
			// 已有记录
			self::$user->set_session($userdata['user_name']);
			self::$user->set_cookie($userdata['user_name']);
			model('Users')->update_user_info($userinfo['headimgurl']);
			model('Users')->recalculate_price();
			$jump_url = empty($_SESSION['wx_redirect']) ? url('default/index/index') : $_SESSION['wx_redirect'];
			$this->redirect($jump_url);
		}
		
		$user_name = empty($userinfo['name']) ? $userinfo['nickname'] : $userinfo['name'];
		ToLog(5,"weixin_login user not exist:$user_name");	
		$userinfo['user_name'] = base64_encode($user_name);

		
		// 无记录
		if (model('Users')->check_user_name($userinfo['user_name'])) { // 重名处理
			$tmp_name = $user_name .'_w_'. generate_rand_str(6);
			ToLog(5,"weixin_login name repeat:$tmp_name");
			$userinfo['user_name'] = base64_encode($tmp_name);
		}

		ToLog(5,"weixin_login new user" . $userinfo['user_name']);
		$userinfo['email'] = 'email' . generate_rand_str(8)  . '@' . get_top_domain();

		// 插入数据库
		$rlt = model('Users')->third_reg($userinfo);
		if($rlt === false){
			$err_msg = ECTouch::err()->get_all();
			ToLog(3,"third_reg error=" . var_export($err_msg, true));
			return;
		}
		self::$user->set_session($userinfo['user_name']);
		self::$user->set_cookie($userinfo['user_name']);
		$this->send_new_user_msg($user_name);
		model('Users')->update_user_info($userinfo['headimgurl']);
		model('Users')->recalculate_price();
		$jump_url = empty($_SESSION['wx_redirect']) ? url('index') : $_SESSION['wx_redirect'];
		$this->redirect($jump_url);
	}
	

	/**
	 * 新客户加入通知
	 * @see 消息格式
	 * {{first.DATA}}
		会员编号：{{keyword1.DATA}}
		微信昵称：{{keyword2.DATA}}
		时间：{{keyword3.DATA}}
		{{remark.DATA}}
	 * @param 
	 * @return boolean|array
	 */
	function send_new_user_msg($nickname){
		ToLog(1,"send_new_user_msg [$nickname] in");
		$user_id = $_SESSION['user_id'];
		
		$user_no = model('Users')->get_user_serial_no($user_id);
		$up_user_info = model('Users')->get_up_user_info($user_id);
		if(!$up_user_info){
			ToLog(3,"send_new_user_msg fail,as the user[$nickname] not be recommend.");
			return;
		}
		
		return $this->we->send_new_user_msg($up_user_info['user_name'], $up_user_info['openid'], $nickname, $user_no);
	}
	
	public function api(){
		$rlt = $this->we->valid(true);
		if($rlt === false){
			ToLog(4,"wechat valid fail.");
			return 'fail';
		}
		
		if($_SERVER['REQUEST_METHOD'] == "GET"){
			echo $rlt;
			exit;
		}
		
		return $this->we->response();
	}
	
	public function notify(){
		ToLog(1,"wechat notify in");
		$payObj = new WechatNotify();
		$payObj->Handle(false);
	}
	
	public function alarm(){
		ToLog("wechat alarm in.");
	}
	
	
	
	
}
