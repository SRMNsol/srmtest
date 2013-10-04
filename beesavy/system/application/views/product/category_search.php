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

		<div id="pageTitle">
		<div id="pageTitleLeft"></div>
		<h1>We Found {count} Products Matching "{category}"</h1>
		<div id="pageTitleRight"></div>
	</div>
   		<!-- /page Title -->
    
    	
   		<!-- Left catagory -->
                <div class="BGLeftCol">
<div id="facetNav">
<div id="catagory">
	<form id="facetForm" name="facetForm" action="//categories?category=62" method="get">
    <div class="facet" >       
    	<div id="catagory-bt" class="cat-bg">
        <div id="cat-left-curve"><img src="/images/cat-left-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div id="cat-right-curve"><img src="/images/cat-right-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>	
        <div class="parent">Category</div>
</div>
       
    <div id="catagory-bg">    
    
                        <div class="sub-catagory-txt">Brand</div>
        <div id="sub-catagory-bg">
                 
    <div class="child">
            		<div class="holder osX">
						<div id="pane1" class="scroll-pane">
        <ul>
        {brands}
 <li ><input type="checkbox" {checked}  class="facet-value" name="str_brand[]" value="{name}" id="{name}"  /> <label for="{name}" title="{name}">{name}</label> <span class="count">({hits})</span></li>
 {/brands}
                                    </ul>
                                    </div></div>
                <br style="clear: both;"/>
    </div>
</div> 
          </form>
                  <div style="clear:both;height:10px;">	</div>

        
    	<div class="sub-catagory-txt">Catagory</div>
        <div id="sub-catagory-bg">
    	<div class="child"> 
         <div style="clear:both;height:5px;">	</div>                   
                            		<div class="holder osX">
						<div id="pane2" class="scroll-pane">
                    
                        <ul class="bullets">
                        {categories}
<li style="padding-left:5px;"><a class="grandparent_category_id-{id}" href="<?php echo $base_url?>&amp;category={name}">{label}</a> <span class="count">({hits})</span></li>
  {/categories}

                       </ul>
                    
                    </div>
                  

                    
                    </div>  
      
                    </div> 
        </div>	                    


        </div>    
        </div>
            </div> 
</div>
        
       <!-- /Left catagory -->
        <div id="results">
		    <div id="featured-stores-10" class="featured-stores">
    <div class="header">
<?php
$feature_tree = $category_tree;
    while($feature_tree['child']){
        $feature_tree = $feature_tree['child'];
    }
$feature_name = $feature_tree['name'];

echo "<div class='title'>Featured Stores for $feature_name:</div>";
?>
        <div class="more"><a href="/stores/search">See More Stores ›</a></div>
    </div>
{stores}
	    <div class="store">
		<div class="logo">
            <a href="/stores/details/{id}"><img class="cdn-image" src="{logo_thumb}" alt="{name}" onerror="this.src ='/images/no-image-100px.gif'"/></a>
		</div>
		<div class="cashback">
			<a href="/stores/details/{id}">{cashback_text} Cash Back</a>
        </div>
	</div>
{/stores}
    </div>	
		    		    <div id="refine">
                <div id="sort"><label>Sort By:</label>&nbsp;&nbsp;
                <select name="sort" id="sortField">
                    <option value="lowest_price asc" >Price (Lowest)</option>
                    <option value="lowest_price desc" >Price (Highest)</option>
                    <option value="num_child_products desc" ># of Sellers</option>
                </select>
                </div>


            </div>
<? $index=0;
$ad = 0;
foreach($products as $product){ 
    if($index==$ad){
?>

<? }
?>
							<div class="productResult inactive">
							<input name="group_id" value="<? echo $product['groupID'] ?>" type="hidden"/>
    <div class="thumb">
    <a href="/product/compare/<? echo $product['groupID'] ?>">
        <img class="cdn-image" src="<? echo $product['image'] ?>" alt="** PLEASE DESCRIBE THIS IMAGE **" onerror="this.src ='/images/no-image-100px.gif'"/>
        </a>
    </div>
    <div class="pInfo">
        <h3>
        <a href="/product/compare/<? echo $product['groupID'] ?>" title="<? echo $product['name'] ?>">
            <? echo $product['name'] ?>            </a>
        </h3>
        <span class="desc"><? echo $product['description-abrv']?> <a href="/product/compare/<? echo $product['groupID'] ?>" class="more">more ›</a></span>
    </div>
    <div class="CtA">
    <span class="details">from</span> <a href="/product/compare/<? echo $product['groupID'] ?>" class="price">$<? echo $product['lowprice'] ?></a><br/>
 	          <div class="BtnOrangeBg BtnComparePrice">	          
		        <a class="BtnBlackTxt" href="/product/compare/<? echo $product['groupID'] ?>" rel="nofollow">COMPARE PRICES</a>	        
 	          </div>
 	          <span class="details">available at <a href="/product/compare/<? echo $product['groupID'] ?>"><? echo $product['numchildproducts'] ?> stores</a></span>		
    </div></div>
<?  $index++; } ?>

</div>
      
		

<div id="Pagination" class="pagination-controls"></div>
    <div class="pagination-info">Showing results <strong>1</strong> to <strong>25</strong> of <strong>{count}</strong></div>
	  <div style="clear: both;"></div>
      <div style="clear: both;"></div>
<script type="text/javascript">
    $(function() {
        $("#sortField").val('{sort}');

        $("input.facet-value").bind("click", function(){
            var input = this;
            var baseurl = '<?php $query = $query_string['search'];
                $base_url = "/product/category?q=$query";
                if($query_string['page'])
                   $base_url.="&page=".$query_string['page'];
                if($query_string['sort'])
                    $base_url.="&sort=".$query_string['sort'];
                if($query_string['category'])
                    $base_url.="&category=".$query_string['category'];
                echo $base_url;?>';
            var brandstring = '&brand=';
            var checked_input = $("input.facet-value:checked");
            var first= true;
            $.each(checked_input, function(index, value){
                if(first){
                    first = false;
                    brandstring += value.value;
                }else{
                    brandstring += '__'+value.value;
                }
            });
            var url = baseurl;
            url += brandstring;
            $(this).removeAttr("checked");
            document.location = url;
        });   
        // this initialises the demo scollpanes on the page.
    $('#pane1').jScrollPane({ showArrows: true, scrollbarWidth: 15, arrowSize: 16 });
    $('#pane2').jScrollPane({ showArrows: true, scrollbarWidth: 15, arrowSize: 16 });
    $("#sortField").change(function() {
    var baseurl = '<?php $query = $query_string['search'];
    $base_url = "/product/category?q=$query";
    if($query_string['brand'])
       $base_url.="&brand=".$query_string['brand'];
    if($query_string['category'])
        $base_url.="&category=".$query_string['category'];
    echo $base_url;
?>';
var sort_type = $("#sortField").val();
baseurl = baseurl + "&sort="+sort_type;


        document.location = baseurl;
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
