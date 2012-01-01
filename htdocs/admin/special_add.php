<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","sid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("special","sid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("sid","typeid","title","about","flag","seokeywords","seodescription","listorder","body")); //初始化变量全局返回
	if(!empty($_POST) and !empty($title)){

		$sid=GetNum($sid);
		if(empty($body))showmsg("内容不能为空!",PHP_SELF);//出错！
		//上传图片处理
		require_once (INC_PATH.'/upload.class.php');
		$f = new Upload('../attachment/special',array('gif','jpg','jpge','png'),500000);//路径 允许扩展名 文件尺寸
		$f->setThumb(0);//设置不生成缩微图
		$f->run('fileimg',1);
		$info=$f->getInfo();
		$imgdata=$info[0]['fullsavename'];//获取第一个上传图片反馈
		
		$arrayadd=array(
			"title"=> Char_cv($title),
			"seokeywords"=> Char_cv($seokeywords),
			"seodescription"=> Char_cv($seodescription),
			"listorder"=> GetNum($listorder),
			"flag"=> Char_cv($flag),
			"about"=> Char_cv($about),
			"pic"=> $imgdata ,
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
		include("tpl/special_add.htm");
	}
}elseif($action=="edit" && !empty($sid)){
	InitGP(array("sid","typeid","title","about","flag",'imgold',"seokeywords","seodescription","listorder","body")); //初始化变量全局返回
	if(!empty($_POST) and !empty($title) and !empty($sid)){

		$sid=GetNum($sid);
		if(empty($sid))showmsg("缺少ID参数!",PHP_SELF);//出错！
		if(empty($body))showmsg("内容不能为空!",PHP_SELF);//出错！

		require_once (INC_PATH.'/upload.class.php');
		$f = new Upload('../attachment/special',array('gif','jpg','jpge','png'),500000);//路径 允许扩展名 文件尺寸
		$f->setThumb(0);//设置不生成缩微图
		$f->run('fileimg',1);
		$info=$f->getInfo();
		$imgdata=$info[0]['fullsavename'];//获取第一个上传图片反馈
		if(isset($info[0]['error']))$imgdata=$imgold;
		
		$arrayadd=array(
			"title"=> Char_cv($title),
			"seokeywords"=> Char_cv($seokeywords),
			"seodescription"=> Char_cv($seodescription),
			"listorder"=> GetNum($listorder),
			"flag"=> Char_cv($flag),
			"about"=> Char_cv($about),
			"pic"=> $imgdata ,
			"body"=>HtmlReplace($body,-1)
		);
		$info=$Table->edit($sid,$arrayadd);
		if($info=="OK"){
				showmsg("更新成功!","special_list.php");//出错！
		}else{
			showmsg("更新失败!","special_list.php");//出错！
		}
	}else{
		$evalue=$Table->getone($sid);
		//print_r($evalue);
		include("tpl/special_add.htm");
	}

}else{
	showmsg("未知请求","-1");//出错！
}

?>