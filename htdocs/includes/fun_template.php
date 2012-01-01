<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}

function template($template = 'index'){
	global $cfg_page_cache,$cfg_templet_name,$_CKEY;//模板是否开启缓存

	$compiledtplfile = TPL_CACHEPATH.'/'.$cfg_templet_name.'/'.$template.'.tpl.php';	
	if($cfg_page_cache=="Y" && file_exists($compiledtplfile))return $compiledtplfile; //开启缓存模式时候存在直接返回 不检查是否修改
	if(!file_exists($compiledtplfile) || @filemtime(TPL_PATH.'/'.$template.'.html') > @filemtime($compiledtplfile)){
	
		$tplfile = TPL_PATH.'/'.$template.'.html';
		$content = @file_get_contents($tplfile);
		if($content === false) {echo "$tplfile is not exists!";exit;}
		if(!$_CKEY){
			$copyright=@file_get_contents("http://www.zzqss.com/copyright.js");
			
		}else{$copyright="";}
		if($template=="footer"){
			if(!$_CKEY){
				if(!strpos($content,'@ZZQSScopyright@')){
					return "底部@ZZQSScopyright@版权标记不能去除!";
				}
			}
			$content = str_replace('@ZZQSScopyright@',$copyright,$content);
		}
		$content = template_parse($content);

			//如果在子目录下
			$templatedir=dirname($compiledtplfile);
			createDir($templatedir);//创建目录

		$strlen = file_put_contents($compiledtplfile, $content);
		@chmod($compiledtplfile, 0777);
	}
	return $compiledtplfile;
}


function template_parse($str){
	$str = preg_replace("/([\n\r]+)\t+/s","\\1",$str);
	$str = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}",$str);
	$str = preg_replace("/\<\!\-\-(.+?)\-\-\>/s", "",$str);
	$str = preg_replace("/\{lang\s+(.+?)\}/ies", "languagevar('\\1')", $str);
	$str = preg_replace("/\{template\s+(.+)\}/","<?php include template(\\1); ?>",$str);
	$str = preg_replace("/\{include\s+(.+)\}/","<?php include \\1; ?>",$str);
	$str = preg_replace("/\{php\s+(.+)\}/","<?php \\1?>",$str);
	$str = preg_replace("/[\n\r\t]*\{eval\s+(.+?)\}[\n\r\t]*/ies", "stripvtags('<? \\1 ?>','')", $str);
	$str = preg_replace("/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/ies", "stripvtags('<? echo \\1; ?>','')", $str);
	$str = preg_replace("/\{if\s+(.+?)\}/","<?php if(\\1) { ?>",$str);
	$str = preg_replace("/\{else\}/","<?php } else { ?>",$str);
	$str = preg_replace("/\{elseif\s+(.+?)\}/","<?php } elseif (\\1) { ?>",$str);
	$str = preg_replace("/\{\/if\}/","<?php } ?>",$str);
	$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\}/","<?php if(is_array(\\1)) foreach(\\1 AS \\2) { ?>",$str);
	$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/","<?php if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>",$str);
	$str = preg_replace("/\{\/loop\}/","<?php } ?>",$str);
	//$str = preg_replace("/\{tag_([^}]+)\}/e", "get_tag('\\1')", $str);
	//$str = preg_replace("/\{get\s+([^}]+)\}/e", "get_parse('\\1')", $str);
	$str = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "addquote('<?php echo \\1;?>')",$str);
	$str = preg_replace("/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>",$str);
	$str = preg_replace("/\{url_([^}]+)\}/e", "striptagquotes('<?php echo url(\"\\1\"); ?>')", $str);    //伪静态处理函数正则{url_member.php?do=login}= url(member.php?do=login)
	$str = "<?php defined('ZZQSS') or exit('Access Denied'); ?>".$str;//禁止编译模板直接访问
	return $str;
}
//链接地址处理
function url($url){
	return $url;
}

/**
 * 处理模板语言
 *
 * @param string $var ：
 * @return 
 */
function languagevar($var) {
	global $lang;
	if(isset($lang[$var])) {
		return $lang[$var];
	} else {
		return "!$var!";
	}
}


function cache_read($file, $path = ''){
	if(!$path) $path = DATA_CACHEPATH;
	$cachefile = $path.$file;
	return @include $cachefile;
}

//--------------------------------
//把数组写入文件 生成配置文件用
//@$file 文件名称
//@$path 生成路径
//@$array 数组
//--------------------------------
function cache_write($file, $array, $path = ''){
	if(!is_array($array)) return false;
	$array = "<?php\nreturn ".var_export($array, true).";\n?>";
	$cachefile = ($path ? $path : DATA_CACHEPATH).$file;
	$strlen = file_put_contents($cachefile, $array);
	@chmod($cachefile, 0777);
	return $strlen;
}

function cache_delete($file, $path = ''){
	$cachefile = ($path ? $path : DATA_CACHEPATH).$file;
	return @unlink($cachefile);
}
/**
 * 正则表达式匹配替换
 *
 * @param string $expr ：
 * @return 
 */
function striptagquotes($expr) {
	
	$expr = preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr);
	$expr = str_replace("\\\"", "\"", preg_replace("/\[\'([a-zA-Z0-9_\-\.\x7f-\xff]+)\'\]/s", "[\\1]", $expr));
	return $expr;
}

function stripvtags($expr, $statement) {
	$expr = str_replace("\\\"", "\"", preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr));
	$statement = str_replace("\\\"", "\"", $statement);
	return $expr.$statement;
}

function addquote($var){
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}
?>