<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","aid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("area","aid");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("aid","name_cn","name_en","serverfeepct","serverfee","listorder")); //初始化变量全局返回
	if(!empty($_POST) and !empty($name_cn)){

		if(empty($name_cn))showmsg("中文名不能为空!","-1");//出错！
		if(empty($name_en))showmsg("英文名不能为空!","-1");//出错！
		$arrayadd=array(
			"name_cn"=> Char_cv($name_cn),
			"name_en"=> Char_cv($name_en),
			"serverfeepct"=> GetNum($serverfeepct),
			"serverfee"=> GetNum($serverfee),
			"listorder"=> GetNum($listorder)
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
			exit("<script language='javascript'>alert('发布成功');parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('发布失败');history.go(-1);</script>");
		}
	}else{
		//print_r($evalue);
		include("tpl/area_add.htm");
	}
}elseif($action=="edit" && !empty($aid)){
	InitGP(array("aid","name_cn","name_en","serverfeepct","serverfee","listorder")); //初始化变量全局返回
	if(!empty($_POST) and !empty($name_cn) and !empty($aid)){
		$aid=GetNum($aid);
		if(empty($aid))showmsg("缺少ID参数!","-1");//出错！
		if(empty($name_cn))showmsg("中文名不能为空!","-1");//出错！
		if(empty($name_en))showmsg("英文名不能为空!","-1");//出错！
		$arrayadd=array(
			"name_cn"=> Char_cv($name_cn),
			"name_en"=> Char_cv($name_en),
			"serverfeepct"=> GetNum($serverfeepct),
			"serverfee"=> GetNum($serverfee),
			"listorder"=> GetNum($listorder)
		);
		$info=$Table->edit($aid,$arrayadd);
		if($info=="OK"){
			exit("<script language='javascript'>alert('编辑成功');parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('编辑失败');history.go(-1);</script>");
		}
	}else{
		$evalue=$Table->getone($aid);
		//print_r($evalue);
		include("tpl/area_add.htm");
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