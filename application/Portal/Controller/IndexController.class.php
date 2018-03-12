<?php
namespace Portal\Controller;
use Common\Controller\HomebaseController;

class IndexController extends HomebaseController {
	protected $course_obj;
	protected $coursetype_obj;
	protected $term_relationships_model;
	function _initialize() {
		parent::_initialize();
		$this->course_obj = D("Common/Course");
		$this->coursetype_obj = D("Common/Coursetype");
		$this->user_obj = D("Common/Users");
		$this->articletype_obj = D("Common/Terms");
		$this->post_obj = D("Common/Posts");
		$this->slide_obj = D("Common/Slide");
		$this->usercourse_obj = D("Common/Usercourse");
		$this->term_relationships_model = D("Portal/TermRelationships");
		$this->topic_obj = D("Common/Forum_topic");
	}
	public function index() {
		$cs_typelist=$this->coursetype_obj->where('parent=0')->select();
		$zx_courselist=$this->course_obj->order("id desc")->limit(12)->select();
		foreach($zx_courselist as $n=> $val){
			$zx_courselist[$n]['teacher']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('user_nicename');
			$zx_courselist[$n]['tpic']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('avatar');
			$zx_courselist[$n]['xueyuannum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count()+$val['cs_xuni'];
			$zx_courselist[$n]['pinglununm']=$this->usercourse_obj->where(array('course_id'=>$val['id'],'pinglun'=>array('NEQ','NULL')))->count();
		}
		$tuijian_courselist=$this->course_obj->where('is_tuijian=1')->order("id desc")->limit(12)->select();
		foreach($tuijian_courselist as $n=> $val){
			$tuijian_courselist[$n]['teacher']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('user_nicename');
			$tuijian_courselist[$n]['tpic']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('avatar');
			$tuijian_courselist[$n]['xueyuannum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count()+$val['cs_xuni'];
			$tuijian_courselist[$n]['pinglununm']=$this->usercourse_obj->where(array('course_id'=>$val['id'],'pinglun'=>array('NEQ','NULL')))->count();
		}
		
		$articlelist=$this->articletype_obj->limit(3)->select();
		foreach($articlelist as $n=> $val){
			$articlelist[$n]['voo']=$this->term_relationships_model
			->alias("a")
			->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
			->where('term_id=\''.$val['term_id'].'\'')
			->limit(7)
			->order("a.listorder ASC,b.post_modified DESC")->select();
		}
		$free_courselist=$this->course_obj->where('cs_price=0')->order("id desc")->limit(12)->select();
		foreach($free_courselist as $n=> $val){
			$free_courselist[$n]['teacher']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('user_nicename');
			$free_courselist[$n]['tpic']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('avatar');
			$free_courselist[$n]['xueyuannum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count()+$val['cs_xuni'];
			$free_courselist[$n]['pinglununm']=$this->usercourse_obj->where(array('course_id'=>$val['id'],'pinglun'=>array('NEQ','NULL')))->count();
		}
		foreach($cs_typelist as $n=> $val){
			$cs_typelist[$n]['voo']=$this->course_obj->order('id desc')->where('top_id=\''.$val['term_id'].'\'')->select();
		}
		$courselist=$this->course_obj->where(array('cs_price'=>array(gt,0),'course_type'=>'normal'))->order("id desc")->limit(8)->select();
		foreach($courselist as $n=> $val){
			$courselist[$n]['xueyuannum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count()+$val['cs_xuni'];
		}
		$hotcourselist=$this->course_obj->order("id desc")->select();
		foreach($hotcourselist as $n=> $val){
			$hotcourselist[$n]['xueyuannum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count()+$val['cs_xuni'];
		}
		$hotcourselist=$this->my_sort($hotcourselist,'xueyuannum',SORT_DESC,SORT_STRING);  
		$hotcourselist=array_slice($hotcourselist,0,8);
		$livecourselist=$this->course_obj->where(array('cs_price'=>array(gt,0),'course_type'=>'live'))->order("id desc")->limit(8)->select();
		$topic=$this->topic_obj->order('hits',DESC)->limit(12)->select();
		foreach($topic as $n=> $val){
			$topic[$n]['avatar']=$this->user_obj->where('id=\''.$val['userid'].'\'')->getField('avatar');
			$topic[$n]['username']=$this->user_obj->where('id=\''.$val['userid'].'\'')->getField('user_nicename');
		}
		$teacherlist=$this->user_obj->where(array('user_type'=>3,'user_status'=>1))->limit(4)->select();
		$slide=$this->slide_obj->where(array('slide_cid'=>1,'slide_status'=>1))->select();
		$mslide=$this->slide_obj->where(array('slide_cid'=>2,'slide_status'=>1))->select();
		$this->assign("tuijian_courselist",$tuijian_courselist);
		$this->assign("articlelist",$articlelist);
		$this->assign("free_courselist",$free_courselist);
		$this->assign("zx_courselist",$zx_courselist);
		$this->assign("cs_typelist",$cs_typelist);
		$this->assign("slide",$slide);
		$this->assign("teacherlist",$teacherlist);
		$this->assign("mslide",$mslide);
		$this->assign("courselist",$courselist);
		$this->assign("livecourselist",$livecourselist);
		$this->assign("hotcourselist",$hotcourselist);
		$this->assign("topic",$topic);
		$this->display(":index");
	}
	function my_sort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){   
        if(is_array($arrays)){   
            foreach ($arrays as $array){   
                if(is_array($array)){   
                    $key_arrays[] = $array[$sort_key];   
                }else{   
                    return false;   
                }   
            }   
        }else{   
            return false;   
        }  
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);   
        return $arrays;   
    }  
	public function article($status=1){
		$term_id= intval(I("get.termid"));
		$where=empty($term_id)?array("a.status=$status"):array("a.term_id = $term_id and a.status=$status");

		$term=$this->articletype_obj->select();
		$name=$this->articletype_obj->where(array('term_id'=>$term_id))->getField('name');
		$count=$article=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->where($where)
		->limit($page->firstRow . ',' . $page->listRows)
		->order("a.listorder ASC,b.post_modified DESC")->count();
		$page = $this->page($count, 6);
		$article=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->where($where)
		->limit($page->firstRow . ',' . $page->listRows)
		->order("a.listorder ASC,b.post_modified DESC")->select();
		$tuijian=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->where(array("recommended"=>1,'a.status'=>1))
		->limit('10')
		->order("a.listorder ASC,b.post_modified DESC")->select();
		$remen=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->order('post_hits DESC' )->where(array('a.status'=>1))
		->limit('10')
		->select();
		foreach($article as $n=> $val){
			$article[$n]['yue']=date("m",strtotime($article[$n]['post_date']));
			$article[$n]['ri']=date("d",strtotime($article[$n]['post_date']));
		}

		$this->assign("article",$article);
		$this->assign("remen",$remen);
		$this->assign("tuijian",$tuijian);
		$this->assign("term_id",$term_id);
		$this->assign("term",$term);
		$this->assign("name",$name);
		$this->assign("Page", $page->show('Admin'));
		$this->display(":article");

	}
	public function content($status=1){
		$article_id= intval(I("get.id"));
		$termid=intval(I("get.termid"));
		$posts_model=M("Posts");
		$term=M("Terms");
		$posts_model->save(array("id"=>$article_id,"post_hits"=>array("exp","post_hits+1")));
		$content=$posts_model->where(array('id'=>$article_id))->find();
		$tuijian=$article=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->where(array("recommended"=>1,'a.status'=>1))
		->limit('10')
		->order("a.listorder ASC,b.post_modified DESC")->select();
		$remen=$article=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->order('post_hits DESC' )->where(array("recommended"=>1,'a.status'=>1))
		->limit('10')
		->select();
		$termname=$term->where(array('term_id'=>$termid))->getField('name');
		$this->assign("termname",$termname);
		$this->assign("term_id",$termid);
		$this->assign("tuijian",$tuijian);
		$this->assign("remen",$remen);
		$this->assign("content",$content);
		$this->assign("name",$content['post_title']);
		$this->display(":content");
	}
}


