<?php
API::start([
    // 设置声明的请求方法
    'methods' => '*',

    // 设置http标头
    'header' => [
        'HTTP/1.1 200 OK',
    ],

    // 设置phpini
    'ini' => [],
]);