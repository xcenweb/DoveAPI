<?php
// 框架访问控制
return [

    // 默认执行文件
    'default_file' => 'index.php',

    // 禁止被访问的目录名，被禁止后访问会返回框架404错误
    'padlock' => ['dev'],

    // TODO 指定路径绑定域名
    'band' => [
        // test.xcenadmin.top => app/abc/index.php
        // test.xcenadmin.top/xyz => app/abc/xyz.php
        'test' => 'abc',
    ],
    
];