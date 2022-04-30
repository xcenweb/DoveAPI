<?php
// debug模式下json错误返回
return [
    'code' => $code,
    'message' => '程序运行时发生错误',
    'debug' => [
        'file' => $file,
        'info' => $info,
        'callStack'=>$stack,
    ],
    'DoveAPI_version' => DOVE_VERSION,
];