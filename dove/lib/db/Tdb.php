<?php
declare(strict_types=1);
//文本数据库，先把坑挖好，以后来填
namespace dove\db;
use dove\Debug;

class Tdb
{

    private $dataFlow;     // 数据流
    private $dataFlowCache;// 数据流缓存

    public function __construct($options)
    {
        $this->dbf = $options['dbpath'].$option['dbname'].'.tdb';
        if(file_exist($this->dbf)) $this->debug('数据库不存在');
        $dataFlow = unserialize(gzuncompress(file_get_contents($this->dbf)));
    }

    // 建造一个数据库
    public function mk_db($name)
    {
        
    }

    // 格式化一个数据库
    public function re_db($name)
    {
        
    }

    // 删除数据库
    public function del_db($name)
    {
    
    }

    // 使用框架debug
    public function debug($msg,$c=500)
    {
        Debug::e($c,'dove\db\Tdb::'.$msg,__FILE__);
    }
}