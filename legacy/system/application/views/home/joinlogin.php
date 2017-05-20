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
   
<?php } 



?>


<?php // if($statussign) { echo $statussign; exit; } ?>
<?php /*  if(isset($user_prof['email'])) { print_r($user_prof);  exit; } if(isset($user_prof['email']) && $user_prof['email']!='') 
					{ echo $user_prof['email'];  exit; } */ ?>
<style type="text/css">
.btn-google {

    font-size: 16px;

}
.btn-facebook {

    font-size: 16px !important;

}
.form-control1 {
    color: black !important;
 
}
.formpadding {
    padding: 2% !important;
}
.message.alert.alert-danger {
    width: 50%;
    margin: 0 auto !important;
}
</style>

		<section id="bee_top_joinform">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-4">
					<div class="bee_story_title">
						<h3>NOT A MEMBER ? JOIN NOW</h3>
					</div>
				</div>
			</div>
            
            <?php if(!empty($errors)){?>
                <div class="message alert alert-danger">
                {errors}
                <p>{message}</p>
                {/errors}
                </div>
                <?php } ?>
                
            
            <div class="row">
            
                
            <div class="col-md-12">
               <div class="row">
              <div class="col-md-6">
               <form id="standardLoginForm" enctype="application/x-www-form-urlencoded" method="post" 
                                    action=<?php echo s3path("/account/login"); ?>>
										<div class="row">
											<div class="col-md-6">
											 <a href="<?php echo SURL?>main/glogin">	<button class="btn btn-google btn-block" style="margin-bottom:10px;"><i class="fa fa-google"></i> Signin With Google</button></a>
											</div>
											<div class="col-md-6">
				<a href="#">	<button class="btn btn-facebook btn-block"><i class="fa fa-facebook"></i> Signin With Facebook</button></a>
											</div> 
										</div>   
										<div class="space20"></div>
                                        
                                        
                                         <?php if(($status=='inactive')){?>
                                                <div class="message alert alert-danger">
                                                <p>
                                                Your account is deactivate
                                               </p>
                                               
                                                </div>
                                                <div class="space10"></div>
                                                <?php } ?>
               
                                        
										
										<div class="row">
											<div class="col-md-1 col-sm-1 col-xs-1">
												<i class="fa fa-envelope"></i>
											</div>  
											<div class="col-md-11 col-sm-11 col-xs-11">    
												<input required type="text" placeholder="Enter Email Address" name="email" id="email" class="form-control">
											</div>    
										</div>
										<br>
										<div class="row">
											<div class="col-md-1 col-sm-1 col-xs-1">
												<i class="fa fa-lock"></i>
											</div>
											<div class="col-md-11 col-sm-11 col-xs-11">  
												<input placeholder="Enter Password" required name="password" id="password" value="" type="password" class="form-control">
											</div>
										</div>
										<br>
										<div class="row">

											<p style="text-align:center; font-weight:bold; padding:15px 0;"> By Clicking on Create Account you agree to terms and conditions and privacy policy</p>
										</div>

										<div class="row">
											<div class="col-md-6 col-md-offset-3">

<input name="type" value="standard" id="type" type="hidden">

<input name="return" value="/users/login" id="return" type="hidden">

 
  <div class="space20"></div>
												<button style="margin:10px 0;" class="btn btn-primary btn-block" type="submit">Sign In</button>     
											</div>

										</div>
									</form>
              
                
              </div>  
             <div class="col-md-6">
                <form name="registerForm" id="registerForm" method="POST" action="<?php echo SURL?>account/register">
                <div class="row">
                 <div class="col-md-6">
                   <a href="<?php echo SURL?>main/glogin"> <button type="button" class="btn btn-google btn-block" style="margin-bottom: 10px;">Register with Google +</button></a>
                 </div>
                 <div class="col-md-6">
                 
                  <a href="https://www.facebook.com/dialog/oauth?client_id=219918071819528&redirect_uri=http%3A%2F%2Fdev.nsol.sg%2Fprojects%2Fbeesavy_new%2Flegacy%2Fpublic%2Fmain%2Ffblogin&state=451eaed65c3c29254ada19a1bd0f1077&scope=email">  <button type="button" class="btn btn-facebook btn-block">Register with Facebook</button></a>
                 </div>    
                </div>
                <div class="space20"></div>
				
				<?php if(($statussign=='inactive')){?>
				<div class="message alert alert-danger">
				<p>
				Your account is deactivate
			   </p>
			   
				</div>
				<div class="space10"></div>
				<?php } ?>
				
                <div class="row">
                 <div class="col-md-1 col-sm-1 col-xs-1">
                 <label class="label-gap"> <i class="fa fa-envelope"></i></label>   
                 </div>
                 <div class="col-md-11 col-sm-11 col-xs-11">
                     <input required type="text" name="email" placeholder="Enter Email Address " value="<?php if(isset($user_prof['email']) && $user_prof['email']!='') 
					 { echo $user_prof['email']; } ?>" id="email" class="form-control">
                 </div>    
                </div>
                   <?php  if($chekref['referral_status']==1)  { ?>
                    <div class="space20"></div>
                       <div class="row">
                 <div class="col-md-1 col-sm-1 col-xs-1">
                 <label class="label-gap"><i class="fa fa-th"></i> </label>   
                 </div>
             
                   <div class="col-md-11 col-sm-11 col-xs-11">
                     <input type="text" name="referral" placeholder="Enter Referral Code" class="form-control">
                 </div>    
              

                </div>
                <?php } ?>


                
                       <div class="space20"></div>
                   <div class="row">
                 <div class="col-md-1 col-sm-1 col-xs-1">
                 <label class="label-gap"><i class="fa fa-lock"></i> </label>   
                 </div>
                 <div class="col-md-11 col-sm-11 col-xs-11">
                     <input required type="password" placeholder="Enter Password" name="password" id="password" class="form-control">
                 </div>    
                </div>
                       <div class="space20"></div>
                       <div class="row">
                 <div class="col-md-1 col-sm-1 col-xs-1">
                 <label class="label-gap"><i class="fa fa-lock"></i>  </label>   
                 </div>
                 <div class="col-md-11 col-sm-11 col-xs-11">
                    <input required type="password" name="password_confirm" placeholder=" Confirm Password" id="password_confirm" class="form-control">
                 </div>    
                </div>
                    
                  
                    
                    
                    
                    
                    
                    
                    	<div class="space20"></div>
                           <div class="row">
                 
                 <div class="col-md-6 col-md-offset-3">
                     <input type="submit" class="btn btn-saving btn-block" value="Start Saving">
                 </div>    
                </div>
                    
                    
                    
                    </form>
              </div>
             </div>
            </div>
            
            </div>
		
		
		</div>
	</section>

 
    <section id="bee_service">
    <div class="container">

   
    <div class="row botoom-service">
        <div class="col-md-6">
        <div class="row">
        <div class="col-md-3">
            <img src="<?php echo SURL?>images/user-icon.png" class="img-responsive cashimg">
        </div>
        <div class="col-md-9">
            <h4>Get cash back at thousands of top online stores</h4>
            <p>When you shop online through BeeSavy, we earn a sales commission on anything you buy. We pass most of this commission to you as a cash back discount.</p>
        </div>    
        </div>
        </div>
        <div class="col-md-6">
        <div class="row">
        <div class="col-md-3">
             <img src="<?php echo SURL?>images/user-icon.png" class="img-responsive cashimg">
        </div>
        <div class="col-md-9">
             <h4>Get paid to refer your friends</h4>
            <p>BeeSavy pays you 10% commission on all of your referrals' cash back forever. We even pay you 10% commission for all of the people they refer up to seven levels!.</p>
        </div>    
        </div>
        </div>
    </div>
        
    </div>    
    </section>









	<script type="text/javascript">


	//$("#standardLoginForm").validate();
	//$("#registerForm").validate();
	//$("#registerForm .email").focus();

</script>


<!-- /content -->

<!-- footer -->
<?php $this->load->view('blocks/footer'); ?>

<?php $this->load->view('blocks/footer_script'); ?>
<!-- /footer -->
  </body>
  </html>
