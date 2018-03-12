<?php
namespace Course\Controller;
use Common\Controller\HomebaseController;
header("Content-Type: text/html; charset=utf-8");
class CourseController extends HomebaseController {
	protected $course_obj;
	protected $courseview_obj;
	protected $coursetype_obj;
	protected $usercourse_obj;
	protected $section_obj;
	protected $order_obj;
	protected $user_obj;
	protected $label_obj;
	protected $user_favorites_obj;
	function _initialize() {
		parent::_initialize();
		vendor('Alipay.Corefunction');
        vendor('Alipay.Md5function');
        vendor('Alipay.Notify');
        vendor('Alipay.Submit');
		$this->course_obj = D("Common/Course");
		$this->coursetype_obj = D("Common/coursetype");
		$this->section_obj = D("Common/Section");
		$this->courseview_obj = D("Common/CourseView");
		$this->usercourse_obj = D("Common/Usercourse");
		$this->order_obj = D("Common/Order");
		$this->user_obj = D("Common/Users");
		$this->label_obj = D("Common/Label");
		$this->live_obj = D("Common/Live");
		$this->material_obj = D("Common/Material");
		$this->user_favorites_obj = D("Common/user_favorites");
		$this->teacher_order = D("Common/Teacher_order");
		$this->chat_msg = D("Common/Chatmsg");
		$this->papers_obj = D("Common/Exam_papers");
		$this->userpapers_obj = D("Common/Exam_userpapers");
	}
	public function coursecenter(){
		$topid=intval(I("get.topid"));
		$childid= intval(I("get.childid"));
		$labelid= intval(I("get.labelid"));
		
		$topmap=empty($topid)?array("cs_state=1" ):array("cs_state = 1 and top_id=$topid");
		$childmap=empty($childid)?array("cs_state=1" ):array("cs_state = 1 and ty_id=$childid");
		$labelmap=empty($labelid)?array("cs_state=1" ):array("cs_state = 1 and labelid=$labelid");
		
		if(!empty($topid)){
			$map=$topmap;
		}
		if(!empty($childid)){
			$map=$childmap;
		}
		if(!empty($labelid)){
			$map=$labelmap;
		}
		$toptype=$this->coursetype_obj->where('parent=0')->select();
		if(!empty($topid))
		{
			$childtype=$this->coursetype_obj->where('parent=\''.$topid.'\'')->select();		
		}
	    if(!empty($childid))
		{
			$label=$this->label_obj->where('c_id=\''.$childid.'\'')->select();	
		}
		$count=$this->course_obj->where($map)->count();
		$page = $this->page($count, 16);
		$csdata=$this->course_obj->limit($page->firstRow . ',' . $page->listRows)->order(array("id"=>"desc"))->where($map)->select();
		foreach($csdata as $n=> $val){
			$csdata[$n]['xueyuannum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count()+$val['cs_xuni'];
			$csdata[$n]['pinglununm']=$this->usercourse_obj->where(array('course_id'=>$val['id'],'pinglun'=>array('NEQ','NULL')))->count();
		}
		$this->assign("topid",$topid);
		$this->assign("childid",$childid);
		$this->assign("labelid",$labelid);
		$this->assign("toptype",$toptype);
		$this->assign("childtype",$childtype);
		$this->assign("label",$label);
		
		$this->assign("csdata",$csdata);
		$this->assign("typeid",$c_id);
		$this->assign("label_id",$label_id);
		$this->assign("name",$tyname['name']);
		$this->assign("Page", $page->show('Admin'));
	    $this->display();
	}
	public function search(){
		if(IS_POST){
			$key=I("post.keywords");
			if(empty($key)){
				$map['cs_state'] = 1;
			}else{
				$map['cs_state'] = 1;
				$map['cs_name'] = array('like','%'.$key.'%');
			}
			$count=$this->course_obj->where($map)->count();
			$page = $this->page($count, 16);
			$course = $this->course_obj->where($map)->select();
			$this->assign("course",$course);
			$this->assign("Page", $page->show('Admin'));
			$this->display();
		}
		
	}
	public function  selectcourse(){
	   $type_id=I("get.id");
       $course = $this->course_obj->order(array("id"=>"asc"))->where(array('ty_id'=>$type_id))->select();
       $json_string = json_encode($course);
       echo $json_string;
		
	}
	public function courseinfo(){
		$livetype=C('livetype');
		$is_zhang=true;
		$c_id=  intval(I("get.id"));
		if($c_id==''){
		  $this->display('error');
		  exit();
		}
		$cs_data=$this->course_obj->where("id=$c_id")->find();
		$teacher=$this->user_obj->where(array('id'=>$cs_data['cs_teacher']))->find();
		$course_type=$this->coursetype_obj->where(array('term_id'=>$cs_data['ty_id']))->find();
		$map['user_id']=sp_get_current_userid();
		$map['course_id']=$c_id;
		if($buyinfo=$this->usercourse_obj->where($map)->find()){
		    $isbuy=1;
		    if($buyinfo['pinglun']==''){
		    	$ispinglun=0;
		    }else{
		    	$ispinglun=1;
		    	$mypinglun=$buyinfo;
		      }
		}else{
			$isbuy=0;
		}
		if($cs_data['cs_price']==0){
		    $isfree=0;
		}else{
		    $isfree=1;
		}
		$check=$this->usercourse_obj->where(array("user_id"=>$map['user_id'],"course_id"=>$c_id))->find();
	    $urlArr = explode("|",$check['studied']);
		
		$sc_list=$this->section_obj->where(array('cs_id'=>$c_id,'type_id'=>1,'state'=>1))->order('id asc')->select();
		$exam=$this->papers_obj->where(array('cs_id'=>$c_id,'state'=>1))->order('id asc')->select();
		foreach($exam as $n=> $val){
			if($this->userpapers_obj->where(array('userid'=>$map['user_id'],'papersid'=>$exam[$n]['id']))->find()){
				$exam[$n]['ustate']=1;
			}else{
				$exam[$n]['ustate']=0;
			}
		}
		foreach($sc_list as $n=> $val){
	    	$sc_list[$n]['voo']=$this->section_obj->where(array('cs_id'=>$c_id,'zhang_id'=>$sc_list[$n]['id'],'state'=>1))->order('id asc')->select();	    	
			
		}
		if(empty($sc_list)){
		   $now=date('Y-m-d H:i:s');
		   $sc_list=$this->section_obj->where(array('cs_id'=>$c_id,'type_id'=>0,'state'=>1))->order('id asc')->select();
		   foreach($sc_list as $n=> $val){
				$sc_list[$n]['channelid']=$this->live_obj->where('sectionid=\''.$val['id'].'\'')->getField('channelid');    	
		   }
		   $is_zhang=false;
		   
		   if($cs_data['course_type']=='live'){
			   
				if($livetype=='qcloudlive'){
					$HttpUrl="live.api.qcloud.com";
					$HttpMethod="GET"; 
					$isHttps =true;
					$secretKey=C('SecretKey');
					$COMMON_PARAMS = array(
						'Nonce'=> rand(),
						'Timestamp'=>time(NULL),
						'Action'=>'DescribeLVBChannel',
						'SecretId'=> C('SecretId'),
					);
					
					foreach($sc_list as $n=> $val){
						$PRIVATE_PARAMS = array(
						'channelId'=>$val['channelid'],
					   );
					$result=$this->CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps);
					$res=json_decode($result,true);
					if($res.code==0){
						$sc_list[$n]['livestate']=$res['channelInfo']['0'][channel_status];
					}else{
						$sc_list[$n]['livestate']='';
					}
					
				   }
				}else{
					$token=$this->gettoken();
					$bizCode='IPVULL';
					$url='http://open.wsview.com:8090/iWSViewPortalData?';
					$username=C('wsviewname');
					foreach($sc_list as $n=> $val){
						$liveID=$sc_list[$n]['channelid'];
						$postdata = "bizCode=".$bizCode."&userName=".$username."&token=".$token.'&pReqVULL.liveID='.$liveID;
						$curl = curl_init(); 
						curl_setopt($curl, CURLOPT_URL, $url); 
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
						curl_setopt($curl, CURLOPT_POST, 1); 
						curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
						$data = curl_exec($curl); 
						$xml = simplexml_load_string($data);
						$data = json_decode(json_encode($xml),TRUE);
						$state=$data['contUL'];
						$sc_list[$n]['livestate']=$state['liveStatus'];
						
					}
				} 
		   }
		}
		$map2['course_id']=$c_id;
		if (sp_get_current_userid()!=''){
		  $map2['user_id']=array('not in',sp_get_current_userid());
		}
		$pinglunlist=$this->usercourse_obj->where($map2)->select();
	     foreach($pinglunlist as $n=> $val){
			$pinglunlist[$n]['avatar']=$this->user_obj->where('id=\''.$val['user_id'].'\'')->getField('avatar');
		}
		$buynum=$this->usercourse_obj->where(array("course_id"=>$c_id))->count()+$cs_data['cs_xuni'];
		
		$newstud=$this->usercourse_obj->order('id desc')->where(array("course_id"=>$c_id))->limit(15)->select();
	    foreach($newstud as $n=> $val){
			$newstud[$n]['avatar']=$this->user_obj->where('id=\''.$val['user_id'].'\'')->getField('avatar');
			$newstud[$n]['user_nicename']=$this->user_obj->where('id=\''.$val['user_id'].'\'')->getField('user_nicename');
		}
		$dongtai=$this->usercourse_obj->order('id desc')->limit(10)->select();
		foreach($dongtai as $n=>$val){
		    $dongtai[$n]['username']=$this->user_obj->where('id=\''.$val['user_id'].'\'')->getField('user_nicename');
			$dongtai[$n]['coursename']=$this->course_obj->limit(6)->where('id=\''.$val['course_id'].'\'')->getField('cs_name');
			$dongtai[$n]['courseid']=$this->course_obj->limit(6)->where('id=\''.$val['course_id'].'\'')->getField('id');
		 }
	
		$name=$cs_data[cs_name];
		$material=$this->material_obj->where(array('cs_id'=>$c_id))->select();
		$favorite=$this->user_favorites_obj->where(array('uid'=>sp_get_current_userid(),'object_id'=>$c_id))->find();
		$this->assign("buynum",$buynum);
		$this->assign("dongtai",$dongtai);
		$this->assign("newstud",$newstud);
		$this->assign("teacher",$teacher);
		$this->assign("pinglunlist",$pinglunlist);
		$this->assign("mypinglun",$mypinglun);
		$this->assign("c_id",$c_id);
		$this->assign("u_id",sp_get_current_userid());
		$this->assign("ispinglun",$ispinglun);
	    $this->assign("isfree",$isfree);
		$this->assign("isbuy",$isbuy);
		$this->assign("cs_data",$cs_data);
		$this->assign("sc_list",$sc_list);
		$this->assign("name",$name);
		$this->assign("course_type",$course_type);
		$this->assign("buyinfo",$buyinfo);
		$this->assign("material",$material);
		$this->assign("favorite",$favorite);
		$this->assign("exam",$exam);
		
		if($is_zhang){
			$this->display(courseinfo);
		}else{
			$this->display('courseinfo1');
		}
		
	}
	
	function downmaterial(){
	 $this->check_login();
	 $id=  intval(I("get.id"));
	 $data=$this->material_obj->where(array('id'=>$id))->find(); 
     $file_name = $data['downname']; 
     $file_dir =$data['url'];  
     $file = @ fopen($file_dir,"r"); 
	 
     if (!$file) { 
         echo "文件找不到"; 
      } 
      else { 
	     ob_start(); 
		 
         $filename=$data['url'];
         header( "Content-type:  application/octet-stream "); 
         header( "Accept-Ranges:  bytes "); 
         header( "Content-Disposition:  attachment;  filename= $filename"); 
         $size=readfile($filename); 
         header( "Accept-Length: " .$size);
	  
	   }
	 
      }
     public function favorite(){
      if(IS_POST){ 
	    $map['user_id']=sp_get_current_userid();
		$map['course_id']=(int)$_POST['cid'];
	    if($buyinfo=$this->usercourse_obj->where($map)->find()){
			exit();
		}
    	$id = (int)$_POST['id']; 
		$data['object_id']=(int)$_POST['cid'];
    	$data['uid']=sp_get_current_userid();
    	$model = M('user_favorites'); 
    	if(empty($id)){
			
    		$model->add($data); 
    	}else{
			$model->where(array('id'=>$id))->delete(); 
    		}
        }
    }
	public function pinglunadd(){
		$this->check_login();
	   $cid=  intval(I("post.c_id"));
	   $user_id=sp_get_current_userid();
	   $content=I("post.pinglun");
	   $data['pinglun'] =  $content;
	   $data['pingluntime']=date('Y-m-d H:i:s');
	   if(empty($content)){
	       $this->error('请填写评论内容！');
	   }
       if($this->usercourse_obj->where(array('course_id'=>$cid,'user_id'=>$user_id))->save($data)){
           $this->success('评论成功！');
       }
	}
	public function buycourse(){
	    $id=  intval(I("get.id"));
	    $cs_data=$this->course_obj->where("id=$id")->find();
	    if($cs_data['cs_price']==0){
	      $this->assign("cs_data",$cs_data);
	      $this->display(buycourse_free);
	    }else{
	    $this->assign("cs_data",$cs_data);
	    $this->display(buycourse);
	    }
	}
	public function order(){
		$this->check_login();
		$id=  intval(I("get.id"));
	    $cs_data=$this->course_obj->where("id=$id")->find();
	    $this->assign("cs_data",$cs_data);
	    $this->display();
	}
	public function payorder(){
		$this->check_login();
	    $data['uid']=  I("get.uid");
	    $data['cid']=  I("get.cid");
	    $out_trade_no=I("get.cn");
	    $cs_data=$this->course_obj->where(array('id'=>$data['cid']))->find();
	    $this->assign("data",$data);
	    $this->assign("out_trade_no",$out_trade_no);
	    $this->assign("cs_data",$cs_data);
	    $this->display();
	}
	public function createorder(){
		$this->check_login();
		$id=  intval(I("get.id"));
	    $cs_data=$this->course_obj->where("id=$id")->find();
	    if($cs_data['cs_price']==0){
	      $this->assign("cs_data",$cs_data);
	      $this->display(buycourse_free);
	    }else{
	      
   	    $out_trade_no = date('Ymdhms').rand(100,999);
   	    $userid=sp_get_current_userid();
		$course_id=  intval(I("get.id"));
		$cs_data=$this->course_obj->where(array("id"=>$course_id))->find();
		$user=$this->user_obj->where(array("id"=>$userid))->find();
		$order['user_id']=sp_get_current_userid();
		$order['order']=$out_trade_no;
		$order['course_id']=$course_id;
		$order['state']=2;
		$order['total']=$cs_data['cs_price'];
		$order['addtime']=date('Y-m-d H:i:s');
		$check=$this->order_obj->where(array("user_id"=>$userid,"course_id"=>$course_id))->find();
		if(!$check){
			$this->order_obj->add($order);
			$this->assign("out_trade_no",$out_trade_no);
		}else{
		    $this->assign("out_trade_no",$check['order']);
		}
	    $this->assign("cs_data",$cs_data);
	    $this->assign("user",$user);
	    $this->assign("course_id",$course_id);
	    $this->display();
	    }
	   
	}
	public function myorder(){
		$this->check_login();
		$userid=sp_get_current_userid();
		$order=$this->order_obj->where(array("user_id"=>$userid))->order('addtime desc')->select();
		$count=$this->order_obj->where(array("user_id"=>$userid))->count();
		foreach($order as $n=> $val){  
			$course= $this->course_obj->where(array("id"=>$order[$n][course_id]))->find();        
            $order[$n]['course_name']=$course['cs_name'];
	      }  
	    $this->assign("order",$order);
	    $this->display();
	}
   
	public function myclass(){
		$this->check_login();
		$c_id=  intval(I("get.id"));
		$cs_data=$this->course_obj->where("id=$c_id")->find();
		$lession=$this->section_obj->where(array("cs_id"=>$cs_data['id']))->select();
		$this->assign("cs_data",$cs_data);
		$this->assign("lession",$lession);
		$this->display();
	}
	public function study(){
		
	    $c_id=  intval(I("get.id"));
		$lession=$this->section_obj->where(array("id"=>$c_id))->find();
		$map['user_id']=sp_get_current_userid();
		$map['course_id']=$lession['cs_id'];
		$type=$this->course_obj->where(array("id"=>$lession['cs_id']))->getField('course_type');
		$teacherid=$this->course_obj->where(array("id"=>$lession['cs_id']))->getField('cs_teacher');
		$sc_list=$this->section_obj->where(array('cs_id'=>$lession['cs_id'],'type_id'=>1,'state'=>1))->order('id asc')->select();
		$psc_list=$this->section_obj->where(array('cs_id'=>$lession['cs_id'],'type_id'=>0,'state'=>1))->order('id asc')->select();
		$yuntype=C('yuntype');
		foreach($sc_list as $n=> $val){
	    	$sc_list[$n]['voo']=$this->section_obj->where(array('cs_id'=>$lession['cs_id'],'zhang_id'=>$sc_list[$n]['id'],'state'=>1))->order('id asc')->select();	    	
		    $is_zhang=true;
		}
		
		$lession['pic']=$this->course_obj->where(array("id"=>$lession['cs_id']))->getField('cs_picture');
		$lession['csname']=$this->course_obj->where(array("id"=>$lession['cs_id']))->getField('cs_name');
		if(empty($sc_list)){
		   $sc_list=$this->section_obj->where(array('cs_id'=>$lession['cs_id'],'type_id'=>0,'state'=>1))->order('id asc')->select();
		   $count=$this->section_obj->where(array('cs_id'=>$lession['cs_id'],'type_id'=>0,'state'=>1))->order('id asc')->count();
		   $is_zhang=false;
		}
		if($data=$this->usercourse_obj->where($map)->find() or $map['user_id']==$teacherid){
			$isbuy=1;
		}else{
			$isbuy=2;
		}
		if($type=='normal'){
			$yuouxiaoqi=$this->course_obj->where(array("id"=>$lession['cs_id']))->getField('youxiaoqi');
			$end=subDate($yuouxiaoqi,$data['addtime']);
			if((strtotime($end)-strtotime(date('Y-m-d H:i:s')))<0){
				$isover=true;
			}else{
				$isover=false;
			}
			$this->assign("isover",$isover);
			$this->assign("is_zhang",$is_zhang);
			$this->assign("isbuy",$isbuy);
			$this->assign("psc_list",$psc_list);
			$this->assign("sc_list",$sc_list);
		    $this->assign("lession",$lession);
			$this->assign("cid",$c_id);
			$this->assign("count",$count);
			$this->display();
		}
		if($type=='live'){
			$livetype=C('livetype');
			$channel_id=$this->live_obj->where(array("sectionid"=>$lession['id']))->getField('channelid');
			$appid=C("AppId");
			if($livetype=='qcloudlive'){
				$now=date('Y-m-d H:i:s');
				$start=$lession['live_starttime'];
				$channelid=$this->live_obj->where(array('sectionid'=>$c_id))->getField('channelid');
				$HttpUrl="live.api.qcloud.com";
				$HttpMethod="GET"; 
				$isHttps =true;
				$secretKey='QzDgxMDboZMP17NhwY0aN3oVse0FoLG9';
				$COMMON_PARAMS = array(
					'Nonce'=> rand(),
					'Timestamp'=>time(NULL),
					'Action'=>'DescribeLVBChannel',
					'SecretId'=> C('SecretId'),
				);
				$PRIVATE_PARAMS = array(
					'channelId'=>$channelid,
				   );
				$result=$this->CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps);
				$res=json_decode($result,true);
				if($res.code==0){
					$isover=$res['channelInfo']['0'][channel_status];
				}
				if(strtotime($now)>=strtotime($start) or $res['channelInfo']['0'][channel_status]==1){
					 $isstrat=true;
				 }else{
					 $isstrat=false;
				 }
				 $this->assign("is_zhang",$is_zhang);
				$this->assign("sc_list",$sc_list);
				$this->assign("isbuy",$isbuy);
				$this->assign("lession",$lession);
				$this->assign("isover",$isover);
				$this->assign("isstrat",$isstrat);
				$this->assign("channel_id",$channel_id);
				$this->assign("appid",$appid);
				$this->assign("count",$count);
				$this->assign("uid",$map['user_id']);
				$this->display('zhibo');
			
					
			}else{
				$now=date('Y-m-d H:i:s');
				$start=$lession['live_starttime'];
				$token=$this->gettoken();
				$bizCode='IPVULL';
				$url='http://open.wsview.com:8090/iWSViewPortalData?';
				$username=C('wsviewname');
				$postdata = "bizCode=".$bizCode."&userName=".$username."&token=".$token.'&pReqVULL.liveID='.$channel_id;
				$curl = curl_init(); 
				curl_setopt($curl, CURLOPT_URL, $url); 
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
				curl_setopt($curl, CURLOPT_POST, 1); 
				curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
				$data1 = curl_exec($curl); 
				$xml = simplexml_load_string($data1);
				$data1 = json_decode(json_encode($xml),TRUE);
				$state=$data1['contUL'];
				if($state['resultCode']==0){
					$isover=$state['liveStatus'];
				}
				if(strtotime($now)>=strtotime($start) or $state['liveStatus']==1){
					 $isstrat=true;
				 }else{
					 $isstrat=false;
				 }
				$src='http://www.wsview.com/yzplayerAction!play2.action?autoPlay=false&playType=uLive&userVideoID='.$channel_id.'&iframe=iframe';
				$this->assign("src",$src);
				$this->assign("is_zhang",$is_zhang);
				$this->assign("sc_list",$sc_list);
				$this->assign("isbuy",$isbuy);
				$this->assign("lession",$lession);
				$this->assign("isover",$isover);
				$this->assign("isstrat",$isstrat);
				$this->assign("channel_id",$channel_id);
				$this->assign("appid",$appid);
				$this->assign("count",$count);
				$this->display('wsview');
				
			}
			
		}
		if($type=='doc'){
			$yuouxiaoqi=$this->course_obj->where(array("id"=>$lession['cs_id']))->getField('youxiaoqi');
			$end=subDate($yuouxiaoqi,$data['addtime']);
			if((strtotime($end)-strtotime(date('Y-m-d H:i:s')))<0){
				$isover=true;
			}else{
				$isover=false;
			}
			$lession['doccontent']=htmlspecialchars_decode($lession['doccontent']);
			$this->assign("isover",$isover);
			$this->assign("is_zhang",$is_zhang);
			$this->assign("isbuy",$isbuy);
			$this->assign("psc_list",$psc_list);
			$this->assign("sc_list",$sc_list);
		    $this->assign("lession",$lession);
			$this->display("docstudy");
		}
		
	}  
	function video(){
		$id=$_GET['sid'];
		$data = $this->section_obj->getById ($id );
		echo $data['yun_url'];
		
	}
	function chekbuy(){
		$id=I('post.id');
		$section = $this->section_obj->where(array('id'=>$id))->find();
		$teacherid=$this->course_obj->where(array('id'=>$section['cs_id']))->getField('cs_teacher');
		$userid=sp_get_current_userid();
		$result=$this->usercourse_obj->where(array("course_id"=>$section['cs_id'],'user_id'=>$userid))->find();
		if($result){
			$res['isbuy']=1;
		}else{
			$res['isfree']=$section['is_free'];
			if($teacherid==$userid){
			  $res['isteacher']=1;
			}
		}
		echo json_encode($res);
	}
	public function play(){
		$this->check_login();
	    $id=  intval(I("get.id"));
	    $section=$this->section_obj->where(array("id"=>$id))->find();
	    
	}
	public  function studied(){
	   $sc_id=  intval(I("post.sc_id"));
	   $cs_id=  intval(I("post.cs_id"));
	   $userid=sp_get_current_userid();
	   $check=$this->usercourse_obj->where(array("user_id"=>$userid,"course_id"=>$cs_id))->find();
	   $urlArr = explode("|",$check['studied']);  
	  if(!in_array($sc_id ,$urlArr)){                
             $data['studied'] =$check['studied'].$sc_id.'|';
             $this->usercourse_obj->where(array("user_id"=>$userid,"course_id"=>$cs_id))->save($data);  
            }
		$this->success('设置成功！');	
     	}
    public function pay_free (){
        $c_id=  intval(I("get.id"));
        $userid=sp_get_current_userid();
        $cs_data=$this->course_obj->where("id=$c_id")->find();
        $check=$this->usercourse_obj->where(array("user_id"=>$userid,"course_id"=>$c_id))->find();
		if($userid==''){
				$this->error("请登陆！",U("User/Login/index"));
			}
        if($cs_data['cs_price']==0){
        	if($check){
        		$this->error('您已经购买了此课程，请不要重复购买');
        	}else{
        		$c_data['user_id']=$userid;
	    	    $c_data['course_id']=$c_id;
	    	    $c_data['addtime']=date('Y-m-d H:i:s');
	    	    $c_data['state']=1;
             	$this->usercourse_obj->add($c_data);
             	$this->success('添加成功');
        	}
        }else{
         $this->error('此课程不是免费课程，请到前台购买');
        }
    }  
	public function payment(){
		$this->check_login();
	    $payment=I("post.payment");
	    if($payment==''){
	    	$this->error('请选择支付方式！');
	    	exit();
	    }
	   
	    if($payment=='alipay'){
	    	$this->payWithAlipay(); 
	    }
	    if($payment=='wxpay'){
	    	$this->error('还未开发，敬请期待！');
	    }
	    if($payment=='yuepay'){
	    	if(IS_POST){
	    	$c_id=  intval(I("get.id"));
	    	$cs_data=$this->course_obj->where("id=$c_id")->find();
	    	$userid=sp_get_current_userid();
	    	$user=$this->user_obj->where(array("id"=>$userid))->find();
	    	$totalmoney=$_POST['totalmoney'];
	    	$out_trade_no=$_POST['orderId'];
	    	$this->assign("totalmoney",$totalmoney);
	    	$check=$this->usercourse_obj->where(array("user_id"=>$userid,"course_id"=>$_POST['courseid']))->find();
	    	if(!$check){
	    	  if($user['coin']<$_POST['totalmoney']){
	    		$result=0;
	    		$this->assign("result",$result);
	    		$this->assign("cs_data",$cs_data);
	    		$this->assign("out_trade_no",$out_trade_no);
	    		$this->display(":Course/doyue");
	    	  }else{
	    		$result=1;
	    	    $u_data['coin']=($user['coin'])-($totalmoney);
	    	    $o_data['state']=1;
	    	    $orderId=$_POST['orderId'];
	    	    $this->order_obj->where(array("order"=>$orderId))->save($o_data);
	    	    $this->user_obj->where(array("id"=>$userid))->save($u_data);
	    	    $c_data['user_id']=$userid;
	    	    $c_data['course_id']=$_POST['courseid'];
	    	    $c_data['addtime']=date('Y-m-d H:i:s');
	    	    $c_data['state']=1;
	    	    $c_data['teacher_id']=$cs_data['cs_teacher'];
	    	    $c_data['course_price']=$cs_data['cs_price'];
	    	    $c_id=$_POST['courseid'];
	    	    $sailes['u_id']=$cs_data['cs_teacher'];
	    	    $sailes['c_id']=$_POST['courseid'];
	    	    $sailes['money']=round($totalmoney*C('cardbili') ,2);
	    	    $sailes['addtime']=date('Y-m-d H:i:s');
	    	    $this->teacher_order->add($sailes);
				$this->usercourse_obj->add($c_data);
				$this->user_favorites_obj->where(array('uid'=>$userid,'object_id'=>$c_id))->delete();
	    	    $this->assign("result",$result);
	    	    $this->assign("out_trade_no",$out_trade_no);
	    	    $this->assign("cs_data",$cs_data);
	    	    $this->assign("yue",$u_data['coin']);
	    	    $this->assign("c_id",$c_id);
	    	    $this->display(":Course/doyue");
	    	  }
	    	}else{
	    	   $result=2;
	    	   $this->assign("cs_data",$cs_data);
	    	   $this->assign("out_trade_no",$out_trade_no);
	    	   $this->assign("result",$result);
	    	   $this->display(":Course/doyue");
	    	}
	      }
	    }
	}
	function payWithAlipay(){
	     $this->check_login();
         $alipay_config=array(
           'partner' => C('partner'),
           'key' => C('key'),
           'sign_type' => C('sign_type'),
           'input_charset' => C('input_charset'),
           'cacert' => C('cacert'),
           'transport' => 'http',
         );
        $payment_type = "1"; 
        $notify_url = C('notify_url'); 
        $return_url = C('return_url'); 
        $seller_email = C('seller_email');
        $out_trade_no = $_POST['orderId'];
        $subject = $_POST['ordsubject'];  
        $total_fee = $_POST['totalmoney']; 
        $body = $_POST['ordbody'];  
        $show_url = $_POST['ordshow_url'];  
        $anti_phishing_key = "";
        $exter_invoke_ip = get_client_ip(); 
  
      $parameter = array(
        "service" => "create_direct_pay_by_user",
        "partner" => trim($alipay_config['partner']),
        "payment_type"    => $payment_type,
        "notify_url"    =>$notify_url,
        "return_url"    => $return_url,
        "seller_email"    => $seller_email,
        "out_trade_no"    => $out_trade_no,
        "subject"    => $subject,
        "total_fee"    => $total_fee,
        "body"            => $body,
        "show_url"    => $show_url,
        "anti_phishing_key"    => $anti_phishing_key,
        "exter_invoke_ip"    => $exter_invoke_ip,
        "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
        );	
        $alipaySubmit = new \ AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"post", "确认");
        echo $html_text;
	}
    function notifyurl(){
             
		$alipay_config=array(
           'partner' => C('partner'),
           'key' => C('key'),
           'sign_type' => C('sign_type'),
           'input_charset' => C('input_charset'),
           'cacert' => C('cacert'),
           'transport' => 'http',
         );
        $alipayNotify = new  \  AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if($verify_result) {
              
           $out_trade_no   = $_POST['out_trade_no'];      
           $trade_no       = $_POST['trade_no'];         
           $trade_status   = $_POST['trade_status'];     
           $total_fee      = $_POST['total_fee'];        
           $notify_id      = $_POST['notify_id'];         
           $notify_time    = $_POST['notify_time'];       
           $buyer_email    = $_POST['buyer_email']; 
		   $body           = $_POST['body'];  		   
           $parameter = array(
             "out_trade_no"     => $out_trade_no, 
             "trade_no"         => $trade_no,    
             "total_fee"        => $total_fee,   
             "trade_status"     => $trade_status, 
             "notify_id"        => $notify_id,    
             "notify_time"      => $notify_time,  
             "buyer_email"      => $buyer_email, 
			 "body"             => $body, 
           );
           if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {		   
     		   if(!checkorderstatus($out_trade_no)){
				orderhandle($parameter);  
               $cs_data=$this->course_obj->where("id=$body")->find();
			   $c_data['user_id']=sp_get_current_userid();
	    	   $c_data['course_id']=$body;
	    	   $c_data['addtime']=date('Y-m-d H:i:s');
	    	   $c_data['state']=1;
	    	   $c_data['teacher_id']=$cs_data['cs_teacher'];
	    	   $c_data['course_price']=$total_fee;
	    	  
	    	    $sailes['u_id']=$cs_data('cs_teacher');
	    	    $sailes['c_id']=$body;;
	    	    $sailes['money']=round($total_fee*C('alipaybili') ,2); 
	    	    $sailes['addtime']=date('Y-m-d H:i:s');
	    	    $this->teacher_order->add($sailes);
			    $this->usercourse_obj->add($c_data);
			   M(User_favorites)->where(array('object_id'=>$c_data['course_id']))->delete();
               }
            }
            echo "success";      
         }else {
				
                echo "fail";
        }    
    }
    function returnurl(){
        $alipay_config=array(
           'partner' => C('partner'),
           'key' => C('key'),
           'sign_type' => C('sign_type'),
           'input_charset' => C('input_charset'),
           'cacert' => C('cacert'),
           'transport' => 'http',
         );
        $alipayNotify = new  \ AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if($verify_result) {
			  
			$out_trade_no   = $_GET['out_trade_no'];     
			$trade_no       = $_GET['trade_no'];        
			$trade_status   = $_GET['trade_status'];     
			$total_fee      = $_GET['total_fee'];       
			$notify_id      = $_GET['notify_id'];        
			$notify_time    = $_GET['notify_time'];      
			$buyer_email    = $_GET['buyer_email'];      
			$body           = $_GET['body'];  
			$parameter = array(
				 "out_trade_no"     => $out_trade_no, 
				 "trade_no"         => $trade_no,    
				 "total_fee"        => $total_fee,   
				 "trade_status"     => $trade_status, 
				 "notify_id"        => $notify_id,    
				 "notify_time"      => $notify_time,  
				 "buyer_email"      => $buyer_email, 
				 "body"             => $body, 
			);
			if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
				if(!checkorderstatus($out_trade_no) || !$res=$this->usercourse_obj->where(array('user_id'=>sp_get_current_userid(),'course_id'=>$body))->find()){
				   orderhandle($parameter);  
				   $cs_data=$this->course_obj->where("id=$body")->find();
				   $c_data['user_id']=sp_get_current_userid();
				   $c_data['course_id']=$body;
				   $c_data['addtime']=date('Y-m-d H:i:s');
				   $c_data['state']=1;
				   $c_data['teacher_id']=$cs_data['cs_teacher'];
				   $c_data['course_price']=$total_fee;
					$sailes['u_id']=$cs_data['cs_teacher'];
					$sailes['c_id']=$body;;
					$sailes['money']=round($total_fee*0.5 ,2); 
					$sailes['addtime']=date('Y-m-d H:i:s');
					$this->teacher_order->add($sailes);
					$this->usercourse_obj->add($c_data);
					M(User_favorites)->where(array('object_id'=>$c_data['course_id']))->delete();
					 
				 }
				 
			    $this->redirect(C('successpage'));
			 }else {
				 echo "trade_status=".$_GET['trade_status'];
				 $this->redirect(C('errorpage'));
			 }
		}else {
 
			echo "支付失败！";
		}
	}
    function zhibo(){
		$appid=C('AppId');
		$this->assign("appid",$appid);
		$this->display();
	}
	function chatsent(){
		$userid=sp_get_current_userid();
		$data=array();
		$data['content']=$_POST['content'];
		$data['cs_id']=$_POST['cs_id'];
		$data['uid']=$userid;
		$data['channel_id']=$_POST['channel_id'];
		$data['time']=time();
		$data['timee']=date('Y-m-d H:i:s',time());
		$data['sender']=$this->user_obj->where(array('id'=>$userid))->getField('user_nicename');
		$data['pic']=$this->user_obj->where(array('id'=>$userid))->getField('avatar');
		$dd=$this->chat_msg->add($data);
		if($dd){
			$dataa=$this->chat_msg->where(array('cs_id'=>$data['cs_id']))->order('id desc')->limit('100')->select();
            if(!empty($dataa)){
			   echo json_encode($dataa);
			}
	   }
	}
		public function fresh(){
			$csid=$_GET['cs_id'];
			$data=$this->chat_msg->where(array('cs_id'=>$csid))->order('id desc')->limit('100')->select();
			if(!empty($data)){
				echo json_encode($data);
			}
			
		}
   
		function CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps){
		$FullHttpUrl = $HttpUrl."/v2/index.php";
		$ReqParaArray = array_merge($COMMON_PARAMS, $PRIVATE_PARAMS);
		ksort($ReqParaArray);
		$SigTxt = $HttpMethod.$FullHttpUrl."?";
		$isFirst = true;
		foreach ($ReqParaArray as $key => $value)
		{
			if (!$isFirst) 
			{ 
				$SigTxt = $SigTxt."&";
			}
         $isFirst= false;
			if(strpos($key, '_'))
			{
				$key = str_replace('_', '.', $key);
			}
        $SigTxt=$SigTxt.$key."=".$value;
		}
		$Signature = base64_encode(hash_hmac('sha1', $SigTxt, $secretKey, true));
		$Req = "Signature=".urlencode($Signature);
		foreach ($ReqParaArray as $key => $value)
		{
			$Req=$Req."&".$key."=".urlencode($value);
		}
		if($HttpMethod === 'GET')
		{
			if($isHttps === true)
			{
				$Req="https://".$FullHttpUrl."?".$Req;
			}
			else
			{
				$Req="http://".$FullHttpUrl."?".$Req;
			}
         // dump($Req);
			$Rsp = file_get_contents($Req);
            return ($Rsp );
		}
		else
		{
			if($isHttps === true)
			{
				$Rsp= SendPost("https://".$FullHttpUrl,$Req,$isHttps);
			}
			else
			{
				$Rsp= SendPost("http://".$FullHttpUrl,$Req,$isHttps);
			}
			 return ($Rsp );
		}
		
	}
	function SendPost($FullHttpUrl,$Req,$isHttps){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $Req);
        curl_setopt($ch, CURLOPT_URL, $FullHttpUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($isHttps === true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
        }
        $result = curl_exec($ch);
		if($result.code==0){
			$this->success('创建直播成功！');
		}
	}
	function gettoken(){
		$bizCode='IPUQXC';
		$username=C('wsviewname');
		$password=MD5(C('wsviewpass'));
		$url='http://open.wsview.com:8090/iWSViewPortalData?';
		$postdata = "bizCode=".$bizCode."&pReqQXC.userName=".$username."&pReqQXC.password=".$password; 
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($curl, CURLOPT_POST, 1); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
		$data = curl_exec($curl); 
		$xml = simplexml_load_string($data);
		$data = json_decode(json_encode($xml),TRUE);
		return($data['token']);
		curl_close($curl);
	}
}