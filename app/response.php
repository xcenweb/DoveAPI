<?php 

if (M('get.q') == 'xml') {
    // 输出模板xml，输出后后面的不会被运行
    dove()->response->mxml(true, 200, 'this is DoveAPI response XML',[
        'version' => DOVE_VERSION,
        'runtime' => round(microtime(true) - DOVE_START_TIME, 8) . 's',
    ]);
}

if(M('get.') == 'json') {
    // 输出模板json，输出后后面的不会被运行
    dove()->response->mjson(true, 200, 'this is DoveAPI response JSON',[
        'version' => DOVE_VERSION,
        'runtime' => round(microtime(true) - DOVE_START_TIME, 8) . 's',
    ]);
}

// 设置统一输出 json/xml/void mjson/mxml
dove()->response->set_uni('mjson');

// 统一输出
dove()->response->uni(true, 404, '姿势似乎不正确？');