<?php
session_start();
//用户登录页面
include("common.inc.php");
InitGP(array("action","commit","code","userName","password","RememberMe")); //初始化变量全局返回
header("Content-type: text/html; charset=".CHARSET);
//允许的动作
$actarray = array('login', 'register', 'active', 'useractive','newpass', 'quit','resetp');
$action = (!empty($action) && in_array($action, $actarray))?$action:'login';
//链接
$theurl = 'user.php?action='.$action;

if($action=='login'){
	if(!empty($_USERS))dheader("index.php");//如果已经登录直接跳转到首页
	if (!empty($commit)) {
		//处理登录操作
		include(INC_PATH."/code/securimage.php");
		$img = new Securimage();
		$valid = $img->check($code);
		if($valid != true) {
			print("<script language='javascript'>alert('验证码错误');history.go(-1);</script>");
			exit();
	  	}
		include(INC_PATH."/member.class.php");
		$m=new memberclass();
		if (!empty($RememberMe)) {
			$m->setcookietime(14*24*3600);
		}
		$msg=$m->login($userName,$password);
		if ($msg=="OK") {
			//登录成功自动跳转到首页
			checkauth();//检查用户登录
			if ($_USERS['state']==0) {
				dheader(url("user.php?action=useractive"));//php跳转页面
			}
			$gotourl=get_cookie('_refer');
			$gotourl = empty($_GET['refer'])?rawurldecode($gotourl):$_GET['refer'];
			$gotourl=remove_xss($gotourl);//过滤xss攻击
			if (empty($gotourl)) {
				$gotourl=url("index.php");
			}
			//jumpurl($gotourl);
			//dheader($gotourl);//php跳转页面
			print("<script language='javascript'>alert('登录成功');</script>".$m->ucsynlogin);
			jumpurl($gotourl);				
			//showmessage("登录成功!".$m->ucsynlogin,$gotourl,1);
		}else {
			print("<script language='javascript'>alert('".$msg."');history.go(-1);</script>");
			exit();				
		}
	}else{
		include template('login');//包含输出指定模板
	}
	
}elseif($action=='register'){
	InitGP(array("action","regNickName","regPassword","regRePassword","regEmail","regCheckCodeInput","commit")); //初始化变量全局返回
	if(!empty($_USERS))dheader("index.php");//如果已经登录直接跳转到首页
	$ERROR_MSG='';
	if (!empty($commit)) {
			//处理注册操作
		if (empty($regNickName)||empty($regPassword)||empty($regRePassword)||empty($regEmail)) {
			$ERROR_MSG ="用户名密码和邮箱必须填写！";
		}
		if ($regPassword!=$regRePassword) {
			$ERROR_MSG ="两次输入的密码不一致！";
		}
		if (empty($ERROR_MSG)) {
			$uarray=array();
			include(INC_PATH."/member.class.php");
			$m=new memberclass();
			$msg=$m->reg($regNickName,$regPassword,$regEmail,$uarray); //注册动作
			if ($msg=="OK") {
		
				$emailhttp=substr(strstr($regEmail, '@'),1);
				$emailhttp="http://mail.".$emailhttp;
				if($cfg_reg_checkemail=='N'){
					print("<script language='javascript'>alert('注册成功!');</script>");
					jumpurl(url("index.php"));
					exit;				
				}
				include template('register_ok');//包含输出指定模板
				exit;
			}else {
				$ERROR_MSG =$msg;		
			}
			
		}
		if (!empty($ERROR_MSG)) {
			print("<script language='javascript'>alert('".$ERROR_MSG."');history.go(-1);</script>");
			exit();
		}
	}else{
	//显示注册表单
		include template('register');//包含输出指定模板
	}
}elseif($action=='active'){
	//账户激活操作
	InitGP(array("code")); //初始化变量全局返回
	@list($uname,$activekey) = explode("\t", cookie_authcode($code,'DECODE'));
	if(!empty($uname)&&!empty($activekey)){
		editstate("users","state","uname='".$uname."'",1);//修改状态
		include template('register_active_ok');//包含输出指定模板
	}else{
		include template('register_active_error');//包含输出指定模板
	}
}elseif($action=='useractive'){
	//提示激活帐号
	include template('useractive');//包含输出指定模板
			
}elseif($action=='resetp'){//重置密码
	InitGP(array("username","email","forgotCode","commit")); //初始化变量全局返回
	$username=Char_cv($username);
	if (!empty($commit)) {
		if (!isemail($email)) {
			print("<script language='javascript'>alert('邮箱格式不正确');history.go(-1);</script>");
			exit();			
		}
		if (empty($username)) {
			print("<script language='javascript'>alert('用户名不能为空');history.go(-1);</script>");
			exit();					
		}
		include(INC_PATH."/code/securimage.php");
		$img = new Securimage();
		$valid = $img->check($forgotCode);
		if($valid != true) {
			print("<script language='javascript'>alert('验证码错误');history.go(-1);</script>");
			exit();
	  	}
		$value=DB::fetch_first("Select * From ".DB::table("users")." WHERE email='".$email."' and uname='".$username."'");
	  	if (!empty($value)) {
	  		//发送邮件到邮箱
			$string=$value['uname']."\t".$value['activekey']."\t".$value['email'];
			
			$codestring=cookie_authcode($string,'ENCODE',"",3600*24);
			//exit;
			$subject="{$cfg_site_name} 会员 {$value['uname']}重设密码";
			//发送邮件操作
			$site=SITE_URL;
			
			$codestring=str_replace("+","%2B",$codestring);
			$emailstr="hi {$value['uname']},<BR><BR>您在{$cfg_site_name}申请了重设密码，请点击下面的链接，然后根据页面提示完成密码重设：<BR><BR><BR><A href='{$site}/user.php?action=newpass&code={$codestring}' target=_blank>{$site}/user.php?action=newpass&code={$codestring}</A><BR><BR>-- <BR>{$cfg_site_name}";
			
			include_once(INC_PATH."/sendmail.class.php");
			$sendmail=new SendEmail();
			$sendmail->sendmailto($subject,$emailstr,$value['email']);
			
	  		include template('resetp_SendEmail');//显示邮件已经发送到邮箱
	  		exit();
	  	}else{
			print("<script language='javascript'>alert('用户名和邮箱不区配');history.go(-1);</script>");
			exit();				  		
	  	}
		
	}else {
		
		include template('ForgotPassword');//包含输出指定模板			
	}
}elseif($action=='newpass'){//重置密码
	InitGP(array("code","password","password2","commit")); //初始化变量全局返回
	if (!empty($code)) {
		@list($uname,$activekey,$email) = explode("\t", cookie_authcode($code,'DECODE'));
		
		if (!empty($password) && !empty($password2)) {
			if (strlen($password)<=6) {
				print("<script language='javascript'>alert('密码长度太短！');history.go(-1);</script>");
				exit();		
			}
			if ($password!=$password2) {
				print("<script language='javascript'>alert('两次输入的密码不一致！');history.go(-1);</script>");
				exit();
			}
			//校验code是否正确
			$uid=DB::result_first("Select uid From ".DB::table("users")." WHERE email='".$email."' and uname='".$uname."' and activekey='".$activekey."'");
			if (empty($uid)) {
				print("<script language='javascript'>alert('数据校验失败！链接已过期或者链接错误！');history.go(-1);</script>");
				exit();
			}
			include(INC_PATH."/member.class.php");
			$m=new memberclass();
			$info=$m->edit($uname,"","",$password);
			if ($info=="OK") {
				include template('resetp_ok');//包含输出修改密码成功
				exit();
			}else {
				print("<script language='javascript'>alert('修改密码失败！请重试');history.go(-1);</script>");
				exit();		
			}
			
		}
		if (empty($uname) || empty($activekey)||empty($email)) {
			print("<script language='javascript'>alert('链接已过期!');</script>");
			jumpurl(url("index.php"));	
		}else {
			include template('resetp_newpass');//包含输出指定模板	
		}
	}else{
		print("<script language='javascript'>alert('链接缺少参数!');</script>");
		jumpurl(url("index.php"));			
	}

}elseif($action=='quit'){//退出登录
	//处理登录操作
	include(INC_PATH."/member.class.php");
	$m=new memberclass();
	$msg=$m->quit();
	print("<script language='javascript'>alert('退出成功!');</script>".$m->ucsynlogin);
	jumpurl(url("index.php"));	
	//showmessage("退出成功!".$m->ucsynlogin,"index.php",1);
}
?>