<?php
declare(strict_types=1);

namespace dove;
use dove\Plugin;
use dove\Debug;
use dove\Config;
use dove\Route;

class App
{
    public static $path;      // 访问的路径
    public static $file;      // 未编译文件
    public static $cacheName; // 缓存文件名称
    public static $cachePath; // 缓存文件路径

    public static function init()
    {
        $baseUrl  = str_replace('//','/',Route::baseUrl());
        $baseUrlArr = explode('/',$baseUrl);
        $pathinfo = pathinfo($baseUrl);
        $AClist = Config::get('AccessControl');

        // 预留的框架管理器(若无用可删
        if(!!$AClist['FrameworkManage']['entry']&&$baseUrlArr[1]==$AClist['FrameworkManage']['entry']) Plugin::load('Fme',[Route::baseUrl(true),$baseUrl,$AClist],true);

        /**
         * 1.是否是一个禁止外部访问的一级目录
         * 2.是否是起始或结束自动加载文件
         * 3.这个方法只进行多级目录检查，但对性能影响可能会有点大，观察一下
         */
        if(in_array($baseUrlArr[1],$AClist['padlock'],true)||in_array($pathinfo['filename'],['__begin','__coda'],true)||in_array(preg_replace("/^\/+?|\/+?$/",'',$baseUrl),$AClist['padlock'],true)) Debug::e(404,'目录或文件['.$baseUrlArr[1].']已被设置为禁止外部访问或为起始、结束文件!');
        $file = ($pathinfo['dirname']=='/'||$pathinfo['dirname']=='.')?($pathinfo['basename']=='')?'/'.$AClist['default_file']:'/'.$pathinfo['basename'].'.php':$pathinfo['dirname'].'/'.$pathinfo['basename'].'.php';
        self::$file = rtrim(DOVE_APP_DIR,'/').$file;
        self::$path = pathinfo(self::$file)['dirname'].'/';
        self::$cacheName = base64_encode($file);
        self::$cachePath = DOVE_RUNTIME_DIR.'cache/'.self::$cacheName.'.php';
        return true;
    }

    public static function start()
    {
        self::init();
        if(!file_exists(self::$file)) Debug::e(404,'路由不存在，路径['.self::$file.']',self::$file);
        if(file_exists(self::$path.'__begin.php')) require self::$path.'__begin.php';

        if(Plugin::exists('Compiling')){
            if(!file_exists(self::$cachePath)){
                static::mk_cache();
            } else {
                // 通过修改时间判断源文件是否更新
                // 生产环境下强烈建议注释掉该句
                if(filemtime(self::$cachePath)<filemtime(self::$file)) static::up_cache();
            }
            require self::$cachePath;
        } else {
            require self::$file;
        }

        if(file_exists(self::$path.'__coda.php')) require self::$path.'__coda.php';
        return true;
    }

    public static function mk_cache()
    {
        $handleA = fopen(self::$file,'r');
        $handleC = fopen(self::$cachePath,'w');
        fwrite($handleC,Plugin::use('Compiling',[fread($handleA,filesize(self::$file))]));
        fclose($handleA);
        fclose($handleC);
        return true;
    }

    public static function up_cache()
    {
        return static::mk_cache();
    }
}