<?php
class pageController extends Controller {
	public function getUrl($page) {
		if(preg_match('/&page=([\d]+)/', $_SERVER['REQUEST_URI'])) {
			return preg_replace('/page=([\d]+)/', 'page='.$page, $_SERVER['REQUEST_URI']);
		}else {
			return $_SERVER['REQUEST_URI'].'&page='.$page;
		}
	}

	public function page($page, $totalPage) {
		if($page < 1 && $totalPage >= 1) {
			$page = 1;
		}else {
			$page = $page >= $totalPage ? $totalPage : $page;
		}
		$pageHtml = '';
		if($page > 0 && $totalPage > 1) { 
			$pageHtml = $pageHtml."<div class='page-main'>";
			if($page > 1) {
				$beforePage = $page - 1;
				$beforeUrl = $this->getUrl($beforePage);
				$pageHtml = $pageHtml."<a href='".$beforeUrl."'><span>< 上一页</span></a>";
			}
		}
		$afterCount = $totalPage - $page;
		$beforeCount = $page - 1;
		$before = $after = 1;
		if($totalPage > 8) {
			if($afterCount >= 4 && $beforeCount >= 4) {
				$after = 4;	
				$before = $page - 4;
			}else if($afterCount > 4 && $beforeCount < 4) {
				$before =  1;
				$after = 8 - $beforeCount;
			}else if($beforeCount > 4 && $afterCount < 4) {
				$after = $afterCount;
				$before = $page - 8 + $after;
			}
		}else {
			$after = $afterCount;
			$before = 1;
		}
		// 上一页
		for($before; $before > 0 && $before < $page; $before++){
			$beforeUrl = $this->getUrl($before);
			$pageHtml = $pageHtml."<a href='".$beforeUrl."'><span>".$before."</span></a>";
		}
		if($page > 0 && $totalPage > 1) { // 当前页 
			$pageHtml = $pageHtml."<a href='javascript:void(0);'><span style='border: none;'>".$page."</span></a>";
		}
		// 下一页
		for($i = 1; $i <= $after; $i++){
			$nextPage = $page + $i;
			$nextUrl = $this->getUrl($nextPage);
			$pageHtml = $pageHtml."<a href='".$nextUrl."'><span>".$nextPage."</span></a>";
		}
		if($page < $totalPage) { 
			$nextPage = $page +1;
			$nextUrl = $this->getUrl($nextPage);
			$pageHtml = $pageHtml."<a href='".$nextUrl."'><span>下一页 ></span></a>";
		}
		if($page > 0 && $totalPage > 1) { 
			$pageHtml = $pageHtml."</div>";
		}
	return $pageHtml;

	}

}
