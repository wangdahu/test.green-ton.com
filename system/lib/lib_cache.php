<?php

final class Cache{
	private $cache_dir = null;
	private $cache_prefix = null;
	private $cache_time = null;
	private $cache_mode = null;


	public function init($cache_dir = 'cache', $cache_prefix = 'cache_', $cache_time = 1800, $cache_mod = 1) {
		$this->cache_dir = $cache_dir;
		$this->cache_prefix = $cache_prefix;
		$this->cache_time = $cache_time;
		$this->cache_mod = $cache_mod;

		$id = $this->setFileName();
		//
		if($this->hasCache($id)) {
			return $this->get($id);
		}else {
			
		}
	}

	// 生成缓存文件名
	public function setFileName() {
		return $this->cache_prefix.md5($_SERVER['REQUEST_URI']);
	}
	
	// 获取缓存
	public function get($id) {
		if(!$this->hasCache($id)){
			return false;
		}
		return $this->getCacheData($id);
	}

	// 获取缓存目录
	public function getCacheDir() {
		return rtrim($this->cache_dir, '/');
	}

	// 获取完整的缓存文件名称
	public function getFileName($id) {
		return $this->getCacheDir().'/'.$id.'.php';
	}

	// 根据缓存文件返回缓存名称
	public function getCacheName($file) {
		if(!file_exists($file)){
			return false;
		}

		$filename = basename($file);
		preg_match('/^'.$this->cache_prefix.'(.*).php$/i', $fileName, $matches);
		return $matches[1];
	}

	// 设置缓存
	public function set($id, $data) {
		if(!isset($id)) {
			return false;
		}
		$cache = array(
			'file' => $this->getFileName($id, $this->cache_dir),
			'data' => $data
		);
		return $this->writeCache($cache);
	}

	// 写入缓存
	public function writeCache($cache = array()) {
		if(!is_dir($this->getCacheDir())) {
			mkdir($this->getCacheDir(), 0777);
		}elseif(!is_writable($this->getCacheDir())) {
			chmod($this->getCacheDir(), 0777);
		}

		if($this->cache_mod == 1) {
			$content = serialize($cache['data']);
		}else {
			$content = "<?php\n"."return ".var_export($cache['data'], true).";\n";
		}

		if($fp = @fopen($cache['file'], 'w')) {
			@flock($fp, 'LOCK_EX');
			if(fwrite($fp, $content) === false) {
				trigger_error('写入缓存失败');
			}
			@flock($fp, 'LOCK_UN');
			@fclose($fp);
			@chmod($cache['file'], 0777);
			return true;
		}else {
			trigger_error('打开'.$cache['file'].'失败！');
			return false;
		}
	}

	// 判断缓存是否存在
	public function hasCache($id) {
		$fileName = $this->getFileName($id);
		// 检查前删除过期缓存
		if(file_exists($fileName)) {
			if(time() > filemtime($fileName)+$this->cache_time) {
				unlink($fileName);
				return false;
			}
			return $fileName;
		}
		return false;
	}

	// 删除一条缓存
	public function deleteCache($id) {
		$fileName = $this->hasCache();
		if($fileName) {
			return unlink($fileName);
		}
		trigger_error('缓存不存在');
	}

	// 获取缓存数据
	public function getCacheData($id) {
		$fileName = $this->hasCache($id);
		if(!$fileName){
			return false;
		}

		if($this->cache_mod == 1) {
			$fp = @fopen($fileName, 'r');
			$data = @fread($fp, filesize($fileName));
			@fclose($fp);
			return unserialize($data);
		}
		return include $fileName;
	}
	
	// 清空缓存
	public function flushCache() {
		$glob = @glob($this->getCacheDir().'/'.$this->cache_prefix.'*.php');
		if($glob) {
			foreach($glob as $item) {
				$id = $this->getCacheName($item);
				$this->deleteCache($id);
			}
		}
		return true;
	}
}
