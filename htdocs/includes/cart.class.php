<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}
class CartClass {
	var $db;
	var $table_cart;
	var $tablepre;
	function __construct(){
		//设置全局变量
		global $db,$tablepre;
		$this->db=$db;
		$this->tablepre=$tablepre;
		$this->table_cart=new TableClass("cart","gid");
	}
	function CartClass(){
		$this->__construct();
	}
	//对象获取
	function &init() {
		static $object;
		if(empty($object)) {
			$object = new CartClass();
		}
		return $object;
	}
	//#######清空操作########
	function clear($id=''){
		global $_USERS;
		$anonymous=get_cookie('anonymous');
		if(!empty($_USERS['uid'])){
			$wherestr[]="uname ='".$_USERS['uname']."'";
		}elseif(!empty($anonymous)){
			$wherestr[]="anonymous = '{$anonymous}'";
		}else{
			return false;
		}
		if (!empty($id)) {
			$wherestr[]=$this->joinid($id);
		}
		if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
		$this->db->query("delete from {$this->table_cart->table} where {$wheresql}");
		return true;
	}
	//#######获取当前用户购物车商品########
	function getall($id=''){
		global $_USERS;
		$anonymous=get_cookie('anonymous');
		//是否登录
		if(!empty($_USERS['uid'])){
			$wherestr[]="uname ='".$_USERS['uname']."'";
		}elseif(!empty($anonymous)){
			$wherestr[]="anonymous = '{$anonymous}'";
		}else{
			return array();
		}
		if (!empty($id)) {
			$wherestr[]=$this->joinid($id);
		}
		if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
		return $this->getdata("",$wheresql,"goodsseller desc,gid desc");
	}
	//查询当前用户购物车商品数
	function getnum(){
		global $_USERS;
		$anonymous=get_cookie('anonymous');		
		//是否登录
		if(!empty($_USERS['uid'])){
			return $this->getcount("uname ='".$_USERS['uname']."'");
		}elseif(!empty($anonymous)){
			return $this->getcount("anonymous ='".$anonymous."'");
		}else{
			return 0;
		}
	}
	//#######添加进购物车########
	function add($dataarray){
		global $_USERS;
		$anonymous=get_cookie('anonymous');
		if(empty($dataarray['goodsurl']))return lang('goodsurl_notempty');
		if(empty($dataarray['goodsname']))return lang('goodsname_notempty');
		if(empty($dataarray['goodsseller']))return lang('seller_notempty');
		if(!empty($_USERS['uid'])){
			$dataarray['uid']=$_USERS['uid'];
			$dataarray['uname']=$_USERS['uname'];
		}elseif(!empty($anonymous)){
			$dataarray['anonymous']=$anonymous;
		}else{
			return lang('notsupport_cookie_turncookie');
		}
		
		$dataarray['type']=($dataarray['type']==1)?1:2;//1是代购2是代发
		$dataarray['goodsnum']=(int)GetNum($dataarray['goodsnum']);
		return $this->table_cart->add($dataarray);
	}
	//购物车选中商品放入订单库
	function carttoorder($id){
		global $_USERS;
		if (!empty($id)) {
			$wherestr[]=$this->joinid($id);
		}
		$wherestr[]="uname ='".$_USERS['uname']."'";
		if (empty($wherestr)||empty($_USERS['uname'])) {
			return false;
		}
		if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
		//获取数据
		$temparray=$this->getdata("",$wheresql);
		if(!empty($temparray)){
			//进入用户操作类
			include_once(INC_PATH."/member.class.php");
			$m=new memberclass();
			foreach ($temparray as $value){
				$addarray=$value;
				$tempstate=($value['type']==1)?1:3;//带发直接状态修改成在途中
				unset($addarray['gid']);//丢掉
				unset($addarray['anonymous']);//丢掉
				$addarray['addtime']=time();//添加时间
				$addarray['state']=$tempstate;//订单状态
				//处理插入数据库
				include_once(INC_PATH."/order.class.php");
				$order=OrderClass::init();
				$info=$order->add($addarray);
				if(GetNum($info)){
					$seccessid[]=$info;
					//扣除用户帐户余额操作
					if ($value['type']!=2) {
						$tempmoney=$value['goodsprice']*$value['goodsnum'];
						$note=lang('Buy')."<a href=\'".$value['goodsurl']."\' target=\'_blank\'>《".$value['goodsname']."》</a> ".$value['goodsnum'].lang('Pieces_order_ID').$info;
						$m->moneyedit($_USERS['uname'],- $tempmoney,1,$note);//扣去账户余额
					}
				}else{
					$order->del($seccessid);//手动回滚操作
					return lang('process_CartID').$value['gid'].lang('orderid_error');
				}
			}
			//运费扣费处理
			$result=$this->countmoney($temparray);//统计运费
			foreach ($result['s'] as $key=>$val){
				$note=lang('goodsseller')."[".$key."]".lang('Domestic_Ship').$val;
				$m->moneyedit($_USERS['uname'],- $val,2,$note);//扣去账户余额
			}
			$this->clear($id);//删除购物车商品
			return 'OK';
		}else return '订单为空';
	}
	//购物车商品进入收藏夹
	function carttofavorite($id){
		if (!empty($id)) {
			$wherestr=$this->joinid($id);
		}	
		if (empty($wherestr)) {
			return lang('goodsID_notempty');
		}
		//获取数据
		$temparray=$this->getdata("",$wherestr);
		if(!empty($temparray)){
			foreach ($temparray as $value){
				if(!empty($value['uname'])){
					$addarray=array(
						'uid'=>$value['uid'],
						'uname'=>$value['uname'],
						'goodsurl'=>$value['goodsurl'],
						'goodsname'=>$value['goodsname'],
						'goodsprice'=>$value['goodsprice'],
						'goodsimg'=>$value['goodsimg'],
						'goodsseller'=>$value['goodsseller'],
						'sellerurl'=>$value['sellerurl'],
						'goodssite'=>$value['goodssite'],
						'siteurl'=>$value['siteurl'],
						'addtime'=>time()
					);
					//处理插入数据库
					$f=new TableClass("favorite","fid");
					$info=$f->add($addarray);
					if(GetNum($info)){
						$seccessid[]=$info;
					}else{
						return lang('Handling_goodsID').$value['gid'].lang('Error_add_Favorite');
					}
				}
			}
			return 'OK';
		}else return lang('Data_notfound');
	}
	//统计购物车额度
	function countmoney($dataarray=array(),$id=''){
		if (empty($dataarray)) {
			$dataarray=$this->getall($id);
		}
		$result=$s=array();
		$result['goodsmoney']=$result['sendmoney']=$result['totalmoney']=0;
		//循环统计
		foreach ($dataarray as $val) {
			if ($val['type']==1) {
				$result['goodsmoney']+=($val['goodsprice']*$val['goodsnum']);//商品价格总和
				if (!empty($s[$val['goodsseller']])){
					if($val['sendprice']>$s[$val['goodsseller']]){
						$s[$val['goodsseller']]=$val['sendprice'];
					}
				}else{
					$s[$val['goodsseller']]=$val['sendprice'];
				}	
			}
		}
		$result['s']=$s;
		$result['sendmoney']=array_sum($s);
		$result['totalmoney']=$result['sendmoney']+$result['goodsmoney'];
		return $result;
	}
	function amonymoustouname($uid,$uname){
		$anonymous=get_cookie('anonymous');
		if (!empty($anonymous)) {
			$wherestr[]="anonymous = '{$anonymous}'";
			$wherestr[]="uname IS NULL";
			if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
			$dataarray=array(
				'uid'=>$uid,
				'uname'=>$uname,
			);
			updatetable($this->table_cart->table,$dataarray, $wheresql);
			return true;
		}
	}
	//用临时账户清空
	function clearbyanonymous($anonymous){
		if(!empty($anonymous)){
			$anonymous=Char_cv($anonymous);//过滤
			$this->db->query("delete from {$this->table_cart->table} where anonymous ='{$anonymous}'");
			return true;
		}else return false;
	}
	//用用户名清空
	function clearbyuid($uid){
		if(GetNum($uid)){
			$this->db->query("delete from {$this->table_cart->table} where uid ='{$uid}'");
			return true;
		}else return false;
	}
	//用用户名清空
	function clearbyuname($uname){
		if(!empty($uname)){
			$this->db->query("delete from {$this->table_cart->table} where uname ='{$uname}'");
			return true;
		}else return false;
	}
	//编辑
	function edit($eid,$dataarray){
		return $this->table_cart->edit($eid,$dataarray);
	}
	//删除
	function del($id){
		return $this->table_cart->del($id);
	}
	//获取一个
	function getone($gid,$field="*"){
		return $this->table_cart->getone($gid,$field);
	}
	//获取当前购物车商品列表
	function getallbyuid($uid){
		$uid=GetNum($uid);
		return $this->getdata("","uid = '{$uid}'","goodsseller desc,gid desc");
	}
	//获取当前购物车商品列表
	function getallbyuname($uname){
		$uname=Char_cv($uname);
		return $this->getdata("","uname = '{$uname}'","goodsseller desc,gid desc");
	}
	//获取当前购物车商品列表
	function getallbyanonymous($anonymous){
		$anonymous=Char_cv($anonymous);
		return $this->getdata("","anonymous = '{$anonymous}'","goodsseller desc,gid desc");
	}
	//获取数据
	function getdata($limit="",$where="",$orderby="",$field="*"){
		return $this->table_cart->getdata($limit,$where,$orderby,$field);
	}
	//统计
	function getcount($where=""){
		return $this->table_cart->getcount($where);
	}
	
	function joinid($id){
		//ID处理
		if(is_numeric($id)){
			$wherestr="gid = '{$id}'";
		}elseif(is_array($id)){
			$ids=getdotstring($id,'int');
			$wherestr="gid in ({$ids})";			
		}elseif(is_string($id) && (strexists($id,',') || strexists($id,'|'))){
			if(strexists($id,',')){
				$ids=getdotstring($id,'int');
			}else{
				$tempids=explode('|',$id);
				$ids=getdotstring($tempids,'int');
			}
			$wherestr="gid in ({$ids})";
		} else{
			return '';	
		}
		return 	$wherestr;
	}
}
?>