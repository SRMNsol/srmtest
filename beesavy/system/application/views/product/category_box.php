         <div style="clear:both;height:5px;">	</div>                   
                            		<div class="holder osX">
						<div id="pane2" class="scroll-pane">
                    
                        <ul class="bullets">
<?php
$query = $query_string['search'];
$url = $base_url;
while($category_tree){
    $category_node = $category_tree;
    echo $category_tree['name'];
    $category_tree=$category_tree['child'];
    
}
if($query_string['brand'])
   $url.="&amp;brand=".$query_string['brand'];

foreach($categories as $category){
    $id = $category['name'];
    $name = $category['label'];
    $hits = $category['hits'];
    $search_url = $url."&amp;category=$id";
  echo "<li style='padding-left:5px;'><a class='grandparent_category_id-$id' href='$search_url'>$name</a> <span class='count'>($hits)</span></li>";
}
?>

                       </ul>
                    
                    </div></div>
                  

                    
                    </div>  
      
                    </div>          
                    
                    


        </div>    
