<?php
//弹出一键填单相关ajax数据处理
include("../common.inc.php");
InitGP(array("action","url","refuname","referer","aid","cityid")); //初始化变量全局返回
include_once(INC_PATH."/coupon.class.php");
$coupon=CouponClass::init();
AjaxHead();
if($action=='active'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$code=Char_cv($jsondata->code);
	$info=$coupon->active($code,$_USERS['uname']);
	echo json_encode($info);
	exit;
}else if($action=='present'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$uname=Char_cv($jsondata->name);
	$sn=Char_cv($jsondata->code);
	$info=$coupon->present($sn,$uname,$_USERS['uname']);
	echo json_encode($info);
	exit;
}else if($action=='sell'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$price=GetNum($jsondata->price);
	$sn=Char_cv($jsondata->code);
	$info=$coupon->sellcoupon($sn,$price,$_USERS['uname']);
	echo json_encode($info);
	exit;
}else if($action=='cancelsell'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	
	$sn=Char_cv($jsondata->code);
	$info=$coupon->cancelsell($sn,$_USERS['uname']);
	echo json_encode($info);
	exit;
	
}else if($action=='getcoupon'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$price=GetNum($jsondata->price);
	$num=GetNum($jsondata->num);
	$info=$coupon->getcoupon($price,$num,$_USERS['uname']);
	echo json_encode($info);
	exit;
}else if($action=='buycoupon'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$code=GetNum($jsondata->code);
	if (empty($_USERS['uname'])) {
		echo json_encode(lang('login_operate'));
		exit;
	}
	$info=$coupon->buycoupon($code,$_USERS['uname']);
	echo json_encode($info);
	exit;
}
?>