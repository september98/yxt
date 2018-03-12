<?php

/**
 * 后台Controller
 */
namespace Common\Controller;
use Common\Controller\AppframeController;

class AdminbaseController extends AppframeController {
	
	protected $page_size = 50;
	protected $batch_size = 10;

	public function __construct() {
	    hook('admin_begin');
		$admintpl_path=C("SP_ADMIN_TMPL_PATH").C("SP_ADMIN_DEFAULT_THEME")."/";
		C("TMPL_ACTION_SUCCESS",$admintpl_path.C("SP_ADMIN_TMPL_ACTION_SUCCESS"));
		C("TMPL_ACTION_ERROR",$admintpl_path.C("SP_ADMIN_TMPL_ACTION_ERROR"));
		parent::__construct();
		$time=time();
		$this->assign("js_debug",APP_DEBUG?"?v=$time":"");
		
		C('CFG', D('SysConfig')->load_config());
	}

	function _initialize(){
	    parent::_initialize();
	    define("TMPL_PATH", C("SP_ADMIN_TMPL_PATH"));
	    
	    //暂时取消后台多语言
	    $this->load_app_admin_menu_lang();
	    
	    $session_admin_id=session('ADMIN_ID');
	    
    	if(!empty($session_admin_id)){
    		$users_obj= M("Users");
    		$user=$users_obj->where(array('id'=>$session_admin_id))->find();
    		if(!$this->check_access($session_admin_id)){
				$this->error("您没有访问权限！");
			}
			$this->assign("admin",$user);
		}else{
		    
			if(IS_AJAX){
				$this->error("您还没有登录！",U("admin/public/login"));
			}else{
				header("Location:".U("admin/public/login"));
				exit();
			}

		}
	}

	/**
	 * 初始化后台菜单
	 */
	public function initMenu() {
		$Menu = F("Menu");
		if (!$Menu) {
			$Menu=D("Common/Menu")->menu_cache();
		}
		return $Menu;
	}

	/**
	 * 消息提示
	 * @param type $message
	 * @param type $jumpUrl
	 * @param type $ajax
	 */
	public function success($message = '', $jumpUrl = '', $ajax = false) {
		parent::success($message, $jumpUrl, $ajax);
	}

	/**
	 * 模板显示
	 * @param type $templateFile 指定要调用的模板文件
	 * @param type $charset 输出编码
	 * @param type $contentType 输出类型
	 * @param string $content 输出内容
	 * 此方法作用在于实现后台模板直接存放在各自项目目录下。例如Admin项目的后台模板，直接存放在Admin/Tpl/目录下
	 */
	public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        parent::display($this->parseTemplate($templateFile), $charset, $contentType,$content,$prefix);
	}

	/**
	 * 获取输出页面内容
	 * 调用内置的模板引擎fetch方法，
	 * @access protected
	 * @param string $templateFile 指定要调用的模板文件
	 * 默认为空 由系统自动定位模板文件
	 * @param string $content 模板输出内容
	 * @param string $prefix 模板缓存前缀*
	 * @return string
	 */
	public function fetch($templateFile='',$content='',$prefix=''){
		$templateFile = empty($content)?$this->parseTemplate($templateFile):'';
		return parent::fetch($templateFile,$content,$prefix);
	}

	/**
	 * 自动定位模板文件
	 * @access protected
	 * @param string $template 模板文件规则
	 * @return string
	 */
	public function parseTemplate($template='') {
		$tmpl_path=C("SP_ADMIN_TMPL_PATH");
		define("SP_TMPL_PATH", $tmpl_path);
    	if($this->theme) { // 指定模板主题
    	    $theme = $this->theme;
    	}else{
    	    // 获取当前主题名称
    	    $theme      =    C('SP_ADMIN_DEFAULT_THEME');
    	}

		if(is_file($template)) {
			// 获取当前主题的模版路径
			define('THEME_PATH',   $tmpl_path.$theme."/");
			return $template;
		}
		$depr       =   C('TMPL_FILE_DEPR');
		$template   =   str_replace(':', $depr, $template);

		// 获取当前模块
		$module   =  MODULE_NAME."/";
		if(strpos($template,'@')){ // 跨模块调用模版文件
			list($module,$template)  =   explode('@',$template);
		}

		$module =$module."/";

		// 获取当前主题的模版路径
		define('THEME_PATH',   $tmpl_path.$theme."/");

		// 分析模板文件规则
		if('' == $template) {
			// 如果模板文件名为空 按照默认规则定位
			$template = CONTROLLER_NAME . $depr . ACTION_NAME;
		}elseif(false === strpos($template, '/')){
			$template = CONTROLLER_NAME . $depr . $template;
		}

		$cdn_settings=sp_get_option('cdn_settings');
		if(!empty($cdn_settings['cdn_static_root'])){
		    $cdn_static_root=rtrim($cdn_settings['cdn_static_root'],'/');
		    C("TMPL_PARSE_STRING.__TMPL__",$cdn_static_root."/".THEME_PATH);
		    C("TMPL_PARSE_STRING.__PUBLIC__",$cdn_static_root."/public");
		    C("TMPL_PARSE_STRING.__WEB_ROOT__",$cdn_static_root);
		}else{
		    C("TMPL_PARSE_STRING.__TMPL__",__ROOT__."/".THEME_PATH);
		}
		

		C('SP_VIEW_PATH',$tmpl_path);
		C('DEFAULT_THEME',$theme);
		define("SP_CURRENT_THEME", $theme);

		$file = sp_add_template_file_suffix(THEME_PATH.$module.$template);
		$file= str_replace("//",'/',$file);
		if(!file_exists_case($file)) E(L('_TEMPLATE_NOT_EXIST_').':'.$file);
		return $file;
    }

    /**
     * 排序 排序字段为listorders数组 POST 排序字段为：listorder或者自定义字段
     * @param mixed $model 需要排序的模型类
     * @param string $custom_field 自定义排序字段 默认为listorder,可以改为自己的排序字段
     */
    protected function _listorders($model,$custom_field='') {
        if (!is_object($model)) {
            return false;
        }
        $field=empty($custom_field)&&is_string($custom_field)?'listorder':$custom_field;
        $pk = $model->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data[$field] = $r;
            $model->where(array($pk => $key))->save($data);
        }
        return true;
    }

	/**
	 * 
	 * {@inheritDoc}
	 * @see \Common\Controller\AppframeController::page()
	 */
	protected function page($total_size = 1, $page_size = 0, $current_page = 1, $listRows = 6, $pageParam = '', $pageLink = '', $static = false) {
		if ($page_size == 0) {
			$page_size = C("PAGE_LISTROWS");
		}

		if (empty($pageParam)) {
			$pageParam = C("VAR_PAGE");
		}

		$page = new \Page($total_size, $page_size, $current_page, $listRows, $pageParam, $pageLink, $static);
        $page->SetPager('Admin', '{first}{prev}&nbsp;{liststart}{list}&nbsp;{next}{last}<span>共{recordcount}条数据</span>', array("listlong" => "4", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
		return $page;
	}

	/**
	 *  检查后台用户访问权限
	 * @param int $uid 后台用户id
	 * @return boolean 检查通过返回true
	 */
	private function check_access($uid){
		//如果用户角色是1，则无需判断
		if($uid == 1){
			return true;
		}

		$rule=MODULE_NAME.CONTROLLER_NAME.ACTION_NAME;
		$no_need_check_rules=array("AdminIndexindex","AdminMainindex");

		if( !in_array($rule,$no_need_check_rules) ){
			return sp_auth_check($uid);
		}else{
			return true;
		}
	}

	/**
	 * 加载后台用户语言包
	 */
    private function load_app_admin_menu_lang(){
	    $default_lang=C('DEFAULT_LANG');
	    $langSet=C('ADMIN_LANG_SWITCH_ON',null,false)?LANG_SET:$default_lang;
		if($default_lang!=$langSet){
		    $admin_menu_lang_file=SPAPP.MODULE_NAME."/Lang/".$langSet."/admin_menu.php";
		}else{
		    $admin_menu_lang_file=SITE_PATH."data/lang/".MODULE_NAME."/Lang/$langSet/admin_menu.php";
		    if(!file_exists_case($admin_menu_lang_file)){
		        $admin_menu_lang_file=SPAPP.MODULE_NAME."/Lang/".$langSet."/admin_menu.php";
		    }
		}
		if(is_file($admin_menu_lang_file)){
			$lang=include $admin_menu_lang_file;
			L($lang);
    	}
    }
    
    protected function is_only($field, $value, $id = 0, $where=''){
    	$sql = "$field='$value' ";
    	$sql .= empty($id) ? '' : " AND " . $this->id . " <> '$id'";
    	$sql .= empty($where) ? '' : ' AND ' .$where;
    
    	$count = $this->instance->where($sql)->count();
    	return $count==0?true:false;
    }
    
    protected function update_by_id($data, $id){
    	$rlt = $this->instance->data($data)->where(" $this->id=$id")->save();
    	return $rlt > 0;
    }
    
    protected function drop($id){
    	$rlt = $this->instance->where(" $this->id='$id'")->delete();
    	return $rlt > 0;
    }
    
    protected function get_name($id, $field=''){
    	if (empty($field))
    	{
    		$field = $this->name;
    	}
    	return $this->instance->field($field)->where(" $this->id='$id'")->getOne();
    }
    
    protected function get_record($id){
    	return $this->instance->where(" $this->id='$id'")->find();
    }
    
    protected function add_record($data){
    	return $this->instance->data($data)->add();
    }
    
    protected function update_record($id,$data,$condition=''){
    	if(empty($condition)){
    		$condition = " $this->id='$id'";
    	}
    	$rlt = $this->instance->data($data)->where($condition)->save();
    	return $rlt > 0;
    }
    
    protected function get_total_count($condition='1=1'){
    	return $this->instance->where($condition)->count();
    }
    
    // 获取分页查询limit
    protected function pageLimit($url, $num = 10) {
    	$url = str_replace(urlencode('{page}'), '{page}', $url);
    	$page = is_object($this->pager ['obj']) ? $this->pager ['obj'] : new \Think\Pager();
    	$cur_page = $page->getCurPage($url);
    	$limit_start = ($cur_page - 1) * $num;
    	$limit = $limit_start . ',' . $num;
    	$this->pager = array(
    			'obj' => $page,
    			'url' => $url,
    			'num' => $num,
    			'cur_page' => $cur_page,
    			'limit' => $limit
    	);
    	return $limit;
    }
    
    // 分页结果显示
    protected function pageShow($count) {
    	return $this->pager ['obj']->show($this->pager ['url'], $count, $this->pager ['num']);
    }
    
    /**
     * 分批取记录
     * @param unknown $amount
     * @return 当前的取记录的条件和下一次调用的参数
     */
    protected function patchShow($amount){
    	$page = isset($_GET['page']) ? $_GET['page'] : 1;
    	$last = isset($_GET['batch_last']) ? $_GET['batch_last'] : 0;
    	$total = isset($_GET['batch_total']) ? $_GET['batch_total'] : 0;
    	 
    	if($last + $amount > $total ){
    		$limit = $total - $last;
    	}
    	else{
    		$limit = $amount;
    	}
    	 
    	$cfg = array('limit'=>$limit,'start'=>$last + ($page -1) * $this->page_size);
    	 
    	 
    	$patch_last = $last + $amount;
    	if($patch_last < $total){
    		$cfg['filter'] = array('batch_last'=>$patch_last, 'batch_total'=>$total,'page'=>$page);
    	}
    	return $cfg;
    }
    
    // 操作成功之后跳转,默认三秒钟跳转
    protected function message($msg, $url = NULL, $type = 'succeed', $waitSecond = 2) {
    	if ($url == NULL)
    		$url = 'javascript:history.back();';
    		if ($type == 'error') {
    			$title = '错误信息';
    		} else {
    			$title = '提示信息';
    		}
    		$data ['title'] = $title;
    		$data ['message'] = $msg;
    		$data ['type'] = $type;
    		$data ['url'] = $url;
    		$data ['second'] = $waitSecond;
    		$this->assign('data', $data);
    		$this->display('./Common/message');
    		exit();
    }
    
    // 弹出信息
    protected function alert($msg, $url = NULL, $parent = false) {
    	header("Content-type: text/html; charset=utf-8");
    	$alert_msg = "alert('$msg');";
    	if (empty($url)) {
    		$gourl = 'history.go(-1);';
    	} else {
    		$gourl = ($parent ? 'parent' : 'window') . ".location.href = '{$url}'";
    	}
    	echo "<script>$alert_msg $gourl</script>";
    	exit();
    }
    
    protected function parse_switch_data($data, $keys){
    	foreach ($keys as $key){
    		if(empty($data[$key])){
    			$data[$key] = 0;
    		}
    		elseif ($data[$key] == 'on'){
    			$data[$key] = 1;
    		}
    	}
    	return $data;
    }
}