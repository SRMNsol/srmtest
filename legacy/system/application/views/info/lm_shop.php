
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
    <div class="space20"></div>     <div class="space20"></div>    
    <!-- content -->


<!-- content -->
<section id="help">
            <div class="container">
                <div class="row padding-top">
                    <div class="col-md-3">
                        <div class="row">

    <!-- Left category -->
    {left_nav}
    <!-- /Left category -->
</div>
                    </div>    
<div class="col-md-9">
                        <div class="panel panel-successxxx">

                            <div class="panel-body inner">
                                <div class="row">
                                    <h3>  Learn More - Shop By Store</h3>
                                    <br>
                                    <div class="col-md-12">
                                        <div class="panel panel-infoxxx">
                                            <div class="panel-body">
                                                <div class="row">
                                                <div class="space20"></div>
                                                <h4>Already know what you want and where you want to shop?</h4>
                                                        <p>Use our <a href="#">Shop By Store </a> functionality to navigate to your store of choice.  By shopping through the link on BeeSavy, you'll be earning valuable cash back on your purchase.  Just be sure that your shopping cart is empty before linking through to the store.  Otherwise, the store won't pay cash back if you already had items in your cart.</p>
                                                </div>
                                               
                                                 
                                            </div>
                                        </div>
                                    </div>      

                                </div>    

                            </div>
                        </div>  
                        <div style="background-color: rgba(0, 0, 0, 0.05);">
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Shop By Store -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="5504554979"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
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