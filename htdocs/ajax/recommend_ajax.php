<?php
//弹出一键填单相关ajax数据处理
include("../common.inc.php");
InitGP(array("action","url","refuname","referer","aid","cityid")); //初始化变量全局返回
$goodsobj=new TableClass('goods','gid');
AjaxHead();
if($action=='addbuynum'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$gid=GetNum($jsondata->pid);
	$wheresqlarr="gid=".$gid;
	addfield($goodsobj->table,'buynum',$wheresqlarr,1);
	echo json_encode('OK');
	exit;

}else if($action=='add'){
	//抓取商品加入购物车ajax
	$strjson=str_replace("'",'"',stripslashes($_POST['adddata']));
	$pdata=json_decode($strjson);
	
	$p_name = Char_cv($pdata->name);
	$p_price = GetNum($pdata->price);
	$p_fee = GetNum($pdata->freight);
	$p_num = GetNum($pdata->buyNum);
	$p_note = Char_cv($pdata->remark);
	$p_url = Char_cv($pdata->href);
	$p_size = Char_cv($pdata->chicun);
	$p_color = Char_cv($pdata->yanse);
	$p_saler = Char_cv($pdata->shopName);
	$s_url = Char_cv($pdata->shopHref);
	$picture = Char_cv($pdata->picture);
	$type = GetNum($pdata->type);
	if($type==0)$type=1;
	$expressno = Char_cv($pdata->expressno);
	if(strlen($p_name)<=0 || strlen($p_price)<=0 || $p_fee<0 || strlen($p_num)<=0||strlen($p_url)<=0){
		echo 132;
		return ;
	}
	$preg=$shopsite->getpreg($p_url);//获取站点
	
	//放入购物车处理
	$addarray=array(
		'goodsurl'=>$p_url,
		'goodsname'=>$p_name,
		'goodsprice'=>$p_price,
		'sendprice'=>$p_fee,
		'goodsnum'=>$p_num,
		'goodsimg'=>$picture,
		'goodssize'=>$p_size,
		'goodscolor'=>$p_color,
		'goodsseller'=>$p_saler,
		'sellerurl'=>$s_url,
		'goodssite'=>$preg['shopname'],
		'siteurl'=>$preg['shopurl'],
		'expressno'=>$expressno,
		'type'=>$type,
		'goodsremark'=>$p_note,
		'addtime'=>time()
	);
	include(INC_PATH."/cart.class.php");
	$Cart=CartClass::init();	
	$info=$Cart->add($addarray);
	if(GetNum($info)){
		echo json_encode('OK');
	}else echo $info;
	exit;
}else if($action=='state'){
	include(INC_PATH."/cart.class.php");
	$Cart=CartClass::init();
	$countnum=$Cart->getnum();
	$countmoney=$Cart->countmoney();
	//返回商品总数和总价
	echo "tj#".$countnum."#".$countmoney['totalmoney'];
}
?>