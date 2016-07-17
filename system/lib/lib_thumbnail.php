<?php
/**
  * 生成缩略图
  *
  */
class Thumbnail {
	private $maxWidth;
	private $maxHeight;
	private $scale;
	private $inflate;
	private $types;
	private $imgLoaders;
	private $imgCreators;
	private $source;
	private $sourceWidth;
	private $sourceHeight;
	private $sourceMime;
	private $thumb;
	private $thumbWidth;
	private $thumbHeight;

	public function __construct($maxWidth=200, $maxHeight=200, $scale = true, $inflate =true) {
		$this->maxWidth = $maxWidth;
		$this->maxHeight = $maxHeight;
		$this->scale = $scale;
		$this->inflate = $inflate;
		$this->types = array('image/jpeg', 'image/png', 'image/gif');

		$this->imgLoaders = array(
			'image/jpeg' => 'imagecreatefromjpeg',
			'image/png' => 'imagecreatefrompng',
			'image/gif' => 'imagecreatefromgif'
		);

		$this->imgCreators = array(
			'image/jpeg' => 'imagejpeg',
			'image/png' => 'imagepng',
			'image/gif' => 'imagegif'
		);
	}
	
	public function loadFile($image) {
		if(!$dims = @getimagesize($image)) {
			trigger_error("源图片不存在"); 
		}
		if(in_array($dims['mime'], $this->types)) {
			$loader = $this->imgLoaders[$dims['mime']];
			$this->source = $loader($image);
			$this->sourceWidth = $dims[0];
			$this->sourceHeight = $dims[1];
			$this->sourceMime = $dims['mime'];
			$this->initThumb();
			return true;
		}else {
			trigger_error("不支持".$dims['mime']."图片类型"); 
		}
	}

	public function loadData($image, $mime) {
		if(in_array($mime, $this->types)) {
			if($this->source = @imagecreatefromstring($image)) {
				$this->sourceWidth = imagesx($this->source);
				$this->sourceHeight = imagesx($this->source);
				$this->sourceMime = $mime;
				return true;
			}else {
				trigger_error("不能从字符串加载图片");
			}
		}else {
			trigger_error("不支持".$mime."图片格式");
		}
	}

	public function buildThumb($file = null) {
		$creator = $this->imgCreators[$this->sourceMime];
		if(isset($file)) {
			return $creator($this->thumb, $file);
		}else {
			return $creator($this->thumb);
		}
	}

	public function initThumb() {
		if($this->scale) {
			if($this->sourceWidth > $this->sourceHeight) {
				$this->thumbWidth = $this->maxWidth;
				$this->thumbHeight = floor($this->sourceHeight*($this->maxWidth/$this->sourceHeight));
			}elseif($this->sourceWidth < $this->sourceHeight) {
				$this->thumbHeight = $this->maxHeight;
				$this->thumbWidth = floor($this->sourceWidth*($this->maxHeight/$this->sourceHeight));
			}else {
				$this->thumbWidth = $this->maxWidth;
				$this->thumbHeight = $this->maxHeight;
			}
		}
		$this->thumb = imagecreatetruecolor($this->thumbWidth, $this->thumbHeight);

		if($this->sourceWidth <= $this->maxWidth && $this->sourceHeight <= $this->maxHeight && $this->inflate == false) {
			$this->thumb = $this->source;
		}else {
			imagecopyresampled($this->thumb,$this->source, 0, 0, 0, 0, $this->thumbWidth, $this->thumbHeight, $this->sourceWidth, $this->sourceHeight);
		}
	}

	public function getMime() {
		return $this->sourceMime;
	}

	public function getThumbWidth() {
		return $this->thumbWidth;
	}




	



}
