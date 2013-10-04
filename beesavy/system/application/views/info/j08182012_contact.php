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
<? if(($success)) { ?>
<div style="clear:both" class="message success">
{success}
</div>
<? } ?>
                <div class="BGLeftCol" style="border:#00C 0px solid" >
		<!-- page Title -->

		<div id="pageTitle">
		<div id="pageTitleLeft"></div>
		<h1>Help</h1>
		<div id="pageTitleRight"></div>
	</div>
   		<!-- /page Title -->
<!-- Left catagory -->
{side_nav}
        
       <!-- /Left catagory -->
       
       
       <!-- Right side -->
       <div id="results-bottom">
       <div id="results" class="about contact" style="border:0px solid #000;" >
			<div class="title">Contact Us </div>
            <div style="float:left;width:100%;"><hr color="#e96d08" style="margin-left:10px;"></div>
<?php if($success){?>
	<div style="float:left;width:100%;"><P>Thank you for your feedback, we will get back to you as soon as possible.</P></div>
<?php } else { ?>
	<div style="float:left;width:100%;"><P>Before contacting us, be sure to look through our new <A href="/info/faq">FAQ section</A>. If your question is still not resolved, fill out the below form and your question will be routed to the appropriate department.</P></div>
<?php } ?>
<DIV>
<form id="contactForm" name="contactForm" action="/info/contact_submit" method="post" enctype="application/x-www-form-urlencoded">
					<dl style="margin-left:30px;float:left;">
                    <table width=460 border=0>
<tr height=30><td align=right><font size=2><strong>Your Name :&nbsp;&nbsp;</strong> </font></td><td><DD id="name-element" ><INPUT id=name class=optional type=text name=name></DD></td></tr>
 <tr><td align=right height=30><font size=2><strong>Email Address :&nbsp;&nbsp;</strong> </font></td><td><DD id=email-element><INPUT id=email class="required email" type=text name=email></DD></td></tr>
   <tr><td height=30 align=right><dt id="subject-label"><label for="subject" class="required">Subject</label></dt></td><td>
<dd id="subject-element">
<select name="subject" id="subject">
    <option selected="selected" value="Choose a Subject" label="Choose a Subject">Choose a Subject</option>
    <option value="Where is My Cash Back?" label="Where is My Cash Back?">Where is My Cash Back?</option>
    <option value="Request a store" label="Request a store">Request a store</option>
    <option value="Request a charity" label="Request a charity">Request a charity</option>
    <option value="Biz dev/advertising/media" label="Biz dev/advertising/media">Biz dev/advertising/media</option>
    <option value="Trouble Logging In" label="Trouble Logging In">Trouble Logging In</option>
    <option value="Feedback" label="Feedback">Feedback</option>
    <option value="Other" label="Other">Other</option>
</select></dd></td></tr>
  <tr>
  <td align=left><dt id="store_name-label" style="display: block; "><label for="store_name" class="optional">Store Name :</label></dt></td>
  <td><dd id="store_name-element" style="display: block; ">
<select name="store_name" id="store_name">
    <option value="Choose a Store" label="Choose a Store">Choose a Store</option>
    {store_list}
    <option value="{name}">{name}</option>
    
    {/store_list}
</select></dd></td>
  </tr>
<tr><td><dt id="order_number-label" style="display: block; "><label for="order_number" class="optional">Order Number : </label></dt></td>
<td><dd id="order_number-element" style="display: block; "><input type="text" name="order_number" id="order_number" value="" class="required"></dd></td></tr>

<tr ><td><dt id="purchase_subtotal-label" style="display: block; "><label for="purchase_subtotal" class="optional">Purchase Subtotal :</label></dt></td>
<td><dd id="purchase_subtotal-element" style="display: block; "><input type="text" name="purchase_subtotal" id="purchase_subtotal" value="" class="required"> (excluding tax, shipping, coupons)</dd></td></tr>

<tr ><td><dt id="click_id-label" style="display: block; "><label for="click_id" class="optional">Approx. Purchase Date</label></dt><dt id="month-label" style="display: none; "><label for="month" class="optional">Purchase Date</label></dt></td><td>
<dd id="click_id-element" style="display: block; ">
<select name="click_id" id="click_id" class="required">
    <option value="Not Found" label="Don&#39;t See My Purchase Date">Don't See My Purchase Date</option>
</select></dd>

<dd id="month-element" style="display: none; ">
<select name="month" id="month">
    <option value="Choose Month" label="Choose Month">Choose Month</option>
    <option value="01" label="January">January</option>
    <option value="02" label="February">February</option>
    <option value="03" label="March">March</option>
    <option value="04" label="April">April</option>
    <option value="05" label="May">May</option>
    <option value="06" label="June">June</option>
    <option value="07" label="July">July</option>
    <option value="08" label="August">August</option>
    <option value="09" label="September">September</option>
    <option value="10" label="October">October</option>
    <option value="11" label="November">November</option>
    <option value="12" label="December">December</option>
</select></dd>
<dt id="day-label" style="display: none; ">&nbsp;</dt>
<dd id="day-element" style="display: none; ">
<select name="day" id="day">
    <option value="Choose Day" label="Choose Day">Choose Day</option>
    <option value="1" label="1">1</option>
    <option value="2" label="2">2</option>
    <option value="3" label="3">3</option>
    <option value="4" label="4">4</option>
    <option value="5" label="5">5</option>
    <option value="6" label="6">6</option>
    <option value="7" label="7">7</option>
    <option value="8" label="8">8</option>
    <option value="9" label="9">9</option>
    <option value="10" label="10">10</option>
    <option value="11" label="11">11</option>
    <option value="12" label="12">12</option>
    <option value="13" label="13">13</option>
    <option value="14" label="14">14</option>
    <option value="15" label="15">15</option>
    <option value="16" label="16">16</option>
    <option value="17" label="17">17</option>
    <option value="18" label="18">18</option>
    <option value="19" label="19">19</option>
    <option value="20" label="20">20</option>
    <option value="21" label="21">21</option>
    <option value="22" label="22">22</option>
    <option value="23" label="23">23</option>
    <option value="24" label="24">24</option>
    <option value="25" label="25">25</option>
    <option value="26" label="26">26</option>
    <option value="27" label="27">27</option>
    <option value="28" label="28">28</option>
    <option value="29" label="29">29</option>
    <option value="30" label="30">30</option>
    <option value="31" label="31">31</option>
</select></dd>
<dt id="year-label" style="display: none;">&nbsp;</dt>
<dd id="year-element" style="display: none; ">
<select name="year" id="year">
    <option value="2011" label="2011">2011</option>
</select></dd></td></tr>


<tr ><td><dt id="message-label"><label for="message" class="required">Message</label></dt></td>
<td><dd id="message-element">
<textarea name="message" id="message" class="required" rows="8" cols="40"></textarea></dd></td></tr>

<tr><td colspan=2><dt id="submit-label">&nbsp;</dt>
<DD><div class="SendMessage"><div class="BtnSendMessageBg BtnSendMessage"><INPUT type="submit" name="" value=""/></div></div></dd></dl></td></tr></table>
  </FORM>
  <div id="eligibility" style="display: block; ">
					<p>Please keep in mind that your purchase may not be eligible for cash back if:</p>
					<ul>
						<li>You used a coupon from another website or from an email directly from the merchant</li>
						<li>You added the item(s) to your shopping cart BEFORE clicking through from Beesavy</li>
						<li>Your purchase was for a gift card or was paid for with a gift card</li>
						<li>You used Google Checkout to pay for the order</li>
						<li>You closed your web browser window before completing your purchase</li>
						<li>Your browser is not configured to accept cookies</li>
					</ul>
					<br>
					<p>For the complete terms and conditions, please see the <a href="http://www.beesavy.com/info/terms">Beesavy Terms of Service</a></p>
				</div>
  
</DIV>
</DIV>
		<div style="clear: both;"></div>
        </div>
		<div style="clear: both;"></div>

       <!-- Right side -->




<!-- /content -->
    
	<script language="javascript">
function hideCashbackFields()
{
	$("#store_name-element").hide();
	$("#store_name-label").hide();
	
	$("#order_number-element").hide();
	$("#order_number-label").hide();
	
	$("#purchase_subtotal-element").hide();
	$("#purchase_subtotal-label").hide();
	
	$("#click_id-element").hide();
	$("#click_id-label").hide();
	
	hidePurchaseDateFields();
	
	$("#eligibility").hide();
}

function showCashbackFields()
{
	$("#store_name-element").show();
	$("#store_name-label").show();
	
	$("#order_number-element").show();
	$("#order_number-label").show();
	
	$("#purchase_subtotal-element").show();
	$("#purchase_subtotal-label").show();
	
    showPurchaseDateFields();
    /*
	$("#click_id-element").show();
	$("#click_id-label").show();
     */
	
	$("#eligibility").show();
}

function showPurchaseDateFields()
{
	$("#month-element").show();
	$("#month-label").show();
	
	$("#day-element").show();
	$("#day-label").show();
	
	$("#year-element").show();
	$("#year-label").show();
}

function hidePurchaseDateFields()
{
	$("#month-element").hide();
	$("#month-label").hide();
	
	$("#day-element").hide();
	$("#day-label").hide();
	
	$("#year-element").hide();
	$("#year-label").hide();
}

function changeMessageToOrderConfirm()
{
	// Get the current message label
	var messageLabel = $("#message-label > label");
	
	// Change it to say Order Confirmation
	messageLabel.text("Order Confirmation");
	
	// Give the user some prompt text in the text area
	var messageBox = $("#message-element > textarea");
	messageBox.text("Please copy and paste your order invoice or receipt here");
}

function resetMessageBox()
{
	// Get the current message label
	var messageLabel = $("#message-label > label");
	
	// Change it back to Message
	messageLabel.text("Message");
	
	// Get rid of the prompt in the message box
	var messageBox = $("#message-element > textarea");
	messageBox.text("");
}

function checkForCashbackSubject()
{
	// Get the currently selected subject
	var selected = $("#subject option:selected");
	
	// If the subject is "Where's My Cashback?" show the extra fields & change message to order confirmation
	if (selected.text() == "Where is My Cash Back?") {
		// Check if the user is logged in, first
		if (isLoggedIn()) {
			showCashbackFields();
			changeMessageToOrderConfirm();
		} else {
			// If not logged in, redirect to login page
			alert("Please login to report missing cashback");
			window.location="" + "/users/login";
		}
	} else {
		// If the subject is not cashback, hide the extra fields & reset the message box
		hideCashbackFields();
		resetMessageBox();
	}
}

function isLoggedIn()
{
	var loggedIn = "1";
	
	if (loggedIn == '1') {
		return true;
	}
	
	return false;
}

function prependDollarSignToSubtotal()
{
	// Get the contents of the purchase subtotal wrapper element
	var oldContents = $("#purchase_subtotal-element").html();
	
	// Prepend a $ to the contents
	var newContents = '$' + oldContents + ' (excluding tax, shipping, coupons)';
	
	// Set the contents of the wrapper element to the $+ text
	$("#purchase_subtotal-element").html(newContents);
}

function isDatePastDue()
{
	// Get the current date
	var currentDate = new Date();
	
	// Calculate date 90 days ago
	var ninetyDate = new Date();
	ninetyDate.setDate(currentDate.getDate()-90);
	
	// Get the date the user entered
	var clickDate = $("#click_id option:selected").text();
	var userYear;
	var userMonth;
	var userDay;
	
	if (clickDate == "Don't See My Purchase Date") {
		userYear = $("#year").val();
		userMonth = $("#month").val();
		userDay = $("#day").val();
	} else {
		var clickDateArray = clickDate.split(" ");
		var clickDateSubString = clickDateArray[0];
		var dateArray = clickDateSubString.split("-");
		
		userYear = dateArray[2];
		userMonth = dateArray[0];
		userDay = dateArray[1];
	}
	
	var userDate = new Date();
	
	userDate.setFullYear(userYear, (userMonth - 1), userDay);
	
	// If the user's date is earlier than the 90 days ago date, reject it
	if (userDate < ninetyDate) {
		return true;
	}
	
	return false;
}

function isDateTooSoon()
{
	// Get the current date
	var currentDate = new Date();
	
	// Calculate date 4 days ago
	var fourDate = new Date();
	fourDate.setDate(currentDate.getDate()-4);
	
	// Get the date the user entered
	var clickDate = $("#click_id option:selected").text();
	var userYear;
	var userMonth;
	var userDay;
	
	if (clickDate == "Don't See My Purchase Date") {
		userYear = $("#year").val();
		userMonth = $("#month").val();
		userDay = $("#day").val();
	} else {
		var clickDateArray = clickDate.split(" ");
		var clickDateSubString = clickDateArray[0];
		var dateArray = clickDateSubString.split("-");
		
		userYear = dateArray[2];
		userMonth = dateArray[0];
		userDay = dateArray[1];
	}
	
	var userDate = new Date();
	
	userDate.setFullYear(userYear, (userMonth - 1), userDay);
	
	// If the user's date is less than 4 days ago, reject it
	if (userDate > fourDate) {
		return true;
	}
	
	return false;
}

function cashbackFieldsNotValid()
{	
	// Check each of the extra fields for valid values
	
	// If any field is missing a value, return true
	var storeName = $("#store_name option:selected").val();
	
	if ($.trim(storeName) == "Choose a Store") {
		return true;
	}
	
	var orderNumber = $("#order_number").val();
	
	if ($.trim(orderNumber) == "") {
		return true;
	}
	
	var clickId = $("#click_id").val();
	var chosenMonth = $("#month option:selected").val();
	var chosenDay = $("#day option:selected").val();
	
    /*
	if ($.trim(clickId) == "" || $.trim(clickId) == "None") {
		return true;
	} else if ((clickId == "Not Found") && (chosenMonth == "Choose Month" || chosenDay == "Choose Day")) {
		return true;
	}
     */
	
	var purchaseSubtotal = $("#purchase_subtotal").val();
	
	if ($.trim(purchaseSubtotal) == "") {
		return true;
	}
	
	var orderConfirmation = $("#message").val();
	
	if ($.trim(orderConfirmation) == "Please copy and paste your order invoice or receipt here" || $.trim(orderConfirmation) == "") {
		return true;
	}
	
	// Otherwise, return false
	return false;
}

function populateClickId()
{
	// Get the current store name
	var storeName = $("#store_name option:selected").val();
	
	// Send an ajax request to get the clicks associated with this user and that store
	if ($.trim(storeName) != "Choose a Store") {
	
		$.getJSON('/help/findclicksbystore/store/' + storeName, function(data) {
			// Add each click to the click_id dropdown
			if (data != null) {
				$("#click_id").empty();
				for (var i = 0; i < data.length; i++) {
					$("#click_id").append('<option value="' + data[i].id + '|' + data[i].created + '">' + data[i].created + '</option>');
				}
				
				$("#click_id").append('<option value="Not Found">Don\'t See My Purchase Date</option>');
			}
		});
	}
}

function addHelpTextToClickIdLabel()
{
	// Wrap the text in the click id label in a abbr tag + title info for pop-up help
	var storeName = $("#store_name option:selected").val();
	$("#click_id-label > label").wrapInner('<abbr title="Please choose which of the following dates you clicked from Beesavy to ' + storeName +' to make your purchase."></abbr>');
}

function checkForDateNotFound()
{
	// Get the selected click id field
	var selectedClickId = $("#click_id option:selected").val();
	
	// If its value is "Not Found," reveal the manual purchase date fields
	if (selectedClickId == "Not Found") {
		showPurchaseDateFields();
	} else {
		hidePurchaseDateFields();
	}
}

$(document).ready(function() {
	// Hide all the fields dealing with the "Where's My Cashback?" subject
	hideCashbackFields();
	
	// Add handler to subject select to check for "Where's My Cashback?" being selected
	$("#subject").change(function() {
		checkForCashbackSubject();
	});
	
	// Prepend a $ to the purchase subtotal field
	prependDollarSignToSubtotal();
	
	// Add a handler to validate the form upon submit
	$("#contactForm").submit(function (cfs) {
		// If the subject is cashback, check the extra fields and the date
		var currentSubject = $("#subject option:selected").val();
		
		if (currentSubject == "Where is My Cash Back?") {
			// If the extra fields aren't filled in, reject it
			if (cashbackFieldsNotValid()) {
				cfs.preventDefault();
				alert("Please fill out all required fields to help us investigate your purchase.");
			}
	
			// If the purchase date is less than 4 days ago, reject it
			if (isDateTooSoon()) {
				cfs.preventDefault();
				alert("Please allow at least 4 days from the purchase date for your cash back to post to your Beesavy account");
			}
		
			// If the purchase date is more than 90 days ago, reject it
			if (isDatePastDue()) {
				cfs.preventDefault();
				alert("If your order is over 90 days old, Beesavy is unfortunately unable to investigate");
			}
		}
	});
	
	// Add a handler to populate the click id field if the user chooses a store
	$("#store_name").change(function() {
		populateClickId();
		addHelpTextToClickIdLabel();
	});
	
	// Add a handler to reveal the manual purchase date entry fields if the user can't find their purchase date by click id
	$("#click_id").change(function() {
		checkForDateNotFound();
	});
});
</script>
	<script>
	
$(document).ready(function() {
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
	
	    $("div.SendMessage").mouseover(function () {
        var element = $(this);
 		element.find('.BtnSendMessage').addClass('BtnSendMessageRBg').removeClass('BtnSendMessageBg');
    }).mouseout(function () {
    	var element = $(this);
		element.find('.BtnSendMessageRBg').addClass('BtnSendMessageBg').removeClass('BtnSendMessageRBg');
    });
	
	});
</script>
         
      
   
<!-- footer -->  
    {footer}
  </div>
<!-- /footer --> 
  




  </body>
  </html>
