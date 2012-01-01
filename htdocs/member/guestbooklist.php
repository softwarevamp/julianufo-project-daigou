<?php
//我的劵
InitGP(array("action","type","oid","page")); //初始化变量全局返回
include_once(INC_PATH."/guestbook.class.php");
$Table=new GuestBookClass();

AjaxHead();
if(empty($action)){
	$uname=$_USERS['uname'];
	$wherestr[]="G.uname='{$uname}'";
if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总

//获取当前页码
$total=$Table->getcount("uname='{$uname}'"); 							  //总信息数
$pagesize=5;												  //一页显示信息数
$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
$offset=($page-1)*$pagesize;   								  //偏移量
$dataarray=$Table->getdata("$offset,$pagesize",$wheresql); //获取团购数据

}

//print_r($dataarray);

include template('member_guestbooklist');//包含输出指定模板
?>