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
<style type="text/css">
.faq-title {
    padding: 16px 15px;
    background-color: #c23115;
    color: #fff;
}
</style>

<!-- content -->
<section id="help">
            <div class="container">
                <div class="row padding-top">
			
                    <div class="col-md-3">
                        <div class="row">

    <!-- Left category -->
	 <?php $this->load->view('blocks/left_nav'); ?>
    <!-- /Left category -->


     <div class="row show_tv_only">
                        <div style="background-color: rgba(0, 0, 0, 0.05);">
                           <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- faq -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="7120888976"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
                        </div>

                    </div>
</div>
                    </div>      

                    <div class="col-md-9">


                        <div class="row">
                        	 <h3 class="faq-title">Faq</h3>
                            <div class="bee_faq">
                            

                                <div class="cd-faq-items">
                                    <ul id="getting-started" class="cd-faq-group">


                                        <?php if(count($faqs)){ ?>

                                        <?php foreach($faqs as $key =>  $faq){ ?>
                                        <?php if($faq['faq_id'] == 5 ){ ?>
                                        <li id="getting-started" class="cd-faq-title"><h2><?php echo $faq['cate_name']; ?></h2></li>
                                        <?php } ?>
                                        <?php if($faq['faq_id'] == 16 ){ ?>
                                        <li id="shopping-searching" class="cd-faq-title"><h2><?php echo $faq['cate_name']; ?></h2></li>
                                        <?php } ?>
                                        <?php if($faq['faq_id'] == 25 ){ ?>
                                        <li id="using-beeSavy-coupons" class="cd-faq-title"><h2><?php echo $faq['cate_name']; ?></h2></li>
                                        <?php } ?>

                                        <?php if($faq['faq_id'] == 29 ){ ?>
                                        <li id="beesavy-cash-back" class="cd-faq-title"><h2><?php echo $faq['cate_name']; ?></h2></li>
                                        <?php } ?>

                                        <?php if($faq['faq_id'] == 51 ){ ?>
                                        <li id="problems-order" class="cd-faq-title"><h2><?php echo $faq['cate_name']; ?></h2></li>
                                        <?php } ?>

                                        <?php if($faq['faq_id'] == 55 ){ ?>
                                        <li id="understanding-your-account" class="cd-faq-title"><h2><?php echo $faq['cate_name']; ?></h2></li>
                                        <?php } ?>

                                        <?php if($faq['faq_id'] == 65 ){ ?>
                                        <li id="privacy-security" class="cd-faq-title"><h2><?php echo $faq['cate_name']; ?></h2></li>
                                        <?php } ?>

                                         <li>
                                            <a class="cd-faq-trigger" href="#0"><?php echo $faq['faq_name']; ?></a>
                                            <div class="cd-faq-content">
                                                <p><?php echo $faq['faq_desc']; ?></p>
                                            </div> <!-- cd-faq-content -->
                                        </li>
                                        <?php } ?>
                                        <?php } ?>
                                    </ul> <!-- cd-faq-group -->

                                   
                                    <!-- cd-faq-group -->
                                </div> <!-- cd-faq-items -->
                            </div>

                        </div>
                    </div>
                </div>    
            </div>    

        </section>
    

<!-- /content -->


<!-- footer -->
<?php $this->load->view('blocks/footer'); ?>
<?php $this->load->view('blocks/footer_script'); ?>
</body>
</html>

<!-- /footer -->
