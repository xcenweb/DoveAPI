<?php
declare(strict_types=1);
namespace dove\cache;
use dove\Config;

class Filecache {

    function __construct()
    {
        $c = Config::get('cache','file');
        $this->path = $c['path'];
        $this->suffix = $c['suffix'];
        $this->compress_level = $c['compress_level'];
        return true;
    }

    // 设置缓存，数组自动序列化
    public function set($key,$value='',$exp=0){
        $f = $this->path.$key.$this->suffix;
        file_put_contents($f,gzcompress(strval(is_array($value)?serialize($value):$value),$this->compress_level));
        return touch($f,time()+$exp);
    }

    // 读取缓存，数组自动去序列化
    // get(名称,true是删除后返回内容,默认删除后返回false)
    public function get($key,$delp=false){
        $f = $this->path.$key.$this->suffix;
        if(!file_exists($f)) return false;
        $data = gzuncompress(file_get_contents($f));
        if(filemtime($f) < time()){
            unlink($f);
            if(!$delp) return false;
        }
        return (preg_match("/^a\:[0-9]\:\{.*\}/",$data)==1)?unserialize($data):$data;
    }

    // 数值自增，返回自增后的值
    public function inc($key,$int=1){
        $f = $this->path.$key.$this->suffix;
        if(!file_exists($f)) return false;
        $int = intval(gzuncompress(file_get_contents($f)))+$int;
        file_put_contents($f,gzcompress(strval($int),$this->compress_level));
        return $int;
    }

    // 数值自减，返回自减后的值
    public function dec($key,$int=1){
        $f = $this->path.$key.$this->suffix;
        if(!file_exists($f)) return false;
        $int = intval(gzuncompress(file_get_contents($f)))-$int;
        file_put_contents($f,gzcompress(strval($int),$this->compress_level));
        return $int;
    }

    // 删除缓存，可进行多个删除
    public function del(){
        $keys = func_get_args();
        foreach($keys as $key){
            $f = $this->path.$key.$this->suffix;
            if(!file_exists($f)) continue;
            unlink($f);
        }
        return true;
    }

    // 删除所有缓存，包括子目录
    public function clean(){
        $dirs = scandir($this->path);
        foreach ($dirs as $dir) {
            if ($dir != '.' && $dir != '..') {
                $sonDir = $this->path.'/'.$dir;
                if(is_dir($sonDir)){
                    $this->clear($sonDir);
                    @rmdir($sonDir);
                } else {
                    @unlink($sonDir);
                }
            }
        }
        return true;
    }
    
    // 保存缓存
    public function save()
    {
    
    }
}