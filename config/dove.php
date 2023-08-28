<?php
// DoveAPI 框架的主要配置项

return [

    /**************************
     *      框架基础配置       *
     **************************/

    // TODO 是否开启中文语法，仅支持 app/* 下中文化
    'cncode' => false,

    // 框架调试模式
	'debug' => true,
	
    // 框架调试状态log记录
    'debug_log'=> true,


    /*************************
     *    框架路由访问控制    *
     *************************/
    
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