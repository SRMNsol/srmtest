<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{header}
<body>
<div id="container">
{banner}
<!-- Navigation bar -->
{nav_bar}
<!-- /Navigation bar -->
            <div class="BGNoCol">
	<div id="pageTitle">
		<div id="pageTitleLeft"></div>
        <h1><?php echo $compare[0]['name']?></h1>
		<div id="pageTitleRight"></div>
      <div style="float: right; margin-top: 20px;" id="referral-popup" >
                    <img src='/images/tell-a-friend.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/>
<a target='_blank' href='/social/product/facebook/{id}'><img src='/images/facebook-refer.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
<a target='_blank' href='/social/product/twitter/{id}'><img src='/images/twitter-refer.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
<a onClick="$.get($(this).attr('href'),function(data){document.location=data;});return false;" href='/social/product/email/{id}'><img src='/images/email-refer.png' alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
</div>
	</div>
   		<!-- /page Title -->


	<div id="thumb">
<?php
$cheapest = $compare[0];
$image = $cheapest['image'];
$desc = $cheapest['description'];
$brand = $cheapest['brand'];
$upc = $cheapest['upc'];
$model = $cheapest['manufacturer_model'];
$low = $cheapest['lowest_price'];
$high = $cheapest['highest_price'];
$count = $cheapest['num_child_products'];
$price_range = '$' . $low . ($high > $low ? ' - $' . $high : '');
$store_word = 'Store' . ($count > 1 ? 's' : '');
$merchant = $cheapest['merchant_name'];
$merchant_id = $cheapest['merchant_id'];
$price = $cheapest['final_amount'];
$product_url = $cheapest['link'];
?>

<?
echo "<a id='large-image' href='#'><img class='cdn-image' src='$image' alt='** PLEASE DESCRIBE THIS IMAGE **' onerror=\"this.src='/images/no-image-100px.gif'\"/></a>
	</div>
	<div id='product-info'>
				<span id='price-range'><a href='#compare'>$price_range</a> ($count $store_word)</span><br/><br/>




				<div class='desc'>$desc</div>

			</div>
	<div id='pricePromo'>
	    <div class='promoInfo'>
	        <a class='price transfer-link' href='' >$$price</a><br/>
	        <a class='merchant transfer-link' href='/stores/details/$merchant_id' >From $merchant</a>
	    </div>
	    <div class='promoButton'>
        <div class='ShopNow'>
            <div class='BtnShopNowSep BtnSNOrangeRBg'>
	        <a class='BtnBlackTxt' target='_blank' href='$product_url' rel='nofollow' >SHOP NOW</a>
            </div>
            </div>
	    </div>
	</div>";
?>



<div style="clear: both;"></div>

	<div class="tabs">
		<ul>
			<li><a href="#" class="active">Compare Prices</a></li>
		</ul>
	</div>
	<div id="tabFilter">
<? if($zip){?>
                <div id="calculateZip">
                    <form id="zipForm" action="/product/compare/{id}" method="get">
                    <div style="float:left;font-weight:normal;margin-top:4px;margin-left:50px;border:0px solid #000;">Include Tax &amp; Shipping with Prices: {zip}&nbsp;&nbsp;</div>
                         <input id="zipButton" type="image" src="/images/btn-edit.gif" alt="Edit Zip Code" />
                                            </form>
                </div>
<? } else {?>
		<div id="calculateZip">
			<form id="zipForm" action="/product/compare/{id}" method="get">
				<span>Include Tax &amp; Shipping with Prices: </span>
                <input name="zip" id="zip-input" value="Zip Code" type="text" onFocus="this.value=''"/>
				<input id="zipButton" src="/images/btn-calculate.gif" alt="Calculate" type="image"/>
							</form>
		</div>
<? } ?>

	</div>





	<a name="compare"></a>
	<table class="matrix" id="matrix-products">
		<thead>
			<tr >
				<th class="TH-borderLeft header" >Store Name</th>
				<th class="header">Store Price</th>
				<th class="header">Coupons&nbsp;&nbsp;</th>
				<th class="header"><a class="tooltip">Cash Back <img style="margin: -4px; padding-left: 3px;padding-right:20px;"  alt="** PLEASE DESCRIBE THIS IMAGE **" src="/images/cashback-question.png" width="16" height="16" /><span id="cashbackTip">When
 you shop through BeeSavy at one of our trusted stores, we earn a sales
 commission on anything you purchase from that store. We pass the
majority of this commission back to you as "cash back".</span></a></th>
				<th class="header">Tax &amp; Shipping</th>
				<th class="header headerSortDown">Beesavy Price</th>
				<th class="TH-borderRight header">&nbsp;</th>
			</tr>
		</thead>
        <tbody>
<?php
$first = true;
for($i=0; $i<count($compare); $i++){
    $result = $compare[$i];
    $store_price = $result['retail_amount'];
    $cashback_amount =$result['cashback_amount'];
    $price = (float) $store_price;
    $cb = (float) $cashback_amount;
    $cashp = round(($cb / $price) * 100, 1);
    $cashback_text = $cashp."% cash back";
    $shipping = "";
    $ts = $result['t&s'];
    $final = $result['final_amount'];
    $image = $result['merchant_image'];
    $url = $result['link'];
    $store_url = "/stores/details/".$result['merchant_id'];
    $low = "";
    if ($first){
        $low = "<span class='lowest'>Lowest Price!</span>";
        $first = false;
    }
    $coupon_html = "";
    $has_coupon = $result['coupon_id'];
    if ($has_coupon){
        $coupon_discount = $result['coupon_discount'];
        $code = $result['code'];
        $name = $result['name'];
        $exp = $result['expiration'];
        $coupon_html ="<div class='coupon'>
						<a class='tooltip transfer-link' href='$store_url' ><span class='couponTip'><strong>$name</strong>Code: <strong>$code</strong><br/><em>Expires $exp</em></span><span class='title'>$$coupon_discount Off</span></a><br/>
					<span class='code'>Code: <strong>$code</strong></span>
					</div>
";
    }

echo "<tr class='productList'>
				<td class='merchant-name'>
					<div class='iconsWrap'>
					    <div class='iconInfo displayNone'><a href='$store_url' title='View Store Information'></a></div>
					</div>
					<div class='storeName'>
                    <a class='transfer-link' target='_blank' href='$url' rel='nofollow'><img class='cdn-image'
onload=\"
        var width=100;
    var height=32;
    var ratio= Math.min(width/this.width, height/this.height);
    var nwidth=ratio*this.width;
    var nheight=ratio*this.height;
    this.width=nwidth;
    this.height=nheight;\"
                    src='$image' alt='** PLEASE DESCRIBE THIS IMAGE **' onerror='this.src ='../images/no-image-100px.gif''/></a><br/>
					</div>
				</td>
				<td class='base-price'>$$store_price</td>
				<td class='coupons'>$coupon_html</td>
				<td class='cashback1'><a href='$url' target='_blank' class='tooltip transfer-link'>$$cashback_amount <span class='percentTip'>$cashback_text</span></a></td>
				<td class='tax'>$ts</td>
				<td class='final-price'>
					<span class='final'>$$final</span><br/>
					$low</td>
                    <td class='shop-now'>
   <div class='ShopNow'><div class='BtnShopNow BtnSNOrangeBg'><a class='BtnBlackTxt' target='_blank' href='$url' rel='nofollow'>SHOP NOW</a></div> </div>
        </td>
			</tr>";
}
?>
</tbody>
	</table>
</div>
</div>


<script>
$(document).ready(function() {
    $("div.ShopNow").mouseover(function () {
        var element = $(this);
 		element.find('.BtnShopNow').addClass('BtnSNOrangeRBg').removeClass('BtnSNOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnShopNow').addClass('BtnSNOrangeBg').removeClass('BtnSNOrangeRBg');
    });

	    $("div.ShopNow").mouseover(function () {
        var element = $(this);
 		element.find('.BtnShopNowSep').addClass('BtnSNOrangeRBg').removeClass('BtnSNOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnShopNowSep').addClass('BtnSNOrangeBg').removeClass('BtnSNOrangeRBg');
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

<!-- footer -->
<div style="margin-left:20px;">
{footer}
</div>
   <!-- /footer -->
  </body>
  </html>




