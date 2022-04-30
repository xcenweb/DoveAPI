<?php
declare(strict_types=1);
namespace dove\tool;
// 验证、过滤字符串
use dove\Config;
use dove\Debug;

class Filter
{
    private static $RULES = [];

    // 检验一个字符
    // Filter::validate_once(规则,字符串,允许空字符串内容,闭包函数);
    public static function validate_once($rule='',$str='',$empty=true,$func=null){
        self::initial();
        if($empty && $str!="" || $str!=[]) if(preg_match(self::$RULES[$rule],strval($str))) return true;
        if($func) $func($rule,self::$RULES[$rule],$str);
        return false;
    }

    // 检验多个字符
    // Filter::validate(['规则1'=>[0=>'字符1',1=>'字符2',...],'规则2'=>[0=>'字符']],允许空字符串内容,闭包函数);
    public static function validate($array=[],$empty=true,$func=null){
        self::initial();
        $n_rule = 1;
        foreach($array as $rule=>$strs){
            if(!isset(self::$RULES[$rule])) Debug::e(500,"Filter:规则不存在！");
            if(is_array($strs)){
                // 一规则多字符验证
                foreach($strs as $n_str=>$str){
                    if(!preg_match(self::$RULES[$rule],strval($str)) || $empty && $str=="" || $str==[]){
                         if($func) $func($n_rule,$n_str+1,$rule,self::$RULES[$rule],$str);
                         return false;
                    }
                }
            } else {
                // 一规则一字符验证
                if(!preg_match(self::$RULES[$rule],strval($strs)) || $empty && $str=="" || $str==[]){
                    if($func) $func($n_rule,1,$rule,self::$RULES[$rule],$strs);
                    return false;
                }
            }
            $n_rule++;
        }
        return true;
    }

    // 过滤(替换掉)字符
    // 'rule'=>'to'
    public static function filter($str,$ruleTo=[]){
        $rules = [];
        $tos = [];
        foreach($ruleTo as $rule=>$to){
            $rule[] = $rule;
            $tos[] = $to;
        }
        return preg_replace($rules,$tos,$str);
    }
    
    // 初始化
    private static function initial(){
        if(self::$RULES==[]) self::$RULES = Config::get('filter','*');
        return true;
    }
}