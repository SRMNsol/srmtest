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
<?php if(!empty($errors)){?>
<div style="clear:both" class="message error">
{errors}
<p>{message}</p>
{/errors}
</div>
<?php } ?>
		<!-- page Title -->
<div id="content" class="BGNoCol">
	<div id="pageTitle">
	<div id="pageTitleLeft"></div>
		<h1>Log In or Sign Up for a Free BeeSavy.com Account</h1>
	<div id="pageTitleRight"></div>
</div>

<div id="fullRegister" class="borderRight">
	  <div class="heading"><h3>Not a Member? Join BeeSavy Today </h3></div>

	<div>
		<form id="registerForm" enctype="application/x-www-form-urlencoded" method="post" action="/account/register"><dl class="beesavy_form">
                    	<table cellspacing=0 cellpadding=0 border=0>
                <tr><td><dt id="email-label"><label for="email" class="required">Email Address: *</label></dt></td><td><dd id="email-element"><input name="email" id="email" class="required email" type="text" value="{email}"></dd></td></tr>

                <tr><td height=60><dt><label>Referral Code: *<br><span style="font-weight: normal;">(Who referred you?)</span></label></dt></td><td><dd id="password-element"><input name="referral" id="email" class="required email" value="{referral}" type="text"><div style="font-size:9pt;float:left;margin-top:-5px;"><i>Not Case Sensitive</i></div></dt></td></tr>

                <tr><td width=150px><dt id="password-label"><label for="password" class="required">Password: *</label></dt></td><td><dd id="password-element"><input name="password" id="password" value="" class="required password" type="password"></dd></td></tr>
<tr><td><dt id="password_confirm-label"><label for="password_confirm" class="required">Confirm Password: * </label></dt></td><td><dd id="password_confirm-element"><input name="password_confirm" id="password_confirm" value="" class="required password" type="password"></dd></td></tr>

                <tr><td><font size=2>* Required Field </font></td><td valign=top align=right><div class="StartSaving"><div class="BtnStartSavingBg BtnStartSaving"><INPUT type="submit" value="START SAVING!" class="button"/></div></div></td></tr>
                </table>
</dd></dl></form>
</div>
</div>
<div id="registerText">
  <div id="compare">
    <h4>Compare prices on millions of products</h4>
    <p>BeeSavy’s comparison shopping engine goes above and beyond by including not only list price, tax, and shipping, but also cash back and coupon discounts—all
      in one simple interface.</p>
  </div>
  <div id="cashback">
    <h4>Get cash back at thousands of top online stores</h4>
    <p>When you shop online through BeeSavy, we earn a sales commission on anything you buy. We pass most of this commission to you as a cash back discount.</p>
  </div>
  <div id="coupons">
    <h4>Find hundreds of exclusive coupons</h4>
    <p>Not only does our system integrate store coupons into every product price, we also have a coupon section where you can browse through all of our available    coupons.</p>
  </div>

    <div id="refer">
    <h4 style="margin-left:83px;margin-top:-3px;">Get paid to refer your friends</h4>
    <p style="margin-left:83px;position:relative;"> BeeSavy  pays you 10% commission on all of your referrals' cash back forever.  We even pay you 10% commission for all of the people they refer up to seven levels!</p>
  </div>
</div>
<DIV style="CLEAR: left"></DIV>
<div id="securityNotice">BeeSavy will always be free, and your E-Mail address will never be shared with anyone</div>
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


<!-- /content -->

<!-- footer -->
{footer}
<!-- /footer -->




  </body>
  </html>
