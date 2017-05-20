  <?php $this->load->view('blocks/header'); ?>
<body>

<script type="text/javascript">
window.sendinblue=window.sendinblue||[];window.sendinblue.methods=["identify","init","group","track","page","trackLink"];window.sendinblue.factory=function(e){return function(){var t=Array.prototype.slice.call(arguments);t.unshift(e);window.sendinblue.push(t);return window.sendinblue}};for(var i=0;i<window.sendinblue.methods.length;i++){var key=window.sendinblue.methods[i];window.sendinblue[key]=window.sendinblue.factory(key)}window.sendinblue.load=function(){if(document.getElementById("sendinblue-js"))return;var e=document.createElement("script");e.type="text/javascript";e.id="sendinblue-js";e.async=true;e.src=("https:"===document.location.protocol?"https://":"http://")+"s.sib.im/automation.js";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)};window.sendinblue.SNIPPET_VERSION="1.0";window.sendinblue.load();window.sendinblue.client_key="1n0l4my1w3ubrs1l0iy5j";window.sendinblue.page();

</script>


<?php


 // echo $login_url .'ddddddddd';  exit;?>
<div id="container">
    <!-- Navigation bar -->
	<?php if($this->db_session->userdata('login')['login']){ 

	?>

<?php $this->load->view('blocks/admin-topbar'); ?>
<?php }else{

	 ?>
       <?php $this->load->view('blocks/nav_bar'); ?>
   
<?php } ?>

<?php // print_r($chekref['referral_status']); exit(); ?>


<?php /*  if(isset($user_prof['email'])) { print_r($user_prof);  exit; } if(isset($user_prof['email']) && $user_prof['email']!='') 
					{ echo $user_prof['email'];  exit; } */ ?>
<style type="text/css">
.btn-google {

    font-size: 16px;

}
.btn-facebook {

    font-size: 16px !important;


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
            
                      
                
            <div class="col-md-8 col-md-offset-2 formouter join-center">
                <form name="registerForm" id="registerForm" method="POST" action="<?php echo SURL?>account/register">
                <div class="row" >
                 <div class="col-md-6">
                   <a href="<?php echo SURL?>main/glogin"> <button type="button" class="btn btn-google btn-block">Register with Google +</button></a>
                 </div>
                 <div class="col-md-6">
        
                  <?php if(isset($output['email']) && $output['email']!='')
				  { echo $output['logout']; 
				  } else { 
				  print_r($output); }?>
                 </div>    
                </div>
                <div class="space20"></div>
                <div class="row">
                 <div class="col-md-1 ">
                 <label class="label-gap"> <i class="fa fa-envelope"></i></label>   
                 </div>
                 <div class="col-md-11">
                     <input type="text" name="email" placeholder="Enter Email Address " 
                     value="<?php if(isset($output['email']) && $output['email']!='') { echo $output['email'];} ?>" id="email" class="form-control">
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
                     <input type="password" placeholder="Enter Password" name="password" id="password" class="form-control">
                 </div>    
                </div>
                    
                      <div class="space20"></div>
                       <div class="row">
                 <div class="col-md-1">
                 <label class="label-gap"><i class="fa fa-lock"></i>  </label>   
                 </div>
                 <div class="col-md-11">
                    <input type="password" name="password_confirm" placeholder=" Confirm Password" id="password_confirm" class="form-control">
                 </div>    
                </div>
                           
                    <div class="space20"></div>
                    
                    
                    
                    
                    
                    
                    
                           <div class="row">
                 
                 <div class="col-md-12">
                     <input type="submit" class="btn btn-saving btn-block" value="Start Saving">
                 </div>    
                </div>
                    
                    
                    
                    </form> 
                
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
    <?php if(isset($_GET['fb']) == 'true'){ ?>
	<script type="text/javascript">
        $(document).ready(function(){
            window.location.href = $('#fbb').attr('href');
        });
    </script>
    <?php } ?>

<!-- /content -->

<!-- footer -->

<?php $this->load->view('blocks/footer'); ?>

<?php $this->load->view('blocks/footer_script'); ?>
<!-- /footer -->




  </body>
  </html>
