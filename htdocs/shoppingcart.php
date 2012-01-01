<?php
//购物车
include("common.inc.php");
InitGP(array("action")); //初始化变量全局返回
include_once(INC_PATH."/cart.class.php");
$Cart=CartClass::init();
$dataarray=$Cart->getall();
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

include template('shopingcart');//包含输出指定模板
?>