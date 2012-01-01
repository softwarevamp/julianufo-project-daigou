<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="Stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css" />
<link href="<?php echo TPL;?>css/AddItemPanel.css" rel="stylesheet" type="text/css" />
<script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="<?php echo TPL;?>js/jQuery.Extend.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/jQuery.Drag.min.js"></script>
<script src="<?php echo TPL;?>js/jquery.cookies.2.1.0.min.js"type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Gobal.js"></script>
<link href="<?php echo TPL;?>css/special.css" rel="stylesheet" type="text/css" />
<title>[<?php echo $cfg_site_name;?>-专题活动] - 热购精品大荟萃 活动优惠大放送 </title>
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
<form name="aspnetForm" method="post" action="#" id="aspnetForm">
  <?php include template('header'); ?>
  <div class="special">
    <div class="qj"> </div>
    <div class="lm">
      <h2> <img src="<?php echo TPL;?>images/new.gif" alt="专题" /></h2>
      <span></span> </div>
    <div class="new">

<?php if(is_array($topharray)) foreach($topharray AS $r) { ?>
      <div class="zuo"><a href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>" target="_blank"><img src="<?php echo $r['pic'];?>" alt="<?php echo $r['title'];?>" /></a></div>
<?php } ?>
      <div class="you">
<?php if(is_array($topharray)) foreach($topharray AS $r) { ?>
        <div class="js">
          <h1><a href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>" target="_blank"><?php echo $r['title'];?></a></h1>
          <p><?php echo $r['about'];?><a href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>" target="_blank">查看详情&gt;&gt;</a></p>
        </div>
<?php } ?>
        <ul>
<?php if(is_array($topcarray)) foreach($topcarray AS $r) { ?>
          <li><a href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>" target="_blank"><?php echo $r['title'];?></a></li>
<?php } ?>
        </ul>
        <dl class="noLogin">
          <dt><img src="<?php echo TPL;?>images/picLogined.gif" /></dt>
          <dd><a href="<?php echo url("user.php?action=register"); ?>" title="立即加入" target="_blank"> </a></dd>
        </dl>
      </div>
  
  
    </div>
    <div class="lm">
      <h2> <img src="<?php echo TPL;?>images/wonderful.gif" alt="精彩专题活动" /></h2>
    </div>
    <div class="hdlb">

<?php if(is_array($dataarray)) foreach($dataarray AS $r) { ?>
      <dl>
        <dt> <a href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>" target="_blank"><img src="<?php echo $r['pic'];?>" alt="<?php echo $r['title'];?>" /></a> </dt>
        <dd>
          <h1><a href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>" target="_blank"><?php echo $r['title'];?></a></h1>
          <p><?php echo $r['about'];?></p>
          <span><a href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>" target="_blank">查看详情&gt;&gt;</a></span> </dd>
      </dl>
<?php } ?>  

  
      <div style="clear: both"> &nbsp; </div>
    </div>
<div>  <? echo pagelist($total,$pagesize,$page,"");; ?> </div>
  </div>
  <?php include template('footer'); ?>
</form>
</body>
</html>
