<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","payid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("order","oid");
AjaxHead();//禁止页面缓存
header("Content-type: text/html; charset=".CHARSET);
if(empty($action)){
	InitGP(array("oid","uid","uname","goodsurl","goodsname","goodsprice","oldgoodsprice","sendprice","oldsendprice","goodsnum","goodssize","goodscolor","goodsseller","sellerurl","expressno","goodsremark","orderweight","orderremark","payid","state")); //初始化变量全局返回
	if(!empty($_POST) and GetNum($oid)){
		$oid=GetNum($oid);
		//处理价格和运费修改扣除用户相应金额账户余额
		
		if($goodsprice!=$oldgoodsprice){
			//商品价格调整
			$tempmoney=0;
			$tempmoney=GetNum($oldgoodsprice-$goodsprice);
			include_once(INC_PATH."/member.class.php");
			$m=new memberclass();
			$note="调整商品<a href=\'".$goodsurl."\' target=\'_blank\'>《".$goodsname."》</a>价格：".-$tempmoney."订单ID:".$oid;
			$m->moneyedit($uname,$tempmoney,5,$note);//扣去账户余额
		}
		if($sendprice!=$oldsendprice){
			//商品运费调整
			$tempmoney=0;
			$tempmoney=GetNum($oldsendprice-$sendprice);//计算运费调整
			$wheresqlarr="uname = '".$uname."' and goodsseller = '".$goodsseller."' and state < 3";
			editstate($Table->table,"sendprice",$wheresqlarr,$sendprice);//更改状态操作
			
			include_once(INC_PATH."/member.class.php");
			$m=new memberclass();			
			$note="调整商品<a href=\'".$goodsurl."\' target=\'_blank\'>《".$goodsname."》</a>运费：".-$tempmoney."订单ID:".$oid;
			$m->moneyedit($uname,$tempmoney,5,$note);//扣去账户余额
		}
		
		$arrayedit=array(
			"goodsurl"=> $goodsurl,
			"goodsname"=> Char_cv($goodsname),
			"goodsprice"=> GetNum($goodsprice),
			"sendprice"=> GetNum($sendprice),
			"goodsnum"=> GetNum($goodsnum),
			"goodssize"=> Char_cv($goodssize),
			"goodscolor"=> Char_cv($goodscolor),
			"goodsseller"=> Char_cv($goodsseller),
			"goodsremark"=> Char_cv($goodsremark),
			"orderremark"=> Char_cv($orderremark),
			"sellerurl"=> $sellerurl,
			"expressno"=> $expressno,
			"orderweight"=>GetNum($orderweight),
			"state"=>GetNum($state),
			"payid"=> Char_cv($payid),
			"uptime"=>time()
		);
		$info=$Table->edit($oid,$arrayedit);
		if($info=="OK"){
			exit("<script language='javascript'>alert('编辑成功');parent.parent.$.fn.colorbox.close();</script>");
		}else{
			exit("<script language='javascript'>alert('编辑失败');parent.location.reload();</script>");
		}	
	}else{
		$evalue=$Table->getone($oid);
		//print_r($evalue);
		include("tpl/order_edit.htm");
	}
}
?>