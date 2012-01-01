<?php
include("../common.inc.php");
InitGP(array("page","action","eid","delids")); //初始化变量全局返回
include("function_common.php");
//初始化对象
$smtp=new TableClass("smtpaccount","eid");

if(empty($action)){
	InitGP(array("email","eid")); //初始化变量全局返回
	if(!empty($uname))$wherestr[]="email like '%{$email}%'";
	if(!empty($tid))$wherestr[]="state in({$tid})";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	
	//获取当前页码
	$total=$smtp->getcount($wheresql); 							  //总信息数
	$pagesize=15;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$smtp->getdata("$offset,$pagesize",$wheresql); //获取团购数据
	
	//包含后台模板文件
	include("tpl/smtp_list.htm");
}elseif ($action=="edit") {
	InitGP(array("eid","smtp_server","smtp_port","smtp_email","smtp_account","smtp_password","reply_address","smtp_auth","smtp_ssl","state","Submit")); //初始化变量全局返回
	if(!empty($Submit)){
		$editarray=array(
			"smtp_server"=>$smtp_server,
			"smtp_port"=>$smtp_port,
			"smtp_email"=>$smtp_email,
			"smtp_account"=>$smtp_account,
			"smtp_password"=>$smtp_password,
			"reply_address"=>$reply_address,
			"smtp_ssl"=>$smtp_ssl,
			"state"=>$state,
			"smtp_auth"=>$smtp_auth
		);
		$info=$smtp->edit($eid,$editarray);
		if($info=="OK"){showmsg("编辑成功!","smtp_list.php");//成功
		}else showmsg($info,"-1");//出错！

	}else {
	
	//编辑信息表单
	$dataedit=$smtp->getdata(1,"eid={$eid}");
	$value=$dataedit[0];//获取第一条记录
	//包含后台模板文件
	include("tpl/smtp_list.htm");	
	}
	
}elseif ($action=="add") {	
	InitGP(array("smtp_server","smtp_port","smtp_email","smtp_account","smtp_password","reply_address","smtp_auth","smtp_ssl","state","Submitadd")); //初始化变量全局返回
	if(!empty($Submitadd)){
		$password=md5(md5($password));//两次md5加密
		$addarray=array(
			"smtp_server"=>$smtp_server,
			"smtp_port"=>$smtp_port,
			"smtp_email"=>$smtp_email,
			"smtp_account"=>$smtp_account,
			"smtp_password"=>$smtp_password,
			"reply_address"=>$reply_address,
			"smtp_ssl"=>$smtp_ssl,
			"state"=>$state,
			"smtp_auth"=>$smtp_auth
		);
		
		
		$info=$smtp->add($addarray);
		if(GetNum($info)){showmsg("添加成功!","smtp_list.php");//成功
		}else showmsg($info,"-1");//出错！	

	}else {
		include("tpl/smtp_list.htm");	
	}
}elseif ($action=="del" && !empty($eid)){
	//执行删除操作
	$eid=GetNum($eid);
	$info=$smtp->del($eid);
	if($info=="OK")showmsg("删除成功！","smtp_list.php");
	else showmsg($info,"smtp_list.php");
}elseif ($action=="dels"){
	if(empty($delids)){showmsg("没有选择任何对象！",PHP_SELF);exit;}//空选择
	//执行删除多个操作
	$delids=explode('|',$delids);
	foreach ($delids as $id){
		if(GetNum($id)){
			$info=$smtp->del($id);
		}
	}
	if($info=="OK")exit("1");
	
}



?>

