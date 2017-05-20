
  <?php $this->load->view('blocks/header'); ?>

<body>
<div id="container">
    <!-- Navigation bar -->
	<?php if($this->db_session->userdata('login')['login']){ ?>

<?php $this->load->view('blocks/admin-topbar'); ?>
<?php }else{ ?>
          <?php $this->load->view('blocks/nav_bar'); ?>

<?php } 

?>
<style type="text/css">
.form-control.btn-search {
    margin-top: -8px !important;
    width: 216px !important;
    margin-left: -15px !important;
}
.btn-icon{    margin-top: -8px !important;}
</style>
    <!-- /Navigation bar -->
    <!-- content -->
    <section id="cash_back">
        <div class="container">

            <div style="background-color: rgba(0, 0, 0, 0.05);">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Department Stores & General Merchandise -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="4167422575"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
            </div>
		<div class="space20"></div>
    
					<div class="row">
				<div class="col-md-4">
					<div class="bee_story_title1">
					
					
                        <h2>{category}</h2>
					</div>
				</div>
           
                <div class="col-md-2 ">

				<div class="btn-group inline quer_btn_inl">
			          <button type="button" class="btn btn-default dropdown-toggle bee_btn" data-toggle="dropdown">
			            Jump to Store <span class="caret"></span>
			          </button>
			          <ul class="dropdown-menu" role="menu">
			           <?php foreach($stores as $store){ ?>
							<li><a href="<?php echo s3path('/stores/details/'.$store['id']); ?>"><?php echo $store['name']; ?></a></li>
						<?php } ?>   
			          </ul>
			        </div>
                </div>
                     <div class="col-md-3 s_no_padding_query">
					 	<!-- <form class="navbar-form" action="<?php echo s3path('/search'); ?>" role="search">
							  <div class="input-group custom-search-form inline">
							  <input type="text" class="form-control btn-search" placeholder="Search for store" name="q">
							  <span class="input-group-btn">
							  <button class="btn btn-default btn-icon" type="submit">
							  <span class="glyphicon glyphicon-search "></span>
							 </button>
							 </span>
						 </form> -->

                         <form class="navbar-form " action="<?php echo s3path('/search'); ?>" role="search" style="margin: 0px;">
                            <div class="input-group add-on">
                                <input class="form-control" placeholder="Search for Store" name="q" type="text">

                                <!-- <input type="text" class="form-control btn-search" placeholder="Search for store" name="q"> -->

                                <div class="input-group-btn">
                                    <button class="btn btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </form>

			             </div><!-- /input-group -->
              
                <div class="col-md-3 ">
				   <div class="btn-group inline">
			          <button type="button" class="btn btn-default dropdown-toggle bee_btn" data-toggle="dropdown">
			            Search By Category <span class="caret"></span>
			          </button>
			          <ul class="dropdown-menu" role="menu">
			           <?php foreach ($categories as $item) : ?>
						<?php $category_url = 'category?' . http_build_query(['category' => $item['id']]) ?>
							 <li><a href="<?php echo escape($category_url, 'html_attr') ?>"><?php echo escape($item['name']) ?></a></li>
							<?php endforeach ?>
			          </ul>
			        </div>
                </div>
			</div>
            <div class="row">
                <div class="band">
                    <!-- <div class="col-md-2">
                    <p><i class="fa fa-search"></i> Search By Alphabet<p>

                    </div> -->
                    <div class="col-md-12" style="display:none;">

                        <ul class="pagination ">

                            <li><a class="btn-number-page" href="#">A</a></li>
                            <li><a class="btn-number-page" href="#">B</a></li>
                            <li><a class="btn-number-page" href="#">C</a></li>
                            <li><a class="btn-number-page" href="#">D</a></li>
                            <li><a class="btn-number-page" href="#">E</a></li>
                            <li><a class="btn-number-page" href="#">F</a></li>
                            <li><a class="btn-number-page" href="#">G</a></li>
                            <li><a class="btn-number-page" href="#">H</a></li>
                            <li><a class="btn-number-page" href="#">I</a></li>
                            <li><a class="btn-number-page" href="#">J</a></li>
                            <li><a class="btn-number-page" href="#">K</a></li>
                            <li><a class="btn-number-page" href="#">L</a></li>
                            <li><a class="btn-number-page" href="#">M</a></li>
                            <li><a class="btn-number-page" href="#">N</a></li>
                            <li><a class="btn-number-page" href="#">O</a></li>
                            <li><a class="btn-number-page" href="#">P</a></li>
                            <li><a class="btn-number-page" href="#">Q</a></li>
                            <li><a class="btn-number-page" href="#">R</a></li>
                            <li><a class="btn-number-page" href="#">S</a></li>
                            <li><a class="btn-number-page" href="#">T</a></li>
                            <li><a class="btn-number-page" href="#">U</a></li>
                            <li><a class="btn-number-page" href="#">V</a></li>
                            <li><a class="btn-number-page" href="#">W</a></li>
                            <li><a class="btn-number-page" href="#">X</a></li>
                            <li><a class="btn-number-page" href="#">Y</a></li>
                            <li><a class="btn-number-page" href="#">Z</a></li>

                        </ul>
                    </div>
                </div>


            </div>

			<?php $rows = 0 ?>
                <?php foreach($stores as $store){ ?>
				<?php if($rows%4 == 0){ ?>
				<div class="row">
				<?php } ?>
                <div class="col-md-3 col-sm-12">
                    <div class="bee_story_box">
                        <img class="img-responsive" src="<?php echo $store['logo_thumb']; ?>" alt="<?php echo $store['name']; ?>"
                             onerror="this.src="<?php echo s3path("/images/no-image-100px.gif") ?>"">
                        <h4><?php echo $store['cashback_text']; ?> Cash Back</h4>
                        <a href="<?php echo s3path('/stores/details/'.$store['id']); ?>"></a>
                    </div>
                </div>
				
				<?php if(($rows+5)%4 == 0){ ?>
				</div>
				<?php } 
				$rows = $rows+1; ?>
                <?php } ?>
        </div>
    </section>
</div>
<?php $this->load->view('blocks/footer'); ?>

<?php $this->load->view('blocks/footer_script'); ?>
<!--<script src="<?php// echo s3path("/script_files/js/jquery.min.js") ?>"></script>
<script  src="<?php // echo s3path("/script_files/js/bootstrap.min.js") ?>"></script>
<script  src="<?php// echo s3path("/script_files/js/custom.js") ?>"></script> -->
</body>
</html>
