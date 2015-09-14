<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{header}
<body>
<div id="container">

<!-- Header -->
{banner}
<!-- /Header -->

<!-- Navigation bar -->
{nav_bar}
<!-- /Navigation bar -->


<!-- content -->
    <div id="content">



<div class="BGNoCol">

	<!-- page Title -->
	<div id="pageTitle">
		<div id="pageTitleLeft"></div>
		<h1 class="profile">My Account Settings</h1>
		<div id="pageTitleRight"></div>
		<div id="titleNav" class="large">
			<a href="/cashback">Cash Back Summary</a>
			<a href="/tools" id="active">Referral Tools</a>
			<a href="/account">Account Settings</a>
		</div>
	</div>
   	<!-- /page Title -->

    <!-- Left Catagoty -->
    <div class="AccountLeftside">
		<div class="merchantView_Width" style="border:0px solid #090;">
		<div>
		<ul class="tabs">
			<li><a class="active" href=""><font class="tabstext">OVERVIEW</font></a></li>
			<li><a href="/tools/referrals">REFERRALS</a></li>
            <li><a href="/tools/banner">BANNERS</a></li>
            <li><a target="_blank" href="http://www.vistaprint.com/vp/gateway.aspx?sr=no&s=0642720143&email=<?php echo urlencode($email); ?>&offer={id}&fullname={first_name}%20{last_name}&fax={alias}">BEESAVY STORE</a></li>
		</ul>
		</div>
		<div id="tabBorder"></div>
        <div style="font-size:1.3em;font-weight:bold;margin:5px 5px 5px 200px;color:#000;">Refer Friends and Earn Commision Forever!</div>
        <div id="RtoolsNav" style="border:0px solid #090;float:left;margin-left:18px;width:300px;">
                 <form id="facetForm" name="facetForm" action="//categories?category=62" method="get">
</form>
            	 <div class="cat-bg" style="width:300px;float:left;border:0px solid #F00;">
		                        	<div id="cat-left-curve"><img src="<?php echo s3path("/images/cat-left-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
			                        <div id="cat-right-curve"><img src="<?php echo s3path("/images/cat-right-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
                          			<div class="parent">Tools</div>
                      			</div>
              				   <div class="outerbox">
	 								<div class="title2">Email and Link</div>
                                    <div class="RToolsTxt"><p>Get the buzz out! Email your friends about BeeSavy and don't forget to add a signature to your email and forum memberships where allowed.</div>
 								<div class="innerbox">
                                <table><tbody><tr><td rowspan=2 width=30><img src="<?php echo s3path("/images/icons/LinkChain.gif") ?>"></td><td>Share Your Unique Referral Link</td></tr><tr><td><input type=text value="<?php echo base_url(); ?>{alias}"/></td><td></td></tr></tbody></table>

                                         <table><tr><td  width=30><img src="<?php echo s3path("/images/icons/email.gif") ?>"></td><td>Email it<br><a onclick="$.get($(this).attr('href'),function(data){document.location=data;});return false;" href='/tools/email_personal/{alias}'>Personal</a></td><td>Email your friends and watch your cash back grow!</td></tr><tr><td rowspan=2 width=30><img src="<?php echo s3path("/images/icons/email.gif") ?>"></td><td>Email it<br><a onclick="$.get($(this).attr('href'),function(data){document.location=data;});return false;" href='/tools/email_business/{alias}'>Business</a></td><td>
Email your favorite websites and watch your cash back grow!</td></tr></table>


                                     <table><tbody><tr><td rowspan=2 width=30><img src="<?php echo s3path("/images/icons/pen.gif") ?>"></td><td>Add a signature to your emails and forum posts</td></tr><tr><td>
<input id="signature" type=text value="<a href='<?php echo base_url(); ?>{alias}'><img src='<?php echo base_url() ?>Banner/Static/Version_01/234x60_final.jpg'/></a>"/></td></tr></tbody></table>
                               <div style="margin-left:10px;"><table><tbody><tr><td width=5>
<INPUT id=check checked=1 type=radio name=method onclick="$('#signature')[0].value='<a href=\'<?php echo base_url(); ?>{alias}\'><img src=\'<?php echo base_url() ?>Banner/Static/Version_01/234x60_final.jpg\'/></a>';"></td><td align=left>
<LABEL for=check><p class="small">Email Signature</LABEL></td><td width=5>
<INPUT id=check type=radio name=method onclick="$('#signature')[0].value='[URL=<?php echo base_url(); ?>{alias}][IMG]<?php echo base_url() ?>Banner/Static/Version_01/234x60_final.jpg[/IMG][/URL]';"></td><td align=left width=100>
<LABEL for=check><p class="small">Forum Signature</LABEL></td><td></td></tr></tbody></table></div>
        				  		    </div>


                                    <div class="title2">Social networking</div>
                                    <div class="RToolsTxt"><p>Build your cash back through social networks. Post a one time message or automatically let your social network know when you save money with BeeSavy!</div>
         		                    <div class="innerbox">
				<table><tr><td width=25 align=left><img src="<?php echo s3path("/images/facebooktop.gif") ?>" width=31 height=31></td><td>Share it on Facebook</td></tr></table>
	<FORM id=changeNewsletterForm method=post name=changeNewsletterForm action=/tools/set_setting>
				<input name="setting" value="facebook_auto" type="hidden">
    <table><tr><td align=center width=10><INPUT id=newsletter value=1 onclick="this.form.submit();"
    <?php if($facebook_auto) echo"CHECKED"?> type=checkbox name=value></td><td>Automatically post cash back messages to your Facebook wall.</td></tr></table>
	</FORM>

                <table><tr><td width=10></td><td><p class=small>Ex. I just saved $5.22 by shopping with Beesavy.</td></tr></table>


				<table border=0><tr><td width=25 align=left><img src="<?php echo s3path("/images/twittertop.gif") ?>" width=31 height=31></td><td>Tweet it</td></tr></table>
	<FORM id=changeNewsletterForm method=post name=changeNewsletterForm action=/tools/set_setting>
				<input name="setting" value="twitter_auto" type="hidden">
    <table><tr><td align=center width=10><INPUT onclick="this.form.submit(); return false;" id=newsletter value=1 <?php if($twitter_auto) echo"CHECKED"?> type=checkbox name=value></td><td>Automatically tweet cash back messages to your Twitter account.</td></tr></table><br>

	</FORM>

                <table><tr><td width=10></td><td><p class=small>Ex. I just saved $5.22 by shopping with Beesavy.</td></tr></table>
				<table><tr><td><p class=small><strong>Note: </strong>No personal information such as where you shoppped or what you purchased will be shared.</td></tr></table>
        				  	        </div>

                            		<div style="clear:both;height:10px;"></div>
							   </div>
           	 </div>


             <!-- FAQ  -->
             <div class="OverviewBox">
	         	<div class="CurveBox">
			 		<div class="FAQtitle2">FAQ</div>
                    	<div class="RToolsFAQTxt">
                        <p class="orange">How does it work?</p>
<p style="margin-top:10px;">Every time you refer someone to BeeSavy, you get credit for the referral.  This means that you earn commission on all of their spending forever!  You also earn on the people they refer down to seven levels deep!<br>

                        <p class="orange">What are the rules?</p>
<p style="margin-top:10px;">If someone joins BeeSavy  within 14 days after clicking your link, OR if they enter your referral code upon registration, we'll credit you with the referral. You can refer as many people as you like. Please be courteous and follow proper internet etiquette when referring people.  This means no spamming and only "family friendly" sites.
<br>

                        <p class="orange">What is the catch?</p>
<p style="margin-top:10px;">There is no catch!  There are no minimum spending requirements and no minimum number of referrals.  Simply use BeeSavy to do your usual online shopping and, if you like it, tell your friends and earn referral cash back.  To claim your referral cash back, the only requirement is that your account be active.  An active account is one that has made a purchase (any purchase) in the past 90 days.<br>
                        </div>
                                            <div style="clear:both;height:10px;"></div>
  					</div>

           	   </div>
             <!-- /FAQ  -->


   </div>
	</div>
	<!-- /Left Catagoty -->


<!-- Right Catagoty -->
<div class="AccountRightside">
<!--
<div class="RightBanner">
<script type='text/javascript'>
    OA_show(3);
</script><noscript><a target='_blank' href='http://50.16.95.24/openx/www/delivery/ck.php?n=a88fd39'><img border='0' alt='' src='http://50.16.95.24/openx/www/delivery/avw.php?zoneid=1&amp;n=a88fd39' /></a></noscript>
<!--<img src="<?php echo s3path("/images/rightbanner.jpg") ?>">
</div>-->

<!-- Referral Overview -->
<div class="TotalBox">
<div  class="blockgradiant-bg">
	<div id="cat-left-curve"><img src="<?php echo s3path("/images/cat-left-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div id="cat-right-curve"><img src="<?php echo s3path("/images/cat-right-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div class="title1">Referral Overview</div>
</div>
{total}
<div class="outerbox">
	<div class="title2">Personal Cash Back</div>
	<div class="innerbox">
	<table><tbody><tr><td><strong>Level 1 Referrals:</storng></td><td>{referralcountdirect}</td></tr></tbody><tfoot><tr><td colspan=2>@10% Commission</td></tr></tfoot></table>
	<table><tbody><tr><td><strong>Level 2 to 7 Referrals:</storng></td><td>{referralcountindirect}</td></tr></tbody><tfoot><tr><td colspan=2>@10% Commission</td></tr></tfoot></table>
    <table><tbody><tr><td><strong>Total Referral Network:</storng></td><td><?php echo $total[0]['referralcountdirect'] + $total[0]['referralcountindirect']?></td></tr></tbody></table>
	</div>
	<div class="title2">Referral Cash Back</div>
	<div class="innerbox">
    <table><tbody><tr><td><strong>Total to Date:</storng></td><td>$<?php echo $total[0]['referralavailable']+$total[0]['referralpending'] ?></td></tr></tbody></table>
	<table><tbody><tr><td><strong>Available:</storng></td><td>${referralavailable}</td></tr></tbody></table>
	</div>
<?php
if((float)$total[0]['available'] > 10){ ?>
        <div class="Request"><div class="BtnRequestBg BtnRequest"><a class="button" href="/account/index/0/2" rel="nofollow">REQUEST A PAYMENT</a></div></div>
        <div class="RequestNote">You can now request a payment!</div>
<?php } else {
    $dif = number_format(10 - (float)$total[0]['available'],2);
?>

        <div class="Request"><img style="padding-left:50px;padding-top:10px;" src="<?php echo s3path("/images/btn-request-payment-gray.gif") ?>"/></div>
        <div class="RequestNote">You need an additional $<?php echo $dif ?> to request a payment.</div>
<?php } ?>
	<div style="clear:both;height:10px;"></div>
</div>
{/total}
</div>
<!-- Referral Overview -->
</div>
<!-- Right category -->


	<div style="clear: both;"></div>
	</div>
<!-- /content -->



<!-- footer -->
    <div style="clear: both;"></div>

<div id="ftr" class="ftrLeftCol">
		<p id="links" style="height: 20px; line-height: 20px;">Copyright © 2010 BeeSavy, LLC. All Rights Reserved. <a href="/stores/storelist">All Stores</a> |  <a href="/info/terms">Terms of Service</a> | <a href="/info/privacy">Privacy Policy</a> | <a href="/info/contact">Contact Us</a></p>
		<a href="http://twitter.com/" target="_blank" class="socialMedia twitter">Follow Us On Twitter</a>
		<a href="http://facebook.com/" target="_blank" class="socialMedia facebook">Like Us on Facebook</a>
		<div style="clear: both;"></div>
		<p id="disclaimer">Tax and shipping costs are estimates; please see the store's website for exact pricing. BeeSavy does not guarantee the
accuracy of information provided by online stores and other third parties, including product information, prices, coupons, and
availability. BeeSavy shall not be liable for or responsible to honor any inaccurate information shown on our website. Please see our <a href="">Terms of Service</a> for more details.</p>
	</div>
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
