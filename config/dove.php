<?php

// 框架配置项

return [
    // 开启调试模式
	'debug' => true,

    // debug模式下错误返回形式 json/page
	'debug_mode' => 'page',

    // 非debug模式(生产环境)下错误返回形式 json/page
	'pe_debug_mode' => 'json',
	
	// 设置生产环境下报错返回json、tpl文件位置
	'pe_debug_mode_json_path' => DOVE_DATA_DIR.'tpl/debug/pe_json.php',
	'pe_debug_mode_page_path' => DOVE_DATA_DIR.'tpl/debug/pe_page.tpl',
	
	// 不建议自定义修改。设置开发环境下报错返回json、tpl文件位置
	'debug_mode_json_path' => ROOT_DIR.'vendor/xcenweb/doveapi-core/src/tpl/debug/json.php',
	'debug_mode_page_path' => ROOT_DIR.'vendor/xcenweb/doveapi-core/src/tpl/debug/page.tpl',
	
    // 是否开启debug-log记录
    'error_log'=> true,

    // 是否开启自定义log记录
    'save_log' => true,

    // 自定义log 相关预设
    // ['类型，默认unknown','目录，默认unknown','记录log的文件名，默认unknown']
    'log_preset' => [
        'eg' => ['Bad','test','test_log'],
    ],
];