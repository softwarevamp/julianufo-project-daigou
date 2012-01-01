<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","type","aid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("service","aid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("state","orderby","orderway","keywords")); //初始化变量全局返回
	if(!empty($state))$wherestr[]="state='{$state}'";
	if($type!=null)$wherestr[]="type='{$type}'";
	if(!empty($keywords))$wherestr[]=" CONCAT(aid,' ',uname,' ',account) like '%$keywords%' ";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	
	$orderway=$orderway=="desc"?"desc":"asc";
	if(!empty($orderby))$orderstr="{$orderby} {$orderway}";

	//获取当前页码
	$total=$Table->getcount($wheresql); 							  //总信息数
	$pagesize=15;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$Table->getdata("$offset,$pagesize",$wheresql,$orderstr); //获取团购数据
	//print_r($dataarray);
	
	//包含后台模板文件
	include("tpl/service_list.htm");
}elseif($action=="edit") {
	InitGP(array("mid","mname","type","node","murl","listorder","mcode","Submit")); //初始化变量全局返回
	if(!empty($Submit)){
		$mid=GetNum($mid);
		if($type=="zone")$node=0;
		if($mid==0)showmsg("缺少ID参数!",-1);//成功
		$arrayedit=array(
			"mname"=> Char_cv($mname),
			"type"=> Char_cv($type),
			"node"=> GetNum($node),
			"murl"=> Char_cv($murl),
			"listorder"=>GetNum($listorder) ,
			"mcode"=> Char_cv($mcode)
		);
		$info=$Table->edit($mid,$arrayedit);
		if($info=="OK"){
			showmsg("编辑成功!",PHP_SELF);//成功
		}else showmsg($info,"-1");//出错！	
	
	}else{
	$evalue=$Table->getone($mid);
	}
}elseif ($action=="updatestate" && !empty($ids) && !empty($state)){
	//更改状态
	
	$state=GetNum($state);
	$ids=getdotstring(explode('|',$ids));
	$wheresqlarr="aid in({$ids})";
	editstate($Table->table,"state",$wheresqlarr,$state);//更改状态操作
	exit("1");
}elseif ($action=="updateremark" && !empty($ids) && !empty($value)){
	//更改状态
	$ids=GetNum($ids);
	$wheresqlarr="aid ={$ids}";
	$value=Char_cv($value);
	editstate($Table->table,"remark",$wheresqlarr,$value);//更改状态操作	
	exit("1");

}elseif ($action=="changestate" && !empty($aid)){
	//更改状态
	$aid=GetNum($aid);
	$wheresqlarr="aid ={$aid}";
	editstate($Table->table,"state",$wheresqlarr,1);//更改状态操作
	showmsg("修改状态成功!","-1");//成功提示！
	
}elseif ($action=="chargeback" && !empty($aid)){
	//更改状态
	$aid=GetNum($aid);
	$wheresqlarr="aid ={$aid}";
	$row=$Table->getone($aid);
	
	$umoney=DB::result_first("Select money From `{$Table->table}` where uname like '{$row['uname']}' ");
	if($umoney<$row['money'])showmsg("用户帐户余额不足!扣费失败!","-1");//成功提示！
	
	include_once(INC_PATH."/member.class.php");
	$m=new memberclass();
	
	
	$note=$row['name'].' 账户:'.$row['account'].'充值扣费'.$row['money']."服务订单ID:".$row['aid'];
	$m->moneyedit($row['uname'],-$row['money'],0,$note);//扣去账户余额	
	
	editstate($Table->table,"state",$wheresqlarr,2);//更改状态操作
	showmsg("修改状态并且扣费成功!","-1");//成功提示！
	
}else{
	showmsg("未知请求","-1");//出错！
}


?>