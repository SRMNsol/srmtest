<?php
session_start();

// Include the autoloader provided in the SDK
require_once APPPATH. 'controllers/fb/facebook-php-sdk/autoload.php';
require_once APPPATH. 'controllers/fb/facebook-php-sdk/Facebook.php';
require_once APPPATH. 'controllers/fb/facebook-php-sdk/FacebookApp.php';
require_once APPPATH. 'controllers/fb/facebook-php-sdk/FacebookBatchRequest.php';


// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Url\FacebookUrlDetectionHandler;

/*
 * Configuration and setup Facebook SDK
 */
 
 

$appId 			= '103559523515694'; //Facebook App ID
$appSecret 		= 'f544babf07d2e85e3a4270ece485e418'; //Facebook App Secret
$redirectURL 	= 'http://dev.nsol.sg/projects/beesavy_new/legacy/public/main/fblogin'; //Callback URL
$fbPermissions 	= array('email');  //Optional permissions



$fb = new Facebook(array(
	'app_id' => $appId,
	'app_secret' => $appSecret,
	'default_graph_version' => 'v2.8'
));
// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();
if (isset($_GET['state'])) {
    	$helper->getPersistentDataHandler()->set('state', $_GET['state']);
	}
// Try to get access token
//print_r($helper);
try {
	$_SESSION['code'] = $_GET['code'];
	$_SESSION['state'] = $_GET['state'];
	
	if(isset($_SESSION['facebook_access_token'])){
		$accessToken = $_SESSION['facebook_access_token'];
	}else{
  		$accessToken = $helper->getAccessToken();
	
	}
} catch(FacebookResponseException $e) {
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(FacebookSDKException $e) {
//var_dump($_GET, $_SESSION);
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
}
