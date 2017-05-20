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
<!-- content -->

		<!-- page Title -->
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

	<?php if(isset($success)) { ?>
	<div class="alert alert-success">            
	{success}
	</div>
	<?php } ?>

            <div class="row">
              
            <div class="col-md-12">
               <div class="row">
              <div class="col-md-6">
               <form id="standardLoginForm" enctype="application/x-www-form-urlencoded" method="post" 
                                    action=<?php echo s3path("/account/forgot"); ?>>
										<div class="row">
											<div class="col-md-6">
											 <a href="<?php echo SURL?>main/glogin">	<button class="btn btn-google btn-block"><i class="fa fa-google"></i> Signin With Google</button></a>
											</div>
											<div class="col-md-6">
				<a href="#">	<button class="btn btn-facebook btn-block"><i class="fa fa-facebook"></i> Signin With Facebook</button></a>
											</div> 
										</div>   
										<div class="space20"></div>
                                        
                                      
                                        
										
										<div class="row">
											<div class="col-md-1">
												<i class="fa fa-envelope"></i>
											</div>  
											<div class="col-md-11">    
												<input required type="text" placeholder="Enter Email Address" name="email" id="email" class="form-control">
												<input name="type" value="standard" id="type" type="hidden">

<input name="return" value="/users/login" id="return" type="hidden">
											</div>    
										</div>
										<br>
										

										<div class="row">
											<div class="col-md-6 col-md-offset-3">

<input name="type" value="standard" id="type" type="hidden">

<input name="return" value="/users/login" id="return" type="hidden">

 
  <div class="space20"></div>
												<button style="margin:10px 0;" class="btn btn-primary btn-block" type="submit">Submit</button>     
											</div>

										</div>
									</form>
              


                
              </div>  
             <div class="col-md-6">
                <form name="registerForm" id="registerForm" method="POST" action="<?php echo SURL?>account/register">
                <div class="row">
                 <div class="col-md-6">
                   <a href="<?php echo SURL?>main/glogin"> <button type="button" class="btn btn-google btn-block">Register with Google +</button></a>
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
                 <div class="col-md-1 ">
                 <label class="label-gap"> <i class="fa fa-envelope"></i></label>   
                 </div>
                 <div class="col-md-11">
                     <input required type="text" name="email" placeholder="Enter Email Address " value="<?php if(isset($user_prof['email']) && $user_prof['email']!='') 
					 { echo $user_prof['email']; } ?>" id="email" class="form-control">
                 </div>    
                </div>
                   <?php  if($chekref['referral_status']==1)  { ?>
                    <div class="space20"></div>
                       <div class="row">
                 <div class="col-md-1">
                 <label class="label-gap"><i class="fa fa-th"></i> </label>   
                 </div>
             
                   <div class="col-md-11">
                     <input type="text" name="referral" placeholder="Enter Referral Code" class="form-control">
                 </div>    
              

                </div>
                <?php } ?>


                
                       <div class="space20"></div>
                   <div class="row">
                 <div class="col-md-1">
                 <label class="label-gap"><i class="fa fa-lock"></i> </label>   
                 </div>
                 <div class="col-md-11">
                     <input required type="password" placeholder="Enter Password" name="password" id="password" class="form-control">
                 </div>    
                </div>
                       <div class="space20"></div>
                       <div class="row">
                 <div class="col-md-1 ">
                 <label class="label-gap"><i class="fa fa-lock"></i>  </label>   
                 </div>
                 <div class="col-md-11">
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
<?php $this->load->view('blocks/footer'); ?>


<?php $this->load->view('blocks/footer_script'); ?>
<!-- /footer -->
  </body>
  </html>

