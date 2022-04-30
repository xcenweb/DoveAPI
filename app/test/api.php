<?php
// API系列实用函数

// 初始化
API::initial([

   // 默认的声明的请求方法，用半角逗号隔开
   'methods'=>'POST,GET',

   // header批量设置
   'header'=>[
       // 'Location: https://m.baidu.com'
   ],

   // ini批量设置
   'ini'=>[
       'max_execution_time'=>60,
   ],
]);

// 模板输出json,输出后停止运行
API::mjson(true,500,'失败');

// 模板输出xml,输出后停止运行
API::mxml(true,500,'失败');