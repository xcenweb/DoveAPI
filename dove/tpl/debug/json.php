<?php
// debug模式下json错误返回
return [
    'code' => $code,
    'message' => '程序运行时发生错误',
    'debug' => [
        'file' => $file,
        'info' => $info,
        'call_stack' => $stack,
        'get' => $_GET,
        'post' => $POST,
    ],
    'DoveAPI' => DOVE_VERSION,
];