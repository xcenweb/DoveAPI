<?php

if (M('g.m') == 'xml') {
    // 输出模板xml
    $this->response->mxml(true,666,'this is DoveAPI',[
        'version'=>DOVE_VERSION,
        'runtime'=>round(microtime(true)-DOVE_START_TIME,8).'s',
    ]);
} else {
    // 输出模板json，输出后后面的不会被运行
    $this->response->mjson(true,666,'this is DoveAPI',[
        'version'=>DOVE_VERSION,
        'runtime'=>round(microtime(true)-DOVE_START_TIME,8).'s',
    ]);
}