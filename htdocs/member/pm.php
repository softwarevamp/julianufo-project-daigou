<?php
//我的劵
InitGP(array("action","mid","subject","message","page")); //初始化变量全局返回

include_once(INC_PATH."/pm.class.php");
$pm=PmClass::init();
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if (empty($action)) {
	$dataarray=$pm->getall();
	
	//输出模板
	include template('member_pm');//包含输出指定模板
	
}elseif ($action=="view" and !empty($mid)){
	
	$value=$pm->view($mid);
	//输出模板
	include template('member_pmview');//包含输出指定模板
}elseif ($action=="reply" and !empty($mid) and !empty($subject) and !empty($message)){
	//回复短信给管理员
	$info=$pm->reply($mid,$subject,$message);
	
		if(GetNum($info)){
			exit("<script language='javascript'>alert(".lang('reply_success').");parent.art.dialog({id:'msgIframe'}).close();</script>");
		}else{
			exit("<script language='javascript'>alert(".lang('Release_failed').");history.go(-1);</script>");
		}	
	
}elseif ($action=="del" and !empty($mid) ){
	
	$pm->del($mid);
	print("<script language='javascript'>alert(".lang('delete_success').");</script>");
	jumpurl(url('m.php?name=pm'));
}
//print_r($dataarray);

?>