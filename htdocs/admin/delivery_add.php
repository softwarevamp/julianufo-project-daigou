<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","did","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("delivery","did");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("did","areaid","serverfee","deliveryname","queryurl","first_weight","continue_weight","first_fee","continue_fee","fuel_fee","customs_fee"));
	if(!empty($_POST) and !empty($deliveryname)){
	
		if(empty($areaid))showmsg("地区必须选择!","-1");//出错！
		if(empty($deliveryname))showmsg("快递名不能为空!","-1");//出错！
		$areaname=DB::result_first("select name_cn from ".DB::table('area')." where aid = '{$areaid}'");//查询uid
		$arrayadd=array(
			"areaid"=> GetNum($areaid),
			"areaname"=> Char_cv($areaname),
			"serverfee"=> GetNum($serverfee),
			"deliveryname"=> Char_cv($deliveryname),
			"queryurl"=> $queryurl,
			"first_weight"=> GetNum($first_weight),
			"continue_weight"=> GetNum($continue_weight),
			"first_fee"=> GetNum($first_fee),
			"continue_fee"=> GetNum($continue_fee),
			"fuel_fee"=> GetNum($fuel_fee),
			"customs_fee"=> GetNum($customs_fee),
			"senddate"=>time()
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
			exit("<script language='javascript'>alert('发布成功');parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('发布失败');history.go(-1);</script>");
		}
	}else{
		//print_r($evalue);
		include("tpl/delivery_add.htm");
	}
}elseif($action=="edit" && !empty($did)){
	InitGP(array("did","areaid","serverfee","deliveryname","queryurl","first_weight","continue_weight","first_fee","continue_fee","fuel_fee","customs_fee"));
	if(!empty($_POST) and !empty($deliveryname) and !empty($did)){
		$did=GetNum($did);
		if(empty($did))showmsg("缺少ID参数!","-1");//出错！
		if(empty($areaid))showmsg("地区必须选择!","-1");//出错！
		if(empty($deliveryname))showmsg("快递名不能为空!","-1");//出错！
		$areaname=DB::result_first("select name_cn from ".DB::table('area')." where aid = '{$areaid}'");//查询uid
		
		$arrayadd=array(
			"areaid"=> GetNum($areaid),
			"areaname"=> Char_cv($areaname),
			"serverfee"=> GetNum($serverfee),
			"deliveryname"=> Char_cv($deliveryname),
			"queryurl"=> $queryurl,
			"first_weight"=> GetNum($first_weight),
			"continue_weight"=> GetNum($continue_weight),
			"first_fee"=> GetNum($first_fee),
			"continue_fee"=> GetNum($continue_fee),
			"fuel_fee"=> GetNum($fuel_fee),
			"customs_fee"=> GetNum($customs_fee),
			"senddate"=>time()
		);
		$info=$Table->edit($did,$arrayadd);
		if($info=="OK"){
			exit("<script language='javascript'>alert('编辑成功');parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('编辑失败');history.go(-1);</script>");
		}
	}else{
		$evalue=$Table->getone($did);
		//print_r($evalue);
		include("tpl/delivery_add.htm");
	}
	
}else{
	showmsg("未知请求","-1");//出错！
}

//获取选择文章分类下拉框
function getareaselect($var="",$value="",$other=""){
	$Table=new TableClass("area","aid");
	$arraydata=$Table->getdata('','','aid asc');
	foreach ($arraydata as $val){
		$arrayoption[$val['aid']]=$val['name_cn'];
	}
	return getselectstr($var, $arrayoption, $value, $other);
}
?>