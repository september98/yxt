<?php
namespace Wechat\Model;
use Think\Model;

/* 访问控制 */
defined('ENTRANCE') or die('Deny Access');

class ReplyModel extends Model {
	protected $tableName = 'reply';
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
	
		//array('reply_id', 'require', '{%reply_id_validate}', 2),

		//array('key_word', 'require', '{%key_word_validate}', 2),

		//array('reply_type', 'require', '{%reply_type_validate}', 2),

		//array('match_type', 'require', '{%match_type_validate}', 2),

		//array('content', 'require', '{%content_validate}', 2),

		//array('createtime', 'require', '{%createtime_validate}', 2),

		//array('updatetime', 'require', '{%updatetime_validate}', 2),

		//array('click', 'require', '{%click_validate}', 2),

		//array('album_id', 'require', '{%album_id_validate}', 2),

		//array('img_media_id', 'require', '{%img_media_id_validate}', 2),

		//array('title', 'require', '{%title_validate}', 2),

		//array('link', 'require', '{%link_validate}', 2),
	);
	
	public function __construct(){
		parent::__construct();
		$this->trueTableName = $this->tablePrefix . 'reply';
		$this->table = $this->tablePrefix . 'reply AS T ';
	}
	
	function get_reply_list($filter, $offset='0,12'){
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
	
	function reply_detail($id){
		$res = $this->query('select * from ' . $this->trueTableName . " where reply_id='$id'");
		if (is_array($res)){
			return $res[0];
		}
		return FALSE;
	}
}