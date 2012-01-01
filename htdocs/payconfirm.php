<?php
//处理付款
include("common.inc.php");
InitGP(array("action","gids","__PAYDATA","referer","aid","cityid")); //初始化变量全局返回
include_once(INC_PATH."/cart.class.php");
$Cart=CartClass::init();

//订单列表显示
if(empty($__PAYDATA)){
	$dataarray=$Cart->getall($gids);
	//处理购物车数据
	foreach ($dataarray as $val) {
		$temparray[$val['goodsseller']][]=$val;
			if (!empty($s[$val['goodsseller']])){
				if($val['sendprice']>$s[$val['goodsseller']]){
					$s[$val['goodsseller']]=$val['sendprice'];
				}
			}else{
				$s[$val['goodsseller']]=$val['sendprice'];
			}
	}
	$countdata=$Cart->countmoney($dataarray);
	//生成校验数据
	$ids=getdotstring($gids,'int');
	$auth=$ids."\t".$countdata['totalmoney'];
	$paydata=cookie_authcode($auth,'ENCODE');
	
	
	include template('payconfirm');//包含输出指定模板
}else{
	//处理提交信息
	@list($ids, $totalmoney) = explode("\t", cookie_authcode($__PAYDATA,'DECODE'));
	if($ids==getdotstring($gids,'int') and !empty($ids)){
		$tempids=$ids;
	}else{
		exit(lang('Data_exception'));
	}
	//处理扣费和订单转移并且记录日志操作
	$info=$Cart->carttoorder($tempids);
	if ($info=='OK') {
		print("<script language='javascript'>alert(".lang('Submitted_successfully').");</script>");
		jumpurl(url("m.php"));
	}else{
		print("<script language='javascript'>alert('".$info."');</script>");
		jumpurl(url("m.php"));
	}
}
?>