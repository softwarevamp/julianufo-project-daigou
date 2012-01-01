<?php
//我的劵
InitGP(array("action","favoriteId","page")); //初始化变量全局返回
$f=new TableClass('favorite','fid');

if(empty($action)){
	$wherestr[]="uname='".$_USERS['uname']."'";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总

	//获取当前页码
	$total=$f->getcount($wheresql); 							  //总信息数
	$pagesize=5;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$f->getdata("$offset,$pagesize",$wheresql); //获取数据
}elseif($action=='add'){
	AjaxHead();
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	include(INC_PATH."/shopsite.class.php");
	$shopsite=ShopClass::init();	
	$preg=$shopsite->getpreg($jsondata->href);//获取站点
	$addarray=array(
		'uid'=>$_USERS['uid'],
		'uname'=>$_USERS['uname'],
		'goodsurl'=>$jsondata->href,
		'goodsname'=>$jsondata->name,
		'goodsprice'=>$jsondata->price,
		'goodsimg'=>$jsondata->picture,
		'goodsseller'=>$jsondata->shopName,
		'sellerurl'=>$jsondata->shopHref,
		'goodssite'=>$preg['shopname'],
		'siteurl'=>$preg['shopurl'],
		'addtime'=>time()
	);
	
	//处理插入数据库
	$info=$f->add($addarray);
	if(GetNum($info)){
		echo json_encode('OK');
		exit;
	}else{
		echo json_encode(lang('Error_handling_Favorites'));
		exit;
	}
}elseif($action=='del'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));//获取json数据
	if($f->del($jsondata->favoriteId,$_USERS['uname'])){
		exit(json_encode('OK'));
	}else{
		exit(json_encode(lang('error')));
	}
}

include template('member_favorite');//包含输出指定模板
?>