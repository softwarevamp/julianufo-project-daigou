<?php
require_once (dirname(__FILE__) . "/../../common.inc.php");

include_once CFG_CACHEPATH.'/sys_pay.cache.php';//支付配置文件
require_once(dirname(__FILE__)."/alipay_config.php");
require_once(dirname(__FILE__)."/alipay_notify.php");
//判断用户是否登录
if(!empty($_USERS)){ 

}
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
$verify_result = $alipay->return_verify();

//获取支付宝的反馈参数
$dingdan					= $_GET['out_trade_no'];		//获取订单号
$total_fee				= $_GET['total_fee'];    		//获取总价格
 
$receive_name    	= $_GET['receive_name'];  	//获取收货人姓名
$receive_address 	= $_GET['receive_address']; //获取收货人地址
$receive_zip     	= $_GET['receive_zip'];  		//获取收货人邮编
$receive_phone   	= $_GET['receive_phone']; 	//获取收货人电话
$receive_mobile  	= $_GET['receive_mobile']; 	//获取收货人手机

if($verify_result) {
	if($_GET['trade_status'] == 'TRADE_FINISHED' ||$_GET['trade_status'] == 'TRADE_SUCCESS'){
		//支付成功处理更新数据库操作
		include_once(INC_PATH."/recharge.class.php");
		$rechargeobj=RechargeClass::init();
		$rechargeobj->paysuccess($dingdan,$total_fee);
		showmsg("支付成功！","../../../m.php");
		
	}else{
		//输出支付失败提示
		showmsg("支付未完成！","../../../m.php");
	
	}
}else{
	//输出支付失败提示
showmsg("支付未完成！","../../../m.php");
	
}
//日志消息,把支付宝反馈的参数记录下来
function  log_result($word) { 
	$fp = fopen("log.txt","a");	
	flock($fp, LOCK_EX) ;
	fwrite($fp,$word."：执行日期：".strftime("%Y%m%d%H%I%S",time())."\t\n");
	flock($fp, LOCK_UN); 
	fclose($fp);
}	
?>