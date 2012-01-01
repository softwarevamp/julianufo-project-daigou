<?php
include("common.inc.php");
InitGP(array("action","type","keyword","aid","page")); //初始化变量全局返回
include_once(INC_PATH."/order.class.php");
$orderobj=OrderClass::init();
$keyword = FilterSearch(stripslashes($keyword));//过滤搜索
if(($keyword!='' || strlen($keyword)>2))
{
	$wherestr[]="goodsname like '%".$keyword."%'";
}
$type = GetNum($type);
if ($type) {
	$wherestr[]="typeid='".$type."'";
}
//$wherestr[]="uname='".$_USERS['uname']."'";
if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总

//获取当前页码
$total=$orderobj->getcount($wheresql); 						  //总信息数
if ($total>1000) $total=1000;								  //显示最大一千条
$pagesize=10;												  //一页显示信息数
$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
$offset=($page-1)*$pagesize;   								  //偏移量
$dataarray=$orderobj->getdata("$offset,$pagesize",$wheresql); //获取数据
//读取编辑推荐
$goodsobj=new TableClass('goods','gid');
$rightarray=$goodsobj->getdata(5,"flag='c'",'listorder asc,gid desc','gid,gtypeid,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,addtime');
//读取4条折扣信息
$discountobj=new TableClass('discount','did');
$discountarray=$discountobj->getdata(4,"flag='c'",'listorder asc,did desc','did,title,flag,about,pic,discounttime,listorder,addtime');

//读取分类
$typeobj=new TableClass('goodstype','typeid');
$typearray=$typearray2=array();
$typearray=$typeobj->getdata('','','typeid asc');
foreach ($typearray as $val){
	$typearray2[$val['typeid']]=$val;
}
$temparray=array('typeid'=>0,'typename'=>lang('All_Categories'));
$typearray2[0]=$temparray;

//utf-8过滤用于搜索的字符串
function FilterSearch($keyword)
{
	$keyword = ereg_replace("[\"\r\n\t\$\\><']",'',$keyword);
	if($keyword != stripslashes($keyword))
	{
		return '';
	}
	else
	{
		return $keyword;
	}
	return $restr;
}
include template('see');//包含输出指定模板
?>