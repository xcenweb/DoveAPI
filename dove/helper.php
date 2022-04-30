<?php
/**
 *  DoveApi - 使您快速编写Api接口的PHP框架
 *  
 *  这里是框架的助手函数
 *  
 *  @github: https://github.com/xcenweb/DoveApi
 *  @author: guge
 *  @qqgroup:489921607
 *
 */
use dove\Config;

/**
 * 获取配置
 * @param string $select 配置名称
 * @param mixed $def 默认内容
 * @return mixed
 */
function config($select = '', $def = '')
{
    if(!empty($select)){
        $select = explode('.',$select);
        return Config::get($select[0],$select[1],$def);
    }
    return false;
}

/**
 * 临时增加或修改配置
 * @param mixed $name 配置名称
 * @param array $value 配置内容
 * @return boolean
 */
function set_config($name = '', $value = [])
{
    return Config::set($name,$value);
}

/**
 * 找到函数所在的位置
 * @param mixed $name 函数名称
 * @return string
 */
function function_dump($funcname) {
    try {
        if(is_array($funcname)) {
            $func = new \ReflectionMethod($funcname[0], $funcname[1]);
            $funcname = $funcname[1];
        } else {
            $func = new \ReflectionFunction($funcname);
        }
    } catch (\ReflectionException $e) {
        die($e->getMessage());
        return;
    }
    $start   = $func->getStartLine() - 1;
    $end     = $func->getEndLine() - 1;
    $filename= $func->getFileName();
    die("已找到函数 $funcname 在文件 [$filename]:$start-$end行)");
}

// = = = = = = = = = = = = = = = = = =

/**
 *  DoveApi - 使您快速编写Api接口的PHP框架
 *  
 *  这里是框架的函数库
 *  
 *  @github: https://github.com/xcenweb/DoveApi
 *  @author: guge
 *  @qqgroup:489921607
 *
 */

/**
 * 获取真实ip
 * @return string
 */
function get_ip()
{
	if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$ip = $_SERVER['REMOTE_ADDR'];
	} elseif (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$ip = getenv('REMOTE_ADDR');
	}
	preg_match("/[\\d\\.]{7,15}/", isset($ip) ? $ip : NULL, $match);
	return isset($match[0]) ? $match[0] : 'unknown';
}

/**
 * 截取字符串右边的内容
 * @param string $str 原字符
 * @param string $q 左边的字符
 * @param integer $offset 查询偏移量
 * @return string
 */
function mb_str_right($str, $q, $offset = 0)
{
    return mb_substr($str, mb_strpos($str, $q, $offset) + mb_strlen($q), mb_strlen($str));
}

/**
 * http method
 * @param string $m_n 使用的方法、方法名
 * @param string $def 默认的内容
 * @return string
 */
function M($m_n,$def='')
{
    $m_n = explode('.',$m_n);
    $m = $m_n[0];
    $n = $m_n[1];
    if($m=="get"||$m=="g"){
        return isset($_GET[$n])?$_GET[$n]:$def;
    } elseif ($m=="post"||$m=="p"){
        return isset($_POST[$n])?$_POST[$n]:$def;
    } elseif ($m=="request"||$m=="r"){
        return isset($_REQUEST[$n])?$_REQUEST[$n]:$def;
    }
    return false;
}