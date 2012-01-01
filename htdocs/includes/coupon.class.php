<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}
/**
 * 优惠卷处理
 * 
 *
 */
class CouponClass {
	var $db;
	var $table_coupon;
	var $tablepre;
	var $usedays=30;//默认有效天数
	function __construct(){
		//设置全局变量
		global $db,$tablepre;
		$this->db=$db;
		$this->tablepre=$tablepre;
		$this->table_coupon=new TableClass("coupon","cid");
	}
	function CouponClass(){
		$this->__construct();
	}
	//对象获取
	function &init() {
		static $object;
		if(empty($object)) {
			$object = new CouponClass();
		}
		return $object;
	}
	
	
	function getcoupon($price,$num,$uname=""){
		$price=GetNum($price);
		$num=intval(GetNum($num));
				
		//暂时只能兑换5元优惠卷
		if ($price>50) {
			return lang('max_exchange_wushi');
		}
		if ($num<1) {
			return lang('notless_one_exchange');
		}
		if (empty($uname)) {
			return lang('user_cantempty');
		}
		$scores=DB::result_first("select scores from ".$this->tablepre."users where uname='".$uname."'");
		if (empty($scores)||$scores<=0) {
			return lang('user_Nopointrecord');
		}
		$totalnum=$price*$num*100;
		if ($totalnum > $scores) {
			return lang('Points_not_exchange');
		}
		include_once(INC_PATH."/member.class.php");
		$m=new memberclass();
		$note=lang('Redeem').$price.lang('Per_coupon').$num.lang('Zhang');
		$m->scoreedit($uname,-$totalnum,$note);
		for ($i = 1; $i <= $num; $i++) {
			$this->add($uname,$price,1,1);//兑换生成优惠卷
		}
		return "OK";
	}
	/**
	 * 添加团购卷
	 *
	 * @param  $uname
	 * @param  $money
	 * @param  $getway 1积分兑换 2活动赠送
	 * @param  $state 0未激活 1已经激活 2出售中 3已使用 
	 * @return 字符串
	 */
	function add($uname,$money,$getway=1,$state=0){
		$money=GetNum($money)>50?50:GetNum($money);
		$uid=DB::result_first("select uid from ".$this->tablepre."users where uname='".$uname."'");
		if (empty($uid) || empty($uname)) {
			return lang('user_cantempty');
		}
		if ($state!=0) {
			$endtime=time()+3600*24*$this->usedays;//默认有效期
		}else{
			$endtime=0;
		}
		$dataarray=array(
			'sn'=>$this->makesn(),
			'uid'=>$uid,
			'uname'=>$uname,
			'getway'=>$getway,
			'addtime'=>time(),
			'endtime'=>$endtime,
			'money'=>$money,
			'state'=>$state
		);
		return $this->table_coupon->add($dataarray);
	}
	/**
	 * 激活优惠卷
	 *
	 * @param unknown_type $sn
	 * @return 'OK'
	 */
	function active($sn,$uname=""){
		$sn=GetNum($sn);
		$row=DB::fetch_first("select cid,state,uname from ".$this->table_coupon->table." where sn='".$sn."'");
		if (!empty($uname) and $uname!=$row['uname']) {
			return lang('Coupon_notbelong_curuser');
		}
		if (is_array($row) && $row['state']==0) {
			$endtime=time()+3600*24*$this->usedays;//默认有效期
			$dataarray=array(
				'endtime'=>$endtime,
				'state'=>1
			);
			return $this->table_coupon->edit($row['cid'],$dataarray);
		}else{
			return lang('Coupon_notexist');
		}
	}
	/**
	 * 出售优惠卷
	 *
	 * @param unknown_type $sn
	 * @param unknown_type $sellmoney
	 * @return unknown
	 */
	function sellcoupon($sn,$sellmoney,$uname=""){
		$sn=GetNum($sn);
		$sellmoney=GetNum($sellmoney);
		$row=DB::fetch_first("select cid,state,uname from ".$this->table_coupon->table." where sn='".$sn."'");
		if (!empty($uname)&&$uname!=$row['uname']) {
			return lang('Coupon_notbelong_curuser');
		}
		if (is_array($row) && $row['state']==1) {
			$dataarray=array(
				'sellmoney'=>$sellmoney,
				'state'=>2
			);
			return $this->table_coupon->edit($row['cid'],$dataarray);
		}else{
			return lang('Coupon_notactivated');
		}
	}
	/**
	 * 取消出售
	 *
	 */
	function cancelsell($sn,$uname=""){
		$sn=GetNum($sn);
		$row=DB::fetch_first("select cid,state,uname from ".$this->table_coupon->table." where sn='".$sn."'");
		if (!empty($uname)&&$uname!=$row['uname']) {
			return lang('Coupon_notbelong_curuser');
		}
		if (is_array($row) && $row['state']==2) {
			$dataarray=array(
				'sellmoney'=>null,
				'state'=>1
			);
			return $this->table_coupon->edit($row['cid'],$dataarray);
		}else{
			return lang('Coupon_notactivated');
		}
	}
	/**
	 * 优惠卷易主
	 *
	 * @param unknown_type $sn
	 * @param unknown_type $uname
	 * @return OK
	 */
	function buycoupon($sn,$uname){
		$uname=Char_cv($uname);
		$sn=Char_cv($sn);
		$urow=DB::fetch_first("select uid,money from ".$this->tablepre."users where uname='".$uname."'");
		if (empty($urow['uid']) || empty($uname)) {
			return lang('user_cantempty');
		}
		$row=DB::fetch_first("select cid,state,getway,sellmoney,uname from ".$this->table_coupon->table." where sn='".$sn."'");
		if ($row['sellmoney'] > GetNum($urow['money'])) {
			return lang('Insuff_accountbalance');
		}
		if ($row['uname']==$uname) {
			return lang('notbuy_owncoupons');
		}
		if (is_array($row) && $row['state']==2 && $row['getway']==1 && GetNum($row['sellmoney'])) {
			$dataarray=array(
				'uid'=>$urow['uid'],
				'uname'=>$uname,
				'state'=>1
			);
			
			include_once(INC_PATH."/member.class.php");
			$m=new memberclass();
			$note=lang('buy_coupon').$sn.lang('Spend').$row['sellmoney'].lang('yuan');
			$note=lang('sell_coupon').$sn.lang('Earn').$row['sellmoney'].lang('yuan');
			$m->moneyedit($uname,-$row['sellmoney'],$note);
			$m->moneyedit($row['uname'],$row['sellmoney'],$note);
			
			return $this->table_coupon->edit($row['cid'],$dataarray);
		}else{
			return lang('Coupon_notactivated');
		}
	}
	/**
	 * 赠送优惠卷
	 *
	 * @param unknown_type $sn
	 * @param unknown_type $uname
	 * @return unknown
	 */
	function present($sn,$uname,$fromuname=""){
		$uid=DB::result_first("select uid from ".$this->tablepre."users where uname='".$uname."'");
		if (empty($uid) || empty($uname)) {
			return lang('user_cantempty');
		}
		$row=DB::fetch_first("select cid,state,uname from ".$this->table_coupon->table." where sn='".$sn."'");
		if (!empty($fromuname)&&$fromuname!=$row['uname']) {
			return lang('Coupon_notbelong_curuser');
		}
		if (is_array($row) && $row['state']==1) {
			$dataarray=array(
				'uid'=>$uid,
				'uname'=>$uname,
				'state'=>1
			);
			return $this->table_coupon->edit($row['cid'],$dataarray);
		}else{
			return lang('Coupon_notactivated');
		}
	}
	//编辑
	function edit($eid,$dataarray){
		return $this->table_coupon->edit($eid,$dataarray);
	}
	//获取一个
	function getone($gid,$field="*"){
		return $this->table_coupon->getone($gid,$field);
	}
	//通过sn获取一个
	function getonebysn($sn,$field="*"){
		$row=DB::fetch_first("select ".$field." from ".$this->table_coupon->table." where sn='".$sn."'");
		return $row;
	}
	//获取数据
	function getdata($limit="",$where="",$orderby="",$field="*"){
		global $COUPONSTATE,$COUPONGETWAY;
		$temparray=$this->table_coupon->getdata($limit,$where,$orderby,$field);
		foreach($temparray as &$value){
			//数据处理
			$value['statename']=$COUPONSTATE[$value['state']];
			$value['getwayname']=$COUPONGETWAY[$value['getway']];
		}
		return $temparray;		
	}
	//统计
	function getcount($where=""){
		return $this->table_coupon->getcount($where);
	}
	/**
	 * 随机生成编号
	 *
	 * @return string
	 */
	function makesn(){
		$autokeys=randomkeys(3,'123');//随机5位数字
		$timestr=date('YmdHis');
		$sn=$timestr.$autokeys;
		return $sn;
	}
}
?>