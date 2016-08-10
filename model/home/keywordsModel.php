<?php

class keywordsModel extends Model {
	public $table = 'keywords';

	public function replaceStr() {
		$keywordsStr = '';
		$this->db->findAll($this->table);
		while($keyword = $this->db->fetch_assoc()) {
			$keywordsStr .= $keyword['keyword']."|";
		}
		return substr($keywordsStr, 0, -1);
	}
}
