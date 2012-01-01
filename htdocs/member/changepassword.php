<?php
session_start();
//修改密码
InitGP(array("action","mid","page")); //初始化变量全局返回
include_once(INC_PATH."/member.class.php");
$m=new memberclass();
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if (empty($action)) {
	$value=$m->getone($_USERS['uname']);
}elseif ($action=='save'){
	InitGP(array("oldPasswordTxt","newPasswordTxt","ckeckPasswordTxt","checkTxt","commit")); //初始化变量全局返回
	if (!empty($_POST)) {
		$newPasswordTxt=Char_cv($newPasswordTxt);
		if (!empty($newPasswordTxt) and md5($oldPasswordTxt)==$_USERS['password']) {
			$msg=$m->edit($_USERS['uname'],'',$_USERS['password'],$newPasswordTxt,$editarray);
			if ($msg=="OK") {
				print("<script language='javascript'>alert(".lang('update_success').");</script>");
				jumpurl(url('m.php?name=edituserinfo'));
				exit;
			}else {
				print("<script language='javascript'>alert(".lang('update_lose').");</script>");
				jumpurl(url('m.php?name=edituserinfo'));	
				exit;		
			}
		}else{
				print("<script language='javascript'>alert(".lang('update_lose').");</script>");
				jumpurl(url('m.php?name=edituserinfo'));	
				exit;			
		}
	}else 
		$value=$m->getone($_USERS['uname']);	
}elseif ($action=='checkcode'){
	InitGP(array("code")); //初始化变量全局返回
	include(INC_PATH."/code/securimage.php");
	$img = new Securimage();
	$valid = $img->check($code);
	if($valid != true) {
  		exit('0');
  	}else{
 		exit('1');
  	}
}

include template('member_changepassword');//包含输出指定模板
?>