<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","ipid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("ipfiltering","ipid");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("ipid","ip","uname","addtime","remark")); //初始化变量全局返回
	if(!empty($_POST) and !empty($uname)){

		if(empty($uname))showmsg("用户名不能为空!","-1");//出错！
		$arrayadd=array(
			"ip"=> Char_cv($ip),
			"uname"=> Char_cv($uname),
			"addtime"=> time(),
			"remark"=> GetNum($remark)
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
			exit("<script language='javascript'>alert('发布成功');parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('发布失败');history.go(-1);</script>");
		}
	}else{

		include("tpl/ipfilter_edit.htm");
	}
}elseif($action=="edit" && !empty($ipid)){
	InitGP(array("ipid","ip","uname","addtime","remark")); //初始化变量全局返回
	if(!empty($_POST) and !empty($uname) and !empty($ipid)){
		$ipid=GetNum($ipid);
		if(empty($ipid))showmsg("缺少ID参数!","-1");//出错！
		if(empty($uname))showmsg("用户名不能为空!","-1");//出错！
		$arrayadd=array(
			"ip"=> Char_cv($ip),
			"uname"=> Char_cv($uname),
			"remark"=> GetNum($remark)
		);
		$info=$Table->edit($ipid,$arrayadd);
		if($info=="OK"){
		
			exit("<script language='javascript'>alert('编辑成功');parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('编辑失败');history.go(-1);</script>");
		}
	}else{
		$evalue=$Table->getone($ipid);
		//print_r($evalue);
		include("tpl/ipfilter_edit.htm");
	}


}else{
	showmsg("未知请求","-1");//出错！
}