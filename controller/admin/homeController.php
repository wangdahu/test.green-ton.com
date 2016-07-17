<?php
class homeController extends Controller {
	public function __construct() {
		parent::__construct();
	}


	public function index() {
		$data['test'] = 'admin/home.php';
		$this->showTemplate('index', $data);
	}

	public function testDb() {
		$modTest = $this->model('test');
		$database = $modTest->testDatabases();
	}

}
