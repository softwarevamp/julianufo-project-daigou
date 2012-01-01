<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="<?php echo TPL;?>css/NewTopFoot.css" rel="Stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/AddItemPanel.css">
<link type="text/css" id="styleName" rel="stylesheet" href="<?php echo TPL;?>css/orange/color.css"/ > 
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/selectaddress.css">
    <script type="text/javascript" src="<?php echo TPL;?>js/jquery-1.4.1.min.js"></script>
    <script type="text/javascript" src="<?php echo TPL;?>js/jQuery.Extend.js"></script>
    <script src="<?php echo TPL;?>js/jQuery.Drag.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo TPL;?>js/jquery.cookies.2.1.0.min.js"></script>
    <script src="<?php echo TPL;?>js/Gobal.js" type="text/javascript"> </script>
    <script type="text/javascript" src="<?php echo TPL;?>js/wdggcGobal.js"></script>
    <script type="text/javascript" src="<?php echo TPL;?>js/Country.js"></script>

<link id="artDialogSkin" href="images/js/skin/aero/aero.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="images/js/artDialog.min.js"></script>


    <style type="text/css">
    #ad20100727{z-index:100;display:none;moz-opacity:0.56;opacity: 0.56; filter:alpha(opacity=56); height:40px;background:#fff url(<?php echo TPL;?>images/footlayer.jpg) repeat-x 0 0;position:fixed;_position:absolute;bottom:0;border-top:#5BB6D0 solid 2px;left:0;right:0;width:100%;}
.gg_close{width:15px;right:10px;margin:5px 0 -100px 0;background:url(<?php echo TPL;?>images/1000912.gif) no-repeat center 2px;height:15px;position:absolute;z-index:100;}
.gg_img{float:left;position:fixed;_position:absolute;bottom:0;background:;z-index:8;width:950px;height:40px;cursor:pointer;}
.gg_img span{height:40px;width:950px;display:block;}
.zd_hf{position:fixed;_position:absolute;margin-left:-475px;left:50%;height:40px;width:950px;bottom:0;z-index:110;display:none;}
    </style><title>
管理地址簿 -<?php echo $cfg_site_name;?>
</title></head>

<body>


    <form id="" action="" method="post" name="">

 <?php include template('header'); ?>
    
    <div class="admin">
        <div class="ding">
            <div class="shouye">
                <a href="<?php echo url("m.php"); ?>" title="我的会员中心"></a>
            </div>
            <div class="lb">
               <div class="weizhi">
                      <b>当前位置：</b><a href="<?php echo url("m.php"); ?>">会员中心</a><span>&gt;</span>管理地址簿
                  </div>
                
                <div class="shezhi">
                    <p>
                        <a href="<?php echo url("m.php"); ?>">我的会员中心</a><span>|</span>风格设置：</p>                   <ul>
                        <li onClick="changeStyle('orange')" class="mypanliS1"></li>
                        <li onClick="changeStyle('grey')" class="mypanliS2"></li>
                        <li onClick="changeStyle('blue')" class="mypanliS3"></li>
                    </ul>
                </div>
            </div>
        </div>

<?php include template('member_left'); ?>
        
        
        <div id="ListPanel" class="fill">
          <table width="700" class="sendr">
            <thead>
              <tr>
                <td></td>
              </tr>
              <tr>
                <td align="center"> 管理地址簿：
                  <input type="text" style="width: 200px;" value="" id="tbkey" />
                  &nbsp;
                  <input type="button" value="搜 索" class="inputblue" onclick="SeachMessage()" id="seach" />
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>

<table border="0" style="font-size: 12px; font-weight: normal;" class="kright">
                    <tbody>
                      <tr>
                        <th width="300" align="left"> 消息标题 </th>
                        <th width="200" align="left"> 消息状态 </th>
                        <th align="left"> 消息标题 </th>
 <th align="left"> 消息状态 </th>
                      </tr>
                      <tr>
                        <td colspan="4" align="left"></td>
                      </tr>
  <?php if(is_array($dataarray)) foreach($dataarray AS $r) { ?>
                      <tr  class="xia_b" style="height:25px">
                        <td align="left"  class="xia_b"><a onclick="art.dialog({title:'站内短信',id:'msgIframe', iframe:'m.php?name=pm&action=view&mid=<?php echo $r['mid'];?>'});" style="cursor: pointer; color: Green; font-weight: bold;"><?php echo $r['subject'];?></a></td>
                        <td align="left" class="xia_b"><?php echo date('Y-m-d H:i:s',$r['sendtime']);?></td>
                        <td align="left"  class="xia_b"><span style="color: Green;"><?php echo $r['hasviewname'];?></span></td>
 <td align="left"  class="xia_b"><span style="color: Green;"><a href="m.php?name=pm&action=del&mid=<?php echo $r['mid'];?>">取消</a></span></td>
                      </tr>
  <?php } ?>
  
                    </tbody>
                </table>
                    <div class="textr"> </div></td>
              </tr>
            </tbody>
          </table>
          <div class="address s2" id="addressA"></div>
      </div>
        
        <div class="yj">
      </div>
    </div>

    
<?php include template('footer'); ?>

    </form>
</body>
</html>