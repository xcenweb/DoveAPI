<?php
// 框架通用数据库配置 可设置多个类型的数据库信息
// Medoo文档：https://medoo.in/doc

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