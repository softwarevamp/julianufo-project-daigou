<?php
$payment_select = array(2 => "alipay");
$payment_userid = array(0 => "",1 => "",2 => "2088202222419963",3 => "",4 => "",5 => "");
$payment_key = array(0 => "",1 => "",2 => "b7hzmicioowrshftkc8ipnpo5lec67zl",3 => "",4 => "",5 => "");
$payment_curpay = array(0 => 'CNY',1 => 'CNY',2 => 'CNY',3 => 'CNY',4 => 'CNY',5 => 'USD');
$payment_exp = array(0 => "0.015",1 => "0.00",2 => "0.015",3 => "0.01",4 => "0.00",5 => "0.00");
$payment_email = array(0 => "webmaster@admin.com",1 => "webmaster@admin.com",2 => "x-yilu@163.com",3 => "webmaster@admin.com",4 => "webmaster@admin.com",5 => "webmaster@admin.com");

$cfg_pay_info 	= array(
	'name' => array('��Ѷ�Ƹ�ͨ','NPS ����֧��ϵͳ','֧����','��������','�ױ�֧��','paypal֧��'),	
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
		'�Ƹ�ͨ����Ѷ��˾Ϊ�ٽ��й���������ķ�չ��Ҫ�����㻥�����û���ֵ����������Ͻ��װ�ȫ�������Ƴ���һϵ�з���',
		'NPS(Network Payment System)�ǵ�������������֧���Ľ���ƽ̨,�����������ߡ��̼Һͽ��ڻ���������,ʵ����Internet�ϵ�֧�����ʽ����㡢��ѯͳ�Ƶȹ��ܡ�',
		'֧������վ(www.alipay.com)�ǹ����Ƚ�������֧��ƽ̨����ȫ�����B2B��˾����Ͱ͹�˾���죬������Ϊ���罻���û��ṩ���ʵİ�ȫ֧������',
		'��������ͨ�����ϸ������е�֧���ӿ�,Ϊ�̻��ṩ��ȫ����ݡ��ȶ������õĵ�������֧���� ��������',
		'����ͨ��������Ϣ��ȫϵͳ��֤�������ҵ���õȼ�AAA��֤�顢ע���ʱ�1��Ԫ��1%�����ѡ�0��ѡ�֧���ϰ������п��������п�֧������Ϸ�㿨֧��������ǩԼ�����ɽ��㡢7X24Сʱ�ͻ����񡢹���ǧ�����ʻ�Ա��Դ��','PayPal�Ǳ���ȫ�������û�׷���Ĺ���ó��֧�����ߣ���ʱ֧������ʱ���ˣ�ȫ���Ĳ������棬��ͨ���й��ı��������������֣�Ϊ�������ó֧�����⣬�����ɹ�������óҵ�񣬾�ʤȫ��'
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