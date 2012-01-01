<?php
//我的劵
InitGP(array("action","type","bid","page")); //初始化变量全局返回
include(INC_PATH."/groupbond.class.php");
$gb=new GroupBondClass();
switch ($type){
case "available":
	$wherestr[]="state in(1,0)";
	break;
case "used":
	$state=2;
	$wherestr[]="state='{$state}'";
	break;	
case "expired":
	$wherestr[]="endtime <>0 and endtime<'{$timestamp}'";
	break;	
case "all":
	break;
default:
	$state=0;
}

//执行发送短信操作
if ($type=="sendsms" && GetNum($bid)) {
	
	$value=$gb->getone($bid);
	if ($value['uname']!=$_USERS['uname']) {
		showmessage("该劵不归您所有！","-1",false);
	}
	if (empty($_USERS['tel'])) {
		showmessage("您尚未填写手机号，请完善手机号信息！","m.php?action=settings",false);
	}
	include_once(INC_PATH."/sendsms.class.php");
	$sms=new SendsmsClass();
	
	$msg="您好，{$value['uname']} 感谢您团购{$value['gtitle']}，您的{$cfg_groupbond_name}序列号：{$value['sn']} 密码：{$value['password']} 消费时请出示此短信！";
	
	$info=$sms->send($_USERS['tel'],$msg);
	if($info){
		showmessage("发送成功！","-1",true);
	}else {
		showmessage("发送失败","-1",false);
	}
}

if(!empty($_USERS['uname'])){
	$uname=$_USERS['uname'];
	$wherestr[]="uname='{$uname}'";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	//获取当前页码
	$total=$gb->getcount($wheresql); 							  //总信息数
	$pagesize=15;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$value=$gb->getdata("$offset,$pagesize",$wheresql,"","ALL"); //获取团购数据
}

/**
 * 输出测试部分开始

//$value="ssssssss";
print_r($value);
 */
/**
 * 输出测试部分结束
 */




include template('member_bond');//包含输出指定模板
?>