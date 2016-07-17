<?php

class testModel extends Model {

	public function testDatabases() {
		$this->db->show_databases();
	}

}
