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

<!-- Content -->
<div>
    <!-- Guide -->
    <div id="guide-beesavy">
        <div  class="orangegradiant-bg">
            <div class="title1">How do I tell others about Beesavy?</div>
        </div>
        <div class="inner-outerbox">
            <div class="innerbox">
                <a href="/info/lm_guide" class="title2">The Guide To Building Your Hive</a><br><br>
                <a href="<?php echo s3path('/images/beesavy-partner-stores.png') ?>" class="title2" target="_blank">Beesavy Top Partner Shops</a></p>
            </div>

            <!-- video -->
            <div class="video">
                <iframe width="213" height="120" src="https://www.youtube.com/embed/G1tfGYWIKlI" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="video">
                <iframe width="213" height="120" src="https://www.youtube.com/embed/z-yD-tAkEUw" frameborder="0" allowfullscreen></iframe>
            </div>
            <!-- /video -->

        </div>
    </div>
    <!-- /Guide -->

    <!-- Top Stores -->
    <div id="CenterBox">
        <div id="WelcomeUserBg">
            <div  class="orangegradiant-bg">
                <div class="title1">Welcome back!</div>
            </div>
            <div class="inner-outerbox">
                <div class="innerbox">
                    <table><tbody><tr><td><strong>Member since:</strong></td><td>{created}</td></tr><tr><td><strong>Last Login:</strong></td><td>{last_login} </td></tr><tr><td><strong>Last Purchase:</strong></td><td>
                    <?php echo (strtotime($last_cashback)) ? strftime('%B %e, %Y', strtotime($last_cashback)) : '-'; ?></td></tr></tbody></table>
                </div>
            </div>
        </div>
        <?php echo googletag_ad('BS_home_250x250') ?>
    </div>
    <!-- /Top stores -->

    <!-- Referral Overview -->
    <div id="accounts-summary-container">
<div class="TotalBox">
<div  class="blockgradiant-bg">
	<div id="cat-left-curve"><img src="<?php echo s3path("/images/cat-left-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div id="cat-right-curve"><img src="<?php echo s3path("/images/cat-right-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div class="title1">Account Summary</div>
</div>
<div class="outerbox">
	<div class="title2">Referral Overview</div>
	<div class="innerbox">
{total}
    <table><tbody><tr><td><strong>Level 1 Referrals :</strong></td><td>{referralcountdirect}</td></tr><tr><td><strong>Level 2 to 7 Referrals :</strong></td><td>{referralcountindirect}</td></tr><tr><td><strong>Total Referral Network:</strong></td><td><?php echo $total[0]['referralcountdirect'] + $total[0]['referralcountindirect']?></td></tr></tbody></table>
	</div>
	<div class="title2">Cash Back Overview</div>
	<div class="innerbox">
    <table><tbody><tr><td><strong>Pending :</strong></td><td>${pending}</td></tr><tr><td><strong>Available :</strong></td><td>${available}</td></tr><tr><td><strong>Processing :</strong></td><td>${processing}</td></tr><tr><td><strong>Paid :</strong></td><td>${paid}</td></tr></tbody></table>
	{/total}
	</div>

<?php if((float)$total[0]['available'] > 10) { ?>
        <div class="Request"><div class="BtnRequestBg BtnRequest"><a class="button" href="/account/index/0/2" rel="nofollow">REQUEST A PAYMENT</a></div></div>
        <div class="RequestNote">You can now request a payment!</div>
<?php } else {
    $dif = number_format(10 - (float)$total[0]['available'],2);
?>

        <div class="Request"><img style="padding-left:50px;padding-top:10px;" src="<?php echo s3path("/images/btn-request-payment-gray.gif") ?>"/></div>
        <div class="RequestNote">You need an additional $<?php echo $dif ?> to request a payment.</div>
<?php } ?>
</div>
</div>
</div>

<?php echo googletag_ad('BS_home_728x90_3') ?>

    <div style="width:930px;margin-left:0px;border:0px solid #00F;float:left;">
        <!-- Top Stores -->
        <div id="top-stores-container">
            <div style="width:100%;height:35px;">
                <div id="top-stores" class="h1">Top Stores</div>
                <div class="seeAll"><a href="/stores/search">See All Stores »</a></div>
            </div>
            <?php foreach ($stores as $store) : ?>
                <div class="store">
                    <div class="logo"><a href="/stores/details/<?php echo escape($store['id']) ?>"><img class="cdn-image" onload="
                            var width=100;
                            var height=34;
                            var ratio= Math.min(width/this.width, height/this.height);
                            var nwidth=ratio*this.width;
                            var nheight=ratio*this.height;
                            this.width=nwidth;
                            this.height=nheight;" onerror="this.src="<?php echo s3path("/images/no-image-100px.gif") ?>""
                            src="<?php echo escape($store['logo_thumb']) ?>" alt="<?php echo escape($store['name']) ?>"/></a>
                    </div>
                    <div class="cashback"><a href="/stores/details/<?php echo escape($store['id']) ?>"><?php echo escape($store['cashback_text']) ?> Cash Back</a></div>
                </div>
            <?php endforeach ?>
        </div>
        <!-- /Top stores -->

        <!-- Amazon -->
        <div style="margin: 5px 0 0 4px; float: left;">
            <!-- Amazon lightning deals script -->
            <script charset="utf-8" type="text/javascript">
                amzn_assoc_ad_type = "responsive_search_widget";
                amzn_assoc_tracking_id = "bee053-20";
                amzn_assoc_link_id = "5ZBNOZHTIPHVJEPF";
                amzn_assoc_marketplace = "amazon";
                amzn_assoc_region = "US";
                amzn_assoc_placement = "";
                amzn_assoc_search_type = "search_widget";
                amzn_assoc_width = 300;
                amzn_assoc_height = 314;
                amzn_assoc_default_search_category = "";
                amzn_assoc_default_search_key = "";
                amzn_assoc_theme = "light";
                amzn_assoc_bg_color = "FFFFFF";
            </script>
            <script src="//z-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetScript&ID=OneJS&WS=1&MarketPlace=US"></script>
            <!-- /Amazon lightning deals script -->
        </div>
        <!-- /Amazon -->

    </div>

</div>


   <!-- /Referral Overview -->
<!-- /Content -->

<!-- footer -->
{footer}
<?php echo googletag_ad('BS_home_728x90_4') ?>

</body>
</html>
