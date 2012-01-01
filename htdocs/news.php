<?php
//帮助中心
include("common.inc.php");
InitGP(array("action","nid",'page')); //初始化变量全局返回
$newsobj=new TableClass('news','nid');

if (empty($action)) {
	//$wherestr[]="flag<>'c'";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	//获取当前页码
	$total=$newsobj->getcount($wheresql); 						  //总信息数
	if ($total>1000) $total=1000;								  //显示最大一千条
	$pagesize=15;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$newsobj->getdata("$offset,$pagesize",$wheresql); //获取数据
	
	//获取头条和推荐

	
	include template('news');//包含输出指定模板
	
}elseif ($action=="view"){
	$nid=GetNum($nid);
	$value=$newsobj->getone($nid);
	
	include template('news_view');//包含输出指定模板
}else{
	exit(lang('Missing_parameter'));
}
?>