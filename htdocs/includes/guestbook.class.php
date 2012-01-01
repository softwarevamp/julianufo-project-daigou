<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}

class GuestBookClass {
	var $db;
	var $table_guestbook;
	var $tablepre;
	function __construct(){
		//设置全局变量
		global $db,$tablepre;
		$this->db=$db;
		$this->tablepre=$tablepre;
		$this->table_guestbook=new TableClass("guestbook","gid");
	}
	function GuestBookClass(){
		$this->__construct();
	}
	//对象获取
	function &init() {
		static $object;
		if(empty($object)) {
			$object = new GuestBookClass();
		}
		return $object;
	}
	
	//添加
	function add($dataarray){
		return $this->table_guestbook->add($dataarray);
	}
	//编辑
	function edit($eid,$dataarray){
		return $this->table_guestbook->edit($eid,$dataarray);
	}
	//删除
	function del($id){
		return $this->table_guestbook->del($id);
	}
	//获取一个
	function getone($gid,$field="*"){
		return $this->table_guestbook->getone($gid,$field);
	}
	//获取数据
	function getdata($limit="",$where="",$orderby="",$field="*",$type='ALL'){
		
		$tempdata=array();
		if(!empty($limit))$limit=" limit $limit ";
		if(!empty($where))$where=" where $where ";
		if(!empty($orderby))$orderby=" order by $orderby ";else $orderby=" order by ".$this->table_guestbook->idname." desc";
		if($type=="ALL")$addsql=" AS G left join {$this->tablepre}users AS U ON G.uname=U.uname ";
		
		$sql="select {$field} from {$this->table_guestbook->table}{$addsql}{$where}{$orderby}{$limit}";
		$query =$this->db->query($sql);
		while($value = $this->db->fetch_array($query)) {
			$tempdata[]=$value;
		}
		return $tempdata;
	}
	//统计
	function getcount($where=""){
		return $this->table_guestbook->getcount($where);
	}
}
?>