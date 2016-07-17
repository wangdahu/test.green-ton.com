<?php

final class Mysql{
		private $db_host;
		private $db_user;
		private $db_pwd;
		private $db_datdabase;
		private $conn;
		private $result;
		private $sql;
		private $row;
		private $codinf;
		private $bulletin = true;  // 是否开启错误记录
		private $show_err = true; // 测试阶段，显示所有错误，具有安全隐患，默认关闭
		private $is_error = false; //  发现错误是都立即终止，默认TRUE，建议不启用，	因为当有问题用户什么都看不到是很苦恼的

	public function init($db_host, $db_user, $db_pwd, $db_database, $conn, $coding){
		$this->db_host = $db_host;
		$this->db_user = $db_user;
		$this->db_pwd = $db_pwd;
		$this->db_database = $db_database;
		$this->conn = $conn;
		$this->coding = $coding;
		$this->connect();
	}

	public function connect() {
		if($this->conn == 'pconn') {
			// 永久连接
			$this->conn = mysql_pconnect($this->db_host, $this->db_user, $this->db_pwd, $this->db_pwd);
		}else {
			// 即时链接
			$this->conn = mysql_connect($this->db_host, $this->db_user, $this->db_pwd, $this->db_pwd);
		}

		if(!mysql_select_db($this->db_database, $this->conn)) {
			if($this->show_err) {
				$this->show_error("数据库不可用：", $this->db_database);
			}
		}
		mysql_query("SET NAMES $this->coding");
	}

	public function query($sql) {
		if($sql == '') {
			$this->show_error("SQL语句错误：", "SQL查询语句为空！");
		}
		$this->sql = $sql;

		$result = mysql_query($this->sql, $this->conn);

		if(!$result) {
			if($this->show_err) {
				$this->show_error("错误sql语句", $this->sql);
			}
		}else {
			$this->result = $result;
		}
		return $this->result;
	}

	public function create_database($databaseName) {
		$sqlDatabase = 'create database '.$databaseName;
		$this->query($sqlDatabase);
	}

	public function show_databases() {
		$this->query("show databases");
		echo "现有数据库：".$amount = $this->db_num_rows();
		echo "<br/>";
		$i = 1;
		while($row = $this->fetch_array()) {
			echo $i.": ".$row['Database'];
			echo "<br />";
			$i++;
		}
	}

	public function databases() {
		$databaseArray = array();
		$db_list = mysql_list_dbs($this->conn);
		while($row = $this->fetch_array()) {
			$databaseArray[] = $row['Database'];
		}
		return $databaseArray;
	}

	public function mysql_result_li() {
		return mysql_result();
	}

	public function fetch_array() {
		return mysql_fetch_array($this->result);
	}

	public function fetch_assoc() {
		return mysql_fetch_assoc($this->result);
	}

	public function fetch_row() {
		return mysql_fetch_row($this->result);
	}

	public function fetch_object() {
		return mysql_fetch_object($this->result);
	}

	public function findAll($table) {
		$this->query("select * from ".$table);
	}

	public function select($selectArray = array(), $debug = '') {
		$table = $condition = $columns = $limit = null;
		extract($selectArray);
		$columns = $columns ? $columns : '*';
		$condition = $condition ? ' where '.$condition : null;
		$limit = $limit ? ' limit '.$limit : null;
		$condition = $condition ? 'where '.$condition : NULL;
		$sql = "select $columns from $table $condition $limit";
		if($debug){
			echo $sql;
		}else {
			$this->query($sql);
		}
	}

	public function delete($table, $condition, $url = ''){
		$condition = $condition ? ' where '.$condition : null;
		if($this->query("delete from $table $condition")){
			if(!empty($url)) {
				$this->Get_admin_msg($url, '删除成功！');
			}
		}
	}

	public function findCount($table, $condition = '') {
		$condition = $condition ? ' where '.$condition : null;
		$this->query('select count(*) from '.$table.' '.$condition);
		$result = $this->fetch_row();
		return $count = $result[0];
	}

	public function insert($table, $columnName, $value, $url='') {
		if($this->query("insert into $table ($columnName) values ($value)")) {
			if(!empty($url)){
				$this->Get_admin_msg($url, '添加成功');
			}
		}
	}

	public function update($table, $mod_content, $condition, $url = '') {
		if($this->query("update $table set $mod_content where $condition")){
			if(!empty($url)) {
				$this->Get_admin_msg($url, '修改成功');
			}
		}
	}

	public function insert_id() {
		return mysqli_insert_id();
	}
	
	public function db_data_seek($id) {
		if($id > 0) {
			$id = $id -1;
		}
		if(!@mysql_data_seek($this->result, $id)){
			$this->show_error('SQL语句有误：', "指定的数据为空");
		}
		return $this->result;
	}	

	public function db_num_rows() {
		if($this->result) {
			if(mysql_error() && $this->show_err) {
				$this->show_error('SQL语句错误', '暂时未空，没有任何内容！');
			}else {
				return mysql_num_rows($this->result);
			}
		}
	}

	public function db_affected_rows() {
		return mysql_affected_rows();
	}

	public function show_error($message = '', $sql= '') {
		if(!$sql) {
			echo "<font color='red'>".$message."</font>";
			echo "<br />";
		}else {
			echo "<fieldset>";
			echo "<legend>错误信息提示：</length><br />";
			echo "";
			echo "";
			echo "";
			echo "";
			echo "错误原因：".mysql_error()."<br /><br />";
			echo "";
			echo "<font color='red'>".$message."</font>";
			echo "";
			echo "<font color='red'><pre>".$sql."</pre></font>";
			$ip = $this->getip();
			if($this->bulletin) {
				$time = date('Y-m-d H:i:s');
				$message = $message."\r\n".$this->sql."\r\n客户ip：".$ip."\r\n时间：".$time."\r\n\r\n";
				$server_date = date('Y-m-d');
				$filename = $server_date."_SQL.txt";
				$file_path = ROOT_PATH."/error/".$filename;
				$error_content = $message;

				$file_dir = ROOT_PATH."/error";

				if(!file_exists($file_dir)) {
					if(!mkdir($file_dir, 0777)) {
						die("upload files directory does not exist and creation failed!");
					}
				}

				if(!file_exists($file_path)) {
					fopen($file_path, 'w+');

					if(is_writable($file_path)) {
						if(!$handle = fopen($file_path, 'a')) {
							echo "不能打开文件".$filename;
							exit;
						}

						if(!fwrite($handle, $error_content)) {
							echo "不能写入到文件".$filename;
							exit;
						}

						echo "----错误记录被保存----";

						fclose($handle);
					}else {
						echo "文件".$filename."不可写";
					}
				}else {
					if(is_writable($file_path)) {
						if(!$handle = fopen($file_path, 'a')) {
							echo "不能打开文件".$filename;
							exit;
						}

						if(!fwrite($handle, $error_content)) {
							echo "不能写入到文件".$filename;
							exit;
						}

						echo "----错误记录被保存-----";
						fclose($handle);
					}else {
						echo "文件".$filename."不可写";
					}
				}
			}
		}
		echo "<br />";
		if($this->is_error) {
			exit;
		}
		echo "</div>";
		echo "</fieldset>";
		echo "<br />";
	}

	public function free() {
		@mysql_free_result($this->result);
	}

	public function select_db($db_name) {
		return mysql_select_db($db_name);
	}

	public function num_fields($table_name) {
		$this->query("select * from ".$table_name);
		echo "<br />";
		echo "字段数：".$total = mysql_num_fields($this->result);
		echo "<pre>";
		for($i = 0; $i < $total; $i++) {
			print_r(mysql_fetch_field($this->result, $i));
		}
		echo "<pre />";
		echo "<br />";
	}

	public function mysql_server($num = '') {
		switch($num) {
			case 1:
				return mysql_get_server_info();
				break;
			case 2:
				return mysql_get_host_info();
				break;
			case 3:
				return mysql_get_client_info();
				break;
			case 4:
				return mysql_get_proto_info();
				break;
			default:
				return mysql_get_client_info();
		}
	}

	public function __destruct() {
		if(!empty($this->result)) {
			$this->free();
		}
	}

	function getip() {
		if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} else {
			if(getenv("HTTP_X_FORWORDED_FOR") && strcasecmp(getenv("HTTP_X_FORWORDED_FOR"), "unknown")) {
			$ip = getenv("HTTP_X_FORWORDED_FOR");
			}else {
				if(getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
					$ip = getenv("REMOTE_ADDR");
				}else {
					if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
						$ip = $_SERVER['REMOTE_ADDR'];
					}else {
						$ip = "unknown";
					}
				}
			}
		}
		return $ip;
	}

	function inject_check($sql_str) {
		$check = eregi('select|insert|udate|delere|\`|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);
		if($check) {
			echo "输入非法注入内容！";
			exit;
		}else {
			return $sql_str;
		}
	}

	function checkurl() {
		if(preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) !== preg_replace("/([^\:]+).*/", "//1", $_SERVER['HTTP_HOST'])) {
			header("Location:http://www.test.green-ton.com");
			exit;
		}
	}

}
