<script type=text/javascript">
    $(document).ready(function() {
	    $("div.Request").mouseover(function () {
            var element = $(this);
            element.find('.BtnRequestBg').addClass('BtnRequestRBg').removeClass('BtnRequestBg');
        }).mouseout(function () {
            var element = $(this);
            element.find('.BtnRequestRBg').addClass('BtnRequestBg').removeClass('BtnRequestRBg');
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
<div id="header">
              <div id="header-beesavy-logo"><a href="/" name="top"><img src="<?php echo s3path("/images/header-beesavy-logo.gif") ?>" alt="beesavy.com" width="356" height="93" /></a></div>
                            <div id="header-links">
              <div id="header-links1">
              <div><a class="help" href="/info/how">Help</a></div>
              <div class="header-links-dot"><div class="header-dot"></div></div>
              <div><a class="make-home" href="/info/makehome" target="_blank">Make Home Page</a></div>
              <div class="header-links-dot"><div class="header-dot"></div></div>
              <div><a href="/account/logout" class="logout">Log out</a></div>
              <div class="header-links-dot"><div class="header-dot"></div></div>
              <div><a class="myaccount" href="/account">My Account</a> </div>
              <div class="welcome">Welcome back!</div>
              </div>

            </div>

              <div id="facebook"><a target='_blank' href='http://www.facebook.com/pages/BeeSavy/139324182791301'><img src="<?php echo s3path("/images/facebooktop.gif") ?>"></a></div>
              <div id="tweeter"><a target='_blank' href='http://www.twitter.com/#!/beesavy'><img src="<?php echo s3path("/images/twittertop.gif") ?>"></a></div>
		      <div id="youtube"><a target='_blank' href='http://www.youtube.com/user/BeeSavy'><img src="<?php echo s3path("/images/youtubetop.gif") ?>"></a></div>

      </div>



