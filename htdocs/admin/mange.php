<?php
include("../common.inc.php");
InitGP(array("page","action","did","delids")); //初始化变量全局返回
include("function_common.php");
$mange=new TableClass("adminmange","mid");
$menuarray=$mange->getdata('','','listorder asc,mid asc');
$menuname=array('zone'=>'管理分区','group'=>'管理分组','item'=>'管理项');

if ($action=="add") {
	InitGP(array("mid","mname","type","node","murl","listorder","mcode","Submit")); //初始化变量全局返回
	if(!empty($Submit)){
		if($type=="zone")$node=0;
	
		$arrayinsert=array(
			"mname"=> Char_cv($mname),
			"type"=> Char_cv($type),
			"node"=> GetNum($node),
			"murl"=> Char_cv($murl),
			"listorder"=>GetNum($listorder) ,
			"mcode"=> Char_cv($mcode)
		);
		$info=$mange->add($arrayinsert);
		if(GetNum($info)){
			showmsg("添加成功!",PHP_SELF);//成功
		}else showmsg($info,"-1");//出错！	
	}
}elseif ($action=="edit") {
	InitGP(array("mid","mname","type","node","murl","listorder","mcode","Submit")); //初始化变量全局返回
	if(!empty($Submit)){
		$mid=GetNum($mid);
		if($type=="zone")$node=0;
		if($mid==0)showmsg("缺少ID参数!",-1);//成功
		$arrayedit=array(
			"mname"=> Char_cv($mname),
			"type"=> Char_cv($type),
			"node"=> GetNum($node),
			"murl"=> Char_cv($murl),
			"listorder"=>GetNum($listorder) ,
			"mcode"=> Char_cv($mcode)
		);
		$info=$mange->edit($mid,$arrayedit);
		if($info=="OK"){
			showmsg("编辑成功!",PHP_SELF);//成功
		}else showmsg($info,"-1");//出错！	
	
	}else{
	$evalue=$mange->getone($mid);
	}
}elseif ($action=="del" && !empty($did)){
	//执行删除操作
	$did=GetNum($did);
	$info=$mange->del($did);
	if($info=="OK")showmsg("删除成功！",PHP_SELF);
	else showmsg($info,"article_list.php");
}elseif ($action=="dels"){
	if(empty($delids)){showmsg("没有选择任何对象！",PHP_SELF);exit;}//空选择
	//执行删除多个操作
	foreach ($delids as $id){
		$id=GetNum($id);
		$info=$mange->del($id);
	}
	if($info=="OK")showmsg("删除成功！",PHP_SELF);
	else showmsg($info,PHP_SELF);
}
//包含后台模板文件
include("tpl/mange.htm");
?>