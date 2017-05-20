<!-- Header -->

<?php $this->load->view('blocks/header'); ?>
<!-- /Header -->

<body>

<style type="text/css">
.ref-btn{ margin-top:15px !important;}
</style>

<style>.btn_bee_savy {
    background-color: #c23115;
    color: #fff;
    border-radius: 0px;
    padding: 5px 40px;
    border: 1px #c23115 solid;
    vertical-align: initial;
}.top_buttons{
	
}
#more-ref{ cursor: pointer; }
  #help_reffral{  margin-top: 40px !important; }
}


.btn-danger {
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
}
.btn-danger:hover {
    color: #fff;
    background-color: #c9302c;
    border-color: #ac2925;
}
 #bee_Modal .form-horizontal .form-group{
  margin: 0px;
  margin-bottom: 15px;r
   }
 #bee_Modal .form-horizontal .form-group:last-child{
  margin: 0px;
  margin-bottom: 30px;r
   }
</style>
<div id="container">
    <!-- Navigation bar -->
<?php $this->load->view('blocks/admin-topbar'); ?>
<!-- /Navigation bar -->
<!-- content -->

<?php // echo '<pre>'; print_r($allref); exit;?>

 <section id="help_reffral">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9">
                            
                            

                            <div class="row">
                                <div class="top_buttons">
                               		<ul>
                                            <li>
                                                <a class="btn btn_bee_savy" href="<?php echo SURL?>account"> Settings </a>
                                            </li>
                                            <li>
                                                <a class="btn btn_bee_savy" href="<?php echo SURL?>cashback"> Cash Back </a>
                                            </li>
                                            <li class="active">
                                                <a class="btn btn_bee_savy" href="<?php echo s3path('/tools'); ?>"> Referrals </a>
                                            </li>
                                	</ul>
                            	</div>
                            </div>
                                
                                
                                
                                    <div class="space20"></div>
                                
                                <div class="row">
                                    <div class="inner_title">
                                        <h3>Refer Friends and Earn Commision Forever!</h3>
                                    </div>
                                    <div class="space20"></div>
                                    
                                    <div class="bee_payment_method">
                                        <div class="row">
                                         <fieldset class="feild_property">
                                            <form id="facetForm" name="facetForm" action="//categories?category=62" method="get">
</form>
                                               
                                                    <legend class="legend_property">
                                                        <label class="invite_others">Invite Your Friends</label>
                                                    </legend>

                                                     <h4 class="text-center">Invite By Email</h4>
                                                     <div class="space20"></div>

                                                       <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="col-md-2"></div>
                                                            <div class="input-group col-md-8 text-center">
                                                              <input type="text" class="form-control" value="<?php echo s3path('/tools/'); ?>{alias}" placeholder="Share Your Unique Referral Link" style=" border: solid 1px #c23115; ">
                                                              <span class="input-group-addon no-padding" id="basic-addon2" style=" border: none; ">
        <a id='send-link' class="btn ben-default" data-toggle="modal" data-target="#bee_Modal"
                                                              style="border: solid 1px #c23115; background: #c23115; color: white; margin: 0px; border-radius: 0;     position: relative;"><i class="fa fa-send" style="margin-right: 10px;"></i>send</a class="btn ben-default"></span>
                                                        </div>
                                                        </div>
                                                    </div>


<div id="bee_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Send Invitation to Friends</h3>
      </div>
      <div class="row modal-body">
        <form class="form-horizontal col-sm-12" id="emailForm">
          <div class="form-group"><label> <h4> E-Mail I</h4></label><input name="emails[]" class="form-control email" placeholder="email@you.com (so that we can contact you)" data-placement="top" data-trigger="manual" data-content="Must be a valid e-mail address (user@gmail.com)" type="text" style=" border: solid 1px #c23115; box-shadow: none;"></div>
          <div class="form-group"><label> <h4> E-Mail I</h4></label><input name="emails[]" class="form-control email" placeholder="email@you.com (so that we can contact you)" data-placement="top" data-trigger="manual" data-content="Must be a valid e-mail address (user@gmail.com)" type="text" style=" border: solid 1px #c23115; box-shadow: none;"></div>
          <div class="form-group"><label> <h4> E-Mail III</h4></label><input name="emails[]" class="form-control email" placeholder="email@you.com (so that we can contact you)" data-placement="top" data-trigger="manual" data-content="Must be a valid e-mail address (user@gmail.com)" type="text" style=" border: solid 1px #c23115; box-shadow: none;"></div>
          <div class="form-group">
          <button type="submit" id="emailBtn" data-loading-text="Sending..." class="btn btn-danger pull-right">Send Email</button> 
          <input type="hidden" name="link" value="<?php echo s3path('/tools'); ?>/{alias}">
          </div>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
                                                   <!--  <div class="row">
                                                        <h4 class="text-center">Invite by Email</h4>
                                                        <div class="space20"></div>
                                                        <div class=" col-md-offset-3 col-md-5">
                                                         <input type="text" placeholder="Enter email addresses separated by commas" class="form-control" id="name" style="border: solid 1px #c23115;">
                                                        </div>
                                                        <div class=" col-md-3 no-padding">
                                                        <a class="btn btn-danger" data-toggle="modal" data-target="#bee_Modal"><i class="fa fa-send"></i> Send </a>
                                                        </div> </div> -->


                                                         
                                                   
                                                    <div class="space30"></div>
                                                    <h4 class="text-center">Share Your Personal Link</h4>
                                                    <div class="space20"></div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="col-md-2"></div>
                                                            <div class="input-group col-md-8 text-center">

                                                              <input id="persnol-share" type="text"  class="form-control" placeholder="Share Your Unique Referral Link" style=" border: solid 1px #c23115;" id="signature" value="<a href='<?php echo s3path('/tools'); ?>/{alias} ' >Beesavy</a>" >

                                                              <span class="input-group-addon no-padding" id="basic-addon2" style=" border: none; ">
                                    <a id="share1-btn" class="btn ben-default" style="border: solid 1px #c23115; background: #c23115; color: white; margin: 0px; border-radius: 0;     position: relative; left: -4px;" href='#'>Copy</a class="btn ben-default"></span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="space30"></div>
                                                    
                                                   
                                                    
                                           
                                                    <h4 class="text-center">Share on Social Media</h4>
                                                    <div class="space30"></div>
                                                    <div class="row">
                                                                                                        
                    <form id="changeNewsletterForm" method="post" name="changeNewsletterForm" action="<?php echo s3path('/account/set_setting'); ?>">
                                                  <input name="setting" value="facebook_auto" type="hidden">
                                                  <input name="value" value="1" type="hidden">
                                                        <div class="col-md-6">
                                                            <div class="share_on_social">
                                                                <a href="https://www.facebook.com/sharer/sharer.php?app_id=272771746485230&sdk=joey&u=<?php echo s3path('/tools'); ?>/{alias} &display=popup&ref=plugin&src=share_button" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')" class="btn bee_btn_small"  style="margin-bottom: 15px"><i class="fa fa-facebook"></i> Share on Facebook</a>
                                                            </div>
                                                        </div>
                                                        
                                                    </form> 
                                                    
    
                                                    
               <form id="changeNewsletterForm" method="post" name="changeNewsletterForm" action="<?php echo s3path('/account/set_setting'); ?>">
                                                      <input name="setting" value="twitter_auto" type="hidden">
                                                       <input name="value" value="1" type="hidden">
                                                        <div class="col-md-6">
                                                            <div class="share_on_social">
                                      
                                                                <a href="https://twitter.com/intent/tweet?status=<?php echo s3path('/tools'); ?>/{alias}"  class="btn bee_btn_small" style="margin-bottom: 15px"><i class="fa fa-twitter"></i> Share on Twitter</a>
                                                            </div>
                                                        </div>
                                                   
                                                    </div>
                                                    <div class="space30"></div>
                                          </fieldset>      
                                        </div>
                                    </div>


                                    <div class="bee_payment_method">
                                        <div class="row">
                                            <form lpformnum="1">
                                                <fieldset class="feild_property">
                                                    <legend class="legend_property">
                                                        <label class="invite_others">Recent Refferals</label>
                                                    </legend>
                                                    
                                                    <div class="row">
                                                        <div class="panel panel-successs">
                        <div class="panel-body">
                            
                           
                            <div class="row" style=" width: 100%; ">
                            <div class=" table-responsive">
                                <table class="table  table-bordered">
                                    <thead class="head-table">
                                        <tr>
                                            <th>Invited</th>
                                            <th>Joined</th>
                                            <th>Shopped</th>
                                            <th>Referrals</th>  
                                        </tr>
                                    </thead>
                                    <tbody id='ref-table'>
                                    <?php  for($i=0; $i<4; $i++) {?>
                                        <tr> 
                                            <td><?php echo $allref[$i]['email']; ?></td>
                                            <td><i class="fa <?php  if ($users[$i]==0) echo "fa-times"; else echo  "fa-check"; ?> "></i></td>
                                     <td><i class="fa <?php if($allref[$i]['purchase_exempt']==0) echo 'fa-times'; else echo 'fa-check';?>"></i></td>
                                            <td><h1 class="label label-danger"><?php echo $allref[$i]['countid']; ?></h1></td>  
                                        </tr>
                                        
												<?php  } ?>
                                        
                                        
                                    </tbody>
                                </table> 
                                </div>   

                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="recent_orders">
                                    <input type="hidden" value="4" id="hidden-id" name="numberof">
                                        <a id="more-ref" class="bee_btn_small  ref-btn" style="padding-left: 25px;"> More  </a>
                                    </div>
                                </div>
                            </div>
                            

                        </div>

                    </div>
                                                    </div>
                                                    
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>





                                    <!-- <div class="bee_payment_method">
                                        <div class="row">
                                            <form lpformnum="1">
                                                <fieldset class="feild_property">
                                                    <legend class="legend_property">
                                                        <label class="invite_others">Refferal</label>
                                                    </legend>
                                                    <div class="space10"></div>
                                                    <div class="row">
                                                        <div class="row bee_center">
                                                            <div class="col-md-6">
                                                                <h4>Email Address</h4>
                                                                <p>zohaibshabir92@gmail.com</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h4>Referral Date</h4>
                                                                <p>02/01/2017</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="space10"></div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div> -->


                                    <div class="bee_payment_method">
                                        <div class="row">
                                            <form lpformnum="1">
                                                <fieldset class="feild_property">
                                                    <legend class="legend_property">
                                                        <label class="invite_others">Beesavy Blogger Button</label>
                                                    </legend>
                                                    <div class="space10"></div>
                                                    <div class="row">
                                                        <div class="own_beesavy_class">
                                                        <p class="text-center">Are you a blogger or power influencer? Copy this code to display our Referral Button on your site.</p>
                                                          <div class="space10"></div>
                                                        <div class="image_center_adds">
                                                        <img src="<?php echo s3path('/img/b-shop.png'); ?>" class="img-responsive">
                                                        </div>
                                                        <div class="space20"></div>
                                                          <div class="input-group">
                                                              <input id="img-link" type="text" class="form-control" 
                                                              value="<a href='<?php echo s3path(''); ?>'><img src='<?php echo s3path('/img/b-shop.png'); ?>'    
class='img-responsive'></a>" aria-describedby="basic-addon2">
                                                              <span class="input-group-addon no-padding" id="basic-addon2" style=" border: none; ">
                                                              <a class="btn ben-default" id="copy-imge" style="border: solid 1px #c23115; background: #c23115; color: white; margin: 0px; border-radius: 0;     position: relative; left: -4px;">Copy</a class="btn ben-default"></span>
                                                        </div>

                                                        </div>
                                                    </div>
                                                    <div class="space10"></div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>


                                   

                                    

                            
                                </div>

                                
                            </div>
                            <div class="col-md-3">
                    <!-- rightnav-included -->
                    <?php
      $this->load->view('blocks/rightnav');
                    ?> 

                    <div style="background-color: rgba(0, 0, 0, 0.05);"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Refer Friends -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="3888220977"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>

                </div>
                        </div>
                        
                    </div>
                </section>

<!-- /content -->



{footer_script}
{footer}



<script>

$('#copy-imge').click(function(){

  $("#img-link").select();
  document.execCommand("copy");

});



$('#share1-btn').click(function(){

  $("#persnol-share").select();
  document.execCommand("copy");

});


$('#more-ref').click(function(){
   var check = $('#hidden-id').val();
        check++;
        check++;
        check++;
        check++;
   $('#hidden-id').val(check);
     

   var rowCount =  $("tbody > tr").length;
   rowCount++;
   rowCount++;
   rowCount++;
   rowCount++;
   if(rowCount < check)
   {
        $("#more-ref").css("display", "none");
   }

    $.ajax({
            type: "POST",
            url: "tools/loadreferrals",
            data: { data : check },
            success: function(data, dataType)
            {
                $("#ref-table >tr ").remove();
               $("#ref-table").append(data);
              // alert(data);
                
            }
});
});
</script>


<script>
    $(document).ready(function(){
        $('#emailForm').submit(function(e){
            e.preventDefault();
            $('#emailBtn').attr('disabled',true);
            $.ajax({
                type:'POST',
                url: 'services/emails/sent_emails_to_friends',
                data: $(this).serialize(),
                success:function(data){

                    if(data == 0)
                        alert('Sorry! email fields should not be empty');
                    else if(data == 1)
                        alert('Congrats! email has been sent successfully');

            $('#emailBtn').attr('disabled',false);
                },
                error:function(data){
                    alert('Sorry! server not responding, please try later');
                }
            });
        });

    });
</script>

	<script>
$(window).load(function() {
	mCustomScrollbars();
});

function mCustomScrollbars(){





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
