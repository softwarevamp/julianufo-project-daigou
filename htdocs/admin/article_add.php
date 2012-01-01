<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","aid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("article","aid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("aid","typeid","title","seokeywords","seodescription","listorder","body")); //初始化变量全局返回
	if(!empty($_POST) and !empty($title)){

		$aid=GetNum($aid);
		if(empty($body))showmsg("内容不能为空!",PHP_SELF);//出错！
		if(empty($typeid))showmsg("必须选择分类!",PHP_SELF);//出错！
		$arrayadd=array(
			"title"=> Char_cv($title),
			"seokeywords"=> Char_cv($seokeywords),
			"seodescription"=> Char_cv($seodescription),
			"listorder"=> GetNum($listorder),
			"typeid"=> GetNum($typeid),
			"body"=>HtmlReplace($body,-1)
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
				showmsg("发布成功!",PHP_SELF);//出错！
		}else{
			showmsg("发布失败!","-1");//出错！
		}
	}else{
		//print_r($evalue);
		include("tpl/article_add.htm");
	}
}elseif($action=="edit" && !empty($aid)){
	InitGP(array("aid","typeid","title","seokeywords","seodescription","listorder","body")); //初始化变量全局返回
	if(!empty($_POST) and !empty($title) and !empty($aid)){

		$aid=GetNum($aid);
		if(empty($aid))showmsg("缺少ID参数!",PHP_SELF);//出错！
		if(empty($body))showmsg("内容不能为空!",PHP_SELF);//出错！
		if(empty($typeid))showmsg("必须选择分类!",PHP_SELF);//出错！
		$arrayadd=array(
			"title"=> Char_cv($title),
			"seokeywords"=> Char_cv($seokeywords),
			"seodescription"=> Char_cv($seodescription),
			"listorder"=> GetNum($listorder),
			"typeid"=> GetNum($typeid),
			"body"=>HtmlReplace($body,-1)
		);
		$info=$Table->edit($aid,$arrayadd);
		if($info=="OK"){
				showmsg("更新成功!","article_list.php");//出错！
		}else{
			showmsg("更新失败!","article_list.php");//出错！
		}
	}else{
		$evalue=$Table->getone($aid);
		//print_r($evalue);
		include("tpl/article_add.htm");
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