<?php
//我的劵
InitGP(array("action","type","oid","page")); //初始化变量全局返回
include_once(INC_PATH."/sendorder.class.php");
$o=SendOrderClass::init();
AjaxHead();
if(empty($action)){
	$uname=$_USERS['uname'];
	$wherestr[]="uname='{$uname}'";
	if($type==1){
		$wherestr[]="state in(2,3)";
	}elseif($type==2){
		$wherestr[]="state =3";
		$wherestr[]="commenttime is null";
	}
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$dataarray=$o->getdata("",$wheresql,""); //获取团购数据

}elseif($action=='cancel'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$info=$o->del($jsondata->id);
	if ($info=="OK") {
		exit(json_encode('OK'));
	}else{
		exit(json_encode($info));
	}
}elseif ($action=='receive'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	if(!empty($jsondata->id)){
		$tempid=GetNum($jsondata->id);
		$wheresqlarr="uname='".$_USERS['uname']."' and sid=".$tempid;
		$sendorders=$o->getone($tempid,"uname,totalfee,state");
		if (empty($tempid)) {
			exit(json_encode(lang('update_failed')));
		}
		if ($sendorders['state']==3 || $sendorders['state']==4) {
			exit(json_encode(lang('update_failed')));
		}
		editstate($o->table_sendorder->table,"state",$wheresqlarr,3);//更改状态操作
		if (!empty($sendorders['totalfee'])) {
		//增加用户积分,后台设置的有就用后台的设置，没有就用购买商品价值
			if(!empty($cfg_sendorder_score))$tempscore=$cfg_sendorder_score;
			else $tempscore=$sendorders['totalfee'];
			
			include_once(INC_PATH."/member.class.php");
			$m=new memberclass();		
			$tempscore=$sendorders['totalfee'];
			$note=lang('sendorder_success_point').$tempscore.lang('sendorderID').$tempid;
			$m->scoreedit($sendorders['uname'],$tempscore,$note);
		}
		exit(json_encode('OK'));
	}else {
		exit(json_encode(lang('update_failed')));
	}
}elseif ($action=='upcomment'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	if(!empty($jsondata->comment)&&!empty($jsondata->sid)){
		$tempcomment=Char_cv($jsondata->comment);
		$tempsid=GetNum($jsondata->sid);
		$wheresqlarr="uname='".$_USERS['uname']."' and sid=".$tempsid;
		editstate($o->table_sendorder->table,"comment",$wheresqlarr,$tempcomment);//更改状态操作
		editstate($o->table_sendorder->table,"commenttime",$wheresqlarr,time());//更改状态操作
		exit(json_encode('OK'));
	}else {
		exit(json_encode(lang('update_failed')));
	}
}

//print_r($dataarray);




include template('member_sendorderlist');//包含输出指定模板
?>