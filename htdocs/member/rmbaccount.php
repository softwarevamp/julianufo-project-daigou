<?php
//我的劵
InitGP(array("action","type","sid","page")); //初始化变量全局返回

include_once(INC_PATH.'/rate.class.php');
$rate = RateClass::init();
//获取最新汇率信息
$ratedata = $rate->get();

if (empty($action)) {
	$recharge=new TableClass("rechargerecord","rid");
	$uname=$_USERS['uname'];
	$wherestr[]="uname='{$uname}'";
	$wherestr[]="state='2'";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$dataarray=$recharge->getdata("",$wheresql,""); //获取团购数据
	include template('member_rmbaccount');//包含输出指定模板
}elseif ($action=="pay"){
	if (empty($type)) {
		$type=1;
	}
	
	
	include template('member_rmbaccount_pay');//包含输出指定模板	
}


//print_r($dataarray);

?>