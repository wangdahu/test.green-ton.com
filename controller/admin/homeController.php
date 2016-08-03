<?php
include 'controller/admin/adminController.php';
class homeController extends adminController {
	public function __construct() {
		parent::__construct();
	}

	public function index() {


		$model = $this->model('home', 'home');
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$limit = 20;
		$lists = $model->lists($page, $limit);
		$count = $model->counts();
		$totalPage = (int)ceil($count/$limit);
		$pageController = $this->controller('page', 'public');
		$data['pageHtml'] = $pageController->page($page, $totalPage);
		$data['lists'] = $lists;
		$data['title'] = '后台管理主页面';

		$this->showTemplate('index', $data);
	}

	public function edit() {
		$data['title'] = '编辑留言';
		$model = $this->model('home');
		if($_POST) {
			extract($_POST);
			if(!$name || !$content) {
				trigger_error('名字和内容都不能为空！！！');
			}
			$name = addslashes($name);
			$content = addslashes($content);
			$model->save($id, $name, $content);
			header("location:".$_SERVER["HTTP_REFERER"]);
		}
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		if(!$id) {
			trigger_error('找不到要编辑的留言！');
		}
		$message = $model->find($id);
		if(!$message) {
			trigger_error('找不到要编辑的留言');
		}
		$data['message'] = $message;
		$this->showTemplate('edit', $data);
	}

	public function delete() {
		if($_POST) {
			$id = isset($_POST['id']) ? (int)$_POST['id'] : '';
			$model = $this->model('home');
			$model->delete($id);
		}
	}

}
