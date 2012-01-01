<?php

// [CH] 以下变量请根据空间商提供的账号参数修改,如有疑问,请联系服务器提供商

	$dbhost = 'localhost';			// 数据库服务器
	$dbuser = 'root';			// 数据库用户名
	$dbpw = 'root';				// 数据库密码
	$dbname = 'hiztao';			// 数据库名
	$pconnect = 0;				// 数据库持久连接 0=关闭, 1=打开

// [CH] Mysql 辅助服务器设置，只有当您拥有多个 Mysql 服务器且协同工作时请进行设置

	$multiserver = array();			// 服务器变量初始化，请勿修改或删除
	
// [CH] 如您对 cookie 作用范围有特殊要求, 或论坛登录不正常, 请修改下面变量, 否则请保持默认

//	$cookiepre = 'dg_';			// cookie 前缀
        $cookiepre = 'ht_';			// cookie 前缀, 更新域名为ht
	$cookiedomain = ''; 			// cookie 作用域
	$cookiepath = '/';			// cookie 作用路径
	
// [CH] 论坛投入使用后不能修改的变量

	$tablepre = 'dg_';   			// 表名前缀, 同一数据库安装多个论坛请修改此处
// [CH] 小心修改以下变量, 否则可能导致论坛无法正常使用

	$database = 'mysql';			// 论坛数据库类型，请勿修改
	$dbcharset = 'utf8';			// MySQL 字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照论坛字符集设定
	
//网站字符集
	$charset = 'utf-8';			// 网站字符集 'GBK' ,'UTF-8' 
	define('CHARSET', 'UTF-8'); //网站字符集 'GBK' ,'UTF-8' 

//cookie加密用密匙	
	define('KEY',"zzqss");

define('SOFT_NAME', '海之淘');
define('SOFT_VERSION', '1.0.0');
define('SOFT_RELEASE', '20120101');

/*

//--------------- UCenter设置 ---------------

// 连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen(), mysql 是直接连接的数据库, 为了效率, 建议采用 mysql

// 数据库相关 (mysql 连接时)
define('UC_DBHOST', 'localhost');				// UCenter 数据库主机
define('UC_DBUSER', 'root');					// UCenter 数据库用户名
define('UC_DBPW', '');						// UCenter 数据库密码
define('UC_DBNAME', 'ucenter');					// UCenter 数据库名称
define('UC_DBCHARSET', 'gbk');					// UCenter 数据库字符集
define('UC_DBTABLEPRE', '`ucenter`.uc_');					// UCenter 数据库表前缀
define('UC_DBCONNECT', '0');					// UCenter 数据库持久连接 0=关闭, 1=打开

// 通信相关
define('UC_KEY', 'zzqssgroup');						// 与 UCenter 的通信密钥, 要与 UCenter 保持一致
define('UC_API', 'http://192.168.5.50/uc');						// UCenter 的 URL 地址, 在调用头像时依赖此常量
define('UC_CHARSET', 'gbk');					// UCenter 的字符集
define('UC_IP', '');				// UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
define('UC_APPID', '1');						// 当前应用的 ID
define('UC_PPP', '20');
*/