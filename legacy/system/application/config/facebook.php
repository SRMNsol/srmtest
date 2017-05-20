<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
 * Configuration and setup Facebook SDK
 */
$config['appId'] 			= '103559523515694'; //Facebook App ID
$config['appSecret'] 		= 'f544babf07d2e85e3a4270ece485e418'; //Facebook App Secret
$config['redirectURL'] 		= 	'http://dev.nsol.sg/projects/beesavy_new/legacy/public/main/fblogin'; //Callback URL
$config['fbPermissions'] 	= array('email');  //Optional permissions

?>
