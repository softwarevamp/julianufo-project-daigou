<?php
/*
 * config.inc.php
 */
//Configuration Settings

$paypal[business]=$payment_userid[5];
$paypal[site_url]=SITE_URL;
$paypal[image_url]="";
$paypal[success_url]=SITE_URL."/paycenter/paypal/return_url.php";
//$paypal[success_url]="php_paypal/ipn/ipn.php";
$paypal[cancel_url]="php_paypal/error.php";
$paypal[notify_url]=SITE_URL."/paycenter/paypal/notify_url.php";
$paypal[return_method]="1"; //1=GET 2=POST
$paypal[currency_code]="USD"; //[USD,GBP,JPY,CAD,EUR]
$paypal[lc]="US";


$paypal[url]="https://www.paypal.com/cgi-bin/webscr";
//$paypal[url]="https://www.sandbox.paypal.com/cgi-bin/webscr";
$paypal[post_method]="fso"; //fso=fsockopen(); curl=curl command line libCurl=php compiled with libCurl support
$paypal[curl_location]="/usr/local/bin/curl";

$paypal[bn]="toolkit-php";
$paypal[cmd]="_xclick";



//posts transaction data using fsockopen.
function fsockPost($url,$data) {

//Parse url
$web=parse_url($url);

//build post string
foreach($data as $i=>$v) {
$postdata.= $i . "=" . urlencode($v) . "&";
}

$postdata.="cmd=_notify-validate";

//Set the port number
if($web[scheme] == "https") { $web[port]="443";  $ssl="ssl://"; } else { $web[port]="80"; }

//Create paypal connection
$fp=@fsockopen($ssl . $web[host],$web[port],$errnum,$errstr,30);

//Error checking
if(!$fp) { echo "$errnum: $errstr"; }

//Post Data
else {

  fputs($fp, "POST $web[path] HTTP/1.1\r\n");
  fputs($fp, "Host: $web[host]\r\n");
  fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
  fputs($fp, "Content-length: ".strlen($postdata)."\r\n");
  fputs($fp, "Connection: close\r\n\r\n");
  fputs($fp, $postdata . "\r\n\r\n");

//loop through the response from the server
while(!feof($fp)) { $info[]=@fgets($fp, 1024); }

//close fp - we are done with it
fclose($fp);

//break up results into a string
$info=implode(",",$info);

}

return $info;

   }

?>