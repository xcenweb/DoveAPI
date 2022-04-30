<?php
// 缓存类测试
use dove\cache\Filecache;

$fc = new Filecache();

// 设置缓存
$fc->set('a','xxxxx',0);
$fc->set('b',['test'=>12345690],0);
$fc->set('c',2,0);

// 获取缓存,即使缓存过期也要在输出后删除
echo '<b><font color="blue">缓存a</font> 内容：</b>'.$fc->get('a',true).'<br>';
echo '<b><font color="green">缓存b</font> 内容：</b>';
print_r($fc->get('b',true));
echo '<br><b><font color="red">缓存c</font> 内容：</b>'.$fc->get('c',true);

// 缓存自增（仅支持数值缓存
echo '<br><hr><b><font color="red">缓存c</font> 自增前数值：</b>'.$fc->get('c',true);
echo '<br><b><font color="red">缓存c</font> 自增后数值：</b>'.$fc->inc('c',1);
// 缓存自减（仅支持数值缓存
echo '<br><hr><b><font color="red">缓存c</font> 自减前数值：</b>'.$fc->get('c',true);
echo '<br><b><font color="red">缓存c</font> 自减后数值：</b>'.$fc->dec('c',1);

// 删除缓存
// a.data b.data c.data
echo '<hr><br><b>删除缓存 <u><font color="blue">a</font>,<font color="green">b</font>,<font color="red">c</font></u> 返回：</b>';
var_dump($fc->del('a','b','c'));

// 删除所有缓存，包括子目录
// $fc->clean();