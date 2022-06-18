<?php
/**
 * 欢迎您使用 DoveAPI框架！
 *
 * 这里是框架的入口文件
 *
 */

// 先设置一个header防止抛错乱码
header('Content-type:text/html;charset=utf-8');
// 载入
require __DIR__.'/../vendor/autoload.php';
// 开始逻辑
(new \dove\App())->run();

// 这后面不要有任何代码哟！除非是最后要执行的，咕～