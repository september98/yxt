<?php
namespace Wechat\Model;
use Think\Model;

/* 访问控制 */
defined('ENTRANCE') or die('Deny Access');

class DiyMenuModel extends Model {
	protected $tableName = 'diy_menu';
	protected $trueTableName = '';
	protected $table = '';

	/*
	protected $_validate = array(
		array('username','require','管理员名称不得为空！',1),  // 都有时间都验证
		array('username','','管理员名称不得重复！',1,unique,1), 
		array('username','','管理员名称不得重复！',1,unique,2),
		array('password','require','管理员密码不得为空！',1),
		array('verify','verify','验证码错误！',1,'callback',4),
	);
	*/

	protected $_validate = array(
	
		//array('menu_id', 'require', '{%menu_id_validate}', 2),

		//array('parent_id', 'require', '{%parent_id_validate}', 2),

		//array('title', 'require', '{%title_validate}', 2),

		//array('keyword', 'require', '{%keyword_validate}', 2),

		//array('is_show', 'require', '{%is_show_validate}', 2),

		//array('sort', 'require', '{%sort_validate}', 2),

		//array('url', 'require', '{%url_validate}', 2),

		//array('menu_type', 'require', '{%menu_type_validate}', 2),
	);
	
	public function __construct(){
		parent::__construct();
		$this->trueTableName = $this->tablePrefix . 'diy_menu';
		$this->table = $this->tablePrefix . 'diy_menu AS T ';
	}
	
	function get_diy_menu_list($filter, $offset='0,12'){
		$sql = 'select T.* from ' . $this->table;

		if(!empty($filter['where'])){
			$sql .= ' WHERE ' . $filter['where'];
		}
		if(!empty($filter['sort_by'])){
			$sql .= ' ORDER BY ' . $filter['sort_by'] . ' ' . $filter['sort_order'];
		}
		
		$sql .= " limit $offset";

		$res = $this->query($sql);
		/*
		foreach ($res as $key=>$row){
			$res[$key]['start_time'] = date('Y-m-d H:i:s', $row['start_time']);
			$res[$key]['end_time']   = date(C('date_format'), $row['end_time']);
		}*/
		return $res;
	}
	
	function diy_menu_detail($id){
		$res = $this->query('select * from ' . $this->trueTableName . " where menu_id='$id'");
		if (is_array($res)){
			return $res[0];
		}
		return FALSE;
	}
}