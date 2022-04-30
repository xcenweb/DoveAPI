<?php
使用框架类 Config;

// 获取配置，返回配置内容
config('配置(或文件)名.配置标识','默认内容');
// 同上，注意第2行的使用
Config::get('配置(文件)名','配置标识','默认内容');


// 临时设置配置，返回布尔值
set_config('配置名',[
    'abc' => 'abc的内容',
]);
// 同上，注意第2行的使用
Config::set('配置名',[
    'abc' => 'abc的内容',
]);
