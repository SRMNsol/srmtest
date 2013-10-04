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


<!-- content -->
<? if($code) { ?>
<div style="clear:both" class="message error">
{errors}
{message}
{/errors}
</div>
<? } ?>
		<!-- page Title -->

		<div id="content" class="BGNoCol">
	<div id="pageTitle">
	<div id="pageTitleLeft"></div>
		<h1>Log In or Sign Up for a Free BeeSavy Account</h1>
	<div id="pageTitleRight"></div>
</div>
<div id="fullLogin">
	<div class="heading"><h3>Already a Member? Log In Here</h3><a href="/main/forgot" class="forgotLink forgotBG">Forgot Password</a></div>
	<div >
		<form id="standardLoginForm" enctype="application/x-www-form-urlencoded" method="post" action="/account/login"><dl class="extrabux_form">
<dt id="email-label" style="width:170px;"><label for="email" class="required">Your Email Address:</label></dt><dd id="email-element"><input name="email" id="email" type="text" value="{user}"></dd>
<dt id="password-label" style="width:170px;"><label for="password" class="required">Your Password:</label></dt>
<dd id="password-element">
<input name="password" id="password" value="" type="password"></dd>

<input name="type" value="standard" id="type" type="hidden">

<input name="return" value="/users/login" id="return" type="hidden">
<dt id="submit-label">&nbsp;</dt>
<dd>
<div class="LogIn"><div class="BtnLogInBg BtnLogIn"><INPUT type="submit" name="" value=""/></div></div></dd></dl></form>	</div>
	
</div>
<div id="fullRegister" class="borderLeft">
	<div class="heading"><h3>Not a Member? Join BeeSavy Today </h3></div>
	<ul>
		<li>Get <strong>Cash Back</strong> at thousands of top online stores</li>
	</ul>
	<div>
		<form id="registerForm" enctype="application/x-www-form-urlencoded" method="post" action="/account/register"><dl class="beesavy_form">
                    	<table cellspacing=0 cellpadding=0 border=0>
                <tr><td><dt id="email-label"><label for="email" class="required">Email Address:  *</label></dt></td><td><dd id="email-element"><input name="email" id="email" class="required email" type="text" value="{user}"></dd></td></tr>
               
                <tr><td height=60><dt><label>Referral Code: <dd><font style="font-size:8.5pt;"></font></dd></dt></label></td><td><dd id="password-element"><input name="referral" id="email" class="required email" type="text" value="{referral}"><div style="font-size:9pt;float:left;margin-top:-5px;"><i>Not Case Sensitive</i></div></dt></td></tr>
               
                <tr><td><dt id="password-label"><label for="password" class="required">Password:</label></dt></td><td><dd id="password-element"><input name="password" id="password" value="" class="required password" type="password"></dd></td></tr>
<tr><td><dt id="password_confirm-label"><label for="password_confirm" class="required">Confirm Password:</label></dt></td><td><dd id="password_confirm-element"><input name="password_confirm" id="password_confirm" value="" class="required password" type="password"></dd></td></tr>

                <tr><td></td><td valign=top align=right><div class="StartSaving"><div class="BtnStartSavingBg BtnStartSaving"><INPUT type="submit" name="" value=""/></div></div></td></tr>
                </table>
</dd></dl></form>	


</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#standardLoginForm").validate();
	$("#registerForm").validate();
	$("#registerForm .email").focus();
});
</script>
<div style="clear: both;"></div>
	<div style="clear: both; height: 10px;"></div>
	</div>
		

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


<!-- /content -->

<!-- footer -->  
{footer}
<!-- /footer --> 




  </body>
  </html>
