<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","adminid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("admin","adminid");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
$mange=new TableClass("adminmange","mid");
$menuarray=$mange->getdata('','','listorder asc,mid asc');
if(empty($action)){
	InitGP(array("adminid","adminname","adminpwd","mid")); //初始化变量全局返回
	if(!empty($_POST) and !empty($adminname)){
		if(empty($adminname))showmsg("管理员名不能为空!","-1");//出错！
		if(strlen($adminpwd)!=32)$adminpwd=md5($adminpwd);//用户密码加密
		if(is_array($mid))$adminmid=getdotstring($mid,'int');//格式化成id,id形式
		
		foreach($menuarray as $value){
			if(in_array($value['mid'],$mid)){
				$temparray[]=$value['mcode'];
			}
		}
		$adminpurview=implode_field_value($temparray);//格式化成id,id形式
		
		$arrayadd=array(
			"adminname"=> Char_cv($adminname),
			"adminpwd"=> Char_cv($adminpwd),
			"adminmid"=> $adminmid,
			"adminpurview"=> $adminpurview
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
			exit("<script language='javascript'>alert('发布成功');parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('发布失败');history.go(-1);</script>");
		}
	}else{
		//print_r($evalue);
		include("tpl/admin_add.htm");
	}
}elseif($action=="edit" && !empty($adminid)){
	InitGP(array("adminid","adminname","adminpwd","mid")); //初始化变量全局返回
	if(!empty($_POST) and !empty($adminname) and !empty($adminid)){
		$adminid=GetNum($adminid);
		if(empty($adminid))showmsg("缺少ID参数!","-1");//出错！
		if(empty($adminname))showmsg("管理员名不能为空!","-1");//出错！
		if(strlen($adminpwd)!=32)$adminpwd=md5($adminpwd);//用户密码加密
		
		if(is_array($mid))$adminmid=getdotstring($mid,'int');//格式化成id,id形式
		
		foreach($menuarray as $value){
			if(in_array($value['mid'],$mid)){
				$temparray[]=$value['mcode'];
			}
		}
		$adminpurview=implode_field_value($temparray);//格式化成id,id形式
		
		$arrayadd=array(
			"adminname"=> Char_cv($adminname),
			"adminpwd"=> Char_cv($adminpwd),
			"adminmid"=> $adminmid,
			"adminpurview"=> $adminpurview
		);
		$info=$Table->edit($adminid,$arrayadd);
		if($info=="OK"){
			exit("<script language='javascript'>alert('编辑成功');parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('编辑失败');history.go(-1);</script>");
		}
	}else{
		$evalue=$Table->getone($adminid);
		//print_r($evalue);
		include("tpl/admin_add.htm");
	}


}else{
	showmsg("未知请求","-1");//出错！
}

//获取选择文章分类下拉框
function getatypeselect($var="",$value="",$other=""){
	$Table=new TableClass("atype","typeid");
	$arraydata=$Table->getdata('','','typeid asc');
	foreach ($arraydata as $val){
		$arrayoption[$val['typeid']]=$val['typename'];
	}
	return getselectstr($var, $arrayoption, $value, $other);
}
function implode_field_value($array, $glue = ',') {
	$sql = $comma = '';
	foreach ($array as $k => $v) {
		$sql .= $comma."$v";
		$comma = $glue;
	}
	return $sql;
}
?>