    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{header}
<body>
<div id="container">
<!-- Header -->
{banner}
<!-- /Header -->

<!-- Navigation bar -->
{nav_bar}
<!-- /Navigation bar -->

<?php echo googletag_ad("BS_help_728x90_1") ?>

<!-- content -->
<div class="BGLeftCol">
    <!-- page Title -->
    <div id="pageTitle">
        <div id="pageTitleLeft"></div>
        <h1>Help</h1>
        <div id="pageTitleRight"></div>
    </div>
    <!-- /page Title -->

    <!-- Left category -->
    {side_nav}
    <!-- /Left category -->

    <!-- Right side -->
    <div id="results" class="help" style="border:0px solid #000;" >
        <div class="title">Learn More - Shop By Store</div>
        <div style="float:left;width:100%;"><hr color="#e96d08" style="margin-left:10px;"></div>
        <p><strong>Already know what you want and where you want to shop?</strong> &nbsp;Use our <a href="/stores/search">Shop By Store </a>functionality to navigate to your store of choice. &nbsp;By shopping through the link on BeeSavy, you'll be earning valuable cash back on your purchase. &nbsp;Just be sure that your shopping cart is empty before linking through to the store. &nbsp;Otherwise, the store won't pay cash back if you already had items in your cart.
        <br><iframe width="425" height="349" src="http://www.youtube.com/embed/_0TpVYLihF8" frameborder="0" allowfullscreen></iframe><br><br>
    </div>
    <div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>

<!-- Right side -->

<script>
$(document).ready(function() {
    $("div.productResult").mouseover(function () {
        var element = $(this);
        element.find('.BtnComparePrice').addClass('BtnOrangeRBg').removeClass('BtnOrangeBg');
    }).mouseout(function () {
        var element = $(this);
        element.find('.BtnComparePrice').addClass('BtnOrangeBg').removeClass('BtnOrangeRBg');
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
});
</script>

<!-- /content -->

<!-- footer -->
{footer}
<?php echo googletag_ad("BS_help_728x90_2") ?>
<!-- /footer -->

</body>
</html>
