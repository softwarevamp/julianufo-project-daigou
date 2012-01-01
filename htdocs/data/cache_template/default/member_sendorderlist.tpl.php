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
    <script type="text/javascript">
        function cancel(id) {
            if (!confirm("您确定要取消此运单吗？")) { return; }
            $.ajax({
                type: "POST",
                url: "/m.php?name=sendorderlist&action=cancel",
                dataType: "json",
                contentType: "application/json;utf-8",
                data: "{'id':'" + id + "'}",
                timeout: 10000,
                error: function() { alert('网络错误，请稍后再试'); },
                success: function(r) {
                    switch (r) {
                        case "OK": alert("取消成功"); $("#sendordertable_" + id).remove(); if ($(".o_wu table").length <= 1) { window.location = window.location.href } break;
                        default: alert(r);
                    }
                }
            });
        }
        function receive(id, dom) {
            if (!confirm("您确定收到包裹了吗？")) { return; }
            $(dom).attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "/m.php?name=sendorderlist&action=receive",
                dataType: "json",
                contentType: "application/json;utf-8",
                data: "{'id':'" + id + "'}",
                timeout: 10000,
                error: function() { alert('网络错误，请稍后再试'); $(dom).removeAttr("disabled"); },
                success: function(r) { $(dom).removeAttr("disabled"); if (r == "OK") { alert("确认成功");  window.location = window.location.href} }

               // success: function(r) { $(dom).removeAttr("disabled"); if (parseInt(r.d) > 0) { $("#score").text(r.d); $("#vlink").attr("href", "/mypanli/OrderVote.aspx?orderID=" + id); $("#success,.addpanel_overlay").show(); dom.onclick = function() { return true; }; $(dom).unbind("click").text("前往评价").attr("href", "/mypanli/OrderVote.aspx?orderID=" + id); } }				

            });
        }
 
 
 var remarkPanel = "<div class=\"beizhu\"><div style=\"width: 270px; overflow: hidden; float: left;\"><div class=\"if\"><label id=\"noremarkLb\"><input id=\"noremark\" type=\"checkbox\" />无特殊运单评价说明，请勾选此项</label></div><textarea id=\"remarkContent\" cols=\"\" rows=\"\"></textarea><dl><dt><input id=\"remarkSubmit\" type=\"button\" value=\"提交\" /></dt><dd><input id=\"remarkClose\" type=\"button\" onclick=\"closeRemarkPanel();\" value=\"关闭\" /></dd></dl></div><img src=\"/images/jiantou.gif\" /></div>";
 
 function showRemarkPanel(id, type, dom) {
    $(".beizhu").remove(); $(dom).before(remarkPanel); $("#remarkContent").val($("#remark" + id).val()); if (type) { $("#noremark").click(function() { if (this.checked) { $("#remarkContent").attr("disabled", "disabled").val("我对服务满意!"); } else { $("#remarkContent").removeAttr("disabled").val($("#remark" + id).val()); } }); $("#remarkSubmit").click(function() { upRemark(id, $.trim($("#remarkContent").val())); }); } else { $("#remarkContent").attr("disabled", "disabled").css({ background: "#eeeeee", color: "#bbbbbb", border: "#bbbbbb solid 1px" }); $("#noremarkLb").css({ color: "#bbbbbb" }); $("#noremarkLb input").attr("disabled", "disabled"); $("#remarkSubmit").remove(); }
    $(".beizhu").animate({ width: "282px", marginLeft: "-244px" }, 300, function() { });
}
 
function closeRemarkPanel() { if ($(".beizhu").length > 0) { $(".beizhu").animate({ width: "0", marginLeft: "-2px" }, 300, function() { $(this).remove(); }); } }
 
 function upRemark(id, content) {
    $.ajax({ type: "POST",
        url: "/m.php?name=sendorderlist&action=upcomment",
        dataType: "json",
        contentType: "application/json;utf-8",
        data: "{'comment':'" + content + "','sid':" + id + "}",
        timeout: 6000,
        error: function() {
            alert("修改评价失败！");
        },
        success: function(resault) {
            if (resault == 'OK') {
                closeRemarkPanel();
                $("#remark" + id).val(content);
                alert("运单评价成功！");
            }
            else{
                alert(resault);
            }
        }
    });
}
 
 
 
 
        $(function() {
            if (typeof document.body.style.maxHeight == "undefined") {
                $("#success").css("position", "absolute").css("margin-top", "0px");
                var divY = (getViewportHeight() - $("#ProVotePanel").outerHeight()) / 2;
                $("#success").css("top", (divY + document.documentElement.scrollTop).toString());
                $(window).scroll(function() { $("#success").css("top", divY + document.documentElement.scrollTop + ""); });
            }
 
        });
    </script>

<title>我的运单-<?php echo $cfg_site_name;?></title>
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
                      <b>当前位置：</b><a href="<?php echo url("m.php"); ?>">会员中心</a><span>&gt;</span>我要代购
                  </div>
                
                <div class="shezhi">
                    <p>
                        <a href="<?php echo url("m.php"); ?>">我的会员中心</a><span>|</span>风格设置：</p>
                    <ul>
                        <li onclick="changeStyle('orange')" class="mypanliS1"></li>
                        <li onclick="changeStyle('grey')" class="mypanliS2"></li>
                        <li onclick="changeStyle('blue')" class="mypanliS3"></li>
                    </ul>
                </div>
            </div>
        </div>

<?php include template('member_left'); ?>
    <div class="fill">
        <div class="circuit">
            <img alt="步骤" src="<?php echo TPL;?>images/donghua.gif">
        </div>
        <div class="o_wu" style="margin-top:20px">
<?php if(!empty($dataarray)) { ?>
<?php if(is_array($dataarray)) foreach($dataarray AS $r) { ?>
          <table border="0" cellpadding="0" cellspacing="0" id="sendordertable_<?php echo $r['sid'];?>" style="margin-top:10px">
            <tr class="bg hg">
                <td align="center" class="bk">运单号</td>
              <td align="center" class="bk">提交时间</td>
              <td align="center" class="bk">收货人</td>
              <td align="center" class="bk">运送方式</td>
              <td align="center" class="bk">包裹号<img src="<?php echo TPL;?>images/wen.gif" width="16" height="16" hspace="2" align="baseline" /></td>
              <td align="center" class="bk">运单状态</td>
              <td align="center" class="bk">操作</td>
            </tr>
            <tr class="bk hg">
                <td width="120" align="center" class="bk_top lan_font"><a title="点击查看运单商品列表" href="<?php echo url("m.php?name=orderlist&action=sendorder&sid=$r[sid]"); ?>" target="_blank"><?php echo $r['sid'];?></a></td>
                <td width="80" align="center" class="bk_top"><?php echo date('Y-m-d',$r['addtime']);?></td>
              <td width="80" align="center" class="bk_top"><?php echo $r['consignee'];?></td>
              <td width="80" align="center" class="bk_top"><?php echo $r['deliveryname'];?></td>
              <td width="80" align="center" class="bk_top"><?php echo $r['sn'];?>&nbsp;</td>
              <td width="80" align="center" class="bk_top"><?php echo $r['statename'];?></td>
              <td align="center" class="bk_top">
  <input id="remark<?php echo $r['sid'];?>" type="hidden" value="<?php echo $r['reply'];?>"/>

  <?php if($r['state']==1) { ?>
  <span class="cx marr_1"><a href="javascript:;" onclick="cancel(<?php echo $r['sid'];?>)">撤销此单</a></span>
  <?php } elseif ($r['state']==3) { ?>
<?php if(empty($r['commenttime'])) { ?>
<span class="cx marr_1"><a href="javascript:;" onclick="showRemarkPanel(<?php echo $r['sid'];?>, 1, this)">运单评价</a></span>
<?php } else { ?>
<?php if(!empty($r['reply'])) { ?>
<span class="cx marr_1"><a href="javascript:;" onclick="showRemarkPanel(<?php echo $r['sid'];?>, 0, this)">查看回复</a></span>
<?php } else { ?>
运单已评价
<?php } ?>
<?php } ?>
  <?php } else { ?>
  &nbsp;<span class="cx_2 marr_2"><a href="javascript:;" onclick="receive(<?php echo $r['sid'];?>)">确认收货</a></span>
  <?php } ?>
  
  </td>
            </tr>
            </table>
<?php } ?>	

<?php } else { ?>
<H2>您还没有提交运单噢~去看看我的送货车中是不是有可以提交运送的宝贝呢……</H2>
<P><A href="<?php echo url("m.php?name=orderlist"); ?>">我的送货车</A><SPAN>|</SPAN><A href="<?php echo url("m.php?name=fillorders"); ?>">我要代购</A><SPAN>|</SPAN><A href="<?php echo url("see.php"); ?>/See/">随便逛逛</A></P> 
  	
<?php } ?>

      </div>
  
       
    </div>

        <div class="yj">
        </div>
    </div>

    
<?php include template('footer'); ?>
</body>
</html>
