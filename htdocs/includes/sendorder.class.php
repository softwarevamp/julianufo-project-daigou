<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}

class SendOrderClass {
	var $db;
	var $table_sendorder;
	var $tablepre;
	function __construct(){
		//设置全局变量
		global $db,$tablepre;
		$this->db=$db;
		$this->tablepre=$tablepre;
		$this->table_sendorder=new TableClass("sendorder","sid");
	}
	function SendOrderClass(){
		$this->__construct();
	}
	//对象获取
	function &init() {
		static $object;
		if(empty($object)) {
			$object = new SendOrderClass();
		}
		return $object;
	}
	
	//添加运单
	function add($dataarray){
		
		return $this->table_sendorder->add($dataarray);
	}
	//编辑
	function edit($eid,$dataarray){
		return $this->table_sendorder->edit($eid,$dataarray);
	}
	//删除
	function del($id){
		global $_USERS;
		$sendorders=$this->getone($id,"uname,oids,couponid,freight,serverfee,customsfee,totalfee,state");
		if(is_array($sendorders)){
			if ($sendorders['state']!=1) {
				return lang('Not_allowcancel_sendorder');
			}
			if ($_USERS['uname']!=$sendorders['uname']) {
				return lang('Permissions_not');
			}
			include_once(INC_PATH."/member.class.php");
			$m=new memberclass();
			$tempmoney=$sendorders['totalfee'];
			$note=lang('cancel_sendorder_id').$id;
			$m->moneyedit($sendorders['uname'],$tempmoney,3,$note);
			$wheresqlo="oid in(".$sendorders['oids'].")";
			editstate($this->tablepre."order","state",$wheresqlo,4);//更改订单状态操作
			editstate($this->tablepre."order","sid",$wheresqlo,0);//更改订单对应运单ID操作
			if (GetNum($sendorders['couponid'])){
				editstate($this->tablepre."coupon","state","cid = ".GetNum($sendorders['couponid']),1);//更改优惠卷状态操作
			}
			
		}else {
			return lang('sendOrderID_notexist');
		}
		$dataarray=array(
			'state'=>4
		);
		return $this->edit($id,$dataarray);
		//return $this->table_sendorder->del($id);
	}
	//获取一个
	function getone($gid,$field="*"){
		return $this->table_sendorder->getone($gid,$field);
	}
	//获取数据
	function getdata($limit="",$where="",$orderby="",$field="*"){
		global $SENDORDERSTATE;
		$temparray=$this->table_sendorder->getdata($limit,$where,$orderby,$field);
		foreach($temparray as &$value){
			//数据处理
			$value['statename']=$SENDORDERSTATE[$value['state']];
		}
		return $temparray;		
	}
	//统计
	function getcount($where=""){
		return $this->table_sendorder->getcount($where);
	}
}
?>