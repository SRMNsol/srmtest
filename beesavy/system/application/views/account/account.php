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
<? if(!empty($errors)) { ?>
<div style="clear:both" class="message error">
{errors}
{message}
<br/>
{/errors}
</div>
<? } ?>
<? if(isset($success)) { ?>
<div style="clear:both" class="message success">
{success}
</div>
<? } ?>
<? if(isset($notice)) { ?>
<div style="clear:both" class="message notice">
{notice}
</div>
<? } ?>
	<!-- page Title -->
    <div id="content" class="BGNoCol">
	<div id="pageTitle">
		<div id="pageTitleLeft"></div>
		<h1 class="profile">My Account Settings</h1>
		<div id="pageTitleRight"></div>
		<div id="titleNav" class="large">
			<a href="/cashback">Cash Back Summary</a>
			<a href="/tools">Referral Tools</a>
			<a href="/account" id="active">Account Settings</a>
		</div>
	</div>
   	<!-- /page Title -->
    
    	

                

             
             

<!-- Left Catagoty -->
<div id=settings class="AccountLeftside">

<H2>Edit Payment Method</H2>


<?php
$payment_radio = array('','','');
if($payment_method == "CHECK"){
    $payment_radio = array('checked','','');
}elseif($payment_method == "PAYPAL"){
    $payment_radio = array('','checked','');
}elseif($payment_method == "CHARITY"){
    $payment_radio = array('','','checked');
}

?>

        

             
<DIV id="MailMe" class="slideBox closed"> 
		<input name="method" <?php echo $payment_radio[0]?> id="check" type="radio" onclick="$('.slideBoxContainer').hide();$('#MailMe').find('.slideBoxContainer').slideDown('slow');">
   <LABEL for=check>Mail Me A Check</LABEL>
		<div style="display:none" class="slideBoxContainer">
		<FORM id=checkPaymentForm method=post name=checkPaymentForm action=/account/edit_payment><INPUT id=paymentType value=check type=hidden name=paymentType> 
	    <INPUT type=hidden name=pmethod value="check">

		<TABLE>
		<TBODY>
		<TR>
        <TD>First / Last Name:</TD>
    	<TD><INPUT id=firstName tabIndex=1 type=text name=firstName value="{first_name}"><INPUT id=lastName tabIndex=2 type=text name=lastName value="{last_name}"></TD>
						<td class="submit"><div class=SaveChanges><div class="BtnSaveChangesBg BtnSaveChanges"><INPUT type="submit" name="" value=""/></div></div></td>
        </TR>
		<TR>
	    <TD>Street Address:</TD>
	    <TD><INPUT id=street tabIndex=3 type=text name=street value="{address}"></TD>
        </TR>
	    <TR>
	    <TD>City, State, &amp; Zip Code:</TD>
    	<TD><INPUT style="WIDTH: 115px" id=city tabIndex=4 type=text name=city value="{city}"> 
    	<SELECT id=state tabIndex=5 name=state> 

<?php 
    #Set the default selected store
    if($state){
    echo str_replace("value=$state", "value=$state selected","<OPTION  
        value=AL>AL</OPTION> <OPTION value=AK>AK</OPTION> <OPTION 
        value=AS>AS</OPTION> <OPTION value=AZ>AZ</OPTION> <OPTION 
        value=AR>AR</OPTION> <OPTION value=CA>CA</OPTION> <OPTION 
        value=CM>CM</OPTION> <OPTION value=CO>CO</OPTION> <OPTION 
        value=CT>CT</OPTION> <OPTION value=DE>DE</OPTION> <OPTION 
        value=DC>DC</OPTION> <OPTION value=FL>FL</OPTION> <OPTION 
        value=GA>GA</OPTION> <OPTION value=GU>GU</OPTION> <OPTION 
        value=HI>HI</OPTION> <OPTION value=ID>ID</OPTION> <OPTION 
        value=IL>IL</OPTION> <OPTION value=IN>IN</OPTION> <OPTION 
        value=IA>IA</OPTION> <OPTION value=KS>KS</OPTION> <OPTION 
        value=KY>KY</OPTION> <OPTION value=LA>LA</OPTION> <OPTION 
        value=ME>ME</OPTION> <OPTION value=MD>MD</OPTION> <OPTION 
        value=MA>MA</OPTION> <OPTION value=MI>MI</OPTION> <OPTION 
        value=MN>MN</OPTION> <OPTION value=MS>MS</OPTION> <OPTION 
        value=MO>MO</OPTION> <OPTION value=MT>MT</OPTION> <OPTION 
        value=NE>NE</OPTION> <OPTION value=NV>NV</OPTION> <OPTION 
        value=NH>NH</OPTION> <OPTION value=NJ>NJ</OPTION> <OPTION 
        value=NM>NM</OPTION> <OPTION value=NY>NY</OPTION> <OPTION 
        value=NC>NC</OPTION> <OPTION value=ND>ND</OPTION> <OPTION 
        value=OH>OH</OPTION> <OPTION value=OK>OK</OPTION> <OPTION 
        value=OR>OR</OPTION> <OPTION value=PA>PA</OPTION> <OPTION 
        value=PR>PR</OPTION> <OPTION value=RI>RI</OPTION> <OPTION 
        value=SC>SC</OPTION> <OPTION value=SD>SD</OPTION> <OPTION 
        value=TN>TN</OPTION> <OPTION value=TX>TX</OPTION> <OPTION 
        value=UT>UT</OPTION> <OPTION value=VT>VT</OPTION> <OPTION 
        value=VA>VA</OPTION> <OPTION value=VI>VI</OPTION> <OPTION 
        value=WA>WA</OPTION> <OPTION value=WV>WV</OPTION> <OPTION 
        value=WI>WI</OPTION> <OPTION value=WY>WY</OPTION>"); 
    } else { ?>
    <OPTION  
        value=AL>AL</OPTION> <OPTION value=AK>AK</OPTION> <OPTION 
        value=AS>AS</OPTION> <OPTION value=AZ>AZ</OPTION> <OPTION 
        value=AR>AR</OPTION> <OPTION value=CA>CA</OPTION> <OPTION 
        value=CM>CM</OPTION> <OPTION value=CO>CO</OPTION> <OPTION 
        value=CT>CT</OPTION> <OPTION value=DE>DE</OPTION> <OPTION 
        value=DC>DC</OPTION> <OPTION value=FL>FL</OPTION> <OPTION 
        value=GA>GA</OPTION> <OPTION value=GU>GU</OPTION> <OPTION 
        value=HI>HI</OPTION> <OPTION value=ID>ID</OPTION> <OPTION 
        value=IL>IL</OPTION> <OPTION value=IN>IN</OPTION> <OPTION 
        value=IA>IA</OPTION> <OPTION value=KS>KS</OPTION> <OPTION 
        value=KY>KY</OPTION> <OPTION value=LA>LA</OPTION> <OPTION 
        value=ME>ME</OPTION> <OPTION value=MD>MD</OPTION> <OPTION 
        value=MA>MA</OPTION> <OPTION value=MI>MI</OPTION> <OPTION 
        value=MN>MN</OPTION> <OPTION value=MS>MS</OPTION> <OPTION 
        value=MO>MO</OPTION> <OPTION value=MT>MT</OPTION> <OPTION 
        value=NE>NE</OPTION> <OPTION value=NV>NV</OPTION> <OPTION 
        value=NH>NH</OPTION> <OPTION value=NJ>NJ</OPTION> <OPTION 
        value=NM>NM</OPTION> <OPTION value=NY>NY</OPTION> <OPTION 
        value=NC>NC</OPTION> <OPTION value=ND>ND</OPTION> <OPTION 
        value=OH>OH</OPTION> <OPTION value=OK>OK</OPTION> <OPTION 
        value=OR>OR</OPTION> <OPTION value=PA>PA</OPTION> <OPTION 
        value=PR>PR</OPTION> <OPTION value=RI>RI</OPTION> <OPTION 
        value=SC>SC</OPTION> <OPTION value=SD>SD</OPTION> <OPTION 
        value=TN>TN</OPTION> <OPTION value=TX>TX</OPTION> <OPTION 
        value=UT>UT</OPTION> <OPTION value=VT>VT</OPTION> <OPTION 
        value=VA>VA</OPTION> <OPTION value=VI>VI</OPTION> <OPTION 
        value=WA>WA</OPTION> <OPTION value=WV>WV</OPTION> <OPTION 
        value=WI>WI</OPTION> <OPTION value=WY>WY</OPTION> 
    <? } ?>
        </SELECT> 
        <INPUT style="WIDTH: 75px" id=zip tabIndex=6 type=text name=zip value="{zip}"> 
		</TD>
        </TR>
        </TBODY>
        </TABLE>
        </FORM>
		</div>
</DIV>


    <div id="Paypal" class="slideBox closed">
		<input name="method" <?php echo $payment_radio[1]?> id="paypal" type="radio" onclick="$('.slideBoxContainer').hide();$('#Paypal').find('.slideBoxContainer').slideDown('slow');">
		<label for="paypal"><img style="margin-bottom: -7px;" src="/images/paypal-logo.png"></label>
		<div class="slideBoxContainer" style="display:none">
			<form id="paypalPaymentForm" name="paypalPaymentForm" action="/account/edit_payment" method="post">
				<input id="paymentType" name="pmethod" value="paypal" type="hidden">
				<p>Have money sent directly to your PayPal Account. Don't have an account? <a href="http://paypal.com/" target="_blank">Sign Up Here</a>.</p>
				<table>
					<tbody><tr>
						<td>PayPal Email Address:</td>
						<td><input id="paypalEmail" name="paypalEmail" type="text" value="{paypal_email}"></td>
						<td class="submit"><div class=SaveChanges><div class="BtnSaveChangesBg BtnSaveChanges"><INPUT type="submit" name="" value=""/></div></div></td>
					</tr>
				</tbody></table>
			</form>
		</div>
	</div>
    
    
	<div id="Charity" class="slideBox closed">
		<input name="method" <?php echo $payment_radio[2]?> id="charity" type="radio" onclick="$('.slideBoxContainer').hide();$('#Charity').find('.slideBoxContainer').slideDown('slow');">
		<label for="charity">Donate to a Charity</label>
		<div class="slideBoxContainer" style="display:none">
			<form id="charityPaymentForm" name="charityPaymentForm" action="/account/edit_payment" method="post">
				<input id="paymentType" name="pmethod" value="charity" type="hidden">
				<p>Select the Charity of Your Choice and BeeSavy will donate when you request a payment.</p>
				<table>
					<tbody><tr>
						<td>Charity:</td>
						<td>
							<select id="charity_id" name="charity_id">
<?php 
    #Set the default selected store
    echo str_replace("value=\"$charity_id\"", "value='$charity_id' selected",'<OPTION selected 
							<option selected="selected" label="Please select a charity" value="2">Please select a charity</option>
							<option label="American Heart Association" value="9">American Heart Association</option>
																<option label="American Red Cross" value="1">American Red Cross</option>
																<option label="Animal Welfare Institute" value="12">Animal Welfare Institute</option>
																<option label="Big Brothers Big Sisters of America" value="15">Big Brothers Big Sisters of America</option>
																<option label="Boys &amp; Girls Club of America" value="3">Boys &amp; Girls Club of America</option>
																<option label="CARE" value="16">CARE</option>
																<option label="Catholic Charities USA" value="17">Catholic Charities USA</option>
																<option label="Cystic Fibrosis Foundation" value="13">Cystic Fibrosis Foundation</option>
																<option label="Disabled American Veterans" value="18">Disabled American Veterans</option>
																<option label="Feed The Children" value="19">Feed The Children</option>
																<option label="Feeding America" value="14">Feeding America</option>
																<option label="Friends of Long Beach Animals" value="29">Friends of Long Beach Animals</option>
																<option label="Green Wish" value="28">Green Wish</option>
																<option label="Habitat for Humanity International" value="5">Habitat for Humanity International</option>
																<option label="Humane Society of the U.S." value="20">Humane Society of the U.S.</option>
																<option label="Leukemia &amp; Lymphoma Society" value="21">Leukemia &amp; Lymphoma Society</option>
																<option label="Nature Conservancy" value="6">Nature Conservancy</option>
																<option label="Salvation Army" value="8">Salvation Army</option>
																<option label="Save The Children" value="22">Save The Children</option>
																<option label="Special Olympics" value="23">Special Olympics</option>
																<option label="UNCF" value="25">UNCF</option>
																<option label="UNICEF" value="7">UNICEF</option>
																<option label="United Jewish Communities" value="26">United Jewish Communities</option>
                                                                <option label="World Vision" value="27">World Vision</option>')?>
															</select>
						</td>
						<td class="submit"><div class=SaveChanges><div class="BtnSaveChangesBg BtnSaveChanges"><INPUT type="submit" name="" value=""/></div></div></td>
					</tr>
				</tbody></table>
			</form>
         </div>

	</div>
      
<H2>Edit Social Networking Settings</H2>
<p>Build your cash back through social networks. Automatically let your social network know when you save money with BeeSavy!
<DIV class="slideBox closed">
	<FORM id=changeNewsletterForm method=post name=changeNewsletterForm action=/account/set_setting>
				<input name="setting" value="facebook_auto" type="hidden">
    <table><tr><td><img src="/images/facebooktop.gif" width=31 height=31></td><td align=center width=10><INPUT id=newsletter value=1 onclick="this.form.submit();"
    <?php if($facebook_auto) echo"CHECKED"?> type=checkbox name=value></td><td>Automatically post cash back messages to your Facebook wall.</td></tr></table>
	</FORM>
	<FORM id=changeNewsletterForm method=post name=changeNewsletterForm action=/account/set_setting>
				<input name="setting" value="twitter_auto" type="hidden">
    <table><tr><td><img src="/images/twittertop.gif" width=31 height=31></td><td align=center width=10><INPUT onclick="this.form.submit();" id=newsletter value=1 <?php if($twitter_auto) echo"CHECKED"?> type=checkbox name=value></td><td>Automatically tweet cash back messages to your Twitter account.</td></tr></table><br>

	<p class="small"><strong>Note:</strong> No personal information such as where you shopped or what you purchased will be shared.</>
	</FORM>
</DIV>



     <H2>Setup/Edit Referral ID Alias</H2>
      <p>When you joined BeeSavy, you were automatically assigned a unique id so that we could credit your referrals to you. If you would like an easier to remember id to share with people, select it here.<a href="/info/lm_referral"><font class="Learn">Learn more.</font></a></p><br><br>
	<DIV class="slideBox closed">
<FORM id=changeEmailForm method=post name=changeEmailForm action=/account/set_alias><LABEL>Referral Alias</LABEL> 
<TABLE>
  <TBODY>
  <TR>
    <TD>Current Referral ID Alias :</TD>
    <TD><STRONG>{alias}</STRONG></TD>
    <TD class=submit rowSpan=3><div class=SaveChanges><div class="BtnSaveChangesBg BtnSaveChanges"><INPUT type="submit" name="" value=""/></div></div> </TD></TR>
  <TR>
    <TD>New Referral ID Alias:</TD>
    <TD><INPUT tabIndex=10 type=text name=email></TD></TR>
  <TR>
    <TD>Confirm New Referral ID Alias:</TD>
    <TD><INPUT tabIndex=11 type=text 
name=email_confirm></TD></TR>
<tr><td></td><td><i>Minimum 3 characters</i></td></tr>
</TBODY></TABLE></FORM></DIV>

	<H2>Change Email</H2>
	<DIV class="slideBox closed">
<FORM id=changeEmailForm method=post name=changeEmailForm 
action=/account/set_email><LABEL>Change Email</LABEL> 
<TABLE>
  <TBODY>
  <TR>
    <TD>Current Email Address:</TD>
    <TD><STRONG>{email}</STRONG></TD>
    <TD class=submit rowSpan=3><div class=SaveChanges><div class="BtnSaveChangesBg BtnSaveChanges"><INPUT type="submit" name="" value=""/></div></div> </TD></TR>
  <TR>
    <TD>New Email Address:</TD>
    <TD><INPUT tabIndex=12 type=text name=email></TD></TR>
  <TR>
    <TD>Confirm New Email Address:</TD>
    <TD><INPUT tabIndex=13 type=text 
name=email_confirm></TD></TR></TBODY></TABLE></FORM></DIV>
	<H2>Email Settings</H2>

	<DIV class="slideBox closed" style="height:80px;">
<FORM id=changeNewsletterForm method=post name=changeNewsletterForm action=/account/set_email_setting>
    <table border=0><tr><td align=left width=15><INPUT id=newsletter value=1 <?php if($send_reminders) echo"CHECKED"?> type=checkbox name=send_reminders></td><td>Please notify me occasionally of special offers from BeeSavy.</td></tr></table>
        <table><tr><td align=center width=15><INPUT id=newsletter value=1 <?php if($send_updates) echo"CHECKED"?> type=checkbox name=send_updates></td><td>Please notify me of special partner offers.</td><td><div class=SaveChanges><div class="BtnSaveChangesBg BtnSaveChanges"><INPUT type="submit" name="" value=""/></div></div> </td></tr></table>
</FORM>
</DIV>

	<H2>Change Password</H2>
	<DIV class="slideBox closed">
<FORM id=changePasswordForm method=post name=changePasswordForm 
action=/account/set_password><LABEL>Change Password</LABEL> 
<TABLE>
  <TBODY>
  <TR>
    <TD>Current Password:</TD>
    <TD><INPUT tabIndex=14 type=password name=password_current></TD></TR>
  <TR>
    <TD>New Password:</TD>
    <TD><INPUT tabIndex=15 type=password name=password_new></TD>
    <TD class=submit rowSpan=2><div class="SaveChanges"><div class="BtnSaveChangesBg BtnSaveChanges"><INPUT type="submit" name="" value=""/></div></div> </TD></TR>
  <TR>
    <TD>Confirm New Password:</TD>
    <TD><INPUT tabIndex=16 type=password 
name=password_confirm></FORM></TD></TR></TBODY></TABLE>
</DIV>

</div>
<!-- Left Catagoty -->
  
  
  <!-- Right Catagoty -->
<div class="AccountRightside">
<!-- Referral Overview -->
<!--<div class="RightBanner"><!--				
<script type='text/javascript'>
    OA_show(3);
</script><noscript><a target='_blank' href='http://50.16.95.24/openx/www/delivery/ck.php?n=a88fd39'><img border='0' alt='' src='http://50.16.95.24/openx/www/delivery/avw.php?zoneid=1&amp;n=a88fd39' /></a></noscript>
<!--<img src="/images/rightbanner.jpg">
</div>-->
<div class="TotalBox">
<div  class="blockgradiant-bg">
	<div id="cat-left-curve"><img src="/images/cat-left-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
	<div id="cat-right-curve"><img src="/images/cat-right-curve.jpg" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>	
	<div class="title1">Cash Back Overview</div>
</div>      
<div class="outerbox">    
	<div class="title2">Personal Cash Back</div>
    {total}
	<div class="innerbox">
    <table><tbody><tr><td><strong>Pending :</strong></td><td>${UserPending}</td></tr><tr><td><strong>Available :</strong></td><td>${UserAvailable}</td></tr></tbody></table>
	</div>          
	<div class="title2">Referral Cash Back</div>
	<div class="innerbox">
    <table ><tbody><tr><td><strong>Pending :</strong></td><td>${referralpending}</td></tr><tr><td><strong>Available :</strong></td><td>${referralavailable}</td></tr><tr><td colspan="2"><p class="small">
<?php 
$dt1= new DateTime($last_cashback); 
$dt2= new DateTime(); 
$int = $dt1->diff($dt2); 
$val = (float)$int->format('%a'); 
            
            
if(!$purchase_exempt && (float) $total[0]['referralpending'] != 0 && $val>90) { ?>
<strong>Note:</strong>  You must make a purchase in the next <? 
echo 90-$val;
?> days in order to make $<?php echo $total[0]['referralpending'] ?> in pending referral cash back available. </span>
<?php } else { ?>
<strong>Note:</strong>  Congratulations! Your pending referral cash back will be available as soon as the return period has passed. </span> 
<? } ?>
</td></tr></tbody></table>
	</div>
    <div class="title2">Total Cash Back</div>
	<div class="innerbox">
    <table><tbody><tr><td><strong>Pending :</strong></td><td>${pending}</td></tr><tr><td><strong>Available :</strong></td><td>${available}</td></tr><tr><td><strong>Processing :</strong></td><td>${processing}</td></tr><tr><td><strong>Paid :</strong></td><td>${paid}</td></tr></tbody></table>
	</div>
	{/total}
<?php if((float)$total[0]['available'] > 10) { ?>
        <div class="Request">
<div class="BtnRequestBg BtnRequest"><a class="BtnRequestTxt" href="/account/payment" target="_blank" rel="nofollow">REQUEST A PAYMENT</a></div></div>
        <div class="RequestNote">You can now request a payment!</div>
<?php } else { 
    $dif = number_format(10 - (float)$total[0]['available'],2);
?>

        <div class="Request"><img style="padding-left:50px;padding-top:10px;" src="/images/btn-request-payment-gray.gif"/></div>
        <div class="RequestNote">You need an additional $<? echo $dif ?> to request a payment.</div>
<?php } ?>
	<div style="clear:both;height:10px;"></div>
</div>      
</div>
<!-- Referral Overview -->					
</div>
<!-- Right catagory -->	
   
<!-- /content -->

         
      
   
<!-- footer -->  
    <div style="clear: both;"></div>
    
	<div id="ftr" class="ftrLeftCol">
		<p id="links" style="height: 20px; line-height: 20px;">Copyright © 2010 BeeSavy, LLC. All Rights Reserved. <a href="/stores/storelist">All Stores</a> |  <a href="/info/terms">Terms of Service</a> | <a href="/info/privacy">Privacy Policy</a> | <a href="/info/contact">Contact Us</a></p>
		<a href="http://twitter.com/" target="_blank" class="socialMedia twitter">Follow Us On Twitter</a>
		<a href="http://facebook.com/" target="_blank" class="socialMedia facebook">Like Us on Facebook</a>
		<div style="clear: both;"></div>
		<p id="disclaimer">Tax and shipping costs are estimates; please see the store's website for exact pricing. BeeSavy does not guarantee the 
accuracy of information provided by online stores and other third parties, including product information, prices, coupons, and 
availability. BeeSavy shall not be liable for or responsible to honor any inaccurate information shown on our website. Please see our <a href="">Terms of Service</a> for more details.</p>
	</div>
  </div>
  </div>
<!-- /footer -->  
  
<script>
$(document).ready(function() {
    $("div.SaveChanges").mouseover(function () {
        var element = $(this);
 		element.find('.BtnSaveChangesBg').addClass('BtnSaveChangesRBg').removeClass('BtnSaveChangesBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnSaveChangesRBg').addClass('BtnSaveChangesBg').removeClass('BtnSaveChangesRBg');
    });
	
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
<script src="jquery/jquery_003.js">
</script>



  </body>
  </html>
