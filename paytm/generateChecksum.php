<?php
//use Redirect;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, auth-token');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Origin: *");
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");
include("./env.php");
//echo PAYTM_MERCHANT_KEY;
header("Content-Type: application/json");

$mid = 'SDBEXq82035234210571'; //'LoPyaL46096848169204'; //key = tpJmKe81092739039978
$mkey = 't3fX4Ses32j_m5ZF';    //mid =  1PRscwi&opK94P!5

//define('PAYTM_MERCHANT_KEY', $mkey);
$_POST = json_decode(file_get_contents('php://input'), true);
$checkSum = "";
//ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
// below code snippet is mandatory, so that no one can use your checksumgeneration url for other purpose .
$findme   = 'REFUND';
$findmepipe = '|';
$paramList = array();
$paramList["MID"] = $mid;
$_POST = json_decode(file_get_contents('php://input'), true);
if(isset($_POST['ORDER_ID']) and empty($_POST['ORDER_ID']) OR !isset($_POST['ORDER_ID'])){
         echo json_encode(array("ORDER_ID" => 'Order is required to generate checksum'));
         exit();

}
if($_POST){
	$paramList['MID'] = $_POST['MID'];
	$paramList['INDUSTRY_TYPE_ID'] =$_POST['INDUSTRY_TYPE_ID'];
	$paramList['CHANNEL_ID'] =$_POST['CHANNEL_ID'];
	$paramList['WEBSITE'] =$_POST['WEBSITE'];
	$paramList['ORDER_ID'] =$_POST['ORDER_ID'];
	$paramList['CALLBACK_URL'] =$_POST['CALLBACK_URL'];
	$paramList['CUST_ID'] =$_POST['CUST_ID'];
	$paramList['EMAIL'] =$_POST['EMAIL'];
	$paramList['MOBILE_NO'] =$_POST['MOBILE_NO'];
	$paramList['TXN_AMOUNT'] =$_POST['TXN_AMOUNT'];


//exec('curl https://app.ninja11.in/api/v2/paytmCallBack?user_id='.$_POST['CUST_ID'].'&email='.$_POST['EMAIL'].'&deposit_amount='.$_POST['TXN_AMOUNT']);

}

//1PRscwi&opK94P!5
$merchant_key = $mkey;

//Here checksum string will return by getChecksumFromArray() function.
$checkSum = getChecksumFromArray($paramList,$merchant_key);
//print_r($_POST);
 echo json_encode(array("CHECKSUMHASH" => $checkSum,"order_id" => $_POST["ORDER_ID"], "status" => "1"));
