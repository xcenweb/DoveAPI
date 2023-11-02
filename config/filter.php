<?php
// DoveAPI 框架字符串验证规则

return [

    '邮箱' => '/^[0-9a-z]+@(([0-9a-z]+)[.])+[a-z]{2,3}$/',

    '数字' => '/^\d+$|^\d+[.]?\d+$/',

	'正整数' => '/^[1-9][0-9]*$/',

	'小数' => '/^\d+[.]?\d+$/',

	'中国大陆手机号' => '/^1[0-9]{10}$/',

	'常见密码' => '/^(?=.*?[a-zA-Z])(?=.*?[0-9])[a-zA-Z0-9_\-\+\,\.\!\$\*\(\)\[\]\{\};:<>#@&=]+$/',
	'中强密码' => '/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])[a-zA-Z0-9_\-\+\,\.\!\$\*\(\)\[\]\{\};:<>#@&=]+$/',
	'高强密码' => '/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[_\-\+\,\.\!\$\*\(\)\[\]\{\};:<>#@&=])[a-zA-Z0-9_\-\+\,\.\!\$\*\(\)\[\]\{\};:<>#@&=]+$/',

	//...
];