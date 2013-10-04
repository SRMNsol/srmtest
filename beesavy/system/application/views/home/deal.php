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
		<!-- page Title -->
 		
		<DIV id="content" class="BGNoCol">
<DIV id="pageTitle">
<DIV id=pageTitleLeft></DIV>
<div style="float:left;margin-top:12px;margin-left:10px;"><img src="/images/clock.gif"></div>
<H1>Daily Deals</H1>
<DIV id=pageTitleRight></DIV></DIV>
<DIV style="PADDING-LEFT: 18px" id=dailydeals>
{deals}
<DIV class="deal"><INPUT class=timestamp value=1298700000 type=hidden name=timestamp> 
<DIV class="name"><A class=transfer-link href="{link}" rel=nofollow target=_blank>{merchant_name}</A></DIV>
<DIV class="expires">Expires: {expires}</DIV>
<DIV class="description">
    <p>{name}</p>
    <p>Plus {cashback_text} cash back! {exp_date_short}</p>
    <p class="restrictions">{restrictions}</p>
</DIV>
<DIV class="countdown current"><NOSCRIPT>{expiration} </NOSCRIPT></DIV>
<div class="transfer_image"><A href="{link}" rel=nofollow target=_blank><IMG src="{merchant_thumb}" /></A></div>
<div class="ShopNow"><div class="BtnShopNowDeals BtnSNOrangeBg"><a class="BtnBlackTxt" href="{link}" target="_blank" rel="nofollow">SHOP NOW</a></div>
</DIV>
<DIV class="details">
	<DIV class=savings-container>
		<DIV class=percent>{cashback_text}</DIV>
		<DIV class=savings>Back</DIV>
    </DIV>
</DIV>
</DIV>
{/deals}


<DIV style="CLEAR: both"></DIV></DIV>
<SCRIPT type=text/javascript>
$(document).ready(function () {
	    $("div.productResult").mouseover(function () {
        var element = $(this);
 		element.find('.BtnComparePrice').addClass('BtnOrangeRBg').removeClass('BtnOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnComparePrice').addClass('BtnOrangeBg').removeClass('BtnOrangeRBg');
    });

	    $("div.ShopNow").mouseover(function () {
        var element = $(this);
 		element.find('.BtnShopNowDeals').addClass('BtnSNOrangeRBg').removeClass('BtnSNOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnShopNowDeals').addClass('BtnSNOrangeBg').removeClass('BtnSNOrangeRBg');
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
	
	
    $(".countdown").each(function () {
        var timestamp = $(this).parent().find('.timestamp').val();
        var date = new Date(timestamp * 1000);

        if ($(this).hasClass('current')) {
            $(this).countdown({until: date, layout: 'Expires in {dn}d, {hn}h, {mn}m, {sn}s'});
        } else if ($(this).hasClass('future')) {
        	$(this).countdown({until: date, layout: 'Starts in {dn}d, {hn}h, {mn}m, {sn}s'});
        }
    });
});
</SCRIPT>

<DIV style="HEIGHT: 10px; CLEAR: both"></DIV></DIV>
		

       <!-- Right side -->




<!-- /content -->

         
      
<!-- footer -->  
    {footer}
<!-- /footer --> 
  




  </body>
  </html>
