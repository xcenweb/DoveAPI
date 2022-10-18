<?php
return [

    // $this->start();全局自动运行
    'autoload' => false,

    // 默认的声明的请求方法，多个用半角逗号隔开
    'methods' => '*',

    // 默认跨域设置
    'origin' => '*',

    // 默认自动加载的header设置
    'header' => [
        'X-Powered-By: DoveAPI-Framework',
		// 'X-Powered-By: DoveAPI-Framework' => false,// 允许相同且多个类型
    ],

    // 默认自动修改的ini设置
    'ini' => [
		'display_errors' => 0,
	],

    // 统一执返 $response->uni();
    // 可选 json/xml/void/mjson/mxml
    'response_uni' => 'json',

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