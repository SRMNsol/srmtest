

<?php $this->load->view('blocks/header'); ?>
<body>
<div id="container">
    <!-- Navigation bar -->
<?php $this->load->view('blocks/admin-topbar'); ?>
<!-- /Navigation bar -->

    <?php echo googletag_ad("BS_account_728x90_1") ?>

    <!-- content -->
<style type="text/css">
.mar-top{ margin-top: 5px !important;}
.mar-bot{ margin-top: -5px !important;
margin-bottom: 18px !important;}
</style>

<script type="text/javascript">
window.sendinblue=window.sendinblue||[];window.sendinblue.methods=["identify","init","group","track","page","trackLink"];window.sendinblue.factory=function(e){return function(){var t=Array.prototype.slice.call(arguments);t.unshift(e);window.sendinblue.push(t);return window.sendinblue}};for(var i=0;i<window.sendinblue.methods.length;i++){var key=window.sendinblue.methods[i];window.sendinblue[key]=window.sendinblue.factory(key)}window.sendinblue.load=function(){if(document.getElementById("sendinblue-js"))return;var e=document.createElement("script");e.type="text/javascript";e.id="sendinblue-js";e.async=true;e.src=("https:"===document.location.protocol?"https://":"http://")+"s.sib.im/automation.js";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)};window.sendinblue.SNIPPET_VERSION="1.0";window.sendinblue.load();window.sendinblue.client_key="1n0l4my1w3ubrs1l0iy5j";window.sendinblue.page();

</script>

<?php if(isset($_GET['email'])){
	?>	   
<script>
sendinblue.identify('<?php echo $_GET['email']; ?>', {
  'name': 'Beesavy Account',
  //'id': '10002',
	// 'mobile' : '+12025550153',
  'plan' : 'Free',
  'location' : 'Pakistan'
});
</script>
<?php } ?>
    <!-- START CONTENT --><br>
    <section id="account_beesavy">

        <?php
		
		//echo 'dddddddddd'; exit;
		
        $payment_radio = array('', '', '');
        if ($payment_method == "CHECK") {
            $payment_radio = array('checked', '', '');
        } elseif ($payment_method == "PAYPAL") {
            $payment_radio = array('', 'checked', '');
        } elseif ($payment_method == "CHARITY") {
            $payment_radio = array('', '', 'checked');
        }
        ?>
        <div class="container">
        <?php if(!empty($errors)) { ?> <div class="space20"></div><?php } ?>
           <?php if(!empty($notice)) { ?> <div class="space20"></div><?php } ?>
              <?php if(!empty($success)) { ?> <div class="space20"></div><?php } ?>
            <div class="row msg-row">
				<div class="col-md-12">
                <?php if(!empty($errors)) { ?>
                <div class="alert alert-danger" style="width:100%"> 
					{errors}
                    {message}
                    {/errors}</div>
                <?php } ?>
                <?php if(isset($success)) { ?>
                <div class="alert alert-success" style="width:100%">{success}</div>
                <?php } ?>
                <?php if(isset($notice)) { ?>
                <div class="alert alert-warning" style="width:100%">{notice}</div>
                <?php } ?>
				</div>
            </div>   <div class="space20"></div>
            <div class="row" style="position: relative;top:-20px;">

                <div class="col-md-9">

                        <div class=" top_buttons">
                            <ul>
                                <li class="active">
                                    <a class="btn btn_bee_savy" href="<?php echo s3path('/account');?>"> Settings </a>
                                </li>
                                <li>
                                    <a class="btn btn_bee_savy" href="<?php echo s3path('/cashback');?>"> Cash Back </a>
                                </li>
                                <li>
                                    <a class="btn btn_bee_savy" href="<?php echo s3path('/tools');?>"> Referrals </a>
                                </li>
                            </ul>
                        </div>


                    <div class="boxi"><h5 class="adminpadding"> Edit Payment Method</h5></div>
                    <div class="bee_box">
                    <form class="form-horizontal" id="charityPaymentForm" name="charityPaymentForm"
                                      action=<?php echo s3path("/account/edit_payment");?>
                                      method="post">
                        <div class="space30"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 no-padding" id="border_right_account">
                                <div class="row">
                                    <div class="bee_box_title">
                                        <h4>
                                       <!-- <input name="method" <?php // echo $payment_radio[0]?> id="check" type="radio"
                                                   onclick="$('.slideBoxContainer').hide();$('#form-second').show();$('#MailMe').find('.slideBoxContainer').slideDown('slow');">-->
                                            Mail me a check</h4>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class=" slideBox closed" id="MailMe">
                                        <div  class="slideBoxContainer">
                                          
                                                <INPUT id=paymentType value=check type=hidden name=paymentType>
                                                <INPUT type=hidden name=pmethod value="check">
                                                
                                                <div class="form-group">
                                                    <label class=" col-sm-1 col-xs-1" for="email"><i
                                                                class="fa fa-user fa-2x"></i>
                                                        <!--<span>Enter Your Name</span>--></label>
                                                    <div class="col-sm-11 col-xs-11">
                                                        <input type="text" class="form-control" id=firstName tabIndex=1
                                                               name=first_name value="{first_name}"
                                                               placeholder="Enter Full Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 col-xs-1" for="pwd"><i
                                                                class="fa fa-home fa-2x"></i>
                                                        <!--<span>Enter Adress </span> --></label>
                                                    <div class="col-sm-11 col-xs-11 ">
                                                        <input type="text" class="form-control" id=street tabIndex=3
                                                               name=street value="{address}" placeholder="Enter Adress">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 col-xs-2" for="pwd"><i
                                                                class="fa fa-address-card fa-2x"></i>
                                                        <!--<span>City /Zip State</span>--> </label>
                                                    <div class="col-md-10 ">
                                                        <div class="row">
                                                            <div class="col-sm-6 col-xs-5 ">
                                                                <input type="text" class="form-control" id=city
                                                                       tabIndex=4 name=city value="{city}"
                                                                       placeholder="Enter City">
                                                            </div>
                                                            <div class="col-sm-6 col-xs-5 no-padding ">
                                                                <input type="text" class="form-control" id=zip
                                                                       tabIndex=6 name=zip value="{zip}"
                                                                       placeholder="Enter Zip">
                                                                <input type="hidden" name="city" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            

                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 custom_query_class_new">
                                <div class="slideBox closed" id="Paypal">
                                    <div class="bee_box_title">
                                        <h4><!--<input name="method" <?php echo $payment_radio[1]?> id="paypal" type="radio"
                                                   onclick="$('.slideBoxContainer').hide();$('#form-second').show();$('#Paypal').find('.slideBoxContainer').slideDown('slow');">-->
                                            Paypal</h4>
                                    </div>
                                    <div class="row account-padding">
                                        <div class="col-md-1 col-sm-1 col-xs-1">
                                            <i class="fa fa-cc-paypal fa-2x"></i>
                                        </div>
                                        <div class="col-md-11 col-sm-11 col-xs-11 sign_up_mquery">
                                            <a href="http://paypal.com/" target="_blank">Sign Up Here</a>

                                        </div>
                                    </div>
                                    <div class="row slideBoxContainer">
                                      
                                            <input id="paymentType" name="pmethod" value="paypal" type="hidden">
                                            
                                            <!-- <div class="space10"></div> -->
                                            <div class="form-group">
                                                <label class=" col-sm-1 col-xs-1" for="email"><i
                                                            class="fa fa-envelope fa-2x"></i>
                                                    <!--<span> Enter Your Email</span>--> </label>
                                                <div class="col-sm-11 col-xs-11">
                                                    <input type="text" class="form-control" id="paypalEmail"
                                                           name="paypalEmail" value="{paypal_email}"
                                                           placeholder="Enter Paypal Email Address ">
                                                </div>
                                            </div>
                                        
                                    </div>
                                </div>


                            </div>
                        </div>
                        <hr>
                        <div id="Charity" class="slideBox closed row">
                            <div class="bee_box_title">

                                <h4><!--<input name="method" <?php echo $payment_radio[2]?> id="charity" type="radio"
                                           onclick="$('.slideBoxContainer').hide();$('#form-second').hide();$('#Charity').find('.slideBoxContainer').slideDown('slow');">-->Donate
                                    to a Charity</h4>
                            </div>

                            <div class="row">
                                <div class="rightmargin">
                                    <p>Select the Charity of Your Choice and BeeSavy will donate when you request a
                                        payment.</p>
                                </div>
                            </div>
                            <br>
                             <button style="display:none" id="form-second" type="submit" class="btn btn-danger pull-right">Save Changes
                                            </button>
                            <div class="row slideBoxContainer">
                                
                                    <div class="form-group">
                                        <label class="control-label spanfontsize col-sm-3" for="email"><i
                                                    class="fa fa-star-o"></i> <span> Select Charity</span> </label>
                                        <div class="col-sm-9 no-padding">
                                            <select id="charity_id" name="charity_id" class="form-control">
                                                <?php
                                                foreach ($charities as $charity) {
                                                    printf('<option value="%s" %s>%s</option>',
                                                        escape($charity->getId()),
                                                        $charity_id == $charity->getId() ? 'selected="selected"' : '',
                                                        escape($charity->getName())
                                                    );
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="space10"></div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-danger pull-right">Save Changes
                                            </button>
                                        </div>
                                    </div>
                              
                            </div>
                        </div>
                        </form>
                    </div>

                    <div class="bee_payment_method">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="boxi"><h5 class="adminpadding"> Edit Social Media </h5></div>
                                <div class="bee_box">
                             

                                    <form id=changeNewsletterForm method=post name=changeNewsletterForm
                                          action="<?php echo s3path('/account/set_setting');?>">
                               
                                         <input name="setting" value="facebook_auto" type="hidden">


                                        <div class="space30"></div>

                                        <div class="row">
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"
                                                               style=" text-align: center; font-size: 27px; color: #c23115; padding: 0px 15px; "></i></a>
                                            </div>
                                            <div class="col-md-10 col-sm-10 col-xs-10">
                                                <p><input id=newsletter value=1 onClick="this.form.submit();"
                             <?php if ($facebook_auto) echo "CHECKED"?> type=checkbox name=value> Post Cash Back to Facebook </p>
                                            </div>
                                        </div>
                                    </form>


                           <form id=changeNewsletterForm method=post name=changeNewsletterForm action="<?php echo s3path('/account/sett_setting');?>">
                                        <input name="setting" value="twitter_auto" type="hidden">
                                        <div class="space10"></div>
                                        <div class="row">
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"
                                                             style=" text-align: center; font-size: 27px; color: #c23115; padding: 0px 15px; "></i></a>
                                            </div>
                                            <div class="col-md-10 col-sm-10 col-xs-10">
            <p><input onClick="this.form.submit();" id=newsletter value=1 <?php if($twitter_auto) echo"CHECKED"?> type=checkbox
                                                          name=value> Post Cash Back to Twitter </p>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="space10"></div>
                                    <div class="row">
                                        <p><strong> Note: </strong> No personal information such as where you shopped or
                                            what you purchased will be shared.</p>
                                    </div>
                                    <div class="space10"></div>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-danger pull-right">Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space20"></div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="boxi "><h5 class="adminpadding"> Edit Referral Alias </h5></div>
                                <div class="bee_box ref-code">
                                    <div class="space20"></div>
                                    <div class="row">


                                        <div class="row">
                                            <form class="form-horizontal" id=changeEmailForm method=post
                                                  name=changeEmailForm
                                                  action=<?php echo s3path('/account/set_alias'); ?>>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-7 no-padding" for="email"><i
                                                                class=""></i> <h5> Current Referral ID Alias :</h5>
                                                    </label>
                                                    <div class="col-sm-5 no-padding">
                                                        <h4 style=" padding-top: 7px;">{alias}</h4>
                                                    </div>
                                                </div>
                                                <div class="space10"></div>

                                                <div class="form-group">
                                                    <!-- <label class="control-label col-sm-1 no-padding" for="email"><i class=""></i> <span>New Referral ID Alias:</span></label>-->
                                                    <div class="col-sm-12 no-padding">
                                                        <input type="text" placeholder="New Referral ID Alias"
                                                               class="form-control" tabIndex=10 type=text name=email>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <!-- <label class="control-label col-sm-5 no-padding" for="email"><i class=""></i> <span>Confirm New Referral ID Alias: </span></label>-->
                                                    <div class="col-sm-12 no-padding">
                                                        <input type="text" placeholder=" Confirm New Referral ID Alias"
                                                               class="form-control" tabIndex=11 type=text
                                                               name=email_confirm>
                                                    </div>
                                                </div>
<div class="space20"></div>
 <div class="space10"></div> 

                                                <div class="form-group mar-top">
                                                    <div class="col-sm-12">
                                                        <button type="submit" name="" class="btn btn-danger pull-right">
                                                            Save
                                                            Changes
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bee_payment_method">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="boxi"><h5 class="adminpadding"> Change Paranthesis </h5></div>
                                <div class="bee_box">
                                    <div class="space30"></div>

                                    <form id=changeNewsletterForm method=post name=changeNewsletterForm
                                          action=<?php echo s3path('/account/set_email_setting');?>>
                                        <div class="row">
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <a href="#"><i class="fa fa-envelope" aria-hidden="true"
                                                               style=" text-align: center; font-size: 27px; color: #c23115; padding: 0px 15px; "></i></a>
                                            </div>
                                            <div class="col-md-10 col-sm-10 col-xs-10">
                                                <p><input id=newsletter value=1
                                                          <?php if ($send_reminders) echo "CHECKED"?> type=checkbox
                                                          name=send_reminders> Please notify me occasionally of
                                                    special offers from BeeSavy.</p>
                                            </div>
                                        </div>
                                        <div class="space20"></div>
                                        <div class="row">
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <a href="#"><i class="fa fa-newspaper-o" aria-hidden="true"
                                                               style=" text-align: center; font-size: 27px; color: #c23115; padding: 0px 15px; "></i></a>
                                            </div>
                                            <div class="col-md-10 col-sm-10 col-xs-10">
                                                <p><input id=newsletter value=1
                                                          <?php if ($send_updates) echo "CHECKED"?> type=checkbox
                                                          name=send_updates> Please notify me of special partner
                                                    offers.</p>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-danger pull-right"
                                                        style="margin-top: 30px;">Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!--  <div class="row">

                                         <div class="space10"></div>
                                         <p><input type="checkbox" checked=""> Please notify me occasionally of special offers from BeeSavy.</p>
                                         <div class="space10"></div>
                                         <p><input type="checkbox" checked=""> Please notify me of special partner offers.</p>

                                     </div> -->

                                    <div class="space_50"></div>

                                    <div class="space20"></div>

                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="boxi"><h5 class="adminpadding"> Email Settings </h5></div>
                                <div class="bee_box">
                                    <div class="row">


                                        <div class="space20"></div>

                                        <div class="row">
                                            <form class="form-horizontal" id=changeEmailForm method=post
                                                  name=changeEmailForm
                                                  action=<?php echo s3path('/account/set_email'); ?>>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-5" for="email"><span> Current Email ID:</span>
                                                    </label>
                                                    <div class="col-sm-7 no-padding" style="padding: 7px 0;">
                                                        <span class="bb">{email}
                                                    </span></div>

                                                </div>


                                                <div class="form-group">
                                                    <label class="control-label col-sm-5" for="email"><span>New Email ID:</span>
                                                    </label>
                                                    <div class="col-sm-7 no-padding">
                                                        <input type="text" class="form-control" tabIndex=12 name=email
                                                               placeholder="Enter E-mail Address">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-5" for="email"><span>Confirm Email ID:</span>
                                                    </label>
                                                    <div class="col-sm-7 no-padding">
                                                        <input type="text" class="form-control" tabIndex=13 type=text
                                                               name=email_confirm
                                                               placeholder="Re-Enter Email">

                                                <input type="hidden" value="{email}" name="oldemail">

                                                    </div>
                                                </div>

                                                <!-- <div class="space10"></div> -->
<div class="space20"></div>  <div class="space20"></div>
                                                <div class="form-group mar-bot">
                                                    <div class="col-sm-12">
                                                        <button type="submit" class="btn btn-danger pull-right">Save
                                                            Changes
                                                        </button>
                                                    </div>
                                                </div>
                                              

                                            </form>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bee_payment_method">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="boxi"><h5 class="adminpadding"> Change Password </h5></div>
                                <div class="bee_box">
                                    <div class="space30"></div>
                                    <div class="row">

                                        <div class="row">
                                     
            <form class="form-horizontal" id="changePasswordForm" method="post" name="changePasswordForm" action="<?php echo s3path('/account/set_password'); ?>">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="email"><span> Current Password: </span>
                    </label>
                    <div class="col-sm-9 no-padding">
                        <input class="form-control" tabIndex=14 type="password" name="password_current" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="email"><span> New Password: </span>
                    </label>
                    <div class="col-sm-9 no-padding">
                        <input class="form-control" type="password" name="password_new" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="email"><span> Confirm Password: </span>
                    </label>
                    <div class="col-sm-9 no-padding">
                        <input type="password" name="password_confirm" class="form-control" placeholder="">
                         <input type="hidden" value="{email}" name="passemail">
                    </div>
                </div>



                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-danger pull-right">Save
                            Changes
                        </button>
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
                <div class="col-md-3">
                    <!-- rightnav-included -->

                    <?php  $this->load->view('blocks/rightnav'); ?>
                    <div class="space10"></div>
                    <div class="row show_tv_only">
                        <a href="#">
                            <?php echo googletag_ad('BS_account_300x600') ?>
                        </a>
                        <div style="background-color: rgba(0, 0, 0, 0.05);"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- account setting -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="2411487774"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
                        </div>

                    </div>
                </div>

            </div>
            <div class="space_50"></div>
        </div>

    </section>

    <!-- END CONTENT -->

<?php $this->load->view('blocks/footer'); ?>

<?php $this->load->view('blocks/footer_script'); ?>
<?php echo googletag_ad('BS_account_728x90_2') ?>
<!-- /footer -->

    <script>
	$(document).ready(function() {
  // $('.slideBoxContainer').slideDown('slow');
});
	
        $(window).load(function () {
			
		
			
            mCustomScrollbars();
        });

        function mCustomScrollbars() {
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
            $("#mcs_container").mCustomScrollbar("vertical", 400, "easeOutCirc", 1.05, "auto", "yes", "yes", 10);
            $("#mcs2_container").mCustomScrollbar("vertical", 0, "easeOutCirc", 1.05, "auto", "yes", "no", 0);
            $("#mcs3_container").mCustomScrollbar("vertical", 900, "easeOutCirc", 1.05, "auto", "no", "no", 0);
            $("#mcs4_container").mCustomScrollbar("vertical", 200, "easeOutCirc", 1.25, "fixed", "yes", "no", 0);
            $("#mcs5_container").mCustomScrollbar("horizontal", 500, "easeOutCirc", 1, "fixed", "yes", "yes", 20);
        }

        /* function to fix the -10000 pixel limit of jquery.animate */
        $.fx.prototype.cur = function () {
            if (this.elem[this.prop] != null && (!this.elem.style || this.elem.style[this.prop] == null)) {
                return this.elem[this.prop];
            }
            var r = parseFloat(jQuery.css(this.elem, this.prop));
            return typeof r == 'undefined' ? 0 : r;
        }

        /* function to load new content dynamically */
        function LoadNewContent(id, file) {
            $("#" + id + " .customScrollBox .content").load(file, function () {
                mCustomScrollbars();
            });
        }
    </script>

</body>
</html>
