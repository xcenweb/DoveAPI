<?php
declare(strict_types=1);
//数组操作助手类，部分代码来自互联网
namespace dove\tool;
use dove\Debug;

class Arr
{
    // 将一个多维数组拆分成 键=>值
    public static function divide($array)
    {
        return [array_keys($array), array_values($array)];
    }
    
    // 输出被打乱的$array或输出被打乱的$array的第$count个值
    // $print值为true（默认）时输出被打乱的数组，为false时输出打乱数组的第一个的值
    public static function random($array,$print=true,$count=0)
    {
        shuffle($array);
        return $print?$array:$array[$count];
    }
}