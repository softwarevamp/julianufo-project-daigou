<?php
$payment_select = array(2 => "alipay",3=>"cbpayment",5 => "paypal");
$payment_userid = array(0 => "",1 => "",2 => "x-yilu@163.com",3 => "22034812",4 => "",5 => "0508060631@163.com");
$payment_key = array(0 => "",1 => "",2 => "b7hzmicioowrshftkc8ipnpo5lec67zl",3 => "2011WY1858D85C58AS68F188AB3N",4 => "",5 => "e149KB|tony|EJApaPGrqNGVYdwPAZmVkHEF");
$payment_curpay = array(0 => 'CNY',1 => 'CNY',2 => 'CNY',3 => 'CNY',4 => 'CNY',5 => 'USD');
$payment_exp = array(0 => "0.015",1 => "0.00",2 => "0.015",3 => "0.00",4 => "0.00",5 => "0.00");
$payment_email = array(0 => "webmaster@admin.com",1 => "webmaster@admin.com",2 => "x-yilu@163.com",3 => "",4 => "webmaster@admin.com",5 => "0508060631@163.com");

$cfg_pay_info 	= array(
	'name' => array('腾讯财付通','NPS 网上支付系统','支付宝','网银在线','易宝支付','paypal支付'),	
	'type' => array('tenpay','nps','alipay','cbpayment','yeepay','paypal'),	
	'logo' => array('tenpay.jpg','nps.gif','alipay.jpg','cbpayment.gif','yeepay.gif','paypal.gif'),	
	'reg'	 => array(
		'http://union.tenpay.com/mch/mch_register.shtml?posid=22&actid=84&opid=50&whoid=31&sp_suggestuser=1202347401',
		'http://www.nps.cn/',
		'http://www.alipay.com/',
		'http://merchant3.chinabank.com.cn/register.do',
		'https://www.yeepay.com/selfservice/requestRegister.action',
		'https://www.paypal.com'
	),
	'des' => array(
		'财付通是腾讯公司为促进中国电子商务的发展需要，满足互联网用户价值需求，针对网上交易安全而精心推出的一系列服务。',
		'NPS(Network Payment System)是电子商务中网上支付的交易平台,是连接消费者、商家和金融机构的桥梁,实现了Internet上的支付、资金清算、查询统计等功能。',
		'支付宝网站(www.alipay.com)是国内先进的网上支付平台，由全球最佳B2B公司阿里巴巴公司创办，致力于为网络交易用户提供优质的安全支付服务。',
		'网银在线通过整合各家银行的支付接口,为商户提供安全、便捷、稳定、易用的电子商务支付解 决方案。',
		'首批通过国家信息安全系统认证、获得企业信用等级AAA级证书、注册资本1亿元。1%手续费、0年费、支持上百种银行卡、神州行卡支付及游戏点卡支付。网上签约、轻松结算、7X24小时客户服务、共享千万优质会员资源。','PayPal是倍受全球亿万用户追捧的国际贸易支付工具，即时支付，即时到账，全中文操作界面，能通过中国的本地银行轻松提现，为您解决外贸支付难题，助您成功开拓外贸业务，决胜全球。'
	)	
);

function mchStrCode($string,$action='ENCODE')
{
	$key	= substr(md5($_SERVER["HTTP_USER_AGENT"].$GLOBALS['cfg_cookie_encode']),8,18);
	$string	= $action == 'ENCODE' ? $string : base64_decode($string);
	$len	= strlen($key);
	$code	= '';
	for($i=0; $i<strlen($string); $i++)
	{
		$k		= $i % $len;
		$code  .= $string[$i] ^ $key[$k];
	}
	$code = $action == 'DECODE' ? $code : base64_encode($code);
	return $code;
}