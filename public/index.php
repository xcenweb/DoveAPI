<?php
/**
 * 欢迎您使用 DoveApi框架！
 *
 * 这里是框架的入口文件
 *
 */
// 先设置一个header防止乱码
header('content-type:text/html;charset=utf-8');
// 然后载入核心文件
require '../dove/DoveAPI.php';
// 开启路由
\dove\App::start();

//这后面不要有任何代码哟！除非是最后要执行的，咕～