<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{header}
<body>
<div id="container">
{banner}
<!-- Navigation bar -->
{nav_bar}
<!-- /Navigation bar -->

<?php echo googletag_ad('BS_stores_728x90') ?>

<!-- content -->
<div class="BGNoCol">

    <!-- page Title -->
    <div id="pageTitle">
        <div id="pageTitleLeft"></div>
        <h1>{store_name} Cash Back &amp; Coupons</h1>
        <div id="pageTitleRight"></div>
        <div style="float: right; margin-top: 20px;" id="referral-popup" >
            <img src="<?php echo s3path("/images/tell-a-friend.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/>
            <a target='_blank' href='/social/store/facebook/{id}'><img src="<?php echo s3path("/images/facebook-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
            <a target='_blank' href='/social/store/twitter/{id}'><img src="<?php echo s3path("/images/twitter-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
            <a onclick="$.get($(this).attr('href'),function(data){document.location=data;});return false;" href='/social/store/email/{id}'><img src="<?php echo s3path("/images/email-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
        </div>
    </div>
    <!-- /page Title -->

    <div style="width: 170px; float: right;  margin: 10px 13px 0pt 0pt; text-align: center;border:0px solid #C30;">
        <div id="topStore-bt" class="topStore-bg">
            <div id="cat-left-curve"><img src="<?php echo s3path("/images/cat-left-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
            <div id="cat-right-curve"><img src="<?php echo s3path("/images/cat-right-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
            <div style="font-size:12pt;color:#fff;font-weight:bold;valign:middle;border:0px solid #F00;height:23px;padding:5px;">Top Stores</div>
        </div>
        <div id="topStoreContent-bg">
            {top_stores}
                <a href="/stores/details/{id}"><img src="{logo_thumb}" onload="
                    var width = 100;
                    var height = 32;
                    var ratio= Math.min(width/this.width, height/this.height);
                    var nwidth = ratio*this.width;
                    var nheight = ratio*this.height;
                    this.width = nwidth;
                    this.height = nheight;"
                alt="** PLEASE DESCRIBE THIS IMAGE **" onerror="this.src="<?php echo s3path("/../images/no-image-100px.gif") ?>""/></a><br/><br/>
            {/top_stores}
        </div>

        <?php echo googletag_ad('BS_stores_160x600_1') ?>
        <?php echo googletag_ad('BS_stores_160x600_2') ?>
    </div>

    <div id="merchantView" style="width:700px;">
        <div id="storeInfo">
            <div id="description">
                <div id="logo">
                   <a class="transfer-link" href="/transfer/store/{id}" target="_blank" rel="nofollow">
                       <img  class="cdn-image" style="padding: 10px;" src="{logo_thumb}" onload="
                            var width = 100;
                            var height = 32;
                            var ratio= Math.min(width/this.width, height/this.height);
                            var nwidth = ratio*this.width;
                            var nheight = ratio*this.height;
                            this.width = nwidth;
                            this.height = nheight;"
                        alt="** PLEASE DESCRIBE THIS IMAGE **" onerror="this.src="<?php echo s3path("/../images/no-image-100px.gif") ?>""/>
                   </a>
                </div>
                <div class="ShopCashBack">
                    <div class="ShopCashBack-Bt BtnSCBOrangeBg">
                        <a class="BtnCBBlackTxt" href="/transfer/store/{id}" target="_blank" rel="nofollow">
                            <?php if ($store['cashback_text']) : ?>
                            Shop <?php echo escape($store['cashback_text']) ?> Cashback
                            <?php else : ?>
                            Go to shop
                            <?php endif ?>
                        </a>
                    </div>
                </div>
                <div style="margin-top: 15px; clear: both;">{description}</div>
                <div style="margin-top: 15px; clear: both;">{restrictions}</div>
            </div>
        </div>

        <?php if ($coupons) { ?>
            <ul class="tabs">
                <li><a class="active" href="#coupons">Store Coupons</a></li>
            </ul>
            <div id="tabBorder" style="width: 680px;"></div>
            <div class="tab-container">
                <div style="display: block;" id="coupons" class="tab-content">


                <?php
                    $index=0;
                    $ad = 0;
                    foreach ($coupons as $coupon) {
                ?>
                    <div class="couponList inactive" style="width: 680px; margin-right: 0pt; margin-left: 20px;">
                    <div class="logo">
                        <a class="transfer-link" href="/transfer/coupon/<?php echo $coupon['cid'] ?>" target="_blank" rel="nofollow">
                            <img class="cdn-image" src="<?php echo $coupon['logo_thumb'] ?>" onload="
                                var width = 100;
                                var height = 32;
                                var ratio = Math.min(width/this.width, height/this.height);
                                var nwidth = ratio*this.width;
                                var nheight = ratio*this.height;
                                this.width = nwidth;
                                this.height = nheight;"
                            alt="** PLEASE DESCRIBE THIS IMAGE **" onerror="this.src="<?php echo s3path("/../images/no-image-100px.gif") ?>""/>
                        </a>
                    </div>
                    <div class="cInfo">
                        <h3><a class="transfer-link" href="/transfer/coupon/<?php echo $coupon['cid'] ?>" target="_blank" rel="nofollow"><?php echo $coupon['name'] ?></a></h3>
                        <div class="details"> Expires <?php echo $coupon['expiration'] ?> <?php echo $coupon['code_prefix'] ?><font color=black><b><?php echo $coupon['code'] ?></b></font>
                            <br/>
                            <div class="BottomSpace" >
                            <a target='_blank' href='/social/coupon/facebook/<?php echo $coupon['cid'] ?>'><img src="<?php echo s3path("/images/facebook-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
                            <a target='_blank' href='/social/coupon/twitter/<?php echo $coupon['cid'] ?>'><img src="<?php echo s3path("/images/twitter-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
                            <a onclick="$.get($(this).attr('href'),function(data){document.location=data;});return false;" href='/social/coupon/email/<?php echo $coupon['cid'] ?>'><img src="<?php echo s3path("/images/email-refer.png") ?>" alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
                            </div>
                        </div>
                    </div>

                    <div class="CtA">
                        <table cellspacing=0 cellpadding=0>
                            <tr>
                                <td><div class="ClickToCopyCode"><div style="position:relative" class="click-contain ClickToCopyCode-Bt BtnCTCCOrangeBg-coupon"><a class="click-button BtnBlackTxt" href="/transfer/coupon/<?php echo $coupon['cid'] ?>" target="_blank" rel="nofollow"><?php echo $coupon['action_text'] ?></a></div></div></td>
                            </tr>
                            <tr>
                                <td><div class="instructions"><?php echo $coupon['code_prefix'] ?><a class="click-text couponCode transfer-link" href="" target="_blank" rel="nofollow"><?php echo $coupon['code'] ?></a></div></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
                        $index++;
                    }
                ?>

                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
    <?php } ?>

    <div style="clear: both;"></div>
    <div style="clear: both; height: 10px;"></div>
</div>

<script>
$(document).ready(function() {
    $("div.couponList").mouseover(function () {
        var element = $(this);
        element.find('.ClickToCopyCode-Bt').addClass('BtnCTCCOrangeRBg-coupon').removeClass('BtnCTCCOrangeBg-coupon');
    }).mouseout(function () {
        var element = $(this);
        element.find('.ClickToCopyCode-Bt').addClass('BtnCTCCOrangeBg-coupon').removeClass('BtnCTCCOrangeRBg-coupon');
    });

    $("div.ShopCashBack").mouseover(function () {
        var element = $(this);
         element.find('.ShopCashBack-Bt').addClass('BtnSCBOrangeRBg').removeClass('BtnSCBOrangeBg');
    }).mouseout(function () {
        var element = $(this);
        element.find('.ShopCashBack-Bt').addClass('BtnSCBOrangeBg').removeClass('BtnSCBOrangeRBg');
    });
});
</script>


<!-- /content -->
<!-- footer -->
{footer}
<!-- /footer -->


</body>
</html>
