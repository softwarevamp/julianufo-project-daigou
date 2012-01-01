<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","inbox","uname","email","subject","message","did","delids")); //初始化变量全局返回
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("uid","isadmin","email","subject","message")); //初始化变量全局返回
	if(!empty($_POST) and !empty($subject)){
		//发送邮件
		if(isemail($email) && !empty($message)){
		$emailstr=$message;
		include_once(INC_PATH."/sendmail.class.php");
		$sendmail=new SendEmail();
		$sendmail->sendmailto($subject,$emailstr,$email);
		
		
			if(!empty($inbox)){
				exit("<script language='javascript'>alert('".$sendmail->printmsg."');parent.$.fn.colorbox.close();</script>");
			}else{
				showmsg($sendmail->printmsg,PHP_SELF);//出错！
			}
		}else{
			if(!empty($inbox)){
				exit("<script language='javascript'>alert('email格式错误');location.reload();</script>");
			}else{
				showmsg("email格式错误",PHP_SELF);//出错！
			}
		}
	}else{
		if(!empty($uname)){
			$email=DB::result_first("select email from ".DB::table('users')." where uname = '{$uname}'");//查询email
		}

		//print_r($evalue);
		include("tpl/email_send.htm");
	}

}else{
	showmsg("未知请求","-1");//出错！
}

?>