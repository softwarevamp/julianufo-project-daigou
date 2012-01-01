<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","sid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("shopsite","sid");
AjaxHead();//禁止页面缓存
include_once(INC_PATH.'/shopsite.class.php');
$ShopSite=new ShopClass();

if(empty($action)){
	InitGP(array("state","orderby","orderway","keywords")); //初始化变量全局返回
	if(!empty($state))$wherestr[]="state='{$state}'";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$orderway=$orderway=="desc"?"desc":"asc";
	if(!empty($orderby))$orderstr="{$orderby} {$orderway}";

	//获取当前页码
	$total=$Table->getcount($wheresql); 							  //总信息数
	$pagesize=15;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$Table->getdata("$offset,$pagesize",$wheresql,$orderstr); //获取团购数据
	//print_r($dataarray);
	
	//包含后台模板文件
	include("tpl/shopsite_list.htm");
}elseif ($action=="updatestate" && !empty($ids)){
	//更改状态
	
	$state=GetNum($state);
	$ids=getdotstring(explode('|',$ids));
	$wheresqlarr="sid in({$ids})";
	editstate($Table->table,"state",$wheresqlarr,$state);//更改状态操作
	$ShopSite->cachedata();
	exit("1");
}elseif ($action=="del" && !empty($did)){
	//执行删除操作
	$did=GetNum($did);
	$info=$Table->del($did);
	$ShopSite->cachedata();
	if($info=="OK")showmsg("删除成功！",PHP_SELF);
	else showmsg($info,PHP_SELF);
}elseif ($action=="dels"){
	if(empty($delids)){showmsg("没有选择任何对象！",PHP_SELF);exit;}//空选择
	//执行删除多个操作
	$delids=explode('|',$delids);
	foreach ($delids as $id){
		if(GetNum($id)){
			$info=$Table->del($id);
		}
	}
	$ShopSite->cachedata();
	if($info=="OK")exit("1");
	
}else{
	showmsg("未知请求","-1");//出错！
}


?>