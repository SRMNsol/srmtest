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
        <div id="pageTitle" >
            <div id="pageTitleLeft"></div>
            <h1>Cash Back Stores</h1>
            <div id="pageTitleRight"></div>
            <div id="titleNav" class="small">
            <a class="pad" href="/stores/search">ALL</a>
            <a href="/stores/search?q=0">#</a>
            <?php for ($ord = ord('a'); $ord <= ord('z'); $ord++) : ?>
            <?php $chr = chr($ord) ?>
            <?php $url = "/stores/search/?q=$chr" . ($category ? "&category=$category" : "") ?>
            <a class="uppercase" href="<?php echo escape($url, 'html_attr') ?>"><?php echo $chr ?></a>
            <?php endfor ?>
        </div>
    </div>
    <!-- /page Title -->


   		<!-- Left side -->
        <div class="BGLeftCol">
                <div id="facetNav">

<div id="catagory">

    <div class="facet" >
    	<div id="catagory-bt" class="cat-bg">
        <div id="cat-left-curve"><img src="/images/cat-left-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div id="cat-right-curve"><img src="/images/cat-right-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div class="parent">Jump to a Store</div>
    </div>

    <div id="catagory-bg">

    	<div class="child">
         <div style="clear:both;height:5px;">	</div>

                  <div style="margin-left:10px;margin-bottom:10px;">

                   <select name="merchant" id="merchantSelect" onchange="if(this.options[this.selectedIndex].value !=''){window.location=this.options[this.selectedIndex].value}">
                        <option selected="selected" value="">ALL</option>
                        {store_list}
                            <option value="/stores/details/{id}">{name}</option>
                        {/store_list}
                  </select>
                  </div>

	<div class="sub-catagory-txt">Store catagory</div>
        <div id="sub-catagory-bg">
    	<div class="child">


        <div class="holder osX">
            <div id="pane1" class="scroll-pane">
                <ul class="bullets">
                    <li><a href="/stores/search">ALL</a></li>
                    <?php foreach ($categories as $category) :?>
                    <li><a href="<?php echo escape("/stores/search?category=" . $category['id'], 'html_attr')?>"><?php echo escape($category['name']) ?></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>




                    </div>

                    </div>
                      <div style="clear:both;height:5px;">	</div>



        </div>


                    </div>




           </div>
           </div>


        </div>

       <!-- /Left side-->


       <!-- Right side -->


<? $index=0;
$ad = 0;
foreach ($stores as $store){
    if($index==$ad){
?>
             <div style="float:right;margin-right:6px;">
<!-- <script type='text/javascript'>
    OA_show(6);
</script><noscript><a target='_blank' href='http://50.16.95.24/openx/www/delivery/ck.php?n=a88fd39'><img border='0' alt='' src='http://50.16.95.24/openx/www/delivery/avw.php?zoneid=6&amp;n=a88fd39' /></a></noscript>
<!--<img src="/images/rightbanner.jpg">-->
                </div>
<? }
?>
             <div class="couponList inactive" >
	         <div class="logo" >
             <a href="/stores/details/<? echo $store['id'] ?>"><img class="cdn-image"
onload="
        var width=100;
    var height=32;
    var ratio= Math.min(width/this.width, height/this.height);
    var nwidth=ratio*this.width;
    var nheight=ratio*this.height;
    this.width=nwidth;
    this.height=nheight;"
 src="<? echo $store['logo_thumb'] ?>" alt="<? echo $store['name'] ?>"></a>
            </div>

            <div class="desc">
            <h3><a href="/stores/details/<? echo $store['id'] ?>" title="<? echo $store['name'] ?>"><? echo $store['name'] ?></a></h3>
             <? echo $store['description-abrv']?> <a class="moreLink" href="/stores/details/<? echo $store['id'] ?>">more ›</a>
            </div>

            <div class="coupons">
                <?php if ($store['coupons']) : ?>
                <div class="coupon dot"><a href="/stores/details/<? echo $store['id'] ?>"><? echo $store['coupons']?> Coupons</a></div>
                <?php else : ?>
                <div class="coupon"></div>
                <?php endif ?>
            </div>

            <div class="CashBack" style="border:0px solid #000;"><div class="CashBack-Bt1 BtnCBOrangeBg" <?php if (empty($store['cashback_text'])) : ?>style="visibility:hidden"<?php endif ?>><a href="/stores/details/<? echo $store['id'] ?>" rel="nofollow"><span class="CashBack-value value"><? echo $store['cashback_text']?></span></a></div></div>
         	   <div class="ShopStore" style><div class="ShopStore-Bt BtnSSOrangeBg"><a class="BtnBlackTxt" href="/stores/details/<? echo $store['id'] ?>" rel="nofollow">SHOP STORE</a></div></div>
	    </div>

<?

    $index += 1;}
 ?>
<div style="border:1px solid #000;float:right;position:relative;margin-right:4px;">
<!-- <script type='text/javascript'>
    OA_show(7);
</script><noscript><a target='_blank' href='http://50.16.95.24/openx/www/delivery/ck.php?n=a88fd39'><img border='0' alt='' src='http://50.16.95.24/openx/www/delivery/avw.php?zoneid=7&amp;n=a88fd39' /></a></noscript>
<!--<img src="/images/rightbanner.jpg">-->
                </div>
  <div class="pag">


<div id="Pagination" class="pagination-controls"></div>
    <div class="pagination-info">Showing results <strong>{start}</strong> to <strong>{end}</strong> of <strong>{count}</strong></div>
</div>
			<div style="clear: both;"></div>
					</div>
		<div style="clear: both;"></div>

<script>
$(document).ready(function() {
    $("div.couponList").mouseover(function () {
        var element = $(this);
 		element.find('.ShopStore-Bt').addClass('BtnSSOrangeRBg').removeClass('BtnSSOrangeBg');
		element.find('.CashBack-Bt1').addClass('BtnCBOrangeRBg').removeClass('BtnCBOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.ShopStore-Bt').addClass('BtnSSOrangeBg').removeClass('BtnSSOrangeRBg');
				element.find('.CashBack-Bt1').addClass('BtnCBOrangeBg').removeClass('BtnCBOrangeRBg');
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
       <!-- Right side -->



<!-- /content -->



<!-- footer -->
{footer}
   <!-- /footer -->


  </body>
  </html>
