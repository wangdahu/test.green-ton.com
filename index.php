<?php
/**
  * 应用入口文件
  * @author wangdahu
  * @version 1.0
  */
ini_set('display_errors', 'on');
error_reporting(E_ALL);

require dirname(__FILE__).'/system/app.php';

require dirname(__FILE__).'/config/config.php';


Application::run($CONFIG);
