<?php
session_start();
//修改邮箱
InitGP(array("action","mid","page")); //初始化变量全局返回
include_once(INC_PATH."/member.class.php");
$m=new memberclass();
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if (empty($action)) {
	$value=$m->getone($_USERS['uname']);
}elseif ($action=='save'){
	InitGP(array("passwordTxt","newEmailTxt","regEmailTxt","regCodeTxt","commit")); //初始化变量全局返回
	if (!empty($_POST)) {
		$passwordTxt=Char_cv($passwordTxt);
		if (isemail($newEmailTxt) and md5($passwordTxt)==$_USERS['password']) {
			$msg=$m->edit($_USERS['uname'],$newEmailTxt,$_USERS['password'],'');
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
}elseif ($action=='checkemail'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	if(isemail($jsondata->email)){
		$info=$m->checkemail($jsondata->email);
		if ($info=="OK") {
			exit(json_encode('OK'));
		}else exit(json_encode($info));
	}else {
		exit(json_encode(lang('Malformed')));
	}
	
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

include template('member_changeemail');//包含输出指定模板
?>