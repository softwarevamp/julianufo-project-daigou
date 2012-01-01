<?php
include("../common.inc.php");
InitGP(array("page","action","aid","delids")); //初始化变量全局返回
include("function_common.php");
$mange=new TableClass("adminmange","mid");

//控制只显示有权限的控制选项
$wherestr="mid in({$_ADMINUSERS['adminmid']})";
$menuarray=$mange->getdata('',$wherestr,'listorder asc,mid asc');

$menuzone=array();
$menugroup=array();
$zonestrarray=array();
$groupstrarray=array();
$itemstrarray=array();
foreach($menuarray as $value){
	if($value['type']=='zone'){
		$menuzone[]=$value;
	}
	if($value['type']=='group'){
		$menugroup[]=$value;
	}
	if($value['type']=='item'){
		$itemstrarray[$value['node']][]="'{$value['mcode']}' : ['{$value['mname']}','{$value['murl']}','']";
	}
}
foreach($menuzone as $value){
	foreach($menugroup as $value1){
		if($value1['node']==$value['mid']){
			$groupstrarray[$value['mid']][]="'{$value1['mcode']}' : {".implode_field_value($itemstrarray[$value1['mid']],',')."}";
		}
}}
foreach($menuzone as $value){
$zonestrarray[]="'{$value['mcode']}' : {".implode_field_value($groupstrarray[$value['mid']],',')."}";
}
function implode_field_value($array, $glue = ',') {
	$sql = $comma = '';
	foreach ($array as $k => $v) {
		$sql .= $comma."$v";
		$comma = $glue;
	}
	return $sql;
}

//包含后台模板文件
include("tpl/index.htm");
?>