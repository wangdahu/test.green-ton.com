<?php
class homeController extends Controller {
	public function __construct() {
		parent::__construct();
	}


	public function index() {
		$data['title'] = '后台登陆';
		$data['test'] = 'admin/home.php';
		$this->showTemplate('index', $data);
	}


}
