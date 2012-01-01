<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","value","ids","keywords","firstmonth","endmonth","name")); //初始化变量全局返回
$orderTable=new TableClass("order","oid");
$sendorderTable=new TableClass("sendorder","sid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("orderby","orderway")); //初始化变量全局返回
	
	
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	//年度统计数据
		$ordersql="select sum(goodsprice+sendprice) from {$tablepre}order";
		$orderquery =$db->result_first($ordersql);
		$sendordersql="select sum(Insurancefee + totalfee) from {$tablepre}sendorder";
		$sendorderquery =$db->result_first($sendordersql);
		
		$serverfeesql="select sum(serverfee) from {$tablepre}sendorder";
		$serverfeequery=$db->result_first($serverfeesql);
		$allmoney=$orderquery+$sendorderquery;		
		
	$dataarray=array();
	if(!empty($keywords))
	{
		$year=$keywords;
		
	}else{
		$year=date('Y');
	}
	$month='';
	$j='';

	if(!empty($firstmonth)){
		$first=$firstmonth;
	}else{
		$first=1;
	}
	if(!empty($endmonth)){
	  $end=$endmonth;
	}else{
		$end=12;
	}
    for($month=$first;$month<=$end;$month++){
	   
	
	 $j=$month+1;
	 if($j==13)$j=1;

  	   $starttime=strtotime($year."-".$month."-1");
	   $endtime=strtotime($year."-".$j."-1");
	   if($starttime<time()){

		$Quartersendordersql="SELECT sum( Insurancefee +  totalfee ) FROM {$tablepre}sendorder WHERE addtime BETWEEN ".$starttime." AND ".$endtime;
		$Quarterordersql="SELECT sum(goodsprice+sendprice) FROM {$tablepre}order WHERE addtime BETWEEN ".$starttime." AND ".$endtime;
		$Quartersendorderdata=$db->result_first($Quartersendordersql);
		$Quarterorderdata=$db->result_first($Quarterordersql);
		$Quarterdata=$Quartersendorderdata+$Quarterorderdata;
		$serverfeesql="select sum(serverfee) from {$tablepre}sendorder WHERE addtime BETWEEN ".$starttime." AND ".$endtime;
		$serverfeedata=$db->result_first($serverfeesql);
		$dataarray[$month]['allmoney']=getNum($Quarterdata);
		$dataarray[$month]['sendorderdata']=getNum($Quartersendorderdata);
		$dataarray[$month]['orderdata']=getNum($Quarterorderdata);
		$dataarray[$month]['servermoney']=getNum($serverfeedata);
		
	  }
  }
	//$orderway=$orderway=="asc"?"asc":"desc";
	//if(!empty($orderby))$orderstr="{$orderby} {$orderway}";

	//获取当前页码
	//$total=$Table->getcount($wheresql); 							  //总信息数
	//$pagesize=15;												  //一页显示信息数
	//$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	//$offset=($page-1)*$pagesize;   								  //偏移量
	//$dataarray=$Table->getdata("$offset,$pagesize",$wheresql,$orderstr); //获取团购数据

	//包含后台模板文件
	include("tpl/fs_list.htm");
}else{
	showmsg("未知请求","-1");//出错！
}

 ?>