<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta name="description" content="Save money on millions of products from thousands of top online stores at beesavy.com with comparison shopping, cash back, and coupons." />
<link rel="shortcut icon" href="/images/favicon.ico" />
<title>BeeSavy - Taking the sting out of online shopping</title>
<link href="/styles/main.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/styles/home.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/styles/transfer.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/styles/account.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/script_files/extrabux.js"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23342317-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script src="{cookie_url}"></script>
<link href="/styles/button.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
    <div id="transfer">
	<div id="title">
  	<h1 class="oneLine">Transferring You to <strong>{merchant_name}</strong></h1>
    <img src="/images/loading.gif">
  </div>      
	<div style="height:30px; clear: both;"></div>	
  <div class="div"></div>
	  <div class="thumb" id="merchantThumb">

    <img class="cdn-image" src="{merchant_logo}" 
onload="
        var width=100;
    var height=32; 
    var ratio= Math.min(width/this.width, height/this.height);
    var nwidth=ratio*this.width; 
    var nheight=ratio*this.height; 
    this.width=nwidth; 
    this.height=nheight;" 
alt="{merchant_name}" onerror="this.src ='/images/no-image-100px.gif'">
<!-- Load cookie -->
<!-- End cookie-->
  </div>
  <div id="equation">  
  <div id="BeesavyTransfer" class="tall">{name}<?php if($code_prefix){?>, be sure to use Coupon <strong>Code {code} </strong><? } ?> </div>
  <div id="cashBackTransfer" class="tall"><strong>{cashback_text} Cash Back</strong> will be posted to your BeeSavy account in 1 - 4 days</div>
        </div>
        <div style="clear: both; height: 20px;"></div>
	</div>
	<div id="manualRedirect"><a href="{link}">If you are not automatically redirected, click here</a></div>
</div>

<script>
$(document).ready(function() {
    $("div.LogIn").mouseover(function () {
        var element = $(this);
 		element.find('.BtnLogIn').addClass('BtnLogInRBg').removeClass('BtnLogInBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnLogInRBg').addClass('BtnLogInBg').removeClass('BtnLogInRBg');
    });
	
	    $("div.SignUp").mouseover(function () {
        var element = $(this);
 		element.find('.BtnSignUp').addClass('BtnSignUpRBg').removeClass('BtnSignUpBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnSignUpRBg').addClass('BtnSignUpBg').removeClass('BtnSignUpRBg');
    });
    setTimeout("transfer()", 3000);
	
   	});
function transfer(){
    window.location = '{destination_url}';
}
</script>
</body>
</html>
