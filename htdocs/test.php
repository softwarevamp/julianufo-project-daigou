<?php
include("common.inc.php");
InitGP(array("action","refuid","refuname","referer","aid","cityid")); //初始化变量全局返回



		//执行支付成功操作
		include_once(INC_PATH."/rate.class.php");
		$Rate=RateClass::init();

$info=$Rate->get();
//print_r($info);

$a=1;
$b=2;
$c=3;
$d=array($a,$b,$c);
echo join("",$d);



include template('shop/news');//包含输出指定模板

?>

