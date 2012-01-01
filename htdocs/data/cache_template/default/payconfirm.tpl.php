<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css"  />
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/ShoppingCart.css"/>
<script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/wdggcGobal.js"></script>
<title>我的购物车</title>
</head>
<body>
 <form name="ctl00" method="post" action="<?php echo url("payconfirm.php"); ?>" id="ctl00">
 
<div>
<input type="hidden" name="__PAYDATA" id="__PAYDATA" value="<?php echo $paydata;?>" />
</div>

<?php include template('header'); ?>

<div class="center">
  <div class="weizhi"> <b>当前位置：</b><a href="<?php echo url("m.php"); ?>">会员中心</a><span>&gt;</span>购物结算确认 </div>
  <div class="lc_two"> <img src="<?php echo TPL;?>images/donghua.gif"> </div>
  <div class="pay_bt">
    <ul>
      <li class="w1">提交代购商品清单</li>
      <li class="w2">价格</li>
      <li class="w3">购买数量</li>
      <li class="w4">合计</li>
      <li class="w5">国内运费</li>
    </ul>
  </div>
  <div class="product_2">
  <? $i=1 ?>  <?php if(is_array($temparray)) foreach($temparray AS $sname => $value) { ?>
    <table>
      <tbody>
  <?php if(is_array($value)) foreach($value AS $key => $r) { ?>
        <tr>
          <td class="p1"> <?php echo $i;?>
            <input type="hidden" value="<?php echo $r['gid'];?>" name="gids[]">
          </td>
          <td class="p2"><a target="_blank" href="<?php echo $r['goodsurl'];?>"> <?php echo $r['goodsname'];?></a> </td>
          <td class="p3"> ￥<?php echo $r['goodsprice'];?> </td>
          <td class="p4"> <?php echo $r['goodsnum'];?> </td>
          <td class="p5"> <? if($r['type']==1)echo "￥".$r['goodsprice']*$r['goodsnum'];else echo "[代发商品]" ?> </td>
  
  <?php if($key==0) { ?>
          <td rowspan="<? echo count($value) ?>" class="p6">￥<?php echo $s[$sname];?> </td>
  <?php } ?>
        </tr><? $i++ ?><?php } ?>
        <tr>
          <td colspan="8" class="sj"> 商家：<a target="_blank" href="<?php echo $r['sellerurl'];?>"><?php echo $r['goodsseller'];?></a><span>来自网站：<?php echo $r['goodssite'];?></span> </td>
        </tr>
      </tbody>
    </table>
<?php } ?>

    <div class="tixing"> 同一卖家系统默认只收取一次运费，但由于卖家运费设置、商品超重等问题，运费可能出现偏差；采取多退少补原则，届时客服人员会与您联系！ </div>
    <div class="payment">
      <div class="yuer">您当前人民币帐户余额：<b>￥<?php echo $_USERS['money'];?> </b><a target="_blank" href="<?php echo url("m.php?name=rmbaccount"); ?>">立即充值</a></div>
      <dl>
        <dt>所选商品总计<span>￥<?php echo $countdata['goodsmoney'];?></span>&nbsp;+&nbsp;运费总计<span>￥<?php echo $countdata['sendmoney'];?></span></dt>
        <dd> 您总共需要支付<span>￥<?php echo $countdata['totalmoney'];?></span></dd>
      </dl>
    </div>
    <div class="tijiao">
<?php if($_USERS['money'] < $countdata['totalmoney']) { ?>
      <p> 对不起！您的帐户余额不足请立即充值！</p>
<?php } ?>
      <a href="<?php echo url("shoppingcart.php"); ?>">返回购物车</a>
      <input type="submit" value="确认提交" class="ok" onmouseout="this.className='ok'" onmouseover="this.className='ok_'" <?php if($_USERS['money'] < $countdata['totalmoney']) { ?>disabled="disabled"<?php } ?> />
    </div>
  </div>
</div>
 </form>
<?php include template('footer'); ?>
</body>
</html>
