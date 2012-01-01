<?php
include("../common.inc.php");
InitGP(array("page","action","aid","delids")); //初始化变量全局返回
include("function_common.php");
cache_page_clear();
showmsg("清空缓存成功！","-1");



?>