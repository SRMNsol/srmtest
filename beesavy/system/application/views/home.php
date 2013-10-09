<?php $this->load->view('blocks/openpage');?>


<!-- shopping pic -->
   <div class="shopping-pic"><img src="/images/feature-product.jpg"  width="930" height="335" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
<!-- /shopping pic -->

<!-- Content -->               
                  
    <!-- Hot products -->
    <div id="hot-products-container">
      <div id="hot-products" class="biggerTitle"> Hot Products</div>
      <div class="seeAll"><a href="product/search">See All Products »</a></div>
      <div class="coupon">
        <div class="descimg"><img src="/images/1716_t.jpg" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div class="desc"> <a class="title" href="" onclick="window.open(this.href); return false;" rel="nofollow"> 15% off ALL orders! </a> <br/>
          Coupon Code: <a class="code" href="" onclick="window.open(this.href); return false;" rel="nofollow">ExtraBux15</a> </div>
        <div style="clear: both;"></div>
      </div>
      <div class="coupon">
        <div class="descimg"><img src="/images/3154_t.jpg" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div class="desc"> <a class="title" href="" onclick="window.open(this.href); return false;" rel="nofollow"> $20 off all orders over $300. </a> <br/>
          Coupon Code: <a class="code" href="" onclick="window.open(this.href); return false;" rel="nofollow">ExtraBux20</a> </div>
        <div style="clear: both;"></div>
      </div>
      <div class="coupon">
        <div class="descimg"><img src="/images/622_t.jpg" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div class="desc"> <a class="title" href="" onclick="window.open(this.href); return false;" rel="nofollow"> $10 off $75+ order. </a> <br/>
          Coupon Code: <a class="code" href="" onclick="window.open(this.href); return false;" rel="nofollow">1075</a> </div>
        <div style="clear: both;"></div>
      </div>
      <div class="coupon">
        <div class="descimg"><img src="/images/1498_t.jpg" style="float:right;" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div class="desc"> <a class="title" href="" onclick="window.open(this.href); return false;" rel="nofollow"> $20 off orders over $200 </a> <br/>
          Coupon Code: <a class="code" href="" onclick="window.open(this.href); return false;" rel="nofollow">BIGDEAL</a> </div>
        <div style="clear: both;"></div>
      </div>
    </div>
    <!-- /Hot Products -->
    
        <!-- Top Stores -->
    <div id="top-stores-container">
      <div id="top-stores" class="h1">Top stores</div>
            <div class="seeAll"><a href="stores/search">See All Stores »</a></div>
<?php
$html = "";
foreach($top_store as $store){
    $logo = $store['logo'];
    $desc = $store['description'];
    $id = $store['id'];
    $name = $store['name'];
    $percent = $store['cashback_percent'];
    $flat = $store['cashback_flat'];
    if($percent!="0"){
        $cb = "$percent%";
    }else{
        $cb = "$$flat";
    }
    $html .= '<div id="storesJcpenny-container"><div id="storesJcpenny">'
    .'<div id="storesJcpenny"><img src="'.$logo.'" width="156" height="40"></img></div>'
    .'<div class="topstoreDesc">SHOP '.$cb.' CASH BACK>> </div> </div></div>';
        $html .= '<div style="clear:both;float:left;margin-left:10px;"><hr style="width:250px;"/></div>';
}
echo $html;
?>
    </div>
    <!-- /Top stores -->
    
        <!-- Hot Coupons -->
    <div id="hot-coupons-container">
      <div id="hot-coupons" class="h1"> Hot Coupons</div>
      <div class="seeAll"><a href="coupon/search">See All Coupons »</a></div>
<?php
$html = "";
foreach($hot_coupon as $coupon){
    $logo = $coupon['merchant_logo'];
    $desc = $coupon['name'];
    $id = $coupon['id'];
    $html .= '<div class="coupon">'
        .'<div class="descimg"><img src="'.$logo.'" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>'
        .'<div class="desc"> <a class="title" href="/coupon/details/'.$id.'" onclick="window.open(this.href); return false;" rel="nofollow"> '.$desc.' </a> <br/>'
        .'</div>'
        .'<div style="clear: both;"></div></div>';
}
echo $html;
?>
    </div>
    <!-- /Hot Couppons -->
<!-- /Content -->  
    <script>
$(document).ready(function() {
    $("div.couponList").mouseover(function () {
        var element = $(this);
 		element.find('.ClickToCopyCode-Bt').addClass('BtnCTCCOrangeRBg').removeClass('BtnCTCCOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.ClickToCopyCode-Bt').addClass('BtnCTCCOrangeBg').removeClass('BtnCTCCOrangeRBg');
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
<?php $this->load->view('blocks/closepage');?>
