  <?php $this->load->view('blocks/header'); ?>
<body>
<div id="container">
    <!-- Navigation bar -->
	<?php if($this->db_session->userdata('login')['login']){ 

	?>

<?php $this->load->view('blocks/admin-topbar'); ?>
<?php }else{

	 ?>
       <?php $this->load->view('blocks/nav_bar'); ?>
   
<?php } ?>
    <!-- /Navigation bar -->
    <!-- content -->

<div class="space20"></div>     <div class="space20"></div>     
<!-- content -->

<section id="help">
            <div class="container">
                <div class="row padding-top">
                    <div class="col-md-3">
                        <div class="row">
    <!-- Left category -->
    <?php $this->load->view('blocks/left_nav'); ?>
    <style type="text/css">
	.message{ width: 82% !important;
margin-left: 114px !important;}
    </style>
    
    
    <!-- /Left category -->
</div>
                    </div>    
                    <div class="col-md-9">

                        <div class="panel panel-successxxx">

                            <div class="panel-body inner">
                                <div class="row">
                                
                                <?php /* if(isset($msg) && $msg!='') {
								 if($msg=='success')
									{
									echo 'success';// exit; 
									} 
									else if($msg=='error') {
										echo 'error';
										//exit;
										}
								}
										*/
									?>
                                    <h3> Contact us</h3>
                                    <div class="space_50"></div>
                                    <div class="col-md-10 col-md-offset-1">
                                    <?php if(($success)) { ?>
                                    
                                    <div class="message alert alert-success" role="alert">
 									<?php echo  $success; ?>
									</div>
                                    <?php } ?>
                                    <?php if(($error)) { ?>
                                    
                                    <div class="message alert alert-danger">
                                      <?php  echo $error; ?>
                                    </div>
                                    <?php } ?>



                                        <div class="panel panel-infoxxx">
                                            <div class="panel-body">
                                                <div class="row">
               <form class="form-horizontal" id="contactForm" name="contactForm" action=<?php echo s3path("/info/contact_submit");?> method="post" enctype="application/x-www-form-urlencoded">

                                                        <div class="form-group ">
                                                            <label class="control-label icon_query_set col-sm-2" for="email"> <i class="fa fa-user"></i> <span></span></label>
                                                            <div class="col-sm-10 query_inline_setting">
                                                                <input required type="text" class="form-control" id="email" placeholder="Enter Name">
                                                            </div>
                                                        </div>    

                                                        <div class="form-group">
                                                            <label class="control-label icon_query_set col-sm-2" for="email"><i class="fa fa-envelope-o"></i> <span></span></label>
                                                            <div class="col-sm-10 query_inline_setting">
                                                                <input required type="email" class="form-control" id="email" placeholder="Enter Email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label icon_query_set col-sm-2" for="pwd"><i class="fa fa-pencil-square-o"></i>  <span></span></label>
                                                            <div class="col-sm-10 query_inline_setting"> 
                                                                <select class="form-control">
                                                                    <option value="1">Subject</option>    
                                                                    <option value="1">Where is My Cashback</option> 
                                                                    <option value="2">Request a Store</option>         
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label s_quer_neew icon_query_set col-sm-2" for="pwd"><i class="fa fa-comment"></i> 
                                                            <span></span></label>
                                                            <div class="col-sm-10 query_inline_setting"> 
                                                                <textarea  required placeholder="Enter Message" rows="3" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-sm-2" for="pwd"> 
                                                            <span></span></label>
                                                            <div class="col-sm-10 s_no_padding_query query_inline_setting"> 
                                                                <input  required class="form-control" name="captcha" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-sm-2" for="pwd">
                                                            <span></span></label>
                                                            <div class="col-sm-10 s_no_padding_query query_inline_setting"> 
                                                                <img src="<?php echo s3path("/info/captcha");?>" />  
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-2" for="pwd"> 
                                                            <span></span></label>
                                                            <div class="col-sm-10 s_no_padding_query query_inline_setting"> 
                                                                 <button type="submit" class="btn btn-danger">Send Message</button>
                                                            </div>
                                                        </div>                     
                                                       
                                                       
                                                       

                                                        
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>  
                                      

                                </div>    

                            </div>
                        </div>






                    </div>    
                </div>    
            </div>

        </section>

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
<!-- footer -->
<?php $this->load->view('blocks/footer'); ?>
<?php $this->load->view('blocks/footer_script'); ?>
</body>
</html>

<!-- /footer -->

