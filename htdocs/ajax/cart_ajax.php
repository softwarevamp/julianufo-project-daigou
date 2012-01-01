<?php
//购物车相关ajax数据处理
include("../common.inc.php");
InitGP(array("action","remark","gid","num","gids","cityid")); //初始化变量全局返回
include(INC_PATH."/cart.class.php");
$Cart=CartClass::init();
AjaxHead();
if($action=='editremark' and !empty($gid) and !empty($remark)){
	$gid=GetNum($gid);
	$editarray=array(
		'goodsremark'=>Char_cv($remark)
	);
	$info=$Cart->edit($gid,$editarray);
	exit;

}else if($action=='updatenum' and !empty($gid) and !empty($num)){
	$gid=GetNum($gid);
	$num=(int)GetNum($num);
	if($num<=0)$num=1;
	$editarray=array(
		'goodsnum'=>$num
	);
	$info=$Cart->edit($gid,$editarray);
	exit;
}else if($action=='accountAll' and !empty($gids)){
	//返回商品总数和总价
	$countmoney=$Cart->countmoney('',$gids);
	echo json_encode($countmoney);
}else if($action=='addtofavorites' and !empty($gids)){
	if(empty($_USERS))exit(json_encode(lang('login_operate')));
	if($Cart->carttofavorite($gids)=="OK"){
		echo json_encode(lang('Favorites_success'));
	}
}else if($action=='del' and !empty($gids)){
	if($Cart->clear($gids)){
		echo json_encode(lang('delete_success'));
	}else{
		echo json_encode(lang('delete_failed'));
	}
}
?>