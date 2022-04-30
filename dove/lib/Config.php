<?php 
declare(strict_types=1);

namespace dove;
use dove\Debug;

// 配置
class Config
{

    public static $_config = [];
    private static $_ext = '.php';

    /**
     * 获取配置
     */
    public static function get($name,$con='*',$def='',$uri='config')
    {
        if(isset(self::$_config[$name])){
            if($con=='*') return isset(self::$_config[$name])?self::$_config[$name]:[];
            return isset(self::$_config[$name][$con])?self::$_config[$name][$con]:$def;
        }
        static::pull($name,$uri);
        if($con=='*') return isset(self::$_config[$name])?self::$_config[$name]:[];
        return isset(self::$_config[$name][$con])?self::$_config[$name][$con]:$def;
    }

    /**
     * 临时设置或修改配置
     */
    public static function set($name,$set=[])
    {
        isset(self::$_config[$name])?array_merge(self::$_config[$name],$set):self::$_config[$name]=$set;
        return true;
    }
    
    /**
     * 拉取配置
     */
    private static function pull($name,$uri='config')
    {
        if(isset(self::$_config[$name])) return self::$_config[$name];
        $conf = ROOT_DIR.$uri.'/'.$name.self::$_ext;
        if(!file_exists($conf)) Debug::e(500,"配置文件 {$conf} 不存在",$conf);
        return self::$_config[$name] = require $conf;
    }
}