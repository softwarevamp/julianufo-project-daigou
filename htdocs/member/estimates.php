<?php
//我的劵
InitGP(array("action","bid","page")); //初始化变量全局返回


	//获取地区信息
	$areaobj=new TableClass('area','aid');
	$areaarray=$areaobj->getdata('','state=1');


include template('member_estimates');//包含输出指定模板
?>