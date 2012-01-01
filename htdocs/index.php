<?php
include("common.inc.php");
InitGP(array("action","refuid","refuname","referer","aid","cityid")); //初始化变量全局返回

if($cfg_site_closed=="Y")showmsg(lang('Site_has_been_temporarily_closed'),"-1");
//showmessage("站点因正在更新已暂时关闭！","",false,99999);

include_once(INC_PATH."/guestbook.class.php"); //问题质询5条
$Table=new GuestBookClass();
$dataarray=$Table->getdata("5"," G.state=1 "," G.gid desc,G.addtime desc","G.msg,G.uname,G.addtime,U.face","ALL");

//获取推荐商品10个
$goodsobj=new TableClass('goods','gid');
$cptjarray=$goodsobj->getdata(10,"flag='c'",'buynum desc,gid desc','gid,gtypeid,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,addtime');

//获取精品活动
$specialobj=new TableClass('special','sid');
$specialarray1=$specialobj->getdata(1,"flag='sy'",'listorder asc,sid desc','sid,title,flag,about,pic,listorder,addtime');
$specialarray2=$specialobj->getdata("1,6","flag='sy'",'listorder asc,sid desc','sid,title,flag,about,pic,listorder,addtime');

//获取首页三个广告仑显图
$topcarray=$specialobj->getdata(3,"flag='sy'",'listorder asc,sid desc','sid,title,flag,about,pic,listorder,addtime');


//获取优惠活动
$specialob=new TableClass('special','sid');
$special=$specialob->getdata(2,"flag='h'",'listorder asc,sid desc','sid,title,flag,about,pic,listorder,addtime');
//获取折扣信息
$discountobj=new TableClass('discount','did');
$discountarray=$discountobj->getdata(2,"flag='h'",'listorder asc,did desc','did,title,flag,about,pic,listorder,addtime');

$discountob=new TableClass('discount','did');
$discount=$discountob->getdata(1,"flag='h'",'listorder asc,did desc','did,title,flag,about,pic,listorder,addtime');

//公告
$newsobj=new TableClass('news','nid');
$newsarray=$newsobj->getdata(9,$wheresql); //获取数据


//帮助信息->常见问题
$wheresql="";
$articleobj=new TableClass('article','aid');
$articlearray=$articleobj->getdata(9,$wheresql,"",'aid,typeid,title');

include_once(INC_PATH.'/rate.class.php');
$rate = RateClass::init();
//获取最新汇率信息
$ratedata = $rate->get();

include template('index');//包含输出指定模板
?>