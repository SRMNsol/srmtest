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
		<h1>We Found {count} Stores Matching "{category_name}"</h1>
		<div id="pageTitleRight"></div>
	</div>
   		<!-- /page Title -->


   		<!-- Left category -->
                <div class="BGLeftCol">
<div id="facetNav">
<div id="category">
    <div class="facet" >
    	<div id="category-bt" class="cat-bg">
        <div id="cat-left-curve"><img src="<?php echo s3path("/images/cat-left-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div id="cat-right-curve"><img src="<?php echo s3path("/images/cat-right-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
        <div class="parent">Category</div>
</div>

    <div id="category-bg">

                  <div style="clear:both;height:10px;">	</div>


    	<div class="sub-category-txt">Category</div>
        <div id="sub-category-bg">
    	<div class="child">
         <div style="clear:both;height:5px;">	</div>
                            		<div class="holder osX">
						<div id="pane2" class="scroll-pane">

<ul class="bullets">
<?php foreach ($categories as $item) : ?>
<?php $category_url = '/product/category?' . http_build_query(['category' => $item['id']]) ?>
<li style="padding-left:5px;"><a href="<?php echo escape($category_url, 'html_attr') ?>"><?php echo escape($item['name']) ?></a></li>
<?php endforeach ?>
</ul>

                    </div>



                    </div>

                    </div>
        </div>


        </div>
        </div>
            </div>
</div>

       <!-- /Left category -->
        <div id="results">
		    <div id="featured-stores-10" class="featured-stores" style="height:auto;">
    <div class="header">
    <div class='title'>Featured Stores for <?php echo escape($category_name) ?>:</div>;
        <div class="more"><a href="/stores/search">See More Stores ›</a></div>
    </div>
{stores}
	    <div class="store">
		<div class="logo">
            <a href="/stores/details/{id}"><img class="cdn-image" src="{logo_thumb}" alt="{name}" onerror="this.src="<?php echo s3path("/images/no-image-100px.gif") ?>""/></a>
		</div>
		<div class="cashback">
			<a href="/stores/details/{id}">{cashback_text} Cash Back</a>
        </div>
	</div>
{/stores}
    </div>
</div>



<div id="Pagination" class="pagination-controls"></div>
    <div class="pagination-info">Showing results <strong>1</strong> to <strong>25</strong> of <strong>{count}</strong></div>
	  <div style="clear: both;"></div>
      <div style="clear: both;"></div>
<script type="text/javascript">
    $(function() {
        $("input.facet-value").bind("click", function(){
            var input = this;
            var baseurl = '<?php $query = $query_string['search'];
                $base_url = "/product/category?q=$query";
                if($query_string['page'])
                   $base_url.="&page=".$query_string['page'];
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


<!-- /content -->




<!-- footer -->
{footer}
   <!-- /footer -->





  </body>
  </html>
