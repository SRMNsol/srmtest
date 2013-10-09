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



<!-- Content -->
    <!-- Daily Deals -->
    <div>
    <div id="daily-deals-SIcontainer">
    <div style="width:100%;height:41px;border:0px solid #00C;">
     	<div style="float:left;margin-top:5px;margin-left:10px;"><img src="/images/clock.gif"></div>
      <div id="hot-products" class="biggerTitle">Daily Deals</div>
      <div class="seeAll"><a href="/main/deal">See All Deals »</a></div>
      </div>

    <?php if (empty($deals)) : ?>
    <p style='font-size:1.5em;text-align:center;padding-top:20px;'>Currently gathering daily deals</p>
    <?php else : ?>
        <?php $i = 0 ?>
        <?php foreach ($deals as $deal) : ?>
        <div class="HomeDailyDeals">
            <div class="ProductName"><a class="title" href="<?php echo escape($deal['link'], 'html_attr') ?>" onclick="window.open(this.href); return false;" rel="nofollow"> <strong><?php echo escape($deal['merchant_name']) ?></strong> </a></div>
            <div class="DealsCt">
                <div class="DealsLogo"><img
                    src="<?php echo escape($deal['merchant_logo']) ?>"
                    onload="
                        var width=100;
                        var height=34;
                        var ratio= Math.min(width/this.width, height/this.height);
                        var nwidth=ratio*this.width;
                        var nheight=ratio*this.height;
                        this.width=nwidth;
                        this.height=nheight;
                    "
                    onerror="this.src='/images/no-image-100px.gif'"
                    alt="** PLEASE DESCRIBE THIS IMAGE **"
                />
            </div>

            <div class="DealsText">
                <p><a class="title" href="<?php echo escape($deal['link'], 'html_attr') ?>"><?php echo escape($deal['name-abrv']) ?></a></p>
            </div>
        </div>
        <div class="savings-container">
            <div class=percent><?php echo escape($deal['cashback_text']) ?></div>
                <div class=savings>Back</div>
            </div>
            <div style="clear:both;line-height:1px;">&nbsp;</div>
            <div class="expdate"><?php echo escape($deal['exp_date_short']) ?></div>
            <?php if ($deal['code']) : ?>
            <div class="btnCouponCode"><a class="BtnBlackTxt" href="<?php echo escape($deal['link'], 'html_attr') ?>">Coupon: <?php echo escape($deal['code']) ?></a></div>
            <?php endif ?>
            <div style="clear:both;line-height:1px;">&nbsp;</div>
        </div>
        <?php if ($i < count($deals) - 1) : ?>
        <div style="background:#c7c7c7;height:2px;width:200px;margin-left:55px;margin-top:5px;margin-bottom:5px;"></div>
        <?php endif ?>
        <?php $i++ ?>
        <?php endforeach ?>
    <?php endif ?>

    </div>
    <!-- /Daily Deals -->

    <!-- Top Stores -->
    <div id="CenterBox">

        <div id="WelcomeUserBg">
<div  class="orangegradiant-bg">
	<div id="cat-left-curve"><img src="/images/cat-orange-left-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div id="cat-right-curve"><img src="/images/cat-orange-right-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
    <div class="title1"><font color=#000>Welcome back!</font></div>
</div>
<div class="inner-outerbox">

	<div class="innerbox">
    <table><tbody><tr><td><strong>Member since:</strong></td><td>{created}</td></tr><tr><td><strong>Last Login:</strong></td><td>{last_login} </td></tr><tr><td><strong>Last Purchase:</strong></td><td><? if(strtotime($last_cashback)){
        echo strftime('%B %e, %Y', strtotime($last_cashback));
    }else{
        echo "-";
    }?></td></tr></tbody></table>
	</div>
<div style="clear:both;height:10px;"></div>

</div>
</div>



    <div id="Groupon">
<script type="text/javascript">
var _gwparam = _gwparam ||[];
_gwparam["APIKEY"]="3c16c40cab007286dee9523a72bee69b0e7f25ea";
_gwparam["size"]="250.250.lofimulti";
_gwparam["location"]="";
_gwparam["bgcolor"]="e96d08";
_gwparam["title"]="undefined";
_gwparam["PID"]="1915435";
_gwparam["AID"]="10817648";
_gwparam["SID"]="{user_id}";
</script>
<script id="grouponAd" type="text/javascript" src="http://www.groupon.com/javascripts/common/affiliate_widget/grouponwidget.js"></script></div>
    </div>
    <!-- /Top stores -->

    <!-- Referral Overview -->
    <div id="accounts-summary-container">
<div class="TotalBox">
<div  class="blockgradiant-bg">
	<div id="cat-left-curve"><img src="/images/cat-left-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div id="cat-right-curve"><img src="/images/cat-right-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div class="title1">Account Summary</div>
</div>
<div class="outerbox">
	<div class="title2">Referral Overview</div>
	<div class="innerbox">
{total}
    <table><tbody><tr><td><strong>Level 1 Referrals :</strong></td><td>{referralcountdirect}</td></tr><tr><td><strong>Level 2 to 7 Referrals :</strong></td><td>{referralcountindirect}</td></tr><tr><td><strong>Total Referral Network:</strong></td><td><?php echo $total[0]['referralcountdirect'] + $total[0]['referralcountindirect']?></td></tr></tbody></table>
	</div>
	<div class="title2">Cash Back Overview</div>
	<div class="innerbox">
    <table><tbody><tr><td><strong>Pending :</strong></td><td>${pending}</td></tr><tr><td><strong>Available :</strong></td><td>${available}</td></tr><tr><td><strong>Processing :</strong></td><td>${processing}</td></tr><tr><td><strong>Paid :</strong></td><td>${paid}</td></tr></tbody></table>
	{/total}
	</div>

<?php if((float)$total[0]['available'] > 10) { ?>
        <div class="Request"><div class="BtnRequestBg BtnRequest"><a class="BtnRequestTxt" href="/account/index/0/2" rel="nofollow">REQUEST A PAYMENT</a></div></div>
        <div class="RequestNote">You can now request a payment!</div>
<?php } else {
    $dif = number_format(10 - (float)$total[0]['available'],2);
?>

        <div class="Request"><img style="padding-left:50px;padding-top:10px;" src="/images/btn-request-payment-gray.gif"/></div>
        <div class="RequestNote">You need an additional $<? echo $dif ?> to request a payment.</div>
<?php } ?>
	<div style="clear:both;height:20px;"></div>
</div>
</div>
</div>



        <!-- Top Stores -->
         <div style="width:930px;margin-left:0px;border:0px solid #00F;float:left;">
    <div id="welcome-top-stores-container">
       <div style="width:100%;height:35px;">
       <div id="top-stores" class="h1">Top Stores</div>
	   <div class="seeAll"><a href="/stores/search">See All Stores »</a></div>
       </div>
       {stores}
 	      <div class="store">
                  <div class="logo"><a href="/stores/details/{id}"><img class="cdn-image"
onload="
        var width=100;
    var height=34;
    var ratio= Math.min(width/this.width, height/this.height);
    var nwidth=ratio*this.width;
    var nheight=ratio*this.height;
    this.width=nwidth;
    this.height=nheight;"  onerror="this.src='/images/no-image-100px.gif'"
src="{logo_thumb}" alt="{name}"/></a></div>
		          <div class="cashback"><a href="/stores/details/{id}">{cashback_text} Cash Back</a></div>
	          </div>
	   {/stores}
    </div>

    <!-- /Top stores -->

 <!-- Hot Coupons -->
    <div id="hot-coupons-container">
    	<div style="width:100%;height:35px;">
     		<div id="hot-coupons" class="h1"> Hot Coupons</div>
      		<div class="seeAll"><a href="/coupon/search">See All Coupons »</a></div>
      	</div>
      	{coupons}
	    <div class="Homecoupon">
            <div class="descimg"><a href='{linkstore}' ><img src="{logo_thumb}"
onload="
        var width=100;
    var height=34;
    var ratio= Math.min(width/this.width, height/this.height);
    var nwidth=ratio*this.width;
    var nheight=ratio*this.height;
    this.width=nwidth;
    this.height=nheight;"  onerror="this.src='/images/no-image-100px.gif'"
alt="** PLEASE DESCRIBE THIS IMAGE **"/></a></div>
	        <div class="desc"> <a class="title" href="{linkstore}"  rel="nofollow"> {name-abrv} </a> <br/>{code_prefix}<a class="code" href=""  rel="nofollow">{code}</a>
			</div>
	        <div style="clear: both;"></div>
      </div>
      {/coupons}
   </div>
</div>
</div>


   <!-- /Referral Overview -->
<!-- /Content -->
    <script>
$(document).ready(function() {
	    $("div.ShopByStore").mouseover(function () {
        var element = $(this);
		element.find('.nav-ShopByStore-Bt').addClass('BtnSBSOrangeRBg').removeClass('BtnSBSOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.nav-ShopByStore-Bt').addClass('BtnSBSOrangeBg').removeClass('BtnSBSOrangeRBg');
    });

	    $("div.Request").mouseover(function () {
        var element = $(this);
 		element.find('.BtnRequestBg').addClass('BtnRequestRBg').removeClass('BtnRequestBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnRequestRBg').addClass('BtnRequestBg').removeClass('BtnRequestRBg');
    });

	    $("div.FindCoupons").mouseover(function () {
        var element = $(this);
		element.find('.nav-FindCoupons-Bt').addClass('BtnFCOrangeRBg').removeClass('BtnFCOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.nav-FindCoupons-Bt').addClass('BtnFCOrangeBg').removeClass('BtnFCOrangeRBg');
    });

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

	});
</script>
<!-- footer -->
<div id="ftr" >
<p id="links" style="height: 20px; line-height: 20px;">Copyright &copy; 2011 - <?php echo date('Y'); ?> BeeSavy, LLC. &nbsp;All Rights Reserved. &nbsp;<a href="/stores/storelist">All Stores</a> | <a href="/info/terms">Terms of Service</a> | <a href="/info/privacy">Privacy Policy</a> | <a href="/info/contact">Contact Us</a></p>
		<a href="http://twitter.com/beesavy" target="_blank" class="socialMedia twitter">Follow Us On Twitter</a>
		<a href="http://www.facebook.com/pages/BeeSavy/139324182791301" target="_blank" class="socialMedia facebook">Like Us on Facebook</a>
		<div style="clear: both;"></div>
		<p id="disclaimer">Tax and shipping costs are estimates; &nbsp;please see the store's website for exact pricing. &nbsp;BeeSavy does not guarantee the accuracy of information provided by online stores and other third parties, including product information, prices, coupons, and availability. &nbsp;BeeSavy shall not be liable for or responsible to honor any inaccurate information shown on our website. &nbsp;Please see our <a href="/info/terms">Terms of Service</a> for more details.</p>
	</div>
   <!-- /footer -->
  </div>
  </body>
  </html>
