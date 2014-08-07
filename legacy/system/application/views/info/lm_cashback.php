<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{header}
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
			<div class="title">Learn More - Cash Back</div>
            <div style="float:left;width:100%;"><hr color="#e96d08" style="margin-left:10px;"></div>
<p><strong>What is cash back and where does it come from? </strong> The short answer is that retailers themselves provide the money for cash back. 
</p>

<p>The longer answer is that each year, retailers spend billions of dollars on advertising. &nbsp;This advertising includes traditional advertising mediums such as TV commercials and print media advertisements, as well as online advertising. 


<p><strong>Did you know that in most cases, when you make a purchase online, that retailer is paying a commission on your purchase to the site that referred you? </strong> That's right, if you arrive at a retailer's site by clicking on an advertisement, from a search or from a link on another website, that site is most likely getting a commission on your purchase. &nbsp;<strong>Why haven't you heard about this before?</strong> &nbsp;Because most sites keep the commission for themselves. 
</p>

<p>We believe that you are entitled to this money. &nbsp;As a result, we return most of this commission as cash back to the users. &nbsp;<STRONG>IT'S LIKE GETTING PAID TO SHOP! 


<br><iframe width="425" height="349" src="http://www.youtube.com/embed/QVAL5BpvQBA?hl=en&fs=1" frameborder="0" allowfullscreen></iframe><br><br>

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
