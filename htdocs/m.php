<?php
//用户中心入口文件
include('common.inc.php');
InitGP('name'); //初始化变量全局返回
checklogin();//检查是否登录
//允许的动作
$namerray = array('index','fillorders', 'favorite', 'orderlist', 'tosendorder', 'sendorderlist','guestbooklist', 'rmbaccount', 'pay', 'coupon', 'recordslist', 'refundrecord', 'pm', 'myaddress', 'scorerecords', 'edituserinfo', 'changepassword', 'changeemail','estimates','recommend');

$name = (!empty($name) && in_array($name, $namerray))?$name:'index';

//链接
$theurl = 'm.php?name='.$name;

include_once(ROOT_PATH.'/member/'.$name.'.php'); //调用相应处理文件

//获取帮助文章列表
function helplist($num,$id='',$aids="",$orderby="aid asc"){
	if(is_numeric($id)){
		$wherestr[]="typeid = ".$id;
	}elseif(is_array($id)){
		$ids=getdotstring($id,'int');
		$wherestr[]="typeid in ({$ids})";
	}elseif(is_string($id) && (strexists($id,',') || strexists($id,'|'))){
		if(strexists($id,',')){
			$ids=getdotstring($id,'int');
		}else{
			$ids=getdotstring(explode('|',$ids),'int');
		}
		$wherestr[]="typeid in ({$ids})";
	} else{
		$wherestr[]="";
	}
	if (!empty($aids)) {
		$aids=getdotstring($aids,'int');
		$wherestr[]="aid in ({$ids})";
	}
	$num=GetNum($num);
	$wheresql = implode(' AND ', $wherestr);	//条件汇总
	$articleobj=new TableClass('article','aid');
	$articlearray=$articleobj->getdata($num,$wheresql,$orderby,'aid,typeid,title');
	return $articlearray;
}

?>