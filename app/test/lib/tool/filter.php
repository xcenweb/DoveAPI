<?php
// 字符串验证功能测试

使用工具类 Filter;

// 检验一个字符
// Filter::validate_once(规则,字符串,允许空字符串内容,闭包函数);

Filter::validate_once('数字','0o0',true,function($a,$b,$c){
    echo "- 发生错误的规则名称：{$a}<br>- 规则内容:{$b}<br>- 导致错误的字符串内容：{$c}";
});

echo '<br><font color="green">加载时间：'.round(microtime(true)-DOVE_START_TIME,8).'</font>';
echo '<br><hr><br>';

// 检验多字符 bug
// Filter::validate(['规则1'=>[0=>'字符1',1=>'字符2',...],'规则2'=>[0=>'字符']],允许空字符串内容,闭包函数);

Filter::validate([
    '数字'=>[0=>10,1=>134,2=>66],
    '邮箱'=>null,
],false,function($a,$b,$c,$d,$e){
    echo "<b>第{$a}个规则下发生了错误</b><br>- 发生错误的规则名称：{$c}<br>- 发生错误的规则：{$d}<br>- 规则下第{$b}个字符串<br>- 导致错误的字符串内容：{$e}";
});

echo '<br><font color="green">加载时间：'.round(microtime(true)-DOVE_START_TIME,8).'</font>';
echo '<br><hr><br>';