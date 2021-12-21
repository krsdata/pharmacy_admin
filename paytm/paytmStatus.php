<?php
/*
* import checksum generation utility
* You can get this utility from https://developer.paytm.com/docs/checksum/
*/
require_once("PaytmChecksum.php");

$paytmParams = array();

$paytmParams["MID"]     = "YOUR_MID_HERE";
$paytmParams["ORDERID"] = "ORDERID_98765";

/*
* Generate checksum by parameters we have
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
$checksum = PaytmChecksum::generateSignature($paytmParams, "YOUR_MERCHANT_KEY");

$paytmParams["CHECKSUMHASH"] = $checksum;

$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
$url = "https://securegw-stage.paytm.in/order/status";

/* for Production */
// $url = "https://securegw.paytm.in/order/status";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  
$response = curl_exec($ch);
print_r($response);
