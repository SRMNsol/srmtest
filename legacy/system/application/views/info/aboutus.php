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

<?php echo googletag_ad('BS_help_728x90_1') ?>

<!-- content -->
<div class="BGLeftCol" style="border:#00C 0px solid" >
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
    <div id="results" class="help">
        <div class="title">About us</div>
        <div style="float:left;width:100%;"><hr color="#e96d08" style="margin-left:10px;"></div>
            <p><strong>BeeSavy is the first website to combine comparison shopping with coupons, cash back discounts and referral cash back. &nbsp;</strong>Compare prices on millions of products from hundreds of trusted online stores. </p>

            <h2><strong>No matter where you shop or what you're buying, you'll save $:</strong></h2>

            <p><strong>I know what I want... but where should I buy it? &nbsp;</strong>Search for any product in BeeSavy's search engine. &nbsp;We show you all the stores selling that product along with the total price at each of those stores. &nbsp;The total price includes the list price, tax and shipping costs, cash back discount, and coupon savings. </p>

            <p><strong>I already know where I'm shopping... how do I save $? &nbsp;</strong>Even for you brand-loyal shoppers, you can save money every time you shop at your favorite stores. &nbsp;Click the <a href="/stores/search">Shop By Store</a> button in the top right to get started. &nbsp;First, check for coupons at your favorite store. &nbsp;Next, click through to your favorite store and make a purchase. &nbsp;When you shop online through BeeSavy, we earn a sales commission on anything you buy. &nbsp;We pass most of this commission to you as a cash back discount. &nbsp;Your cash back discount will post to your BeeSavy account within 1-4 days. &nbsp;BeeSavy will send you a check or deposit your cash back into your PayPal account once your balance reaches $10. </p>

            <p><strong>I don't know what I want... Now what? &nbsp;</strong>You can browse popular products by clicking the <a href="/product/category">Shop by Category</a> button in the top left. &nbsp;We'll show you the most popular products in hundreds of different categories.</p>

            <h2><strong>Other BeeSavy benefits for online shoppers:</h2>

            <p>Trusted retailers only! &nbsp;</strong>Unlike other comparison shopping websites, BeeSavy carefully chooses each and every one of its stores to ensure a safe and secure shopping experience. &nbsp;If you ever have a bad experience with a BeeSavy store, please let us know. </p>

            <p><strong>Feeling generous? &nbsp;Donate your savings to a charity. &nbsp;</strong>When you request a cash back payment, BeeSavy gives you the option to donate a portion or all of your cash back to a charity. &nbsp;Just choose a charity and how much you want to donate and we'll take care of the rest! </p>

            <p><strong>Love BeeSavy? &nbsp;Tell your friends and get referral cash back forever. &nbsp;</strong>Tell a friend about BeeSavy and we'll give you a 40% commission on all of their cash back forever. &nbsp;There is no limit to how many friends you can refer! &nbsp;We'll even pay you a 10% commission on all of their referrals up to seven levels deep. </p>


            <h2><strong>BeeSavy benefits for online retailers:</h2>

            <p>It's a win-win-win.</strong> &nbsp;With most forms of marketing, online retailers must pay upfront with no guarantee of results; however, with cost-per-sale marketing, online retailers only pay BeeSavy when it generates a sale. &nbsp;Online retailers choose a commission rate that fits within their profit margin, thereby ensuring a positive return on their marketing dollars. &nbsp;By giving most of this commission to the purchasing customer as a cash back rebate, BeeSavy utilizes this online retailer marketing method to save its customers money that traditional comparison shopping websites cannot match (due to their cost-per-click revenue model).
            </p>

            <p>BeeSavy.com is owned and operated by BeeSavy, LLC, a privately held company.</p>

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
<?php echo googletag_ad('BS_help_728x90_2') ?>
</div>
<!-- /footer -->

</body>
</html>
