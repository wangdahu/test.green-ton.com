<?php
/**
  * 核心模型类
  * @author wangdahu
  * @version 1.0
  */
class Model {
	protected $db = null;

	final public function __construct() {
		header('Content-type:text/html;charset=utf-8');

		$this->db = $this->load('mysql');
		$config_db = $this->config('db');

		$this->db->init(
			$config_db['db_host'],
			$config_db['db_user'],
			$config_db['db_password'],
			$config_db['db_database'],
			$config_db['db_conn'],
			$config_db['db_charset']
		);
	}

	// 根据表前缀获取表明
	final protected function table($table_name) {
		$config_db = $this->config('db');
		return $config_db['db_table_prefix'].$table_name;
	}

	// 加载类库 $auto:false 默认加载系统自动加载的类库，true自定义类库
	final protected function load($lib, $auto = TRUE) {
		if(empty($lib)) {
			trigger_error('加载类库名不能为空！');
		}elseif($auto === TRUE) {
			return Application::$_lib[$lib];
		}elseif($auto === FALSE) {
			return Application::newLib($lib);
		}
	}
	
	// 加载系统配置，默认为系统配置 $CONFIG['system'][$config]
	final protected function config($config) {
		return Application::$_config[$config];
	}


}
