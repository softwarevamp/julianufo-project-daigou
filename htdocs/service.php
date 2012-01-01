<?php
//帮助中心
include("common.inc.php");
InitGP(array("action","type",'page')); //初始化变量全局返回

//帮助信息
$wheresql="";
$articleobj=new TableClass('article','aid');
$helparray=$articleobj->getdata(5,$wheresql,"",'aid,typeid,title');

if (empty($action) || $action=='alipay') {
	include template('service/alipay');//包含输出指定模板
}elseif ($action=="game"){
	include template('service/game');//包含输出指定模板
}elseif ($action=="qq"){
	include template('service/qq');//包含输出指定模板
}elseif ($action=="tenpay"){
	include template('service/tenpay');//包含输出指定模板
}elseif ($action=="other"){
	include template('service/other');//包含输出指定模板	
}elseif ($action=="card"){
	include template('service/card');//包含输出指定模板	
}elseif($action=='add'){	//处理添加操作
	checklogin();//检查是否登录
	$serviceobj=new TableClass('service','sid');
	header("Content-type: text/html; charset=".CHARSET);
	if ($type=='alipay') {
		InitGP(array("account","money")); //初始化变量全局返回
		$money=GetNum($money);
		if (empty($account)||empty($money)) {
			exit("<script language='javascript'>alert(".lang('no_empty').");history.go(-1);</script>");
		}
		//处理插入数据库操作
		$addarray=array(
			'uid'=>$_USERS['uid'],
			'uname'=>$_USERS['uname'],
			'name'=>lang('zhifubao_pay'),
			'account'=>$account,
			'amount'=>$money,
			'price'=>0,
			'num'=>0,
			'money'=>$money,
			'remark'=>'',
			'type'=>0,
			'addtime'=>time(),
			'state'=>0
		);

	}elseif ($type=='game'){
		InitGP(array("vendor","product",'num','gamearea','account')); //初始化变量全局返回
		include_once(ROOT_PATH.'/images/js/productlist.php');	//引入价格数组
		$num=(int)$num;
		$vendor=(int)$vendor;
		$product=(int)$product;
		$gamename=$tempname=$amount='';
		$price=0;
		foreach ($vendorArr as $row){
			if ($row[1]==$vendor) {
				$gamename=$row[0];
			}
		}
		$tempname="Arr{$vendor}";
		foreach ($$tempname as $r){
			if ($r[1]==$product) {
				$price=$r[2];
				$amount=$r[0];
			}
		}
		if (empty($account))exit("<script language='javascript'>alert(".lang('play_ac').");history.go(-1);</script>");
		if (empty($vendor))exit("<script language='javascript'>alert(".lang('mustchoo_p').");history.go(-1);</script>");
		if (empty($gamename))exit("<script language='javascript'>alert(".lang('mustchoo_p').");history.go(-1);</script>");
		if (empty($product))exit("<script language='javascript'>alert(".lang('mustchoo_m').");history.go(-1);</script>");
		if (empty($price)||empty($amount))exit("<script language='javascript'>alert(".lang('mustchoo_mtwo').");history.go(-1);</script>");
		if (empty($num)||$num<0)exit("<script language='javascript'>alert(".lang('mustchoo_num').");history.go(-1);</script>");

		
		//处理插入数据库操作
		$addarray=array(
			'uid'=>$_USERS['uid'],
			'uname'=>$_USERS['uname'],
			'name'=>$gamename.'>'.$gamearea,
			'account'=>$account,
			'amount'=>$amount,
			'price'=>GetNum($price),
			'num'=>$num,
			'money'=>GetNum($price*$num),
			'remark'=>'',
			'type'=>1,
			'addtime'=>time(),
			'state'=>0
		);
	}elseif ($type=='qq'){
		InitGP(array("cat","amount",'qq')); //初始化变量全局返回
		//处理插入数据库操作
		$addarray=array(
			'uid'=>$_USERS['uid'],
			'uname'=>$_USERS['uname'],
			'name'=>Char_cv($cat),
			'account'=>$qq,
			'amount'=>$amount,
			'price'=>GetNum($amount),
			'num'=>1,
			'money'=>GetNum($amount),
			'remark'=>'',
			'type'=>2,
			'addtime'=>time(),
			'state'=>0
		);
	}elseif ($type=='tenpay'){
		InitGP(array("account","money")); //初始化变量全局返回
		$money=GetNum($money);
		if (empty($account)||empty($money)) {
			exit("<script language='javascript'>alert(".lang('no_empty').");history.go(-1);</script>");
		}
		//处理插入数据库操作
		$addarray=array(
			'uid'=>$_USERS['uid'],
			'uname'=>$_USERS['uname'],
			'name'=>lang('caifutong_pay'),
			'account'=>$account,
			'amount'=>$money,
			'price'=>$money,
			'num'=>1,
			'money'=>$money,
			'remark'=>'',
			'type'=>3,
			'addtime'=>time(),
			'state'=>0
		);
	}elseif ($type=='other'){
		InitGP(array("webname","weburl",'account','money','remark')); //初始化变量全局返回
		$money=GetNum($money);
		if (empty($account)||empty($money)) {
			exit("<script language='javascript'>alert(".lang('not_empty').");history.go(-1);</script>");
		}
		if (empty($webname))exit("<script language='javascript'>alert(".lang('website_noempty').");history.go(-1);</script>");
		//处理插入数据库操作
		$addarray=array(
			'uid'=>$_USERS['uid'],
			'uname'=>$_USERS['uname'],
			'name'=>lang('website').'[<a href=\"'.$weburl.'\" target=\"_blank\">'.$webname.'</a>]'.lang('Recharge'),
			'account'=>$account,
			'amount'=>$money,
			'price'=>$money,
			'num'=>1,
			'money'=>$money,
			'remark'=>Char_cv($remark),
			'type'=>4,
			'addtime'=>time(),
			'state'=>0
		);
		
	}elseif ($type=='card'){
		InitGP(array("bankname","account",'amount','money')); //初始化变量全局返回
		$money=GetNum($money);
		if (empty($account)||empty($money)||$money<0) {
			exit("<script language='javascript'>alert(".lang('Credit_card_noempty').");history.go(-1);</script>");
		}
		if (empty($bankname))exit("<script language='javascript'>alert(".lang('Bankname_noempty').");history.go(-1);</script>");
		//处理插入数据库操作
		$addarray=array(
			'uid'=>$_USERS['uid'],
			'uname'=>$_USERS['uname'],
			'name'=>$bankname,
			'account'=>$account,
			'amount'=>$money,
			'price'=>$money,
			'num'=>1,
			'money'=>$money,
			'remark'=>'',
			'type'=>5,
			'addtime'=>time(),
			'state'=>0
		);	
		
	}else{exit(lang('Parameter_error'));}
	
	$info=$serviceobj->add($addarray);
	if (GetNum($info)) {
		print("<script language='javascript'>alert(".lang('submit_success').");</script>");
		//include_once(INC_PATH."/sendqq.func.php");
		
		//$msg="有新的充值信息!请尽快处理!充值订单ID:".$info;
		//send_qq_msg('527774557',$msg);
		
		jumpurl(url("service.php"));			
	}

}else{
	exit(lang('Missing_parameter'));
}
?>