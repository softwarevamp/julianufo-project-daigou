<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","pid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("payid","pid");
AjaxHead();//禁止页面缓存

InitGP(array("type","raction","orderby","orderway","keywords")); //初始化变量全局返回
if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
$orderway=$orderway=="desc"?"desc":"asc";
if(!empty($orderby))$orderstr="{$orderby} {$orderway}";else{$orderstr="pid asc";}
//获取当前页码
$total=$Table->getcount($wheresql); 							  //总信息数
$pagesize=20;												  //一页显示信息数
$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
$offset=($page-1)*$pagesize;   								  //偏移量
$dataarray=$Table->getdata("$offset,$pagesize",$wheresql,$orderstr); //获取团购数据


if(empty($action)){
	//包含后台模板文件
	include("tpl/payid_list.htm");
}elseif ($action=="add"){
	InitGP(array("payabout","payid")); //初始化变量全局返回
	if(!empty($_POST) and !empty($payid)){
		$arrayadd=array(
			"payid"=> Char_cv($payid),
			"payabout"=> Char_cv($payabout)
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
				showmsg("发布成功!",PHP_SELF);//出错！
		}else{
			showmsg("发布失败!","-1");//出错！
		}
	}else{
		$evalue=$Table->getone($pid);
		//print_r($evalue);
		include("tpl/payid_list.htm");
	}
	
}elseif ($action=="edit"){
	InitGP(array("payabout","payid")); //初始化变量全局返回
	if(!empty($_POST) and !empty($payid)){
		$pid=GetNum($pid);
		if(empty($pid))showmsg("ID不能为空!",PHP_SELF);//出错！
		if(empty($payid))showmsg("拍名称不能为空!",PHP_SELF);//出错！
		$arrayadd=array(
			"payid"=> Char_cv($payid),
			"payabout"=> Char_cv($payabout)
		);
		$info=$Table->edit($pid,$arrayadd);
		if($info=="OK"){
				showmsg("更新成功!",PHP_SELF);//出错！
		}else{
			showmsg("更新失败!","-1");//出错！
		}
	}else{
		$evalue=$Table->getone($pid);
		//print_r($evalue);
		include("tpl/payid_list.htm");
	}
	
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
	
}else{
	showmsg("未知请求","-1");//出错！
}
?>