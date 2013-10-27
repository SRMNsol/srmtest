<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta name="description" content="Save money on millions of products from thousands of top online stores at beesavy.com with comparison shopping, cash back, and coupons." />
<link rel="shortcut icon" href="/images/favicon.ico" />
<title>BeeSavy - Taking the sting out of online shopping</title>
<link href="/styles/main.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/styles/transfer.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/styles/account.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/script_files/extrabux.js"></script>
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
<link href="/styles/button.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
    <div id="transfer">
	<div id="transferWrap">
		<div id="closeButton"><a href="/transfer/{type}/{type_id}/skip"></a></div>
		<div id="title">
        <h1 class="twoLines">Sign Up to Save <?php if(isset($cashback_text)){ ?>{cashback_text}<?}else{?>${cashback_amount}<?}?> Cash Back<br /> at <span class="bold"><?php if(isset($merchant_name)){ ?>{merchant_name}<?}else{?>{name}<?}?></span></h1>
		</div>		
		<div class="div"></div>
		<div style="padding:0 15px;"></div>
<?php if($code) { ?>
<div style="clear:both" class="message error">
{errors}
{message}
{/errors}
</div>
<?php } ?>
        <div id="login">
		    <h2>Sign In</h2>
		    <form id="standardLoginForm" enctype="application/x-www-form-urlencoded" method="post" action="/transfer/login/{type}/{type_id}">
		        <input type="hidden" name="type" value="standard" id="type" />
		        <dl class="extrabux_form">
                    <dt id="email-label"><label for="email" class="required">Your Email Address:</label></dt>
                    <dd id="email-element"><input type="text" name="email" id="email" value=""></dd>
                    <dt id="password-label"><label for="password" class="required">Your Password:</label></dt>
                    <dd id="password-element"><input type="password" name="password" id="password" value=""></dd>
                    <dt style="display:inline; float:left; width:150px; padding-top:15px;"><a href="/main/forgot" target="_blank" style="font-size:12px; color:#666; text-decoration:underline;">Forgot your password?</a></dt>
                    
                    <dd><div class="LogIn"><div class="BtnLogInBg BtnLogIn"><INPUT type="submit" name="" value=""/></div></div></dd>
                </dl>
            </form>		
        </div>
		<div id="signup" >
		    <h2>New Account</h2>
		    <ul>
		        <li>Get <strong>cash back</strong> at thousands of top stores</li>
		    </ul>
		    <form id="quickRegisterForm" enctype="application/x-www-form-urlencoded" method="post" action="/transfer/register/{type}/{type_id}">
            <dl class="extrabux_form">
            	<table cellspacing=0 cellpadding=0 border=0>
                <tr><td><label for="email" class="required">Email Address:  *</label></td></tr>
                <tr><td><input name="email" id="email" class="required email" type="text"></td></tr>
                <tr><td><label>Referral Code: <font style="font-size:8pt;"></font></label></td></tr>
				<tr><td><input name="referral" value="{referral}" id="email" class="required email" type="text"></td></tr>
                <tr><td height=20><font style="font-size:9pt;"><i>Not Case Sensitive</i></font></td></tr>
                <tr><table cellspacing=0 cellpadding=0 width=100%><tr><td align=left><font size=2>* Required Field </font></td><td valign=top align=right><div class="StartSaving"><div class="BtnStartSavingBg BtnStartSaving"><INPUT type="submit" name="" value=""/></div></div></td></tr></table></td></tr>
                </table>				
            </dl></form>
        </div>
		<div id="optOut"><a href="/transfer/{type}/{type_id}/skip">or continue shopping without cash back &raquo;</a></div>
	</div>
</div></div>

<script>
$(document).ready(function() {
    $("div.LogIn").mouseover(function () {
        var element = $(this);
 		element.find('.BtnLogIn').addClass('BtnLogInRBg').removeClass('BtnLogInBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnLogInRBg').addClass('BtnLogInBg').removeClass('BtnLogInRBg');
    });
	
	    $("div.StartSaving").mouseover(function () {
        var element = $(this);
 		element.find('.BtnStartSaving').addClass('BtnStartSavingRBg').removeClass('BtnStartSavingBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnStartSavingRBg').addClass('BtnStartSavingBg').removeClass('BtnStartSavingRBg');
    });
	
   	});
</script>
</body>
</html>
