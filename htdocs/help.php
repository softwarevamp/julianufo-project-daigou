<?php
//帮助中心
include("common.inc.php");
InitGP(array("action","id","keyword","referer","aid","cityid")); //初始化变量全局返回
//创建对象
$atypeobj=new TableClass('atype','typeid');
$articleobj=new TableClass('article','aid');
$atypearray=$atypeobj->getdata('','','typeid asc');
$articlearray=$articleobj->getdata('','','aid asc','aid,typeid,title');
if (empty($action)) {
	$id=GetNum($id);
	foreach ($atypearray as $r){
		if ($r['node']==$id) {
			$rightatypearray[]=$r;
		}
	}
	//$rightatypearray=$atypearray;
	$rightarticlearray=$articlearray;
	include template('help');//包含输出指定模板
}elseif ($action=='list'){
	$typeid=GetNum($id);
	if (!empty($typeid)) {
		$rightatypearray=$atypeobj->getdata('','typeid='.$typeid,'typeid asc');
		$rightarticlearray=$articleobj->getdata('','typeid='.$typeid,'aid asc','aid,typeid,title');
	}elseif (!empty($keyword)){
	$keyword=Char_cv($keyword);
	$rightatypearray=$atypearray;
	$rightarticlearray=$articleobj->getdata('','title like \'%'.$keyword.'%\'','aid asc','aid,typeid,title');
	}else {
		$rightatypearray=$atypearray;
		$rightarticlearray=$articlearray;	
	}
	include template('help');//包含输出指定模板
}elseif($action=='view'){
	$aid=GetNum($id);
	if (!empty($aid)) {
		$value=$articleobj->getone($aid);
		$i=0;
		foreach ($articlearray as $r){
			if ($r['typeid']==$value['typeid']) {
				$articlelist[]=$r;
				if ($r['aid']>$aid and $i==0) {
					$nextvalue=$r;
					$i++;
				}
			}
		}
		foreach ($atypearray as $r){
			if ($value['typeid']==$r['typeid']) {
				$position=$r;
			}
		}
		
	include template('help_view');//包含输出指定模板	
	}else {
		print("<script language='javascript'>alert(".lang('Missing_parameter').");</script>");
		jumpurl(url('help.php'));		
	}
}
?>