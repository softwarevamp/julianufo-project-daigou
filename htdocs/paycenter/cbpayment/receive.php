<?php
require_once (dirname(__FILE__) . "/../../common.inc.php");

include_once CFG_CACHEPATH.'/sys_pay.cache.php';//支付配置文件

require_once(dirname(__FILE__)."/cbpayment_config.php");


$v_oid     =trim($_POST['v_oid']);       // 商户发送的v_oid定单编号   
$v_pmode   =trim($_POST['v_pmode']);    // 支付方式（字符串）   
$v_pstatus =trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
$v_pstring =trim($_POST['v_pstring']);   // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）； 
$v_amount  =trim($_POST['v_amount']);     // 订单实际支付金额
$v_moneytype  =trim($_POST['v_moneytype']); //订单实际支付币种    
$remark1   =trim($_POST['remark1' ]);      //备注字段1
$remark2   =trim($_POST['remark2' ]);     //备注字段2
$v_md5str  =trim($_POST['v_md5str' ]);   //拼凑后的MD5校验值  

$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

if ($v_md5str==$md5string)
{
	if($v_pstatus=="20"){
		//支付成功处理更新数据库操作
		/*include(INC_PATH."/order.class.php");
    	$o=new OrderClass();
		$o->edit_money_state($v_oid,2,$v_amount);*/
		
		$v_amount = $v_amount*0.99;
		include_once(INC_PATH."/recharge.class.php");
		$rechargeobj=RechargeClass::init();
		$rechargeobj->paysuccess($v_oid,$v_amount);
		showmsg("支付成功!","../../../m.php");
		
	}else{
		showmsg("支付失败","../../../m.php");
		exit;
	}
}else{
	showmsg("校验失败,数据可疑!","../../../m.php");
	exit;
}
?>