<?php
include_once CFG_CACHEPATH.'/sys_pay.cache.php';//支付配置文件
require_once(dirname(__FILE__)."/paypal_config.php");



$price = sprintf("%01.2f", $priceCount);

$subject=$value["gtitle"]."支付订单号:".$OrdersId;

$reval  = "";
$reval .= "<input type=\"hidden\" name=\"cmd\" value=\"{$paypal[cmd]}\" />			\n";
$reval .= "<input type=\"hidden\" name=\"return\" value=\"{$paypal[success_url]}\" />\n";
$reval .= "<input type=\"hidden\" name=\"notify_url\" value=\"{$paypal[notify_url]}\" />\n";
$reval .= "<input type=\"hidden\" name=\"business\" value=\"{$paypal[business]}\" />	\n";
$reval .= "<input type=\"hidden\" name=\"item_name\" value=\"{$subject}\" />	\n";
$reval .= "<input type=\"hidden\" name=\"item_number\" value=\"{$OrdersId}\" />	\n";
$reval .= "<input type=\"hidden\" name=\"rm\" value=\"2\" />\n";
$reval .= "<input type=\"hidden\" name=\"charset\" value=\"utf-8\" />\n";
$reval .= "<input type=\"hidden\" name=\"currency_code\" value=\"{$paypal[currency_code]}\">\n";
$reval .= "<input type=\"hidden\" name=\"invoice\" value=\"{$OrdersId}\" />\n";
$reval .= "<input type=\"hidden\" name=\"amount\" value=\"{$price}\" />\n";


$hiddeninput=$reval;

$strRequestUrl	= $paypal[url];
echo '<html>
<head>
	<title>转到支付页面</title>
</head>
<body onLoad="document.alipay.submit();">
	<form name="alipay" action="'.$strRequestUrl.'" method="post">
	'.$hiddeninput.'
	</form>
</body>
</html>';
exit;
?>