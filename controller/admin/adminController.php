<?php

class adminController extends Controller {
	public function __construct() {
		parent::__construct();
		$this->checkAuth();
	}

	public function checkAuth() {
		$authController = $this->controller('auth', 'public');
		$value = $authController->get('wangdahu');
		if(!$value) {
			echo '获取登录信息失败，请重新登录';
			$url = 'index.php?app=admin&controller=login&action=index';
			header("Location:$url");
		}
	}
}
