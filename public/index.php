<?php
/**
 * 欢迎您使用 DoveAPI框架！
 *
 * 这里是框架的入口文件
 *
 */

header('Content-type:text/html;charset=utf-8');
require __DIR__.'/../vendor/autoload.php';
(new \dove\App())->run();

// 这后面不要有任何代码哟！除非是最后要执行的，咕～