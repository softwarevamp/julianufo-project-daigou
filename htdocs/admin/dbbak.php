<?php
include("../common.inc.php");
ini_set('memory_limit', '50M');
include("function_common.php");

require_once('mysqlbak.class.php');
InitGP(array('action','dbdir','gzip')); //初始化变量全局返回
//$db->link;
$backupDir = 'data';
$gzip=$gzip?1:0;
$config = array(
'host' => $dbhost,
'port' => 3306,
'userName' => $dbuser,
'userPassword' => $dbpw,
'charset' => $dbcharset,
'path' => './'.$backupDir.'/',
'isCompress' => $gzip,
'isDownload' => 0,
);
$mr = new MySQLReback($config);
$mr->setDBName($dbname);
//$mr->recover('backup@artas_test@20090707080609.sql.gz');
if($action=="backup"){
$mr->backup();
showmsg("备份数据库成功!","dbbak.php");
}elseif ($action=="restore" and !empty($dbdir))
{
$mr->recover($dbdir);
showmsg("恢复数据库成功!","dbbak.php");

}elseif ($action=="del" and !empty($dbdir)){
$filepath='./'.$backupDir.'/'.$dbdir;
@unlink($filepath);
showmsg("删除数据库备份成功!","dbbak.php");

}elseif ($action=="down" and !empty($dbdir)){
$filepath='./'.$backupDir.'/'.$dbdir;
$mr->downloadFile($filepath);

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>管理区域</title>
<style type="text/css">
body {
	padding-left: 0px;
	padding-right: 0px;
	padding-top: 0px;
	padding-bottom: 0px;
	margin: 0px;

}
html {
	background-color: #F9F9F9;
	padding-left: 0px;
	padding-right: 0px;
	padding-top: 0px;
	padding-bottom: 0px;
	margin: 0px;
}
body {
	background-color: #F9F9F9;
	font-family: Verdana, Arial,Vrinda,Tahoma;
	line-height: 175%;
	font-size:12px;
	color:#666;
}
a {
	color: #555;
	text-decoration:none;
}
a:hover {
	color: #0099CC;
}
#man_zone {
	min-height:500px;
	width: 99%;
	border: 1px solid #B4C9C6;
	margin: 6px 0 0 0;
	background-color:#FFFFFF;
	padding: 5px 0 5px 0;
	overflow: auto;
}
#man_zone table{
    background-color:#DBE6E3;
}
#man_zone table tr{
    background-color:#fff;
}

#man_zone table th{
    background-image:url(../images/r2_c13_r2_c2.jpg);
	color:#09c;
}
.left_title_1 {
	background-color: #F3F8F7;
	color:#73938E;
	font-weight:bold;
	line-height:30px;
	text-align:right
}
.left_title_2 {
	background-color: #fff;
	color:#999;
	font-weight:bold;
	line-height:30px;
	text-align:right;
}
#man_zone table tr.marked {
		background-color: #FFF2CA;
}

</style>
</head>

<body>
<div id="man_zone">
  <table width="99%" border="0" align="center"  cellpadding="3" cellspacing="1" class="table_style">
    <tr>
      <td colspan="4" align="center" class="left_title_1"><a href="?action=backup">【点击备份当前数据库】</a><a href="?action=backup&gzip=1">【点击备份当前数据库并压缩】</a></td>
    </tr>
    <tr>
      <td width="36%" align="center" class="left_title_1">数据库备份</td>
      <td width="9%" align="center">备份大小</td>
      <td width="14%" align="center">备份时间</td>
      <td width="41%" align="center">操作</td>
    </tr>
	
	<?php
	$dh = glob($backupDir.'/*');
	krsort($dh);
		foreach($dh as $file){
	$filesize=intval(filesize($file)/1024);
	$filetime=date('Y-m-d H:i:s',filemtime($file));
	$file=substr($file,5);
		
	?>
    <tr>
      <td class="left_title_2"><?php echo $file?>&nbsp;&nbsp;&nbsp;</td>
      <td>&nbsp;<?php echo $filesize?>KB</td>
      <td><?php echo $filetime?></td>
      <td><a  href="javascript:if(confirm('恢复以后无法还原，确定要恢复数据库吗?'))location='?action=restore&amp;dbdir=<?php echo $file?>'">【恢复备份】</a><a  href="javascript:if(confirm('删除以后无法还原，确定要删除数据库备份吗?'))location='?action=del&amp;dbdir=<?php echo $file?>'">【删除备份】</a><a  href="?action=down&amp;dbdir=<?php echo $file?>">【下载到本地】</a></td>
    </tr>
	
	<?php
		}

	
	?>
  </table>
</div>
</body>
</html>
