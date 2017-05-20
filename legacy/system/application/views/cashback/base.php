<!-- Header -->

<?php $this->load->view('blocks/header'); ?>
<!-- /Header -->

<body>
<style>.btn_bee_savy {
    background-color: #c23115;
    color: #fff;
    border-radius: 0px;
    padding: 5px 40px;
    border: 1px #c23115 solid;
    vertical-align: initial;
}
.top_buttons ul li {
    display: inline-block !important;
    margin-right: 5px !important;
    margin-bottom: 10px !important;
}
.btn_bee_savy:hover {
    background-color: #ffffff;
    color: #c23115;
    border-radius: 0px;
    padding: 5px 40px;
    border: 1px #c23115 solid;
}
ul li.active a.btn_bee_savy {
    background-color: #00543c;
    color: #fff;
    border-radius: 0px;
    padding: 5px 40px;
    border: 1px #00543c solid;
    vertical-align: initial;
}
.full-left{float: left !important;
margin-left: 8px !important;}

@media only screen and (max-width: 768px) {

 .new_clss_media {
    width: 100% !important;
}
.inline_block_mediaquery ul li {
    display: block !important;
}
}
</style>
<?php  // echo '<pre>'; print_r($allorder);  exit;?>
<div id="container">


    <!-- Navigation bar -->
<?php $this->load->view('blocks/admin-topbar'); ?>
<!-- /Navigation bar -->
<div class="space20"></div><div class="space20"></div>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                
                
                
               			 <div class="row">
                                    <div class="top_buttons inline_block_mediaquery">
                               			 <ul>
                                    <li>
                                        <a class="btn btn_bee_savy new_clss_media" href="<?php echo SURL?>account"> Settings </a>
                                    </li>
                                    <li class="active">
                                        <a class="btn btn_bee_savy new_clss_media" href="<?php echo SURL?>cashback"> Cash Back </a>
                                    </li>
                                    <li>
                                        <a class="btn btn_bee_savy new_clss_media" href="<?php echo s3path('/tools'); ?>"> Referrals </a>
                                    </li>
                                </ul>
                            		</div>
                                </div>
                                
                                
                                
                    <?php if(!empty($errors)) { ?>
                    <div class="alert alert-danger" style="width:100%">
                        {errors}
                        {message}
                        {/errors}
                    </div>
                    <?php } ?>
                    <?php if(isset($success)) { ?>
                    <div class="alert alert-success" style="width:100%">{success}</div>
                    <?php } ?>
                    <?php if(isset($notice)) { ?>
                    <div class="alert alert-warning" style="width:100%">{notice}</div>
                    <?php } ?>
                </div>
            </div>
           <div class="space20"></div>
            <div class="row">
                <div class="col-md-9">
                        
                    <div class="space20"></div>

                    <div class="row ">
                        <div class="col-md-12"><h3 class="heading_title_cashback">Cash Back</h3>
                        </div>
                    </div>
                    <div class="space20"></div>
					
		{transactions}
                    <div class="row">
                        <div class="head_c_b text-center">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <h4>{transtype}</h4>


                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <h4>{month}</h4>


                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <h4>${cashback}</h4>


                            </div>
                        </div>
                    </div>
                    <div class="space15"></div>
		{/transactions}
						<div id="tabBorder"></div>

                    <div class="row text-center">
                    
                    
                    
                                <div class=" mar-left col-md-4 col-sm-4 col-xs-4">
                                        <h2 class="left full-left common_class_query_head">Store</h2>    
                                </div>
                                
                                 <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="cashed">
                                        <h2 class=" common_class_query_head">Date</h2>    
                                    </div>
                                </div> 
                                
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="cashed">
                                        <h2 class=" common_class_query_head">Price</h2>    
                                    </div>
                                </div>    
                           
                    
                     <?php for($i=0; $i<count($allorder); $i++) {?>
                            
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                         <img width="150" height="150"  class="store-img img-responsive" src="http://s3.amazonaws.com/static-dev.beesavy.com/logo/<?php  echo $allorder[$i]['logoPath']; ?>">
                                </div>
                                
                                 <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="cashed">
                                        <h5 class="cash-value comm_clas_td"><?php echo $allorder[$i]['date'] ;?></h5>    
                                    </div>
                                </div> 
                                
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="cashed">
                                        <h5 class="cash-value comm_clas_td">$<?php echo $allorder[$i]['available'] ;?></h5>    
                                    </div>
                                </div>    
                           
							<?php } ?>
                    


                </div>
                    <div class="space10"></div>
               

        <div style="background-color: rgba(0, 0, 0, 0.05);">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Cash Back -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="8318420576"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        </div>


                </div>
                <div class="col-md-3">
                    <!-- rightnav-included -->

                    <?php $this->load->view('blocks/rightnav'); ?>
                    <div class="space10"></div>
                    <div class="row show_tv_only">
                        <a href="#">
                            <?php echo googletag_ad('BS_account_300x600') ?>
                        </a>

                    </div>
                </div>

            </div>
            <div class="space_50"></div>
        </div>
    </section>


    <!-- content -->
            <!-- Right category -->
            <!-- /content -->


            <!-- footer -->
            {footer_script}
            {footer}
            <!-- /footer -->

</body>
</html>
