<?php
//时间设置
//error_reporting(E_ALL ^ E_NOTICE);//错误报告级别
error_reporting(E_ALL & ~E_NOTICE);//错误报告级别
//ini_set('display_errors',1);
//error_reporting(E_ERROR | E_PARSE);//错误报告级别
set_magic_quotes_runtime(0);
function_exists('date_default_timezone_set') && date_default_timezone_set('Etc/GMT-8');//设置程序时间是格林时间减8，是北京时间
// 计算程序开始时间
function get_microtime() {
	list($usec, $sec) = explode(' ', microtime());
	return ((float)$usec + (float)$sec);
}
$time_start = get_microtime();

// 计算执行时间
function ptime() {
	global $time_start;
	$time_end = get_microtime();
	$ptime = $time_end - $time_start;
	return substr($ptime, 0, 8);
}
//php低版本兼容传递变量
if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_ENV = &$HTTP_ENV_VARS;
	$_FILES = &$HTTP_POST_FILES;
}

if(!get_magic_quotes_gpc()){
	Add_S($_POST);
	Add_S($_GET);
	Add_S($_COOKIE);
	Add_S($_SESSION);
}
//靠这个设置太BT了 日
//Add_S($_FILES); 
//定义环境
define('ZZQSS',true);
define('ROOT_PATH', str_replace("\\", '/', dirname(__FILE__)));
$php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
define('PHP_SELF',  htmlentities($php_self));
define('ROOT_DIR',  substr(PHP_SELF, 0, strrpos(PHP_SELF, '/')));
define('SITE_URL', "http://".$_SERVER['HTTP_HOST'].ROOT_DIR);
define('INC_PATH', ROOT_PATH.'/includes');
$site_url=SITE_URL;
//模板缓存目录
define('TPL_CACHEPATH', ROOT_PATH.'/data/cache_template');
//系统设置变量缓存目录
define('CFG_CACHEPATH', ROOT_PATH.'/data/syscache');
define('DATA_CACHEPATH', ROOT_PATH.'/data/datacache/');

//安装
if(!file_exists(ROOT_PATH.'/data/install.lock')) {
	header("Location: install/index.php");//安装
	exit();
}
//获取当前时间
$timestamp = time();
//声明几个全局变量users 存储用户信息
$_USERS=array();
$ERROR_MSG="";
//变量配置文件包含
include_once( ROOT_PATH.'/config/setting.inc.php');
//配置文件包含
include_once( ROOT_PATH.'/config/config.inc.php');

//包含后台配置参数
require_once(CFG_CACHEPATH.'/config.cache.inc.php');

include_once( ROOT_PATH.'/language/templates.lang.php');
//include_once( ROOT_PATH.'/language/templates_ewen.lang.php');


//定义模板目录
if(is_dir(ROOT_PATH."/templates/{$cfg_templet_name}"))
{	//设置后台配置模板目录
	define('TPL_PATH', ROOT_PATH."/templates/{$cfg_templet_name}");
	define('TPL', 'templates/'.$cfg_templet_name.'/');//定义模板使用的路径
}else{
	//设置参数不是目录则设置defalut为模板目录
	define('TPL_PATH', ROOT_PATH."/templates/default");
	define('TPL', 'templates/default/');//定义模板使用的路径
}
//共用函数包含
include_once( ROOT_PATH.'/includes/fun_common.php');
//模板函数包含
include_once(ROOT_PATH.'/includes/fun_template.php');
//数据库初始化
require_once ROOT_PATH.'/includes/db_mysql.class.php';
$db=& DB::object();
$db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
include_once(INC_PATH."/table.class.php");//数据表操作基础类

function Add_S(&$array){
	if(is_array($array)){
		foreach($array as $key=>$value){
			if(!is_array($value)){
				$array[$key]=addslashes($value);
			}else{
				Add_S($array[$key]);
			}
		}
	}
}
//设置游客cookie
$anonymous=get_cookie('anonymous');
if(empty($anonymous)){
	$xxtea = new Xxtea();
	$auth=real_ip()."\t".$timestamp;
	$strcode=$xxtea->encrypt($auth,"zzqss");	
	set_cookie('anonymous',$strcode,$timestamp+3600*24*7);//cookie有效期一周
	$anonymous=$strcode;
}
checkauth();//检查用户登录
checkkey();
//统计购物车物品数量
if (!empty($_USERS['uname'])) {
	$wherestrcart="uname ='".$_USERS['uname']."'";
}else {
	$wherestrcart="anonymous ='".$anonymous."'";
}
$_CARTCOUNT=DB::result_first("Select count(gid) From ".DB::table('cart')." where ".$wherestrcart);//购物车物品数量

?>