<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","bid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("bankaccount","bid");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("bid","currency","account","accountname","bankname","remark")); //初始化变量全局返回
	if(!empty($_POST) and !empty($account)){

		if(empty($currency))showmsg("币种不能为空!",PHP_SELF);//出错！
		if(empty($accountname))showmsg("账户名不能为空!",PHP_SELF);//出错！
		$arrayadd=array(
			"currency"=> Char_cv($currency),
			"account"=> Char_cv($account),
			"accountname"=> Char_cv($accountname),
			"bankname"=> Char_cv($bankname),
			"remark"=> Char_cv($remark)
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
				showmsg("发布成功!",PHP_SELF);//出错！
		}else{
			showmsg("发布失败!","-1");//出错！
		}
	}else{
		//print_r($evalue);
		include("tpl/bankaccount_add.htm");
	}
}elseif($action=="edit" && !empty($bid)){
	InitGP(array("bid","currency","account","accountname","bankname","remark")); //初始化变量全局返回
	if(!empty($_POST) and !empty($account) and !empty($bid)){
		$bid=GetNum($bid);
		if(empty($bid))showmsg("缺少ID参数!",PHP_SELF);//出错！
		if(empty($currency))showmsg("币种不能为空!",PHP_SELF);//出错！
		if(empty($accountname))showmsg("账户名不能为空!",PHP_SELF);//出错！
		$arrayadd=array(
			"currency"=> Char_cv($currency),
			"account"=> Char_cv($account),
			"accountname"=> Char_cv($accountname),
			"bankname"=> Char_cv($bankname),
			"remark"=> Char_cv($remark)
		);
		$info=$Table->edit($bid,$arrayadd);
		if($info=="OK"){
			exit("<script language='javascript'>alert('编辑成功');parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('编辑失败');history.go(-1);</script>");
		}
	}else{
		$evalue=$Table->getone($bid);
		//print_r($evalue);
		include("tpl/bankaccount_add.htm");
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
?>