<?php
//我的劵
InitGP(array("action","products","oids","page")); //初始化变量全局返回
if (!empty($products)) {
	$products=array_unique($products);
}
if (empty($oids)) {
	$oids=getdotstring($products,'int');
}else{
	$oids=getdotstring($oids,'int');
}
if (empty($oids)) {
	print("<script language='javascript'>alert('提交缺少订单ID');</script>");
	jumpurl(url('m.php?name=orderlist'));
}
if (empty($action)) {
	//获取团购数据
	include_once(INC_PATH."/order.class.php");
	$o=OrderClass::init();
	$wherestro[]="uname='".$_USERS['uname']."'";
	$wherestro[]="oid in(".$oids.")";
	if(!empty($wherestro)) $wheresqlo = implode(' AND ', $wherestro);	//条件汇总
	$dataarray=$o->getdata("",$wheresqlo,"","oid,uid,uname,goodsurl,goodsname,goodsprice,goodsnum,goodssite,siteurl,orderweight");
	//计算商品总价格和总重量
	$countmoney=$countweight=0;
	$tempoids=array();
	foreach ($dataarray as $value){
		$tempoids[]=$value['oid'];
		$countmoney+=$value['goodsprice']*$value['goodsnum'];
		$countweight+=$value['orderweight'];
	}
	$ids=getdotstring($tempoids,'int');
	$auth=$ids."\t".$countmoney."\t".$countweight;
	$LOCKDATA=cookie_authcode($auth,'ENCODE');//加密数据
	
	//print_r($dataarray);
	
	//获取地区信息
	$areaobj=new TableClass('area','aid');
	$areaarray=$areaobj->getdata('','state=1');
	//获取用户地址
	$addressobj=new TableClass('address','aid');
	$addressarray=$addressobj->getdata('',"uname='".$_USERS['uname']."'","def desc,aid desc");
	
	//获取优惠卷
	include_once(INC_PATH."/coupon.class.php");
	$couponobj=CouponClass::init();	
	$wherestrc[]="uname='".$_USERS['uname']."'";
	$wherestrc[]="endtime >= ".time();
	$wherestrc[]="state = 1";
	if(!empty($wherestrc)) $wheresqlc = implode(' AND ', $wherestrc);	//条件汇总
	$couponarray=$couponobj->getdata("",$wheresqlc,""); //获取数据		
	
	include template('member_tosendorder');//包含输出指定模板
	
}elseif ($action=="save"){
	InitGP(array("action","LOCKDATA","consignee","tel","country","city","address","zip","area","remark","did","usecoupon","couponid")); //初始化变量全局返回
	//创建运送方式对象
	$deliveryobj=new TableClass('delivery','did');
	$areaobj=new TableClass('area','aid');
	$couponid=GetNum($couponid);
	//处理提交信息
	@list($ids, $countmoney,$countweight) = explode("\t", cookie_authcode($LOCKDATA,'DECODE'));
	//if($ids==$oids and !empty($ids) and !empty($countmoney) and !empty($countweight)){  //允许包裹重量为0，所以去掉!empty($countweight)
        if($ids==$oids and !empty($ids) and !empty($countmoney)){
		$oids=$ids;
		$countmoney=GetNum($countmoney);
		$countweight=GetNum($countweight);
	}else{
		exit('数据异常');
	}
	//判断订单状态
	$wherestro[]="uname='".$_USERS['uname']."'";
	$wherestro[]="oid in(".$oids.")";
	if(!empty($wherestro)) $wheresqlo = implode(' AND ', $wherestro);	//条件汇总		
	$query = DB::query("SELECT state FROM ".DB::table('order')." where ".$wheresqlo);
	while ($item = DB::fetch($query)) {
		if ($item['state']!=4) {
			print("<script language='javascript'>alert('重复提交运单或者订单状态异常！');</script>");
			jumpurl(url('m.php?name=orderlist'));			
		}
	}
	
	if (!GetNum($did)) {
		print("<script language='javascript'>alert('缺少运送方式！');</script>");
		jumpurl(url('m.php?name=orderlist'));
	}
	if (empty($consignee)||empty($address)) {
		print("<script language='javascript'>alert('收货人姓名和地址不能为空！');</script>");
		jumpurl(url('m.php?name=orderlist'));
	}
	
	$deliveryrow=$deliveryobj->getone($did);
	if (empty($deliveryrow)) {
		print("<script language='javascript'>alert('运送方式不存在！');</script>");
		jumpurl(url('m.php?name=orderlist'));				
	}
	
	if (empty($deliveryrow) || $deliveryrow['areaid']!=$area) {
		print("<script language='javascript'>alert('运送区域不对照');</script>");
		jumpurl(url('m.php?name=orderlist'));			
	}else{
		$arearow=$areaobj->getone($area);
		if (empty($arearow)) {
			print("<script language='javascript'>alert('运送区域数据不存在');</script>");
			jumpurl(url('m.php?name=orderlist'));				
		}
	}
	//使用优惠卷
	if ($usecoupon==1 && GetNum($couponid)) {
		$wherestrc[]="uname='".$_USERS['uname']."'";
		$wherestrc[]="endtime >= ".time();
		$wherestrc[]="state = 1";
		$wherestrc[]="cid = ".GetNum($couponid);
		if(!empty($wherestrc)) $wheresqlc = implode(' AND ', $wherestrc);	//条件汇总
		$couponmoney = DB::result_first("select money from ".$tablepre."coupon where ".$wheresqlc);
	}else{
		$couponid=0;
	}
	$couponmoney=GetNum($couponmoney);
	//计算开始
	$freight=$serverfee=$totalfee=$customsfee=0;//初始化变量
	//计算运费
	if ($countweight <= $deliveryrow['first_weight']) {
		$freight = $deliveryrow['first_fee'];
	}elseif ($countweight > $deliveryrow['first_weight']){
		$freight = $deliveryrow['first_fee']+ceil((($countweight - $deliveryrow['first_weight'])/$deliveryrow['continue_weight']))*$deliveryrow['continue_fee'];
	}
	//计算服务费

	if (!empty($arearow['serverfeepct'])) {
		$serverfee = ($countmoney+$freight+$deliveryrow['customs_fee'])*$arearow['serverfeepct'];

	if (!empty($arearow['serverfee'])) {
			if ($serverfee > $arearow['serverfee']) {
				$serverfee = $arearow['serverfee'];
			}
		}
	}else{
		$serverfee = $arearow['serverfee'];
	}

	//不同等级会员服务费折扣
	if($_USERS['utype']==1){
		$serverfee *=$cfg_vip_sendfee1;
	}elseif($_USERS['utype']==2){
		$serverfee *=$cfg_vip_sendfee2;
	}elseif($_USERS['utype']==3){
		$serverfee *=$cfg_vip_sendfee3;
	}
	//优惠卷抵消服务费
	if (!empty($couponmoney)) {
		$serverfee = $serverfee-$couponmoney;
		if ($serverfee < 0) {
			$serverfee=0;
		}
	}
	$totalfee = $freight + $serverfee + GetNum($deliveryrow['customs_fee']);
	if ($totalfee > $_USERS['money']) {
		print("<script language='javascript'>alert('账户余额不足！请充值后重新操作！');</script>");
		jumpurl(url('m.php?name=orderlist'));		
	}

	
	$totalfee = sprintf("%01.2f", $totalfee);
	$freight = sprintf("%01.2f", $freight);
	$serverfee = sprintf("%01.2f", $serverfee);
	$deliveryrow['customs_fee'] = sprintf("%01.2f", $deliveryrow['customs_fee']);
	$addarray=array(
		'uid'=>$_USERS['uid'],
		'uname'=>$_USERS['uname'],
		'email'=>$_USERS['email'],
		'oids'=>$oids,
		'couponid'=>GetNum($couponid),
		'freight'=>GetNum($freight),
		'serverfee'=>$serverfee,
		'customsfee'=>$deliveryrow['customs_fee'],
		'totalfee'=>$totalfee,
		'countmoney'=>$countmoney,
		'countweight'=>$countweight,
		'consignee'=>$consignee,
		'country'=>$country,
		'city'=>$city,
		'zip'=>$zip,
		'tel'=>$tel,
		'address'=>$address,
		'remark'=>$remark,
		'did'=>$did,
		'deliveryname'=>$deliveryrow['deliveryname'],
		'areaname'=>$deliveryrow['areaname'],
		'addtime'=>time(),
		'uptime'=>time(),
		'state'=>1
	);
	include_once(INC_PATH."/sendorder.class.php");
	$sendorderobj=SendOrderClass::init();
	$sid=$sendorderobj->add($addarray);
	if (GetNum($sid)) {
		//提交成功,处理扣费和修改订单状态
		include_once(INC_PATH."/member.class.php");
		$m=new memberclass();
		$note="提交运单,运单ID:".$sid;
		$m->moneyedit($_USERS['uname'],- $totalfee,3,$note);//扣费操作
		
		editstate($tablepre."order","state",$wheresqlo,5);//更改订单状态操作
		editstate($tablepre."order","sid",$wheresqlo,$sid);//更改订单对应运单ID操作
		if (GetNum($couponid)){
			editstate($tablepre."coupon","state","cid = ".GetNum($couponid),3);//更改优惠卷状态操作
		}
		//显示成功页面
	
		include template('member_tosendorderok');//包含输出指定模板
		
	}else{
		print("<script language='javascript'>alert('生成送货单出错！');</script>");
		jumpurl(url('m.php?name=orderlist'));			
	}
	
//	print_r($addarray);

}
?>