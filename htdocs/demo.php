<?php
include("common.inc.php");
InitGP(array("action","refuid","refuname","referer","aid","cityid")); //初始化变量全局返回

if(empty($action)){

include template('demo');//包含输出指定模板

}elseif($action=="demo"){

include template('Lesson');

}






?>