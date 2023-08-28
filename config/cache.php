<?php
// DoveAPI 框架缓存设置

return [

    // 文件缓存
    'file' => [
        'path' => DOVE_RUNTIME_DIR.'cache/file/',// 缓存文件存储路径
        'suffix' => '.data',// 缓存文件后缀
        'compress_level' => 6,// 数据压缩级别 0～9
    ],

    // Memcache缓存
    'memcache' => [
        'host' => '127.0.0.1',// 主机
        'port' => 11211,// 端口
        'threshold' => 20000,// 自动压缩的阈值
        'min_saving' => 0.2,// 数据压缩率 0～1
        'auto_compress' => false,// 大值自动压缩
    ],

];