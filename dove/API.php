<?php 

use dove\Config;
use dove\tool\ArrToxml;
// 接口的一切操作集合

class API
{
    public static $response_temps;
    
    /**
     * 初始化
     * 使用本类任何一个组件方法前必须先调用此方法
     * json模板、默认和临时定义的header、默认和临时phpini设置
     */
    public static function start($set=[])
    {
        $conf = Config::get('api','*');
        if(!empty($set)){
            self::$response_temps = $conf['response_temps'];
            isset($set['method'])?header('Access-Control-Allow-Methods:'.$m):header('Access-Control-Allow-Methods:'.$conf['methods']);
            $add = isset($set['header'])?$set['header']:[];
            static::set_header($conf['def_header']+$add);
            $add = isset($set['ini'])?$set['ini']:[];
            static::set_ini($conf['def_ini']+$add);
        }
        return true;
    }

    public static function set_header($array=[])
    {
        // http header
        foreach($array as $string=>$replace){
            is_numeric($string)?header($replace):header($string,$replace);
        }
        return true;
    }

    public static function set_ini($array=[])
    {
        // php ini
        foreach($array as $varname=>$newvalue){
            if(ini_get($varname)) ini_set($varname,strval($newvalue));
        }
        return true;
    }

    /**
     * 模板输出json。输出后停止运行
     * 
     * 模板示例 true => ['code'=>'int','msg'=>'text','data'=>'array']
     * 使用示例 Api::mjson(true,200,'值二',['值三','值四']);
     * 返回示例 {"code":200,"msg":"值二","data":["值三","值四"]}
     *
     */
    public static function mjson()
    {
        if(func_num_args()==0) Debug::e(500,'class Api::mjson 参数不能为空');
        ob_clean();
        header('Content-type: application/json;charset=utf-8');
        die(json_encode(static::get_temp(func_num_args(),func_get_args()),JSON_UNESCAPED_UNICODE));
    }
    
    /**
     * 模板输出xml。输出后停止运行
     * 
     * 模板示例 true => ['code'=>'int','msg'=>'text','data'=>'array']
     * 使用示例 Api::mjson(true,200,'值二',['值三','值四']);
     * 返回示例 <?xml version="1.0" encoding="UTF-8"?><response><code>200</code><msg>text</msg><data>array</data></response>
     *
     */
    public static function mxml()
    {
        if(func_num_args()==0) Debug::e(500,'class API::mxml 参数不能为空');
        ob_clean();
        header("Content-type: text/xml;charset=utf-8");
        die(ArrToxml::build(static::get_temp(func_num_args(),func_get_args()),'response'));
    }
    
    public static function get_temp($arg,$args)
    {
        $temp  = self::$response_temps[$args[0]];
        $tempNum = count($temp);
        $i = 1;
        $array = [];
        foreach($temp as $name=>$def){
            if($tempNum < $i) break;
            $array = isset($args[$i])?array_merge($array,[$name=>$args[$i]]):array_merge($array,[$name=>$def]);
            $i++;
        }
        return $array;
    }
}