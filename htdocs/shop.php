<?php
include("common.inc.php");
InitGP(array("action","tid","gid","ps","page")); //初始化变量全局返回
$goodsobj=new TableClass('shop_goods','gid');
$typeobj=new TableClass('shop_gtype','typeid');
//读取分类信息
$typearray=$typeobj->getdata('','','typeid asc');
include_once(INC_PATH.'/tree.class.php');
$tree=new Tree($typearray,'typeid','node');
//分类处理
$categoryarr = $tree->getChilds(0);
$space='|----';
foreach ($categoryarr as $key => $catid) {
	$cat = $tree->getValue($catid);
	$cat['pre'] = $tree->getLayer($catid, $space);
	$listarr[$cat['typeid']] = $cat;
}
//读取分类结束
if ($action=='list'){
	$tid=GetNum($tid);
	$gtype=$tree->getValue($tid);
	
	if ($gtype['node']==0) {
		$position="<span>&gt;</span><a href='shop.php?action=list&tid=".$gtype['typeid']."'>".$gtype['typename']."</a>";
		$typename=$gtype['typename'];
	}else{
		$cgtype=$tree->getValue($gtype['node']);
		$typename=$cgtype['typename'];
		$position="<span>&gt;</span><a href='shop.php?action=list&tid=".$cgtype['typeid']."'>".$cgtype['typename']."</a>";
		$position.="<span>&gt;</span><a href='shop.php?action=list&tid=".$gtype['typeid']."'>".$gtype['typename']."</a>";
	}
	
	$tids=$tree->getChilds($tid);
	$tids[]=$tid;
	$wherestr[]="gtypeid in(".getdotstring($tids,'int').")";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	//获取当前页码
	$total=$goodsobj->getcount($wheresql); 						  //总信息数
	if (GetNum($ps)) {
		$pagesize=GetNum($ps);
	}else {$pagesize=9;}											  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$goodsobj->getdata("$offset,$pagesize",$wheresql,'listorder asc,gid desc','gid,gtypeid,goodsname,goodsprice,goodsimg,rindex,views,buynum,listorder,flag,addtime'); //获取数据	
	
	$rightarray=$goodsobj->getdata(10,"flag='c'",'listorder asc,gid desc','gid,gtypeid,goodsname,goodsprice,goodsimg,rindex,views,buynum,listorder,flag,addtime');
	$leftarray=$goodsobj->getdata(10,"flag='c'",'buynum desc,gid desc','gid,gtypeid,goodsname,goodsprice,goodsimg,rindex,views,buynum,listorder,flag,addtime');
	include template('shop_list');//包含输出指定模板
	
}elseif ($action=='view'){
	$gid=GetNum($gid);
	$value=$goodsobj->getone($gid);
	$gtype=$typeobj->getone($value['gtypeid']);
	if ($gtype['node']==0) {
		$position="<span>&gt;</span><a href='shop.php?action=list&tid=".$gtype['typeid']."'>".$gtype['typename']."</a>";
	}else{
		$cgtype=$typeobj->getone($gtype['node']);
		$position="<span>&gt;</span><a href='shop.php?action=list&tid=".$cgtype['typeid']."'>".$cgtype['typename']."</a>";
		$position.="<span>&gt;</span><a href='shop.php?action=list&tid=".$gtype['typeid']."'>".$gtype['typename']."</a>";
	}
	
	$leftarray=$goodsobj->getdata(10,"flag='c'",'buynum desc,gid desc','gid,gtypeid,goodsname,goodsprice,goodsimg,rindex,views,buynum,listorder,flag,addtime');
	addfield($goodsobj->table,'views',"gid=".$gid,1);//增加浏览次数
	include template('shop_view');//包含输出指定模板
}else {
	InitGP(array("c","k")); //初始化变量全局返回
	if (!empty($c)||!empty($k)) {
		if (!empty($c)) {
			$tids=$tree->getChilds($c);
			$tids[]=$c;
			$wherestr[]="gtypeid in(".getdotstring($tids,'int').")";			
		}
		if (!empty($k) && strlen($k)>=2) {
			$keyword = FilterSearch(stripslashes($k));//过滤搜索
			$wherestr[]="goodsname like '%".$keyword."%'";
		}
	}else {
		$wherestr[]="flag='c'";
	}
	
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	//获取当前页码
	$total=$goodsobj->getcount($wheresql); 						  //总信息数
	$pagesize=9;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;
	
	$dataarray=$goodsobj->getdata("$offset,$pagesize",$wheresql,'buynum desc,gid desc','gid,gtypeid,goodsname,goodsprice,goodsimg,rindex,views,buynum,listorder,flag,addtime');
	$rightarray=$goodsobj->getdata(10,"flag='c'",'listorder asc,gid desc','gid,gtypeid,goodsname,goodsprice,goodsimg,rindex,views,buynum,listorder,flag,addtime');
	$leftarray=$goodsobj->getdata(10,"flag='c'",'buynum desc,gid desc','gid,gtypeid,goodsname,goodsprice,goodsimg,rindex,views,buynum,listorder,flag,addtime');
	
	include template('shop');//包含输出指定模板
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