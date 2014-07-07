<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{header}
<body>
<div id="container">
{banner}
{nav_bar}
<!-- content -->
		<!-- page Title -->

		<div id="pageTitle">
		<div id="pageTitleLeft"></div>
		<h1>Find Free Coupons</h1>
		<div id="pageTitleRight"></div>
            <div id="titleNav" class="large">
        <a href="/coupon/search?" <?php if(!$sort) echo "id='active'";?>>All</a>
        <a href="/coupon/search?sort=free_shipping" <?php if($sort=="free_shipping asc") echo "id='active'";?>>Free Shipping</a>
        <a href="/coupon/search?sort=expire_soon" <?php if($sort=="end_date asc") echo "id='active'";?>>Expiring Soon</a>
        <a href="/coupon/search?sort=hot_coupons" >Hot Coupons!</a>
    </div>
	</div>

   		<!-- /page Title -->


   		<!-- Left side -->
        <div class="BGLeftCol">
                <div id="facetNav">

<div id="catagory">

    <div class="facet" >
    	<div id="catagory-bt" class="cat-bg">
        <div id="cat-left-curve"><img src="<?php echo s3path("/images/cat-left-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div id="cat-right-curve"><img src="<?php echo s3path("/images/cat-right-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div class="parent">Jump to a Store</div>
   		 </div>

    <div id="catagory-bg">

    	<div class="child scroll">
         <div style="clear:both;height:5px;">	</div>

                  <div style="margin-left:10px;margin-bottom:10px;">

                   <select name="merchant" id="merchantSelect" onchange="if(this.options[this.selectedIndex].value !=''){window.location=this.options[this.selectedIndex].value}">
                        <option selected="selected" value="">ALL</option>
{store_list}
<option value='/stores/details/{id}'>{name}</option>
{/store_list}
                                       </select>
                  </div>
        </div>


                    </div>




           </div>
           </div>


        </div>

       <!-- /Left side-->


       <!-- Right side -->
<?php $index=0;
$ad = 0;
foreach($coupons as $coupon){
    if($index==$ad){
?>
             <div style="float:right;margin-right:6px;"><!--
<script type='text/javascript'>
    OA_show(8);
</script><noscript><a target='_blank' href='http://50.16.95.24/openx/www/delivery/ck.php?n=a88fd39'><img border='0' alt='' src='http://50.16.95.24/openx/www/delivery/avw.php?zoneid=8&amp;n=a88fd39' /></a></noscript>
<!--<img src="<?php echo s3path("/images/rightbanner.jpg") ?>">-->
                </div>
<?php }
?>
<div class='couponList inactive'>
	        <div class='logo'>
	            <a class='transfer-link' href='/transfer/coupon/<?php echo $coupon['id'] ?>' target='_blank' rel='nofollow'>
                    <img class='cdn-image' src='<?php echo $coupon['logo_thumb'] ?>'
onload="
        var width=100;
    var height=32;
    var ratio= Math.min(width/this.width, height/this.height);
    var nwidth=ratio*this.width;
    var nheight=ratio*this.height;
    this.width=nwidth;
    this.height=nheight;"
alt='$store' onerror="this.src="<?php echo s3path("/../images/no-image-100px.gif") ?>""/>
	            </a>
	        </div>
	        <div class='cInfo'>
	            <h3><a class='transfer-link' href='<?php echo $coupon['link'] ?>' target='_blank' rel='nofollow'><?php echo $coupon['name'] ?></a></h3>
	            <div class='details'>
	                <span>Expires <?php echo $coupon['expiration'] ?> </span>
                    <br/><div style='padding-top: 3px;'>
                    <img src="<?php echo s3path("/images/tell-a-friend.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **' onerror="this.src="<?php echo s3path("/images/no-image-100px.gif") ?>""/>
<a target='_blank' href='/social/coupon/facebook/<?php echo $coupon['id'] ?>'><img src="<?php echo s3path("/images/facebook-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
<a target='_blank' href='/social/coupon/twitter/<?php echo $coupon['id'] ?>'><img src="<?php echo s3path("/images/twitter-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
<a onclick="$.get($(this).attr('href'),function(data){document.location=data;});return false;" href='/social/coupon/email/<?php echo $coupon['id'] ?>'><img src="<?php echo s3path("/images/email-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
                    </div>
                     	            </div>
	        </div>

            <div class="CashBack"><div class='CashBack-Bt BtnCBOrangeBg' <?php if (empty($coupon['cashback_text'])) : ?>style="visibility: hidden"<?php endif ?>>


	            <a  href='/transfer/coupon/<?php echo $coupon['id'] ?>' target='_blank' rel='nofollow'>
	                <span class="CashBack-value value"><?php echo $coupon['cashback_text'] ?></span>
	            </a>
	        </div></div>


	        <div class='CtA'>
                          <div >
	           <table cellspacing=0 cellpadding=0>
               <tr><td>

	           <div class="ClickToCopyCode"><div style="position:relative;overflow:auto;0" class="click-contain ClickToCopyCode-Bt BtnCTCCOrangeBg-coupon">
	          <a class="BtnBlackTxt click-button" class='transfer-link' href='/transfer/coupon/<?php echo $coupon['id'] ?>' target='_blank' rel='nofollow'>
	          <?php echo $coupon['action_text'] ?>
	          </a>
 	          </div></div>
	                	</td></tr>                <tr><td>
	                			        <div class='instructions'><?php echo $coupon['code_prefix'] ?>
    <a class='click-text couponCode transfer-link' href='/transfer/coupon/<?php echo $coupon['id'] ?>' target='_blank' rel='nofollow'><?php echo $coupon['code'] ?></a>
			        </div></td></tr></table>

	            </div>
	        </div>
	    </div>
<?php

    $index += 1;}
 ?>
<div style="border:1px solid #000;float:right;position:relative;margin-right:4px;"><!--
<script type='text/javascript'>
    OA_show(9);
</script><noscript><a target='_blank' href='http://50.16.95.24/openx/www/delivery/ck.php?n=a88fd39'><img border='0' alt='' src='http://50.16.95.24/openx/www/delivery/avw.php?zoneid=9&amp;n=a88fd39' /></a></noscript>
<!--<img src="<?php echo s3path("/images/rightbanner.jpg") ?>">-->
                </div>




  <div class="pag">


<div id="Pagination" class="pagination-controls"></div>
    <div class="pagination-info">Showing results <strong>{start}</strong> to <strong>{end}</strong> of <strong>{count}</strong></div>
</div>
			<div style="clear: both;"></div>
					</div>
		<div style="clear: both;"></div>

<script type="text/javascript">
$(document).ready(function() {
    var isInit = true;
    function pageselectCallback(page_index, jq){
        if (isInit){
            isInit = false;
            return false;
        }
        // Get number of elements per pagination page from form
        var items_per_page = $('#items_per_page').val();
        var length = {count};
        var max_elem = Math.min((page_index+1) * items_per_page, length);
        var newcontent = '';
        var page = jq.find(".current")[0].textContent;
        if(page==undefined){
            page = jq.find(".current")[0].innerText;
        }
        if (page=="Prev") {
            page = "1";
        }
        var pat = new RegExp("page=[0-9]*");
        if(pat.test(document.URL)){
            window.location = (document.URL).replace(pat,"page="+page);
        }
        else {
            var pat = new RegExp("[?]");
            if(pat.test(document.URL)){
            window.location = (document.URL)+"&page="+page;
            }else{
            window.location = (document.URL)+"?page="+page;
            }
        }
        // Iterate through a selection of the content and build an HTML string
        for(var i=page_index*items_per_page;i<max_elem;i++)
        {
        }

        // Replace old content with new content

        // Prevent click eventpropagation
        return false;
    }

    function getOptions(){
        var opt = {callback: pageselectCallback};
        var page = {page_index};
        opt["current_page"]={page_index};
        opt["num_edge_entries"]=1;
        opt["num_display_entries"]=5;
        opt["prev_show_always"]=false;
        opt["next_show_always"]=false;
        opt["prev_text"]="Prev <<";
        opt["next_text"]="Next >>";
        opt["ellipse_text"] = "<span class='spacer'>...</span>";
        opt["items_per_page"] = {limit};
        opt["link_to"]=document.URL;
        return opt;
    }

    // When document has loaded, initialize pagination and form
        // Create pagination element with options from form
        var optInit = getOptions();
        $("#Pagination").pagination({count}, optInit);
});
</script>
<script>

$(document).ready(function() {
    $("div.couponList").mouseover(function () {
        var element = $(this);
 		element.find('.ClickToCopyCode-Bt').addClass('BtnCTCCOrangeRBg-coupon').removeClass('BtnCTCCOrangeBg-coupon');
		 		element.find('.CashBack-Bt').addClass('BtnCBOrangeRBg').removeClass('BtnCBOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.ClickToCopyCode-Bt').addClass('BtnCTCCOrangeBg-coupon').removeClass('BtnCTCCOrangeRBg-coupon');
				element.find('.CashBack-Bt').addClass('BtnCBOrangeBg').removeClass('BtnCBOrangeRBg');
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


       <!-- Right side -->



<!-- /content -->

<!-- footer -->
{footer}
   <!-- /footer -->


  </body>
  </html>
