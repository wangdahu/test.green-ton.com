<?php
/**
  * 模板类 
  * @author wangdahu
  * @version 1.0
  */

final class Template {
	public $template_name = null;
	public $data = array();
	public $out_put = null;

	public function init($template_name, $data = array()) {
		$this->template_name = $template_name;
		$this->data = $data;
		$this->fetch();
	}

	// 加载模板文件
	public function fetch() {
		$view_file = VIEW_PATH.'/'.$this->template_name.'.php';
		if(file_exists($view_file)) {
			extract($this->data);
			ob_start();
			include $view_file;
			$content = ob_get_contents();
			ob_end_clean();
			$this->out_put = $content;
		}else {
			trigger_error('加载'.$view_file.'模板文件不存在');
		}
	}


	// 输出模板
	public function outPut() {
		echo $this->out_put;
	}

}
