<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/AddItemPanel.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css"  />
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/home.css"  />
<link type="text/css" id="styleName" rel="stylesheet" href="<?php echo TPL;?>css/orange/color.css"/ >    
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/mypanli.css"/>
<script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/wdggcGobal.js"></script>

<title>会员中心-<?php echo $cfg_site_name;?></title>
</head>

<body>

<?php include template('header'); ?>
    <div class="admin">
      <div class="ding">
            <div class="shouye">
                <a title="会员中心首页" href="<?php echo url("m.php"); ?>"></a>
            </div>
            <div class="lb">

                <div class="gonggao">
                    <img alt="温馨提示" title="温馨提示" src="<?php echo TPL;?>images/lb.gif">
                  <ul id="affiche">
                        
<li>收藏夹新增“一键收藏”功能，让您收藏宝贝变得更容易，快去试试吧！</li>
<li><a target="_blank" href="#">网站全新改版！精彩活动等你来参加！</a></li>
  </ul>
                </div>
                
                <div class="shezhi">
                    <p>
                        <a href="<?php echo url("m.php"); ?>">会员中心首页</a><span>|</span>风格设置：</p>
                    <ul>
<li onclick="changeStyle('orange')" class="mypanliS1"></li>
                        <li onclick="changeStyle('grey')" class="mypanliS2"></li>
                        <li onclick="changeStyle('blue')" class="mypanliS3"></li>
                    </ul>
                </div>
            </div>
      </div>
  
<?php include template('member_left'); ?>

    <div class="bj">
        <div class="center">
            <div class="data">
                <div class="geren">
                    <div class="photo">
                        <img onerror="this.src='<?php echo TPL;?>images/noimg120.gif'" alt="<?php echo $_USERS['showname'];?>" src="<?php echo $_USERS['face'];?>">
                    </div>
                    <div class="info">
                        <h2>
                            你好！<?php echo $_USERS['showname'];?>，欢迎您回来！！</h2>
                        <ul>
                            <li style="width:165px;">身份：<?php echo $UTYPENAME[$_USERS['utype']];?></li>
                            <li style="width:179px;">RMB帐户：<span>￥<?php echo $_USERS['money'];?></span><a href="<?php echo url("m.php?name=rmbaccount"); ?>">充值</a></li>
                            <li style="width:165px;">信箱：<a href="<?php echo url("m.php?name=pm"); ?>"><?php echo $_USERS['pm'];?>条未读信息</a></li>
                            <li style="width:179px;">帐户积分：<span><?php echo $_USERS['scores'];?></span><a href="<?php echo url("m.php?name=coupon&action=getcoupon"); ?>" style="">兑换</a>|<a href="m.php?name=index&amp;action=upmember" style="margin-top:0px;">会员升级</a></li>
                        </ul>
                        <p style="display:none;">
                           您当前已经消费了0元</p>
                    </div>
                </div>
                <div class="shuju">
                    <ul>
                        <li>已经到货的商品：<a href="<?php echo url("m.php?name=orderlist&type=1"); ?>"><?php echo $COUNT_ORDER4;?>个</a></li>
                        <li>正在途中的商品：<a href="<?php echo url("m.php?name=orderlist&type=2"); ?>"><?php echo $COUNT_ORDER3;?>个</a></li>
                        <li>已经发货的运单：<a href="<?php echo url("m.php?name=sendorderlist&type=1"); ?>"><?php echo $COUNT_SENDORDER23;?>个</a></li>
                        <li>可以评价的服务：<a href="<?php echo url("m.php?name=sendorderlist&type=2"); ?>"><?php echo $COUNT_SENDORDERSERVER;?>个</a></li>
                    </ul>
                </div>
            </div>
            <dl class="gwc">
                <dt>
                    <img alt="我的购物车" src="<?php echo TPL;?>images/gwche.gif"></dt>
                <dd>
                    <h2>
                        <a href="<?php echo url("shoppingcart.php"); ?>">我的购物车</a></h2>
                    <p>
                        <a href="<?php echo url("shoppingcart.php"); ?>">您的购物车上有&nbsp;<b><?php echo $_CARTCOUNT;?></b>&nbsp;件商品，赶快去提交订单吧！</a></p>
                    <span>由于时效性问题，您所选择商品的价格丶优惠政策等信息随时可能发生变化哦。赶快去看看！</span>
                </dd>
            </dl>
            <dl class="gwc">
                <dt>
                    <img alt="我的送货车" src="<?php echo TPL;?>images/che.gif"></dt>
                <dd>
                    <h2>
                        <a href="<?php echo url("m.php?name=orderlist"); ?>">我的送货车</a></h2>
                    <p>
                        商品状态为&nbsp;<font style="color: rgb(255, 0, 0);">“ 已到仓库”</font>&nbsp;即可提交运送哦！</p>
                </dd>
            </dl>
            <div class="qb">
                <h2>
                    专题情报</h2>
                <div class="qingbao">
<?php if(is_array($specialarray)) foreach($specialarray AS $r) { ?>

                    <dl>
<dt>
<a target="_blank" href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>"><img alt="<?php echo $r['title'];?>" src="<?php echo $r['pic'];?>"></a></dt>
<dd><h1><a target="_blank" href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>"><?php echo $r['title'];?></a></h1>
<p><?php echo substrs($r['about'],100,0,1);?></p>
</dd></dl>

<?php } ?>
                </div>
            </div>
        </div>
        <div class="right">
            <h2>
             网站公告</h2>
            <ul>
<?php if(is_array($newsarray)) foreach($newsarray AS $r) { ?>
                <li><a target="_blank" href="<?php echo url("news.php?action=view&nid=$r[nid]"); ?>"><?php echo $r['title'];?></a></li>
<?php } ?>


            </ul>
            <h2>
                常见问题</h2>
            <ul>
<?php $helparray=helplist(5,1)?>
<?php if(is_array($helparray)) foreach($helparray AS $r) { ?>
                    <li><a target="_blank" href="<?php echo url("help.php?action=view&id=$r[aid]"); ?>"><?php echo $r['title'];?></a></li>
<?php } ?>

            </ul>
            <h2>
                问题咨询</h2>
            <div class="jianyi">
                <p>
                    你对网站有什么疑问吗？</p>
                <p>
                   欢迎您提出意见和咨询！</p>
                <dl>
<form name="guestbook" method="post" action="<?php echo url("m.php?name=index&action=guestbook"); ?>">
                    <dt>
                        <textarea rows="" cols="" id="msg" name="msg"></textarea>
                        <p>
                            <input type="text" id="code" name="code" maxlength="4" onkeydown="return enter(event);"><input type="text" style="display: none;">
                            <img src="includes/code/securimage_show.php?sid=<? echo md5(time()); ?>&amp;w=92&amp;h=22&amp;t='+Math.random();" alt="验证码" name="checkCode" border="0" id="checkCode" style="vertical-align: middle; cursor: pointer;" title="点击图片刷新" onclick="this.src='includes/code/securimage_show.php?sid=<? echo md5(time()); ?>&amp;w=92&amp;h=22&amp;t='+Math.random();">                        </p>
                    </dt>
                    <dd>
                        <input type="submit" onmouseout="this.className=''" onmouseover="this.className='jg'" value="提交" onclick="" id="suggestBtn"></dd>
</form>
                </dl>
            </div>
        </div>
        <div class="yj_you">
        </div>
    </div>

      <div class="yj">
      </div>
    </div>

    
<?php include template('footer'); ?>
</body>
</html>
