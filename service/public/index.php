<?php
/**
 * 程序入口
 * 
 * @author xlight www.im87.cn
 */


// 文件夹分隔符
define('SEP', DIRECTORY_SEPARATOR);

// 网站根目录
define('ROOT', dirname(__DIR__));

// 框架根目录
define('SYS_ROOT', ROOT . '/vendor/tiny/system');

// public
define('PUBLIC_ROOT', ROOT . '/public');

// 程序根目录
define('APP_ROOT', ROOT . '/application');

// 模块根目录
define('MODULE_ROOT', APP_ROOT . '/Module');

// 引入引导文件
require SYS_ROOT . '/Bootstrap.php';

// 初始化并运行程序
$bootstrap = System\Bootstrap::getInstance();
$bootstrap->init()->runApplication();
/**/
