<?php
include("common.inc.php");
InitGP(array("action","keyword","refuname","referer","aid","cityid")); //初始化变量全局返回
//当前版本:Taoapi TOP PHP SDK 2.2
header("Content-type:text/html; charset=UTF-8");
include_once 'library/Taoapi.php';

$Taoapi_Config = Taoapi_Config::Init();
$Taoapi_Config->setCharset('UTF-8');
$Taoapi = new Taoapi;
if(!empty($keyword)){
//搜索商品信息(taobao.items.search)
$Taoapi->method = 'taobao.items.search';
$Taoapi->fields = 'iid,detail_url,pic_url,num_iid,title,nick,type,cid,seller_cids,props,input_pids,input_str,desc,pic_path,num,valid_thru,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,has_showcase,modified,increment,auto_repost,approve_status,postage_id,product_id,auction_point,property_alias,itemimg,propimg,sku,outer_id,is_virtural,is_taobao,is_ex,video,itemList,categoryList';
$Taoapi->q = $keyword;
$Taoapi->cid = '16';
$Taoapi->order_by = 'seller_credit';
$Taoapi->is_mall = 'true';

//需要更多的字段可以登陆 taoapi.com 进行配置生成
$TaobaokeData = $Taoapi->Send('get','xml')->getArrayData();

}

echo '<pre>';

//检测API是否遇到错误
if($Taoapi->getErrorInfo())
{
	echo lang('api_error');
	
	print_r($Taoapi->getErrorInfo());
}

//打印获取到的API数据结果
print_r($TaobaokeData[item_search][items][item]);
print_r($TaobaokeData[total_results]);

echo'</pre>';


?>
<form action=""/>
<input type="text" name="keyword" value=""/><input type=submit value="搜索"/>
</form>