<?php
//我的劵
header("Content-type: text/html; charset=utf-8");
InitGP(array("action","bid","page")); //初始化变量全局返回


if (empty($action)) {
	//最新公告
	$newsobj=new TableClass('news','nid');
	$newsarray=$newsobj->getdata(5); //获取数据
	//获取最新的两个专题
	$specialobj=new TableClass('special','sid');
	$specialarray=$specialobj->getdata(2,"",'listorder asc,sid desc','sid,title,flag,about,pic,listorder,addtime');
	//统计订单和运单
	$COUNT_ORDER4=DB::result_first("Select count(oid) From ".DB::table('order')." where "."uname='".$_USERS['uname']."' and state = 4");
	$COUNT_ORDER3=DB::result_first("Select count(oid) From ".DB::table('order')." where "."uname='".$_USERS['uname']."' and state = 3");
	$COUNT_SENDORDER23=DB::result_first("Select count(sid) From ".DB::table('sendorder')." where "."uname='".$_USERS['uname']."' and state in(2,3)");
	$COUNT_SENDORDERSERVER=DB::result_first("Select count(sid) From ".DB::table('sendorder')." where "."uname='".$_USERS['uname']."' and state =3 and commenttime is null");

}elseif ($action=="guestbook"){
	InitGP(array("msg","code"),1); //初始化变量全局返回
	include(INC_PATH."/code/securimage.php");
	$img = new Securimage();
	$valid = $img->check($code);
	if($valid != true) {
		print("<script language='javascript'>alert('验证码错误');history.go(-1);</script>");
		exit();
  	}
	if(empty($msg) && strlen($msg) < 4) {
		print("<script language='javascript'>alert('留言内容少于四个字符或者为空！');history.go(-1);</script>");
		exit();
  	}
	include_once(INC_PATH."/guestbook.class.php");
	$Table=new GuestBookClass();
	$addarray=array(
		'uid'=>$_USERS['uid'],
		'uname'=>$_USERS['uname'],
		'addtime'=>$timestamp,
		'msg'=>$msg,
		'state'=>0,
		'hide'=>1
	);
	$info=$Table->add($addarray);
	if (GetNum($info)) {
		print("<script language='javascript'>alert('您的提问发布成功，请耐心等待管理员回复！');</script>");
		jumpurl(url('m.php?name=guestbooklist'));			
	}else{
		print("<script language='javascript'>alert('发布提问失败，请稍微重试！');</script>");
		jumpurl(url('m.php?name=guestbooklist'));
	}

}elseif ($action=="upmember"){
	//会员升级操作
	include_once(INC_PATH."/member.class.php");
	$m=new memberclass();

	if($_USERS['utype']==0){
		if($_USERS['scores']>=$cfg_vip_score1){
			$note="金卡会员升级";
			$m->scoreedit($_USERS['uname'],-$cfg_vip_score1,$note);			
			editstate('users',"utype","uname='".$_USERS['uname']."'",1);//更改会员等级操作
			editstate('users',"validity","uname='".$_USERS['uname']."'",time()+3600*24*$cfg_vip_validity);//更改会员有效期操作
			print("<script language='javascript'>alert('升级黄金会员成功！');</script>");
		    jumpurl(url('m.php'));
		}else{
			print("<script language='javascript'>alert('积分不足！升级金卡会员需要积分{$cfg_vip_score1}');history.go(-1);</script>");
			exit();		
		}
	}elseif ($_USERS['utype']==1){
		if($_USERS['scores']>=$cfg_vip_score2){
			$note="白金卡会员升级";
			$m->scoreedit($_USERS['uname'],-$cfg_vip_score2,$note);			
			editstate('users',"utype","uname='".$_USERS['uname']."'",2);//更改会员等级操作			
			editstate('users',"validity","uname='".$_USERS['uname']."'",time()+3600*24*$cfg_vip_validity);//更改会员有效期操作
			print("<script language='javascript'>alert('升级白金卡会员成功！');</script>");
		    jumpurl(url('m.php'));
		}else{
			print("<script language='javascript'>alert('积分不足！升级白金卡会员需要积分{$cfg_vip_score2}');history.go(-1);</script>");
			exit();		
		}		
	
	}elseif ($_USERS['utype']==2){
		if($_USERS['scores']>=$cfg_vip_score3){
			$note="钻石卡会员升级";
			$m->scoreedit($_USERS['uname'],-$cfg_vip_score3,$note);			
			editstate('users',"utype","uname='".$_USERS['uname']."'",3);//更改会员等级操作				
			editstate('users',"validity","uname='".$_USERS['uname']."'",time()+3600*24*$cfg_vip_validity);//更改会员有效期操作
			print("<script language='javascript'>alert('升级钻石卡会员成功！');</script>");
		    jumpurl(url('m.php'));
		}else{
			print("<script language='javascript'>alert('积分不足！升级钻石卡会员需要积分{$cfg_vip_score3}');history.go(-1);</script>");
			exit();		
		}
	}elseif ($_USERS['utype']==3){
			print("<script language='javascript'>alert('您已经是最高级会员，无需升级！');history.go(-1);</script>");
			exit();
	}

}


include template('member_index');//包含输出指定模板
?>