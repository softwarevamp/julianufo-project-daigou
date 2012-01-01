<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","sid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("sendorder","sid");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);

$evalue=$Table->getone($sid);

include_once(INC_PATH."/order.class.php");
$o=OrderClass::init();
$wherestr[]="uname='".$evalue['uname']."'";
$wherestr[]="sid = ".GetNum($sid);
if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
$dataarray=$o->getdata("",$wheresql,""); //获取团购数据	

$totalnum=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>发货清单</title>
</head>

<body>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center"><h3>发货清单</h3></td>
  </tr>
</table>

<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
  <tr>
    <td>用户名：<?php echo $evalue['uname'];?></td>
    <td>姓名：<?php echo $evalue['consignee'];?></td>
    <td>地址：<?php echo $evalue['address'];?></td>
    <td>邮编：<?php echo $evalue['zip'];?></td>
    <td>电话：<?php echo $evalue['tel'];?></td>
  </tr>
</table>
<br />
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="5%" align="center" bgcolor="#CCCCCC">序号</td>
    <td width="54%" align="center" bgcolor="#CCCCCC">商品名称</td>
    <td width="9%" align="center" bgcolor="#CCCCCC">订单ID</td>
    <td width="11%" align="center" bgcolor="#CCCCCC">来源商家</td>
    <td width="7%" align="center" bgcolor="#CCCCCC">单价</td>
    <td width="7%" align="center" bgcolor="#CCCCCC">数量</td>
    <td width="7%" align="center" bgcolor="#CCCCCC">总价</td>
  </tr>
  
  <?php foreach($dataarray as $k=>$r){?>
  <tr>
    <td align="center"><?php echo $k+1;?></td>
    <td><?php echo $r['goodsname'];?> </td>
    <td align="center"><?php echo $r['oid'];?></td>
    <td><?php echo $r['goodsseller'];?></td>
    <td><?php echo $r['goodsprice'];?></td>
    <td><?php echo $r['goodsnum'];?></td>
    <td><?php echo $r['goodsprice']*$r['goodsnum'];if($r['type']==2)echo '[代发]'?></td>
  </tr>
  <?php 
  $totalnum+=$r['goodsnum'];
  
  }?>

</table>
<br />
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
  <tr>
    <td align="right">总商品数量：<?php echo $totalnum?> 件&nbsp;&nbsp;&nbsp;&nbsp;运费：<?php echo $evalue['freight'];?>&nbsp;&nbsp;&nbsp;&nbsp;运送方式：<?php echo $evalue['deliveryname'];?></td>
  </tr>
</table>
</body>
</html>
