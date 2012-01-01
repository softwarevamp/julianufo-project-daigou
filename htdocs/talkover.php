<?php
include("common.inc.php");
InitGP(array("action","page")); //初始化变量全局返回
include_once(INC_PATH."/guestbook.class.php");
$Table=new GuestBookClass();

$wherestr[]=" G.state=1";
$wherestr[]=" G.hide=0";
if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总

//获取当前页码
$total=$Table->getcount("state=1 and hide=0"); 							  //总信息数
$pagesize=10;												  //一页显示信息数
$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
$offset=($page-1)*$pagesize;   								  //偏移量
$dataarray=$Table->getdata("$offset,$pagesize",$wheresql); //获取团购数据


//读取编辑推荐
$goodsobj=new TableClass('goods','gid');
$rightarray=$goodsobj->getdata(4,"flag='c'",'listorder asc,gid desc','gid,gtypeid,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,addtime');
//读取4条折扣信息
$discountobj=new TableClass('discount','did');
$discountarray=$discountobj->getdata(4,"flag='c'",'listorder asc,did desc','did,title,flag,about,pic,discounttime,listorder,addtime');

//输出测试
//print_r($dataarray);


include template('talkover');//包含输出指定模板
?>