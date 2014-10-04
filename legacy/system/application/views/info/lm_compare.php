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
        <div class="title">Learn More - Compare Prices</div>
        <div style="float:left;width:100%;"><hr color="#e96d08" style="margin-left:10px;"></div>
        <p><strong>Let BeeSavy do the work for you!</strong> &nbsp;Type in the product you are searching for and we will compare prices at thousands of the most popular online stores. &nbsp;You'll get the lowest price without having to search multiple web sites. You will also be sure that you're dealing with trusted, well-established stores.  <br><iframe width="425" height="349" src="http://www.youtube.com/embed/J0AsoctE_Rw?hl=en&fs=1" frameborder="0" allowfullscreen></iframe><br><br>
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
