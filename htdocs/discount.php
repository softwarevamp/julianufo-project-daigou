<?php
include("common.inc.php");
InitGP(array("action","did",'page')); //初始化变量全局返回
$discountobj=new TableClass('discount','did');

if (empty($action)) {
	//$wherestr[]="flag<>'c'";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	//获取当前页码
	$total=$discountobj->getcount($wheresql); 						  //总信息数
	if ($total>1000) $total=1000;								  //显示最大一千条
	$pagesize=12;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$discountobj->getdata("$offset,$pagesize",$wheresql,"",'did,title,flag,about,pic,discounttime,discounturl,listorder,addtime'); //获取数据
	
	//获取头条和推荐
	$topharray=$discountobj->getdata(1,"flag='h'",'listorder asc,did desc','did,title,flag,about,pic,listorder,addtime');
	$topcarray=$discountobj->getdata(6,"flag='c'",'listorder asc,did desc','did,title,flag,about,pic,discounttime,listorder,addtime');
	
	include template('discount');//包含输出指定模板
	
}elseif ($action=="view"){
	$did=GetNum($did);
	$value=$discountobj->getone($did);
	$topcarray=$discountobj->getdata(10,"flag='c'",'listorder asc,did desc','did,title,flag,about,pic,discounttime,listorder,addtime');

	//读取编辑推荐
	$goodsobj=new TableClass('goods','gid');
	$rightarray=$goodsobj->getdata(5,"flag='c'",'listorder asc,gid desc','gid,gtypeid,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,addtime');	
	
	include template('discount_view');//包含输出指定模板
}else{
	exit(lang('Missing_parameter'));
}
?>