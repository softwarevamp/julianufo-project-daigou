<?php defined('ZZQSS') or exit('Access Denied'); ?>        <div class="leftpan" style="border:1px #ccc solid;border-top:none;">
            <h2>
                购物</h2>
          <ul>
                <li id="fillorders"><a href="<?php echo url("m.php?name=fillorders"); ?>">
                    我要代购</a></li>
                <li><a href="<?php echo url("shoppingcart.php"); ?>">
                    我的购物车</a></li>
                <li id="favorite"><a href="<?php echo url("m.php?name=favorite"); ?>">
                    我的收藏夹</a></li>
       <li id="recommend"><a href="<?php echo url("m.php?name=recommend"); ?>">
                    我的推荐</a></li>
          </ul>
            <h2>
                送货</h2>
          <ul>
                <li id="orderlist"><a href="<?php echo url("m.php?name=orderlist"); ?>">
                    我的订单</a></li>
                <li id="sendorderlist"><a href="<?php echo url("m.php?name=sendorderlist"); ?>">
                    我的运单</a></li>
          </ul>
            <h2>
                帐户管理</h2>
          <ul>
                <li  id="rmbaccount"><a href="<?php echo url("m.php?name=rmbaccount"); ?>">
                    我的RMB帐户<span>[充值]</span></a></li>
                <li id="coupon"><a href="<?php echo url("m.php?name=coupon"); ?>">
                    我的优惠券</a></li>
                <li id="recordslist"><a href="<?php echo url("m.php?name=recordslist"); ?>">
                    消费记录</a></li>
                <li id="refundrecord"><a href="<?php echo url("m.php?name=refundrecord"); ?>">
                    退款记录</a></li>
                <li id="pm"><a href="<?php echo url("m.php?name=pm"); ?>">
                    我的信箱<span>(<?php echo $_USERS['pm'];?>)</span></a></li>
                <li id="myaddress"><a href="<?php echo url("m.php?name=myaddress"); ?>">
                    收货地址薄</a></li>
          </ul>
            <h2 style="display:none;">
                我的团购&nbsp;<img alt="我的团购" src="<?php echo TPL;?>images/new.gif"></h2>
          <ul style="display:none;">
                <li><a href="#">
                    我要开团</a></li>
                <li><a href="#">
                    我开的团</a></li>
                <li><a href="#">
                    我抱的团</a></li>
                <li><a href="#">
                    我关注的团</a></li>
          </ul>
            <h2>
                积分管理</h2>
          <ul>
                
                <li id="scorerecords"><a href="<?php echo url("m.php?name=scorerecords"); ?>">
                    我的积分</a></li>
          </ul>
            <h2>
                提问管理</h2>
          <ul>
                
                <li  id="guestbooklist"><a href="<?php echo url("m.php?name=guestbooklist"); ?>">
                    我的提问</a></li>
          </ul>		  
  
  
            <h2>
                个人信息管理</h2>
          <ul>
                
                <li id="edituserinfo"><a href="<?php echo url("m.php?name=edituserinfo"); ?>">
                    编辑个人档案</a></li>
                <li id="changepassword"><a href="<?php echo url("m.php?name=changepassword"); ?>">
                    修改密码</a></li>
                <li id="changeemail"><a href="<?php echo url("m.php?name=changeemail"); ?>">
                    修改Email地址</a></li>
          </ul>
      </div>
<script type="text/javascript"> 
//左边样式切换
$(function() {
    var b = document.location.search.substr(1);
    b = b.toLowerCase();
function GetValue(search,index)
{
try
{
var url = search;// document.location.search.substr(1);
var x = url.split("&");
var v = x[index].split("=")[1];
return v;
}
catch(e)
{
return "";
}
}
b = GetValue(b,0);
if(b!=""){
$("#"+b).addClass("xz");
}

});
</script>
