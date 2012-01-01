<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}
class OrderClass {
	var $db;
	var $table_order;
	var $tablepre;
	function __construct(){
		//设置全局变量
		global $db,$tablepre;
		$this->db=$db;
		$this->tablepre=$tablepre;
		$this->table_order=new TableClass("order","oid");
	}
	function OrderClass(){
		$this->__construct();
	}
	//对象获取
	function &init() {
		static $object;
		if(empty($object)) {
			$object = new OrderClass();
		}
		return $object;
	}

	//添加
	function add($dataarray){
		return $this->table_order->add($dataarray);
	}
	//编辑
	function edit($eid,$dataarray){
		return $this->table_order->edit($eid,$dataarray);
	}
	//删除
	function del($id){
		global $_USERS;
		$goods=$this->getone($id,"uname,goodsnum,goodsprice,goodsurl,goodsname,sendprice,type,goodsseller,goodssite,state");
		if(is_array($goods)){
			if ($goods['state']!=1 && $goods['state']!=6) {
				return lang('Not_allowcancel_order');
			}
			if ($_USERS['uname']!=$goods['uname']) {
				return lang('Permissions_not');
			}
			//type=1时候表示是代购商品需要返还用户付款额度
			if ($goods['type']==1 || $goods['type']==2) {
				include_once(INC_PATH."/member.class.php");
				$m=new memberclass();
				$countnum = $this->getcount("uname='".$goods['uname']."' and goodsseller='".$goods['goodsseller']."' and (state=1 or state=6)");
				if ($countnum>1) {
					//只退还账户余额]
					$tempmoney=$goods['goodsprice']*$goods['goodsnum'];
					$note=lang('cancel_order')."<a href=\'".$goods['goodsurl']."\' target=\'_blank\'>《".$goods['goodsname']."》</a>".lang('order_id').$id;
					$m->moneyedit($goods['uname'],$tempmoney,4,$note);
				}elseif ($countnum=1){
					//退还账户余额和运费
					$tempmoney=$goods['goodsprice']*$goods['goodsnum']+$goods['sendprice'];
					$note=lang('cancel_order')."<a href=\'".$goods['goodsurl']."\' target=\'_blank\'>《".$goods['goodsname']."》".lang('And_freight').$goods['sendprice']."</a>".lang('order_id').$id;
					$m->moneyedit($goods['uname'],$tempmoney,4,$note);
				}//else{
					//退还账户余额和运费
				//	$tempmoney=$goods['goodsprice']*$goods['goodsnum']+$goods['sendprice'];
				//	$note="取消订单<a href=\'".$goods['goodsurl']."\' target=\'_blank\'>《".$goods['goodsname']."》和运费:".$goods['sendprice']."</a>订单ID:".$id;
				//	$m->moneyedit($goods['uname'],$tempmoney,4,$note);
				//}
			}
		}else {
			return lang('OrderID_notexist');
		}
		return $this->table_order->del($id);
	}
	//订单发送
	function ordertosend($oids,$uname=""){
		$wherestro[]="oid in(".$oids.")";
		if (!empty($uname)) {
			$wherestro[]="uname='".$_USERS['uname']."'";	
		}
		if(!empty($wherestro)) $wheresqlo = implode(' AND ', $wherestro);	//条件汇总
		editstate($this->table_order->table,"state",$wheresqlo,5);//更改状态操作
	}
	//获取一个
	function getone($gid,$field="*"){
		return $this->table_order->getone($gid,$field);
	}
	//获取数据
	function getdata($limit="",$where="",$orderby="",$field="*"){
		global $ORDERSTATE;
		$temparray=$this->table_order->getdata($limit,$where,$orderby,$field);
		foreach($temparray as &$value){
			//数据处理
			if(empty($value['orderimg'])){
				$value['showimg']=$value['goodsimg'];
				$value['orderimg']=$value['goodsimg'];
			}else {
				$value['showimg']=get_thumb($value['orderimg']);
			}
			$value['statename']=$ORDERSTATE[$value['state']];
		}
		return $temparray;		
		
	}
	function getuserdata($limit="",$where="",$orderby="",$field="*",$type='ALL'){
		
		$tempdata=array();
		if(!empty($limit))$limit=" limit $limit ";
		if(!empty($where))$where=" where $where ";
		if(!empty($orderby))$orderby=" order by $orderby ";else $orderby=" order by ".$this->table_order->idname." desc";
		if($type=="ALL")$addsql=" AS O left join {$this->tablepre}users AS U ON O.uname=U.uname ";
		$sql="select {$field} from {$this->table_order->table}{$addsql}{$where}{$orderby}{$limit}";
		$query =$this->db->query($sql);
		while($value = $this->db->fetch_array($query)) {
			$tempdata[]=$value;
		}
		return $tempdata;
	}
	//统计
	function getcount($where=""){
		return $this->table_order->getcount($where);
	}
}
?>