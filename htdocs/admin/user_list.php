<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","payid","ids","did","delids","name")); //初始化变量全局返回
$Table=new TableClass("users","uid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("state","orderby","orderway","keywords")); //初始化变量全局返回
	
	if(!empty($state))$countwherestr[]="state='{$state}'";
	
	if(!empty($state))$wherestr[]="U.state='{$state}'";
	//if(!empty($name))$wherestr[]="uname='{$name}'";
	if(!empty($keywords))$countwherestr[]=" CONCAT(uid,' ',uname,' ',email) like '%$keywords%' ";
	
	if(!empty($keywords))$wherestr[]=" CONCAT(U.uid,' ',U.uname,' ',U.email) like '%$keywords%' ";
	
	if(!empty($countwherestr)) $countwheresql = implode(' AND ', $countwherestr);	//条件汇总
	
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$orderway=$orderway=="desc"?"desc":"asc";
	if(!empty($orderby))$orderstr="{$orderby} {$orderway}";

	//获取当前页码
	$total=$Table->getcount($countwheresql); 							  //总信息数
	$pagesize=15;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$Table->getdata("$offset,$pagesize",$countwheresql,$orderstr); //获取团购数据
	//$sql="select sum(O.goodsprice +  O.sendprice),* from {$tablepre}order as O left join {$tablepre}users as U on O.uid=U.uid where {$wheresql} order by {$orderstr} limit {$offset},{$pagesize}";
	//$query =$db->query($sql);
	//while($value = $db->fetch_array($query)) {
			//$dataarray[]=$value;
	//}
	
	//包含后台模板文件
	include("tpl/user_list.htm");
}elseif ($action=="updatestate" && !empty($ids) && !empty($state)){
	//更改状态
	
	$state=GetNum($state);
	$ids=getdotstring(explode('|',$ids));
	$wheresqlarr="uid in({$ids})";
	editstate($Table->table,"state",$wheresqlarr,$state);//更改状态操作
	exit("1");
}elseif ($action=="del" && !empty($did)){
	//执行删除操作
	$did=GetNum($did);
	$info=$Table->del($did);
	if($info=="OK")showmsg("删除成功！",PHP_SELF);
	else showmsg($info,PHP_SELF);
}else{
	showmsg("未知请求","-1");//出错！
}


?>