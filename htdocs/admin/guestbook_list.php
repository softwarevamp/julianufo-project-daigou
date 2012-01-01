<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","gid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("guestbook","gid");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("type","raction","orderby","orderway","keywords")); //初始化变量全局返回
	if(!empty($keywords))$wherestr[]=" CONCAT(msg,' ',reply,' ',uname) like '%$keywords%' ";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	
	$orderway=$orderway=="desc"?"desc":"asc";
	if(!empty($orderby))$orderstr="{$orderby} {$orderway}";

	//获取当前页码
	$total=$Table->getcount($wheresql); 							  //总信息数
	$pagesize=20;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$Table->getdata("$offset,$pagesize",$wheresql,$orderstr); //获取团购数据
	//print_r($dataarray);
	
	//包含后台模板文件
	include("tpl/guestbook_list.htm");

	
}elseif ($action=="reply" && !empty($gid)){
	InitGP(array("gid","hide","state","reply")); //初始化变量全局返回
	if(!empty($_POST) and !empty($gid)){

		$gid=GetNum($gid);
		$arrayadd=array(
			"hide"=> GetNum($hide),
			"state"=> GetNum($state),
			"reply"=>HtmlReplace($reply,-1)
		);
		$info=$Table->edit($gid,$arrayadd);
		if($info=="OK"){
				exit("<script language='javascript'>alert('回复成功');parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('编辑失败');location.reload();</script>");
		}
	}else{
		$evalue=$Table->getone($gid);
		//print_r($evalue);
		include("tpl/guestbook_reply.htm");
	}

}elseif ($action=="updatestate" && !empty($ids)){
	//更改状态
	
	$state=GetNum($state);
	$ids=getdotstring(explode('|',$ids));
	$wheresqlarr="gid in({$ids})";
	editstate($Table->table,"state",$wheresqlarr,$state);//更改状态操作
	exit("1");
}elseif ($action=="updatehide" && !empty($ids)){
	//更改状态
	
	$state=GetNum($state);
	$ids=getdotstring(explode('|',$ids));
	$wheresqlarr="gid in({$ids})";
	editstate($Table->table,"hide",$wheresqlarr,$state);//更改状态操作
	exit("1");
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