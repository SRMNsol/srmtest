<?php 

 // if($refon['referral_status']) { print_r($refon['referral_status']); exit(); } ?>

<style type="text/css">
.reg-btn{ margin-bottom: 14px !important;}
</style>
	<section id="logo_mobile"  class="show_only_mob">
	    <div class="container">
	        <div class="row">
	            <div class="col-md-12">
	                <div class="mobile_logo">
	                   <a href="index.php"> <img class="img-responsive" src="img/mega_logo_mobile.png"></a>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>


    <section id="bee_topbar">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12"></div>
                <div class="col-md-5 col-sm-5 col-xs-12">
                    <form class="navbar-form" action="<?php echo s3path('/search'); ?>" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="q">
                            <div class="input-group-btn padding-top">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="bee_login">

                        <li class="sign_button"><a href="#"  data-toggle="modal" data-target="#myModal">LOGIN</a></li>
                        <li class="join_button"><a href="#"  data-toggle="modal" data-target="#joinModal"> JOIN NOW</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="bee_nav">
        <nav class="navbar navbar-default bee_navbar">
            <div class="container" style="padding-right:0px !important;">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="show_tv_only">
                        <a class="navbar-brand bee_mega_logo" href="<?php echo SURL ?>"><img class="img-responsive" src="<?php echo s3path("/images/mega_logo.png") ?>"></a>
                    </div>
                    <div class="show_mob_tab_only">
                        <a class="navbar-brand " href="<?php echo SURL ?>"><img src="<?php echo s3path("/images/logo.png") ?>"></a>
                    </div>
                </div>
                <div class="collapse navbar-collapse js-navbar-collapse">
                    <div class="row">

                        <div class="col-md-10">    
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown mega-dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">SHOP BY CATEGORY <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>

                                    <ul class="dropdown-menu mega-dropdown-menu row">

                                        
                                                
                                            <?php 
                                             $r=0;
                                            foreach ($categories as $category) : ?>
                                                
                                                <?php    
                                                if($r==0){
                                                echo '<li class="col-sm-4"><ul>';
                                            } 
                                                 if($r % 5 == 0 && $r !=0){
                                            echo '</ul></li><li class="col-sm-4">
                                                   <ul>';
                                                } 
                                                
                                                ?>
                                             <li><a href="<?php echo SURL?>product/category?category=<?php echo escape($category['id'], 'html_attr') ?>"><?php echo escape($category['name']) ?></a></li>  
                                             
                                            <?php $r++; endforeach ?>

                                        </ul></li>

                                    </ul>

                                </li>
                                
                                <li><a href="<?php echo SURL?>stores/search">SHOP BY STORE</a></li>
                                <li><a href="<?php echo SURL?>stores/storelist">ALL STORES</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
                </div>
                <!-- /.nav-collapse -->
            </div>
        </nav>
    </section>

    <section id="bee_join">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><center> LOGIN TO ACCOUNT </center></h4>
                                </div>
                                <div class="modal-body">
									<form id="standardLoginForm" enctype="application/x-www-form-urlencoded" method="post" 
                                    action=<?php echo s3path("/account/login"); ?>>
										<div class="row">
											<div class="col-md-6">
												<button data-target="<?php echo s3path("/main/joinnow ") ?>" class="btn btn-google btn-block"><i class="fa fa-google"></i> Signin With Google</button>
											</div>
											<div class="col-md-6">
												<button data-target="<?php echo s3path("/main/joinnow ") ?>" class="btn btn-facebook btn-block"><i class="fa fa-facebook"></i> Signin With Facebook</button>
											</div> 
										</div>   
										<hr>
										<br>
										<div class="row">
											<div class="col-md-1">
												<i class="fa fa-envelope"></i>
											</div>  
											<div class="col-md-11 no-padding">    
												<input required="required" type="text" placeholder="Your Email Address" name="email" id="email" class="form-control">
											</div>    
										</div>
										<br>
										<div class="row">
											<div class="col-md-1">
												<i class="fa fa-lock"></i>
											</div>
											<div class="col-md-11 no-padding">  
												<input required="required" placeholder="Your Password" name="password" id="password" value="" type="password" class="form-control">
											</div>
										</div>
										<br>
										<!--
										
										<div class="row">

											<div class="col-md-1">
												<a href="#" data-toggle="popover" title="IF YOU HAVE A REFFRAL CODE KINDLY ENTER IT IN  BOX" data-content=""> <i class="fa fa-question-circle"></i></a>
											</div>
											<div class="col-md-11 no-padding">
												<input type="text" placeholder="Do you have a referral code ? " name="referral" class="form-control">
											</div>

										</div>
										<br>
										-->


										<div class="row">

											<p style="text-align:center; font-weight:bold; padding:15px 0;"> By Clicking on Create Account you agree to terms and conditions and privacy policy</p>
										</div>

										<div class="row">
											<div class="col-md-6 col-md-offset-3">

<input name="type" value="standard" id="type" type="hidden">

<input name="return" value="/users/login" id="return" type="hidden">
												<button style="margin:10px 0;" class="btn btn-primary btn-block " type="submit">Sign In</button>     
											</div>

										</div>
									</form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                
              <div class="col-md-12">
                    <div class="modal fade" id="joinModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><center> NOT A MEMBER ? JOIN NOW</center></h4>
                                </div>
                                <div class="modal-body">
									<form name="registerForm" id="registerForm" method="POST" action="<?php echo SURL?>account/register">
                <div class="row" >
                 <div class="col-md-6">
                   <a href="<?php echo SURL?>main/glogin"> <button type="button" class="btn btn-google btn-block">Register with Google +</button></a>
                 </div>
                 <div class="col-md-6">
                 
             <a type="button" class="btn btn-facebook btn-block" href="<?php echo s3path("/main/joinnow?fb=true"); ?> ">Register with Facebook
             </a>
                 </div>    
                 
                </div>
                <hr>
                 <div class="space20"></div>
                <div class="row">
                 <div class="col-md-1">
                 <label class="label-gap"> <i class="fa fa-envelope"></i></label>   
                 </div>
                 <div class="col-md-11">
                     <input required="required" type="text" name="email" placeholder="Enter Email Address" value="<?php if(isset($user_prof['email']) && $user_prof['email']!='') 
					 { echo $user_prof['email']; } ?>" id="email" class="form-control">
                 </div>    
                </div>
                  <?php if($refon['referral_status']==1) { ?>

                 <div class="space20"></div>
                       <div class="row">
                 <div class="col-md-1">
                 <label class="label-gap"><i class="fa fa-th"></i> </label>   
                 </div>

              
                <div class="col-md-11">
                     <input required="required" type="text" name="referral" placeholder="Enter Referral Code" class="form-control">
                 </div>   

</div>
                    <?php  }
                  ?>
                
                    <div class="space20"></div>
                   <div class="row">
                 <div class="col-md-1">
                 <label class="label-gap"><i class="fa fa-lock"></i> </label>   
                 </div>
                 <div class="col-md-11">
                     <input required="required" type="password" placeholder="Enter Password" name="password" id="password" class="form-control">
                 </div>    
                </div>
                    <div class="space20"></div>
                       <div class="row">
                 <div class="col-md-1">
                 <label class="label-gap"><i class="fa fa-lock"></i>  </label>   
                 </div>
                 <div class="col-md-11">
                    <input required="required" type="password" name="password_confirm" placeholder=" Confirm Password" id="password_confirm" class="form-control">
                 </div>    
                </div>
                    <div class="space20"></div>
                      
                           <div class="row ">
                 
                 <div class="col-md-6 col-md-offset-3">
                     <input type="submit" class="btn btn-saving btn-block reg-btn" value="Start Saving">
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
    </section>
    