<?php
//帮助中心
include("common.inc.php");
InitGP(array("action","nid",'page')); //初始化变量全局返回




if (empty($action) || $action=='aboutus') {
	
	include template('about/aboutus');//包含输出指定模板
	
}elseif ($action=="contactus"){

	include template('about/contactus');//包含输出指定模板
}elseif ($action=="joinus"){

	include template('about/joinus');//包含输出指定模板
}elseif ($action=="links"){

	include template('about/links');//包含输出指定模板
		
}elseif ($action=="Agreement"){

	include template('about/Agreement');//包含输出指定模板
		
}elseif ($action=="Customers"){

	include template('about/Customers');//包含输出指定模板
		
}else{
	exit(lang('Missing_parameter'));
}
?>