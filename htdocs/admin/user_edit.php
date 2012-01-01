<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","payid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("users","uid");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("uid","password","email","tname","sex","tel","zip","address","qq","msn","country","city","scores","money","memberid","remark")); //初始化变量全局返回
	if(!empty($_POST) and !empty($uid)){
		$uid=GetNum($uid);
		if(strlen($password)!=32)$password=md5($password);//用户密码加密
		$arrayedit=array(
			"password"=> $password,
			"email"=> Char_cv($email),
			"tname"=> Char_cv($tname),
			"sex"=> GetNum($sex),
			"qq"=> GetNum($qq),
			"msn"=> Char_cv($msn),
			"country"=> Char_cv($country),
			"city"=> Char_cv($city),
			"zip"=> Char_cv($zip),
			"tel"=> Char_cv($tel),
			"address"=> Char_cv($address),
			"money"=> GetNum($money),
			"scores"=> GetNum($scores),
			"memberid"=>Char_cv($memberid),
			"remark"=>Char_cv($remark)
		);
		$info=$Table->edit($uid,$arrayedit);
		if($info=="OK"){
			exit("<script language='javascript'>alert('编辑成功');parent.parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('编辑失败');parent.location.reload();</script>");
		}
	}else{
		$evalue=$Table->getone($uid);
		//print_r($evalue);
		include("tpl/user_edit.htm");
	}

}else{
	showmsg("未知请求","-1");//出错！
}


?>