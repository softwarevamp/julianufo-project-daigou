<?php
//我的劵
InitGP(array("action","bid","page")); //初始化变量全局返回

include_once(INC_PATH."/coupon.class.php");
$coupon=CouponClass::init();

$uname=$_USERS['uname'];
$wherestr[]="uname='{$uname}'";

if (empty($action)) {
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$dataarray=$coupon->getdata("",$wheresql,""); //获取数据
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$total=$coupon->getcount($wheresql);
	include template('member_coupon');//包含输出指定模板
}elseif ($action=="active"){
	$wherestr[]="getway=2";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$dataarray=$coupon->getdata("",$wheresql,""); //获取数据
	//print_r($dataarray);
	
	include template('member_coupon_active');//包含输出指定模板
}elseif ($action=="present"){
	$wherestr[]="endtime >= ".time();
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$dataarray=$coupon->getdata("",$wheresql,""); //获取数据	
	
	
	include template('member_coupon_present');//包含输出指定模板
}elseif ($action=="sell"){
	$wherestr[]="endtime >= ".time();
	$wherestr[]="getway=1";
	$wherestr[]="state in(1,2)";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$dataarray=$coupon->getdata("",$wheresql,""); //获取数据	
	
	include template('member_coupon_sell');//包含输出指定模板	
}elseif ($action=="getcoupon"){
	//积分兑换
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$total=$coupon->getcount($wheresql);
	include template('member_coupon_getcoupon');//包含输出指定模板		
	
}

?>