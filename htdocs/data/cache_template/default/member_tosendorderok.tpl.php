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
    
        <div class="circuit_3">
            <img alt="步骤" src="<?php echo TPL;?>images/donghua.gif">
        </div>
        
      <div class="o_wu_1">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="215" rowspan="3" align="center" valign="top"><img src="<?php echo TPL;?>images/welcome.jpg" width="98" height="78" /></td>
            <td width="485" align="left" class="lv"><b>恭喜您，您的运单已经提交成功！</b></td>
          </tr>
          <tr>
            <td align="left">本次您共支付了<span class="red"><b>￥<?php echo $totalfee;?></b></span></td>
          </tr>
          <tr>
            <td align="left">我们已经收到您的付款，我们将尽快处理您的订单！</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><span class="next mar_right">
            <input type="button" value="查看我的运单" onmouseout="this.className=''" onmouseover="this.className='by'" onclick="location.href='m.php?name=sendorderlist'" />
            </span>
            <div class="next mar_right">
              <input type="button" value="继续代购" onmouseout="this.className=''" onmouseover="this.className='by'" onclick="location.href='m.php?name=fillorders'" />
            </div>
              </td></tr>
        </table>
      </div>
    </div>
    
<div class="yj">
        </div>
    </div>
<?php include template('footer'); ?>

</body>
</html>
