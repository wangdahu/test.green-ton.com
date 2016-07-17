<?php

class homeModel extends Model {
	
	public $table = 'messages';

	public function testDatabases() {
	for($i = 100001; $i < 1001000; $i++) {
		$sql = 'insert into messages (name, content, addtime) values ("王刚", "王刚灌水的第'.$i.'条信息", '.time().')';
		$this->db->query($sql);
	}
		$this->db->show_databases();
	}

	public function lists($page = 0, $step= 20) {
		$limit = $page*$step.", ".$step;
		$selectArray = array(
			'table' => $this->table,
			'limit' => $limit
		);

		$lists = array();
		$reulst = $this->db->select($selectArray);
		while($row = $this->db->fetch_assoc()) {
			$lists[] = $row;
		}
		return $lists;
	}

	public function counts() {
		return $this->db->findCount($this->table);
	}
}
