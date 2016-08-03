<?php
class keywordsController extends Controller {
	
	public function index() {
		$data['title'] = '关键字';

		$model = $this->model('keywords');
		$keywords = $model->findAll();

		$data['keywords'] = $keywords;
		$this->showTemplate('index', $data);
	}

	public function add() {
		if($_POST) {
			$keywords = $_POST['keywords'];
			$keywords = str_replace('，', ',', $keywords);
			$keywordsArr = preg_split('/[,]/', $keywords);
			$insertStr = '';
			foreach($keywordsArr as $keyword) {
				if($keyword) {
					$insertStr .= "'".addslashes($keyword)."'),(";
				}
			}
			$model = $this->model('keywords');
			$insertStr = substr($insertStr, 0, -3);
			$model->add($insertStr);
		}
	}

	public function delete() {
		if($_POST) {
			$id = $_POST['id'];
			$model = $this->model('keywords');
			$model->delete($id);
		}
	}

}
