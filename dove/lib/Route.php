<?php 
declare(strict_types=1);
namespace dove;
class Route
{
    // 获取当前带 QUERY_STRING 的url
    public static function url($domain = false)
    {
        $url = (isset($_SERVER['HTTP_X_REWRITE_URL']))?$_SERVER['HTTP_X_REWRITE_URL']:(isset($_SERVER['REQUEST_URI']))?$_SERVER['REQUEST_URI']:'';
        return $domain?static::domain().$url:$url;
    }
    
    // 获取当前不带QUERY_STRING的url
    public static function baseUrl($domain = false)
    {
        $str = static::url();
        $baseUrl = strpos($str,'?')?strstr($str,'?',true):$str;
        return $domain?static::domain().$baseUrl:$baseUrl;
    }
    
    // 获取当前执行的文件
    public static function baseFile($file = null)
    {
        $script_name = basename($_SERVER['SCRIPT_FILENAME']);
        return (basename($_SERVER['SCRIPT_NAME'])===$script_name)?$_SERVER['SCRIPT_NAME']:(basename($_SERVER['PHP_SELF'])===$script_name)?$_SERVER['PHP_SELF']:'';;
    }
    
    // 带协议的域名
    public static function domain()
    {
        return (static::isHttps()?'https':'http').'://'.($_SERVER['HTTP_HOST']??$_SERVER['SERVER_NAME']);
    }
    
    // 判断是否为https
    public static function isHttps()
    {
        return (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && !strcasecmp('https', $_SERVER['HTTP_X_FORWARDED_PROTO']))||(!empty($_SERVER['HTTP_X_FORWARDED_PORT']) && 443 == $_SERVER['HTTP_X_FORWARDED_PORT'])||(!empty($_SERVER['HTTPS']) && 'off' != strtolower($_SERVER['HTTPS']))||(!empty($_SERVER['SERVER_PORT']) && 443 == $_SERVER['SERVER_PORT']);
    }
}