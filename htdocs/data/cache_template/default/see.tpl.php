<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="<?php echo TPL;?>css/NewTopFoot.css" rel="Stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/AddItemPanel.css">
<script type="text/javascript" src="<?php echo TPL;?>js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/jQuery.Extend.js"></script>
<script src="<?php echo TPL;?>js/jQuery.Drag.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/jquery.cookies.2.1.0.min.js"></script>
<script src="<?php echo TPL;?>js/Gobal.js" type="text/javascript"></script>
<link href="<?php echo TPL;?>css/see.css" rel="Stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo TPL;?>js/SeeRun.js"></script>

<style type="text/css">
.pages {height:25px;margin:0 10px 5px 0;display:inline;float:right;overflow:hidden}
.pages li{list-style-type: none;}
.pages  a{text-decoration:none;}
.pages li{
border:1px solid #AAAAAA;color:#666666;display:inline;float:left;height:20px;line-height:20px;margin-left:2px;padding:0 5px;text-decoration:none;}
.pages li {border:1px solid #DDDDDD;color:#CCC;font-family:"simsun";}
.pages li:hover {background:#FFEDE1;border:1px solid #FF9900;}
.pages .current {background:#FFEDE1;border:1px solid #FF6600;color:#FF0000;}
.pages em {color:#999999;display:inline;float:left;height:22px;line-height:22px;margin-left:5px;}
</style>
<meta content="代购,淘宝网,服装,代购商品,购物网站" name="keywords">
<meta content="随便逛逛，看看大家最近在代购什么商品？你可以了解会员经常逛的购物网站、淘宝网卖家；发现更多服装、饰品、特产等宝贝。代购商品之前，不妨先逛逛。" name="description">
<title>[<?php echo $cfg_site_name;?>-随便逛逛] - 看看大家都在买什么</title>
</head>
<body>
  <?php include template('header'); ?>
  <div class="see_pic">
    <div class="search">
      <div class="select">
        <input type="text" value="<?php echo $typearray2[$type]['typename'];?>" name="" id="categoryID" categoryid="<?php echo $type;?>" onclick="$('#categoryList').show()" onmouseover="this.className='bian';" onmouseout="this.className='';" onfocus="this.blur();" readonly="readonly">
        <div onclick="this.style.display='none';" class="sort" id="categoryList" style="display: none;">


<a onclick="$('#categoryID').val('所有分类').attr('categoryid','0');" href="javascript:;"> 所有分类</a>

<?php if(is_array($typearray)) foreach($typearray AS $r) { ?>
<a onclick="$('#categoryID').val('<?php echo $r['typename'];?>').attr('categoryid','<?php echo $r['typeid'];?>');" href="javascript:;"> <?php echo $r['typename'];?></a>
<?php } ?>

</div>
      </div>
      <input type="text" value="" name="" class="text" id="keyword" />
      <input type="button" onmouseout="this.className='button'" onmouseover="this.className='button_'" class="button" id="searchbtn">
    </div>
  </div>
  <div class="see">
    <div class="see_left  mar_right_10">
      <div class="pltj" style="height:auto">
        <div class="lm">
          <h2> <img alt="Panli推荐" src="<?php echo TPL;?>images/see_tj.gif"> </h2>
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
    <div class="see_right">
      <div class="see_h2">
        <h2> <img alt="宝贝展示" src="<?php echo TPL;?>images/zhanshi.gif"></h2>
        <dl>
          <dt></dt>
          <dd> <a target="_self" id="ctl00_NewContentPlaceHolder_next" href="?page=<? echo $page+1; ?>">下一页</a></dd>
        </dl>
      </div>
      <div class="ku"> <a href="<?php echo url("see.php"); ?>">查看所有商品</a> </div>
      <div class="tishi" style="display: block;"> 网站所有商品信息来源其他购物网站，由于时效性问题，商品信息可能有出入，以来源网站信息为准！ </div>
      <div class="tongji">
        <label> 搜索到的最新<span id="recordnum">1000</span>条记录</label>
        <b><a href="<?php echo url("see.php"); ?>">查看所有商品</a></b> </div>
      <div class="see_show">
  
  <?php if(is_array($dataarray)) foreach($dataarray AS $r) { ?>
  
        <ul>
          <li class="s_left"><a target="_blank" href="<?php echo $r['goodsurl'];?>" name="<?php echo $r['oid'];?>"> <img onerror="this.src='/images/noimg80.gif'" largesrc="<?php echo $r['orderimg'];?>" src="<?php echo $r['showimg'];?>"></a> </li>
          <li class="s_mid">
            <h1><a href="<?php echo $r['goodsurl'];?>" title="<?php echo $r['goodsname'];?>" target="_blank"><?php echo $r['goodsname'];?></a></h1>
            <dl>
              <dt><em>￥<?php echo $r['goodsprice'];?></em><span>宝贝分类：<a href="?type=<?php echo $r['typeid'];?>"><?php echo $typearray2[$r['typeid']]['typename'];?></a></span></dt>
              <dd>
                <label> 来源商家：</label>
                <a target="_blank" href="<?php echo $r['siteurl'];?>" class="wz"><?php echo $r['goodssite'];?></a><a target="_blank" href="<?php echo $r['sellerurl'];?>" class="dm"><?php echo $r['goodsseller'];?></a></dd>
            </dl>
          </li>
          <li class="s_right">
            <dl>
              <dt>购买人:<?php echo $r['uname'];?></dt>
  
              <dt style="font-size:11px">成交时间:<?php echo ddate('Y-m-d', $r['addtime']);?></dt>
              <dd> <a onclick="FastAddShow('<?php echo $r['goodsurl'];?>')">我要代购</a> </dd>
            </dl>
          </li>
        </ul>
<?php } ?>

      </div>
      <div class="" style=""><? echo pagelist($total,$pagesize,$page,"");; ?>      </div>
    </div>
  </div>
  <div class="windows" id="LargePicDiv" style="width:320px;display: none;">
    <div class="jiantou"> </div>
    <div class="white" style="width:310px"> <a target="_blank" href="#"> <img alt="" src="MAX-WIDTH: 310px" style=""></a></div>
    <p> <a target="_blank" href="#" id="PicTitle"></a> </p>
  </div>
  <?php include template('footer'); ?>
</body>
</html>
