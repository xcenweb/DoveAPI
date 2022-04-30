<?php
// 数组操作
使用工具类 Arr;

$arrayA = [
    'test' => [
        'abcd' => 556677,
        'ABCD' => ['五五','六六',],
    ],
    'doveapi' => [45,25,36,80],
];

$arrayB = ['4566z1','doveapi','gugu','fff','0o0O0oO'];

echo '<b>拆分数组</b><br>';

// 将一个多维数组拆分成 键=>值
print_r(Arr::divide($arrayA));

echo '<hr><br><b>打乱数组</b><br>';

// 打乱数组或输出被打乱的数组的第一个值
// 第二个值为true（默认）时输出被打乱的数组，为false时输出打乱数组的第一个的值
print_r(Arr::random($arrayB));
echo '<br>';
var_dump(Arr::random($arrayB,false));
echo '<br>';
var_dump(Arr::random($arrayB,false,3));

echo '<hr>';