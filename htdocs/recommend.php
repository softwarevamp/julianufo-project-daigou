<?php
include("common.inc.php");
InitGP(array("action","tid","gid","page")); //初始化变量全局返回
$goodsobj=new TableClass('goods','gid');
$typeobj=new TableClass('gtype','typeid');
if ($action=='list'){
	$tid=GetNum($tid);
	$gtype=$typeobj->getone($tid);
	if ($gtype['node']==0) {
		$childgtype=$typeobj->getdata('',"node=".$gtype['typeid']);
		foreach ($childgtype as $child){
			$tids[]=$child['typeid'];
		}
		$position="<span>&gt;</span><a href='recommend.php?action=list&tid=".$gtype['typeid']."'>".$gtype['typename']."</a>";
		$typename=$gtype['typename'];
	}else{
		$cgtype=$typeobj->getone($gtype['node']);
		$typename=$cgtype['typename'];
		$position="<span>&gt;</span><a href='recommend.php?action=list&tid=".$cgtype['typeid']."'>".$cgtype['typename']."</a>";
		$position.="<span>&gt;</span><a href='recommend.php?action=list&tid=".$gtype['typeid']."'>".$gtype['typename']."</a>";
	}
	$tids[]=$tid;
	$wherestr[]="gtypeid in(".getdotstring($tids,'int').")";
	$wherestr[]="Audit=1";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	//获取当前页码
	$total=$goodsobj->getcount($wheresql); 						  //总信息数
	$pagesize=12;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$goodsobj->getdata("$offset,$pagesize",$wheresql,'listorder asc,gid desc','gid,gtypeid,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,addtime'); //获取数据	
	//print_r($dataarray);
	include template('recommend_list');//包含输出指定模板
}elseif ($action=='view'){
	$gid=GetNum($gid);
	$value=$goodsobj->getone($gid);
	$gtype=$typeobj->getone($value['gtypeid']);
	if ($gtype['node']==0) {
		$position="<span>&gt;</span><a href='recommend.php?action=list&tid=".$gtype['typeid']."'>".$gtype['typename']."</a>";
	}else{
		$cgtype=$typeobj->getone($gtype['node']);
		$position="<span>&gt;</span><a href='recommend.php?action=list&tid=".$cgtype['typeid']."'>".$cgtype['typename']."</a>";
		$position.="<span>&gt;</span><a href='recommend.php?action=list&tid=".$gtype['typeid']."'>".$gtype['typename']."</a>";
	}
	
	$leftarray=$goodsobj->getdata(10,"flag='c'",'buynum desc,gid desc','gid,gtypeid,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,addtime');
	addfield($goodsobj->table,'views',"gid=".$gid,1);//增加浏览次数
	include template('recommend_view');//包含输出指定模板
}else {
	$rightarray=$goodsobj->getdata(6,"flag='c'",'listorder asc,gid desc','gid,gtypeid,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,addtime');
	$rightuserarray=$goodsobj->getdata(6,"flag='c' and usertype=1 and Audit=1",'listorder asc,gid desc','gid,gtypeid,usertype,uname,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,why,addtime');
	$leftarray=$goodsobj->getdata(10,"flag='c'",'buynum desc,gid desc','gid,gtypeid,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,addtime');
	
	$specialobj=new TableClass('special','sid');
	$topcarray=$specialobj->getdata(3,"flag='tj'",'listorder asc,sid desc','sid,title,flag,about,pic,listorder,addtime');
	//print_r($rightarray);
	//print_r($leftarray);
	include template('recommend');//包含输出指定模板
}
?>