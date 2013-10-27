<?php
$product_url = "/product/compare/".$product['groupID'];
?>

<div class="productResult inactive">
    <div class="thumb">
    <a href="<?echo $product_url;?> ">
        <img class="cdn-image" src="<?php echo $product['image'];?>" alt="** PLEASE DESCRIBE THIS IMAGE **"/>
        </a>
    </div>
    <div class="pInfo">
        <h3>
            <a href="<?echo $product_url;?>" title="<?php echo $product['name'];?>">
            <?php echo $product['name'];?></a>
        </h3>
        <span class="desc"><?php echo $product['description'];?><a href="<?echo $product_url;?> " class="more">more ›</a></span>
    </div>
    <div class="CtA">
        <span class="details">from</span> <a href="<?echo $product_url;?> " class="price">$<?php echo $product['lowprice'];?></a><br/>
        <div class="BtnComparePrice BtnOrangeBg"><a class="BtnBlackTxt" href="<?echo $product_url;?>">COMPARE PRICES</a></div>
        <span class="details">available at <a href="<?echo $product_url;?> "><?php echo $product['numchildproducts'];?> stores</a></span>
    </div>
</div>
