<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value")); //初始化变量全局返回
$Table=new TableClass("remittance","rid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("type","raction","orderby","orderway","keywords")); //初始化变量全局返回
	if(!empty($keywords))$wherestr[]=" remitname like '%$keywords%' ";
	$wherestr[]="addtime <> ''";
	
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	
	$orderway=$orderway=="desc"?"desc":"asc";
	if(!empty($orderby))$orderstr="{$orderby} {$orderway}";

	//获取当前页码
	$total=$Table->getcount($wheresql); 							  //总信息数
	$pagesize=16;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$Table->getdata("$offset,$pagesize",$wheresql,$orderstr); //获取数据
	//包含后台模板文件
	include("tpl/rechargeinfo.htm");
}elseif ($action=="del" && !empty($rid)){
	//执行删除操作
	$did=GetNum($rid);
	$info=$Table->del($rid);
	if($info=="OK")showmsg("删除成功！",PHP_SELF);
	else showmsg($info,PHP_SELF);
}else{
	showmsg("未知请求","-1");//出错！
}


?>