<?php
require_once (dirname(__FILE__) . "/../../common.inc.php");

include_once CFG_CACHEPATH.'/sys_pay.cache.php';//支付配置文件

require_once(dirname(__FILE__)."/nps_config.php");

if(empty($_POST['m_orderid'])){
	echo "非法访问！";
	exit();
}
//=========================== 把商家的相关信息返回去 =======================
					//$_POST['
	$m_id		= 	$_POST['m_id'];					//商家号	
	$m_orderid	= 	$_POST['m_orderid'];			//商家订单号
	$m_oamount	= 	$_POST['m_oamount'];			//支付金额
	$m_ocurrency= 	$_POST['m_ocurrency'];			//币种		
	$m_language	= 	$_POST['m_language'];			//语言选择
	$s_name		= 	$_POST['s_name'];				//消费者姓名
	$s_addr		= 	$_POST['s_addr'];				//消费者住址
	$s_postcode	= 	$_POST['s_postcode'];			//邮政编码
	$s_tel		= 	$_POST['s_tel'];				//消费者联系电话
	$s_eml		= 	$_POST['s_eml'];				//消费者邮件地址
	$r_name		= 	$_POST['r_name'];				//消费者姓名
	$r_addr		= 	$_POST['r_addr'];				//收货人住址
	$r_postcode	= 	$_POST['r_postcode'];			//收货人邮政编码
	$r_tel		= 	$_POST['r_tel'];				//收货人联系电话
	$r_eml		= 	$_POST['r_eml'];				//收货人电子地址
	$m_ocomment	= 	$_POST['m_ocomment'];			//备注
	$State		=	$_POST['m_status'];				//支付状态2成功,3失败
	$modate		=	$_POST['modate'];				//返回日期
	//接收组件的加密
	$OrderInfo	=	$_POST['OrderMessage'];			//订单加密信息
	$signMsg 	=	$_POST['Digest'];				//密匙
	//接收新的md5加密认证
	$newmd5info	=	$_POST['newmd5info'];
	
	
$memberid	= $m_ocomment;			//备注 这里是返回站内的会员编号
$buyid		= ereg_replace("[^-0-9A-Za-z]","",$m_orderid);   //商家订单号
$mState		=	$_POST['m_status'];//支付状态2成功,3失败
$OrderInfo	=	$OrderMessage;  //订单加密信息
$signMsg 	=	$Digest;				   //密匙
//接收新的md5加密认证
$newmd5info	=	$newmd5info;
$digest = strtoupper(md5($OrderInfo.$cfg_merpassword));

//本地的校对密钥
$newtext = $m_id.$m_orderid.$m_oamount.$cfg_merpassword.$mState;
$myDigest = strtoupper(md5($newtext));
$mysign == md5($cfg_merchant.$buyid.$money.$success.$cfg_merpassword);
//--------------------------------------------------------

//签名正确
if($digest == $signMsg && $mState==2){
	$OrderInfo = HexToStr($OrderInfo);
	
	if($newmd5info == $myDigest) //md5密匙认证
	{
		//支付成功处理更新数据库操作
		include(INC_PATH."/order.class.php");
    	$o=new OrderClass();
		$o->edit_money_state($buyid,2,$m_oamount);
		showmsg("支付成功！","../../m.php");

		
  }else{
  	showmsg("交易密钥错误，请与管理员联系！","-1");
	  exit();
  }
}else{
	showmsg("交易密钥错误，请与管理员联系！","-1");
	exit();
}
?>
