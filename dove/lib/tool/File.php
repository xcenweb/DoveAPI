<?php
declare(strict_types=1);
// 文件操作工具类
namespace dove\tool;

class File
{
    /**
     * 创建指定路径下的指定文件
     * @param string $path (需要包含文件名和后缀)
     * @param boolean $over_write 是否覆盖文件
     * @param int $time 设置时间。默认是当前系统时间
     * @param int $atime 设置访问时间。默认是当前系统时间
     * @return boolean
     */
    public static function create_file($path,$over_write = false,$time = null,$atime = null)
    {
        $path = static::dir_replace($path);
        $time = empty($time) ? time() : $time;
        $atime = empty($atime) ? time() : $atime;
        if(file_exists($path) && $over_write) static::unlink_file($path);
        $aimDir = dirname($path);
        static::create_dir($aimDir);
        return touch($path,$time,$atime);
    }

    /**
     * 删除文件
     * @param string $path
     * @return boolean
     */
    public static function unlink_file($path) 
    {
        $path = static::dir_replace($path);
        return file_exists($path)?unlink($path):false;
    }

    /**
     * 创建多级目录
     * @param string $dir 路径
     * @param int $mode 权限
     * @return boolean
     */
    public static function create_dir($dir = '',$mode = 0755)
    {
        return is_dir($dir) or (static::create_dir(dirname($dir)) and mkdir($dir, $mode));
    }
    
    /**
     * 循环获取某目录中文件
     * @param string $path 目录路径
     * @return mixed
     */
    public static function get_file_list($dir = '')
    {
        if(is_dir($dir)){
            $list = [];
            $arr = scandir($dir);
            foreach($arr as $file){
                if($file != '.' && $file != '..'){
                    if(is_dir($dir.$file)) continue;
                    $list[] = $file;
                }
            }
            return $list;
       }
       return false;
    }
    
    /**
     * 循环获取某目录中文件和子目录
     * @param string $path 目录路径
     * @return mixed
     */
    public static function get_fileSubdir_list($dir = '')
    {
        if(is_dir($dir)){
		    $files = [];
		    $child_dirs = scandir($dir);
		    foreach($child_dirs as $child_dir){
		    	if($child_dir != '.' && $child_dir != '..'){
	    			if(is_dir($dir.'/'.$child_dir)){
                        $files[$child_dir] = static::get_fileSubdir_list($dir.'/'.$child_dir);
                    }else{
                        $files[] = $child_dir;
                    }
		    	}
		    }
		    return $files;
	    }else{
		    return $dir;
	    }
    }
    
    /**
     * 替换相应的字符
     * @param string $path 路径
     * @return string
     */
    public static function dir_replace($path = '')
    {
        return str_replace('//','/',str_replace('\\','/',$path));
    }
}