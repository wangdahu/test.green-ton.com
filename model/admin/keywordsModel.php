<?php
class keywordsModel extends Model {
	public $table = 'keywords';

	public function findAll() {
		$this->db->findAll($this->table);
		$keywords = array();
		while($keyword = $this->db->fetch_assoc()) {
			$keywords[] = $keyword;
		}
		return $keywords;
	}


	public function add($valueStr) {
		$this->db->insert($this->table, 'keyword', $valueStr);
	}


	public function delete($id) {
		$condition = 'id = "'.$id.'"';
		echo $condition;
		return $this->db->delete($this->table, $condition);
	}
}
