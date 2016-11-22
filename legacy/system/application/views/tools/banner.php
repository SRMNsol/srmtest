<!DOCTYPE html PUBLIC "-/W3C//DTD XHTML 1.0 Transitional//EN"
    "http:/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta name="description" content="Save money on millions of products from thousands of top online stores at BeeSavy.com with comparison shopping, cash back, and coupons." />
<title>BeeSavy – Taking the sting out of online shopping
</title>
<link rel="shortcut icon" href="<?php echo s3path("/images/favicon.ico") ?>" />
<link href="<?php echo s3path("/styles/account.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/main.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/home.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/results.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/view.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo s3path("/styles/button.css") ?>" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo s3path("/scroll/styles/jScrollPane.css") ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo s3path("/scroll/styles/scrollstyles.css") ?>" />
<link media="screen" rel="stylesheet" href="<?php echo s3path("/styles/colorbox.css") ?>" />
<link rel="stylesheet" href="/css/custom.css">
<link rel="stylesheet" href="/css/select2.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script src="/js/select2.js"></script>
<script src="/js/autocomplete.js"></script>
<script src="<?php echo s3path("/colorbox/jquery.colorbox.js") ?>"></script>
<script type="text/javascript" src="<?php echo s3path("/zeroclipboard/ZeroClipboard.js") ?>">
</script>
<script type='text/javascript' src="<?php echo s3path("/script_files/nav_bar.js") ?>"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23342317-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type='text/javascript'>
$(document).ready(function(){
        ZeroClipboard.setMoviePath('<?php echo s3path("/zeroclipboard/ZeroClipboard.swf") ?>');
		var clips = [];

		function startZC() {
            var elements = $(".Material");
            var container = $(".Material .BannerClickCode");
            var buttons = $(".Material .BannerClickCode .button");
            var text = $(".Material input")
            for(var i=0; i<elements.length; i++){
                var clip = new ZeroClipboard.Client();
                clip.setHandCursor( true );

                clip.addEventListener('load', function (client) {
                });
                var newval = text[i].value;

                var cb = function callback(someclip, sometext){
                    return function(client){
                        someclip.setText(sometext);
                    };
                };

                clip.addEventListener('mouseOver', cb(clip, newval));
                clip.glue( buttons[i], container[i]);
                clips.push(clip);
            }
			//clip.glue( $('#l1sc'), $('#l1st') );
		}
    $("#personal").colorbox();
    $("#business").colorbox();
    startZC();
});
</script>
</head>
<body >
<script type="text/javascript">
$(document).ready(function(){
$("#l1s").colorbox();
$("#l2s").colorbox();
$("#ws1s").colorbox();
$("#ws2s").colorbox();
$("#mr1s").colorbox();
$("#mr2s").colorbox();
$("#sp1s").colorbox();
$("#sp2s").colorbox();
$("#fb1s").colorbox();
$("#fb2s").colorbox();
$("#hb1s").colorbox();
$("#hb2s").colorbox();

$("#l1f").colorbox();
$("#l2f").colorbox();
$("#ws1f").colorbox();
$("#ws2f").colorbox();
$("#mr1f").colorbox();
$("#mr2f").colorbox();
$("#sp1f").colorbox();
$("#sp2f").colorbox();
$("#fb1f").colorbox();
$("#fb2f").colorbox();
$("#hb1f").colorbox();
$("#hb2f").colorbox();
});
</script>
</head>
<body>
<style type="text/css">
.BannerBox img {
    max-height:100px;
    max-width:100px;
}
.BannerBox{
    width:200px;
}
.img-div{
    height:147px;
    width:176px;
}
</style>
<div id="container">

<!-- Header -->
   {banner}
<!-- /Header -->

<!-- Navigation bar -->
    {nav_bar}
<!-- /Navigation bar -->


<!-- content -->



<div class="BGNoCol" style="border:0px solid #090;">

	<!-- page Title -->
	<div id="pageTitle">
		<div id="pageTitleLeft"></div>
		<h1 class="profile">My Account Settings</h1>
		<div id="pageTitleRight"></div>
		<div id="titleNav" class="large">
			<a href="/cashback">Cash Back Summary</a>
			<a href="/tools" id="active">Referral Tools</a>
			<a href="/account">Account Settings</a>
		</div>
	</div>
   	<!-- /page Title -->

    <!-- Left Catagoty -->
    <div style="width:900px;border:0px solid #090;float:left;">
		<div class="merchantView_Width" style="border:0px solid #090;width:920px;">
		<div>
		<ul class="tabs">
			<li><a  href="/tools"><font class="tabstext">OVERVIEW</font></a></li>
			<li><a href="/tools/referrals">REFERRALS</a></li>
            <li><a class="active" href="#_">BANNERS</a></li>
            <li><a target="_blank" href="http://www.vistaprint.com/vp/gateway.aspx?sr=no&s=0642720143&email=<?php echo urlencode($email); ?>&offer={id}&fullname={first_name}%20{last_name}&fax={alias}">BEESAVY STORE</a></li>
		</ul>
		</div>
		<div id="tabBorder" style="width:900px;"></div>



             <!-- FAQ  -->

           <p class=BannerGeneral>  Do you have a website?  Are you tired of relying on typical online advertising to try to monetize your site?  How would you like to develop loyalty among your users and even earn commission on people who don't even visit your site?  BeeSavy is a powerful new way to monetize your site while providing your users and their friends a valuable service.  You will be saving your users time and money and you'll earn commission on all of their purchases as well as the people they refer through seven levels!

	<p class=BannerGeneral>Just copy your unique link below to place the banner of your choice on your site and we'll take care of the rest.  Don't see the banner size you need?  Just <a href="/info/contact" style="color:#F90;">contact us</a> and we'll get you the banner size you need!


           <!-- LeaderBoard -->
                        <div class="LeaderboardOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=97% height=40><tr><td><font class="BannerTypeText">Leaderboard - Option 1</font></td><td align=right><font class="SizeText">size: 728 x 90</font></td></tr></table>
        	        <div class="LeaderboardInnerBox">
 						<div class="Material">
                            <table border=0><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerLeaderboard_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=left><table border=0 width=100%>

<tr>
<td align=center><div class="Preview"><div class="BtnPreiviewBanner">
<a class="button button-small" id="l1s" href="{leaderboard_1_static_url}"  rel="nofollow">PREVIEW</a></div></div></td>
<td colspan=2 align=center><input id="l1st" class="BannerInput" type=text value="{leaderboard_1_static}"/></td>
<td align=center colspan=2><div class="ClickCode"><div id="l1sc" class="BannerClickCode"><a id="l1sb" class="button button-small" href="#_" rel="nofollow">CLICK TO COPY CODE</a>
</div></div></td>
</tr></table>
</td></tr></table>
                    	</div>
					</div>

        	        <div class="LeaderboardInnerBox">
 						<div class="Material">
							<table border=0><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerLeaderboard_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=left><table border=0 width=100%><tr><td align=center><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" id="l1f" href="{leaderboard_1_flash_url}"  rel="nofollow">PREVIEW</a></div></div></td><td colspan=2 align=center><input "l1ft" class="BannerInput" type=text value="{leaderboard_1_flash}" /></td><td align=center colspan=2><div class="ClickCode"><div "l1fc" class="BannerClickCode"><a id="l1fb" class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table></td></tr></table>
                    	</div>
					</div>
                    <div class="space">&nbsp;</div>
                </div>


                    <div class="LeaderboardOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=97% height=40><tr><td><font class="BannerTypeText">LeaderBoard - Option 2</font></td><td align=right><font class="SizeText">size: 728 x 90</font></td></tr></table>
        	        <div class="LeaderboardInnerBox">
 						<div class="Material">
							<table border=0><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerLeaderboard_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=left><table border=0 width=100%><tr><td align=center><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" id="l2s" href="{leaderboard_2_static_url}"  rel="nofollow">PREVIEW</a></div></div></td><td colspan=2 align=center><input "l2st" class="BannerInput" type=text value="{leaderboard_2_static}"/></td><td align=center colspan=2><div class="ClickCode"><div "l2sc" class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow" id="l2sb">CLICK TO COPY CODE</a></div></div></td></tr></table></td></tr></table>
                    	</div>
					</div>

        	        <div class="LeaderboardInnerBox">
 						<div class="Material">
							<table border=0><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerLeaderboard_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=left><table border=0 width=100%><tr><td align=center><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" id="l2f" href="{leaderboard_2_flash_url}"  rel="nofollow">PREVIEW</a></div></div></td><td colspan=2 align=center><input "l2ft" class="BannerInput" type=text value="{leaderboard_2_flash}"/></td><td align=center colspan=2><div "l2fc" class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow" "l2fb">CLICK TO COPY CODE</a></div></div></td></tr></table></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
                </div>





          <!-- Vertical Sky scrappper -->
		                <div class="SkyscraperOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=90% height=40><tr><td><font class="BannerTypeText">Wide skyscraper - Option 1</font></td><td align=right><font class="SizeText">size: 160 X 600</font></td></tr></table>
        	        <div class="SkyscraperInnerBox">
 						<div class="Material">
							<table border=0><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 align=center><img src="<?php echo s3path("/images/BannerSkyscraper_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" id="ws1s" href="{wide_skyscraper_1_static_url}"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input id="ws1st" class="BannerInput" type=text value="{wide_skyscraper_1_static}"/></td></tr><tr><td align=center colspan=2><div id="ws1sc" class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow" id="ws1sb">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
        	        <div class="SkyscraperInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerSkyscraper_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{wide_skyscraper_1_flash_url}" id="ws1f"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input id="ws1ft" class="BannerInput" type=text value="{wide_skyscraper_1_flash}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div id="ws1fc" class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow" id="ws1fb">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
               </div>

                <div class="SkyscraperOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=90% height=40><tr><td><font class="BannerTypeText">Wide skyscraper - Option 2</font></td><td align=right><font class="SizeText">size: 160 X 600</font></td></tr></table>
        	        <div class="SkyscraperInnerBox">
 						<div class="Material">
							<table border=0><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 align=center><img src="<?php echo s3path("/images/BannerSkyscraper_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" id="ws2s" href="{wide_skyscraper_2_static_url}"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input id="ws2st" class="BannerInput" type=text value="{wide_skyscraper_2_static}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div id="ws2sc" class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow" id="ws2sb">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
        	        <div class="SkyscraperInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerSkyscraper_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{wide_skyscraper_2_flash_url}" id="ws2f"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input id="ws2ft" class="BannerInput" type=text value="{wide_skyscraper_2_flash}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div id="ws2fc" class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow" id="ws2fb">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
               </div>

           <!-- Medium -->
             				<div class="MediumOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=90% height=40><tr><td><font class="BannerTypeText">Medum Rectangle - Option 1</font></td><td align=right><font class="SizeText">size: 300 x 250</font></td></tr></table>
        	        <div class="MediumInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerMedium_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{medium_rectangle_1_static_url}" id="mr1s"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input id="mr1st" class="BannerInput" type=text value="{medium_rectangle_1_static}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div id="mr1sc" class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow" id="mr1sb">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>

        	        <div class="MediumInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerMedium_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{medium_rectangle_1_flash_url}" id="mr1f"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" type=text value="{medium_rectangle_1_flash}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
                </div>

                             				<div class="MediumOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=90% height=40><tr><td><font class="BannerTypeText">Medum Rectangle - Option 2</font></td><td align=right><font class="SizeText">size: 300 x 250</font></td></tr></table>
        	        <div class="MediumInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerMedium_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" id="mr2s" href="{medium_rectangle_2_static_url}"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" type=text value="{medium_rectangle_2_static}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>

        	        <div class="MediumInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerMedium_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{medium_rectangle_2_flash_url}" id="mr2f"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" type=text value="{medium_rectangle_2_flash}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
                </div>


         <!-- Square popup -->
             				<div class="MediumOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=90% height=40><tr><td><font class="BannerTypeText">Square Popup - Option 1</font></td><td align=right><font class="SizeText">size: 250 x 250</font></td></tr></table>
        	        <div class="MediumInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerMedium_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a id="sp1s" class="button button-small" href="{square_popup_1_static_url}"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" type=text value="{square_popup_1_static}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>

        	        <div class="MediumInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerMedium_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{square_popup_1_flash_url}" id="sp1f"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" type=text value="{square_popup_1_flash}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
                </div>

                             				<div class="MediumOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=90% height=40><tr><td><font class="BannerTypeText">Square Popup - Option 2</font></td><td align=right><font class="SizeText">size: 250 x 250</font></td></tr></table>
        	        <div class="MediumInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerMedium_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{square_popup_2_static_url}" id="sp2s"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" type=text value="{square_popup_2_static}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>

        	        <div class="MediumInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerMedium_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{square_popup_2_flash_url}" id="sp2f"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" type=text value="{square_popup_2_flash}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
                </div>


          <!-- Fullbanner -->
		              <div class="FullOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=90% height=40><tr><td><font class="BannerTypeText">Full Banner - Option 1</font></td><td align=right><font class="SizeText">size: 468 X 60</font></td></tr></table>
        	        <div class="FullInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerFull_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2><table border=0 width=100%><tr><td align=center><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{full_banner_1_static_url}" id="fb1s"  rel="nofollow">PREVIEW</a></div></div></td><td colspan=2 align=center><input class="BannerInput" type=text value="{full_banner_1_static}"/></td><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table></td></tr></table>
                    	</div>
					</div>
                    <div class="FullInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerFull_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2><table border=0 width=100%><tr><td align=center><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{full_banner_1_flash_url}" id="fb1f"  rel="nofollow">PREVIEW</a></div></div></td><td colspan=2 align=center><input class="BannerInput" type=text value="{full_banner_1_flash}"/></td><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
               </div>


                                                       <div class="FullOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=90% height=40><tr><td><font class="BannerTypeText">Full Banner - Option 2</font></td><td align=right><font class="SizeText">size: 468 X 60</font></td></tr></table>
        	        <div class="FullInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerFull_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2><table border=0 width=100%><tr><td align=center><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{full_banner_2_static_url}" id="fb2s"  rel="nofollow">PREVIEW</a></div></div></td><td colspan=2 align=center><input class="BannerInput" type=text value="{full_banner_2_static}"/></td><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table></td></tr></table>
                    	</div>
					</div>
                    <div class="FullInnerBox">
 						<div class="Material">
                            <table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerFull_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2><table border=0 width=100%><tr><td align=center><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{full_banner_2_flash_url}" id="fb2f"  rel="nofollow">PREVIEW</a></div></div></td><td colspan=2 align=center><input class="BannerInput" type=text value="{full_banner_2_flash}" /></td><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
               </div>




         <!-- Half Banner-->

             		   <div class="HalfOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=90% height=40><tr><td><font class="BannerTypeText">Half Banner - Option 1</font></td><td align=right><font class="SizeText">size: 234 x 60</font></td></tr></table>
        	        <div class="SkyscraperInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerHalf_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" id="hb1s" href="{half_banner_1_static_url}"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" type=text value="{half_banner_1_static}" /></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
        	        <div class="SkyscraperInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerHalf_01.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{half_banner_1_flash_url}" id="hb1f"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" type=text value="{half_banner_1_flash}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
               </div>

                           	                <div class="HalfOuterBox">
                   	<table cellspacing=0 cellpadding=0 align=center width=90% height=40><tr><td><font class="BannerTypeText">Half Banner - Option 2</font></td><td align=right><font class="SizeText">size: 234 x 60</font></td></tr></table>
        	        <div class="SkyscraperInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Static</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerHalf_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a id="hb2s" class="button button-small" href="{half_banner_2_static_url}"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" type=text value="{half_banner_2_static}"/></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
        	        <div class="SkyscraperInnerBox">
 						<div class="Material">
							<table><tr><td colspan=2 class="MaterialTitle" align=center height=25>Animated</td></tr><tr><td colspan=2 ><img src="<?php echo s3path("/images/BannerHalf_02.gif") ?>" style="border:1px solid #CCC;"></td></tr><tr><td colspan=2 align=center height=35><div class="Preview"><div class="BtnPreiviewBanner"><a class="button button-small" href="{half_banner_2_flash_url}" id="hb2f"  rel="nofollow">PREVIEW</a></div></div></td></tr><tr><td colspan=2 align=center><input class="BannerInput" value="{half_banner_2_flash}" type=text /></td></tr><tr><td align=center colspan=2><div class="ClickCode"><div class="BannerClickCode"><a class="button button-small" href="#_"  rel="nofollow">CLICK TO COPY CODE</a></div></div></td></tr></table>
                    	</div>
					</div>
                      <div class="space">&nbsp;</div>
               </div>








               </div>
               </div>
               </div>



<!-- footer -->
{footer}
<!-- /footer -->

	<script>
$(window).load(function() {
	mCustomScrollbars();
});

function mCustomScrollbars(){
	/*
	malihu custom scrollbar function parameters:
	1) scroll type (values: "vertical" or "horizontal")
	2) scroll easing amount (0 for no easing)
	3) scroll easing type
	4) extra bottom scrolling space for vertical scroll type only (minimum value: 1)
	5) scrollbar height/width adjustment (values: "auto" or "fixed")
	6) mouse-wheel support (values: "yes" or "no")
	7) scrolling via buttons support (values: "yes" or "no")
	8) buttons scrolling speed (values: 1-20, 1 being the slowest)
	*/
	$("#mcs_container").mCustomScrollbar("vertical",400,"easeOutCirc",1.05,"auto","yes","yes",10);
	$("#mcs2_container").mCustomScrollbar("vertical",0,"easeOutCirc",1.05,"auto","yes","no",0);
	$("#mcs3_container").mCustomScrollbar("vertical",900,"easeOutCirc",1.05,"auto","no","no",0);
	$("#mcs4_container").mCustomScrollbar("vertical",200,"easeOutCirc",1.25,"fixed","yes","no",0);
	$("#mcs5_container").mCustomScrollbar("horizontal",500,"easeOutCirc",1,"fixed","yes","yes",20);
}

/* function to fix the -10000 pixel limit of jquery.animate */
$.fx.prototype.cur = function(){
    if ( this.elem[this.prop] != null && (!this.elem.style || this.elem.style[this.prop] == null) ) {
      return this.elem[ this.prop ];
    }
    var r = parseFloat( jQuery.css( this.elem, this.prop ) );
    return typeof r == 'undefined' ? 0 : r;
}

/* function to load new content dynamically */
function LoadNewContent(id,file){
	$("#"+id+" .customScrollBox .content").load(file,function(){
		mCustomScrollbars();
	});
}
</script>
<script src="<?php echo s3path("/jquery/jquery_003.js") ?>">
</script>



  </body>
  </html>
