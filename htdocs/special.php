<?php
include("common.inc.php");
InitGP(array("action","sid",'page')); //初始化变量全局返回
$specialobj=new TableClass('special','sid');

if (empty($action)) {
	$wherestr[]="flag='hd'";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	//获取当前页码
	$total=$specialobj->getcount($wheresql); 						  //总信息数
	if ($total>1000) $total=1000;								  //显示最大一千条
	$pagesize=6;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$specialobj->getdata("$offset,$pagesize",$wheresql,"",'sid,title,flag,about,pic,listorder,addtime'); //获取数据
	
	//获取头条和推荐
	$topharray=$specialobj->getdata(1,"flag='hd'",'listorder asc,sid desc','sid,title,flag,about,pic,listorder,addtime');
	$topcarray=$specialobj->getdata(3,"flag='hd'",'listorder asc,sid desc','sid,title,flag,about,pic,listorder,addtime');
	
	include template('special');//包含输出指定模板
	
}elseif ($action=="view"){
	$sid=GetNum($sid);
	$value=$specialobj->getone($sid);
	
	include template('special_view');//包含输出指定模板
}else{
	exit(lang('Missing_parameter'));
}
?>