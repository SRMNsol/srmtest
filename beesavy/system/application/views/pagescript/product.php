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

        $("input.facet-value").bind("click", function(){
            var input = this;
            var baseurl = '<?php $query = $query_string['search'];
                $base_url = "/search?q=$query";
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
                    brandstring += value.attributes.value.textContent;
                }else{
                    brandstring += '__'+value.attributes.value.textContent;
                }
            });
            var url = baseurl;
            url += brandstring;
            document.location = url;
        });   
        // this initialises the demo scollpanes on the page.
    $('#pane1').jScrollPane({ showArrows: true, scrollbarWidth: 15, arrowSize: 16 });
    $('#pane2').jScrollPane({ showArrows: true, scrollbarWidth: 15, arrowSize: 16 });
    $("#sortField").change(function() {
    var baseurl = '<?php $query = $query_string['search'];
    $base_url = "/search?q=$query";
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

        var current_val ='<?php echo $query_string['sort']?>';
        if(current_val!=""){
        $("#sortField").val(current_val);}
    var text = "Enter a product or store";
    var search = $("#nav-search-input");

    search.focus(focusaction(search, text));
    search.blur(bluraction(search, text));
    search.trigger('blur');
    }); 
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
</script> 
