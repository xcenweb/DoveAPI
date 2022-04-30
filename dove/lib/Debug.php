<?php 
declare(strict_types=1);
namespace dove;

use dove\Config;
use dove\Route;
use dove\Log;
use dove\App;

// 抛错
class Debug
{
    private static $code; //错误码
    private static $info; //报错信息
    private static $file; //定位文件
    private static $backtrace = []; //回溯信息数组
    private static $tplDir = DOVE_DIR.'tpl/debug/'; //模板目录
    
    // 综合分类报错
    public static function e($code=500,$info='',$file='')
    {
        self::$code = $code;
        self::$info = $info;
        self::$file = $file;
        self::$backtrace = array_reverse(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
	      $debug = Config::get('dove','debug',false);
	      $debug_mode = (Config::get('dove','debug_mode','page')=='page')?true:false;
	      $pe_debug_mode = (Config::get('dove','pe_debug_mode','page')=='page')?true:false;
	      ob_clean();
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])&&strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
            Log::saveErr(self::$file,self::$info,'(ajax)');
            $tpl = ($debug)?'':'pe_';
            die(self::json($tpl.'json'));
        }
        // @todo:此流程待优化
        if($debug){
            // debug
            Log::saveErr(self::$file,self::$info,'调试模式报错');
            if($debug_mode) die(static::page());
            die(static::json());
        }else{
            // 生产环境
            Log::saveErr(self::$file,self::$info,'生产环境报错');
            if($pe_debug_mode) die(static::page('pe_page'));
            die(static::json('pe_json'));
        }
    }

    // 输出页面
    private static function page($tpl='page')
    {
        $stack = '';
	    $line = 1;
	    foreach(self::$backtrace as $key => $val){
		    $stack.= "<kbd>{$line}.</kbd> is ";
	    	if(isset($val['class'])) $stack.='<u>'.$val['class'].'</u>'.$val['type'];
		    if(isset($val['function'])) $stack.= ($val['function']=='{closure}') ? '<font color="red"><b>{closure}</b></font>' : '<mark>'.$val['function'].'()</mark>';
		    if(isset($val['file']) && isset($val['line'])) $stack.='在文件 [<u>'.$val['file'].']</u> <b>第'.$val['line'].'行</b>';
	    	$stack.= "\r\n";
		    $line++;
	    }
	    $array = [
	        'domain'=>Route::domain(),
	        'err_code'=>self::$code,
	        'err_info'=>self::$info,
	        'err_file'=>self::$file,
	        'call_stack'=>str_replace('\\','/',$stack),
	        'version'=>DOVE_VERSION,
	        'uncompiled_file'=>str_replace(ROOT_DIR,'',App::$file),
	        'uncompiled_file_content'=>!defined('FME_VERSION')?(file_exists(App::$file))?htmlspecialchars(file_get_contents(App::$file)):'<font color="red">[File Not Found]</font>':'',
	        'compiled_file'=>str_replace(ROOT_DIR,'',App::$cachePath),
	        'compiled_file_content'=>!defined('FME_VERSION')?(file_exists(App::$cachePath))?htmlspecialchars(file_get_contents(App::$cachePath)):'<font color="red">[File Not Found]</font>':'',
	        'exitTime'=>round(microtime(true)-DOVE_START_TIME,8),
	    ];
        $value = [];
        $string= [];
        foreach($array as $val=>$str){
            $value[] = '{$'.$val.'}';
            $string[]= $str;
        }
        return str_replace($value,$string,file_get_contents(self::$tplDir.$tpl.'.tpl'));
    }

    // 输出json
    private static function json($tpl='json')
    {
        header('Content-type: application/json;charset=utf-8');
        $stack = [];
	   	$line = 1;
	    foreach(self::$backtrace as $key => $val){
	   		if(isset($val['class'])) $stack['#'.$line]['do']=$val['class'].$val['type'];
		   	if(isset($val['function'])) $stack['#'.$line]['do']= ($val['function']=='{closure}') ? '{closure}' : $val['function'].'()';
		   	if(isset($val['file']) && isset($val['line'])) $stack['#'.$line]['in']=$val['file'].':'.$val['line'];
		    $line++;
	    }
	    $code = self::$code;
	   	$info = self::$info;
	    $file = self::$file;
        $array = require(self::$tplDir.$tpl.'.php');
        return json_encode($array,JSON_UNESCAPED_UNICODE);
    }
}