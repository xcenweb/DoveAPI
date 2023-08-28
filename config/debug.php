<?php
// DoveAPI 框架报错设置

return [

    // 开发模式(debug=true)下错误返回形式 json/page
	'debug_mode' => 'page',

    // 生产模式(debug=false)下错误返回形式 json/page
	'pe_debug_mode' => 'json',

	// 设置生产环境下报错返回json、tpl文件位置
	'pe_debug_mode_json_path' => DOVE_DATA_DIR.'tpl/debug/pe_json.php',
	'pe_debug_mode_page_path' => DOVE_DATA_DIR.'tpl/debug/pe_page.tpl',
	
	// （框架内置，不建议自定义修改）设置开发环境下报错返回json、tpl文件位置
	'debug_mode_json_path' => ROOT_DIR.'vendor/xcenweb/doveapi-core/src/tpl/debug/json.php',
	'debug_mode_page_path' => ROOT_DIR.'vendor/xcenweb/doveapi-core/src/tpl/debug/page.tpl',

];