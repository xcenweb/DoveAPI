<?php 
/**
 * DoveAPI 加密/解密/编码/解码 类
 * 
 * @author:xcenweb
 * @email:1610943675@qq.com
 *
 */
namespace dove\plugin;
use dove\Config;

class Encrypt
{
    public $string; // 待加密字符
    
    /**
     * 生成可加盐的32位或16位md5,默认32位
     * @parma string $string 待加密数据
     * @parma string $salt 盐值[首,尾]
     * @parma boolean $raw T16bit-F32bit
     * @return string
     */
    public static function md5_encode($string='',$salt=null,$raw=false)
    {
        return md5(static::addSalt($string,$salt),$raw);
    }
    
    /**
     * md5解密，彩虹表查询，咕一段时间
     * @parma $string md5加密字符
     * @return mixed
     */
    public static function md5_decode($string)
    {
        
    }
    
    /**
     * mcrypt 加密，不同于php自带的mcrypt
     * @parma string $string 待加密数据
     * @parma string $key 密码，默认框架安全码
     * @parma int $expiry 有效时间，为零不限
     * @return string
     */
    public static function mcrypted_encode($string,$key='',$expiry=0){
		$ckeyLength = 4;
		$key = md5($key ? $key : self::$default_key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = substr(md5(microtime()), - $ckeyLength);
		$cryptkey = $keya . md5($keya . $keyc);  
		$keyLength = strlen($cryptkey);
		$string = sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string . $keyb), 0, 16) . $string;
		$stringLength = strlen($string);
 
		$rndkey = array();	
		for($i = 0; $i <= 255; $i++) {	
			$rndkey[$i] = ord($cryptkey[$i % $keyLength]);
		}
 
		$box = range(0, 255);	
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}	
		$result = '';
		for($a = $j = $i = 0; $i < $stringLength; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp; 
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		$result = $keyc . str_replace('=', '', base64_encode($result));
		$result = str_replace(['+', '/', '='],['-', '_', '.'], $result);
		return $result;
	}

    /**
     * mcrypt 解密，不同于php自带的mcrypt
     * @parma string $string 已加密内容
     * @parma string $key 密码，默认框架安全码
     * @return string
     */
	public static function mcrypted_decode($string,$key='')
	{
		$string = str_replace(['-','_','.'],['+','/','='], $string);
		$ckeyLength = 4;
		$key = md5($key ? $key : self::$default_key); //解密密匙
		$keya = md5(substr($key, 0, 16));		 //做数据完整性验证  
		$keyb = md5(substr($key, 16, 16));		 //用于变化生成的密文 (初始化向量IV)
		$keyc = substr($string, 0, $ckeyLength);
		$cryptkey = $keya . md5($keya . $keyc);  
		$keyLength = strlen($cryptkey);
		$string = base64_decode(substr($string, $ckeyLength));
		$stringLength = strlen($string);
 
		$rndkey = array();	
		for($i = 0; $i <= 255; $i++) {	
			$rndkey[$i] = ord($cryptkey[$i % $keyLength]);
		}
		$box = range(0, 255);
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		$result = '';
		for($a = $j = $i = 0; $i < $stringLength; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp; 
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0)
		&& substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)
		) {
			return substr($result, 26);
		} else {
			return '';
		} 
	}

    // 字符串两端增加盐值
    public function addSalt($str='',$salt=null)
    {
        if(is_array($salt)){
            if(isset($salt[0])) $str = $salt[0].$str;
            if(isset($salt[1])) $str.= $salt[1];
        }
        return static::saltTag($str);
    }

    // 替换盐值中的标签
    public static function saltTag($v)
    {
        $v = str_replace([
            '{datetime}','{date}','{time}','{safecode}',
        ],[
            date('YmdHis'),date('Ymd'),date('His'),Config::get('dove','safecode'),
        ],$v);
        return $v;
    }
}