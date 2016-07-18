<?php
class homeController extends Controller {
	public function __construct() {
		parent::__construct();
	}


	public function index() {
		$data['title'] = '留言板主页';
		$model = $this->model('home');
		if($_POST) {
			extract($_POST);
			if(!$name || !$content) {
				echo 'alert("名字和内容都不能为空！！！")';
			}
			$name = addslashes($name);
			$content = addslashes($content);
			$model->save($name, $content);
			header("location:".$_SERVER["HTTP_REFERER"]);
		}

		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$limit = 20;
		$lists = $model->lists($page, $limit);
		$count = $model->counts();
		$totalPage = (int)ceil($count/$limit);
		$pageController = $this->controller('page', 'public');
		$data['pageHtml'] = $pageController->page($page, $totalPage);
		$data['lists'] = $lists;
		$this->showTemplate('index', $data);
	}

	public function lists() {
		$model = $this->model('home');
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$limit = 20;
		$lists = $model->lists($page, $limit);
		$count = $model->counts();
		$totalPage = (int)ceil($count/$limit);
		$pageController = $this->controller('page', 'public');
		$data['pageHtml'] = $pageController->page($page, $totalPage);
		$data['lists'] = $lists;
		$this->showTemplate('lists', $data);
	}

}
