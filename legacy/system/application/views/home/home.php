{header}
<!-- /Header -->

<!-- Navigation bar -->
{nav_bar}
<!-- /Navigation bar -->
{banner}
<?php  // print_r($chekref['referral_status']); exit(); ?>

<section id="bee_top_stories">
		<div class="container">
			<!-- <div class="row">
				<div class="col-md-12">
					<div class="bee_story_title">
						<h1>Top Stores <span> <a href="stores/storelist"> <button class="btn btn-default bee_btn2 pull-right">VIEW ALL</button></a></span></h1>
					</div>
				</div>
			</div> -->

			 <div class="row row-padding">
                    <div class="col-md-3">
                        <div class="bee_story_title">
							<h1> Top Stores </h1>
						</div>
                    </div>
                    <div class="col-md-6">
                    <div class="space20"></div>
            <div style="background-color: rgba(0, 0, 0, 0.05);"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Home ad 1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="1493157778"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
                    </div>
                    <div class="col-md-3">
                        <div class="bee_story_title">
						<h1><span> <a href="stores/storelist"> <button class="btn btn-default bee_btn2 pull-right">VIEW ALL</button></a></span></h1>
					</div>
                    </div>    
                </div>













                                             
                             <?php
//echo '<pre>';							 
					//	 print_r($stores );
					// exit;
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
                            
                </div>
	</section>

	
 <style type='text/css'>
                        #__mobileAssociatesSearchWidget_adunit_0{
                            
                        width: 100% !important;}
                    </style>
	<section id="amazon_deal">

		<!--Item slider text-->
		<div class="container">
		  <div class="row">
		    
		      <h2 style="text-align: center;">Today's Best Amazon Deals</h2>
		    
		   
		    
		  </div>
		  <div class="space-30"></div>

		  <div class="row">

		  <div class="col-md-12">
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
		  </div>
		  </div>



		</div>


	</section>



<div class="container">
<div class="col-md-12">
	<div style="background-color: rgba(0, 0, 0, 0.05);"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Home ads 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="5923357379"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

</div>
		<div class="space20"></div>
</div>

</div>


{footer}

<section id="bee_back_to_top">
<div id="back-to-top" class="back-to-top"></div>

</section>

{footer_script}

