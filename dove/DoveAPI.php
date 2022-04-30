<?php 

/**
 *  DoveApi 0.x系列 - 使您快速编写Api接口的PHP框架
 *
 *  @github: https://github.com/xcenweb/DoveApi
 *  @author: guge
 *  @qqgroup:489921607
 *
 */
use dove\Debug;
use dove\Config;

define('DOVE_VERSION','1.0.1');
define('DOVE_START_TIME',microtime(true));

define('ROOT_DIR',str_replace(['\\','//'],'/',dirname(__DIR__)).'/');
define('DOVE_DIR',ROOT_DIR.'dove/');           // 核心目录
define('DOVE_LIBRARY',DOVE_DIR.'lib/');        // 支持目录
define('DOVE_PLUGIN_DIR',DOVE_DIR.'plugin/');  // 插件目录
define('DOVE_APP_DIR',ROOT_DIR.'app/');        // 应用目录
define('DOVE_CONFIG_DIR',ROOT_DIR.'config/');  // 配置目录
define('DOVE_DATA_DIR',ROOT_DIR.'data/');      // 数据目录
define('DOVE_EXTEND_DIR',ROOT_DIR.'extend/');  // 扩展目录
define('DOVE_PUBLIC_DIR',ROOT_DIR.'public/');  // 公共访问目录
define('DOVE_RUNTIME_DIR',ROOT_DIR.'runtime/');// 运行目录

require DOVE_DIR.'helper.php';
require DOVE_DIR.'API.php';
set_error_handler(function ($level,$msg,$file,$line){
    $levels = [E_STRICT=>'Strict',E_NOTICE=>'Notice',E_WARNING=>'Warning',E_DEPRECATED=>'Deprecated',E_USER_ERROR=>'User Error',E_USER_NOTICE=>'User Notice',E_USER_WARNING=>'User Warning',E_USER_DEPRECATED=>'User Deprecated'];
    $level = isset($levels[$level])?$levels[$level]:'Unkonw error';
	Debug::e(500,"{$level}: {$msg} in {$file} on {$line}",$file);
});
spl_autoload_register(function ($className){
    $clist = ['extend\\'=>DOVE_EXTEND_DIR,'dove\\plugin\\'=>DOVE_PLUGIN_DIR,'dove\\'=>DOVE_LIBRARY];
    foreach($clist as $namespace => $dir){
        if(mb_substr($className, 0, mb_strlen($namespace)) != $namespace) continue;
        $file = str_replace("\\", "/", $dir . mb_str_right($className, $namespace)) . ".php";
        if(!file_exists($file)) Debug::e(500,"未找到类{$className}[{$file}]");
		require $file;
		return true;
    }
});
set_include_path(get_include_path().PATH_SEPARATOR.DOVE_EXTEND_DIR.'/');
date_default_timezone_set('PRC');
Config::get('dove','debug')?error_reporting(E_ALL):error_reporting(0);
ob_start();