<div id="nav">
    <div id="nav-left-curve"></div>
    <div class="nav-bg">
        <div id="nav-ShopByCategory-bt"><a onclick="$('#catDropdown1').slideToggle();">SHOP BY CATEGORY</a></div>
        <div id="nav-SearchLabel">FIND A STORE</div>
        <form id="nav-search-form" action="/search" method="get" accept-charset="utf-8">
            <div id="nav-search">
                <input id="autocomplete" name="q" />
                <input id="nav-search-form-submit" class="nav-button" type="submit" value="SEARCH" />
            </div>
        </form>
        <div class="ShopByStore"><a href="/stores/search" class="nav-ShopByStore-Bt nav-button">SHOP BY STORE</a></div>
        <div class="FindCoupons"><a href="/stores/storelist" class="nav-FindCoupons-Bt nav-button">ALL STORES</a></div>
    </div>
    <div id="nav-right-curve"></div>
</div>

<div>
    <div id="catDropdown1" style="float:left; display:none;">
        <ul id="catDropdown">
            <?php foreach ($categories as $category) : ?>
                <li><a href="/product/category?category=<?php echo escape($category['id'], 'html_attr') ?>" class="col2" style="width: 210px; padding-left: 10px;"><?php echo escape($category['name']) ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
