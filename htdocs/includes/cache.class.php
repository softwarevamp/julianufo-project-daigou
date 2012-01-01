<?php
/**
 *
 * @author lssbing
 * @version $Id: FileCache.class.php 267 2010-01-19 07:21:08Z
 */
class FileCache {
 
	/**
	 * 缓存目录
	 *
	 * @var string
	 * @access private
	 */
	private $dir;
	/**
	 * 构造器
	 *
	 * @access public
	 */
	public function __construct() {
		$this->dir = DATA_CACHEPATH.'/'; //缓存目录
		@chmod($this->dir, 0777);
		if(!is_writable($this->dir)) {
			throw new Exception(lang('cache_file') . $this->dir . lang('not_write'));
		}
	}
 
	/**
	 * 设置一个缓存变量
	 *
	 * @param String $key    缓存Key
	 * @param mixed $value   缓存内容
	 * @param int $expire    缓存时间(秒)
	 * @return boolean       是否缓存成功
	 * @access public
	 * @abstract
	 */
    public function set($key, $value, $expire = 60) {
		$file = $this->dir . md5($key) . '.cache';
		if(file_put_contents($file , serialize($value), LOCK_EX)) {
			@touch($file, time() + $expire);
			return true;
		} else {
			return false;
		}
 
	}
 
	/**
	 * 获取一个已经缓存的变量
	 *
	 * @param String $key  缓存Key
	 * @return mixed       缓存内容
	 * @access public
	 */
	public function get($key) {
		$file = $this->dir . md5($key) . '.cache';
		if(is_file($file)) {
			if(time() <= filemtime($file)) {
				return unserialize(file_get_contents($file));
			} else {
				@unlink($file);
				//删除缓存
				return false;
			}
		} else {
			//没有找到缓存
			return false;
		}
	}
 
	/**
	 * 删除一个已经缓存的变量
	 *
	 * @param  $key
	 * @return boolean       是否删除成功
	 * @access public
	 */
	public function del($key) {
		$file = $this->dir . md5($key) . '.cache';
		return @unlink($file);
	}
 
	/**
	 * 删除全部缓存变量
	 *
	 * @return boolean       是否删除成功
	 * @access public
	 */
	public function delAll() {
		$files = scandir($this->dir);
		$files = array_diff($files, array('.', '..'));
		foreach($files as $file) {
			@unlink($file);
		}
		return true;
	}
 
	/**
	 * 检测是否存在对应的缓存
	 *
	 * @param string $key   缓存Key
	 * @return boolean      是否存在key
	 * @access public
	 */
	public function has($key) {
		return (is_file($this->dir . md5($key) . '.cache') === NULL ? false : true);
	}
}


?>