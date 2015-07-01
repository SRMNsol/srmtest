<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta name="description" content="Save money on millions of products from thousands of top online stores at beesavy.com with comparison shopping, cash back, and coupons." />
<title>Beesavy</title>
<link href="<?php echo s3path("/styles/account.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/main.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/home.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/results.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/view.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/button.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo s3path("/scroll/styles/jScrollPane.css") ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo s3path("/scroll/styles/scrollstyles.css") ?>" />
<script type="text/javascript" src="<?php echo s3path("/script_files/extrabux.js") ?>"></script>
<script type="text/javascript" src="<?php echo s3path("/script_files/ZeroClipboard.js") ?>"></script>
<script type="text/javascript" src="<?php echo s3path("/script_files/jquery.js") ?>"></script>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="<?php echo s3path("/www.beesavy.com") ?>" layout="box_count" show_faces="true" width="150" font="arial"></fb:like>
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
	<div id="pageTitle">
		<div id="pageTitleLeft"></div>
		<h1 class="profile">Cash Back Summary</h1>
		<div id="pageTitleRight"></div>
		<div id="titleNav" class="large">
			<a href="http://www.extrabux.com/users/profile" id="active">Cash Back Summary</a>
			<a href="http://www.extrabux.com/users/referral">Referral Tools</a>
			<a href="http://www.extrabux.com/users/settings">Account Settings</a>
		</div>
	</div>
   	<!-- /page Title -->



    <div class="BGNoCol">


		<!-- Left Category -->
    <div class="AccountLeftside">
<div class="merchantView_Width">
	<div >
		<ul class="tabs">
		<?php
		$activetab = array('class="active"','','');
		if($type=='personal'){
		    $activetab = array('','class="active"','');
		}elseif($type=='referral'){
		    $activetab = array('','','class="active"');
		}?>
			<li><a <?php echo $activetab[0]?> href="/account/cashback/all"><font class="tabstext">All</font></a></li>
			<li><a <?php echo $activetab[1]?> href="/account/cashback/personal">Personal</a></li>
			<li><a <?php echo $activetab[2]?> href="/account/cashback/referral">Referral</a></li>
		</ul>
	</div>
	<div id="tabBorder"></div>
	<table class="matrix" id="profile">
		<thead>
			<tr>
				<th class="header"><a href="#">Month</a></th>
				<th class="header"><a href="#">Type</a></th>
				<th class="header"><a href="#">Status</a></th>
				<th class="header"><a href="#">Cash Back</a></th>
				<th class="header"><a href="#">Payment Date</a></th>
			</tr>
		</thead>
		<tbody>
		{transactions}
		<tr><td>{month}</td><td>{type}</td><td>{status}</td><td>${cashback}</td><td>{payment_date}</td></tr>
		{/transactions}
        </tbody>
    </table>
    </div>
<div style="clear: both;"></div>
</div>
	<!-- /Left Category -->

  <!-- Right Catagoty -->
<div class="AccountRightside">
<!-- Referral Overview -->
<div class="RightBanner">
<img src="<?php echo s3path("/images/rightbanner.jpg") ?>">
</div>
<div class="TotalBox">
<div  class="blockgradiant-bg">
	<div id="cat-left-curve"><img src="<?php echo s3path("/images/cat-left-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div id="cat-right-curve"><img src="<?php echo s3path("/images/cat-right-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div class="title1">Cash Back Overview</div>
</div>
<div class="outerbox">
	<div class="title2">Personal Cash Back</div>
	{personal}
	<div class="innerbox">
    <table><tbody><tr><td><strong>Pending :</strong></td><td>${pending}</td></tr><tr><td><strong>Available :</strong></td><td>${available}</td></tr></tbody></table>
	</div>
	{/personal}
	<div class="title2">Referral Cash Back</div>
	<div class="innerbox">
	{referral}
    <table ><tbody><tr><td><strong>Pending :</strong></td><td>${pending}</td></tr><tr><td><strong>Available :</strong></td><td>${available}</td></tr><tr><td colspan="2"><p class="small"><strong>Note:</strong> {notice} </span></td></tr></tbody></table>
	</div>
	{/referral}
    <div class="title2">Total Cash Back</div>
    {total}
	<div class="innerbox">
    <table><tbody><tr><td><strong>Pending :</strong></td><td>${pending}</td></tr><tr><td><strong>Available :</strong></td><td>${processing}</td></tr><tr><td><strong>Processing :</strong></td><td>${available}</td></tr><tr><td><strong>Paid :</strong></td><td>${paid}</td></tr></tbody></table>
	</div>
	{/total}
        <div class="Request"><div class="BtnRequestBg BtnRequest"><a class="button" href="" target="_blank" rel="nofollow">REQUEST A PAYMENT</a></div></div>
        <div class="RequestNote">You can now request a payment!</div>
	<div style="clear:both;height:10px;"></div>
</div>
</div>
<!-- Referral Overview -->
</div>
<!-- Right category -->
<!-- /content -->




<!-- footer -->
    <div style="clear: both;"></div>

	<div id="ftr" class="ftrLeftCol">
		<p id="links" style="height: 20px; line-height: 20px;">Copyright © 2010 Beesavy, LLC. All Rights Reserved. <a href="">All Stores</a> | <a href="">Popular Brands</a> | <a href="">Terms of Service</a> | <a href="">Privacy Policy</a></p>
		<a href="http://twitter.com/" target="_blank" class="socialMedia twitter">Follow Us On Twitter</a>
		<a href="http://facebook.com/" target="_blank" class="socialMedia facebook">Like Us on Facebook</a>
		<div style="clear: both;"></div>
		<p id="disclaimer">Tax and shipping costs are estimates; please see the store's website for exact pricing. Beesavy does not guarantee the
accuracy of information provided by online stores and other third parties, including product information, prices, coupons, and
availability. Beesavy shall not be liable for or responsible to honor any inaccurate information shown on our website. Please see our <a href="">Terms of Service</a> for more details.</p>
	</div>
  </div>
<!-- /footer -->

	<script>
$(window).load(function() {
	mCustomScrollbars();
});

function mCustomScrollbars(){
	/*
	malihu custom scrollbar function parameters:
	1) scroll type (values: "vertical" or "horizontal")
	2) scroll easing amount (0 for no easing)
	3) scroll easing type
	4) extra bottom scrolling space for vertical scroll type only (minimum value: 1)
	5) scrollbar height/width adjustment (values: "auto" or "fixed")
	6) mouse-wheel support (values: "yes" or "no")
	7) scrolling via buttons support (values: "yes" or "no")
	8) buttons scrolling speed (values: 1-20, 1 being the slowest)
	*/
	$("#mcs_container").mCustomScrollbar("vertical",400,"easeOutCirc",1.05,"auto","yes","yes",10);
	$("#mcs2_container").mCustomScrollbar("vertical",0,"easeOutCirc",1.05,"auto","yes","no",0);
	$("#mcs3_container").mCustomScrollbar("vertical",900,"easeOutCirc",1.05,"auto","no","no",0);
	$("#mcs4_container").mCustomScrollbar("vertical",200,"easeOutCirc",1.25,"fixed","yes","no",0);
	$("#mcs5_container").mCustomScrollbar("horizontal",500,"easeOutCirc",1,"fixed","yes","yes",20);
}

/* function to fix the -10000 pixel limit of jquery.animate */
$.fx.prototype.cur = function(){
    if ( this.elem[this.prop] != null && (!this.elem.style || this.elem.style[this.prop] == null) ) {
      return this.elem[ this.prop ];
    }
    var r = parseFloat( jQuery.css( this.elem, this.prop ) );
    return typeof r == 'undefined' ? 0 : r;
}

/* function to load new content dynamically */
function LoadNewContent(id,file){
	$("#"+id+" .customScrollBox .content").load(file,function(){
		mCustomScrollbars();
	});
}
</script>
<script src="<?php echo s3path("/jquery/jquery_003.js") ?>">
</script>



  </body>
  </html>
