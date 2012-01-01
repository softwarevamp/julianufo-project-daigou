<?php
//我的劵
InitGP(array("action","type","bid","page")); //初始化变量全局返回
$r=new TableClass("address","aid");
if (empty($action)) {
	$defaid=DB::result_first("select aid from ".DB::table("address")." where def=1 and uname='".$_USERS['uname']."'");
	if (empty($defaid)) {
		$defaid=-1;
	}
	include template('member_myaddress');//包含输出指定模板
}elseif ($action=="get"){
	if(!empty($_USERS['uname'])){
		$uname=$_USERS['uname'];
		$wherestr[]="uname='{$uname}'";
		if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
		//获取当前页码
		$dataarray=$r->getdata("",$wheresql); //获取团购数据
		$temparray=array();
		foreach ($dataarray as $key=>$val){
			$temparray[$key]['ID']=$val['aid'];
			$temparray[$key]['AreaID']=$val['aid'];
			$temparray[$key]['CountryName']=$val['country'];
			$temparray[$key]['CityName']=$val['city'];
			$temparray[$key]['Telephone']=$val['tel'];
			$temparray[$key]['Consignee']=$val['consignee'];
			$temparray[$key]['Postcode']=$val['zip'];
			$temparray[$key]['Address']=$val['address'];
			$temparray[$key]['Postcode']=$val['zip'];
			$temparray[$key]['Postcode']=$val['zip'];
		}
	}
	echo json_encode($temparray);
}elseif ($action=="add"){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$tempid=GetNum($jsondata->id);
	$addarray=array(
		'uid'=>$_USERS['uid'],
		'uname'=>$_USERS['uname'],
		'consignee'=>Char_cv($jsondata->consignee),
		'country'=>Char_cv($jsondata->country),
		'city'=>Char_cv($jsondata->city),
		'zip'=>Char_cv($jsondata->zip),
		'tel'=>Char_cv($jsondata->teltphone),
		'address'=>Char_cv($jsondata->address)
	);
	if ($tempid > 0) {
		//编辑
		$r->edit($tempid,$addarray);
		$rjson['d']=1;
	}else{
		//增加
		$info=$r->add($addarray);
		$rjson['d']=$info;
	}
	echo json_encode($rjson);
	
}elseif($action=="setdefault"){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$aid=GetNum($jsondata->id);
	$wheresqlarr="uname='".$_USERS['uname']."'";
	$wheresqlarr2="uname='".$_USERS['uname']."' and aid=".$aid;
	editstate($r->table,"def",$wheresqlarr,0);//更改状态操作
	editstate($r->table,"def",$wheresqlarr2,1);//更改状态操作
	$rjson['d']="success";
	echo json_encode($rjson);
}elseif ($action=="del"){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$aid=GetNum($jsondata->id);
	$r->del($aid,$_USERS['uname']);
	$rjson['d']="success";
	echo json_encode($rjson);
}

?>