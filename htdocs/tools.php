<?php
include("common.inc.php");
InitGP(array("action","id","keyword","referer","aid","cityid")); //初始化变量全局返回
//创建对象
$atypeobj=new TableClass('atype','typeid');
$articleobj=new TableClass('article','aid');
$atypearray=$atypeobj->getdata('','','typeid asc');
$articlearray=$articleobj->getdata('','','aid asc','aid,typeid,title');
include template('tools');//包含输出指定模板
?>