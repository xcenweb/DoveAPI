<?php
declare(strict_types=1);

namespace dove;

class Plugin
{
    // 插件是否存在
    public static function exists($name='')
    {
        return is_file(DOVE_PLUGIN_DIR.$name.'.php');
    }
    
    // 带回调加载插件，插件不存在不报错
    public static function use($name,$value=[],$method='initial')
    {
        if(!static::exists($name)) return (count($value)==1)?$value[0]:$value;
        return call_user_func_array("\\dove\\plugin\\{$name}::{$method}",$value);
    }
    
    // 不带回调加载插件，插件不存在不报错
    public static function load($name,$value=[],$edStop=false,$method='initial')
    {
        if(!static::exists($name)) return false;
        call_user_func_array("\\dove\\plugin\\{$name}::{$method}",$value);
        if($edStop) exit();
    }
}