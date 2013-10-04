            <div class="holder osX">
                <div id="pane1" class="scroll-pane">
            <ul>
<?php
foreach($brands as $brand){
    $id = $brand['label'];
    $name = $brand['name'];
    $hits = $brand['hits'];
    $url = "";
    $checked = "";
    if(in_array($name, $brandarr))
        $checked = "checked='yes'";

    echo "<li ><input type='checkbox' $checked class='facet-value' name='str_brand[]' value='$name' id='$name'  /> <label for='$name' title='$name'>$name</label> <span class='count'>($hits)</span></li>";
}
echo '</ul></div></div><br style="clear: both;"/></div></div><div style="clear:both;height:10px;"></div>';
?>

