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
    <?php  // print_r($terms)  echo 'ddddddddd'; exit;?>
<div class="space20"></div>     <div class="space20"></div>     
<!-- content -->
<section id="help">
    <div class="container">
    <div class="row padding-top">
              <div class="col-md-3">
                        <div class="row">

                             <?php $this->load->view('blocks/left_nav'); ?>
                           
                         
                           
                        </div>
                    </div>    
 
<div class="col-md-9">
                        <div class="panel panel-successxxx">

                            <div class="panel-body inner">
                                <div class="row">
                                    <h3> <?php echo $guide['page_name']; ?></h3>
                                    <br>
                                    <div class="col-md-12">
                                        <div class="panel panel-infoxxx">
                                            <div class="panel-body">
                                            <?php echo $guide['page_desc']; ?>
                                            </div>
                                        </div>
                                    </div>      

                                </div>    

                            </div>
                        </div>
<div  style="background-color: rgba(0, 0, 0, 0.05);">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- How To Build Your Hive -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="4027821776"
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
<!-- /footer -->

</body>
</html>
