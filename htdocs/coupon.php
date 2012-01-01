<?php
include("common.inc.php");
InitGP(array("action","money","shortType","page")); //初始化变量全局返回

include_once(INC_PATH."/coupon.class.php");
$couponobj=CouponClass::init();


if (!empty($money)) {
	$wherestr[]="money = ".GetNum($money);
}
if (!empty($shortType)) {
	switch ($shortType){
		case 1:
			$orderby="sellmoney asc";
			break;
		case 2:
			$orderby="sellmoney desc";
			break;			
		case 3:
			$orderby="endtime asc";
			break;
		case 4:
			$orderby="endtime desc";
			break;
		default:
			$orderby="cid desc";
	}
}

	$wherestr[]="endtime >= ".time();
	$wherestr[]="getway = 1";
	$wherestr[]="state = 2";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	//获取当前页码
	$total=$couponobj->getcount($wheresql); 							  //总信息数
	$pagesize=12;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$couponobj->getdata("$offset,$pagesize",$wheresql,$orderby); //获取数据

	//print_r($dataarray);


include template('coupon');//包含输出指定模板
?>