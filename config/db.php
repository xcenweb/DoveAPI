<?php 

// 数据库配置 可设置多个类型的数据库信息
// 这里写注释乱且不直观，请到框架文档里查看

// @done $con = Medoo(config('db','index',[]));
// @done $con = Medoo('加载配置>>config');
return [
    'mysql_config' => [
        'type' => 'mysql',
        'host' => 'localhost',
        'database' => '',
        'port' => 3306,
        'username' => '',
        'password' => '',
        'charset' => 'utf-8',
        'prefix' => '',
        'option' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
        ]
    ],
    // More...
];