<?php
include("../common.inc.php");
include("function_common.php");
include_once("../includes/member.class.php");
InitGP(array("page","action","state","value","payid","ids","gid","did","delids")); //初始化变量全局返回
$Table=new TableClass("goods","gid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("type","raction","orderby","orderway","keywords")); //初始化变量全局返回
	if(!empty($type))$wherestr[]="type='{$type}'";
	if(!empty($keywords))$wherestr[]=" goodsname like '%$keywords%' ";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	
	$orderway=$orderway=="desc"?"desc":"asc";
	if(!empty($orderby))$orderstr="{$orderby} {$orderway}";

	//获取当前页码
	$total=$Table->getcount($wheresql); 							  //总信息数
	$pagesize=16;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$Table->getdata("$offset,$pagesize",$wheresql,$orderstr); //获取团购数据
	//print_r($dataarray);
	//获取分类保存到数组
	$Tabletype=new TableClass("gtype","typeid");
	$tempdata=$Tabletype->getdata();
	foreach($tempdata as $v){
		$ATYPE[$v['typeid']]=$v['typename'];
	}
	//包含后台模板文件
	include("tpl/goods_list.htm");
}elseif ($action=="del" && !empty($did)){
	//执行删除操作
	$did=GetNum($did);
	$info=$Table->del($did);
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
	if($info=="OK")exit("1");
	
}elseif ($action=="audit" && !empty($gid)){
	//推荐送积分
	$gid=GetNum($gid);
	$arrayadd=array(
			"Audit"=> 1
		);
		$info=$Table->edit($gid,$arrayadd);
		if($info=="OK"){
				showmsg("更新成功!","goods_list.php");//出错！
		}else{
			showmsg("更新失败!","goods_list.php");//出错！
		}
	$member=new memberclass();
	$note="推荐送积分:".$cfg_recommend_score;
	$member->scoreedit($uname,$cfg_recommend_score,$note);
	
}else{
	showmsg("未知请求","-1");//出错！
}


?>