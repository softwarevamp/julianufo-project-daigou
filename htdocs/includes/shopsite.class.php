<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}
require_once(INC_PATH.'/httpdown.class.php');//包含共用基础函数
class ShopClass {
	var $db;
	var $table_cart;
	var $tablepre;
	var $http;
	var $cachename="shopsite_data.php";//缓存文件
	function __construct(){
		//设置全局变量
		global $db,$tablepre;
		$this->db=$db;
		$this->tablepre=$tablepre;
		$this->table_shopsite=new TableClass("shopsite","sid");
		$this->http=new HttpDown();
	}
	function ShopClass(){
		$this->__construct();
	}
	//对象获取
	function &init() {
		static $object;
		if(empty($object)) {
			$object = new ShopClass();
		}
		return $object;
	}
	//抓取商品信息
	function get($url){
		$matches=$preg=array();
		$this->http->OpenUrl($url);
		$html=file_get_contents($url);
		$preg=$this->getpreg($url);
		if(empty($html)||($preg==false))return false;//找不到对应采集规则或者抓取网页失败返回false
		$html=iconv($preg['charset'],CHARSET,$html);//编码转换
		//$response = iconv("gbk","utf-8//IGNORE",$response);
		//抓取商品名
		
		if(empty($preg['preg_goodsname'])){
			$result['goodsname']=$preg['preg_goodsname2'];
		}elseif(!empty($preg['preg_goodsname'])){
			preg_match($preg['preg_goodsname'],$html,$matches);
			$result['goodsname']=$matches['this'];
			if(empty($result['goodsname']) && !empty($preg['preg_goodsname2'])){
				preg_match($preg['preg_goodsname2'],$html,$matches);
				$result['goodsname']=$matches['this'];
				if(empty($result['goodsname']) && !empty($preg['preg_goodsname3'])){
					preg_match($preg['preg_goodsname3'],$html,$matches);
					$result['goodsname']=$matches['this'];
				}	
			}
		}
		//抓取价格
		$matches=array();
		if(empty($preg['preg_goodsprice'])){
			$result['goodsprice']=$preg['preg_goodsprice2'];
		}elseif(!empty($preg['preg_goodsprice'])){
			preg_match($preg['preg_goodsprice'],$html,$matches);
			$result['goodsprice']=$matches['this'];
			if(!is_numeric($result['goodsprice']) && !empty($preg['preg_goodsprice2'])){
				preg_match($preg['preg_goodsprice2'],$html,$matches);
				$result['goodsprice']=$matches['this'];
				if(empty($result['goodsprice']) && !empty($preg['preg_goodsprice3'])){
					preg_match($preg['preg_goodsprice3'],$html,$matches);
					$result['goodsprice']=$matches['this'];
				}
			}
		}
		//抓取运费
		$matches=array();
		if(empty($preg['preg_sendprice'])){
			$result['sendprice']=$preg['preg_sendprice2'];
		}elseif(!empty($preg['preg_sendprice'])){
			preg_match($preg['preg_sendprice'],$html,$matches);
			$result['sendprice']=$matches['this'];
			if(empty($result['sendprice']) && !empty($preg['preg_sendprice2'])){
				preg_match($preg['preg_sendprice2'],$html,$matches);
				$result['sendprice']=$matches['this'];
				if(empty($result['sendprice']) && !empty($preg['preg_sendprice3'])){
					preg_match($preg['preg_sendprice3'],$html,$matches);
					$result['sendprice']=$matches['this'];				
				}
				
			}
		}
		//抓取图片
		$matches=array();
		if(empty($preg['preg_goodsimg'])){
			$result['goodsimg']=$preg['preg_goodsimg2'];
		}elseif(!empty($preg['preg_goodsimg'])){
			preg_match($preg['preg_goodsimg'],$html,$matches);
			$result['goodsimg']=$matches['this'];
			if(empty($result['goodsimg']) && !empty($preg['preg_goodsimg2'])){
				preg_match($preg['preg_goodsimg2'],$html,$matches);
				$result['goodsimg']=$matches['this'];
				if(empty($result['goodsimg']) && !empty($preg['preg_goodsimg3'])){
					preg_match($preg['preg_goodsimg3'],$html,$matches);
					$result['goodsimg']=$matches['this'];
				}
			}
		}
		//抓取卖家
		$matches=array();
		if(empty($preg['preg_goodsseller'])){
			$result['goodsseller']=$preg['preg_goodsseller2'];
		}elseif(!empty($preg['preg_goodsseller'])){
			preg_match($preg['preg_goodsseller'],$html,$matches);
			$result['goodsseller']=$matches['this'];
			if(empty($result['goodsseller']) && !empty($preg['preg_goodsseller2'])){
				preg_match($preg['preg_goodsseller2'],$html,$matches);
				$result['goodsseller']=$matches['this'];
				if(empty($result['goodsseller']) && !empty($preg['preg_goodsseller3'])){
					preg_match($preg['preg_goodsseller3'],$html,$matches);
					$result['goodsseller']=$matches['this'];		
				}
			}
		}
		//抓取卖家url地址
		$matches=array();
		if(empty($preg['preg_sellerurl'])){
			$result['sellerurl']=$preg['preg_sellerurl2'];
		}elseif(!empty($preg['preg_sellerurl'])){
			preg_match($preg['preg_sellerurl'],$html,$matches);
			$result['sellerurl']=$matches['this'];
			if(empty($result['sellerurl']) && !empty($preg['preg_sellerurl2'])){
				preg_match($preg['preg_sellerurl2'],$html,$matches);
				$result['sellerurl']=$matches['this'];
				if(empty($result['sellerurl']) && !empty($preg['preg_sellerurl3'])){
					preg_match($preg['preg_sellerurl3'],$html,$matches);
					$result['sellerurl']=$matches['this'];	
				}
			}
		}
		$result['preg_goodsprice']=GetNum($result['preg_goodsprice']);
		$result['sendprice']=GetNum($result['sendprice']);
		$result['url']=$url;
		$result['goodsurl']=$url;
		$result['shopname']=$preg['shopname'];
		$result['shopurl']=$preg['shopurl'];
		return $result;//返回抓取到的数据
	}
	//获取网址对应的区配规则
	function getpreg($url){
		if(cache_read($this->cachename)){
			$arraydata=cache_read($this->cachename);
		}else{
			$arraydata=$this->table_shopsite->getdata("","state=1");
			$this->cachedata();//存储到文件
		}
		foreach($arraydata as $value){
			if(strexists($url, $value['shopcode'])){
				return $value;
			}
		}
		return false;//找不到返回false
	}
	//缓存数据
	function cachedata(){
		cache_delete($this->cachename);
		$arraydata=$this->table_shopsite->getdata("","state=1");
		cache_write($this->cachename, $arraydata);
	}
}
?>