<?php
include("../common.inc.php");
InitGP(array("action")); //初始化变量全局返回
include("function_common.php");
$configfile = CFG_CACHEPATH.'/config.cache.inc.php';

//更新配置函数
function ReWriteConfig()
{
	global $db,$configfile,$tablepre;
	if(!is_writeable($configfile))
	{
		echo "配置文件'{$configfile}'不支持写入，无法修改系统配置参数！";
		exit();
	}
	$fp = fopen($configfile,'w');
	flock($fp,3);
	fwrite($fp,"<"."?php\r\n");
	$query=$db->query("Select `varname`,`type`,`value`,`groupid` From `{$tablepre}sysconfig` order by sid asc ");
	while($row = $db->fetch_array($query))
	{
		if($row['type']=='number')
		{
			if($row['value']=='') $row['value'] = 0;
			fwrite($fp,"\${$row['varname']} = ".$row['value'].";\r\n");
		}
		else
		{
			fwrite($fp,"\${$row['varname']} = '".str_replace("'",'',$row['value'])."';\r\n");
		}
	}
	fwrite($fp,"?".">");
	fclose($fp);
}

//保存配置的改动
if($action=="save")
{
	foreach($_POST as $k=>$v)
	{	/*
		if(ereg("^edit___",$k))
		{
			$v = substrs(${$k}, 1024);
		}
		else
		{
			continue;
		}
		*/
		$k = ereg_replace("^edit___","",$k);
		$db->query("Update `{$tablepre}sysconfig` set `value`='$v' where varname='$k' ");
	}
	ReWriteConfig();
	showmsg("成功更改站点配置！","sys_info.php");
	exit();
}

include ('tpl/sys_info.htm');
?>

