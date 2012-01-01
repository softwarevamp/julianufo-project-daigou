<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/AddItemPanel.css">
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css"  />
<link type="text/css" id="styleName" rel="stylesheet" href="<?php echo TPL;?>css/orange/color.css"/ >    
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/orderList.css"/>
<script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/wdggcGobal.js"></script>
 <script src="<?php echo TPL;?>js/Gobal.js" type="text/javascript"></script>

<title>提交运单 - <?php echo $cfg_site_name;?></title>
</head>

<body>

<?php include template('header'); ?>

<div class="admin">
        <div class="ding">
            <div class="shouye">
                <a title="我的会员中心" href="<?php echo url("m.php"); ?>"></a>
            </div>
            <div class="lb">
                <div class="weizhi">
                      <b>当前位置：</b><a href="<?php echo url("m.php"); ?>">会员中心</a><span>&gt;</span>选择运送方式
                  </div>
                
                <div class="shezhi">
                    <p>
                        <a href="<?php echo url("m.php"); ?>">我的会员中心</a><span>|</span>风格设置：</p>                    <ul>
                        <li onclick="changeStyle('orange')" class="mypanliS1"></li>
                        <li onclick="changeStyle('grey')" class="mypanliS2"></li>
                        <li onclick="changeStyle('blue')" class="mypanliS3"></li>
                    </ul>
                </div>
            </div>
        </div>

<?php include template('member_left'); ?>
<script type="text/javascript" src="<?php echo TPL;?>js/Country.js"></script>
<script>
var TOTALORDERMONEY="<?php echo $countmoney;?>";//订单总费用
var TOTALORDERWEIGHT="<?php echo $countweight;?>";//订单总总量
var USERMONEY="<?php echo $_USERS['money'];?>";//用户帐户余额
jQuery(function($) {
//地址显示隐藏
$("#showalladdress").click( function () {
$("#addresslist").toggle();
});
//优惠卷显示隐藏
$("#usecoupon").click( function () {
$("#couponlist").toggle();
var cid = $("input[name='couponid']:checked").val();
if($("#usecoupon").attr("checked")){
$("#couponfee").html($("#coupon_"+cid).val());
countallfee();
}else{
$("#couponfee").html(0);
countallfee();
}
});
$(".areaselect").click( function () {
var area_id = $("input[name='area']:checked").val();
buildlist(area_id);
countallfee();

});
$("input[name='couponid']").click( function () {
var cid = $("input[name='couponid']:checked").val();
$("#couponfee").html($("#coupon_"+cid).val());

countallfee();
});

$("input[name='selectaddress']").click( function () {
var aid = $("input[name='selectaddress']:checked").val();
selectaddress(aid);
});
var selectaddress =function(aid) {

var consignee = $("#address_"+aid+"_consignee").val();
var country = $("#address_"+aid+"_country").val();
var city = $("#address_"+aid+"_city").val();
var zip = $("#address_"+aid+"_zip").val();
var tel = $("#address_"+aid+"_tel").val();
var address = $("#address_"+aid+"_address").val();

var countrystr = '<select name=\'country\'>' + COUNTRY.ToSelect(country) + '</select>';

$("#consignee").val(consignee);
$("#city").val(city);
$("#countrystr").html(countrystr);
$("#zip").val(zip);
$("#tel").val(tel);
$("#address").val(address);

}
var countallfee = function() {
var serverfee=parseFloat($("#serverfee").html());//服务费
var freight=parseFloat($("#freight").html());//运费
var couponfee=parseFloat($("#couponfee").html());//抵扣服务费
if(couponfee > serverfee){
couponfee=serverfee;//只能抵扣服务费
$("#couponfee").html(serverfee);
}
alltotalfee=serverfee+freight-couponfee;
$("#totalfee").html(alltotalfee.toFixed(2));
$("#totalfee2").html(alltotalfee.toFixed(2));
}
var deliverylist;
//运送方式列表显示
var totalweight=parseFloat($("#totalweight").html());//总重量
var listHtml = $("#deliverylist");
var buildlist = function(aid) {
var tempfee=0;
var serverfee=parseFloat($("#areaserverfee_"+aid).val());
var freight=parseFloat($("#freight").html());//运费
var serverfeepct=parseFloat($("#areaserverfeepct_"+aid).val());

if(serverfeepct){
tempfee=parseFloat(parseFloat(TOTALORDERMONEY)+freight)*serverfeepct;

if(tempfee>serverfee)tempfee=serverfee;
}else{
tempfee=serverfee;
}
tempfee=tempfee*<? if($_USERS['utype']==1)echo $cfg_vip_sendfee1;elseif($_USERS['utype']==2)echo $cfg_vip_sendfee2;elseif($_USERS['utype']==3)echo $cfg_vip_sendfee3;else echo 1; ?>;//计算服务费不同会员等级折扣
$("#serverfee").html(tempfee.toFixed(2));//设置服务费
 $.ajax({
type: "POST",
url: "/ajax/sendorder_ajax.php?action=getdelivery",
dataType: "json",
contentType: "application/json;utf-8",
data: "{'aid':'" + aid + "'}",
timeout: 15000,
error: function() { alert("加载信息出错，请稍后再试"); return false;},
success: function(res) {
var deliverylist = res;

                if (deliverylist.length > 0) {
                    listHtml.empty();
                    $.each(deliverylist,
                    function(index, item) {
                        var button = $('<input name="did" type="radio" id="did" value="'+item.did+'" />').click(function() {
//处理计算运费

var deliveryfee =0 ;
//计算运费

if(totalweight < parseFloat(item.first_weight))
{
deliveryfee=parseFloat(item.first_fee)+parseFloat(item.customs_fee);
}else{
deliveryfee=parseFloat(item.first_fee)+Math.ceil((totalweight-parseFloat(item.first_weight))/parseFloat(item.continue_weight))*parseFloat(item.continue_fee)+parseFloat(item.customs_fee);
}
$("#freight").html(deliveryfee);
$("#totalsendfee").html(deliveryfee);

var tempfee=0;
var serverfee=parseFloat($("#areaserverfee_"+aid).val());
var freight=parseFloat($("#freight").html());//运费
var serverfeepct=parseFloat($("#areaserverfeepct_"+aid).val());

if(serverfeepct){
tempfee=parseFloat(parseFloat(TOTALORDERMONEY)+freight)*serverfeepct;

if(tempfee>serverfee)tempfee=serverfee;
}else{
tempfee=serverfee;
}
tempfee=tempfee*<? if($_USERS['utype']==1)echo $cfg_vip_sendfee1;elseif($_USERS['utype']==2)echo $cfg_vip_sendfee2;elseif($_USERS['utype']==3)echo $cfg_vip_sendfee3;else echo 1; ?>;//计算服务费不同会员等级折扣
$("#serverfee").html(tempfee.toFixed(2));//设置服务费

countallfee();
                        });
                        var tr = $('<tr><td class="ww1" width=115 align="left">' + item.deliveryname + '</td><td width=93 align="center">' +item.areaname+'</td><td  width=131 align="center">' + item.first_fee +'<span class="hui">（'+item.first_weight+'克）'+ '</td><td width=238 align="center">' + item.continue_fee +'<span class="hui">（每续重'+item.continue_weight+'克或其零数）'+ '</td><td width=123 align="center">' + item.customs_fee + '</td></tr>');
                        $(".ww1", tr).prepend(button);
                        listHtml.append(tr);
                    });
                    $("#loading").hide();
                    listHtml.show();
countallfee();
                }else{
alert('暂无当前地区运送方式');
listHtml.empty();
listHtml.hide();
countallfee();
}
}
});
};
buildlist(1);//初始化运送方式列表
$("input[name='area']").val(["1"]);

});
//提交校验
function submitTosendorder() {
if($("input[name='area']:checked").length!=1){ alert("运送区域必须选择!"); return false; }
if($("input[name='did']:checked").length!=1){ alert("运送方式必须选择!"); return false; }
if($.trim($("#consignee").val())==""){ alert("收货人姓名不能为空!"); return false; }
if($.trim($("#zip").val())==""){ alert("邮政编码不能为空!"); return false; }
if($.trim($("#tel").val())==""){ alert("收货人电话不能为空!"); return false; }
if($.trim($("#address").val())==""){ alert("详细地址不能为空!"); return false; }
if($('select[name="country"]').val()==0){ alert("国家必须选择!"); return false; }
if(parseFloat(USERMONEY)<parseFloat($("#totalfee").html())){ alert("您的帐户余额不足完成本次支付，请充值后再提交!"); return false; }

if (!confirm("您确定要提交此运单吗？")) return false;
return true;

}
</script>

<form method="post" action="<?php echo url("m.php?name=tosendorder"); ?>" enctype="multipart/form-data" name="form" onSubmit="return  submitTosendorder()">

<input type="hidden" name="action" value="save"/>
<input type="hidden" name="oids" value="<?php echo $ids;?>"/>
<input type="hidden" name="LOCKDATA" value="<?php echo $LOCKDATA;?>"/>


    <div class="fill">
        <div class="circuit_3">
            <img alt="步骤" src="<?php echo TPL;?>images/donghua.gif">
        </div>
     
<div class="o_wu">
<div class="hg bg"><h1>提交产品列表</h1><h3><a href="###" id=""></a></h3></div>
        <div class="add_text" id="" style="">
        <ul>
<?php if(is_array($dataarray)) foreach($dataarray AS $key => $r) { ?>
          <li><? echo $key+1; ?>、<a href="<?php echo $r['goodsurl'];?>" target="_blank"><?php echo $r['goodsname'];?></a>，价格:<?php echo $r['goodsprice'];?>，购买数量:<?php echo $r['goodsnum'];?></li>
<?php } ?>

  <li>产品总价：  <font color=red>￥<?php echo $countmoney;?></font> &nbsp;&nbsp;&nbsp;&nbsp;总重量：<?php echo $countweight;?>g</li>
        </ul>          
        </div>	

</div>
 
      <div class="o_wu">
      <div class="hg bg"><h1>确认收货地址</h1><h3><a href="###" id="showalladdress">显示全部地址</a></h3></div>
        <div class="add_text" id="addresslist" style="display:none">
        <ul>

<?php if(is_array($addressarray)) foreach($addressarray AS $r) { ?>
          <li><input name="selectaddress" type="radio" id="selectaddress" value="<?php echo $r['aid'];?>" <?php if($r['def']==1) { ?>checked="checked"<?php } ?>/>
          <?php echo $r['consignee'];?>,<?php echo $r['country'];?>,<?php echo $r['city'];?>,<?php echo $r['zip'];?>,<?php echo $r['tel'];?>,<?php echo $r['address'];?>
  
  <input name="address_<?php echo $r['aid'];?>_consignee" type="hidden" id="address_<?php echo $r['aid'];?>_consignee" value="<?php echo $r['consignee'];?>" />
  <input name="address_<?php echo $r['aid'];?>_country" type="hidden" id="address_<?php echo $r['aid'];?>_country" value="<?php echo $r['country'];?>" />
  <input name="address_<?php echo $r['aid'];?>_city" type="hidden" id="address_<?php echo $r['aid'];?>_city" value="<?php echo $r['city'];?>" />
  <input name="address_<?php echo $r['aid'];?>_zip" type="hidden" id="address_<?php echo $r['aid'];?>_zip" value="<?php echo $r['zip'];?>" />
  <input name="address_<?php echo $r['aid'];?>_tel" type="hidden" id="address_<?php echo $r['aid'];?>_tel" value="<?php echo $r['tel'];?>" />
  <input name="address_<?php echo $r['aid'];?>_address" type="hidden" id="address_<?php echo $r['aid'];?>_address" value="<?php echo $r['address'];?>" />
  
  </li>
<?php } ?>
<li><input name="selectaddress" type="radio" id="selectaddress" value="9999999" <?php if(empty($addressarray)) { ?>checked="checked"<?php } ?>/> 重新填写收货信息
  <input name="address_9999999_consignee" type="hidden" id="address_9999999_consignee" value="" />
  <input name="address_9999999_country" type="hidden" id="address_9999999_country" value="0" />
  <input name="address_9999999_city" type="hidden" id="address_9999999_city" value="" />
  <input name="address_9999999_zip" type="hidden" id="address_9999999_zip" value="" />
  <input name="address_9999999_tel" type="hidden" id="address_9999999_tel" value="" />
  <input name="address_9999999_address" type="hidden" id="address_9999999_address" value="" />		
</li>
        </ul>          
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td width="152" align="right" class="pad_r_10 o_wu_line_30">收货人姓名：</td>
    <td width="548" class="o_wu_line_30">
<input name="consignee" type="input" class="input" id="consignee" value="<?php echo $addressarray['0']['consignee'];?>" maxlength="20" />
</td>
  </tr>
  <tr>
    <td align="right" class="pad_r_10 o_wu_line_30">收货人电话：</td>
    <td class="o_wu_line_30">
<input name="tel" type="input" class="input" id="tel"  value="<?php echo $addressarray['0']['tel'];?>" maxlength="20" /></td>
  </tr>
  <tr>
    <td align="right" class="pad_r_10 o_wu_line_30">国家：</td>
    <td class="o_wu_line_30" id="countrystr">


<script>
document.write('<select name=\'country\'>' + COUNTRY.ToSelect('<?php echo $addressarray['0']['country'];?>') + '</select>');
</script>
    </td>
  </tr>
  <tr>
    <td align="right" class="pad_r_10 o_wu_line_30">城市：</td>
    <td class="o_wu_line_30"><input type="input" value="<?php echo $addressarray['0']['city'];?>"  maxlength="20" id="city" name="city" class="input" /></td>
  </tr>
  <tr>
    <td align="right" class="pad_r_10 o_wu_line_30">详细地址：</td>
    <td class="o_wu_line_30"><input type="input" value="<?php echo $addressarray['0']['address'];?>"  maxlength="20" id="address" name="address" class="input" /></td>
  </tr>
  <tr>
    <td align="right" class="pad_r_10 o_wu_line_30">邮政编码：</td>
    <td class="o_wu_line_30"><input type="input" value="<?php echo $addressarray['0']['zip'];?>"  maxlength="20" id="zip" name="zip" class="input" /></td>
  </tr>
  <tr>
    <td align="right" valign="middle" class="pad_r_10 o_wu_line_30">运送区域：</td>
      <td rowspan="2">
       <ul class="gj">
<?php if(is_array($areaarray)) foreach($areaarray AS $r) { ?>
         <li>
 <input name="area" class="areaselect"  type="radio" value="<?php echo $r['aid'];?>" />
 <input name="areaserverfee_<?php echo $r['aid'];?>" id="areaserverfee_<?php echo $r['aid'];?>"  type="hidden" value="<?php echo $r['serverfee'];?>" />
 <input name="areaserverfeepct_<?php echo $r['aid'];?>" id="areaserverfeepct_<?php echo $r['aid'];?>"  type="hidden" value="<?php echo $r['serverfeepct'];?>" />
 </li>
         <li><?php echo $r['name_cn'];?></li>
<?php } ?>
   
       </ul>
      </td>
  </tr>
  <tr>
    <td align="right" class="pad_r_10">&nbsp;</td>
    </tr>
  <tr>
    <td align="right" class="pad_r_10">特殊说明：</td>
    <td><span class="lv">
      <textarea name="remark" id="remark"  class="textarea"></textarea>
    </span></td>
  </tr>
</table>
     </div>
      <div class="o_wu">
        <div class="tab_s">
          <h1 class="hg lv">运送方式及费用</h1>
        </div>
        <div class="tab_s">
        <table>
        <tr class="hg bg lan_14">
            <td align="center" width="115" valign="middle">运送方式</td>
            <td align="center" width="93" valign="bottom">寄达地区</td>
            <td align="center" width="131" valign="bottom">起重<span class="red">（元）</span></td>
            <td align="center" width="238" valign="bottom">续重<span class="red">（元）</span></td>
            <td align="center" width="123" valign="bottom">报关费<span class="red">（元）</span></td>
          </tr>
          </table>
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="deliverylist">
            <tr><td>&nbsp;

</td></tr>			

      </table>
<div style="text-align: center; padding: 70px 0;" id="loading">
<img src="<?php echo TPL;?>images/loading.gif" alt="loading..." />
<p style="color: #ccc; padding-top: 10px;">
数据加载中...</p>
</div>
      <div class="tab_s1 font_14">您的包裹重量约为：<span class="red"><b><span id="totalweight"><?php echo $countweight;?></span>g</b></span>，选择当前运送方式的运费为：<span class="red"><b><span id="totalsendfee">0.00</span>元</b></span>      </div>
      </div>
  
  <?php if(!empty($couponarray)) { ?>
      <div class="o_wu" style="display:block">
        <div class="hg lv">
          <div class="lanrentuku1">
          <div class="lanrentuku2">
          <div class="lanrentuku3">
            <input type="checkbox" name="usecoupon" id="usecoupon" value="1"/>
            </div>
            </div>
          </div>
          <h1 class="lv">使用优惠券</h1>
        </div>
        <table width="700%" border="0" cellspacing="0" cellpadding="0" id="couponlist" style="display:none">
          <tr class="hg bg lan_14">
            <td width="207" align="center" valign="middle">优惠卷编号</td>
            <td width="131" align="center" valign="bottom">面额<span class="red">（元）</span></td>
            <td width="238" align="center" valign="bottom">有效期</td>
            <td width="123" align="center" valign="bottom">获得途径径</td>
          </tr>
  <?php if(is_array($couponarray)) foreach($couponarray AS $r) { ?>
          <tr>
            <td align="left">
  <input name="coupon_<?php echo $r['cid'];?>" type="hidden" id="coupon_<?php echo $r['cid'];?>" value="<?php echo $r['money'];?>" />
              <input name="couponid" type="radio" id="couponid" value="<?php echo $r['cid'];?>" /> <?php echo $r['sn'];?>
            </td>
            <td align="center"><font color=red>￥<?php echo $r['money'];?></font></td>
            <td align="center"><?php echo date('Y-m-d',$r['endtime']);?></td>
            <td align="center"><?php echo $r['getwayname'];?></td>
          </tr>
  <?php } ?>

  
          <tr class="font_14">
            <td colspan="5" align="right" valign="bottom">&nbsp;</td>
          </tr>
        </table>
      </div>
  <?php } ?>
  
  
      <div class="o_wu">
        <div class="hg lv">
          <h1 class="lv">结算信息</h1>
        </div>
        <table width="700" border="0" cellspacing="0" cellpadding="0">
      
          <tr class="yellow_bg bai font_14">
            <td width="142" align="center">服务费</td>
            <td width="284" align="center">运输费</td>

            <td width="128" align="center">抵扣服务费</td>
            <td width="146" align="center">应付金额</td>
          </tr>
          <tr>
            <td width="142" align="center" valign="top">+<span id="serverfee">0.00</span>元</td>
            <td width="284" align="center" valign="top">+<span id="freight">0.00</span>元</td>

            <td width="128" align="center" valign="top">-<span id="couponfee">0.00</span>元</td>
            <td width="146" align="center" valign="top"><span id="totalfee">0.00</span>元</td>
          </tr>

          <tr class="font_14">
            <td colspan="3" align="left" valign="bottom">本次运单的费用为：<span class="red"><b>&yen;<span id="totalfee2">0.00</span>元</b></span>，您可以确认收货信息与运送方式后，点此提交运单</td>
            <td width="146" align="center" valign="bottom"><div class="next">
              <input type="submit" value="提交运单并结算" onmouseout="this.className=''" onmouseover="this.className='by'" />
            </div></td>
          </tr>
        </table>
      </div>
    </div>
</form>
<div class="yj">
        </div>
    </div>

    
<?php include template('footer'); ?>

</body>
</html>
