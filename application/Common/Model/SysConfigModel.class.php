<?php
namespace Common\Model;
use Common\Model\CommonModel;

class SysConfigModel extends CommonModel {
	protected $tableName = 'sys_config';
	protected $trueTableName = '';
	protected $table = '';

	protected $_validate = array(
	);
	
	public function __construct(){
		parent::__construct();
		$this->trueTableName = $this->tablePrefix . 'sys_config';
		$this->table = $this->tablePrefix . 'sys_config AS T ';
	}

	
	/**
	 * 载入配置信息
	 * @access  public
	 * @return  array
	 */
	public function load_config() {
		$data = F('sys_config');
		if ($data === false) {
			$sql = 'SELECT code, value FROM ' . $this->trueTableName . ' WHERE parent_id > 0';
			$res = $this->query($sql);
			$arr = array();
			foreach ($res AS $row) {
				$arr[$row['code']] = $row['value'];
			}

			//限定语言项
			$lang_array = array('zh_cn', 'zh_tw', 'en_us');
			if (empty($arr['lang']) || !in_array($arr['lang'], $lang_array)) {
				$arr['lang'] = 'zh_cn'; // 默认语言为简体中文
			}
				
			F('sys_config', $arr);
		} else {
			$arr = $data;
		}
		$config = array();
		foreach ($arr AS $key=>$vo) {
			$config[strtoupper($key)] = $vo;
		}
	
		return $config;
	}
}