<?php

class homeModel extends Model {	
	public $table = 'messages';
	public function login($username, $password) {
		$condition = 'username = "'.$username.'" and password = "'.$password.'"';
		return $this->db->findCount('admin',  $condition);
	}

	public function find($id) {
		$condition = 'id = '.$id;
		$selectArray = array(
			'table' => $this->table,
			'condition' => $condition,
		);
		$this->db->select($selectArray);
		return $this->db->fetch_assoc();
	}

	public function save($id, $name, $content) {
		$this->db->update($this->table, 'name="'.$name.'", content = "'.$content.'"', 'id = "'.$id.'"');
	}
	
	public function delete($id) {
		$this->db->delete($this->table, 'id = "'.$id.'"');
	}
}
