<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户注册 - <?php echo $cfg_site_name;?></title>
<link href="<?php echo TPL;?>css/Register.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css"  />
<script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Gobal.js"> </script>
<script type="text/javascript" src="<?php echo TPL;?>js/Register.js"> </script>
</head>

<body>
<?php include template('header'); ?>
<div class="box">
<form name="login" method="post" action="<?php echo url("user.php?action=register"); ?>">
<input type="hidden" name="commit" value="1"/>
        <div class="move">
          <img alt="注册" src="<?php echo TPL;?>images/move.gif"></div>
        <div class="welcome"><img alt="注册" src="<?php echo TPL;?>images/welcome.gif" /></div>
        <div class="register">
<table>
                <tbody>
                <tr>
                    <td class="l">
                        用户名：
                    </td>
                    <td>
                        <input type="text" onblur="nicknameblur(this)" onfocus="focusCheck(this,&quot;昵称必须是英文字母开头,中文,数字组成,长度2-8个汉字或4-16个字符&quot;);" name="regNickName" id="regNickName" maxlength="20" value="">
                        <p>
                            昵称也可以作为您登录的帐号，大家以后就这样称呼您</p>
                    </td>
                </tr>
<tr>
                    <td class="l">
                        Email地址：
                    </td>
                    <td>
                        <input type="text" onblur="emailBlur(this)" onfocus="focusCheck(this,&quot;此邮箱将作为您登录的帐号，并将用来接收验证邮件&quot;);" name="regEmail" id="regEmail" maxlength="80" value="">
                        <p>
                            此邮箱将作为您登录的帐号，并将用来接收验证邮件</p>
                    </td>
                </tr>
                <tr>
                    <td class="l">
                        设定密码：
                    </td>
                    <td>
                        <input type="password" onfocus="focusCheck(this,'密码可由大小写英文字母、数字组成、长度为6-20个字符')" onblur="checkPassword(this)" value="" name="regPassword" id="regPassword" maxlength="20" onkeydown="passPower(this)">
                        <p>
                            请输入您的帐号密码</p>
                        <div style="display: none;" class="rank" id="passPower">
                          安全等级：低</div>
                    </td>
                </tr>
                <tr>
                    <td class="l">
                      确认密码：
                    </td>
                    <td>
                        <input type="password" value="" onblur="reCheckPassword(this)" onfocus="focusCheck(this,'请再输入一次您的密码')" name="regRePassword" maxlength="20" id="regRePassword">
                        <p>
                          请再输入一次您的密码</p>
                    </td>
                </tr>
                <tr>
                    <td class="l">
                        验证码：
                    </td>
                    <td>
                      <input type="text" name="regCheckCodeInput" class="verification" id="regCheckCodeInput" ><img border="0" onclick="var now=new Date();this.src='includes/code/securimage_show.php?sid=<? echo md5(time()); ?>&amp;w=92&amp;h=30&amp;t='+Math.random();" style="vertical-align: middle; cursor: pointer;" alt="验证码" title="点击图片刷新" src="includes/code/securimage_show.php?sid=<? echo md5(time()); ?>&amp;w=92&amp;h=30&amp;t='+Math.random();" id="regCheckCode">
                        <a onclick="$('#regCheckCode').click();" style="cursor: pointer;">看不清，换一张</a>
                        <p style="display: none;" class="red">
                            验证码输入错误，请重新输入</p>
                    </td>
                </tr>
            </tbody></table>
            <div class="refer">
                <span>
                    <label>
                        <input type="checkbox" checked="checked" value="" name="regAgree" id="regAgree">我已阅读并同意</label><a target="_blank" href="<?php echo url("help.php?action=view&id=82"); ?>">《用户注册协议》</a></span>
                <input type="button" onclick="regSubmit()" onmouseout="this.className='button'" onmouseover="this.className='button_'" value="提交注册" name="" class="button">
            </div>
        </div>
    </form>
    </div>
    <div class="bottom_1">
    </div>

<?php include template('footer'); ?>	
</body>
</html>
