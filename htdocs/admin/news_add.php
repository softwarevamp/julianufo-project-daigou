<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","nid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("news","nid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("nid","title","seokeywords","seodescription","listorder","body")); //初始化变量全局返回
	if(!empty($_POST) and !empty($title)){

		$nid=GetNum($nid);
		if(empty($body))showmsg("内容不能为空!",PHP_SELF);//出错！
		$arrayadd=array(
			"title"=> Char_cv($title),
			"seokeywords"=> Char_cv($seokeywords),
			"seodescription"=> Char_cv($seodescription),
			"listorder"=> GetNum($listorder),
			"body"=>HtmlReplace($body,-1),
			"addtime"=>time()
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
				showmsg("发布成功!",PHP_SELF);//出错！
		}else{
			showmsg("发布失败!","-1");//出错！
		}
	}else{
		//print_r($evalue);
		include("tpl/news_add.htm");
	}
}elseif($action=="edit" && !empty($nid)){
	InitGP(array("nid","typeid","title","seokeywords","seodescription","listorder","body")); //初始化变量全局返回
	if(!empty($_POST) and !empty($title) and !empty($nid)){

		$nid=GetNum($nid);
		if(empty($nid))showmsg("缺少ID参数!",PHP_SELF);//出错！
		if(empty($body))showmsg("内容不能为空!",PHP_SELF);//出错！
		$arrayadd=array(
			"title"=> Char_cv($title),
			"seokeywords"=> Char_cv($seokeywords),
			"seodescription"=> Char_cv($seodescription),
			"listorder"=> GetNum($listorder),
			"body"=>HtmlReplace($body,-1),
			"addtime"=>time()
		);
		$info=$Table->edit($nid,$arrayadd);
		if($info=="OK"){
				showmsg("更新成功!","news_list.php");//出错！
		}else{
			showmsg("更新失败!","news_list.php");//出错！
		}
	}else{
		$evalue=$Table->getone($nid);
		//print_r($evalue);
		include("tpl/news_add.htm");
	}


}else{
	showmsg("未知请求","-1");//出错！
}

?>