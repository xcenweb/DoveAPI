<?php
return [

    // 默认的声明的请求方法，用半角逗号隔开
    'methods' => '*',

    // 默认自动加载的header设置
    'def_header' => [
        'X-Powered-By: DoveAPI-Framework',
        'Access-Control-Allow-Origin:*',
    ],

    // 默认自动修改的ini设置
    'def_ini' => [],
    
    // 模板 mjson、mxml方法通用
    'response_temps' => [
        //成功 值=>默认
        true => [
            'code'   => 200,
            'message'=> '成功',
            'data'   => [],
        ],
    
        //失败 值=>默认
        false => [
            'code'   => 500,
            'message'=> '发生错误',
            'data'   => [],
        ],
    ],
];