<?php
//我的劵
header("content-type: text/html; charset=utf-8");
InitGP(array('action','rid')); //初始化变量全局返回
$r=new TableClass("refund","rid");

if (empty($action)) {
	if(!empty($_USERS['uname'])){
		$uname=$_USERS['uname'];
		$wherestr[]="uname='{$uname}'";
		if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
		//获取当前页码
		$dataarray=$r->getdata("",$wheresql); //获取团购数据
	}
}elseif ($action=='refund' && !empty($rid)){
	$rid=GetNum($rid);
	if ($rid) {
		$recharge=new TableClass("rechargerecord","rid");
		$row=$recharge->getone($rid);
		if (!empty($_POST)) {
			InitGP(array('money','remark')); //初始化变量全局返回
			$addarray=array(
				'rechargeid'=>$rid,
				'uid'=>$_USERS['uid'],
				'uname'=>$_USERS['uname'],
				'money'=>GetNum($money),
				'remark'=>Char_cv($remark),
				'rechargetime'=>$row['successtime'],
				'rechargemoney'=>$row['money'],
				'rechargesn'=>$row['sn'],
				'addtime'=>time()
			);
			$info=$r->add($addarray);
			if (GetNum($info)) {
				print("<script language='javascript'>alert(".lang('apply_success').");</script>");
				jumpurl(url('m.php?name=refundrecord'));
			}else {
				print("<script language='javascript'>alert(".lang('apply_error').");</script>");
				jumpurl(url('m.php?name=refundrecord&action=refund&'.$rid));
			}
		}
	}
}

//print_r($dataarray);

include template('member_refundrecord');//包含输出指定模板
?>