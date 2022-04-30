<?php
使用工具类 ArrToxml;

header("Content-type: text/xml;charset=utf-8");

$array = [
    'code'=>200,
    'user'=>[
      'item1'=>[
        'username'=>'abc',
        'point'=>123,
      ],
      'item2'=>[
        'username'=>'abc',
        'point'=>123,
      ],
    ],
];

echo ArrToxml::build($array,'data');