<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $cfg_site_name;?>" />
<link type="text/css" rel="Stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css" />
<link href="<?php echo TPL;?>css/AddItemPanel.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script src="<?php echo TPL;?>js/jQuery.Extend.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo TPL;?>js/jQuery.Drag.min.js"></script>
    <script src="<?php echo TPL;?>js/Plug-in/jquery.cookies.2.1.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo TPL;?>js/Gobal.js"></script>
    <link href="<?php echo TPL;?>css/about.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        var id = '4';
        $(function() {
            $("#" + id).addClass("tl");
        });
    </script>

<title>
关于我们 - <?php echo $cfg_site_name;?>
</title></head>
<body>
    
<form name="" method="post" action="" id="">

<?php include template('header'); ?>

<div class="about">
        <div class="full">
            <div class="leftpan">
                <h2>关于我们</h2>
                 <ul>
                    
                            <li id='4'><a href='<?php echo url("about.php?action=aboutus"); ?>'>

                                关于我们</a></li>
                        
                            <li id='5'><a href='<?php echo url("about.php?action=contactus"); ?>'>
                                联系我们</a></li>
                        
                            <li id='6'><a href='<?php echo url("about.php?action=joinus"); ?>'>
                                加入我们</a></li>
                        
                            <li id='10'><a href='<?php echo url("about.php?action=Agreement"); ?>'>
                                服务协议</a></li>

                        
                            <li id='14'><a href='<?php echo url("about.php?action=links"); ?>'>
                                友情链接</a></li>
                        
                            <li id='21'><a href='<?php echo url("about.php?action=Customers"); ?>'>
                                 团购服务协议</a></li>
                        
                </ul>

          </div>
          <div class="rightpan">
                <h1>

                    加入我们</h1>
            <div class="detail">
                    <p>　　欢迎您来到全国最大的海外华人在线购物平台，体验最新最时尚的购物方式，一站解决您对国内商品的需求。</p>
<p>　　<strong>我们的团队</strong></p>
<p>　　&ldquo;<span id="ctl00_ContentPlaceHolder1_ucNewsDetail1_lblTitle">郑州全搜索计算机服务有限公司</span>&rdquo;旗下的&ldquo;代购网&rdquo;创建于2008年3月，是在原有的服务海外留学生代购国内商品业务的基础上成立发展而来的。</p>

<p>　　公司拥有多位著名的电子商务专家，拥有开拓进取的精英管理团队，拥有商品代购领域的资深经营经验以及先进的全球物流网络。公司构建了一个自由广阔、安全可靠的网络平台，为广大的海外消费者畅通无阻地进行国内网络购物提供了全方位的解决方案。</p>
<p>　　<strong>我们的目标</strong></p>
<p>　　&ldquo;正在帮助更多的海外消费者实现他们多年的梦想 &mdash;&mdash;&ldquo;足不出户，买遍中国&rdquo;!</p>
<p>　　&ldquo;致力于建设一个为海外用户提供代购国内商品的服务，让身在海外的您不用回国，便能自由挑选和购买到正宗优质的国内商品;同时，与众多国内著名网络商家达成合作协议，您可以通过&ldquo;这样一个海外购物网络门户进入中国， 第一时间了解国内时尚信息，拥有自己梦寐以求的商品，真正实现无国界生活。</p>

<p>　　<strong>我们的服务</strong></p>
<p>　　&ldquo;依托自身广泛的信息平台，和世界范围内的物流网络，向海外消费者提供以互联网为基础、以便利消费者为宗旨的全国代购服务。通过代购，您可以享受到：</p>
<p>　　1、无限选择购买网上商品;</p>
<p>　　2、无需拥有国内银行卡，无需兑换外汇，用外币即可购买国内商品;</p>
<p>　　3、最低价的商品价格 ，便捷多元的付费方式，让您省时省事，坐享其成;</p>
<p>　　5、快捷安全地收到您委托代购的商品;</p>

<p>　　6、整个订购过程方便简捷，享受令人满意的客户服务。</p>
<p>　　&ldquo;作为目前国内最大的国内商品在线代购网，始终致力于向用户提供完善的服务，给用户完美的时尚购物体验。您有对国内商品的需求吗?让我们为您一站解决。</p>
            </div>
            </div>
        </div>
        <div style="background: url(<?php echo TPL;?>images/yuan_top.gif) no-repeat -952px 0;height: 5px; clear: both">
        </div>
    </div>

    
<?php include template('footer'); ?>

</form>
</body>
</html>
