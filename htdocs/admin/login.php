<?php session_start();
if (empty($_POST)) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理登录</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link href="_css/css_login.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 7]><script type="text/javascript" src="_script/unitpngfix.js" tppabs="http://127.0.0.1/Shaman/_script/unitpngfix.js"></script><![endif]-->
<script type="text/javascript" src="_css/css_login.js"  ></script>
<script type="text/javascript">
change_theme('theme2');
function check_input(iformv) 
{  
	if (iformv.username.value == "")
    {
		alert("请填用户名!");
		iformv.username.focus();
		return false;
	}

		if (iformv.password.value=="")
	{   alert("请填密码!");
	    iformv.password.focus();
		return false;
	}
	 return true
}
</script>
<SCRIPT LANGUAGE=JAVASCRIPT>
if (top.location != self.location)top.location=self.location;
</SCRIPT>
</head>
<body>
<div id="nav">
  <ul class="liste_bgrd">
    <li><a href="####" onclick="change_theme('theme1');"><img src="images/login/ico_bgrd_1.gif" tppabs="http://127.0.0.1/Shaman/images/login/ico_bgrd_1.gif" alt="飘渺" /></a></li>
    <li><a href="####" onclick="change_theme('theme2');"><img src="images/login/ico_bgrd_2.gif" tppabs="http://127.0.0.1/Shaman/images/login/ico_bgrd_2.gif" alt="商业" /></a></li>
    <li><a href="####" onclick="change_theme('theme3');"><img src="images/login/ico_bgrd_3.gif" tppabs="http://127.0.0.1/Shaman/images/login/ico_bgrd_3.gif" alt="热情" /></a></li>
    <li><a href="####" onclick="change_theme('theme4');"><img src="images/login/ico_bgrd_4.gif" tppabs="http://127.0.0.1/Shaman/images/login/ico_bgrd_4.gif" alt="冷峻" /></a></li>
    <li><a href="####" onclick="change_theme('theme5');"><img src="images/login/ico_bgrd_5.gif" tppabs="http://127.0.0.1/Shaman/images/login/ico_bgrd_5.gif" alt="自然" /></a></li>
  </ul>
</div>
<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle">
    <form action="login.php" method="post" name="form" id="form" onsubmit="return check_input(this);">
        <input type="hidden" name="act" value="login" />
        <table width="455" border="0" cellspacing="0" cellpadding="0" background="images/login/ling.png" tppabs="http://127.0.0.1/Shaman/images/login/ling.png">
          <tr>
            <td height="200" valign="top"><table width="410" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="100" colspan="2"></td>
                </tr>
                <tr>
                  <td height="40"></td>
                  <td width="210" height="40"><table width="210" border="0" cellspacing="2" cellpadding="0">
                      <tr>
                        <td width="130" height="19"><input name="username" type="text" class="input" id="username" value="" onblur="fade_over(this.id,50);" onfocus="fade_over(this.id,100);"  border="0"/></td>
                        <td width="80" rowspan="2" align="center" valign="middle"><input name="image" type="image" src="images/login/log_an.png" tppabs="http://127.0.0.1/Shaman/images/login/log_an.png" width="72" height="35"/></td>
                      </tr>
                      <tr>
                        <td height="19"><input name="password" type="password" class="input" id="password" value="" onblur="fade_over(this.id,50);" onfocus="fade_over(this.id,100);" border="0"/></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
        <table width="100" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="200">&nbsp;</td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<iframe src="about:blank" name="login" id="login" style="display:none"></iframe>
</body>
</html>
<?php
} else { //form is posted
	include("../common.inc.php");
	InitGP(array("username","password"),"P",1); //初始化变量全局返回
	/*	
	include(INC_PATH."/code/securimage.php");
	$img = new Securimage();
	$valid = $img->check($_POST['code']);
	if($valid != true) {
  		showmsg("验证码错误","-1");
  		exit;
  	}
	*/
  	if (empty($username)||empty($password)) {
  		showmsg("用户名或者密码为空","-1");
  		exit;
  	}
	$row = $db->fetch_first("Select * From {$tablepre}admin where adminname like '$username' ");
	if(is_array($row))
	{
		if(md5($password) != $row['adminpwd'])
		{
			$log_file = ROOT_PATH.'/data/adminlogin_safe.txt';
			if(function_exists('real_ip'))$userIP = real_ip();else $userIP="";
			$getUrl = geturl();		
			fputs(fopen($log_file,'a+'),date('Y-m-d H:i:s')."||$userIP||$getUrl||$username||$password||登陆失败\r\n");
			showmsg("用户名或者密码错误","-1");
			exit;
		}else 
		{
			$adminauth=$row['adminid']."\t".$username."\t".$row['adminpwd'];
			set_cookie('adminauth',cookie_authcode($adminauth,'ENCODE'),time()+3600*12);	//设置12个小时cookie有效期			
			addfield("admin","logincount","adminname='{$username}'",1);//更新登录次数
			editstate("admin","lastlogin","adminname='{$username}'",$timestamp);//更最后登录时间
			showmsg("登录成功！","index.php");	
		}
		
	}else showmsg("用户名不存在","-1");
  
	
}

?>