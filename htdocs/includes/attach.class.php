<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}
/**
 * AttachClass类
 * add()
 * adds()
 * edit()
 * del()
 * getdata()
 * 
 *
 */
class AttachClass {
	var $db;
	var $table;
	var $tablepre;
	function __construct(){
		//设置全局变量
		global $db,$tablepre;
		$this->db=$db;
		$this->tablepre=$tablepre;
		$this->table=$tablepre."attachment";
	}
	function AttachClass() {
		$this->__construct();
	}
	/**
	 * 添加图片
	 *
	 * @param unknown_type $sessionid
	 * @param unknown_type $filename
	 * @param unknown_type $filepath
	 * @param unknown_type $filesize
	 * @param unknown_type $fileext
	 * @param unknown_type $isthumb
	 * @return unknown
	 */
	function add($sessionid,$filename,$filepath,$filesize,$fileext,$thumb){
		$timestamp=time();
		if(!empty($sessionid) && !empty($filepath)){
			$this->db->query("insert into {$this->table}(gid,sessionid,filename,filepath,filesize,fileext,thumb,uploadtime) VALUES(0,'{$sessionid}','{$filename}','{$filepath}','{$filesize}','{$fileext}','{$thumb}',$timestamp)");						
			return $this->db->insert_id();//返回当前图片ID
		}else return false;
	}
	/**
	 * 设置归属
	 *
	 * @param unknown_type $gid
	 * @param unknown_type $aid
	 */
	function setgid($gid,$aid){
		if(!empty($gid) && !empty($aid)){
			$sql="UPDATE {$this->table} SET gid='{$gid}' where aid in($aid)";
			$this->db->query($sql);
		}
	}
	/**
	 * 删除单个图片
	 *
	 * @param unknown_type $aid
	 * @return unknown
	 */
	function del($aid){
		if(is_numeric($aid))
		{	
			$this->db->query("delete from {$this->table} where aid='{$aid}' limit 1");	
			return true;
		}return false;
	}
	/**
	 * 删除指定gid下的所有图片
	 *
	 * @param unknown_type $gid
	 * @return unknown
	 */
	function delgid($gid){
		if(is_numeric($gid))
		{	
			$this->db->query("delete from {$this->table} where gid='{$gid}'");	
			return true;
		}return false;
		
	}
	//清理空gid 图片数据
	function clearempty(){
		$this->db->query("delete from {$this->table} where gid='0'");	
		return true;
	}
	
	/**
	 * 获取数据数组
	 *
	 * @param string $limit
	 * @param string $where
	 * @param string $orderby
	 * @return array
	 */
	function getdata($limit="",$where="",$orderby="")
	{
		$tempdata=array();
		if(!empty($limit))$limit=" limit $limit ";
		if(!empty($where))$where=" where $where ";
		if(!empty($orderby))$orderby=" order by $orderby ";else $orderby=" order by aid desc";

		$sql="select * from {$this->table}{$where}{$orderby}{$limit}";
		$query =$this->db->query($sql);
		while($value = $this->db->fetch_array($query)) {
			//此处可进行数据整理
			$tempdata[]=$value;
		}
		return $tempdata;
	}
	function getcount($where=""){
		if(!empty($where))$where=" where $where";
		$count= $this->db->result_first("Select count(*) From `$this->table` $where");
		return $count;
	
	}
	
}
?>