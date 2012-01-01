<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}

class PmClass {
	var $db;
	var $table_sendorder;
	var $tablepre;
	function __construct(){
		//设置全局变量
		global $db,$tablepre;
		$this->db=$db;
		$this->tablepre=$tablepre;
		$this->table_pm=new TableClass("pm","mid");
	}
	function PmClass(){
		$this->__construct();
	}
	//对象获取
	function &init() {
		static $object;
		if(empty($object)) {
			$object = new PmClass();
		}
		return $object;
	}
	//获取短信息
	function getall(){
		global $_USERS;
		//刷新最新短信
		$this->refresh();
		if(!empty($_USERS['uid'])){
			$wherestr[]="touname='".$_USERS['uname']."'";
		}else{
			return array();
		}
		$wherestr[]="type=1";
		$wherestr[]="writetime!=''";
		if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
		return $this->getdata("",$wheresql,"","mid,fromuid,fromuname,touid,touname,subject,sendtime,writetime,hasview,isadmin");
	}
	//阅读短信息
	function view($mid){
		$mid=GetNum($mid);
		$temparray=$this->getone($mid);
		if (is_array($temparray)) {
			$wheresqlarr="mid=".$mid;
			editstate($this->table_pm->table,"hasview",$wheresqlarr,1);//更改状态操作			
		}
		return $temparray;
	}
	//回复短信给管理员
	function reply($mid,$subject,$message){
		global $_USERS;
		$mid=GetNum($mid);
		$temparray=$this->getone($mid);
		$addarray=array(
			'fromuid'=>$_USERS['uid'],
			'fromuname'=>$_USERS['uname'],
			'touid'=>$temparray['fromuid'],
			'touname'=>$temparray['fromuname'],
			'type'=>2,
			'subject'=>Char_cv($subject),
			'sendtime'=>time(),
			'writetime'=>time(),
			'hasview'=>0,
			'isadmin'=>0,
			'message'=>Char_cv($message)
		);
		return $this->add($addarray);
	}
	//刷新短信箱
	function refresh(){
		global $_USERS;
		$tempdata=$this->getdata("","isadmin=1 and touid=0");
		foreach ($tempdata as $row){
			$temprow=$this->getcount("fromuid={$row['mid']} and touname='".$_USERS['uname']."'");
			if ($temprow < 1) {
				$addarray=array(
					'fromuid'=>$row['mid'],
					'fromuname'=>$row['fromuname'],
					'touid'=>$_USERS['uid'],
					'touname'=>$_USERS['uname'],
					'type'=>1,
					'subject'=>$row['subject'],
					'sendtime'=>$row['sendtime'],
					'writetime'=>$row['writetime'],
					'hasview'=>0,
					'isadmin'=>$row['isadmin'],
					'message'=>$row['message']
				);
				$this->add($addarray);
			}
		}
	}
	//添加
	function add($dataarray){
		return $this->table_pm->add($dataarray);
	}
	//编辑
	function edit($eid,$dataarray){
		return $this->table_pm->edit($eid,$dataarray);
	}
	//删除
	function del($id){
		global $_USERS;
		$row=$this->getone($id,"isadmin,fromuid,fromuname,touid,touname,type");
		if(is_array($row)){
			if ($row['type']!=1) {
				return lang('message_type_error');
			}
			if ($_USERS['uname']!=$row['touname']) {
				return lang('Permissions_not');
			}
			if ($row['isadmin']==1) {
				$wheresqlarr="mid=".$id;
				editstate($this->table_pm->table,"writetime",$wheresqlarr,'0');//更改状态操作
			}else {
				return $this->table_pm->del($id);
			}
		}else {
			return lang('sendOrderID_notexist');
		}
	}
	//获取一个
	function getone($gid,$field="*"){
		return $this->table_pm->getone($gid,$field);
	}
	//获取数据
	function getdata($limit="",$where="",$orderby="",$field="*"){
		$temparray=$this->table_pm->getdata($limit,$where,$orderby,$field);
		foreach($temparray as &$value){
			//数据处理
			$value['hasviewname']=$value['hasview']==0?lang('not_read'):lang('has_read');
		}
		return $temparray;		
	}
	//统计
	function getcount($where=""){
		return $this->table_pm->getcount($where);
	}
}
?>