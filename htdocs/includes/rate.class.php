<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}
require_once(INC_PATH.'/httpdown.class.php');//包含共用基础函数
class RateClass {
	var $db;
	var $tablepre;
	var $http;
	var $cachename="rate_data.php";//缓存文件
	var $url="http://www.usd-cny.com/bankofchina.htm";//汇率抓取网址
	function __construct(){
		//设置全局变量
		global $db,$tablepre ;
		$this->db=$db;
		$this->tablepre=$tablepre;
		$this->http=new HttpDown();
	}
	function RateClass(){
		$this->__construct();
	}
	//对象获取
	function &init() {
		static $object;
		if(empty($object)) {
			$object = new RateClass();
		}
		return $object;
	}
	//抓取商品信息
	function get(){
		global $cfg_site_huilv;
		if(file_exists(DATA_CACHEPATH.$this->cachename) && time()-@filemtime(DATA_CACHEPATH.$this->cachename) <3600*24){
			return cache_read($this->cachename);
		}elseif(!file_exists(DATA_CACHEPATH.$this->cachename) || time()-@filemtime(DATA_CACHEPATH.$this->cachename) >3600*24){
			$this->http->OpenUrl($this->url);
			$html=$this->http->GetHtml();
			if(empty($html))return false;//找不到对应采集规则或者抓取网页失败返回false
			$html=iconv("gbk","utf-8",$html);//编码转换
			//抓取
			$matches=$matches_tmp=array();
			$url_pattern="/<td bgcolor=\"#f7f7f7\">([\w\W]*?)<\/td>/";
			preg_match_all($url_pattern,$html,$matches,PREG_PATTERN_ORDER);
			//print_r($matches);
			for($i=0;$i<count($matches[1]);$i=$i+8){
				$url_pattern="/<a href=\"http:\/\/www.usd-cny.com\/(.*)-rmb.htm\">(.*)<\/a>/U";
				preg_match($url_pattern,$matches[1][$i],$matches_tmp);
				$custom=strtoupper($matches_tmp[1]);
				if(empty($custom)){$custom='RUB';$matches_tmp[1]='RUB';$matches_tmp[2]='卢布';}
				//print_r($matches_tmp);
				$tmp[$custom]['name']=strtoupper($matches_tmp[1]);
				$tmp[$custom]['name_cn']=$matches_tmp[2];
				if(strlen(trim($matches[1][$i+2]))>0){
					$tmp[$custom]['rate']=trim(str_replace(',','',$matches[1][$i+2]));
				}else{
					$tmp[$custom]['rate']=trim(str_replace(',','',$matches[1][$i+1]));
				}
				$tmp[$custom]['rate']=sprintf("%01.3f", $tmp[$custom]['rate']/100);
			}
			
			if(!empty($tmp['USD']['rate'])&&!empty($tmp['GBP']['rate'])&&!empty($tmp['SGD']['rate'])){
				$tmp['USD']['rate']=$cfg_site_huilv;
				$this->cachedata($tmp);//存储到文件
				return $tmp;//返回汇率
			}else{
				return $this->getdefault();//获取汇率失败返回默认的
			}
		}else{
			return $this->getdefault();
		}
	}
	
	//获取网址对应的区配规则
	function getdefault(){
		return cache_read($this->cachename);
		
	}
	//缓存数据
	function cachedata($arraydata){
		cache_delete($this->cachename);
		cache_write($this->cachename, $arraydata);
	}
}
?>