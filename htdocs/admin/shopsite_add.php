<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","sid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("shopsite","sid");
include_once(INC_PATH.'/shopsite.class.php');
$ShopSite=new ShopClass();
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("sid","shopname","shopurl","shopcode","charset","preg_goodsname","preg_goodsname2","preg_goodsname3","preg_goodsprice","preg_goodsprice2","preg_goodsprice3","preg_sendprice","preg_sendprice2","preg_sendprice3","preg_goodsimg","preg_goodsimg2","preg_goodsimg3","preg_goodsseller","preg_goodsseller2","preg_goodsseller3","preg_sellerurl","preg_sellerurl2","preg_sellerurl3"));
	if(!empty($_POST) and !empty($shopname) and !empty($shopcode)){
	
		if(empty($charset))showmsg("编码必须设置!","-1");//出错！
		$arrayadd=array(
			"shopname"=> Char_cv($shopname),
			"shopurl"=> $shopurl,
			"shopcode"=> $shopcode,
			"charset"=> $charset,
			"preg_goodsname"=> $preg_goodsname,
			"preg_goodsname2"=> $preg_goodsname2,
			"preg_goodsname3"=> $preg_goodsname3,
			"preg_goodsprice"=> $preg_goodsprice,
			"preg_goodsprice2"=> $preg_goodsprice2,
			"preg_goodsprice3"=> $preg_goodsprice3,
			"preg_sendprice"=> $preg_sendprice,
			"preg_sendprice2"=> $preg_sendprice2,
			"preg_sendprice3"=> $preg_sendprice3,
			"preg_goodsimg"=> $preg_goodsimg,
			"preg_goodsimg2"=> $preg_goodsimg2,
			"preg_goodsimg3"=> $preg_goodsimg3,
			"preg_goodsseller"=> $preg_goodsseller,
			"preg_goodsseller2"=> $preg_goodsseller2,
			"preg_goodsseller3"=> $preg_goodsseller3,
			"preg_sellerurl"=> $preg_sellerurl,
			"preg_sellerurl2"=> $preg_sellerurl2,
			"preg_sellerurl3"=> $preg_sellerurl3
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
			$ShopSite->cachedata();
			exit("<script language='javascript'>alert('发布成功');parent.$.fn.colorbox.close();parent.location.reload();</script>");
		}else{
			exit("<script language='javascript'>alert('发布失败');history.go(-1);</script>");
		}
	}else{
		//print_r($evalue);
		include("tpl/shopsite_add.htm");
	}
}elseif($action=="edit" && !empty($sid)){
	InitGP(array("sid","shopname","shopurl","shopcode","charset","preg_goodsname","preg_goodsname2","preg_goodsname3","preg_goodsprice","preg_goodsprice2","preg_goodsprice3","preg_sendprice","preg_sendprice2","preg_sendprice3","preg_goodsimg","preg_goodsimg2","preg_goodsimg3","preg_goodsseller","preg_goodsseller2","preg_goodsseller3","preg_sellerurl","preg_sellerurl2","preg_sellerurl3"));
	if(!empty($_POST) and !empty($shopname) and !empty($shopcode)  and !empty($sid)){
		$sid=GetNum($sid);
		if(empty($sid))showmsg("缺少ID参数!","-1");//出错！
		if(empty($charset))showmsg("编码必须设置!","-1");//出错！
		
		$arrayadd=array(
			"shopname"=> Char_cv($shopname),
			"shopurl"=> $shopurl,
			"shopcode"=> $shopcode,
			"charset"=> $charset,
			"preg_goodsname"=> $preg_goodsname,
			"preg_goodsname2"=> $preg_goodsname2,
			"preg_goodsname3"=> $preg_goodsname3,
			"preg_goodsprice"=> $preg_goodsprice,
			"preg_goodsprice2"=> $preg_goodsprice2,
			"preg_goodsprice3"=> $preg_goodsprice3,
			"preg_sendprice"=> $preg_sendprice,
			"preg_sendprice2"=> $preg_sendprice2,
			"preg_sendprice3"=> $preg_sendprice3,
			"preg_goodsimg"=> $preg_goodsimg,
			"preg_goodsimg2"=> $preg_goodsimg2,
			"preg_goodsimg3"=> $preg_goodsimg3,
			"preg_goodsseller"=> $preg_goodsseller,
			"preg_goodsseller2"=> $preg_goodsseller2,
			"preg_goodsseller3"=> $preg_goodsseller3,
			"preg_sellerurl"=> $preg_sellerurl,
			"preg_sellerurl2"=> $preg_sellerurl2,
			"preg_sellerurl3"=> $preg_sellerurl3
		);
		$info=$Table->edit($sid,$arrayadd);
		if($info=="OK"){
			$ShopSite->cachedata();
			exit("<script language='javascript'>alert('编辑成功');parent.$.fn.colorbox.close();parent.location.reload();</script>");
		}else{
			exit("<script language='javascript'>alert('编辑失败');history.go(-1);</script>");
		}
	}else{
		$evalue=$Table->getone($sid);
		//print_r($evalue);
		include("tpl/shopsite_add.htm");
	}
	
}else{
	showmsg("未知请求","-1");//出错！
}
?>