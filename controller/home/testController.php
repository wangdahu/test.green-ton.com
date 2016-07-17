<?php
class testController extends Controller {
	public function __construct() {
		parent::__construct();
	}


	public function index() {
		$data['test'] = 'home/test.php';
	
		$image = ROOT_PATH.'/public/img/net.gif';
		$thumb = new Thumbnail(200, 200);
		$thumb->loadFile($image);
		header('Content-type:'.$thumb->getMime());
		$thumb->buildThumb();

		$img = file_get_contents($image);
		$thumb->loadData($img, 'image/jpg');
		$thumb->buildThumb('wap_thumb.gif');

		$this->showTemplate('index', $data);
	}

	public function testDb() {
		$modTest = $this->model('test');
		$modTest->testDatabases();
	}

}
