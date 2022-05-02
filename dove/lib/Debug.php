<?php 
declare(strict_types=1);
namespace dove;

use dove\Log;
use dove\App;
use dove\Route;
use dove\Config;
use dove\Plugin;

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
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])&&strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
            Log::saveErr(self::$file,self::$info,'(ajax)');
            static::json(($debug)?'json':'pe_json');
        }
        Log::saveErr(self::$file,self::$info,($debug)?'调试模式报错':'生产环境报错');
        $debug_mode = (Config::get('dove','debug_mode','page')=='page')?true:false;
	    $pe_debug_mode = (Config::get('dove','pe_debug_mode','page')=='page')?true:false;
        ($debug)?($debug_mode)?static::page('page'):static::json('json'):($pe_debug_mode)?static::page('pe_page'):static::page('json');
    }

    // 输出页面
    private static function page($tpl)
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
	        'exitTime'=>round(microtime(true)-DOVE_START_TIME,8),
	    ];
	    if (Plugin::exists('Compiling')) {
	        $uncf_content = Plugin::exists('Fme')?(file_exists(App::$file))?htmlspecialchars(file_get_contents(App::$file)):'[File Not Found]':'[File Not Found]';
	        $cf_content = Plugin::exists('Fme')?(file_exists(App::$cachePath))?htmlspecialchars(file_get_contents(App::$cachePath)):'[File Not Found]':'[File Not Found]';
	        $array['mistake_file'] = '<div class="mdui-row"><div class="mdui-col-xs-12 mdui-col-sm-6"><div class="mdui-typo"><h3> 未编译文件 </h3><small>'.str_replace(ROOT_DIR,'',App::$file).'</small></div><pre><code>'.$uncf_content.'</code></pre></div><div class="mdui-col-xs-12 mdui-col-sm-6"><div class="mdui-typo"><h3> 编译后文件 </h3><small>'.str_replace(ROOT_DIR,'',App::$cachePath).'</small></div><pre><code>'.$cf_content.'</code></pre></div></div>';
	    } else {
	        $content = Plugin::exists('Fme')?(file_exists(App::$file))?htmlspecialchars(file_get_contents(App::$file)):'[File Not Found]':'[File Not Found]';
	        $array['mistake_file'] = '<div class="mdui-typo"><h3> 发生错误的文件 </h3><small>'.str_replace(ROOT_DIR,'',App::$file).'</small></div><pre><code>'.$content.'</code></pre></div>';
	    }
        $value = [];
        $string= [];
        foreach($array as $val=>$str){
            $value[] = '{$'.$val.'}';
            $string[]= $str;
        }
        ob_clean();
        die(str_replace($value,$string,file_get_contents(self::$tplDir.$tpl.'.tpl')));
    }

    // 输出json
    private static function json($tpl)
    {
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
        ob_clean();
        header('Content-type: application/json;charset=utf-8');
        die(json_encode($array,JSON_UNESCAPED_UNICODE));
    }
}