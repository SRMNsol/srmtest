<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Save money on millions of products from thousands of top online stores at BeeSavy.com with comparison shopping, cash back, and coupons." />
<title>BeeSavy – Taking the sting out of online shopping</title>
<link rel="shortcut icon" href="<?php echo s3path("/images/favicon.ico") ?>" />
<link href="<?php echo s3path("/styles/main.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/home.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/results.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/button.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/view.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/css/custom.css">
<link rel="stylesheet" href="/css/select2.css">
<link media="screen" rel="stylesheet" href="<?php echo s3path("/styles/colorbox.css") ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script src="/js/select2.js"></script>
<script src="/js/autocomplete.js"></script>
<script src="<?php echo s3path("/colorbox/jquery.colorbox.js") ?>"></script>
<script type='text/javascript' src="<?php echo s3path("/script_files/nav_bar.js") ?>"></script>
</head>
<body>
<div id="container">
<!-- Header -->
      {banner}
<!-- /Header -->


<!-- Navigation bar -->
    {nav_bar}
<!-- /Navigation bar -->

<!-- content -->
		<!-- page Title -->

		<div class="BGNoCol">

        <!-- page Title -->

        <?php if (count($merchants) > 0): ?>
            <div id="pageTitle">
                <div id="pageTitleLeft"></div>
                <h1>We Found <?php echo count($merchants); ?> Stores Matching {search}</h1>
                <div id="pageTitleRight"></div>
                <div style="float: right; margin-top: 20px;" id="referral-popup" >
                    <img src="<?php echo s3path("/images/tell-a-friend.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/>
                    <a target='_blank' href='/social/store/facebook/{id}'><img src="<?php echo s3path("/images/facebook-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
                    <a target='_blank' href='/social/store/twitter/{id}'><img src="<?php echo s3path("/images/twitter-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
                    <a onclick="$.get($(this).attr('href'),function(data){document.location=data;});return false;" href='/social/store/email/{id}'><img src="<?php echo s3path("/images/email-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
                </div>
            </div>
            <div id="merchantView" style="width:700px;">
                <?php foreach ($merchants as $merchant): ?>
                    <?php $cashback_text = $merchant->getCommissionShareText($rate->getLevel0() * 100, '$', 'Up to :max'); ?>
                    <div id="storeInfo" style="width: 100%">
                        <div id="description" style="width: 100%">
                            <div id="logo">
                              <a class="transfer-link" href="/stores/details/<?php echo $merchant->getId(); ?>" target="_blank" rel="nofollow">
                                  <img  class="cdn-image" style="padding: 10px;" src="<?php echo s3rotate($merchant->getLogoWebUrl()); ?>" onload="
                                        var width = 100;
                                        var height = 32;
                                        var ratio= Math.min(width/this.width, height/this.height);
                                        var nwidth = ratio*this.width;
                                        var nheight = ratio*this.height;
                                        this.width = nwidth;
                                        this.height = nheight;"
                                    alt="** PLEASE DESCRIBE THIS IMAGE **" onerror="this.src="<?php echo s3path("/../images/no-image-100px.gif") ?>""/>
                              </a>
                            </div>
                            <div class="ShopCashBack">
                                <div class="ShopCashBack-Bt BtnSCBOrangeBg">
                                    <a class="BtnCBBlackTxt button" href="/transfer/store/<?php echo $merchant->getId(); ?>" target="_blank" rel="nofollow">
                                        <?php if ($cashback_text) : ?>
                                            Shop <?php echo escape($cashback_text) ?> Cashback
                                        <?php else : ?>
                                            Go to shop
                                        <?php endif ?>
                                    </a>
                                </div>
                            </div>
                            <div style="margin-top: 15px; clear: both;"><?php
                                foreach (explode("\n", $merchant->getDescription()) as $line) {
                                    echo escape($line) . '<br>';
                                }
                            ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <DIV id=content class=BGNoCol>
        <DIV id=pageTitle>
        <DIV id=pageTitleLeft></DIV>
        <H1>We Found 0 Stores Matching {search}</H1>
        <DIV id=pageTitleRight></DIV></DIV>

        <DIV id=error>
        <table cellspacing=0 cellpadding=0 style="margin-left:10px;">
        <tr><td><img src="<?php echo s3path("/images/sorry_bee.jpg") ?>"></td><td>
        <P>
        Sorry, we did not find any results that matched your search query</P>
        </td></tr></table>
        <DIV style="CLEAR: both"></DIV></DIV>

        <DIV style="HEIGHT: 10px; CLEAR: both"></DIV></DIV>
    <?php endif; ?>



       <!-- Right side -->




<!-- /content -->
<!-- footer -->
    {footer}
<!-- /footer -->

<SCRIPT type=text/javascript
src="<?php echo s3path("/Extrabux_com%20-%20Page%20Not%20Found_files/extrabux.main.layout.7120.js") ?>"></SCRIPT>

<SCRIPT type=text/javascript>_qoptions={qacct:"p-1cqtECMNlCeJ2"};</SCRIPT>

<SCRIPT type=text/javascript
src="<?php echo s3path("/Extrabux_com%20-%20Page%20Not%20Found_files/quant.js") ?>"></SCRIPT>

<SCRIPT type=text/javascript
src="Extrabux_com%20-%20Page%20Not%20Found_files/pixel"></SCRIPT>

<SCRIPT type=text/javascript>
/* <![CDATA[ */
var google_conversion_id = 1062158219;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "5y5nCKGR_QEQi_-8-gM";
var google_conversion_value = 0;
/* ]]> */
</SCRIPT>

<SCRIPT type=text/javascript
src="<?php echo s3path("/Extrabux_com%20-%20Page%20Not%20Found_files/conversion.js") ?>">
</SCRIPT>
<NOSCRIPT>
<DIV style="DISPLAY: inline"><IMG
style="BORDER-BOTTOM-STYLE: none; BORDER-RIGHT-STYLE: none; BORDER-TOP-STYLE: none; BORDER-LEFT-STYLE: none"
alt="" src="<?php echo s3path("/Extrabux_com%20-%20Page%20Not%20Found_files/1062158219.gif") ?>" width=1
height=1> </DIV></NOSCRIPT>



  </body>
  </html>
