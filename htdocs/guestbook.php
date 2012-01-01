<?php
include("common.inc.php");
InitGP(array("action","page")); //初始化变量全局返回
//include_once(INC_PATH."/guestbook.class.php");
//$Table=new GuestBookClass();

$Table=new TableClass('sendorder','sid');



$wherestr[]="showcomment = 1";
$wherestr[]="state=3";
$wherestr[]="commenttime <> ''";
$wherestr[]="reply <> ''";
if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总

//获取当前页码
$total=$Table->getcount($wheresql. " and state=3 and commenttime <> ''");//总信息数
$pagesize=10;												  //一页显示信息数
$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
$offset=($page-1)*$pagesize;   								  //偏移量
$dataarray=$Table->getdata("$offset,$pagesize",$wheresql,"sid desc"); //获取团购数据

foreach($dataarray as &$val){
$face=DB::result_first("select face from dg_users where uname='".$val['uname']."'");
$val['face']=$face;
}

//读取编辑推荐
$goodsobj=new TableClass('goods','gid');
$rightarray=$goodsobj->getdata(4,"flag='c'",'listorder asc,gid desc','gid,gtypeid,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,addtime');
//读取4条折扣信息
$discountobj=new TableClass('discount','did');
$discountarray=$discountobj->getdata(4,"flag='c'",'listorder asc,did desc','did,title,flag,about,pic,discounttime,listorder,addtime');

//输出测试
//print_r($dataarray);


include template('guestbook');//包含输出指定模板
?>