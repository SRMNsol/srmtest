<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{header}
<body>
<div id="container">
<!-- Header -->
{banner}
<!-- /Header -->

<?php echo googletag_ad('BS_home_728x90_1') ?>

<!-- Navigation bar -->
{nav_bar}
<!-- /Navigation bar -->

<?php echo googletag_ad('BS_home_728x90_2') ?>

<div id="home">
    <div class="coda-slider-wrapper">
        <div class="coda-slider preload" id="coda-slider-1">
            <div class="panel">
                <div class="panel-wrapper">
                    <div class="slide-container">
                        <div class="slide slide-video">
                            <div class="col-left">
                                <!-- video -->
                                <iframe width="480" height="269" src="https://www.youtube.com/embed/G1tfGYWIKlI" frameborder="0" allowfullscreen></iframe>
                            </div>
                            <div class="col-right">
                                <div class="slide-text">
                                    <h1 class="center">Beesavy<br><small>The Home of <b>Social Shopping</b></small></h1>
                                    <ul class="h3">
                                        <li><b>Free</b>. Forever. Seriously.</li>
                                        <li>Cashback wherever you shop online</li>
                                        <li>Cashback when your <b>Friend’s</b> shop online</li>
                                        <li>Cashback when your <b>Friend’s Friend’s Friend’s Friend’s Friend’s Friend</b> shops online</li>
                                        <li>Seriously. We aren’t making this up.</li>
                                    </ul>
                                    <div class="slide-link">
                                        <div class="slide-press-play">Press <b>Play</b> To Learn More</div>
                                        <div class="slide-signup"><div class="SlideSignUp"><a href="/main/joinnow" class="BtnSlideSignUpBg BtnSlideSignUp">JOIN NOW</a></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-wrapper">
                    <div class="slide-container">
                        <div class="slide slide-cashback">
                            <div class="col-right">
                                <div class="slide-text">
                                    <h1>How Cash Back Works </h1>
                                    <h3>Stores pay BeeSavy a sales commission for sending shoppers their way, and BeeSavy uses the commission to pay you cash back. We just need an email address so we can notify you when your cash back has been credited.</h3>
                                </div>
                                <div class="slide-link">
                                    <div class="slide-LearnMore"><a href="/info/lm_cashback" class="slide-LearnMore">Learn More</a></div>
                                    <div class="or">or</div>
                                    <div class="slide-signup"><div class="SlideSignUp"><a href="/main/joinnow" class="BtnSlideSignUpBg BtnSlideSignUp">JOIN NOW</a></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-wrapper">
                    <div class="slide-container">
                        <div class="slide slide-social-shopping">
                            <div class="col-right">
                                <div class="slide-text">
                                    <h1 class="bordered">The Home of <b>Social Shopping</b><br><small>Refer Friends and Earn Commission For Life!</small></h1>
                                    <h3>We know that you and your friends love to
                                    shop online at the biggest and best stores.
                                    So just refer them to sign-up for <b>FREE</b>
                                    at Beesavy, and we give you a commission
                                    on everything they and their referrals buy
                                    online, up to <b>7 HIVE LAYERS</b> deep!</h3>
                                </div>
                                <div class="slide-link">
                                    <div class="slide-LearnMore"><a href="/info/lm_coupon" class="slide-LearnMore">Learn More</a></div>
                                    <div class="or">or</div>
                                    <div class="slide-signup"><div class="SlideSignUp"><a href="/main/joinnow" class="BtnSlideSignUpBg BtnSlideSignUp">JOIN NOW</a></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-wrapper">
                    <div class="slide-container">
                        <div class="slide slide-best-price">
                            <div class="col-right">
                                <div class="slide-text">
                                    <h1>Find Any Product At The Best Price!</h1>
                                    <h3>With one search, BeeSavy compares prices from trusted stores, finds you the best coupons, and gets you cash back!</h3>
                                </div>
                                <div class="slide-link">
                                    <div class="slide-LearnMore"><a href="/info/lm_compare" class="slide-LearnMore">Learn More</a></div>
                                    <div class="or">or</div>
                                    <div class="slide-signup"><div class="SlideSignUp"><a href="/main/joinnow" class="BtnSlideSignUpBg BtnSlideSignUp">JOIN NOW</a></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-wrapper">
                    <div class="slide-container">
                        <div class="slide slide-join">
                            <div class="col-right">
                                <div id="fullRegister">
                                    <div class="JoinFreeForm">
                                        <form id="registerForm" enctype="application/x-www-form-urlencoded" method="post" action="/account/register">
                                            <dl class="extrabux_form">
                                                <table cellspacing=0 cellpadding=0 border=0 width=350>
                                                    <tr><td><dt id="email-labelHome"><label for="email" class="required">Email Address:  *</label></dt></td><td><dd id="email-elementHome"><input name="email" onfocus="" id="email" class="required email" type="text"></dd></td></tr>
                                                    <tr><td><dt><label for="referral" class="required">Referral Code: *<br><span style="font-weight: normal;">(Who referred you?)</span></label></dt></td><td><dd id="referral-code-elementHome"><input name="referral" id="email" class="required email" type="text" value="<?php echo escape($referral) ?>"></dd></td></tr>
                                                    <tr><td></td><td height=25 valign=top><font style="font-size:9pt;"><i>Not Case Sensitive</i></font></td></tr>
                                                    <tr><td><dt id="password-labelHome"><label for="password" class="required">Password: *</label></dt></td><td><dd id="password-elementHome"><input name="password" id="password" value="" class="required password" type="password"></dd></td></tr>
                                                    <tr><td><dt id="password_confirm-labelHome"><label for="password_confirm" class="required">Confirm Password: *</label></dt></td><td><dd id="password_confirm-elementHome"><input name="password_confirm" id="password_confirm" value="" class="required password" type="password"></dd></td></tr>
                                                    <tr><td><font size=2>* Required Field </font></td><td valign=top align=right><div class="StartSaving"><div class="BtnStartSavingBg BtnStartSaving"><INPUT type="submit" value="START SAVING" class="button"/></div></div></td></tr>
                                                </table>
                                            </dl>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-wrapper">
                    <div class="slide-container">
                        <div class="slide slide-how-to">
                            <div class="col-left">
                                <div class="slide-text">
                                    <p class="h3 center">Find your favorite stores and products</p>
                                    <img src="<?php echo s3path('/images/store-logos.png') ?>" class="fit">
                                    <p class="h3 center">Multiple ways to Search:</p>
                                    <div class="box">
                                        <div style="padding: 2px;">
                                            <form method="get" action="/search" accept-charset="utf-8">
                                                <button class="button pull-right" type="submit"><small>SEARCH</small></button>
                                                <input type="text" class="search" name="q">
                                            </form>
                                        </div>
                                    </div>
                                    <p class="h3 center">
                                        <a class="button button-small" href="/stores/search">SHOP BY STORE</a>
                                        <a href="/stores/storelist" class="b link">All Stores</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-center">
                                <div class="slide-text">
                                    <p class="h3 center">See each stores <b>CASHBACK %</b></p>
                                    <div class="box">
                                        <div style="padding: 2px; height: 32px;">
                                            <a class="button pull-right" href="#"><small>SHOP 3% CASHBACK</small></a>
                                            <img src="<?php echo s3path('/images/stores_petco.png') ?>">
                                        </div>
                                    </div>
                                    <p class="h3 center">And simply click-thru on the link.</p>
                                    <p class="h3 center">Finish making your purchase, and the store automatically sends your <b>CASHBACK!</b></p>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="slide-text">
                                    <p class="h3 center">Give your friend’s your secret referral code</p>
                                    <div class="box"><div class="h3 center">Referral ID Alias: <b>beekeeper</b></div></div>
                                    <p class="h3 center">And you will get <b>CASHBACK</b> on every purchase they and their referrals make, up to <b>7 HIVE LAYERS</b> deep!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.coda-slider -->

        <div id="coda-nav-1" class="coda-nav" style="width: 930px;">
            <ul style="width: 930px;">
                <li><a href="#1">Introduction</a></li>
                <li><a href="#2">How Cashback Works</a></li>
                <li><a href="#3">Social Shopping</a></li>
                <li><a href="#4">Compare Prices</a></li>
                <li><a href="#5">Join For Free</a></li>
                <li class="last"><a href="#6">Where Do I Start?</a></li>
            </ul>
        </div>

    </div><!-- /.coda-slider-wrapper -->
</div><!-- /#home -->

<?php echo googletag_ad('BS_home_728x90_3') ?>

<!-- Content -->
<div style="width:930px;height:330px;margin-top:0px;margin-left:0px;border:0px solid #00F;float:left;">
    <!-- Daily Deals -->
    <div id="hot-products-container" class="home-daily-deals">
        <div style="padding-top:2px">
            <!-- Amazon lightning deals -->
            <script charset="utf-8" type="text/javascript">
                amzn_assoc_ad_type = "responsive_search_widget";
                amzn_assoc_tracking_id = "bee053-20";
                amzn_assoc_link_id = "5ZBNOZHTIPHVJEPF";
                amzn_assoc_marketplace = "amazon";
                amzn_assoc_region = "US";
                amzn_assoc_placement = "";
                amzn_assoc_search_type = "search_widget";
                amzn_assoc_width = 302;
                amzn_assoc_height = 314;
                amzn_assoc_default_search_category = "";
                amzn_assoc_default_search_key = "";
                amzn_assoc_theme = "light";
                amzn_assoc_bg_color = "FFFFFF";
            </script>
            <script src="//z-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetScript&ID=OneJS&WS=1&MarketPlace=US"></script>
            <!-- /Amazon lightning deals -->
        </div>
    </div>
    <!-- /Daily Deals -->

    <!-- Top Stores -->
    <div id="top-stores-container">
        <div style="width:100%;height:35px;">
            <div id="top-stores" class="h1">Top Stores</div>
            <div class="seeAll"><a href="/stores/search">See All Stores »</a></div>
        </div>
        <?php foreach ($stores as $store) : ?>
            <div class="store">
                <div class="logo"><a href="<?php echo escape('/stores/details/'.$store['id']) ?>"><img class="cdn-image" onload="
                    var width = 100;
                    var height = 32;
                    var ratio = Math.min(width/this.width, height/this.height);
                    var nwidth = ratio*this.width;
                    var nheight = ratio*this.height;
                    this.width = nwidth;
                    this.height = nheight;"
                onerror="this.src='<?php echo s3path("/images/no-image-100px.gif") ?>'"
                src="<?php echo escape($store['logo_thumb']) ?>" alt="<?php echo escape($store['name']) ?>"/></a></div>
                <div class="cashback"><a href="<?php echo escape('/stores/details/'.$store['id']) ?>"><?php echo escape($store['cashback_text']) ?> Cash Back</a></div>
            </div>
        <?php endforeach ?>
    </div>
    <!-- /Top stores -->

    <!-- Hot Coupons -->
    <div id="hot-coupons-container">
        <div style="width:100%;height:35px;">
            <div id="hot-coupons" class="h1"> Hot Coupons</div>
            <div class="seeAll"><a href="/coupon/search">See All Coupons »</a></div>
        </div>
        <?php foreach ($coupons as $coupon) : ?>
            <div class="Homecoupon">
                <div class="descimg"><a href="<?php echo escape($coupon['linkstore']) ?>"><img src="<?php echo escape($coupon['logo_thumb']) ?>" onload="
                    var width = 100;
                    var height = 34;
                    var ratio = Math.min(width/this.width, height/this.height);
                    var nwidth = ratio*this.width;
                    var nheight = ratio*this.height;
                    this.width = nwidth;
                    this.height = nheight;"
                 onerror="this.src='<?php echo s3path("/images/no-image-100px.gif") ?>'"
                 alt="** PLEASE DESCRIBE THIS IMAGE **"/></a></div>
                 <div class="desc"><a class="title" href="<?php echo escape($coupon['linkstore']) ?>" rel="nofollow"><?php echo escape($coupon['name-abrv']) ?></a><br/>
                 <?php echo escape($coupon['code_prefix']) ?><font class="code" color=black ref=""  rel="nofollow"><?php echo escape($coupon['code']) ?></font></div>
                <div style="clear: both;"></div>
            </div>
        <?php endforeach ?>
    </div>
    <!-- /Hot Couppons -->

</div>
<!-- /Content -->

</div>
<!-- /#container -->


<script type="text/javascript" src="<?php echo s3path("/script_files/jquery.easing.1.3.js") ?>"></script>
<script type="text/javascript" src="<?php echo s3path("/script_files/jquery.coda-slider-2.0.js") ?>"></script>

<script type="text/javascript">
var codaS;
$(document).ready(function() {
    $('#coda-slider-1').codaSlider({
        dynamicArrows:false,
        autoSlide: true,
        autoSlideInterval: 9000,
        autoSlideStopWhenClicked: true,
        dynamicArrows: false,
        dynamicTabs: false,
        crossLinking: true
    });
});
</script>
<!-- footer -->
{footer}
<?php echo googletag_ad('BS_home_728x90_4') ?>
<!-- footer -->
</body>
</html>
