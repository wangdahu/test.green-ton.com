<?php
class loginController extends Controller {

	public function index() {
		$data['title'] = '后台登陆';
		$model = $this->model('home');
		if($_POST) {
			extract($_POST);
			$password = md5($password);
			if($model->login($username, $password)) {
				// 设置cookie
				$authController = $this->controller('auth', 'public');
				$authController->set($username, $password);
				$url = "index.php?app=admin&controller=home&action=index";
				header("Location:$url");
			}else {
				echo '用户名和密码错误！';
			}
		}
		$this->showTemplate('index', $data);
	}

}
