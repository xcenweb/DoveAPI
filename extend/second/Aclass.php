<?php
// 使用多级命名空间
namespace second;
class Aclass
{
    // \second\Aclass::abc();
    public static function abc(){
        echo 'success';
    }
}