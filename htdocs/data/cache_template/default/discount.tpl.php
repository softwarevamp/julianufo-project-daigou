<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="Stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css" />
<link href="<?php echo TPL;?>css/AddItemPanel.css" rel="stylesheet" type="text/css" />
<script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="<?php echo TPL;?>js/jQuery.Extend.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/jQuery.Drag.min.js"></script>
<script src="<?php echo TPL;?>js/jquery.cookies.2.1.0.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Gobal.js"></script>
<link href="<?php echo TPL;?>css/discount.css" rel="stylesheet" type="text/css" />
<meta name="keywords" content="代购,折扣,淘宝网,特卖,促销 " />
<meta name="description" content="Сейчас на каких сайтах идет акция ,распродаж ?Заказать какие товары более выгодно ?" />
<title>[<?php echo $cfg_site_name;?>-折扣信息] - 国内主流网站最新折扣信息尽在把握 </title>
<style type="text/css">
.pages {float:right;height:25px;margin:15px 0 0 0;display:inline;}
.pages li{list-style-type: none;}
.pages  a{text-decoration:none;}
.pages li{
border:1px solid #AAAAAA;color:#666666;display:inline;float:left;height:20px;line-height:20px;margin-left:2px;padding:0 5px;text-decoration:none;}
.pages li {border:1px solid #DDDDDD;color:#CCC;font-family:"simsun";}
.pages li:hover {background:#FFEDE1;border:1px solid #FF9900;}
.pages .current {background:#FFEDE1;border:1px solid #FF6600;color:#FF0000;}
.pages em {color:#999999;display:inline;float:left;height:22px;line-height:22px;margin-left:5px;}
</style>
</head>
<body>
<form name="" method="post" action="" id="">
  <?php include template('header'); ?>
  <div class="hot">
    <div class="leftpan">
      <div class="zk_qbz">
        <h2> <img src="<?php echo TPL;?>images/zk_qbz.gif" /></h2>
      </div>
      <div class="nr">
<?php if(is_array($topharray)) foreach($topharray AS $r) { ?>
        <div class="hotimg"> <a href="<?php echo url("discount.php?action=view&did=$r[did]"); ?>" target="_blank"><img src="<?php echo $r['pic'];?>" alt="<?php echo $r['title'];?>" /></a></div>
<?php } ?>

        <div class="xiang">
<?php if(is_array($topharray)) foreach($topharray AS $r) { ?>
          <div class="tj">
            <h1><a href="<?php echo url("discount.php?action=view&did=$r[did]"); ?>" target="_blank"><?php echo $r['title'];?></a></h1>
            <p><?php echo $r['about'];?><a href="<?php echo url("discount.php?action=view&did=$r[did]"); ?>" target="_blank">[详细]</a></p>
          </div>
<?php } ?>
          <ul class="lb">
<?php if(is_array($topcarray)) foreach($topcarray AS $r) { ?>
            <li><a href="<?php echo url("discount.php?action=view&did=$r[did]"); ?>" target="_blank"><?php echo $r['title'];?></a></li>
<?php } ?>

          </ul>
        </div>
      </div>
    </div>
    <div class="rightpan">
      <div class="lm"> <img src="<?php echo TPL;?>images/zk_tjsj.gif" /></div>
      <ul class="shoplogo">
        <li><a href="http://www.360buy.com/" target="_blank"> <img src="<?php echo TPL;?>images/shop.gif" /></a></li>
        <li><a href="http://www.taobao.com/" target="_blank"> <img src="<?php echo TPL;?>images/taobao.gif" /></a></li>
        <li><a href="http://www.dangdang.com/" target="_blank"> <img src="<?php echo TPL;?>images/shop3.gif" /></a></li>
        <li><a href="http://www.818shyf.com/" target="_blank"> <img src="<?php echo TPL;?>images/shop4.gif" /></a></li>
        <li><a href="http://www.m18.com/" target="_blank"> <img src="<?php echo TPL;?>images/shop5.gif" /></a></li>
        <li><a href="http://www.paipai.com/" target="_blank"> <img src="<?php echo TPL;?>images/paipai.gif" /></a></li>
        <li><a href="http://www.amazon.cn" target="_blank"> <img src="<?php echo TPL;?>images/amzon.gif" /></a></li>
        <li><a href="http://www.shishangqiyi.com/" target="_blank"> <img src="<?php echo TPL;?>images/shop8.gif" /></a></li>
      </ul>
    </div>
  </div>
  <div class="zk_new">
    <div class="zk_qbz">
      <h2> <img src="<?php echo TPL;?>images/zk_zxxx.gif" /></h2>
    </div>
    <ul>
<?php if(is_array($dataarray)) foreach($dataarray AS $r) { ?>
      <li>
        <div class="tupian"><a href="<?php echo url("discount.php?action=view&did=$r[did]"); ?>" target="_blank"><img src="<?php echo $r['pic'];?>" alt="<?php echo $r['title'];?>" /></a></div>
        <div class="xinxi">
          <h1><a href="<?php echo url("discount.php?action=view&did=$r[did]"); ?>" target="_blank"><?php echo $r['title'];?></a></h1>
          <span>折扣时间：<?php echo $r['discounttime'];?></span>
          <p><?php echo $r['about'];?><a href="<?php echo url("discount.php?action=view&did=$r[did]"); ?>" target="_blank">详细&gt;&gt;</a></p>
        </div>
      </li>
  
<?php } ?>    
  
  
    </ul>
    <div style="clear: both"> </div>
<div>  <? echo pagelist($total,$pagesize,$page,"");; ?> </div>
  </div>
  <?php include template('footer'); ?>
</form>
</body>
</html>
