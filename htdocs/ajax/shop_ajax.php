<?php
//弹出一键填单相关ajax数据处理
include("../common.inc.php");
InitGP(array("action","url","refuname","referer","aid","cityid")); //初始化变量全局返回
$goodsobj=new TableClass('shop_goods','gid');
AjaxHead();
if($action=='addbuynum'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$gid=GetNum($jsondata->pid);
	$wheresqlarr="gid=".$gid;
	addfield($goodsobj->table,'buynum',$wheresqlarr,1);
	echo json_encode('OK');
	exit;

}
?>