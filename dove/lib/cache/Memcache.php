<?php
declare(strict_types=1);
namespace dove;
use dove\Config;

class Memcache {

    public $conn;
    
    function __construct($keep=false){
        self::self::$config = Config::get('cache','memcache');
        $this->conn = ($keep)?memcache_pconnect(self::$config['host'],self::$config['port']):memcache_connect(self::$config['host'],self::$config['port']);
        if(self::$config['auto_compress']) memcache_set_compress_threshold($this->conn,self::$config['threshold'],self::$config['min_saving']);
    }

    // 设置
    public function set($key='',$value='',$flag=0,$expire=0){
        return memcache_set($this->conn,$key,$value,$flag,$expire);
    }

    // 获取
    public function get($key=''){
        return memcache_get($this->conn,$key);
    }

    // 自增
    public function inc($key='',$value=''){
        return memcache_increment($this->conn,$key,$value);
    }

    // 自减
    public function dec($key='',$value=''){
        return memcache_decrement($this->conn,$key,$value);
    }

    // 删除全部
    public function clear(){
        return memcache_flush($this->conn);
    }

    // 删除指定
    public function del($key='',$timeout=0){
        return memcache_delete($this->conn,$key,$timeout);
    }
    
    // 服务状态
    public function server_status(){
        return memcache_get_server_status($this->conn,self::$config['host'],self::$config['port']);
    }

    // 版本
    public function get_version(){
        return memcache_get_version($this->conn);
    }
    
    public function close()
    {
         return memcache_close($this->conn);
    }
}