<?php
使用框架类 Log;
// 框架log函数

// ====错误信息log====
Log::saveErr('错误文件','错误信息','错误备注');

// =====自定义log=====
// ['关键字'=>'值'],log/{$path}/,log文件名,log类型
Log::save(['日期'=>date("Y年m月d日 H时i分s秒")],'test','test_log','test');

// ['关键字'=>'值'],config/dove.php中配置名
Log::save(['日期'=>date("Y年m月d日 H时i分s秒")],'eg');