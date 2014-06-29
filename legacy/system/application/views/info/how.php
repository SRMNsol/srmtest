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
<div class="BGLeftCol">
		<!-- page Title -->

		<div id="pageTitle">
		<div id="pageTitleLeft"></div>
		<h1>Help</h1>
		<div id="pageTitleRight"></div>
	</div>
   		<!-- /page Title -->


   		<!-- Left catagory -->

{side_nav}

       <!-- /Left catagory -->


       <!-- Right side -->
       <div id="results" class="about" style="border:0px solid #000;" >
			<div class="title">How It Works </div>
            <div style="float:left;width:100%;"><hr color="#e96d08" style="margin-left:10px;"></div>
       		<table cellspacing=0 cellpadding=0 style="margin-left:12px;float:left;">
            <tr><td><img src="<?php echo s3path("/images/register-compare.gif") ?>"></td>
				<td><h2> Save Time!  &nbsp;Search for stores or products</h2>
			<p>Compare prices on millions of products from hundreds of stores. &nbsp;BeeSavy's comparison shopping engine goes above
            and beyond by including not only list price, tax, and shipping, but also cash back and coupon discounts—all in one simple interface. &nbsp;</p></td>
			</tr>

            <tr><td><img src="<?php echo s3path("/images/register-cashback.gif") ?>"></td>
		   <td><h2>	Save Money!  &nbsp;Shop online with cash back</h2>
			<p>When you shop online through BeeSavy, we earn a sales commission on anything you buy. &nbsp;We pass most of
             this commission on to you as a cash back discount. &nbsp; With one simple search, you can compare prices, find money-saving coupons, and get cash back!</p></td></tr>

            <tr><td><img src="<?php echo s3path("/images/register-coupons.gif") ?>"></td>
			<td><h2> Be Savvy!  &nbsp;Save more with exclusive coupons</h2>
			<p>Coupon discounts will immediately be applied to your order during checkout and your cash back discount will post to your BeeSavy account within 1-4 days. &nbsp; BeeSavy will send you a check or deposit your cash back into your PayPal account once your balance reaches $10.</p></td>
            </tr>

            <tr><td><img src="<?php echo s3path("/images/register-refer.gif") ?>"></td>
            <td><h2> Earn Money!  &nbsp;Refer your friends</h2>
			<p>BeeSavy  pays you 40% commission on all of your referrals' cash back forever. &nbsp;  We even pay you 10% commission for all of the people they refer, up to seven levels! &nbsp;There are no hoops to jump through or other gimmicks.  </p></td></tr></table>
                        </table>
	</div>
<div style="clear: both;"></div>
					</div>
		<div style="clear: both;"></div>

       <!-- Right side -->

<script>
$(document).ready(function() {
    $("div.productResult").mouseover(function () {
        var element = $(this);
 		element.find('.BtnComparePrice').addClass('BtnOrangeRBg').removeClass('BtnOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnComparePrice').addClass('BtnOrangeBg').removeClass('BtnOrangeRBg');
    });


    $("div.ShopByStore").mouseover(function () {
        var element = $(this);
		element.find('.nav-ShopByStore-Bt').addClass('BtnSBSOrangeRBg').removeClass('BtnSBSOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.nav-ShopByStore-Bt').addClass('BtnSBSOrangeBg').removeClass('BtnSBSOrangeRBg');
    });

	    $("div.FindCoupons").mouseover(function () {
        var element = $(this);
		element.find('.nav-FindCoupons-Bt').addClass('BtnFCOrangeRBg').removeClass('BtnFCOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.nav-FindCoupons-Bt').addClass('BtnFCOrangeBg').removeClass('BtnFCOrangeRBg');
    });

	});
</script>


<!-- /content -->

<!-- footer -->
    {footer}
  </div>
<!-- /footer -->



  </body>
  </html>
