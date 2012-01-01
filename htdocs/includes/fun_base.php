<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}

function Char_cv($msg){
	$msg = str_replace('%20','',$msg);
	$msg = str_replace('%27','',$msg);
	$msg = str_replace('*','',$msg);
	$msg = str_replace("\"",'',$msg);
//	$msg = str_replace('//','',$msg);
	$msg = str_replace('&amp;','&',$msg);
	$msg = str_replace('&nbsp;',' ',$msg);
	$msg = str_replace(';','',$msg);
	$msg = str_replace('"','&quot;',$msg);
	$msg = str_replace("'",'&#039;',$msg);
	$msg = str_replace("<","&lt;",$msg);
	$msg = str_replace(">","&gt;",$msg);
	$msg = str_replace('(','',$msg);
	$msg = str_replace(')','',$msg);
	$msg = str_replace("{",'',$msg);
	$msg = str_replace('}','',$msg);
	$msg = str_replace("\t","   &nbsp;  &nbsp;",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);
	return $msg;
}

function lang($var,$vars = array()){
	global $alang;
	if(empty($alang)){
		@include(ROOT_PATH.'/language/main.inc.php');
	}
	if(!empty($alang[$var])){
		if($vars && is_array($vars)) {
			$searchs = $replaces = array();
			foreach($vars as $k => $v) {
				$searchs[] = '{'.$k.'}';
				$replaces[] = $v;
			}
			$alang[$var] = str_replace($searchs, $replaces, $alang[$var]);
		}
		return $alang[$var];
	}else{
		return '!'.$var.'!';
	}
}

function alang($var,$vars = array()){
	global $adminlang;
	if(empty($adminlang)){
		@include(ROOT_PATH.'/language/admin.inc.php');
	}
	if(!empty($adminlang[$var])){
		if($vars && is_array($vars)) {
			$searchs = $replaces = array();
			foreach($vars as $k => $v) {
				$searchs[] = '{'.$k.'}';
				$replaces[] = $v;
			}
			$adminlang[$var] = str_replace($searchs, $replaces, $adminlang[$var]);
		}
		return $adminlang[$var];
	}else{
		return '!'.$var.'!';
	}
}
// $rptype = 0 表示仅替换 html标记
// $rptype = 1 表示替换 html标记同时去除连续空白字符
// $rptype = 2 表示替换 html标记同时去除所有空白字符
// $rptype = -1 表示仅替换 html危险的标记
function HtmlReplace($str,$rptype=0)
{
	$str = stripslashes($str);
	if($rptype==0)
	{
		$str = htmlspecialchars($str);
	}
	else if($rptype==1)
	{
		$str = htmlspecialchars($str);
		$str = str_replace("　",' ',$str);
		$str = ereg_replace("[\r\n\t ]{1,}",' ',$str);
	}
	else if($rptype==2)
	{
		$str = htmlspecialchars($str);
		$str = str_replace("　",'',$str);
		$str = ereg_replace("[\r\n\t ]",'',$str);
	}
	else
	{
		$str = ereg_replace("[\r\n\t ]{1,}",' ',$str);
		$str = eregi_replace('script','ｓｃｒｉｐｔ',$str);
		$str = eregi_replace("<[/]{0,1}(link|meta|ifr|fra)[^>]*>",'',$str);
	}
	return addslashes($str);
}
/**
 * 批量初始化POST or GET变量,并数组返回
 *
 * @param Array $keys
 * @param string $method
 * @param var $htmcv
 * @return Array
 */
function Init_GP($keys,$method='GP',$htmcv=0){
	!is_array($keys) && $keys = array($keys);
	$array = array();
	foreach($keys as $val){
		$array[$val] = NULL;
		if($method!='P' && isset($_GET[$val])){
			$array[$val] = $_GET[$val];
		} elseif($method!='G' && isset($_POST[$val])){
			$array[$val] = $_POST[$val];
		}
		$htmcv && $array[$val] = Char_cv($array[$val]);
	}
	return $array;
}

/**
 * 批量初始化POST or GET变量,并将变量全局化
 *
 * @param Array $keys
 * @param string $method
 * @param var $htmcv
 */
function InitGP($keys,$method='GP',$htmcv=0){
	!is_array($keys) && $keys = array($keys);
	foreach($keys as $val){
		$GLOBALS[$val] = NULL;
		if($method!='P' && isset($_GET[$val])){
			$GLOBALS[$val] = $_GET[$val];
		} elseif($method!='G' && isset($_POST[$val])){
			$GLOBALS[$val] = $_POST[$val];
		}
		$htmcv && $GLOBALS[$val] = Char_cv($GLOBALS[$val]);
	}
}

/**
 * 初始化单一POST or GET 变量
 *
 * @param string $key
 * @param string $method
 * @return unknown
 */
function GetGP($key,$method='GP'){
	if($method=='G' || $method!='P' && isset($_GET[$key])){
		return $_GET[$key];
	}
	return $_POST[$key];
}
//处理数字类型字符
function GetNum($fnum)
{
	$nums = array("０","１","２","３","４","５","６","７","８","９");
	//$fnums = "0123456789";
	$fnums = array("0","1","2","3","4","5","6","7","8","9");
	$fnum = str_replace($nums,$fnums,$fnum);
	$fnum = ereg_replace("[^0-9\.-]",'',$fnum);
	if($fnum=='')
	{
		$fnum=0;
	}
	return $fnum;
}


//获得当前的脚本网址
function geturl()
{
	if(!empty($_SERVER["REQUEST_URI"]))
	{
		$scriptName = $_SERVER["REQUEST_URI"];
		$nowurl = $scriptName;
	}
	else
	{
		$scriptName = $_SERVER["PHP_SELF"];
		if(empty($_SERVER["QUERY_STRING"]))
		{
			$nowurl = $scriptName;
		}
		else
		{
			$nowurl = $scriptName."?".$_SERVER["QUERY_STRING"];
		}
	}
	return $nowurl;
}

//如果$string不是变量，则返回加上‘’的字符串
function getdotstring($string, $vartype='int', $allownull=false, $varscope=array(), $sqlmode=1, $unique=true) {

	if(is_array($string)) {
		$stringarr = $string;
	} else {
		if(substr($string, 0, 1) == '$') {
			return $string;
		}
		$string = str_replace('，', ',', $string);
		$string = str_replace(' ', ',', $string);
		$stringarr = explode(',', $string);
	}

	$newarr = array();
	foreach ($stringarr as $value) {
		$value = trim($value);
		if($vartype == 'int') {
			$value = intval($value);
		}
		if(!empty($varscope)) {
			if(in_array($value, $varscope)) {
				$newarr[] = $value;
			}
		} else {
			if($allownull) {
				$newarr[] = $value;
			} else {
				if(!empty($value)) $newarr[] = $value;
			}
		}
	}

	if($unique) $newarr = sarray_unique($newarr);

	if($vartype == 'int') {
		$string = implode(',', $newarr);
	} else {
		if($sqlmode) {
			$string = '\''.implode('\',\'', $newarr).'\'';
		} else {
			$string = implode(',', $newarr);
		}
	}
	return $string;
}
//将数组中相同的值去掉,同时将后面的键名也忽略掉
function sarray_unique($array) {
	$newarray = array();
	if(!empty($array) && is_array($array)) {
		$array = array_unique($array);
		foreach ($array as $value) {
			$newarray[] = $value;
		}
	}
	return $newarray;
}
/**
 * 截取字符串,多编码
 *
 * @param string $content	原字符串
 * @param string $length	截取长度
 * @param string $num		0=字节  1=个数
 * @param string $add		结尾添加 '..'
 * @param string $code		编码 utf-8或其他
 * @return string
 */
function substrs($content,$length,$num=0,$add=0,$code=''){
	$code = $code ? $code : CHARSET;
	$content = strip_tags($content);
	if($length && strlen($content)>$length){
		$retstr='';
		if($code == 'UTF-8'){
			$retstr = utf8_trim($content,$length,$num);
		}else{
			for($i = 0; $i < $length; $i++) {
				if(ord($content[$i]) > 127){
					if($num){
						$retstr .=$content[$i].$content[$i+1];
						$i++;
						$length++;
					}elseif(($i+1<$length)){
						$retstr .=$content[$i].$content[$i+1];
						$i++;
					}
				}else{
					$retstr .=$content[$i];
				}
			}
		}
		return $retstr.($add ? '..' : '');
	}
	return $content;
}

function utf8_trim($string,$length,$num) {
	if($length && strlen($string)>$length){
		if($num){
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all($pa, $string, $t_string);
			return join('', array_slice($t_string[0], 0, $length));
		}else{
			$hex = '';
			$str = substr($string,0,$length);
			for($i=$length-1;$i>=0;$i--){
				$ch   = ord($str[$i]);
				$hex .= ' '.$ch;
				if(($ch & 128)==0)	return substr($str,0,$i);
				if(($ch & 192)==192)return substr($str,0,$i);
			}
			return($str.$hex);
		}
	}
	return $string;
}

/**
 * 获得用户的真实IP地址
 *
 * @access  public
 * @return  string
 */
function real_ip(){
    static $realip = NULL;
    if ($realip !== NULL){
        return $realip;
    }
    if (isset($_SERVER)){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip){
                $ip = trim($ip);
                if ($ip != 'unknown'){
                    $realip = $ip;
                    break;
                }
            }
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])){
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $realip = $_SERVER['REMOTE_ADDR'];
            } else {
                $realip = '0.0.0.0';
            }
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')){
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }elseif (getenv('HTTP_CLIENT_IP')){
            $realip = getenv('HTTP_CLIENT_IP');
        }else{
            $realip = getenv('REMOTE_ADDR');
        }
    }
    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
    return $realip;
}

/**
 * cookie 处理，setcookie()设置cookie
 *
 * @$var  键
 * @$value  值
 */
function set_cookie($var, $value = '', $time = 0,$cookiepath="/", $prefix = 1)
{
	global $cookiepre, $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	$host = preg_replace('/^[Ww][Ww][Ww]\./', '',preg_replace('/:[0-9]*$/', '', $_SERVER['HTTP_HOST']));
	$time = $time > 0 ? $time : ($value == '' ? time() - 3600 : 0);
	$s = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
	$var=($prefix ? $cookiepre : '').$var;
	$_COOKIE[$var] = $value;
	if(is_array($value))
	{
		foreach($value as $k=>$v)
		{
			setcookie('['.$k.']', $v, $time, $cookiepath, $host, $s);
		}
	}
	else
	{
		setcookie($var, $value, $time, $cookiepath, $host, $s);
	}
}
/**
 * cookie 处理，get_cookie()获取cookie
 *
 * @$var  键
 */
function get_cookie($var, $prefix = 1)
{
	global $cookiepre,$_COOKIE;
	$var =($prefix ? $cookiepre : '').$var;
	return isset($_COOKIE[$var]) ? $_COOKIE[$var] : false;
}

//--------------------------------
//检测file_put_contents是否存在
//
//--------------------------------
if(!function_exists('file_put_contents'))
{
	define('FILE_APPEND', 8);
	function file_put_contents($file, $data, $append = '')
	{
		$mode = $append == '' ? 'wb' : 'ab';
		$fp = @fopen($file, $mode) or exit("Can not open file $file !");
		flock($fp, LOCK_EX);
		$len = @fwrite($fp, $data);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $len;
	}
}
if(!function_exists('http_build_query'))
{
    function http_build_query($data, $prefix = null, $sep = '', $key = '')
	{
        $ret = array();
		foreach((array)$data as $k => $v)
		{
			$k = urlencode($k);
			if(is_int($k) && $prefix != null)
			{
				$k = $prefix.$k;
			}
			if(!empty($key)) {
				$k = $key."[".$k."]";
			}
			if(is_array($v) || is_object($v))
			{
				array_push($ret,http_build_query($v,"",$sep,$k));
			}
			else
			{
				array_push($ret,$k."=".urlencode($v));
			}
		}
        if(empty($sep))
		{
            $sep = ini_get("arg_separator.output");
        }
        return implode($sep, $ret);
    }
}

if(!function_exists('json_encode'))
{
	function json_encode($string)
	{
		require_once 'json.class.php';
		$json = new json();
		return $json->encode($string);
	}
}

if(!function_exists('json_decode'))
{
	function json_decode($string,$type = 1)
	{
		require_once 'json.class.php';
		$json = new json();
		return $json->decode($string,$type);
	}
}

if(!function_exists('iconv'))
{
	function iconv($in_charset, $out_charset, $str)
	{
		if(function_exists('mb_convert_encoding'))
		{
			return mb_convert_encoding($str, $out_charset, $in_charset);
		}
		else
		{

			require_once 'iconv.func.php';
			$in_charset = strtoupper($in_charset);
			$out_charset = strtoupper($out_charset);
			if($in_charset == 'UTF-8' && ($out_charset == 'GBK' || $out_charset == 'GB2312'))
			{
				return utf8_to_gbk($str);
			}
			if(($in_charset == 'GBK' || $in_charset == 'GB2312') && $out_charset == 'UTF-8')
			{
				return gbk_to_utf8($str);
			}
			return $str;
		}
	}
}


/**
 * 创建多级目录。
 *
 * @param string $path  目标路径
 * @return 成功或失败
 */
function createDir($path) {
    $path = str_replace('\\','/',$path) ;
    if ( is_dir($path) ) return true ;
    if ( file_exists($path) ) return false ;        
    $parent = substr($path ,0, strrpos($path,'/') ) ;
    //echo $parent;
    if ( $parent==='' || $parent==='.' || createDir( $parent ) ) 
         return @mkdir($path) ;        #    没权限的
    else return false ;
}
    
//createDir('/a/b/c/d/e/f') ;     #    从根目录
//createDir('./a/b/c/d/e/f') ;    #    从当前目录
//createDir('a/b/c/d/e/f') ;    #    从当前目录
//createDir('../a/b/c/d/e/f') ;    #    从上级目录
//--------------------------------
//检测获取缓存写入文件
//
//--------------------------------
function createhtml($file)
{
	$data = ob_get_contents();
	ob_clean();
	createDir(dirname($file));
	$strlen = file_put_contents($file, $data);
	@chmod($file,0777);
	return $strlen;
}
/*
*写日志文件 记录重要操作
**/

function writelog($file, $log) {
	global $timestamp;
	$yearmonth = date('Ym');
	$logdir = ROOT_PATH.'/data/logs/';
	$logfile = $logdir.$yearmonth.'_'.$file.'.php';
	if(@filesize($logfile) > 2084000) {
		$dir = opendir($logdir);
		$length = strlen($file);
		$maxid = $id = 0;
		while($entry = readdir($dir)) {
			if(strexists($entry, $yearmonth.'_'.$file)) {
				$id = intval(substr($entry, $length + 8, -4));
				$id > $maxid && $maxid = $id;
			}
		}
		closedir($dir);

		$logfilebak = $logdir.$yearmonth.'_'.$file.'_'.($maxid + 1).'.php';
		@rename($logfile, $logfilebak);
	}
	if($fp = @fopen($logfile, 'a')) {
		@flock($fp, 2);
		$log = is_array($log) ? $log : array($log);
		foreach($log as $tmp) {
			fwrite($fp, "<?PHP exit;?>\t".str_replace(array('<?', '?>'), '', $tmp)."\n");
		}
		fclose($fp);
	}
}
//判断字符是否存在另一个字符串里面 没返回false
function strexists($haystack, $needle) {
	return !(strpos($haystack, $needle) === FALSE);
}
//处理text文本域
function format_textarea($string)
{	
	$string = stripslashes($string);
	return addslashes(nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($string))));
}
//生成随机字符串
function randomkeys($length,$type="ALL")
{	$key="";
	if ($type=="ALL") {
		$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';    //字符池
	}elseif ($type=="123"){
		$pattern = '123456789012345678901234567890123456';    //字符池
	}elseif ($type="ABC"){
		$pattern = 'abcdefghijklmnopqrstuvwxyzabcdefghij';    //字符池
	}
	for($i=0;$i<$length;$i++)
	{
		$key .= $pattern{mt_rand(0,35)};    //生成php随机数
	}
	return $key;
}

function AjaxHead()
{
	@header("Pragma:no-cache\r\n");
	@header("Cache-Control:no-cache\r\n");
	@header("Expires:0\r\n");
}
//加密cookie用
/**  
03 * @param string $string 原文或者密文  
04 * @param string $operation 操作(ENCODE | DECODE), 默认为 DECODE  
05 * @param string $key 密钥  
06 * @param int $expiry 密文有效期, 加密时候有效， 单位 秒，0 为永久有效  
07 * @return string 处理后的 原文或者 经过 base64_encode 处理后的密文  
09 * @example  
11 *  $a = authcode('abc', 'ENCODE', 'key');  
12 *  $b = authcode($a, 'DECODE', 'key');  // $b(abc)  
14 *  $a = authcode('abc', 'ENCODE', 'key', 3600);  
15 *  $b = authcode('abc', 'DECODE', 'key'); // 在一个小时内，$b(abc)，否则 $b 为空  
16 */ 

function cookie_authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4;

	$key = md5($key ? $key : KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}


//过滤xss攻击
function remove_xss($val) {
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=@avascript:alert('XSS')>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
      // ;? matches the ;, which is optional
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

      // @ @ search for the hex values
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      // @ @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[xX]0{0,8}([9ab]);)';
               $pattern .= '|';
               $pattern .= '|(&#0{0,8}([9|10|13]);)';
               $pattern .= ')*';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
   }
   return $val;
}


function get_system_env( )
{
	$e = array();
	$e['time'] = gmdate( "Y-m-d", time( ) );
	$e['os'] = PHP_OS;
	$e['ip'] = @gethostbyname($_SERVER['SERVER_NAME']) or ($e['ip'] = getenv( "SERVER_ADDR" )) or ($e['ip'] = getenv('LOCAL_ADDR'));
	$e['sapi'] = @php_sapi_name( );
	$e['host'] = strtolower(getenv('HTTP_HOST') ? getenv('HTTP_HOST') : $_SERVER['HTTP_HOST']);
	$e['path'] = substr(dirname(__FILE__),0,-17);
	$e['cpu'] = $_ENV['PROCESSOR_IDENTIFIER']."/".$_ENV['PROCESSOR_REVISION'];
	$e['name'] = $_ENV['COMPUTERNAME'];
	return $e;
}
/**
* @package     BugFree
* @version     $Id: FunctionsMain.inc.php,v 1.32 2005/09/24 11:38:37 wwccss Exp $
*
*
* Sort an two-dimension array by some level two items use array_multisort() function.
*
* sysSortArray($Array,”Key1″,”SORT_ASC”,”SORT_RETULAR”,”Key2″……)
* @author                      Chunsheng Wang <wwccss@263.net>
* @param  array   $ArrayData   the array to sort.
* @param  string  $KeyName1    the first item to sort by.
* @param  string  $SortOrder1  the order to sort by(“SORT_ASC”|”SORT_DESC”)
* @param  string  $SortType1   the sort type(“SORT_REGULAR”|”SORT_NUMERIC”|”SORT_STRING”)
* @return array                sorted array.
*/
function sysSortArray($ArrayData,$KeyName1,$SortOrder1 = "SORT_ASC",$SortType1 = "SORT_REGULAR")
{
    if(!is_array($ArrayData))
    {
        return $ArrayData;
    }
 
    // Get args number.
    $ArgCount = func_num_args();
 
    // Get keys to sort by and put them to SortRule array.
    for($I = 1;$I < $ArgCount;$I ++)
    {
        $Arg = func_get_arg($I);
        if(!eregi("SORT",$Arg))
        {
            $KeyNameList[] = $Arg;
            $SortRule[]    = "$".$Arg;
        }
        else
        {
            $SortRule[]    = $Arg;
        }
    }
 
    // Get the values according to the keys and put them to array.
    foreach($ArrayData AS $Key => $Info)
    {
        foreach($KeyNameList AS $KeyName)
        {
            ${$KeyName}[$Key] = $Info[$KeyName];
        }
    }
 
    // Create the eval string and eval it.
    $EvalString = 'array_multisort('.join(",",$SortRule).',$ArrayData);'; 
    eval($EvalString);
    return $ArrayData;
}
?>