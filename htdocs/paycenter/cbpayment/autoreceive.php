<?php
require_once (dirname(__FILE__) . "/../../common.inc.php");
include_once CFG_CACHEPATH.'/sys_pay.cache.php';//支付配置文件
require_once(dirname(__FILE__)."/cbpayment_config.php");


//该文件,网银自动校单返回参数要到网很后台设设,地址指到该文件路径.
$v_oid     =trim($_POST['v_oid']);
$v_pmode   =trim($_POST['v_pmode']);
$v_pstatus =trim($_POST['v_pstatus']);
$v_pstring =trim($_POST['v_pstring']);
$v_amount  =trim($_POST['v_amount']);
$v_moneytype  =trim($_POST['v_moneytype']);  
$remark1   =trim($_POST['remark1' ]);
$remark2   =trim($_POST['remark2' ]);     
$v_md5str  =trim($_POST['v_md5str' ]);     
            
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key)); //拼凑加密串
if ($v_md5str==$md5string)
{
  if($v_pstatus=="20")
	{
		//支付成功处理更新数据库操作
		/*include(INC_PATH."/order.class.php");
    	$o=new OrderClass();
		$o->edit_money_state($v_oid,2,$v_amount);*/
		include_once(INC_PATH."/recharge.class.php");
		$rechargeobj=RechargeClass::init();
		$rechargeobj->paysuccess($v_oid,$v_amount);
		showmsg("支付成功！","../../../m.php");
	}
  echo "ok";
}else{
	echo "error";
}
?>