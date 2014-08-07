<div id="nav">
              <div id="nav-left-curve"><img src="<?php echo s3path("/images/nav-left-curve.gif") ?>" width="8" height="42" alt="** PLEASE DESCRIBE THIS IMAGE **" /></div>
              <div class="nav-bg" style="border:0px solid #000;width:914px;height:42px;float:left;margin-top:0px;">
              <div id="nav-ShopByCategory-bt"><img src="<?php echo s3path("/images/nav_categoryBt.jpg") ?>" width="140" height="42" alt="** PLEASE DESCRIBE THIS IMAGE **" onclick="$('#catDropdown1').slideToggle();"/></div>
              <div id="nav-SearchLabel"><img src="<?php echo s3path("/images/nav_searchLabel.jpg") ?>" width="114" height="42" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
              <form id="nav-search-form" action="/search" method="get" accept-charset="utf-8">
              <div id="nav-search">
              <input id="nav-search-input" class="input-box input-focus ac_input" size="10px" name="q" value="Enter a product or store..." type="text"/>
              <input id="nav-search-form-image" src="<?php echo s3path("/images/nav-searchBt.jpg") ?>" type="image"/>
              </div>
              </form>
              <div class="ShopByStore"><a href="/stores/search" class="nav-ShopByStore-Bt BtnSBSOrangeBg"></a></div>
              <div class="FindCoupons"><a href="/coupon/search" class="nav-FindCoupons-Bt BtnFCOrangeBg"></a></div>
              </div>
              <div id="nav-right-curve"><img src="<?php echo s3path("/images/nav-right-curve.gif") ?>" width="8" height="42" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
      </div>
      <div>
      <div id="catDropdown1" style="float:left;width:921px;height:320px;display: none;">
        <ul id="catDropdown">
            <?php foreach ($categories as $category) : ?>
            <li><a href="/product/category?category=<?php echo escape($category['id'], 'html_attr') ?>" class="col2" style="width: 210px; padding-left: 10px;"><?php echo escape($category['name']) ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
    </div>
