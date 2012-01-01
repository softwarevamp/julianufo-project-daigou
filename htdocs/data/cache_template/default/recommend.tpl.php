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
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/Recommend.css">
<script type="text/javascript" src="<?php echo TPL;?>js/RecommendRun.js"></script>
 
<meta content="商品推荐,代购,女装,服饰,护肤,食品" name="keywords">
<meta content="国内的流行趋势是什么？网友都喜欢代购什么？时尚女装、服饰、美容护肤、中国美味食品一为您推荐" name="description">
    
<title>
[<?php echo $cfg_site_name;?>-推荐人] -精选华人热购商品 喜欢就立即代购吧！
</title></head>

<body>

<form id="aspnetForm" action="Default.aspx" method="post" name="aspnetForm">


<?php include template('header'); ?>

  <div class="recommend">
    <div class="leftpan">
            <div class="dh">
                <h2>
                </h2>
              <ul>
                    <li><a title="服装" href="<?php echo url("recommend.php?action=list&tid=1"); ?>" class="q1"></a></li>
                    <li><a title="鞋包" href="<?php echo url("recommend.php?action=list&tid=2"); ?>" class="q2"></a></li>
                    <li><a title="美容" href="<?php echo url("recommend.php?action=list&tid=3"); ?>" class="q3"></a></li>
                    <li><a title="居家" href="<?php echo url("recommend.php?action=list&tid=4"); ?>" class="q4"></a></li>
                    <li><a title="配饰" href="<?php echo url("recommend.php?action=list&tid=5"); ?>" class="q5"></a></li>
                    <li><a title="食品" href="<?php echo url("recommend.php?action=list&tid=6"); ?>" class="q6"></a></li>
              </ul>
            </div>
            <div class="ranking">
                <div class="phb">
                    <h2>
                    </h2>
                </div>
                <div class="ph">
                    
                    <?php if(is_array($leftarray)) foreach($leftarray AS $key => $r) { ?>
                    <dl>
                        <dt <?php if($key==0) { ?>style="display: block;"<?php } else { ?>style="display: none;"<?php } ?>>
                            <div class="img">
                                <a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>">
                                <img alt="<?php echo $r['goodsname'];?>" src="<?php echo $r['goodsimg'];?>">
                                </a>
                            </div>
                            <div class="xiangxi">
                                <h1>
                                    <b>
                                        1.</b> <a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>">
                                            <?php echo substrs($r['goodsname'],45);?></a>
                                </h1>
                                <label>
                                    <?php echo $r['goodsprice'];?></label>
                                <p>
                                    来源网站：<span><?php echo $r['shopname'];?></span></p>
                            </div>
                        </dt>
                        <dd <?php if($key==0) { ?>style="display: none;"<?php } else { ?>style="display: block;"<?php } ?>>
                            <span><? echo $key+1; ?></span>
                            <p>
                                <a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>">
                                    <?php echo substrs($r['goodsname'],45);?></a>
                            </p>
                        </dd>
                    </dl>
<?php } ?>

                </div>
            </div>
    </div>
        <div class="rightpan">
            <dl class="gs">
                <dt>
                  <img alt="Panli推荐" src="<?php echo TPL;?>images/tuijian_tj.gif"></dt>
                <dd>
                    <ul>
                        <li>为您精选最潮流的商品！</li>
                        <li>为您精选最有品质保障的卖家！</li>
                        <li>轻松代购全中国！</li>
                    </ul>
                </dd>
            </dl>
            <div class="gundong">
                <div id="MainPromotionBanner">
                    <div id="SlidePlayer" style="height: 275px;">
                        <ul id="Slides" class="Slides" style="height: 825px; position: absolute; top: -275px;">

<?php if(is_array($topcarray)) foreach($topcarray AS $r) { ?>
<li><a title="<?php echo $r['title'];?>" href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>" target="_blank"><img src="<?php echo $r['pic'];?>" alt="<?php echo $r['title'];?>"></a></li>
<?php } ?>	



</ul><ul class="SlideTriggers"><li class="">1</li><li class="Current">2</li><li class="">3</li></ul>
                        
                    </div>
                </div>
            </div>
            <div class="xbtj">
                <h2>
                  <img alt="推荐人" src="<?php echo TPL;?>images/xbtj1.gif"></h2>
                <p>
                    <a href="<?php echo url("recommend.php?action=list&tid=1"); ?>">服装</a>&nbsp;|&nbsp;
<a href="<?php echo url("recommend.php?action=list&tid=2"); ?>">鞋包</a>&nbsp;|&nbsp;
<a href="<?php echo url("recommend.php?action=list&tid=3"); ?>">美容</a>&nbsp;|&nbsp;
<a href="<?php echo url("recommend.php?action=list&tid=4"); ?>">居家</a>&nbsp;|&nbsp;
<a href="<?php echo url("recommend.php?action=list&tid=5"); ?>">配饰</a>&nbsp;|&nbsp;
<a href="<?php echo url("recommend.php?action=list&tid=6"); ?>">食品</a>
</p>
            </div>
            <div class="lb">
                

<?php if(is_array($rightarray)) foreach($rightarray AS $key => $r) { ?>
                
                <dl>
                    <dt><a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>">
                        <img alt="<?php echo $r['goodsname'];?>" src="<?php echo $r['goodsimg'];?>"></a></dt>
                    <dd>
                        <h1>
                            <a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>">
                            <?php echo $r['goodsname'];?>
</a></h1>
                        <ul>
                            <li><b>￥<?php echo $r['goodsprice'];?></b></li>
                            <li>
                                <label>
                                    来源商家：
                                </label>
                                <span><i>
                                    <?php echo $r['shopname'];?></i></span><a target="_blank" href="<?php echo $r['sellerurl'];?>"><i><?php echo $r['goodsseller'];?></i></a></li>
                            <li>
                                <label>
                                    推荐指数：
                                </label>
                                <div>
                                  <img alt="<?php echo $r['goodsname'];?>" src="<?php echo TPL;?>images/star<?php echo $r['rindex'];?>.gif"></div>
                            </li>
                        </ul>
                    </dd>
                </dl>
 
<?php } ?>
                
                <div style="clear: both;">
                </div>
            </div>

 <div class="xbtj">
                <h2>
                  <img alt="好友推荐" src="<?php echo TPL;?>images/xbtj.gif" /></h2>
                <p>					
                    <a href="<?php echo url("recommend.php?action=list&tid=1"); ?>">服装</a>&nbsp;|&nbsp;
<a href="<?php echo url("recommend.php?action=list&tid=2"); ?>">鞋包</a>&nbsp;|&nbsp;
<a href="<?php echo url("recommend.php?action=list&tid=3"); ?>">美容</a>&nbsp;|&nbsp;
<a href="<?php echo url("recommend.php?action=list&tid=4"); ?>">居家</a>&nbsp;|&nbsp;
<a href="<?php echo url("recommend.php?action=list&tid=5"); ?>">配饰</a>&nbsp;|&nbsp;
<a href="<?php echo url("recommend.php?action=list&tid=6"); ?>">食品</a>
</p>
          
</div>
            <div class="lb">
<?php if(is_array($rightuserarray)) foreach($rightuserarray AS $key => $r) { ?>
                
                <dl style="height:143px;">
                    <dt><a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>">
                        <img alt="<?php echo $r['goodsname'];?>" src="<?php echo $r['goodsimg'];?>" style="height:115px;" /></a></dt>
                    <dd>
                        <h1>
                            <a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>">
                            <?php echo $r['goodsname'];?>
</a></h1>
                        <ul>
                            <li><b>￥<?php echo $r['goodsprice'];?></b></li>
                            <li>
                                <label>
                                    来源商家：
                                </label>
                                <span><i>
                                    <?php echo $r['shopname'];?></i></span><a target="_blank" href="<?php echo $r['sellerurl'];?>"><i><?php echo $r['goodsseller'];?></i></a></li>
                            <li>
                                <label>
                                   推荐指数：
                                </label>
                                <div>
                                  <img alt="<?php echo $r['goodsname'];?>" src="<?php echo TPL;?>images/star<?php echo $r['rindex'];?>.gif" /></div>
                            </li>
  <li>
                                <label>
                                    推荐人：
                                </label>
                                
                                   <i><?php echo $r['uname'];?></i>
                            </li>

                        </ul>
                    </dd>
<label>推荐理由：</label><span style="width:170px;"><?php echo substrs($r['why'],48,0,1);?></span>
                </dl>
<?php } ?>
                <div style="clear: both;width:86px;height:58px;">
                </div>
            </div>
    
    </div>
    </div>

    
<?php include template('footer'); ?>
    </form>


</body>
</html>
