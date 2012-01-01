<?php
//弹出一键填单相关ajax数据处理
include("../common.inc.php");
InitGP(array("action","url","refuname","referer","aid","cityid")); //初始化变量全局返回
$deliveryobj=new TableClass('delivery','did');
AjaxHead();

if($action=='getdetails'){
	$jsondata = json_decode(str_replace("'", '"',file_get_contents('php://input')));
	$countweight=GetNum($jsondata->TotleWeight);
	$productcost=GetNum($jsondata->TotleProductCost);
	$areaid=GetNum($jsondata->Area);
	
	$returntemp=array();
	//获取地区信息
	$areaobj=new TableClass('area','aid');
	$arearow=$areaobj->getone($areaid);
	$deliveryarray=$deliveryobj->getdata('',"areaid=".$areaid);	
	
	//$serverfee=$arearow['serverfeepct']*$productcost > $arearow['serverfee']?$arearow['serverfee']:$arearow['serverfeepct']*$productcost;
	if (is_array($deliveryarray)) {
		foreach ($deliveryarray as $key=>$val){
			//循环处理数据
			$returntemp[$key]=$val;
			//$returntemp[$key]['serverfee']=$serverfee;
			//计算运费
			if ($countweight <= $val['first_weight']) {
				$freight = $val['first_fee'];
			}elseif ($countweight > $val['first_weight']){
				$freight = $val['first_fee']+ceil((($countweight - $val['first_weight'])/$val['continue_weight']))*$val['continue_fee'];
			}			
			$returntemp[$key]['sendfee']=$freight;
			$returntemp[$key]['serverfee']=$arearow['serverfeepct']*($productcost+$freight) > $arearow['serverfee']?$arearow['serverfee']:$arearow['serverfeepct']*($productcost+$freight);
			$returntemp[$key]['totlefee']=$freight+$returntemp[$key]['serverfee']+$val['customs_fee'];
			
		}
	}
	
	
	
	echo json_encode($returntemp);
	exit;
}
?>