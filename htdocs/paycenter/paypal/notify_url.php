<?php
require_once (dirname(__FILE__) . "/../../common.inc.php");

include_once CFG_CACHEPATH.'/sys_pay.cache.php';//支付配置文件
require_once(dirname(__FILE__)."/paypal_config.php");



$result=fsockPost($paypal[url],$_POST);

//获取支付宝的反馈参数
$dingdan			= $_REQUEST['invoice'];		//获取订单号
$total_fee			= trim($_REQUEST['mc_gross']);    		//获取总价格
$status				=$_REQUEST['payment_status'];
$receiver_email		=trim($_REQUEST['receiver_email']);

if(eregi("VERIFIED",$result)){
	if(isset($paypal['business'])){
	
		if(stristr($status,"Completed")==false){
			log_result("succeed _$status\r\n");
			return ;
		}
		if(strcmp($paypal['business'],$receiver_email)!=0){
			log_result("cheat _$receiver_email\r\n");
			return ;
		}
		//执行支付成功操作
		include_once(INC_PATH."/recharge.class.php");
		$rechargeobj=RechargeClass::init();
		//收取手续费的规则
		$total_fee=$total_fee*0.96-0.3;
		$money=$rechargeobj->ratechange($total_fee,'USD');


		$rechargeobj->paysuccess($dingdan,$money);
		echo '支付成功!';
		
	}else{
		//输出支付失败提示
		showmsg("支付未完成！","../../../m.php");
	}
}else{
	if(isset($paypal['business'])){
		log_result("error".date("Y-M-D H:d:S"));
		//输出支付失败提示
		showmsg("支付未完成！","../../../m.php");
	}else{
		//输出支付失败提示
		showmsg("支付未完成！","../../../m.php");
	}
}

//日志消息,记录反馈的参数记录下来
function  log_result($word) { 
	$fp = fopen("log.txt","a");	
	flock($fp, LOCK_EX) ;
	fwrite($fp,$word."：执行日期：".strftime("%Y%m%d%H%I%S",time())."\t\n");
	flock($fp, LOCK_UN); 
	fclose($fp);
}	
?>