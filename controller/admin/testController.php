<?php
class testController extends Controller {
	public function __construct() {
		parent::__construct();
	}


	public function index() {
		$data['test'] = 'admin/test.php';
		$this->showTemplate('index', $data);
	}

	public function testDb() {
		$modTest = $this->model('test');
		$database = $modTest->testDatabases();
		var_dump($database);
	}

}
