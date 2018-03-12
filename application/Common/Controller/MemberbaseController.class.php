<?php
namespace Common\Controller;

use Common\Controller\HomebaseController;

class MemberbaseController extends HomebaseController{
    
	protected $user_model;
	protected $user;
	protected $userid;
	
	function _initialize() {
		parent::_initialize();

		//$this->check_login();
		//$this->check_user();
// 		if(sp_is_user_login()){
// 			$this->userid=sp_get_current_userid();
// 			$this->users_model=D("Common/Users");
// 			$this->user=$this->users_model->where(array("id"=>$this->userid))->find();
// 		}

        // 微信oauth处理
        if(sp_is_weixin()){
            if(ACTION_NAME == 'oauth'){
                return;
            }
        	$js_sign = $this->do_oauth();
        	if($js_sign){
        		$js_sign['user_id'] = $_SESSION['user_id'];
        		$this->assign('js_sign', $js_sign);
                $this->assign('is_subscript', $_SESSION['is_subscript']);
        		ToLog(6,"WechatController.getJsSign success.");
        	}
        	elseif ($js_sign === false){
        		ToLog(6,"WechatController.getJsSign fail.");
        	}
        }
    }
    
    public function do_oauth(){
    	if(empty($_SESSION['user_id'])){
    		$back_act = I('get.referer');
    		if(empty($back_act)){
    			$back_act = __URL__ . $_SERVER['REQUEST_URI'];
    		}
    
    		$callback = U('wechat/oauth');
    		$_SESSION['wx_redirect'] = $back_act;
    		
    		vendor('phpqrcode.phpqrcode');//导入类库
			// $QRcode = new \QRcode();//实例化，注意加\
    			
    		$url = GWechat::getInstance()->getOauthRedirect(__URL__ . $callback);
    		ecs_header("Location: " . $url . "\n");
    		exit();
    	}
    	else{
    		//$ticket = $we_obj->getJsTicket();
    		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		return GWechat::getInstance()->getJsSign($url);
    	}
    }

}