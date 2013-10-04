<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{header}
<body>
<div id="container">
{banner}
<!-- Navigation bar -->
{nav_bar}
<!-- /Navigation bar -->


<!-- content -->
		<!-- page Title -->
            <div class="BGNoCol">
      <div id="pageTitle">
      <div id="pageTitleLeft"></div>
      <h1>{store_name} Cash Back &amp; Coupons</h1>
      <div id="pageTitleRight"></div>
      <div style="float: right; margin-top: 20px;" id="referral-popup" >
                    <img src='/images/tell-a-friend.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/>
<a target='_blank' href='/social/store/facebook/{id}'><img src='/images/facebook-refer.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
<a target='_blank' href='/social/store/twitter/{id}'><img src='/images/twitter-refer.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
<a onclick="$.get($(this).attr('href'),function(data){document.location=data;});return false;" href='/social/store/email/{id}'><img src='/images/email-refer.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
</div>
  </div>
      <!-- /page Title -->
         
         
         

         
         
         
       <div style="width: 170px; float: right;  margin: 10px 13px 0pt 0pt; text-align: center;border:0px solid #C30;">
             	<div id="topStore-bt" class="topStore-bg">
        <div id="cat-left-curve"><img src="/images/cat-left-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div id="cat-right-curve"><img src="/images/cat-right-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>	
        <div style="font-size:12pt;color:#fff;font-weight:bold;valign:middle;border:0px solid #F00;height:23px;padding:5px;">Top Stores</div>
        </div>
        <div id="topStoreContent-bg"> 
        {top_stores}
        <a href="/stores/details/{id}"><img src="{logo_thumb}" 
onload="
        var width=100;
    var height=32; 
    var ratio= Math.min(width/this.width, height/this.height);
    var nwidth=ratio*this.width; 
    var nheight=ratio*this.height; 
    this.width=nwidth; 
    this.height=nheight;" 
alt="** PLEASE DESCRIBE THIS IMAGE **" onerror="this.src ='../images/no-image-100px.gif'"/></a><br/><br/>
        {/top_stores}
    </div>
</div>

<div id="merchantView" style="width:700px;">
    <div id="storeInfo">
        <div id="description">
            <div id="logo">
               <a class="transfer-link" href="/transfer/store/{id}" target="_blank" rel="nofollow">
                   <img  class="cdn-image" style="padding: 10px;" src="{logo_thumb}" 
onload="
        var width=100;
    var height=32; 
    var ratio= Math.min(width/this.width, height/this.height);
    var nwidth=ratio*this.width; 
    var nheight=ratio*this.height; 
    this.width=nwidth; 
    this.height=nheight;" 
alt="** PLEASE DESCRIBE THIS IMAGE **" onerror="this.src ='../images/no-image-100px.gif'"/>
               </a>
            </div>
<div class="ShopCashBack"><div class="ShopCashBack-Bt BtnSCBOrangeBg"><a class="BtnCBBlackTxt" href="/transfer/store/{id}" target="_blank" rel="nofollow">{cashback_text}</a></div></div>
<div style="margin-top: 15px; clear: both;">{description}</div>
<div style="margin-top: 15px; clear: both;">{restrictions}</div>
        </div>
    </div>
<?php if($coupons){?>
    <ul class="tabs">
        <li><a class="active" href="#coupons">Store Coupons</a></li>
            </ul>
    <div id="tabBorder" style="width: 680px;"></div>
    <div class="tab-container">
        <div style="display: block;" id="coupons" class="tab-content">

        
        
        
<? $index=0;
$ad = 0;
foreach($coupons as $coupon){ 
    if($index==$ad){
?>
<div class="couponList inactive" style="width: 680px; margin-right: 0pt; margin-left: 20px;">
<!--
<script type='text/javascript'>
    OA_show(10);
</script><noscript><a target='_blank' href='http://50.16.95.24/openx/www/delivery/ck.php?n=a88fd39'><img border='0' alt='' src='http://50.16.95.24/openx/www/delivery/avw.php?zoneid=10&amp;n=050d042' /></a></noscript>
<!--<img src="/images/rightbanner.jpg">-->
                </div>
<? } ?>
<div class="couponList inactive" style="width: 680px; margin-right: 0pt; margin-left: 20px;">
                <div class="logo">
                    <a class="transfer-link" href="/transfer/coupon/<? echo $coupon['cid'] ?>" target="_blank" rel="nofollow">
                        <img class="cdn-image" src="<? echo $coupon['logo_thumb'] ?>" 
onload="
        var width=100;
    var height=32; 
    var ratio= Math.min(width/this.width, height/this.height);
    var nwidth=ratio*this.width; 
    var nheight=ratio*this.height; 
    this.width=nwidth; 
    this.height=nheight;" 
alt="** PLEASE DESCRIBE THIS IMAGE **" onerror="this.src ='../images/no-image-100px.gif'"/>
                    </a>
                </div>
                <div class="cInfo">
                    <h3><a class="transfer-link" href="/transfer/coupon/<? echo $coupon['cid'] ?>" target="_blank" rel="nofollow"><? echo $coupon['name'] ?></a></h3>
                    <div class="details"> Expires <? echo $coupon['expiration'] ?> <? echo $coupon['code_prefix'] ?><font color=black><b><? echo $coupon['code'] ?></b></font>
                                                
                                                
                                                <br/>
<div class="BottomSpace" >
<a target='_blank' href='/social/coupon/facebook/<? echo $coupon['cid'] ?>'><img src='/images/facebook-refer.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
<a target='_blank' href='/social/coupon/twitter/<? echo $coupon['cid'] ?>'><img src='/images/twitter-refer.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
<a onclick="$.get($(this).attr('href'),function(data){document.location=data;});return false;" href='/social/coupon/email/<? echo $coupon['cid'] ?>'><img src='/images/email-refer.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
</div>
                                            </div>
                </div>
               
                <div class="CtA">
                <table cellspacing=0 cellpadding=0>
                <tr><td>
<div class="ClickToCopyCode"><div style="position:relative" class="click-contain ClickToCopyCode-Bt BtnCTCCOrangeBg-coupon"><a class="click-button BtnBlackTxt" href="/transfer/coupon/<? echo $coupon['cid'] ?>" target="_blank" rel="nofollow"><? echo $coupon['action_text'] ?></a></div></div>
    	               </td></tr><tr><td>     	                
    	       <div class="instructions"><? echo $coupon['code_prefix'] ?><a class="click-text couponCode transfer-link" href="" target="_blank" rel="nofollow"><? echo $coupon['code'] ?></a>     </div>
               </td></tr></table>
                            			                           
                </div>
            </div>
<? $index++; } ?>
            
                        <div style="clear: both;"></div>
                   </div>
            </div>
</div>
<?php } ?>
<div style="clear: both;"></div>
<div style="clear: both; height: 10px;"></div>
	</div>
         
        
        
<script>
$(document).ready(function() {
    $("div.couponList").mouseover(function () {
        var element = $(this);
 		element.find('.ClickToCopyCode-Bt').addClass('BtnCTCCOrangeRBg-coupon').removeClass('BtnCTCCOrangeBg-coupon');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.ClickToCopyCode-Bt').addClass('BtnCTCCOrangeBg-coupon').removeClass('BtnCTCCOrangeRBg-coupon');
    });
	    $("div.ShopCashBack").mouseover(function () {
        var element = $(this);
 		element.find('.ShopCashBack-Bt').addClass('BtnSCBOrangeRBg').removeClass('BtnSCBOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.ShopCashBack-Bt').addClass('BtnSCBOrangeBg').removeClass('BtnSCBOrangeRBg');
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
   <!-- /footer -->  
  

  </body>
  </html>
