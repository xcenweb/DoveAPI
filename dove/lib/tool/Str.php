<?php
declare(strict_types=1);
//字符串操作助手类，部分代码来自互联网
namespace dove\tool;
use dove\Debug;

class Str
{
    /**
     * 转为首字母大写的标题格式
     * @param  string $value
     * @return string
     */
    public static function title($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * 字符串转小写
     * @param  string $value
     * @return string
     */
    public static function lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * 字符串转大写
     * @param  string $value
     * @return string
     */
    public static function upper($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    /**
     * 获取字符串的长度
     * @param  string $value
     * @return int
     */
    public static function length($value)
    {
        return mb_strlen($value);
    }

    /**
     * 截取字符串右边的内容
     * @param string $str 原字符
     * @param string $q 左边的字符
     * @param integer $offset 偏移量
     * @return string
     */
    public static function ic_right($str,$q,$offset = 0)
    {
        return mb_substr($str, mb_strpos($str, $q, $offset) + mb_strlen($q), mb_strlen($str), 'UTF-8');
    }

    /**
     * php截取指定两个字符之间字符串
     * @param string $input 输入字符串
     * @param string $start 开始字符串
     * @param string $end 结束字符串
     * @return string
     */
    public static function ic_both($input,$start = '',$end = '')
    {
        return substr($input,strlen($start)+strpos($input,$start),(strlen($input)-strpos($input,$end))*(-1));
    }

    /**
     * 只替换一次字符串
     * @parma string $needle 要查找的字符串
     * @parma string $replace 替换为字符串
     * @parma string $haystack 被搜索字符串
     * @return string
     */
    public static function replace_once($needle,$replace,$haystack) {
        $pos = strpos($haystack, $needle);
        if($pos===false) return $haystack;
        return substr_replace($haystack,$replace,$pos,strlen($needle));
    }
}