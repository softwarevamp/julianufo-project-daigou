<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","payid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("sendorder","sid");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("sid","sn","email","freight","serverfee","customsfee","totalfee","consignee","country","city","zip","tel","address","state","remark","tel","Submit","comment","reply","showcomment")); //初始化变量全局返回
	if(!empty($_POST) and !empty($sid)){
		$sid=GetNum($sid);
		$arrayedit=array(
			"sn"=> Char_cv($sn),
			"email"=> Char_cv($email),
			"freight"=> GetNum($freight),
			"serverfee"=> GetNum($serverfee),
			"customsfee"=> GetNum($customsfee),
			"totalfee"=> GetNum($totalfee),
			"consignee"=> Char_cv($consignee),
			"country"=> Char_cv($country),
			"city"=> Char_cv($city),
			"zip"=> Char_cv($zip),
			"tel"=> Char_cv($tel),
			"address"=> Char_cv($address),
			"remark"=> Char_cv($remark),
			"state"=>GetNum($state),
			"comment"=>Char_cv($comment),
			"reply"=>Char_cv($reply),
			"showcomment"=>GetNum($showcomment),
			"uptime"=>time()
		);
		$info=$Table->edit($sid,$arrayedit);
		if($info=="OK"){
			exit("<script language='javascript'>alert('编辑成功');parent.parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('编辑失败');parent.location.reload();</script>");
		}
	}else{
		$evalue=$Table->getone($sid);
		//print_r($evalue);
		include("tpl/sendorder_edit.htm");
	}

}else{
	showmsg("未知请求","-1");//出错！
}


?>