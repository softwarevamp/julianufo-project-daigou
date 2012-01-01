<?php
//我的劵
header("content-type: text/html; charset=utf-8");
InitGP(array("action","type","amount","page")); //初始化变量全局返回


if (!empty($action)){
$priceCount=GetNum($amount);

switch ($action){
	case 'paypal':
	$paytype="paypal";
	$cate='USD';
	$paytypeid=2;
	$payname=lang('Paypal_payment');
	break;
	case 'ChinaBank':
	$paytype="cbpayment";
	$cate='CNY';
	$paytypeid=4;
	$payname=lang('cb_payment');
	break;
	case 'ips':
	$paytype="alipay";
	$cate='CNY';
	$paytypeid=1;
	$payname=lang('Alipay_payment');
	break;
	
	default:
	break;
}

include_once(INC_PATH."/recharge.class.php");
$rechargeobj=RechargeClass::init();

$OrdersId=$rechargeobj->add($_USERS['uname'],$priceCount,$cate,$paytypeid,$payname);

//处理付款操作
require_once ROOT_PATH.'/paycenter/'.$paytype.'/config_pay_'.$paytype.'.php';//引用支付处理
}

//include template('member_rmbaccount');//包含输出指定模板

?>