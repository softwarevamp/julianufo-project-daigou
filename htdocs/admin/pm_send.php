<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","inbox","value","payid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("pm","mid");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("uid","isadmin","uname","subject","message")); //初始化变量全局返回
	if(!empty($_POST) and !empty($subject)){
		//群发
		if($isadmin==1){
			$uid=$uname=0;
		}else{
			$uid=DB::result_first("select uid from ".DB::table('users')." where uname = '{$uname}'");//查询uid
			$uid=GetNum($uid);
			$isadmin=0;
			if($uid==0)showmsg("用户名不存在!","-1");//出错！		
		}
		$arrayadd=array(
			"fromuid"=> 0,
			"fromuname"=> Char_cv($_ADMINUSERS['adminname']),
			"touid"=> $uid,
			"touname"=> Char_cv($uname),
			"type"=> 1,
			"subject"=> Char_cv($subject),
			"message"=> Char_cv($message),
			"sendtime"=> $timestamp,
			"writetime"=> $timestamp,
			"hasview"=> 0,
			"isadmin"=> $isadmin
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
			if(!empty($inbox)){
				exit("<script language='javascript'>alert('发送成功');parent.$.fn.colorbox.close();</script>");
			}else{
				showmsg("发送成功",PHP_SELF);//出错！
			}
		}else{
			if(!empty($inbox)){
				exit("<script language='javascript'>alert('发送失败');location.reload();</script>");
			}else{
				showmsg("发送成功",PHP_SELF);//出错！
			}
		}
	}else{
		if(!empty($uid)){
			$Tableu=new TableClass("users","uid");
			$evalue=$Tableu->getone($uid);
		}elseif(!empty($uname)){
			$evalue['uname']=$uname;
		}
		//print_r($evalue);
		include("tpl/pm_send.htm");
	}

}else{
	showmsg("未知请求","-1");//出错！
}

?>