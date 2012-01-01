<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","payid","typeid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("order","oid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("state","orderby","orderway","keywords")); //初始化变量全局返回
	if(!empty($state))$wherestr[]="state='{$state}'";
	if(!empty($keywords))$wherestr[]=" CONCAT(oid,' ',uname,' ',expressno,' ',goodsname,' ',goodsseller,' ',payid) like '%$keywords%' ";
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
	include("tpl/goodsimg_list.htm");
	
}elseif ($action=="updatestate" && !empty($ids) && !empty($state)){
	//更改状态
	
	$state=GetNum($state);
	$ids=getdotstring(explode('|',$ids),'int');
	$wheresqlarr="oid in({$ids})";
	editstate($Table->table,"state",$wheresqlarr,$state);//更改状态操作
	editstate($Table->table,"uptime",$wheresqlarr,$timestamp);//更改更新时间操作
	exit("1");
}elseif ($action=="updateweight" && !empty($ids) && !empty($value)){
	//更改状态
	$value=GetNum($value);
	$wheresqlarr="oid ={$ids}";
	editstate($Table->table,"orderweight",$wheresqlarr,$value);//更改状态操作
	editstate($Table->table,"uptime",$wheresqlarr,$timestamp);//更改更新时间操作
	exit("1");
}elseif ($action=="updateexpressno" && !empty($ids) && !empty($value)){
	//更改状态
	$ids=GetNum($ids);
	$wheresqlarr="oid ={$ids}";
	if(is_numeric($value)){
		$value=GetNum($value);
		editstate($Table->table,"expressno",$wheresqlarr,$value);//更改状态操作	
		editstate($Table->table,"uptime",$wheresqlarr,$timestamp);//更改更新时间操作
		exit("1");
	}else{
		$value=Char_cv($value);
		editstate($Table->table,"orderremark",$wheresqlarr,$value);//更改状态操作
		editstate($Table->table,"uptime",$wheresqlarr,$timestamp);//更改更新时间操作
		exit("1");		
	}
}elseif ($action=="updatepayid" && !empty($ids) && !empty($payid)){
	//更改状态
	$payid=Char_cv($payid);
	$ids=getdotstring(explode('|',$ids),'int');
	$wheresqlarr="oid in({$ids})";
	editstate($Table->table,"payid",$wheresqlarr,$payid);//更改状态操作
	editstate($Table->table,"uptime",$wheresqlarr,$timestamp);//更改更新时间操作
	exit("1");
}elseif ($action=="updatetypeid" && !empty($ids) && !empty($typeid)){
	//更改状态
	$typeid=GetNum($typeid);
	$ids=getdotstring(explode('|',$ids),'int');
	$wheresqlarr="oid in({$ids})";
	editstate($Table->table,"typeid",$wheresqlarr,$typeid);//更改状态操作
	editstate($Table->table,"uptime",$wheresqlarr,$timestamp);//更改更新时间操作
	exit("1");
}elseif ($action=="dels"){
	if(empty($delids)){showmsg("没有选择任何对象！",PHP_SELF);exit;}//空选择
	//执行删除多个操作
	foreach ($delids as $id){
		$id=GetNum($id);
		$info=$Table->del($id);
	}
	if($info=="OK")showmsg("删除成功！",PHP_SELF);
	else showmsg($info,PHP_SELF);
}

//获取选择payid 下拉框
function getpayidselect($var="",$value="",$other=""){
	$Table=new TableClass("payid","pid");
	$arraydata=$Table->getdata();
	foreach ($arraydata as $val){
		$arrayoption[$val['payid']]=$val['payid'];
	}
	return getselectstr($var, $arrayoption, $value, $other);
}
//获取选择订单分类下拉框
function getotypeselect($var="",$value="",$other=""){
	$Table=new TableClass("otype","typeid");
	$arraydata=$Table->getdata('','','typeid asc');
	foreach ($arraydata as $val){
		$arrayoption[$val['typeid']]=$val['typename'];
	}
	return getselectstr($var, $arrayoption, $value, $other);
}
?>