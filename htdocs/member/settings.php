<?php
//我的劵
InitGP(array("action","commit","email","username","oldpassword","password","password2","mobile")); //初始化变量全局返回
if (!empty($commit)) {
	//处理更新用户资料操作
	if ($password!=$password2) {
		showmessage(lang('two_pass_noCorrect'),"-1",false);	
	}
	
	
	$editarray=array(
		"tel"=>GetNum($mobile)
	);
	include("includes/member.class.php");
	$m=new memberclass();
	$msg=$m->edit($username,$email,$oldpassword,$password,$editarray);
	if ($msg=="OK") {
		showmessage(lang('Success_mod'),"login.php",true);
	}else {
		showmessage($msg,"-1",false);	
	}
	
	
}else {
	//显示资料修改表单
	
/**
 * 输出测试部分开始


print_r($_USERS);
 */
/**
 * 输出测试部分结束
 */

	include template('member_settings');//包含输出指定模板
	
}



?>