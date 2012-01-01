<?php
//我的劵
InitGP(array("action","type","oid","page")); //初始化变量全局返回
switch ($type){
case "new":
	$state=0;
	$wherestr[]="money_state='{$state}'";
	break;	
case "payed":
    $wherestr[]="money_state in(1,2)";	
	break;	
case "all":
	break;
default:
	$state=0;
}
include(INC_PATH."/order.class.php");
$o=new OrderClass();

if ($type=="clear" && !empty($oid)) {
	
	editstate("order","state","oid={$oid}",2);//修改订单状态为取消  1完成 2作废 3退款给用户
	showmessage(lang('Cancelorder_success'),$theurl,true);
}



$uname=$_USERS['uname'];
$wherestr[]="uname='{$uname}'";
if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总

//获取当前页码
$total=$o->getcount($wheresql); 							  //总信息数
$pagesize=15;												  //一页显示信息数
$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
$offset=($page-1)*$pagesize;   								  //偏移量
$value=$o->getdata("$offset,$pagesize",$wheresql,"","ALL","*,O.state"); //获取团购数据




include template('member_orders');//包含输出指定模板
?>