<?php
namespace User\Controller;
use Common\Controller\MemberbaseController;
class CenterController extends MemberbaseController {
	
	protected $users_model;
	function _initialize(){
		parent::_initialize();
		$this->check_login();
		$this->users_model=D("Common/Users");
		$this->usercourse_obj = D("Common/UsercourseView");
		$this->course_obj = D("Common/Course");
		$this->section_obj = D("Common/Section");
		$this->order_obj = D("Common/Order");
		$this->card_obj = D("Common/Card");
		$this->application_obj=D("Common/Application");
		$this->teacher_order = D("Common/Teacher_order");
		$this->papers_obj = D("Common/Exam_papers");
		$this->userpapers_obj = D("Common/Exam_userpapers");
		$this->myerrors = D("Common/Exam_myerrors");
		$this->shiti_obj = D("Common/Exam_shiti");
		$userid=sp_get_current_userid();
		$user=$this->users_model->where(array("id"=>$userid))->find();
		$avatar=$user['avatar'];
		$this->assign('avatar',$avatar);
		$this->assign('user',$user);
		
	}
	public function index() {
		$userid=sp_get_current_userid();
		$user=$this->users_model->where(array("id"=>$userid))->find();
		$count==$this->usercourse_obj->order('addtime desc')->where(array("user_id"=>$userid))->count();
		$page = $this->page($count, 9);
		$learning=$this->usercourse_obj->order('addtime desc')->limit($page->firstRow . ',' . $page->listRows)->where(array("user_id"=>$userid))->select();
		if($learning){
			$learning_=1;
		}
	    foreach($learning as $n=> $val){   
			 $learning[$n]['youxiaoqi']=$this->course_obj->where(array('id'=>$val['course_id']))->getField('youxiaoqi');
			 $learning[$n]['course_type']=$this->course_obj->where(array('id'=>$val['course_id']))->getField('course_type');
			 $learning[$n]['endtime']=subDate($learning[$n]['youxiaoqi'],$learning[$n]['addtime']);
             $learning[$n]['remainder']=time2string(strtotime($learning[$n]['endtime'])-strtotime(date('Y-m-d H:i:s')));
             $urlArr = explode("|",$learning[$n]['studied']);  
             $jnum=count( $urlArr)-1;
             $cs_id=$learning[$n][course_id];
             $znum=$this->section_obj->where(array('cs_id'=>$cs_id,'type_id'=>0,'state'=>1))->count();
             $learning[$n]['bili'] = round(($jnum/$znum)*100);
             $learning[$n]['jnum']=$jnum;
             $learning[$n]['znum']=$znum;
			 
	      } 
	         $this->assign('learning',$learning);
		     $this->assign('learning_',$learning_);
			 $this->assign("Page", $page->show('Admin'));
             $this->display(':center');
	}
	
	
	public function jihuo(){
	      $this->display(':jihuo');
	}
	public function jihuo_post(){
	   $this->usercourse = D("Common/Usercourse");
	   if(!sp_check_verify_code()){
    		$this->error("验证码错误！");
    	}
    	$rules = array(
    			array('card_name', 'require', '请输入激活码', 1 ),
    	);
    	if($this->card_obj->validate($rules)->create()===false){
    		$this->error($this->card_obj->getError());
    	}else{
    		$map['card_name']=I("post.card_name");
    		if($this->card_obj->where($map)->find()==false){
    			$this->error("输入的激活码错误！");
    		}else{
    			$carddata=$this->card_obj->where($map)->find();
    		   if($carddata['use_state']==1 or $carddata['card_state']==1){
    		      $this->error("激活码已经被使用，或激活码被锁定！");
    		   }else{
    		     $userid=sp_get_current_userid(); 
    		   	 $state['use_state']=1;
    		   	 $state['user_id']=$userid;
    		       		     
    		     if( $this->usercourse->where(array('user_id'=>$userid,'course_id'=>$carddata['cs_id']))->find()){
    		     	$this->error("已经购买了此课程，请不要重复激活！");
    		     }else{
    		     	 $cs_info=$this->course_obj->where(array('id'=>$carddata['cs_id']))->find();
    		     	 $c_data['user_id']=$userid;
	    	         $c_data['course_id']=$carddata['cs_id'];
	    	         $c_data['addtime']=date('Y-m-d H:i:s');
	    	         $c_data['state']=1;
					 $c_data['course_price']=$cs_info['cs_price'];
					 $c_data['teacher_id']=$cs_info['cs_teacher'];
					  $sailes['u_id']=$cs_info['cs_teacher'];
	    	          $sailes['c_id']=$carddata['cs_id'];
	    	          $sailes['money']=round($cs_info['cs_price']*C('cardbili') ,2); 					  
	    	          $sailes['addtime']=date('Y-m-d H:i:s');
	    	          $this->teacher_order->add($sailes);
             	     $this->usercourse->add($c_data);
    		     	 $this->card_obj->where($map)->save($state);
    		         $this->success('课程激活成功',U("User/center/count"));
    		     }                            
    		   } 
    		}
    	}  	
	}
    public function learned(){
		$userid=sp_get_current_userid();
        $count==$this->usercourse_obj->order('addtime desc')->where(array("user_id"=>$userid))->count();
		$page = $this->page($count, 9);
		$learning=$this->usercourse_obj->order('addtime desc')->limit($page->firstRow . ',' . $page->listRows)->where(array("user_id"=>$userid))->select();
		if($learning){
			$learned_=1;
		}
	    foreach($learning as $n=> $val){           
             $urlArr = explode("|",$learning[$n]['studied']);  
             $jnum=count( $urlArr)-1;
             $cs_id=$learning[$n][course_id];
             $znum=$this->section_obj->where(array('cs_id'=>$cs_id,'type_id'=>0,'state'=>1))->count();
             $learning[$n]['bili'] = ($jnum/$znum)*100;
             
	   }   
	         $this->assign('learning',$learning);
		     $this->assign('learned_',$learned_);
			 $this->assign("Page", $page->show('Admin'));
             $this->display(':learned');
    }
    public function collect(){
    	$userid=sp_get_current_userid();
		$model = M('user_favorites'); 
		$count==$model->where(array("user_id"=>$userid))->count();
		$page = $this->page($count, 10);
    	$collect=$model->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->where(array("uid"=>$userid))->select();
		foreach($collect as $n=> $val){
			$collect[$n]['voo']=$this->course_obj->order('id desc')->where('id=\''.$val['object_id'].'\'')->find();
		}
       if($collect){
		   $collect_=1;
		}
		$this->assign('collect',$collect);
		$this->assign('collect_',$collect_);
		$this->assign("Page", $page->show('Admin'));
		$this->display(':collect');
    }
    public function pinglun(){
     	
        $this->display(':pinglun');
    }
     public function setting(){
     	$userid=sp_get_current_userid();
		$user=$this->users_model->where(array("id"=>$userid))->find();
		$this->assign('user',$user);
        $this->display(':setting');
    }
     public function pic(){
     	$this->display(':pic');
    }
     public function security(){
     	
        $this->display(':security');
    }
     public function securitysave(){
     	$currentPassword=I("post.currentPassword");
     	$newPassword=I("post.newPassword");
     	$confirmPassword=I("post.confirmPassword");
        $userid=sp_get_current_userid();
		$user=$this->users_model->where(array("id"=>$userid))->find();
        if(strlen($newPassword) < 5 || strlen($password) > 20){
	       $this->error("密码长度至少5位，最多20位！");
        	
	    }
	    $user_pass=sp_password($newPassword);
		if($newPassword!=$confirmPassword){
		   $this->error("两次输入密码不一致！");
		   exit();
		}
		if(sp_compare_password($currentPassword, $user['user_pass'])){
			$data['user_pass']=$user_pass;
		   if($this->users_model->where(array('id'=>$userid))->save($data)){
		    session("user",null);
			$_SESSION['login_http_referer']=$referer;
			$this->success("密码更新成功！");
		   }
		}else{
		   $this->error("输入当前密码不正确！");
		}
    }
     public function count(){
     	$userid=sp_get_current_userid();
		$count1=$this->card_obj->where(array('user_id'=>$userid,'use_state'=>1))->order('addtime desc')->count();
     	$count2=$this->usercourse_obj->where(array("user_id"=>$userid))->order('addtime desc')->count();
		$page1 = $this->page($count1, 10);
		$page2 = $this->page($count2, 10);
     	$inflow=$this->card_obj->limit($page1->firstRow . ',' . $page1->listRows)->where(array('user_id'=>$userid,'use_state'=>1))->order('addtime desc')->select();
     	$outflow=$this->usercourse_obj->limit($page2->firstRow . ',' . $page2->listRows)->where(array("user_id"=>$userid))->order('addtime desc')->select();
     	foreach($inflow as $n=> $val){           
            $inflownum=$inflownum+$val['card_price'];
	      }  
     	foreach($outflow as $n=> $val){           
            $outflownum=$outflownum+$val['course_price'];
	      }  
     	$this->assign('inflownum',$inflownum);
     	$this->assign('outflownum',$outflownum);
     	$this->assign('inflow',$inflow);
        $this->assign('outflow',$outflow);
		$this->assign("Page1", $page1->show('Admin'));
		$this->assign("Page2", $page2->show('Admin'));
     	$this->display(':count');
    }
     public function card(){
     	
        $this->display(':card');
    }
     public function card_post(){
     	if(!sp_check_verify_code()){
    		$this->error("验证码错误！");
    	}
    	$rules = array(
    			array('card_name', 'require', '请输入点卡卡号', 1 ),
    	);
    	if($this->card_obj->validate($rules)->create()===false){
    		$this->error($this->card_obj->getError());
    	}else{
    		$map['card_name']=I("post.card_name");
    		if($this->card_obj->where($map)->find()==false){
    			$this->error("输入的卡号错误！");
    		}else{
    			$carddata=$this->card_obj->where($map)->find();
				if($carddata['type_id']!=1){
				   $this->error("此卡号不是充值卡,请确认后再充值！");
				}
    		   if($carddata['use_state']==1 or $carddata['card_state']==1){
    		      $this->error("卡号已经被使用，或卡号被锁定！");
    		   }else{
    		     $userid=sp_get_current_userid(); 
    		   	 $state['use_state']=1;
    		   	 $state['user_id']=$userid;
    		     $this->card_obj->where($map)->save($state);
    		     $user=$this->users_model->where(array("id"=>$userid))->find();
    		     $userdata['coin']=$user['coin']+$carddata['card_price'];
    		     if($this->users_model->where(array('id'=>$userid))->save($userdata)){
    		     	$this->success('充值成功',U("User/center/count"));
    		     }                            
    		   } 
    		}
    	}  	
    }
     public function order(){
		$state=I("get.state");
		$user_id=sp_get_current_userid();
		$where=empty($state)?array("user_id = $user_id"):array("user_id = $user_id and state=$state");
		$count=$this->order_obj->where($where)->count();
		$page = $this->page($count, 10);
		$data=$this->order_obj->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
		foreach($data as $n=> $val){           
            $data[$n]['coursename']=$this->course_obj->where(array('id'=>$data[$n]['course_id']))->getField('cs_name');
	      }  
		$num=$this->order_obj->where(array('state'=>2,'user_id'=>$user_id))->count();
     	$this->assign('num',$num);
     	$this->assign('order',$data);
     	$this->assign('state',$state);
		$this->assign("Page", $page->show('Admin'));
        $this->display(':order');
    }
     function avatar(){
    	
    	$this->display();
    }
    
    function avatar_upload(){
    	$config=array(
    			'rootPath' => './'.C("UPLOADPATH"),
    			'savePath' => './avatar/',
    			'maxSize' => 3024000,
    			'saveName'   =>    array('uniqid',''),
    			'exts'       =>    array('jpg', 'png', 'jpeg'),
    			'autoSub'    =>    false,
    	);
    	$driver_type = sp_is_sae()?"Sae":'Local';
    	$upload = new \Think\Upload($config,$driver_type);//
    	$info=$upload->upload();
    	if ($info) {
    		$first=array_shift($info);
    		$file=$first['savename'];
    		$_SESSION['avatar']=$file;
    		$this->ajaxReturn(sp_ajax_return(array("file"=>$file),"上传成功！",1),"AJAX_UPLOAD");
    	} else {
    		$this->ajaxReturn(sp_ajax_return(array(),$upload->getError(),0),"AJAX_UPLOAD");
    	}
    }
    
    function avatar_update(){
    	if(!empty($_SESSION['avatar'])){
    		$targ_w = intval($_POST['w']);
    		$targ_h = intval($_POST['h']);
    		$x = $_POST['x'];
    		$y = $_POST['y'];
    		$jpeg_quality = 90;
    		
    		$avatar=$_SESSION['avatar'];
    		$avatar_dir=C("UPLOADPATH")."avatar/";
    		if(sp_is_sae()){
    			$src=C("TMPL_PARSE_STRING.__UPLOAD__")."avatar/$avatar";
    		}else{
    			$src = $avatar_dir.$avatar;
    		}
    		
    		$avatar_path=$avatar_dir.$avatar;
    		
    		
    		if(sp_is_sae()){
    			$img_data = sp_file_read($avatar_path);
    			$img = new \SaeImage();
    			$size=$img->getImageAttr();
    			$lx=$x/$size[0];
            	$rx=$x/$size[0]+$targ_w/$size[0];
            	$ty=$y/$size[1];
            	$by=$y/$size[1]+$targ_h/$size[1];
    			
    			$img->crop($lx, $rx,$ty,$by);
    			$img_content=$img->exec('png');
    			sp_file_write($avatar_dir.$avatar, $img_content);
    		}else{
    			$image = new \Think\Image();
    			$image->open($src);
    			$image->crop($targ_w, $targ_h,$x,$y);
    			$image->save($src);
    		}
    		
    		$userid=sp_get_current_userid();
    		$result=$this->users_model->where(array("id"=>$userid))->save(array("avatar"=>$avatar));
    		$_SESSION['user']['avatar']=$avatar;
    		if($result){
    			$this->success("头像更新成功！");
    		}else{
    			$this->error("头像更新失败！");
    		}
    		
    	}
    }
    function application(){
    	$isapp=$this->application_obj->where(array('user_id'=>sp_get_current_userid()))->find();
        $this->assign('isapp',$isapp);
        $this->display(':application');
    }
   function application_post(){
     if(IS_POST){
     	 $data['user_id']=sp_get_current_userid(); 
         $data['t_name']=$_POST['t_name'];
         $data['zigezheng']=$_POST['zigezheng'];
         $data['state']=0;
         $data['addtime']=date('Y-m-d H:i:s');
         if(empty($data['t_name'])){
			 $this->error("请填写用户名！");
		 }
		 if(empty($data['zigezheng'])){
			 $this->error("请上传职称证书！");
		 }
         $result=$this->application_obj->add($data);
			if ($result) {
				
					$this->success("提交成功！");
				}else{
					$this->error("提交失败！");
				}			
        }

    }
	function myeaxm(){
		$userid=sp_get_current_userid();
		$count=$this->userpapers_obj->where(array('userid'=>$userid))->count();
		$page = $this->page($count, 10);
		$myexam=$this->userpapers_obj->limit($page->firstRow . ',' . $page->listRows)->where(array('userid'=>$userid))->select();
		foreach($myexam as $n=> $val){           
            $myexam[$n]['title']=$this->papers_obj->where(array('id'=>$myexam[$n]['papersid']))->getField('title');
			$myexam[$n]['cs_id']=$this->papers_obj->where(array('id'=>$myexam[$n]['papersid']))->getField('cs_id');
	      }  
		$this->assign("Page", $page->show('Admin'));
		$this->assign("myexam", $myexam);
        $this->display(':myexam');
	}
	function myerrors(){
		$userid=sp_get_current_userid();
		$myerrorids=json_decode($this->myerrors->where(array('uid'=>$userid))->getField('shitiid'));
		if($myerrorids){
			$result=1;
			$ids=join(",",$myerrorids);
			$count=$this->shiti_obj->where("id in ($ids)")->count();
			$page = $this->page($count, 10);
			$myerrors=$this->shiti_obj->limit($page->firstRow . ',' . $page->listRows)->where("id in ($ids)")->select();
			$this->assign("Page", $page->show('Admin'));
			$this->assign("myerrors", $myerrors);
		}else{
			$result=0;
		}
		$this->assign("result", $result);
        $this->display(':myerrors');
	}
       
}