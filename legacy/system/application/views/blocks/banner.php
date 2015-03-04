<div id="header">
    <div id="header-beesavy-logo"><a href="/" name="top"><img src="<?php echo s3path("/images/header-beesavy-logo.gif") ?>" alt="beesavy.com" width="356" height="93" /></a></div>
        <div id="header-links">
            <div id="header-links1">
                <div><a class="help" href="/info/how">Help</a></div>
                <div class="header-links-dot"><div class="header-dot"></div></div>
                <div><a class="tm-marketplace" href="http://www.tomorrowsmarketplace.com/" target="_blank">TM Marketplace</a></div>
                <div class="header-links-dot"><div class="header-dot"></div></div>
                <div><a class="join-now" href="/main/joinnow">Join Now</a></div>
                <div class="header-links-dot"><div class="header-dot"></div></div>

                <div><a id="login2" class="login" href="#_" onclick="$('#banner-ad').stop(true,true);$('#banner-ad').hide();$(this).toggle();$('#login1').toggle();$('#loginBox').slideToggle('slow');$('#inputEmail').focus()">Log In</a> </div>
                <div><a id="login1" style="display:none" class="loginOpen" href="#_" onclick="$('#loginBox').stop(true,true);$('#loginBox').hide();$(this).toggle();$('#login2').toggle();$('#banner-ad').slideToggle();">Log In</a> </div>

                <?php echo googletag_ad('BS_login_486x60', 'right') ?>
            </div>

            <FORM id="loginBox" method=post action=/account/login style="display:none">
                <Div id="loginBoxContainer" class="headerLinksOpen">
                    <DIV style="margin-top:5px;border:0px solid #3C0;">
                       <LABEL id=labelEmail for=inputEmail>Email Address: </LABEL>
                       <LABEL id="labelPass" for="inputPass">Password: </LABEL><a href="/main/forgot" class="questionmark"><img src="<?php echo s3path("/images/qmark.jpg") ?>"></a><BR>
                       <INPUT id=inputEmail name=email> <INPUT id=inputPass type=password name=password>
                       <div class="LogIn"><div class="BtnLogInBg BtnHeaderLogIn"><INPUT type="submit" name="" value=""/></div>
                    </div>
                </DIV>
            </FORM>
        </div>
    </div>

    <div id="facebook"><a target='_blank' href='http://www.facebook.com/pages/BeeSavy/139324182791301'><img src="<?php echo s3path("/images/facebooktop.gif") ?>"></a></div>
    <div id="tweeter"><a target='_blank' href='http://www.twitter.com/#!/beesavy'><img src="<?php echo s3path("/images/twittertop.gif") ?>"></a></div>
    <div id="youtube"><a target='_blank' href='http://www.youtube.com/user/BeeSavy'><img src="<?php echo s3path("/images/youtubetop.gif") ?>"></a></div>
</div>
