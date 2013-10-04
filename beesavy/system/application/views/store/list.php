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
 		
		<DIV id=content class=BGNoCol>
<DIV id=pageTitle>
<DIV id=pageTitleLeft></DIV>
<H1>All Stores</H1>
<DIV id=pageTitleRight></DIV>
<DIV id=titleNav class=small><A href="/stores/storelist/0">#</A> 
<A class=uppercase href="/stores/storelist/a">a</A> <A 
class=uppercase href="/stores/storelist/b">b</A> <A 
class=uppercase href="/stores/storelist/c">c</A> <A 
class=uppercase href="/stores/storelist/d">d</A> <A 
class=uppercase href="/stores/storelist/e">e</A> <A 
class=uppercase href="/stores/storelist/f">f</A> <A 
class=uppercase href="/stores/storelist/g">g</A> <A 
class=uppercase href="/stores/storelist/h">h</A> <A 
class=uppercase href="/stores/storelist/i">i</A> <A 
class=uppercase href="/stores/storelist/j">j</A> <A 
class=uppercase href="/stores/storelist/k">k</A> <A 
class=uppercase href="/stores/storelist/l">l</A> <A 
class=uppercase href="/stores/storelist/m">m</A> <A 
class=uppercase href="/stores/storelist/n">n</A> <A 
class=uppercase href="/stores/storelist/o">o</A> <A 
class=uppercase href="/stores/storelist/p">p</A> <A 
class=uppercase href="/stores/storelist/q">q</A> <A 
class=uppercase href="/stores/storelist/r">r</A> <A 
class=uppercase href="/stores/storelist/s">s</A> <A 
class=uppercase href="/stores/storelist/t">t</A> <A 
class=uppercase href="/stores/storelist/u">u</A> <A 
class=uppercase href="/stores/storelist/v">v</A> <A 
class=uppercase href="/stores/storelist/w">w</A> <A 
class=uppercase href="/stores/storelist/x">x</A> <A 
class=uppercase href="/stores/storelist/y">y</A> <A 
class=uppercase href="/stores/storelist/z">z</A> </DIV></DIV>
<DIV id=sitemap>
<UL class=sitemap-col>
<?php if($stores1){?>
{stores1}
  <LI><A href="/stores/details/{id}">{name}</A></LI>
{/stores1}
<? }?>
</UL>
<UL class=sitemap-col>
<?php if($stores2){?>
{stores2}
  <LI><A href="/stores/details/{id}">{name}</A></LI>
{/stores2}
<? }?>
</UL>
<UL class=sitemap-col>
<?php if($stores3){?>
{stores3}
  <LI><A href="/stores/details/{id}">{name}</A></LI>
{/stores3}
<? }?>
</UL>
</DIV>
<DIV style="HEIGHT: 10px; CLEAR: both"></DIV></DIV>
		

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
<!-- /footer --> 




  </body>
  </html>
