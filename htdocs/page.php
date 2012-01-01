<?php
//帮助中心
include("common.inc.php");
InitGP(array("action","nid",'page')); //初始化变量全局返回


if (empty($action) || $action=='estimates') {
	$areaobj=new TableClass('area','aid');
	$areaarray=$areaobj->getdata('','state=1');
	
	include template('page/estimates');//包含输出指定模板
	
}elseif ($action=="measureconversion"){

	include template('page/measureconversion');//包含输出指定模板
	
}elseif ($action=="postage"){

	include template('page/postage');//包含输出指定模板
	
}elseif ($action=="track"){

	include template('page/track');//包含输出指定模板
	
}else{
	exit(lang('Missing_parameter'));
}
?>