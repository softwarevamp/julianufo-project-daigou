<?php
include("common.inc.php");
InitGP(array("action","type","oid","sid","page","minPrice","maxPrice","pages","goodprices","addtime","k","c")); 
include_once(INC_PATH."/order.class.php");
$o=OrderClass::init();
$Table=new OrderClass();
$typeobj=new TableClass('otype','typeid');
if(empty($action)){
	
	
	
$k = FilterSearch(stripslashes($k));//过滤搜索

if(($k!='' || strlen($k)>2))
{
	$wherestr[]="goodsname like '%".$k."%'";
}

$c = GetNum($c);
if ($c) {
	$wherestr[]="typeid='".$c."'";
}

$wherestr[]="state=1";
$wherestr[]="type=1";
if(!empty($minPrice) && !empty($maxPrice)){
	$wherestr[]="goodsprice between {$minPrice} and {$maxPrice}";
}
if(!empty($pages)){
	$pagesize=$pages;
}else{
	$pagesize=9;
}
if(!empty($goodprices)){
    if($goodprices==asc){
    	$orderby="goodsprice asc";
    }elseif($goodprices==desc){
    	$orderby="goodsprice desc";
    }
}
if(!empty($addtime)){
    if($addtime==asc){
    	$orderby="addtime asc";
    }elseif($addtime==desc){
    	$orderby="addtime desc";
    }
}

if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);
$total=$o->getcount($wheresql); 
if ($total>1000) $total=1000;								  //显示最大一千条											  //一页显示信息数
$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
$offset=($page-1)*$pagesize;
$dataarray=$o->getdata("$offset,$pagesize",$wheresql,$orderby);

//统计参与人数和参与人，时间
$wheres[]="type=2";
if(!empty($wheres)) $wheressql = implode(' AND ', $wheres);
$totalnum=$o->getcount($wheressql);
$data=$o->getdata("5",$wheressql,"addtime desc","uname,addtime"); 

$rightarray=$o->getdata(10,"type=1","pinnum desc");	

//读取分类
$typeobj=new TableClass('goodstype','typeid');
$typearray=$typearray2=array();
$typearray=$typeobj->getdata('','','typeid asc');
foreach ($typearray as $val){
	$typearray2[$val['typeid']]=$val;
}
$temparray=array('typeid'=>0,'typename'=>lang('All_Categories'));
$typearray2[0]=$temparray;

include template('pinindex');
}
elseif ($action=='pay'){

	$oid=GetNum($oid);
	$value=$Table->getone($oid);
	include template('pinpay');
	
}elseif ($action=='edit'){
		InitGP(array("oid","pieceNum","pieceRemark")); //初始化变量全局返回
		$oid=GetNum($oid);
		$value=$Table->getone($oid);
		$arrayadd=$value;
		unset($arrayadd['oid']);
		unset($arrayadd['sid']);
		$arrayadd['uid']=$_USERS['uid'];
		$arrayadd['uname']=$_USERS['uname'];
		$arrayadd['goodsnum']=GetNum($pieceNum);
		$arrayadd['type']=2;
		$arrayadd['goodsremark']=Char_cv(pieceRemark);
		$arrayadd['addtime']=time();
		$arrayadd['uptime']=time();
		$arrayadd['state']=1;
		$arrayadd['pinoid']=GetNum($oid);
	
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
			include_once(INC_PATH."/member.class.php");
			$m=new memberclass();
			$note=lang('Buy')."<a href=\'".$value['goodsurl']."\' target=\'_blank\'>《".$value['goodsname']."》</a> ".GetNum($pieceNum).lang('Pieces_order_ID').$info;
			$tempmoney=$value['goodsprice']*GetNum($pieceNum);
			$m->moneyedit($_USERS['uname'],- $tempmoney,1,$note);//扣去账户余额	
			addfield("order","pinnum","oid={$oid}",1);//更改状态操作
			
			showmsg(lang('fight_sucess'),PHP_SELF);//出错！
		}else{
			showmsg(lang('fight_lose'),"-1");//出错！
		}
}


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
?>