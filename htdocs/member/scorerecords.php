<?php
InitGP(array("type","s","e","page")); //初始化变量全局返回

if (!empty($type)) {
	$type=GetNum($type);
	$wherestr[]="type='{$type}'";
}
if (!empty($s)) {
	$s=strtotime($s);
	$wherestr[]="addtime > '{$s}'";
}
if (!empty($e)) {
	$e=strtotime($e);
	$wherestr[]="addtime < '{$e}'";
}

$r=new TableClass("scorerecord","sid");
if(!empty($_USERS['uname'])){
	$uname=$_USERS['uname'];
	$wherestr[]="uname='{$uname}'";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	//获取当前页码
	$total=$r->getcount($wheresql); 							  //总信息数
	$pagesize=10;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$r->getdata("$offset,$pagesize",$wheresql); //获取团购数据
}


//print_r($dataarray);

include template('member_scorerecords');//包含输出指定模板
?>