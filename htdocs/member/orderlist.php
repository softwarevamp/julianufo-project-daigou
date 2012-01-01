<?php
//我的劵
InitGP(array("action","type","oid","sid","page")); //初始化变量全局返回
include_once(INC_PATH."/order.class.php");
$o=OrderClass::init();
$Table=new OrderClass();
$datanum=$Table->getcount("uname='admin'");

AjaxHead();
if(empty($action)){
	$uname=$_USERS['uname'];
	$wherestr[]="uname='{$uname}'";
	if($type==1){
		$wherestr[]="state=4";
	}elseif($type==2){
		$wherestr[]="state =3";
	}
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$dataarray=$o->getdata("",$wheresql,""); //获取团购数据
	//订单分类
	$dataarray123=$dataarray4=$dataarray5=array();
	if(is_array($dataarray)){
		foreach($dataarray as $val){
			//if($val['state'] > 0 && $val['state'] < 4){
	   	  if($val['state'] > 0 && $val['state'] <= 6 && $val['state'] != 5){
			//已到仓库订单
				$dataarray123[]=$val;
			}			
			
			if($val['state']==4){
			//已到仓库订单
				$dataarray4[]=$val;
			}
			if($val['state']==5){
			//在途订单
				$dataarray5[]=$val;
			}
		}
	}
	include template('member_orderlist');//包含输出指定模板
	
}elseif($action=='sendorder' && !empty($sid)){
	
	$uname=$_USERS['uname'];
	$wherestr[]="uname='{$uname}'";
	$wherestr[]="sid = ".GetNum($sid);
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$dataarray=$o->getdata("",$wheresql,""); //获取团购数据		
	include template('member_orderlist5');//包含输出指定模板
	
}elseif($action=='del'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	if ($o->del($jsondata->oid)=="OK") {
		exit(json_encode('OK'));
	}else{
		exit(json_encode(lang('delete_failed')));
	}
}elseif ($action=='upremark'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	if(!empty($jsondata->remark)&&!empty($jsondata->oid)){
		$tempremark=Char_cv($jsondata->remark);
		$tempoid=GetNum($jsondata->oid);
		$wheresqlarr="uname='".$_USERS['uname']."' and oid=".$tempoid;
		editstate($o->table_order->table,"goodsremark",$wheresqlarr,$tempremark);//更改状态操作
		exit(json_encode('OK'));
	}else {
		exit(json_encode(lang('update_failed')));
	}
}


//print_r($dataarray);
//print_r($dataarray3);
//print_r($dataarray4);




?>