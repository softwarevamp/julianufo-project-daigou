<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}

/*******************
*membarclass 类，处理用户相关操作,包含ucenter
*reg() 注册
*login()登录
*checkuname()检测用户名
*checkemail()检测邮箱
*checkuser()检测用户和密码
*
*
*quit()退出操作
*/
class memberclass
{
	var $db;
	var $table;
	var $cookietime;
	var $email;
	var $uname;
	var $activekey;
	var $ucsynlogin;		//uc同步信息，登录或者退出
	var $notallow=array('user','manger');//禁止注册用户名
	function __construct()
	{	//设置全局变量
		global $db,$tablepre,$cfg_login_time;
		$this->db=$db;
		$this->table=$tablepre."users";
		$this->cookietime=time()+$cfg_login_time;
		if(!empty($cfg_login_time))$this->cookietime=time()+3600; //cookie默认时间
	}
	function memberclass()
	{
		$this->__construct();
	}
	//用户注册操作
	function reg($uname,$password,$email,$uarray=array())
	{	
		global $cfg_reg_score,$cfg_reg_checkemail;//注册送积分
		$timestamp=time();
		$this->activekey=randomkeys(5,"ALL");//激活用户使用
		$this->uname=$uname;//变量放入对象中
		$this->email=$email;//变量放入对象中
		$ckname=$this->checkuname($uname,true);
		$ckmail=$this->checkemail($email,true);
		if($ckname=="OK" && $ckmail=="OK")
		{
			$pwd=md5($password);//加密方式 两次MD5
			#api{{
			if(defined('UC_API') && @include_once ROOT_PATH.'/uc_client/client.php')
			{
				$uid = uc_user_register($uname, $password, $email);
				if($uid <= 0)
				{
					if($uid == -1)
					{
						return lang('User_notvalid');
					}
					elseif($uid == -2)
					{
						return lang('Contains_rege_words');
					}
					elseif($uid == -3)
					{
						return lang('user_already_exists',array('$uname'=>$uname));
					}
					elseif($uid == -5)
					{
						return lang('Email_notallowrege');
					}
					elseif($uid == -6)
					{
						return lang('Email_already_registered');
					}
					else
					{
						return lang('register_failed');
					}
				}
				else
				{
					//插入本地数据库操作	
					$uarray['uid']=$uid;
					$uarray['password']=$pwd;
					$uarray['uname']=$uname;
					$uarray['email']=$email;
					$uarray['regtime']=$timestamp;
					$uarray['logintime']=$timestamp;
					$uarray['activekey']=$this->activekey;//激活使用
					if ($cfg_reg_checkemail=="Y") {
						$uarray['state']=0;
					}else{
						$uarray['state']=1;
					}
					//$uarray['scores']=$cfg_reg_score;//注册送积分
					if(is_numeric(inserttable($this->table, $uarray,1))){
						$this->ucsynlogin = uc_user_synlogin($uid);
						$auth=$uid."\t".$uname."\t".$pwd;
						set_cookie('loginauth',cookie_authcode($auth,'ENCODE'));
						include_once(INC_PATH."/cart.class.php");
						$Cart=CartClass::init();
						$Cart->amonymoustouname($uid,$uname);
						//注册送积分
						$note=lang('rege_send_point').$cfg_reg_score;
						$this->scoreedit($uname,$cfg_reg_score,$note);
						if ($cfg_reg_checkemail=="Y") {
							//发送验证邮件
							$this->sendactiveemail();
						}
						return 'OK';
					}
				}
			}else {
			#/aip}}	
				//不是ucenter状态
				//插入数据库用户
				$activekey = $this->activekey;
				if ($cfg_reg_checkemail=="Y") {$userstate=0;}else{$userstate=1;}
				$tel=$uarray['tel'];
				$this->db->query("INSERT INTO `$this->table`(uname,email,password,tel,scores,money,regtime,logintime,activekey,state) values('{$uname}','{$email}','{$pwd}','{$tel}',0,0,$timestamp,$timestamp,'{$activekey}',$userstate)");	
				$uid=$this->db->insert_id();
				$auth=$uid."\t".$uname."\t".$pwd;
				set_cookie('loginauth',cookie_authcode($auth,'ENCODE'),$this->cookietime);
				include_once(INC_PATH."/cart.class.php");
				$Cart=CartClass::init();
				$Cart->amonymoustouname($uid,$uname);
				$note=lang('rege_send_point').$cfg_reg_score;
				$this->scoreedit($uname,$cfg_reg_score,$note);
				if ($cfg_reg_checkemail=="Y") {
					//发送验证邮件
					$this->sendactiveemail();
				}
				return 'OK';
			}
			
		}else 
		{
			$errormsg="";			
			if($ckname!='OK')$errormsg.=$ckname;
			if($ckmail!='OK')$errormsg.=$ckmail;
			return $errormsg;
			
		}

	}
	//用户登录操作
	function login($uname,$pwd)
	{
		global $timestamp;
		$rs=$this->CheckUser($uname,$pwd);//本地验证通过 -1格式错误
		if($rs!=-1)
		{
			#api{{
			if(defined('UC_API') && @include_once ROOT_PATH.'/uc_client/client.php')
			{
				//检查帐号UC
				list($uid, $username, $password, $email) = uc_user_login($uname, $pwd);
				if($uid > 0) {//uc登录成功
					$password = md5($password);
					if($rs == -3) {
						//本地数据库不存在自动插入一个用户
						$this->db->query("INSERT INTO `$this->table`(uid,uname,email,password,scores,money,regtime,logintime) values($uid,'$username','$email','$password',0,0,$timestamp,$timestamp)");
					
					}else if ($rs==-2) {
						$this->db->query("update `$this->table` SET password='{$password}' WHERE uname='$username'");
					}
				$rs = 1;
				//设置cookie
				$auth=$uid."\t".$username."\t".$password;
				set_cookie('loginauth',cookie_authcode($auth,'ENCODE'),$this->cookietime);	
				//生成同步登录的代码
				$this->ucsynlogin = uc_user_synlogin($uid);
				return 'OK';
				}else if($uid == -1)
				{
					
					//当UC不存在 系统存在,就注册一个
					if($rs==1) {
						$row = $this->db->fetch_first("Select * From `$this->table` where uname like '$uname' ");
						$uid = uc_user_register($uname, $pwd, $row['email']);
						//设置cookie
						$auth=$uid."\t".$uname."\t".md5($pwd);
						set_cookie('loginauth',cookie_authcode($auth,'ENCODE'),$this->cookietime);	
						if($uid > 0) $ucsynlogin = uc_user_synlogin($uid);
						include_once(INC_PATH."/cart.class.php");
						$Cart=CartClass::init();
						$Cart->amonymoustouname($uid,$uname);
						return 'OK';
					}elseif ($rs==-3){
						return lang('user_and_pass_notexist');
					}else {
						return lang('pass_error');
					}
				} else {
					$rs = -2;//密码错误
					return lang('pass_error');
				}
	
			}else if ($rs==1) {
			#/aip}}	
				//非ucenter模式下用户登录操作
				$row = $this->db->fetch_first("Select * From `$this->table` where uname like '$uname' ");
				//设置cookie记录
				$auth=$row['uid']."\t".$uname."\t".$row['password'];
				set_cookie('loginauth',cookie_authcode($auth,'ENCODE'),$this->cookietime);
				$this->db->query("update `$this->table` SET logintime={$timestamp} WHERE uname='$uname'");
				include_once(INC_PATH."/cart.class.php");
				$Cart=CartClass::init();
				$Cart->amonymoustouname($row['uid'],$uname);
				if($row['utype']>=1){
				   if(time()>$row['validity']){
					$this->db->query("update `$this->table` SET utype=0,validity=0 WHERE uname='$uname'");
	 
				   }
					
				}
				
				
				
				
				return 'OK';
			}else {
				if($rs==-2)return lang('user_and_pass_error');
				else return lang('username_notexist');
			}
		}
		else
		{
			return lang('datatype_error');
		}
	}
	
	//quit退出系统
	function quit()
	{
		#api{{
		if(defined('UC_API') && @include_once ROOT_PATH.'/uc_client/client.php')
		{
		$this->ucsynlogin = uc_user_synlogout();
		}
		#/aip}}
		set_cookie('loginauth','',- $this->cookietime);//设置cookie过期
		return true;
	}
	//发送激活信
	function sendactiveemail($uname="",$email=""){
		global $cfg_site_name;
		$uname=Char_cv($uname);//过滤
		if (!empty($email)) {
			$this->email=$email;
		}
		if(!empty($uname)){
			$row=$this->db->fetch_first("Select activekey,state,email From `$this->table` WHERE uname='{$uname}'");
			if (!empty($row['activekey'])) {
				if ($row['state']==1) {
					return 'approved';//已经激活
				}
				$this->email=$row['email'];
				$this->uname=$uname;
				$string=$uname."\t".$row['activekey'];
			}else{
				return lang('Specifieduser_notexist');
			}
		}else {
			$string=$this->uname."\t".$this->activekey;
		}
		$codestring=cookie_authcode($string,'ENCODE',"",3600);
		//exit;
		$subject=lang('account_activation_email',array('$cfg_site_name'=>$cfg_site_name,'$this->uname'=>$this->uname));
		//发送邮件操作
		$site=str_replace("/ajax","",SITE_URL);
		$codestring=str_replace("+","%2B",$codestring);
		$emailstr="hi {$this->uname},<BR><BR>".lang('Click_link_activate',array('$cfg_site_name'=>$cfg_site_name))."<BR><BR><BR><A href='{$site}/user.php?action=active&code={$codestring}' target=_blank>{$site}/user.php?action=active&code={$codestring}</A><BR><BR>-- <BR>{$cfg_site_name}";
		
		include_once(INC_PATH."/sendmail.class.php");
		$sendmail=new SendEmail();
		$sendmail->sendmailto($subject,$emailstr,$this->email);
		return "OK";
	}
	
	//设置cookie有效期时间
	function setcookietime($s){
		if (GetNum($s)) {
			$this->cookietime=time()+$s;
			return true;
		}else {
			return false;
		}
	}
	
	//修改资料
	function edit($uname,$email="",$oldpassword="",$password="",$garray="")
	{
		if(!empty($uname)){
			if(!empty($email) && $this->checkemail($email,true)!='OK'){
				return  lang('email_been_rege');
			}
			if(!empty($password)||!empty($email)){
				#api{{
				if(defined('UC_API') && @include_once ROOT_PATH.'/uc_client/client.php')
				{
					$ucresult = uc_user_edit($uname,$oldpassword, $password, $email,1);
					if($ucresult<0){
						if($ucresult == -1) {
							return lang('oldpass_noIncorrect');
						} elseif($ucresult == -4) {
							return  lang('email_format_error');
						} elseif($ucresult == -5) {
							return  lang('email_notallow_rege');
						} elseif($ucresult == -6) {
							return  lang('email_been_rege');
						}
					}
				}
				#/aip}} 
				$pwd=md5($password);
				if (!empty($email) && !empty($password)) {
					$this->db->query("update `$this->table` SET password= '{$pwd}',email='{$email}' WHERE uname='$uname'");	
				}elseif (!empty($email) && empty($password)){
					$this->db->query("update `$this->table` SET email='{$email}' WHERE uname='$uname'");
				}elseif (empty($email) && !empty($password)){
					$this->db->query("update `$this->table` SET password= '{$pwd}' WHERE uname='$uname'");
				}
			}
			if(is_array($garray)){
				//更新数据库操作
				$wheresqlarr=" uname='{$uname}'";
				updatetable($this->table,$garray, $wheresqlarr);				
			}
			return "OK";
		}else 
		{
			return lang('email_beenrege_formaterror');
		}
		
	}
	//检测本地数据库用户名密码 返回1正常 负数出错
	function CheckUser($uname,$password)
	{
		if($this->checkuname($uname,false)!='OK')return -1;//格式错误
		$row = $this->db->fetch_first("Select * From `$this->table` where uname like '$uname' ");
		if(is_array($row))
		{
			if(md5($password) != $row['password'])
			{
				return -2;//密码错误
			}else 
			{
				return 1;//通过检测
			}
		
		}else 
		{
			return -3;//用户名不存在
		}
	}
	
	//判断用户名是否重复
	function checkuname($uname,$ckhas=true)
	{
		//if(!preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $uname))
		//{
		//	return '用户名格式错误';
		//}
		if ( 50 <= strlen($uname) || strlen($uname) < 3 )
		{
			return lang('userlength_error');
		}
		if (is_numeric($uname)) {
			return lang('notuse_user_purenumbers');
		}
		if($ckhas)
		{	#api{{
			if(defined('UC_API') && @include_once ROOT_PATH.'/uc_client/client.php')
			{
				$ucresult = uc_user_checkname($uname);
				
				if($ucresult > 0)
				{
					return 'OK';
				}
				elseif($ucresult == -1)
				{
					return lang('User_notvalid');
				}
				elseif($ucresult == -2)
				{
					return lang('Contains_rege_words');
				}
				elseif($ucresult == -3)
				{
					return lang('username_been_exist');
				}
			}else {
			#/aip}}
			$row = $this->db->fetch_first("Select * From `$this->table` where uname like '$uname' ");
			if(is_array($row)) return lang('user_already_exists');
			}
		}
		return 'OK';
	}
	//检测email
	function checkemail($email,$ckhas=true)
	{
		if(!isemail($email))return lang('email_format_error');
		if($ckhas){
			#api{{
		if(defined('UC_API') && @include_once ROOT_PATH.'/uc_client/client.php')
		{
			$ucresult = uc_user_checkemail($email);
			if($ucresult > 0) {
				return "OK";
			} elseif($ucresult == -4) {
				return lang('email_format_error');
			} elseif($ucresult == -5) {
				return lang('email_notallow_rege');
			} elseif($ucresult == -6) {
				return lang('email_been_rege');
			}
			exit();
		}else {
		#/aip}}		
			$row = $this->db->fetch_first("Select * From `$this->table` where email like '$email' ");
			if(is_array($row)) return lang('email_been_rege');
			return "OK";
		}
		}
		return "OK";
	}
	
	function checktel($tel,$ckhas=true)
	{
		if ( 12 <= strlen($tel) || strlen($tel) < 11 )
		{
			return '联系方式长度不合法';
		}else{
		  	$row = $this->db->fetch_first("Select * From `".$this->table."` where tel like '".$tel."' ");
			if(is_array($row)) return "该 联系方式已存在";
			return "OK";
		}
	}
	//用户积分操作
	function scoreedit($uname,$num=0,$note="")
	{
		if (!empty($uname) && $num!=0 && is_numeric($num)) {
			$row = $this->db->fetch_first("Select uid,scores From `$this->table` where uname like '$uname' ");
			if (is_array($row)) {
				$this->db->query("update `$this->table` SET scores= scores+{$num} WHERE uname='$uname' limit 1");
				if($num>0){$edittype=lang('adds');$type=2;}else{$edittype=lang('Minus');$type=1;}				
				$action = GetNum($action);
				$totalscore = $row['scores']+$num;
				//记录日志操作
				$scorerecord_table=new TableClass('scorerecord','sid');
				$addarray=array(
					'uid'=>$row['uid'],
					'uname'=>$uname,
					'type'=>$type,
					'score'=>$num,
					'totalscore'=>$totalscore,
					'remark'=>$note,
					'addtime'=>time()
				);
				$info=$scorerecord_table->add($addarray);
				if (GetNum($info)) {
					$returnstr="OK";
				}else{
					$returnstr=lang('Error_log');
				}
				//写入日志文件
				$datastr=date('Y-m-d h:i:s');
				$log=$datastr.lang('uname').$uname.'|'.$edittype.lang('points').$num.lang('legend').$note;
				@writelog('score_edit', $log);
				//增加写入文件日志操作！记录每次用户积分改动
			}else $returnstr=lang('username_notexist');			
		}else {
			$returnstr=lang('Missing_parameter_err');
		}
		return $returnstr;
	}
	//用户账户余额操作
	function moneyedit($uname,$num=0,$action=0,$note="")
	{	
		$returnstr="OK";
		if (!empty($uname) && $num!=0 && is_numeric($num)) {
			$row = $this->db->fetch_first("Select uid,money From `$this->table` where uname like '$uname' ");
			if (is_array($row)) {
				$this->db->query("update `$this->table` SET money= money+{$num} WHERE uname='$uname' limit 1");
				if($num>0){$edittype=lang('adds');$type=2;}else{$edittype=lang('Minus');$type=1;}				
				$action = GetNum($action);
				$accountmoney = sprintf("%01.2f", $row['money']+$num);
				//记录日志操作
				$record_table=new TableClass('record','rid');
				$addarray=array(
					'uid'=>$row['uid'],
					'uname'=>$uname,
					'type'=>$type,
					'action'=>$action,
					'money'=>$num,
					'accountmoney'=>$accountmoney,
					'remark'=>$note,
					'addtime'=>time()
				);
				$info=$record_table->add($addarray);
				if (GetNum($info)) {
					$returnstr="OK";
				}else{
					$returnstr=lang('Error_log');
				}
				//写入日志文件
				$datastr=date('Y-m-d h:i:s');
				$log=$datastr.lang('uname').$uname.'|'.$edittype.lang('Amount').$num.lang('legend').$note;
				@writelog('money_edit', $log);
				//增加写入文件日志操作！记录每次用户钱币改动
			}else $returnstr=lang('username_notexist');	
		}else {
			$returnstr=lang('Missing_parameter_err');
		}
		return $returnstr;
	}
	//查询用户帐户余额
	function getmoneybyuname($uname){
		if(!empty($uname)){
			$row = $this->db->result_first("Select money From `$this->table` where uname like '$uname' ");
			return $row;
		}
	}
	/**
	 * 获取一条信息
	 *
	 * @param unknown_type $oid
	 * @return unknown
	 */
	function getone($uid){
		if (is_numeric($uid)) {
			$uid=$this->db->result_first("Select uname From `$this->table` WHERE uid='{$uid}'");
		}
		$gpdata=$this->getdata(1,"uname='{$uid}'");
		$value=$gpdata[0];
		return $value;
		
	}
	/**
	 * 获取一条信息
	 *
	 * @param unknown_type $oid
	 * @return unknown
	 */
	function getonebyemail($email){
		if (isemail($email)) {
			$row=$this->db->fetch_first("Select * From `$this->table` WHERE email='{$email}'");
		}
		if (!empty($row)) {
			return $row;
		}else {
			return false;
		}
	}
	/**
	 * 获取数据数组
	 *
	 * @param string $limit
	 * @param string $where
	 * @param string $orderby
	 * @return array
	 */
	function getdata($limit="",$where="",$orderby="",$field="*")
	{
		$tempdata=array();
		if(!empty($limit))$limit=" limit $limit ";
		if(!empty($where))$where=" where $where ";
		if(!empty($orderby))$orderby=" order by $orderby ";else $orderby=" order by uid desc";

		$sql="select {$field} from {$this->table}{$where}{$orderby}{$limit}";
		$query =$this->db->query($sql);
		while($value = $this->db->fetch_array($query)) {
			//此处可进行数据整理
			$tempdata[]=$value;
		}
		return $tempdata;
	}
	function getcount($where=""){
		if(!empty($where))$where=" where $where";
		$count= $this->db->result_first("Select count(uid) From `$this->table` $where");
		return $count;
	
	}	
	
	
}

?>