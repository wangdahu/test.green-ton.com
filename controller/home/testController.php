<?php
class testController extends Controller {
	public function __construct() {
		parent::__construct();
	}

	public function tree($dir, $level = 1) {
		$dp = opendir($dir);
		while($dirname = readdir($dp)) {
			if($dirname == '.' || $dirname == '..') {
				continue;
			}
			echo "|".str_repeat('-', $level).$dirname."<br />";
			if(is_dir($dir."/".$dirname)) {
				$this->tree($dir.'/'.$dirname, $level+2);
			}
		}
	}

	

	public function index() {
		echo '<pre>';
		$str = "Hello World!=Woshi wangang&n'a\me=sdfsf";
		parse_str($str, $arr);
		var_dump($arr);
		exit;
		echo $str;
		echo nl2br($str);
		exit;
		$str = 'ssssssss%isssssssssss%sdfsdfsdfsdfsdfs';
		printf($str, 44, 4);
		exit;
		
		var_dump(CRYPT_STD_DES, CRYPT_SALT_LENGTH);
		exit;
		$url = "http://www.baidu.comi";
		var_dump(chunk_split($url));
		var_dump($url);
		var_dump(ltrim($url, 'htftpi://'));
		exit;
	echo file_get_contents($url);
	exit;

		echo phpversion();
		
		$str = '2015/11/23 4:50';

		var_dump(str_replace('\/', '/', json_encode($str)));
		var_dump(json_encode($str, JSON_UNESCAPED_SLASHES));

		exit;

		
		$url = "http://test.greent-ton/index.php?app=home";
			
		var_dump($_SERVER);
		exit;
		$url = "http://test.greent-ton/index.php?app=home";

		var_dump(parse_url($url));

		$arr[1] = '111';
		$arr[0] = '000';
		$arr[2] = '222';
		var_dump($arr);
		foreach($arr as $key => $val) {
			var_dump($val);
		}
		
		
		exit;
		echo file_get_contents($_SERVER['HTTP_HOST']);

		exit;

		$str = 'wangdahu_is_good';
		$strArr = explode('_', $str);

		var_dump($strArr);
		array_walk($strArr, "ucwords");
		var_dump($strArr);exit;
		var_dump(implode('', array_walk($strArr, 'ucwords')));
		var_dump($str);
		var_dump(implode('', array_map(function($val){return ucwords($val);}, explode('_', $str))));
exit;

		$arrs = explode("_", $str);
		foreach($arrs as $key) {
			$arr[] = ucwords($key);
		}
		var_dump(implode('', $arr));
		exit;
		var_dump(ucwords($str));
		exit;
		var_dump(stripos($str, 'd'));
		var_dump(strripos($str, 'D'));
		var_dump(strrpos($str, 'D'));
		var_dump(strpos($str, 'd'));
		exit;
		echo max(1,2,3,5);
		var_dump(number_format(1234345345345,1,"?","-"));


		exit;
		header("HTTP/1.0 404 Not Found");
		exit;
		$url = "http://test.greent-ton/index.php?app=home";
		$arr = parse_url($url);
		echo strrchr(substr(basename($url), 0, strripos(basename($url), "?")), '.');
		var_dump($arr);
		$ex = strrchr($arr['path'], '.');
		var_dump($ex);
		exit;
		parse_str("id=23&name=wangdahu", $arr);
		var_dump($arr);
		exit;
		var_dump(crypt(123456, 123));
		var_dump(md5(123456));
		exit;
		$arr = array(
			'content' => 1,
			'test' =>2,
			'tt' =>3,
			'gg' => 4,
			'll' => 5,
			'rr' =>6
		);
		var_dump(reset($arr));
		exit;
		var_dump($arr);
		sort($arr);
		var_dump($arr);
		exit;
		array_shift($arr);
		array_unshift($arr, array(123,213,234,345));
		var_dump($arr);
		var_dump($arr[array_rand($arr, 1)]);
		exit;
		array_pop($arr);
		array_push($arr, 6);
		var_dump(array_flip($arr));

		exit;


		$this->tree('/data/wwwroot/sftp');
		exit;

		$filename = "abc.hh.jpg";

		var_dump(strrchr($filename, "."));

		exit;
		var_dump($GLOBALS);

		var_dump(array_unique(array(1,1,2,3,4,5,5)));
	
		$str = 'ab"c1"2"3';
		echo $str."<br />";

		var_dump(preg_replace('/"/', "'", $str))."<br />";
		var_dump(str_replace(array('"', "a"), array(), $str))."<br />";

		var_dump(json_encode(array(htmlspecialchars($str))))."<br />";
		echo json_encode(array('contet' => '124'))."<br />";


		echo date('Y-m-d H:i:s', time())."<br />";
		echo date('Y-m-d H:i:s', strtotime('0 day'))."<br />";
		echo date('Y-m-d H:i:s', strtotime("-1 day"))."<br />";
		echo date('Y-m-d H:i:s', strtotime("-2 day"))."<br />";
		
		echo strrev('abc')."<br />";
		var_dump(array_reverse(array(1,2,3)));

		var_dump($_SERVER['REMOTE_ADDR']);
		var_dump($_SERVER['SERVER_ADDR']);
		var_dump($_SERVER['PHP_SELF']);
		var_dump($_SERVER['HTTP_REFERER']);
		var_dump(gethostbyname('ad.green-ton.com'));
		var_dump(getenv("REMOTE_ADDR"));
		var_dump(getenv("SERVER_ADDR"));

	}

	public function testDb() {
		$modTest = $this->model('test');
		$modTest->testDatabases();
	}

}
