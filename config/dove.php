<?php

// 框架配置项

return [
    // 开启调试模式
	'debug' => true,

    // debug模式下错误返回形式 json/page
	'debug_mode' => 'page',

    // 非debug模式(生产环境)下错误返回形式 json/page
	'pe_debug_mode' => 'json',

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