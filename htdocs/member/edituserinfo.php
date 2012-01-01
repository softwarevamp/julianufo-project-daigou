<?php
//我的劵
InitGP(array("action","mid","page")); //初始化变量全局返回
include_once(INC_PATH."/member.class.php");
$m=new memberclass();
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if (empty($action)) {
	$value=$m->getone($_USERS['uname']);
}elseif ($action=='save'){
	InitGP(array("tname","sex","tel","zip","address","qq","msn","country","city","oldface","commit")); //初始化变量全局返回
	if (!empty($commit)) {
		
		//上传图片处理
		require_once (INC_PATH.'/upload.class.php');
		$f = new Upload('attachment/avatar',array('gif','jpg','jpge','png'),50000);//路径 允许扩展名 文件尺寸
		$f->setThumb(0);//设置不生成缩微图
		$f->run('faceimg',1);
		$info=$f->getInfo();
		$imgdata=$info[0]['fullsavename'];//获取第一个上传图片反馈
		if(isset($info[0]['error']))$imgdata=$oldface;
		$editarray=array(
			"tname"=>Char_cv($tname),
			"sex"=>GetNum($sex),
			"tel"=>GetNum($tel),
			"zip"=>Char_cv($zip),
			"address"=>Char_cv($address),
			"qq"=>GetNum($qq),
			"msn"=>Char_cv($msn),
			"country"=>Char_cv($country),
			"face"=>$imgdata,
			"city"=>Char_cv($city)
		);
		$msg=$m->edit($_USERS['uname'],'',$_USERS['password'],'',$editarray);
		if ($msg=="OK") {
			print("<script language='javascript'>alert(".lang('update_success').");</script>");
			jumpurl(url('m.php?name=edituserinfo'));
		}else {
			print("<script language='javascript'>alert(".lang('update_lose').");</script>");
			jumpurl(url('m.php?name=edituserinfo'));			
		}
		
	}else 
		$value=$m->getone($_USERS['uname']);	
}
include template('member_edituserinfo');//包含输出指定模板
?>