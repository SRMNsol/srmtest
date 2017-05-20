<div id="header">
<!--    <div id="header-beesavy-logo"><a href="/" name="top"><img src="<?php echo s3path("/images/beesavy-logo.png") ?>" alt="beesavy.com" width="356" height="93" /></a></div>-->
    <div id="header-beesavy-logo"><a href="<?php echo SURL?>" name="top"><img src="<?php echo s3path("/images/beesavy-logo.png") ?>" alt="beesavy.com" width="356" height="93" /></a></div>
        <div id="header-links">
            <div id="header-links1">
                <div><a class="help" href="<?php echo SURL?>info/how">Help</a></div>
                <div class="header-links-dot"><div class="header-dot"></div></div>
                <div><a class="join-now" href="<?php echo SURL?>main/joinnow">Join Now</a></div>
                <div class="header-links-dot"><div class="header-dot"></div></div>

                <div><a id="login2" class="login" href="#_" onclick="$('#banner-ad').stop(true,true);$('#banner-ad').hide();$(this).toggle();$('#login1').toggle();$('#loginBox').slideToggle('slow');$('#inputEmail').focus()">Log In</a> </div>
                <div><a id="login1" style="display:none" class="loginOpen" href="#_" onclick="$('#loginBox').stop(true,true);$('#loginBox').hide();$(this).toggle();$('#login2').toggle();$('#banner-ad').slideToggle();">Log In</a> </div>

                <?php echo googletag_ad('BS_login_486x60', 'right') ?>
            </div>

            <FORM id="loginBox" method=post action=<?php echo SURL?>account/login style="display:none">
                <Div id="loginBoxContainer" class="headerLinksOpen">
                    <DIV style="margin-top:5px;border:0px solid #3C0;">
                       <LABEL id=labelEmail for=inputEmail>Email Address: </LABEL>
                       <LABEL id="labelPass" for="inputPass">Password: </LABEL><a href="<?php echo SURL?>main/forgot" class="questionmark"><img src="<?php echo s3path("/images/qmark.jpg") ?>"></a><BR>
                       <INPUT id=inputEmail name=email> <INPUT id=inputPass type=password name=password>
                       <div class="LogIn"><div class="BtnLogInBg BtnHeaderLogIn"><INPUT type="submit" value="LOG IN" class="button" /></div>
                    </div>
                </DIV>
            </FORM>
        </div>
    </div>

    <div id="facebook"><a target='_blank' href='http://www.facebook.com/pages/BeeSavy/139324182791301'><img src="<?php echo s3path("/images/facebooktop.gif") ?>"></a></div>
    <div id="tweeter"><a target='_blank' href='http://www.twitter.com/#!/beesavy'><img src="<?php echo s3path("/images/twittertop.gif") ?>"></a></div>
    <div id="youtube"><a target='_blank' href='http://www.youtube.com/user/BeeSavy'><img src="<?php echo s3path("/images/youtubetop.gif") ?>"></a></div>
</div>
