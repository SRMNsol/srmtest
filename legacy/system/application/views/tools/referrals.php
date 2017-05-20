<!-- Header -->

<?php $this->load->view('blocks/header'); ?>
<!-- /Header -->

<body>
<style>.btn_bee_savy {
    background-color: #c23115;
    color: #fff;
    border-radius: 0px;
    padding: 5px 40px;
    border: 1px #c23115 solid;
    vertical-align: initial;
}.top_buttons{
	
}
</style>


<div id="container">
    <!-- Navigation bar -->
<?php $this->load->view('blocks/admin-topbar'); ?>
<!-- /Navigation bar -->
<!-- content -->



    <div class="BGNoCol">

	<!-- page Title -->
	<div id="pageTitle">
		<div id="pageTitleLeft"></div>
		<h1 class="profile">Cash Back Summary</h1>
		<div id="pageTitleRight"></div>
		<div id="titleNav" class="large">
			<a href="/cashback">Cash Back Summary</a>
			<a href="/tools" id="active">Referral Tools</a>
			<a href="/account" >Account Settings</a>
		</div>
	</div>
   	<!-- /page Title -->

		<!-- Left Category -->
    <div class="AccountLeftside">
<div class="merchantView_Width">
	<div>
		<ul class="tabs">
			<li><a href="/tools"><font class="tabstext">OVERVIEW</font></a></li>
			<li><a class="active" href="/tools/referrals">REFERRALS</a></li>
            <li><a href="/tools/banner">BANNERS</a></li>
            <li><a target="_blank" href="http://www.vistaprint.com/vp/gateway.aspx?sr=no&s=0642720143&email=<?php echo urlencode($email); ?>&offer={id}&fullname={first_name}%20{last_name}&fax={alias}">BEESAVY STORE</a></li>
		</ul>
		</div>
	<div id="tabBorder"></div>
<?php if(empty($referrals)){
    echo "<p style='font-size:1.5em;text-align:center;padding-top:20px;'>You currently have no referrals. Start referring today!</p>";
}else{ ?>
	<table class="matrix" id="profile">
		<thead>
			<tr>
				<th class="header">Email Address</th>
				<th class="header">Referral Date</th>
			</tr>
		</thead>
		<tbody>
		{referrals}
		<tr><td>{ref_email}</td><td>{ref_created}</td></tr>
		{/referrals}
        </tbody>
    </table>
<?php } ?>
</div>
<div style="clear: both;"></div>
</div>
	<!-- /Left Category -->

  <!-- Right Catagoty -->
<div class="AccountRightside">
<!-- Referral Overview -->
<!--<div class="RightBanner">
<script type='text/javascript'>
    OA_show(3);
</script><noscript><a target='_blank' href='http://50.16.95.24/openx/www/delivery/ck.php?n=a88fd39'><img border='0' alt='' src='http://50.16.95.24/openx/www/delivery/avw.php?zoneid=1&amp;n=a88fd39' /></a></noscript>
<!--<img src="<?php echo s3path("/images/rightbanner.jpg") ?>">
</div>-->
<div class="TotalBox">
<div  class="blockgradiant-bg">
	<div id="cat-left-curve"><img src="<?php echo s3path("/images/cat-left-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div id="cat-right-curve"><img src="<?php echo s3path("/images/cat-right-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div class="title1">Cash Back Overview</div>
</div>
<div class="outerbox">
	<div class="title2">Personal Cash Back</div>
    {total}
	<div class="innerbox">
    <table><tbody><tr><td><strong>Pending :</strong></td><td>${UserPending}</td></tr><tr><td><strong>Available :</strong></td><td>${UserAvailable}</td></tr></tbody></table>
	</div>
	<div class="title2">Referral Cash Back</div>
	<div class="innerbox">
    <table ><tbody><tr><td><strong>Pending :</strong></td><td>${referralpending}</td></tr><tr><td><strong>Available :</strong></td><td>${referralavailable}</td></tr><tr><td colspan="2"><p class="small">
<?php
$dt1= new DateTime($last_cashback);
$dt2= new DateTime();
$int = $dt1->diff($dt2);
$val = (float)$int->format('%a');


if(!$purchase_exempt && (float) $total[0]['referralpending'] != 0 && $val>90) { ?>
<strong>Note:</strong>  You must make a purchase in the next <?php
echo 90-$val;
?> days in order to make $<?php echo $total[0]['referralpending'] ?> in pending referral cash back available. </span>
<?php } else { ?>
<strong>Note:</strong>  Congratulations! Your pending referral cash back will be available as soon as the return period has passed. </span>
<?php } ?>
</td></tr></tbody></table>
	</div>
    <div class="title2">Total Cash Back</div>
	<div class="innerbox">
    <table><tbody><tr><td><strong>Pending :</strong></td><td>${pending}</td></tr><tr><td><strong>Available :</strong></td><td>${available}</td></tr><tr><td><strong>Processing :</strong></td><td>${processing}</td></tr><tr><td><strong>Paid :</strong></td><td>${paid}</td></tr></tbody></table>
	</div>
	{/total}
<?php if((float)$total[0]['available'] > 10){ ?>
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
</div>
<!-- Referral Overview -->
</div>
<!-- Right category -->

</div>
<!-- /content -->

{footer}

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
