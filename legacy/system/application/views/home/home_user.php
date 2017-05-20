
	<?php if($this->db_session->userdata('login')['login']){

 }

$totalref=$total[0]['referralcountdirect']+$total[0]['referralcountindirect'];
 ?>

 {header}

<style type="text/css">

.panel.panel-successs.marg-bot {
   /* padding-bottom: -5px !important;*/
}
.space15 {
    height: 15px;
}
.recent_orders{ margin-top:2px !important;}
.col-md-6.level-desc {
    margin-top: 60px;
}
</style>

<?php // echo '<pre>'; print_r($recentor); exit; ?>

 <body>
<div id="container">

<?php echo googletag_ad('BS_home_728x90_1') ?>

<!-- Navigation bar -->
<?php $this->load->view('blocks/admin-topbar'); ?>
<!-- /Navigation bar -->

<?php echo googletag_ad('BS_home_728x90_2') ?>

<!-- Content --><br><br>
<section id="panelss">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">

                        <div class="row">
							<?php $this->load->view('blocks/leftnav'); ?>
                        </div>
                    </div>    

                <div class="col-md-6 text-center">
                    <div class="levels_users">
                        <h3> There are 4 Levels of USERS </h3>

                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-6 ">
                            <div class="bee_savy_levels">
                                <h4>Level 1</h4>
                                <img src="<?php echo s3path('/img/new-bee.png'); ?>">
                                <h4 style=" font-size: 16px; "> New Bee</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="bee_savy_levels">
                                <h4>Level 2</h4>
                                <img src="<?php echo s3path('/img/worker-bee.png'); ?>">
                                <h4 style=" font-size: 16px; ">Worker Bee</h4>
                                </div>
                            </div>

                            <!-- show only tv -->
                            <div class="col-md-3 col-sm-6 col-xs-6 show_only_tv_level">
                            <div class="bee_savy_levels">
                                <h4>Level 3</h4>
                                <img src="<?php echo s3path('/img/quuen-bee.png'); ?>">
                                <h4 style=" font-size: 16px; ">Queen Bee</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-6 show_only_tv_level">
                            <div class="bee_savy_levels">
                                <h4>Level 4</h4>
                                <img src="<?php echo s3path('/img/beekeeper.png'); ?>">
                                <h4 style=" font-size: 16px; ">Beekepper</h4>
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <a class="btn bee_btn_small" data-toggle="modal" data-target="#bee_Modal2"> Learn More</a>

                                 <div class="modal fade" id="bee_Modal2" role="dialog">
                                    <div class="modal-dialog">
                                    
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">There are 4 Levels of USERS </h4>
                                        </div>
                                        <div class="modal-body">
                                          <p>Level 1 No purchase </p>
                                          <p>Level 2  One item purchase </p>
                                          <p>Level 3  Five Friend invited </p>
                                          <p>Level 4  Direct Referral </p>
										 
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div>

                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="current_level">
                        <div class="row">
                            <div class="col-md-9">
                                <h3>Your Current Level  <?php  if($total[0]['referralcountdirect']>0) { echo 'Beekepper'; } 
										  else if($totalref>4) { echo 'Queen Bee';}
										  else if($purchasit==1) { echo 'Worker Bee';}
										  else if($purchasit==0) { echo 'New Bee'; }?></h3>
                                <div class="space20"></div>

                                <a class="btn bee_btn_small" data-toggle="modal" data-target="#bee_Modal1"> Earn More</a>
                                <div class="modal fade" id="bee_Modal1" role="dialog">
                                    <div class="modal-dialog">
                                    
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">Your Current Level
										  <?php  if($total[0]['referralcountdirect']>0) { echo 'Beekepper'; } 
										  else if($totalref>4) { echo 'Queen Bee';}
										  else if($purchasit==1) { echo 'Worker Bee';}
										  else if($purchasit==0) { echo 'New Bee'; }?>
										  </h4>
                                        </div>
                                        <div class="modal-body" style="padding-top:0px;">
										
										
                                    <?php  if($total[0]['referralcountdirect']>0) {  ?>
											<div class="col-md-6">
												<img src="<?php echo s3path('/img/beekeeper.png');  ?>" style=" width: 85px; "> 
												<h4 style=" font-size: 16px; ">Beekepper</h4>
											</div>
											<div class="col-md-6 level-desc">Direct Referral</div>											
											<?php } else if($totalref>4) {  ?>
											<div class="col-md-6">
												<img src="<?php echo s3path('/img/quuen-bee.png');  ?>" style=" width: 85px; "> 
												<h4 style=" font-size: 16px; ">Queen Bee</h4>
											</div> 
											<div class="col-md-6 level-desc"> Five Friend invited</div>											
											<?php } else if($purchasit==1) {  ?>
											<div class="col-md-6">
												<img src="<?php echo s3path('/img/worker-bee.png');?>" style=" width: 85px; "> 
												<h4 style=" font-size: 16px; ">Worker Bee</h4>
											</div> 
											<div class="col-md-6 level-desc">One item purchase </div>											
											<?php } else if($purchasit==0) {  ?>
											<div class="col-md-6">
												
												<img src="<?php echo s3path('/img/new-bee.png');  ?>" style=" width: 85px; "> 
												<h4 style=" font-size: 16px; ">New Bee</h4>
											</div> 
											<div class="col-md-6 level-desc">No item purchase </div>											
											<?php }?>
										
                                        </div>
                                        <div class="modal-footer" style="margin-top:20% !important;">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div>
                            </div>
							<?php  if($total[0]['referralcountdirect']>0) {  ?>
							<div class="col-md-3">
                                <img src="<?php echo s3path('/img/beekeeper.png');  ?>" style=" width: 85px; "> 
                                <h4 style=" font-size: 16px; ">Beekepper</h4>
                            </div> 
							<?php } else if($totalref>5) {  ?>
							<div class="col-md-3">
                                <img src="<?php echo s3path('/img/quuen-bee.png');  ?>" style=" width: 85px; "> 
                                <h4 style=" font-size: 16px; ">Queen Bee</h4>
                            </div> 
							<?php } else if($purchasit==1) {  ?>
                            <div class="col-md-3">
                                <img src="<?php echo s3path('/img/worker-bee.png');?>" style=" width: 85px; "> 
                                <h4 style=" font-size: 16px; ">Worker Bee</h4>
                            </div> 
							<?php } else if($purchasit==0) {  ?>
							<div class="col-md-3">
                                <img src="<?php echo s3path('/img/new-bee.png');  ?>" style=" width: 85px; "> 
                                <h4 style=" font-size: 16px; ">New Bee</h4>
                            </div> 
							<?php }?>
                        </div>     
                        <div class="space_50 show_tv_only"></div>
                        <!--  <div class="row">
                             <div class="col-md-12">
                                     <a class="btn bee_btn_small" href="#"> Earn More</a>
                             </div>
                         </div> -->


                        <div class="row show_tv_only">

                            <div class="col-md-12">
                               <div style="background-color: rgba(0, 0, 0, 0.05);"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Home After Login -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="9934754571"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
                            </div>  
                        </div>
                    </div>    
                </div>    



                <div class="col-md-3">
                    <!-- rightnav-included -->
                    <?php
						$this->load->view('blocks/rightnav');
                    ?> 
                </div>



            </div>
            <hr>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-successs"> 
                        <div class="panel-body">
                            <div class="row">
                                <h3>Recent Referrals</h3> 
                            </div>
                            <br>
                            <div class="row" style=" width: 100%;">
                                <div class="table-bordered table-responsive">
                                    <table class="table ">
                                    <thead class="head-table">
                                        <tr>
                                            <th>Invited</th>
                                            <th>Joined</th>
                                            <th>Shopped</th>
                                            <th>Referrals</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
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
                            <div style="height: 10px;"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="recent_orders">
                                        <a class="btn bee_btn_small" href="#"> More  </a>
                                    </div>
                                </div>
                            </div>    
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-successs marg-bot">
                        <div class="panel-body">
                            <div class="row">
                                <h3>Recent Orders</h3>    
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Store</h4>
                                </div>
                               
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Cash back</h4>
                                    <br>
                                </div>    
                            </div>
                            <br>
                            <?php // echo '<pre>'; print_r($recentor); exit; ?>
							<?php for($i=0; $i<2; $i++) {?>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                      <!--  <h5 class="cash-value"><?php // echo $recentor[$i]['logoPath'] ;?></h5>    --> 
                                <a href="#">   <img width="150" height="150" class="store-img img-responsive" src="http://s3.amazonaws.com/static-dev.beesavy.com/logo/<?php  echo $recentor[$i]['logoPath']; ?>"></a>
                                </div>
                               
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="cashed">
                                        <h5 class="cash-value">$<?php echo $recentor[$i]['available'] ;?></h5>    
                                    </div>
                                </div>    
                            </div> 
							<?php } ?>
                            <div class="space15"></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="recent_orders">
                                        <a class="btn bee_btn_small" href="#"> More  </a>
                                    </div>
                                </div>
                            </div> 


                              
                        </div>

                    </div>
                </div>    
            </div>
            <div class="space30"></div>
        </div>
    </section>
	

    <section id="bee_top_stories">
        <div class="container">
        <div class="space30"></div>
         <div style="margin-bottom: 15px;">
            <div class="row">
               
              
                <div class="col-md-6 col-sm-6 col-xs-6">


                <h1 class="media_query_for_text">Top Stores</h1>

                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                <a href="stores/storelist" class="btn btn-default bee_btn2 pull-right"> VIEW ALL</a>

                </div>
                

                    <!-- <div class="main_title">
                      <h1>Top Stores <span> <a href="stores/storelist"> <button class="btn btn-default bee_btn2 pull-right">VIEW ALL</button></a></span></h1>
                    </div> -->
                </div>
            </div>

               <?php 
                             $r=0;
                             foreach ($stores as $store)  { ?>
                             <?php 
                             if($r==0){
                                echo "<div class='row'>";
                            }
                            
                            if($r % 4 == 0 && $r !=0){
                              echo "</div><div class='row'>";
                              } ?>
                          
						  
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="bee_story_box">
                                            <img class="img-responsive" src="<?php echo escape($store['logo_thumb']) ?>" alt="<?php echo escape($store['name']) ?>">
						<h4><?php echo escape($store['cashback_text']) ?> Cash Back</h4>
						<a href="<?php echo escape(SURL.'stores/details/'.$store['id']) ?>"></a>
					</div>
				</div>
                            
                             <?php  $r++; } ?>
           

                <div class="row">
                    <div class="col-md-12">
                    <style>
                        #__mobileAssociatesSearchWidget_adunit_0{
                            
                        width: 100% !important;}
                    </style>
                    <!-- Amazon lightning deals -->
        <script charset="utf-8" type="text/javascript">
            amzn_assoc_ad_type = "responsive_search_widget";
            amzn_assoc_tracking_id = "bee053-20";
            amzn_assoc_link_id = "5ZBNOZHTIPHVJEPF";
            amzn_assoc_marketplace = "amazon";
            amzn_assoc_region = "US";
            amzn_assoc_placement = "";
            amzn_assoc_search_type = "search_widget";
            amzn_assoc_width = 900;
            amzn_assoc_height = 500;
            amzn_assoc_default_search_category = "";
            amzn_assoc_default_search_key = "";
            amzn_assoc_theme = "light";
            amzn_assoc_bg_color = "FFFFFF";
        </script>
        <script src="//z-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetScript&ID=OneJS&WS=1&MarketPlace=US"></script>
        <!-- /Amazon lightning deals -->
                    
                    </div>
                </div>
                



        </div>
    </section>  






<div>
   

   <!-- /Referral Overview -->
<!-- /Content -->

<!-- footer -->
{footer_script}
{footer}
<?php // echo googletag_ad('BS_home_728x90_4') ?>

</body>
</html>
