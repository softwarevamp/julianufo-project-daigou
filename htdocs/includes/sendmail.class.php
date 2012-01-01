<?php

/**
*通过phpmailer发送邮件
*@author lssbing
* 
*/
require_once(INC_PATH."/phpmailer/class.phpmailer.php");
//require_once(INC_PATH."/phpmailer/class.smtp.php");
class SendEmail {
	var $db;
	var $table;
	var $smtptable;
	var $sleeping_file;
	var $sleeping_time = 1800;
	var $sleep =false;
	var $file_append=1;
	var $errorMsg="";
	var $currTime;
	var $unuseMails=array();
	var $smtparray=array();
	var $smtpcount=0;
	var $printmsg="";
	var $mailobj;
	function __construct()
	{
		global $db,$tablepre,$timestamp;
		$this->db=$db;
		$this->sleeping_file=DATA_CACHEPATH."/sleepMail.dat";//休眠email存储地址
		$this->currTime=$timestamp;
		$this->smtptable=$tablepre."smtpaccount";
		$this->setsmtp();
		$this->getsleepmail();
		$this->mailobj= new PHPMailer();
	}
	function SendEmail(){
		$this->__construct();
	}
	//执行发送
	function run($subject,$body,$emailarray){
		$this->sleep=true;
		if(is_array($emailarray)){
			foreach ($emailarray as $value){
				$this->sendmailto($subject,$body,$value['email']);
			}
		}else $this->printmsg="数据格式错误";
	}
	//发送操作
	function sendmailto($subject,$body,$to){
		$errorNo=0;
		$subject = $subject ? $subject : "";
		$mailbody = $body ? $body : "" ;
		$to = $to ? $to : "" ;
		if($this->smtpcount < 1){
			$errorNo = 2;
	        $this->errorMsg = "没找到发件人信息";
			$this->printmsg.= "没找到发件人信息";
			return;
		}
		$i=0;
		do {
			if($this->smtpcount==1){
				$rnd=0;
			}else{
				$rnd = mt_rand(0, $this->smtpcount - 1);
			}
			$i++;
			if($i>5)break;
			$rnd = mt_rand(0, $this->smtpcount - 1);
			$line = is_array($this->smtparray[$rnd]) ? $this->smtparray[$rnd] : "";
		}while (in_array($line['smtp_account'], $this->unuseMails));//如果在不可用的列表中，在次加载
        $smtpServer = $line['smtp_server'];
        $fromMail = $line['smtp_email'];
        $smtpaccount = $line['smtp_account'];
        $psw = $line['smtp_password'];
        $port = $line['smtp_port'];
        $auth=$line['smtp_auth'];
        $reply=$line['reply_address'];
        $ssl=$line['smtp_ssl'];
        $name=$line['smtp_name'];
        $smtpUserName = substr($fromMail, 0, strrpos($fromMail, '@'));
        
		if (!isset($smtpServer) || !isset($fromMail) || !isset($psw)) {
	       	$errorNo = 2;
	        $this->errorMsg = "没找到发件人信息";
		}
		if (empty($mailbody) || empty($subject) || empty($to)) {
		    $errorNo = 1;
		    $this->errorMsg = "参数不全";
		}
		if (!$errorNo) {
			//处理发信操作
			//通过phpmailer连接smtp服务器发信
			
			$this->mailobj->ClearAddresses();	//清除上次设置的发送地址
			$this->mailobj->ClearAttachments(); //清除上次设置的附件信息
			$this->mailobj->ClearReplyTos(); 	//清除回复人设置
			
		    $body = eregi_replace("[\]",'',$mailbody); //去掉反斜杠
			$subject= "你好 ".$smtpUserName." ".$subject; //设置标题自动变
			
		    $this->mailobj->CharSet = "utf-8";
		    $this->mailobj->SetLanguage('zh_cn');//设置语言为简体中文
		    $this->mailobj->IsSMTP(); 
		    if($auth)$this->mailobj->SMTPAuth = true;else $this->mailobj->SMTPAuth = false;
		    if($ssl)$this->mailobj->SMTPSecure = "ssl";else $this->mailobj->SMTPSecure = "";
		   	if($port)$this->mailobj->Port       = $port;//设置端口
		   	
		    $this->mailobj->Username = $smtpaccount;
		    
			$this->mailobj->Password = $psw;
			$this->mailobj->Host = $smtpServer;
			$this->mailobj->From = $fromMail;
			$this->mailobj->FromName = $name;
			$this->mailobj->IsHTML(true);
			$this->mailobj->AddAddress($to);
			$this->mailobj->AddReplyTo($reply,$name);
			$this->mailobj->Subject = $subject;
			$this->mailobj->Body = $body;
			if (!$this->mailobj->Send()) {
				$errorNo = 3;
				$this->errorMsg = $this->mailobj->ErrorInfo;
				$this->printmsg.= "出错 ($this->errorNo) " . $this->errorMsg . " |";
			} else {
				$this->printmsg.= "发送到 $to 成功 使用 $fromMail <Br/>";
				if ($this->sleep) {
					sleep(5);//休眠5秒钟再发
				}
			}
		}
		if ($errorNo == 3) {
		    $content = "$fromMail|" . time() . "\r\n";//email|当前时间戳
		    file_put_contents($this->sleeping_file, $content, 1);
		}
		
	}
	
	//获取休眠状态email
	function getsleepmail(){
	    if (file_exists($this->sleeping_file)) {
        $sleepMails = file($this->sleeping_file);
        if (!empty($sleepMails)) {
            foreach($sleepMails as $sleepMail) {
                //解析
                if (false !== strpos($sleepMail, '|')) {
                    $tmp = explode('|', $sleepMail);
                    if (isset($tmp[0]) && isset($tmp[1])) {
                        $mail = trim($tmp[0]);
                        $time = trim($tmp[1]);
                        //是否可用
                        	if ( ($currTime - $time )< $this->sleeping_time) {
                            	$this->unuseMails[] = $mail;
                       		}
	                   	}
                	}
            	}
	       	}
    	}
	}
	function setsmtp(){
		$smtp=new TableClass("smtpaccount",'eid');
		//设置总数和数组
		$this->smtpcount=$smtp->getcount("state=1"); 	
		$this->smtparray=$smtp->getdata("","state=1");//查询获取数据
		unset($smtp);
	}
}

?>