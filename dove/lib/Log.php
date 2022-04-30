<?php
declare(strict_types=1);
namespace dove;
use dove\Route;
class Log
{
    // 自定义log
    public static function save($add=[],$path='unknown',$logname='unknown',$type='unknown')
    {
        if(!Config::get('dove','save_log')) return true;
        if(func_num_args()==2){
            // 使用配置
            $perset = Config::get('dove','log_preset');
            if(!isset($perset[$path])) Debug::e(500,'log：自定义预设['.$path.']不存在');
            $logname = isset($perset[$path][2])?$perset[$path][2]:'unknown';
            $type = isset($perset[$path][0])?$perset[$path][0]:'unknown';
            $path = isset($perset[$path][1])?$perset[$path][1]:'unknown';
        }
        $text = "\r\n[{$type}][".date('Y-m-d H:i:s')."][".get_ip()."]\r\n-请求链接:".Route::url(true)."\r\n-加载时间:".round(microtime(true)-DOVE_START_TIME,8)."\r\n";
        foreach($add as $k=>$v) $text.="-{$k}:{$v}\r\n";
        return static::write($text,DOVE_RUNTIME_DIR.'log/'.$path.'/',$logname.'.log');
    }

    // 错误log
    public static function saveErr($errFile='未知',$errInfo='未知',$remarks='无')
    {
        if(!Config::get('dove','error_log')) return true;
        return static::write("\r\n[ERROR][".date('Y-m-d H:i:s')."][".get_ip()."]\r\n-请求链接:".Route::url(true)."\r\n-文件路径:{$errFile}\r\n-报错内容:{$errInfo}\r\n-加载时间:".round(microtime(true)-DOVE_START_TIME,8)."(s)\r\n-报错备注:{$remarks}\r\n",DOVE_RUNTIME_DIR.'log/'.date('Ym'),date('d').'.log'); 
    }
    
    public static function write($text,$path,$file)
    {
        if(!file_exists($path)) mkdir($path,0777,true);
        return file_put_contents($path.'/'.$file,$text,FILE_APPEND|LOCK_EX);
    }
}