<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="Save money on millions of products from thousands of top online stores at beesavy.com with comparison shopping, cash back, and coupons." />
<link rel="shortcut icon" href="<?php echo s3path("/images/favicon.ico") ?>" />
<title>BeeSavy - Taking the sting out of online shopping</title>
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

<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/main.css") ?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/home.css") ?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/transfer.css") ?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/account.css") ?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/button.css") ?>" media="screen"/>

<script type="text/javascript" src="<?php echo s3path("/script_files/jquery_004.js") ?>"></script>

<?php echo googletag_head() ?>

</head>
<body>
<div id="container" style="width:100%;">
    <?php echo googletag_ad('BS_coupon_728x90', 10, 'none') ?>
    <div style="margin:auto; width:1210px;">
        <div style="width:300px; display:inline-block;"><?php echo googletag_ad('BS_coupon_300x600_1', 0, 'none') ?></div>
        <div style="margin:auto; width:602px; display:inline-block; vertical-align:top;">
            <div id="transfer" style="margin:0;">
                <div id="title">
                    <h1 class="oneLine">Transferring You to <strong>{name}</strong></h1>
                    <img src="<?php echo s3path("/images/loading.gif") ?>">
                </div>
                <div style="height:30px; clear: both;"></div>
                <div class="div"></div>
                <div class="thumb" id="merchantThumb">
                    <img class="cdn-image" src="{logo_thumb}" alt="{name}" onload="
                        var width = 100;
                        var height = 32;
                        var ratio = Math.min(width/this.width, height/this.height);
                        var nwidth = ratio*this.width;
                        var nheight = ratio*this.height;
                        this.width = nwidth;
                        this.height = nheight;"
                    onerror="this.src='<?php echo s3path("/images/no-image-100px.gif") ?>'">
                    <!-- Load cookie -->
                    <!-- End cookie-->
                </div>
                <div id="equation">
                    <div id="cashBackTransfer" class="tall"><strong>{cashback_text} Cash Back</strong> will be posted to your BeeSavy account in 1 - 4 days</div>
                </div>
                <div style="clear: both; height: 20px;"></div>
            </div>
            <div id="manualRedirect"><a href="{destination_url}">If you are not automatically redirected, click here</a></div>
        </div>
        <div style="width:300px; display:inline-block;"><?php echo googletag_ad('BS_coupon_300x600_2', 0, 'none') ?></div>
    </div>
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

function transfer() {
    window.location = '{cookie_url}';
}
</script>
</body>
</html>
