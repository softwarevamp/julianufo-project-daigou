<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo TPL;?>css/NewTopFoot.css" rel="Stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/AddItemPanel.css">
<script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Gobal.js"> </script>
<link href="<?php echo TPL;?>css/see.css" rel="Stylesheet" type="text/css">
<title>讨论组  - <?php echo $cfg_site_name;?></title>
<style type="text/css">
.pages {float:right;height:25px;display:inline;}
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
<?php include template('header'); ?>

<div class="see">
  <div class="see_main_left mar_right_10">
    <div class="deals">
      <div class="top fudong"><img src="<?php echo TPL;?>images/bg_scodtop.png" width="640" height="8" /></div>
      <div class="mid">
        <div class="gbt_line">问题咨询
          <div style="font-size: 14px; text-align: right;"> <a href="<?php echo url("user.php?action=login"); ?>">登录</a> / <a href="<?php echo url("user.php?action=register"); ?>">用户注册</a> </div>
        </div>
        <div class="sect">
          <div class="daelog">
            <ul>


<?php if(is_array($dataarray)) foreach($dataarray AS $r) { ?>

              <a name="<?php echo $r['gid'];?>" id="<?php echo $r['gid'];?>"></a>
              <li>
                <div class="l"><img src="<?php echo $r['face'];?>" onerror="this.src='<?php echo TPL;?>images/untitled.jpg'"/></div>
                <div class="r"> <span class="zi_hui"><?php echo $r['uname'];?> <?php echo ddate("Y-m-d",$r['addtime']);?></span><br />
                  <?php echo $r['msg'];?> <br />
  <?php if(!empty($r['reply'])) { ?>
                  <div class="huifu">回复：<?php echo $r['reply'];?></div>
  <?php } ?>
                </div>
              </li>
  
<?php } ?>
  
              <li></li>
            </ul>
          </div>
        
       <? echo pagelist($total,$pagesize,$page,"");; ?>        </div>
      </div>
      <div class="bom"><img src="<?php echo TPL;?>images/bg_scodbom.png" /></div>
    </div>
  </div>
  
    <div class="see_left">
      <div class="pltj">
        <div class="lm">
          <h2> <img alt="Panli推荐" src="<?php echo TPL;?>images/see_tj.gif" /> </h2>
          <span><a target="_blank" href="<?php echo url("recommend.php"); ?>">更多..</a> </span> </div>
        <ul>


<?php if(is_array($rightarray)) foreach($rightarray AS $r) { ?>

          <li>
            <dl>
              <dt><a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>"> <img alt="<?php echo $r['goodsname'];?>" src="<?php echo $r['goodsimg'];?>"></a></dt>
              <dd>
                <h1> <a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>"> <?php echo substrs($r['goodsname'],45);?></a></h1>
                <p> 价格：<span> ￥<?php echo $r['goodsprice'];?></span></p>
                <div> 来源：<a target="_blank" href="<?php echo $r['sellerurl'];?>"><?php echo $r['goodsseller'];?></a></div>
                <b><a href="###">[<?php echo $r['shopname'];?>]</a></b> </dd>
            </dl>
          </li>

<?php } ?>
  
  

        </ul>
      </div>
      <div class="see_zk" style="">
        <div class="lm">
          <h2><img alt="折扣信息" src="<?php echo TPL;?>images/see_zk.gif"></h2>
          <span><a href="<?php echo url("discount.php"); ?>">更多..</a></span></div>
        <ul>
<?php if(is_array($discountarray)) foreach($discountarray AS $r) { ?>
          <li>
            <h3><a target="_blank" href="<?php echo url("discount.php?action=view&did=$r[did]"); ?>"><?php echo $r['title'];?></a></h3>
            <p><?php echo $r['about'];?><a target="_blank" href="<?php echo url("discount.php?action=view&did=$r[did]"); ?>">详情&gt;&gt;</a></p>
          </li>
<?php } ?>

        </ul>
      </div>
  </div>
</div>
<?php include template('footer'); ?>
</body>
</html>
