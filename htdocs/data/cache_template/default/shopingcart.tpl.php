<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css"  />
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/ShoppingCart.css"/>
<script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/ShoppingCart.js"></script>
<title>我的购物车-<?php echo $cfg_site_name;?></title>
</head>
<body>
<?php include template('header'); ?>
<form id="form1" action="payconfirm.php" onsubmit="return thisPage.submitCheck();" method="post">

<div class="main">
<div class="center" id="pagemain">
  <div class="weizhi"> <a style="float: right; margin-right: 35px;" href="<?php echo url("m.php"); ?>">进入用户中心</a> <b>当前位置：</b><a href="/">首页</a><span>&gt;</span>我的购物车</div>
<?php if(!empty($temparray)) { ?>

  <div class="bt">
    <ul>
      <li class="w1">已挑选的商品名称</li>
      <li class="w2">价格</li>
      <li class="w3">购买数量</li>
      <li class="w4">!total!</li>
      <li class="w5">
        <div id="yunfei" class="yunfei">
          <p> 同一订单中相同卖家的商品，只收一次运费!</p>
          <button onclick="$('#yunfei').hide();return false;"> </button>
        </div>
        <span>国内运费</span><a onclick="$('#yunfei').show();" href="javascript:;"></a></li>
      <li class="w6">备注</li>
    </ul>
  </div>
  <div id="shoppingCartProduct" class="product">
  <?php if(is_array($temparray)) foreach($temparray AS $sname => $value) { ?>
    <table>
      <tbody>
   <?php if(is_array($value)) foreach($value AS $key => $r) { ?>
        <tr id="li<?php echo $r['gid'];?>">
          <td class="b1"><input type="checkbox" checked="checked" value="<?php echo $r['gid'];?>" onclick="thisPage.accountAll()" name="gids[]">
          </td>
          <td class="b2"><a target="_blank" href="<?php echo $r['goodsurl'];?>"><img onerror="this.src='<?php echo TPL;?>images/noimg80.gif'" src="<?php echo $r['goodsimg'];?>"></a></td>
          <td class="b3"><p><a target="_blank" href="<?php echo $r['goodsurl'];?>"><?php echo $r['goodsname'];?></a></p></td>
          <td class="b4">￥<?php echo $r['goodsprice'];?></td>
          <td class="b5">
            <input type="text" value="<?php echo $r['goodsnum'];?>" onkeyup="value=value.replace(/[^\d]/g,'')" onblur="thisPage.updateNum(<?php echo $r['gid'];?>,this.value)" maxlength="4">
          </td>
          <td class="b6"><span><? if($r['type']==1)echo "￥".$r['goodsprice']*$r['goodsnum'];else echo "[代发商品]" ?></span> </td>
  <?php if($key==0) { ?>
          <td rowspan="<? echo count($value) ?>" class="b7" id="sj0">￥<?php echo $s[$sname];?> </td>
  <?php } ?>
  <td class="b8"><a title="<?php echo $r['goodsremark'];?>" onclick="thisPage.showRemarkPanel(<?php echo $r['gid'];?>,false,this,'<?php echo $r['goodsremark'];?>')" onmouseover="thisPage.showRemarkPanel(<?php echo $r['gid'];?>,true,this,'<?php echo $r['goodsremark'];?>')" onmouseout="thisPage.cleartoID(thisPage.toID);if($('.beizhu').length&gt;0)thisPage.outID.push(setTimeout(function() {thisPage.closeRemarkPanel();}, 500));" class="orange">添加备注</a> </td>
        </tr>
<?php } ?>
        <tr>
          <td colspan="8" class="sj">商家：<a target="_blank" title="<?php echo $r['goodsseller'];?>" href="<?php echo $r['sellerurl'];?>"><?php echo $r['goodsseller'];?></a><span>来源网站：<?php echo $r['goodssite'];?></span></td>
        </tr>
      </tbody>
    </table>
<?php } ?>


    <div class="jisuan">
      <ul>
        <li><a onclick="$('input[type=checkbox]').attr('checked',true);thisPage.accountAll();" href="javascript:;"> 全部</a><span>-</span><a id="reSelete" onclick="$('input[type=checkbox]').each(function(){this.checked=!this.checked;});thisPage.accountAll();" href="javascript:;">反选</a></li>
        <li>
          <input type="button" onclick="thisPage.del(this)" onmouseout="this.className='sc'" onmouseover="this.className='sc_'" value="删除" class="sc">
          <input type="button" onmouseout="this.className='tj'" onmouseover="this.className='tj_'" value="添加至收藏夹" onclick="thisPage.addToFavorites(this);" class="tj">
        </li>
      </ul>
      <dl>
        <dt>所选商品总计<span id="totalProPrice">￥<?php echo $countdata['goodsmoney'];?></span>&nbsp;+&nbsp;运费总计<span id="totalFreight">￥<?php echo $countdata['sendmoney'];?></span></dt>
        <dd> 您总共需要支付<span id="totalPrice">￥<?php echo $countdata['totalmoney'];?></span></dd>
      </dl>
    </div>
    <div class="next">
      <p> <a target="_blank" href="<?php echo url("m.php?name=favorite"); ?>">去我的收藏夹</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo url("m.php?name=fillorders"); ?>">继续填写代购单</a></p>
      <input type="submit" onmouseout="this.className='in'" onmouseover="this.className='in_'" value="提交代购" class="in">
    </div>
  </div>
  <?php } else { ?>
  
  
  <div class="nought">
              <h2>
                  您的购物车还是空的哦，快去提交代购商品吧！</h2>
              <p>
                  猜您接下来会：<a href="<?php echo url("m.php?name=fillorders"); ?>">立即填写代购单</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo url("see.php"); ?>">随便逛逛</a></p>
              <div>
                    温馨提示：购物车是空的？可能是还没登录哦！<a href="<?php echo url("user.php?action=login"); ?>">立即登录</a></div>
              
  </div>
  <?php } ?>
  
  
</div>
</div>
</form>

<?php include template('footer'); ?>
</body>
</html>
