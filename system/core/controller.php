<?php
/**
  * 核心控制器
  * @author wangdahu
  * @version 1.0
  */

class Controller {
	public function __construct() {
//		// 写入缓存
//		$cache = Application::$_lib['cache'];
//		$cacheName = '21weqeqw';
//		$fileName = $cache->hasCache($cacheName);
//		if($fileName) {
//			include $fileName;
//			echo 1111;
//		}else {
//			$cacheData = 'testtetstets';
//			$cache->set($cacheName, $cacheData);
//			echo 2222;
//		}
		//header('Content-type:text/html;charset=utf-8');
	}
	
	// 实例化模型
	final protected function model($model, $path='') {
		if(empty($model)) {
			trigger_error('不能实例化空模型');
		}
		$app = $path ? $path : Application::$_lib['app'];
		$model_name = $model.'Model';
		$modelName = MODEL_PATH.'/'.$app.'/'.$model_name.'.php';
		if(file_exists($modelName)){
			require $modelName;
			return new $model_name;
		}else {
			trigger_error('模型'.$modelName.'不存在！');
		}
	}

	// 实例化模型
	final protected function controller($controller, $path = '') {
		if(empty($controller)) {
			trigger_error('不能实例化空控制器');
		}
		$app = $path ? $path : Application::$_lib['app'];
		$controller_name = $controller.'Controller';
		$controllerName = CONTROLLER_PATH.'/'.$app.'/'.$controller_name.'.php';
		if(file_exists($controllerName)){
			require $controllerName;
			return new $controller_name;
		}else {
			trigger_error('控制器'.$controllerName.'不存在！');
		}
	}

	// 加载类库  $auto:false 默认加载系统自动加载的类库，$auto:true加载非自动加载类库 
	final protected function load($lib, $auto = TRUE) {
		if(empty($lib)) {
			trigger_error('加载类库名不能为空！');
		}elseif($auto === TRUE) {
			return Application::$_lib[$lib];
		}elseif($auto === FALSE) {
			return Application::newLib($lib);
		}
	}
	
	// 加载系统配置，默认为系统配置 $CONFIG['system'][$config]
	final protected function config($config) {
		return Application::$_config[$config];
	}
	
	// 加载模板文件
	final protected function showTemplate($path, $data = array()) {
		$template = $this->load('template');
		$controller = Application::$_lib['controller'];
		$app = Application::$_lib['app'];
		$path = $app.'/'.$controller.'/'.$path;
		$template->init($path, $data);
		$template->outPut();
	}

}
