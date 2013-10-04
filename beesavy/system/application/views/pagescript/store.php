<?php
if (!isset($baseurl))
    $baseurl = "?";
if (!isset($query_string)){
    $query_string = array();
    $query_string['search'] = "";
    $query_string['brand'] = "";
    $query_string['category'] = "";
    $query_string['sort'] = "";
}
?>
<script>
    $(function() {

    // this initialises the demo scollpanes on the page.
    $('#pane1').jScrollPane({ showArrows: true, scrollbarWidth: 15, arrowSize: 16 });
    $('#pane2').jScrollPane({ showArrows: true, scrollbarWidth: 15, arrowSize: 16 });
    $("div.couponList").mouseover(function () {
        var element = $(this);
 		element.find('.ShopStore-Bt').addClass('BtnSSOrangeRBg').removeClass('BtnSSOrangeBg');
		element.find('.CashBack-Bt').addClass('BtnCBOrangeRBg').removeClass('BtnCBOrangeBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.ShopStore-Bt').addClass('BtnSSOrangeBg').removeClass('BtnSSOrangeRBg');
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

    var text = "Enter a product or store";
    var search = $("#nav-search-input");

    search.focus(focusaction(search, text));
    search.blur(bluraction(search, text));
    search.trigger('blur');
//<![CDATA[
            var isInit = true;
            function pageselectCallback(page_index, jq){
                if (isInit){
                    isInit = false;
                    return false;
                }
                // Get number of elements per pagination page from form
                var items_per_page = $('#items_per_page').val();
                var length = <?php echo $count;?>;
                var max_elem = Math.min((page_index+1) * items_per_page, length);
                var newcontent = '';
                var page = jq.find(".current")[0].textContent;
                if (page=="Prev") {
                    page = "1";
                }
                var pat = new RegExp("page=[0-9]*");
                if(pat.test(document.URL)){
                    window.location = (document.URL).replace(pat,"page="+page);
                }
                else {
                    window.location = (document.URL)+"&page="+page;  
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
                var page = "<?php echo $page-1;?>";
                opt["current_page"]=<?php echo $page-1;?>;
                opt["num_edge_entries"]=1;
                opt["num_display_entries"]=5;
                opt["items_per_page"] = 25;
                opt["link_to"]=document.URL;
                return opt;
            }
            
            // When document has loaded, initialize pagination and form 
            $(document).ready(function(){
                // Create pagination element with options from form
                var optInit = getOptions();
                $("#Pagination").pagination(<?php echo $count;?>, optInit);
            });
    });
</script> 
