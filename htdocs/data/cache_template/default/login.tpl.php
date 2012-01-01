<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>用户登陆 - <?php echo $cfg_site_name;?></title>
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/login.css">

<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css"  />
<script src="<?php echo TPL;?>js/Gobal.js" type="text/javascript"></script>
</head>
<body>

<?php include template('header'); ?>

<div class="main">
<form name="login" method="post" action="<?php echo url("user.php?action=login"); ?>">
<input type="hidden" size="20" value="login" id="act" name="act">
<input name="commit" type="hidden" value="提交"/>
    <div class="main_other1">
    	
        <table height="352" cellspacing="0" cellpadding="0" border="0" align="center" width="95%">
          
          <tbody><tr>
            <td width="57%" valign="bottom" style="background: transparent url(<?php echo TPL;?>images/loginmain.jpg) no-repeat scroll right center; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous;"><table height="148" cellspacing="0" cellpadding="0" border="0" align="right" width="97%">
              <tbody><tr>
                <td height="37">&nbsp;</td>
              </tr>

            </tbody></table>              </td>
            <td height="333" width="43%" valign="middle"><div align="left">
              <table cellspacing="0" cellpadding="10" border="0" align="center" width="444">
                <tbody><tr>
                  <td width="424"><div class="input_f">
                      <table cellspacing="1" cellpadding="5"  border="0" width="92%">
                        <tbody>
<tr>
                          <td colspan="2"><strong><img height="35" align="absmiddle" width="35" src="<?php echo TPL;?>images/logint.gif"> 登陆<?php echo $cfg_site_name;?></strong></td>
                        </tr>
                        <tr height="30px">
                          <td width="30%"><div align="right">用户名：</div></td>
                          <td width="70%"><input type="text" value="" size="28" onfocus="this.className='buy_ipt2'" onblur="this.className='buy_ipt1';" onmouseout="this.className='buy_ipt1';" onmouseover="this.className='buy_ipt2';" id="u_userName" class="buy_ipt1" name="userName"></td>
                        </tr>
                        <tr height="30px">
                          <td><div align="right">密码：</div></td>
                          <td><input type="password" value="" size="28" onfocus="this.className='buy_ipt2'" onblur="this.className='buy_ipt1';" onmouseout="this.className='buy_ipt1';" onmouseover="this.className='buy_ipt2';" id="u_userPw" class="buy_ipt1" name="password"></td>
                        </tr>
                        <tr height="30px">
                          <td width="30%"><div align="right">验证码：</div></td>
                          <td><input type="text" size="8" onfocus="this.className='buy_ipt2'" onblur="this.className='buy_ipt1';" onmouseout="this.className='buy_ipt1';" onmouseover="this.className='buy_ipt2';" id="gd_code" class="buy_ipt1" name="code">
                              <img align="absmiddle" onclick="var now=new Date();this.src='includes/code/securimage_show.php?sid=<? echo md5(time()); ?>&amp;w=92&amp;h=30&amp;t='+Math.random();" style="cursor: pointer;" src="includes/code/securimage_show.php?sid=<? echo md5(time()); ?>&amp;w=92&amp;h=30&amp;t='+Math.random();"> </td>
                        </tr>
                        <tr height="30px">
                          <td width="30%">&nbsp;</td>
                          <td><div style="position: relative;"><a href="<?php echo url("user.php?action=resetp"); ?>"></a>
                                <label onmouseout="document.getElementById('autoLoginDiv').style.display='none'" onmouseover="document.getElementById('autoLoginDiv').style.display=''" for="remUsername">
                                  <input type="checkbox" id="remUsername" name="RememberMe" tabindex="4" class="ipt-c">
                                  两周以内自动登录</label>
                            <div id="autoLoginDiv" style="border: 1px solid rgb(255, 153, 0); padding: 5px; position: absolute; width: 180px; height: 35px; background-color: rgb(255, 239, 164); left: 0pt; top: 20px; text-align: left; line-height: 150%; color: rgb(220, 104, 0); font-size: 12px; display: none;">为了您的信息安全，请不要在网吧或公用电脑上使用此功能！</div>
                          </div></td>
                        </tr>
                        <tr>
                          <td><div align="right"></div></td>
                          <td>
  
  <div align="left">
  <div style="height:0px;">
  <input type="submit" value="" style="height:0px;"/>
</div>
 <img src="<?php echo TPL;?>images/login_01.gif" width="82" height="24" style="cursor: pointer;" onclick="login.submit()"/>
  
  &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo url("user.php?action=register"); ?>"><img src="<?php echo TPL;?>images/login_02.gif" width="78" height="24" style="cursor: pointer;"></a></div>                            </td>
                        </tr>
                        <tr>
                          <td height="40"></td>
                          <td height="40"><a href="<?php echo url("user.php?action=resetp"); ?>">忘记密码</a></td>
                        </tr>
                      </tbody></table>
                  </div></td>
                </tr>
              </tbody></table>
            </div></td>
          </tr>
        </tbody></table>
</div>
 </form>
</div>

<?php include template('footer'); ?>

</body>


</html>