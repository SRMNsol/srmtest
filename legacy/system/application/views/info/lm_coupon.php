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
    
    	
   		<!-- Left category -->
{side_nav}
        
       <!-- /Left category -->
       
       
       <!-- Right side -->
       <div id="results" class="help" style="border:0px solid #000;" >
			<div class="title">Learn More - Coupon Savings</div>
<div style="float:left;width:100%;"><hr color="#e96d08" style="margin-left:10px;"></div>
<p><strong>How many times has this happened?</strong> &nbsp;You find your best price for an item, and then start searching for coupons to make the deal even better. &nbsp;The coupons you find either don't apply to the item you want or they are expired. &nbsp;BeeSavy refreshes its coupon database daily so you will always have all of the valid coupons available. &nbsp;<strong>In fact, BeeSavy will find your lowest price, including coupons and cash back! 
</p>

<p></strong>Finally, BeeSavy works directly with the largest internet retailers to negotiate unique coupons that you won't find anywhere else!

<br>
			<iframe width="425" height="349" src="http://www.youtube.com/embed/A_a2ELxw0Vo" frameborder="0" allowfullscreen></iframe><br><br>

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
