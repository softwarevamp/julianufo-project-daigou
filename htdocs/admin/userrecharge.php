<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","payid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("rechargerecord","rid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("uid","sn","uname","money","paytype","payname","remark")); //初始化变量全局返回
	if(!empty($_POST) and !empty($uname)){
	
		$uid=DB::result_first("select uid from ".DB::table('users')." where uname = '{$uname}'");//查询uid
		$uid=GetNum($uid);
		if($uid==0)showmsg("用户名不存在!","-1");//出错！
		$arrayadd=array(
			"uid"=> $uid,
			"uname"=> Char_cv($uname),
			"sn"=> GetNum($sn),
			"money"=> GetNum($money),
			"paytype"=> GetNum($paytype),
			"payname"=> Char_cv($payname),
			"remark"=> Char_cv($remark),
			"addtime"=> $timestamp,
			"successtime"=> $timestamp,
			"state"=> 2
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
			include_once(INC_PATH."/member.class.php");
			$m=new memberclass();
			if($m->moneyedit($uname,$money,"后台转账充值")){
				showmsg("充值成功!",PHP_SELF);//出错！
				exit("<script language='javascript'>alert('编辑成功');parent.parent.$.fn.colorbox.close();</script>");
			}else{
				$Table->del($info);
				showmsg("充值失败!","-1");//出错！
			}
		}else{
			showmsg("充值失败!","-1");//出错！
			exit("<script language='javascript'>alert('编辑失败');parent.location.reload();</script>");
		}
	}else{
		$evalue=$Table->getone($uid);
		//充值编号
		$autokeys=randomkeys(3,"123");//随机5位数字
		$timestr=date('YmdHis');
		$sn=$timestr.$autokeys;
		//print_r($evalue);
		include("tpl/userrecharge.htm");
	}

}else{
	showmsg("未知请求","-1");//出错！
}

?>