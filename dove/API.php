<?php 
use dove\Debug;
use dove\Config;
use dove\tool\ArrToxml;
// 接口的一切操作集合

class API
{
    public static $response_temps;
    public static $uni_response;
    /**
     * 初始化
     * 使用本类任何一个组件方法前必须先调用此方法
     * json模板、默认和临时定义的header、默认和临时phpini设置
     */
    public static function start($set=[])
    {
        $conf = Config::get('api','*');
        self::$response_temps = $conf['response_temps'];
        self::$uni_response = $conf['uni_response'];
        // origin,method
        isset($set['origin'])?header('Access-Control-Allow-Origin:'.$set['origin']):header('Access-Control-Allow-Origin:'.$conf['origin']);
        isset($set['method'])?header('Access-Control-Allow-Methods:'.$m):header('Access-Control-Allow-Methods:'.$conf['methods']);
        if(!empty($set)){
            // header
            $add = isset($set['header'])?$set['header']:[];
            static::set_header($conf['def_header']+$add);
            //ini
            $add = isset($set['ini'])?$set['ini']:[];
            static::set_ini($conf['def_ini']+$add);
        }
        return true;
    }

    public static function set_header($array=[])
    {
        foreach($array as $string=>$replace){
            is_numeric($string)?header($replace):header($string,$replace);
        }
        return true;
    }

    public static function set_ini($array=[])
    {
        foreach($array as $varname=>$newvalue){
            if(ini_get($varname)) ini_set($varname,strval($newvalue));
        }
        return true;
    }

    // 统一执返
    public static function m()
    {
        if(func_num_args()==0) Debug::e(500,'class Api::m 参数不能为空');
        ob_clean();
        switch(self::$uni_response){
          case 'json':
            header('Content-type: application/json;charset=utf-8');
            die(json_encode(static::get_temp(func_num_args(),func_get_args()),JSON_UNESCAPED_UNICODE));
          break;
          case 'xml':
            header("Content-type: text/xml;charset=utf-8");
            die(ArrToxml::build(static::get_temp(func_num_args(),func_get_args()),'response'));
          break;
          case 'void':
            static::mvoid();
          break;
        }
        return false;
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

    // http204 空白返回
    public static function mvoid()
    {
        ob_clean();
        header('HTTP/1.1 204 No Content');
        exit;
    }

    public static function get_temp($arg,$args)
    {
        if(!isset(self::$response_temps[$args[0]])) return [];
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