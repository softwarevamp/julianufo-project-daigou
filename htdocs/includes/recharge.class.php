<?php
if (!defined('ZZQSS')){
	die("Access Denied");
}
/**
 * 充值处理模块
 * 
 *
 */
class RechargeClass {
	var $db;
	var $rechargerecord;
	var $tablepre;
	var $usedays=30;//默认有效天数
	function __construct(){
		//设置全局变量
		global $db,$tablepre;
		$this->db=$db;
		$this->tablepre=$tablepre;
		$this->rechargerecord=new TableClass("rechargerecord","rid");
	}
	function RechargeClass(){
		$this->__construct();
	}
	//对象获取
	function &init() {
		static $object;
		if(empty($object)) {
			$object = new RechargeClass();
		}
		return $object;
	}
	
	function add($uname,$amount,$cate='CNY',$paytype=0,$payname=''){
		$money=GetNum($money);
		$uid=DB::result_first("select uid from ".$this->tablepre."users where uname='".$uname."'");
		if (empty($uid) || empty($uname)) {
			return lang('user_cantempty');
		}
		if ($cate=='CNY') {
			$money=$amount;
		}else {
			$money=$this->ratechange($amount,$cate);
		}
		$sn=$this->makesn();
		$dataarray=array(
			'sn'=>$sn,
			'uid'=>$uid,
			'uname'=>$uname,
			'amount'=>$amount,
			'money'=>$money,
			'currency'=>$cate,
			'paytype'=>$paytype,
			'payname'=>$payname,
			'addtime'=>time(),
			'state'=>1
		);
		$info=$this->rechargerecord->add($dataarray);
		if (GetNum($info)) {
			return $sn;
		}else {
			return lang('Into_wrong_order');
		}
	}
	
	function ratechange($money,$cate){
		include_once(INC_PATH.'/rate.class.php');
		$rateobj = RateClass::init();
		//获取最新汇率信息
		$ratedata = $rateobj->get();
		if (GetNum($ratedata[$cate]['rate'])) {
			$tempaccount=$money*$ratedata[$cate]['rate'];
			return $tempaccount;
		}else {
			exit(lang('rata_error'));	
		}
	}
	
	/**
	 * 付款成功充值到账户
	 *
	 * @param unknown_type $sn
	 * @return 'OK'
	 */
	function paysuccess($sn,$money){
		$sn=GetNum($sn);
		$row=$this->getonebysn($sn,$field="rid,uname,state,money,payname");
		if (!is_array($row)) {
			return lang('Renumber_notexist');	
		}
		if ($row['state']==2) {
			return lang('been_recharge');			
		}
		
		//更新状态
		$dataarray=array(
			'money'=>$money,
			'successtime'=>time(),
			'state'=>2
		);
		$this->rechargerecord->edit($row['rid'],$dataarray);
		
		include_once(INC_PATH."/member.class.php");
		$m=new memberclass();
		$note=$row['payname'].$money.lang('yuan').lang('Serial_number').$sn;
		$m->moneyedit($row['uname'],$money,9,$note);
		return 'OK';
	}

	//编辑
	function edit($eid,$dataarray){
		return $this->rechargerecord->edit($eid,$dataarray);
	}
	//获取一个
	function getone($gid,$field="*"){
		return $this->rechargerecord->getone($gid,$field);
	}
	//通过sn获取一个
	function getonebysn($sn,$field="*"){
		$row=DB::fetch_first("select ".$field." from ".$this->rechargerecord->table." where sn='".$sn."'");
		return $row;
	}
	//获取数据
	function getdata($limit="",$where="",$orderby="",$field="*"){
		global $COUPONSTATE,$COUPONGETWAY;
		$temparray=$this->rechargerecord->getdata($limit,$where,$orderby,$field);
		foreach($temparray as &$value){
			//数据处理
			$value['statename']=$COUPONSTATE[$value['state']];
			$value['getwayname']=$COUPONGETWAY[$value['getway']];
		}
		return $temparray;		
	}
	//统计
	function getcount($where=""){
		return $this->rechargerecord->getcount($where);
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