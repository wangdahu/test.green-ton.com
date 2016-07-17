<?php

class homeModel extends Model {

	public function testDatabases() {
		$this->db->show_databases();
	}

}
