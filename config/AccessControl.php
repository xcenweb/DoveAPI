<?php
// 访问控制
return [
    // 默认执行文件(可以理解为...默认打开目录中的文件)
    'default_file' => 'index.php',

    // 禁止被访问的目录名，被禁止后访问会返回框架404错误
    'padlock' => [],
    
    // 框架管理器设置
    'FrameworkManage' => [
        'entry' => 'gu-fme',  //入口，为 false 时不开启
        'username' => 'admin',//用户名
        'password' => 'admin',//密码
        'ip' => false,        //ip限制
        'safecode' => '&0oO0$#', //加密密码，尽量使用随机密码生成器生成
    ],
];