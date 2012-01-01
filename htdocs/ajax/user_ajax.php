<?php
session_start();
//购物车相关ajax数据处理
include("../common.inc.php");
InitGP(array("action","remark","gid","num","gids","cityid")); //初始化变量全局返回
include(INC_PATH."/member.class.php");
$m=new memberclass();
AjaxHead();
if($action=='checkemail'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$email=$jsondata->email;
	$info=$m->checkemail($email,true);
	echo json_encode($info);
	exit;
}else if($action=='checkuname'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$username=$jsondata->username;
	$info=$m->checkuname($username,true);
	echo json_encode($info);
	exit;
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
}else if($action=='resendemail'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));	
	$username=$jsondata->uname;
	$resendactiveeamil=get_cookie('resendactiveeamil');
	if (empty($resendactiveeamil)) {
		set_cookie('resendactiveeamil',1,600);
	}else {
		echo json_encode('again');//重复发送
	}
	$info=$m->sendactiveemail($username);
	echo json_encode($info);
	exit;
}else if($action=='changeemail'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));	
	$newemail=$jsondata->email;	
	if (!empty($_USERS)) {
		$m->edit($_USERS['uname'],$newemail);
		$info=$m->sendactiveemail($username);
		echo json_encode($info);		
	}else {
		$info=$m->sendactiveemail($username,$newemail);
		echo json_encode($info);
	}
}
?>