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

<style type="text/css">
.error-img {
    height: 430px !important;
}
</style>
    <!-- /Navigation bar -->
    <div class="space20"></div>     <div class="space20"></div>    

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
                                    <h3> Invalid User Email or Password </h3>
                                    <br>
                                    <div class="col-md-12">
                                        <div class="panel panel-infoxxx">
                                            <div class="panel-body">
                                               <div class="row">
                                               <img class="error-img" src="<?php echo s3path("/img/error.jpg");?>" >
                                               </div>
                                                
                                            </div>
                                        </div>
                                    </div>      

                                </div>    

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


<!-- /footer -->
