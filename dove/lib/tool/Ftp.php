<?php
declare(strict_types=1);
namespace dove\tool;
use dove\Debug;
/**
 * 仿写CodeIgniter的FTP类
 * FTP基本操作：
 * 1) 登陆; 			connect
 * 2) 当前目录文件列表;  filelist
 * 3) 目录改变;			chgdir
 * 4) 重命名/移动;		rename
 * 5) 创建文件夹;		mkdir
 * 6) 删除;				delete_dir/delete_file
 * 7) 上传;				upload
 * 8) 下载				download
 */
class Ftp {

	private $hostname = '';
	private $username = '';
	private $password = '';
	private $port    = 21;
	private $passive = true;
	private $conn_id = false;
	
	/**
	 * 构造函数
	 *
	 * @param	array	配置数组 : $config = array('hostname'=>'','username'=>'','password'=>'','port'=>''...);
	 */
	public function __construct($config = []) {
		if(count($config) > 0) {
			$this->_init($config);
		}
	}
	
	/**
	 * FTP连接
	 *
	 * @access 	public
	 * @param 	array 	配置数组
	 * @return	boolean
	 */
	public function connect($config = []){
		if(count($config) > 0) $this->_init($config);
		if(false === ($this->conn_id = @ftp_connect($this->hostname,$this->port))){
		    Debug::e(500,'ftp:连接失败');
		    return false;
		}
		if(!$this->_login()){
		    Debug::e(500,'ftp:登录失败');
		    return false;
		}
		if($this->passive === true) ftp_pasv($this->conn_id,true);
		return true;
	}

	
	/**
	 * 目录改变
	 *
	 * @access 	public
	 * @param 	string 	目录标识(ftp)
	 * @param	boolean	
	 * @return	boolean
	 */
	public function chgdir($path = '') {
		if($path == '' OR ! $this->_isconn()) return false;
		$result = @ftp_chdir($this->conn_id,$path);
		if($result === false) {
		    Debug::e(500,'ftp:目录改变失败['.$path.']');
			return false;
		}
		return true;
	}
	
	/**
	 * 目录生成
	 *
	 * @access 	public
	 * @param 	string 	目录标识(ftp)
	 * @param	int  	文件权限列表	
	 * @return	boolean
	 */
	public function mkdir($path = '') {
		if($path == '' OR ! $this->_isconn()) return false;
		$parts = explode('/',$path); // 2013/06/11/username
		$cd = "";
	    foreach($parts as $part){
	        if(!@ftp_chdir($this->conn_id, $part)){
		        @ftp_mkdir($this->conn_id, $part);
		        @ftp_chdir($this->conn_id, $part);
		        @ftp_chmod($this->conn_id, 0777, $part);
	        }
	        $cd .= "../";
	    }
	    @ftp_chdir($this->conn_id, $cd);
		return true;
	}
	
	/**
	 * 上传
	 *
	 * @access 	public
	 * @param 	string 	本地目录标识
	 * @param	string	远程目录标识(ftp)
	 * @param	string	上传模式 auto || ascii
	 * @param	int		上传后的文件权限列表	
	 * @return	boolean
	 */
	public function upload($localpath, $remotepath, $mode = 'auto', $permissions = null) {
		if(!$this->_isconn()) return false;
		if(!file_exists($localpath)){
		    Debug::e(500,'ftp:没有文件来源['.$localpath.']');
			return false;
		}
		if($mode == 'auto'){
			$ext = $this->_getext($localpath);
			$mode = $this->_settype($ext);
		}
		$mode = ($mode == 'ascii') ? FTP_ASCII : FTP_BINARY;
		$result = @ftp_put($this->conn_id, $remotepath, $localpath, $mode);
		if($result === false) {
		    Debug::e(500,'ftp:文件上传异常！本地路径['.$localpath.']；服务器端路径['.$remotepath.']');
			return false;
		}
		if(!is_null($permissions)) {
			$this->chmod($remotepath,(int)$permissions);
		}
		return true;
	}
	
	/**
	 * 下载
	 *
	 * @access 	public
	 * @param 	string 	远程目录标识(ftp)
	 * @param	string	本地目录标识
	 * @param	string	下载模式 auto || ascii	
	 * @return	boolean
	 */
	public function download($remotepath, $localpath, $mode = 'auto') {
		if(!$this->_isconn()) return false;
		if($mode == 'auto'){
			$ext = $this->_getext($remotepath);
			$mode = $this->_settype($ext);
		}
		$mode = ($mode == 'ascii') ? FTP_ASCII : FTP_BINARY;
		$result = @ftp_get($this->conn_id, $localpath, $remotepath, $mode);
		if($result === false){
		    Debug::e(500,'ftp:文件下载失败！本地路径['.$localpath.']；服务器端路径['.$remotepath.']');
			return false;
		}
		return true;
	}
	
	/**
	 * 重命名/移动
	 *
	 * @access 	public
	 * @param 	string 	远程目录标识(ftp)
	 * @param	string	新目录标识
	 * @param	boolean	判断是重命名(FALSE)还是移动(TRUE)	
	 * @return	boolean
	 */
	public function rename($oldname, $newname, $move = false) {
		if(!$this->_isconn()) return false;
		$result = @ftp_rename($this->conn_id, $oldname, $newname);
		if($result === false) {
			if($this->debug === true) {
				$msg = ($move == false) ? "ftp:文件重命名失败" : "ftp:文件移动失败";
				Debug::e(500,$msg);
			}
			return false;
		}
		return true;
	}
	
	/**
	 * 删除文件
	 *
	 * @access 	public
	 * @param 	string 	文件标识(ftp)
	 * @return	boolean
	 */
	public function delete_file($file) {
		if(!$this->_isconn()) return false;
		$result = @ftp_delete($this->conn_id, $file);
		if($result === false) {
			if($this->debug === true) {
			    Debug::e(500,'ftp:删除文件失败['.$file.']');
			}
			return false;
		}
		return true;
	}
	
	/**
	 * 删除文件夹
	 *
	 * @access 	public
	 * @param 	string 	目录标识(ftp)
	 * @return	boolean
	 */
	public function delete_dir($path) {
		if(!$this->_isconn()) return false;
		$path = preg_replace("/(.+?)\/*$/", "\\1/", $path);//对目录宏的'/'字符添加反斜杠'\'
		$filelist = $this->filelist($path);//获取目录文件列表
		if($filelist !== false AND count($filelist) > 0) {
			foreach($filelist as $item) {
				//如果我们无法删除,那么就可能是一个文件夹
				//所以我们递归调用delete_dir()
				if(!@delete_file($item)) {
					$this->delete_dir($item);
				}
			}
		}
		//删除文件夹(空文件夹)
		$result = @ftp_rmdir($this->conn_id, $path);
		if($result === false) {
		    Debug::e(500,'ftp:删除文件夹失败['.$path.']');
			return false;
		}
		return true;
	}
	
	/**
	 * 修改文件权限
	 *
	 * @access 	public
	 * @param 	string 	目录标识(ftp)
	 * @return	boolean
	 */
	public function chmod($path, $perm) {
		if(!$this->_isconn()) return false;
		//只有在PHP5中才定义了修改权限的函数(ftp)
		if(!function_exists('ftp_chmod')){
		    Debug::e(500,'ftp:文件权限修改失败！(function)');
			return false;
		}
		$result = @ftp_chmod($this->conn_id, $perm, $path);
		if($result === false){
		    Debug::e(500,'ftp:文件权限修改失败！被操作路径['.$path.'];修改权限['.$perm.']');
			return false;
		}
		return true;
	}
	
	/**
	 * 获取目录文件列表
	 *
	 * @access 	public
	 * @param 	string 	目录标识(ftp)
	 * @return	array
	 */
	public function filelist($path = '.') {
		if(!$this->_isconn()) return false;
		return ftp_nlist($this->conn_id, $path);
	}
	
	/**
	 * 关闭FTP
	 *
	 * @access 	public
	 * @return	boolean
	 */
	public function close() {
		if(!$this->_isconn()) return false;
		return @ftp_close($this->conn_id);
	}
	
	/**
	 * FTP成员变量初始化
	 *
	 * @access	private
	 * @param	array	配置数组	 
	 * @return	void
	 */
	private function _init($config = array()) {
		foreach($config as $key => $val) {
			if(isset($this->$key)) {
				$this->$key = $val;
			}
		}
		//特殊字符过滤
		$this->hostname = preg_replace('|.+?://|','',$this->hostname);
	}
	
	/**
	 * FTP登陆
	 *
	 * @access 	private
	 * @return	boolean
	 */
	private function _login() {
		return @ftp_login($this->conn_id, $this->username, $this->password);
	}
	
	/**
	 * 判断con_id
	 *
	 * @access 	private
	 * @return	boolean
	 */
	private function _isconn() {
		if(!is_resource($this->conn_id)) {
			Debug::e(500,'ftp:连接失败！');
			return false;
		}
		return true;
	}
	
	/**
	 * 从文件名中获取后缀扩展
	 *
	 * @access 	private
	 * @param 	string 	目录标识
	 * @return	string
	 */
	private function _getext($filename) {
		if(false === strpos($filename, '.')) return 'txt';
		$extarr = explode('.', $filename);
		return end($extarr);
	}
	
	/**
	 * 从后缀扩展定义FTP传输模式  ascii 或 binary
	 *
	 * @access 	private
	 * @param 	string 	后缀扩展
	 * @return	string
	 */
	private function _settype($ext) {
		$text_type = [
			'txt',
		    'text',
			'php',
			'phps',
			'php4',
			'js',
			'css',
			'htm',
			'html',
			'phtml',
			'shtml',
			'log',
			'xml'
		];
		return (in_array($ext, $text_type)) ? 'ascii' : 'binary';
	}
}