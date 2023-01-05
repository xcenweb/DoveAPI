<?php
// 此级目录下所有的header、ini设置
$this->start([
    // 跨域设置
    'origin' => '*',

    // 设置声明的请求方法
    'methods' => '*',

    // 设置http标头
    'header' => [
        'HTTP/1.1 200 OK',
    ],

    // 设置phpini
    'ini' => [],
]);