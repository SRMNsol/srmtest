{header}
<!-- Navigation bar -->
<?php $this->load->view('blocks/nav_bar');  ?>
<!-- /Navigation bar -->
<style type='text/css'>
   .main_title{margin-bottom: 12px !important;margin-top: 12px !important;
   }
   .select {
   background: #080808;
   color: white;
   padding: 3px;
   }
   .simple {
   background: #d9534f;
   color: white;
   padding: 3px;
   }
   #shop_store_top .pagination>li>a, #shop_store_top .pagination>li>span {
   padding: 0px;
   }
   #shop_store_top .band ul li a img {
   border: 0;
   width: 40px;
   margin: 2px 0;
   }
   #shop_store_top .row-padding h3 {
   padding-top: 5px;
   }
   #help #shop_store_top form {
   margin: 0px;
   }
   #shop_store_top .bee_panels .panel-body a{
   color: #c23115;
   }
   #shop_store_top .bee_panels .panel-body a:hover {
   color: #d9534f;
   }
   .pagination>li>a, .pagination>li>span {
   position: relative;
   float: left;
   padding: 6px 12px;
   margin-left: -1px;
   line-height: 1.42857143;
   color: #c23115;
   text-decoration: none;
   background-color: #fff;
   border: 1px solid #d9534f;
   }
   .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
   z-index: 3;
   color: #fff;
   cursor: default;
   background-color: #c23115;
   border-color: #c23115;
   }
   .pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover {
   z-index: 2;
   color: #c23115;
   background-color: rgba(194, 49, 21, 0.15);
   border-color: rgb(194, 49, 21);
   }
   .pagination>.disabled>a, .pagination>.disabled>a:focus, .pagination>.disabled>a:hover, .pagination>.disabled>span, .pagination>.disabled>span:focus, .pagination>.disabled>span:hover {
   color: #c23115;
   cursor: not-allowed;
   background-color: #fff;
   border-color: #c23115;
   }
   @media only screen and (max-width: 667px) {
   .panel.bee_panels{
   min-height: 355px;
   }
   .panel.bee_panels .panel-body {
   padding: 10px 5px;
   }
   .panel.bee_panels .col-md-12{
   padding: 0px;
   }
   .stores .col-xs-6 {
   padding: 0 5px;
   }
   }
</style>
<!-- content -->
<div class="space40 show_tv_only"></div>
<div class="space20"></div>
<section id="help">
   <div class="container">
      <div class="row padding-top">
         <div class="row" id="shop_store_top">
            <!-- <div class="col-md-4 col-sm-4 col-xs-12">
               <form class="navbar-form" role="search"  action="<?php //echo s3path('/search'); ?>" style=" padding: 0; ">
                   <div class="input-group add-on">
                       <input class="form-control" placeholder="Search by Alphabet" name="q" id="srch-term" type="text">
                       <div class="input-group-btn">
                           <button class="btn btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                       </div>
                   </div>
               </form>
               </div>  -->   
            <!-- <div class="col-md-4 col-sm-4 col-xs-12">
               <form class="navbar-form" role="search" style=" padding: 0; ">
                   <div class="input-group add-on">
                       <input class="form-control" placeholder="Jump to Store" name="q" id="srch-term" type="text">
                       <div class="input-group-btn">
                           <button class="btn btn-search" type="submit"><i class="caret"></i></button>
                       </div>
                   </div>
               </form>
               </div> -->    
            <!-- <div class="col-md-4 col-sm-4 col-xs-12">
               <div class=" dropdown" style="padding-top:3%;">
               
                                              <button type="button" class="btn btn-default category-btn dropdown-toggle" data-toggle="dropdown">
                                                  Search by Category <span class="caret"></span>
                                              </button>
               
               
               
                                              <ul class="dropdown-menu">
                                                  <?php //foreach ($categories as $item) : ?>
               	<?php $category_url //= 'product/category?' . http_build_query(['category' => $item['id']]) ?>
               		 <li><a href="<?php //echo SURL.escape($category_url, 'html_attr') ?>"><?php //echo escape($item['name']) ?></a></li>
               		<?php //endforeach ?>
               
                                              </ul>
                                          </div>
               
               </div>  -->   
            <!-- <div class="row">
               <div class="col-md-12">
                   <div class="main_title" style=" margin-bottom: 15px; ">
                       <h3>SHOP BY STORE</h3>
                   </div>
               </div>
               </div> -->
            <div class="row row-padding">
               <div class="col-md-3">
                  <h3><b>SHOP BY STORE</b></h3>
               </div>
               <div class="col-md-6">
            <div style="background-color: rgba(0, 0, 0, 0.05);">
              <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- SHOP BY STORE -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="7400090575"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
            </div>
                    </div>
               <div class="col-md-3">
                  <form class="navbar-form pull-right" role="search">
                     <div class="input-group add-on">
                        <input class="form-control" placeholder="Search by Store" name="srch-term" id="srch-term" type="text">
                        <div class="input-group-btn">
                           <button class="btn btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <div class="row">
               <div class="band">
                  <div class="col-md-12">
                     <ul id="0" class="pagination ">
                        <li><a class="btn-number-page" href="#0"> <img src=<?php echo s3path("/img/icon/0.png");?>></a></li>
                        <li><a class="btn-number-page" href="#A"> <img src=<?php echo s3path("/img/icon/A.png" );?>></a></li>
                        <li><a class="btn-number-page" href="#B"> <img src=<?php echo s3path("/img/icon/B.png"); ?> ></a></li>
                        <li><a class="btn-number-page" href="#C"> <img src=<?php echo s3path("/img/icon/C.png");?>></a></li>
                        <li><a class="btn-number-page" href="#D"> <img src=<?php echo s3path("/img/icon/D.png");?>></a></li>
                        <li><a class="btn-number-page" href="#E"> <img src=<?php echo s3path("/img/icon/E.png");?>></a></li>
                        <li><a class="btn-number-page" href="#F"> <img src=<?php echo s3path("/img/icon/F.png");?>></a></li>
                        <li><a class="btn-number-page" href="#G"> <img src=<?php echo s3path("/img/icon/G.png");?>></a></li>
                        <li><a class="btn-number-page" href="#H"> <img src=<?php echo s3path("/img/icon/H.png");?>></a></li>
                        <li><a class="btn-number-page" href="#I"> <img src=<?php echo s3path("/img/icon/I.png");?>></a></li>
                        <li><a class="btn-number-page" href="#J"> <img src=<?php echo s3path("/img/icon/J.png");?>></a></li>
                        <li><a class="btn-number-page" href="#K"> <img src=<?php echo s3path("/img/icon/K.png");?>></a></li>
                        <li><a class="btn-number-page" href="#L"> <img src=<?php echo s3path("/img/icon/L.png");?>></a></li>
                        <li><a class="btn-number-page" href="#M"> <img src=<?php echo s3path("/img/icon/M.png");?>></a></li>
                        <li><a class="btn-number-page" href="#N"> <img src=<?php echo s3path("/img/icon/N.png");?>></a></li>
                        <li><a class="btn-number-page" href="#O"> <img src=<?php echo s3path("/img/icon/O.png");?>></a></li>
                        <li><a class="btn-number-page" href="#P"> <img src=<?php echo s3path("/img/icon/P.png");?>></a></li>
                        <li><a class="btn-number-page" href="#Q"> <img src=<?php echo s3path("/img/icon/Q.png");?>></a></li>
                        <li><a class="btn-number-page" href="#R"> <img src=<?php echo s3path("/img/icon/R.png");?>></a></li>
                        <li><a class="btn-number-page" href="#S"> <img src=<?php echo s3path("/img/icon/S.png");?>></a></li>
                        <li><a class="btn-number-page" href="#T"> <img src=<?php echo s3path("/img/icon/T.png");?>></a></li>
                        <li><a class="btn-number-page" href="#W"> <img src=<?php echo s3path("/img/icon/W.png");?>></a></li>
                        <li><a class="btn-number-page" href="#U"> <img src=<?php echo s3path("/img/icon/U.png");?>></a></li>
                        <li><a class="btn-number-page" href="#V"> <img src=<?php echo s3path("/img/icon/V.png");?>></a></li>
                        <li><a class="btn-number-page" href="#X"> <img src=<?php echo s3path("/img/icon/X.png");?>></a></li>
                        <li><a class="btn-number-page" href="#Y"> <img src=<?php echo s3path("/img/icon/Y.png");?>></a></li>
                        <li><a class="btn-number-page" href="#Z"> <img src=<?php echo s3path("/img/icon/Z.png");?>></a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="stores">
               <?php $rows = 0; 
                  $index = 0;
                  $ad = 0;
				  $flag = true; $a = true;
			$b = true; $c = true; $d = true; $e = true;
			$row=0;
                  foreach ($stores1 as $store) {
                      ?>
               <?php if($rows%4 == 0){ ?>
               <div class="row">
                  <?php } ?>
                  
                  		<?php if(is_numeric(substr($store['name'], 0, 1)) AND $flag == true){
						?>
							<div class=""><a id="#" class="btn btn-number btn-number-page" href="#0">#</a></div>
								<?php $flag = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'A' AND $a == true){
						?>
							<div class=""><a id="A" class="btn btn-number btn-number-page" href="#0">A</a>
              </div>
							<?php $a = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'B' AND $b == true){
						?><div class="">
							<a id="B" class="btn btn-number btn-number-page" href="#0">B</a>
							</div>
              <?php $b = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'C' AND $c == true){
						?><div class="">
							<a id="C" class="btn btn-number btn-number-page" href="#0">C</a>
							</div>
              <?php $c = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'D' AND $d == true){
						?><div class="">
							<a id="D" class="btn btn-number btn-number-page" href="#0">D</a>
							</div>
              <?php $d = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'E' AND $e == true){
						?><div class="">
							<a id="E" class="btn btn-number btn-number-page" href="#0">E</a>
							</div>
              <?php $e = false; } ?>
                  
                  <div class="col-md-3 col-xs-6 col-sm-6">
                     <div class="row">
                        <div class="panel bee_panels">
                           <div class="panel-body">
                              <div class="row">
                                 <div class="col-md-12">
                                    <a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank"> <img style="height:50px !important;" src="<?php echo $store['logo_thumb'] ?>" alt="<?php echo $store['name'] ?>" class="img-responsive">   </a>
                                 </div>
                              </div>
                              <br>
                              <br>
                              <div class="row">
                                 <div class="col-md-12">
                                    <p><a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank" ?><?php echo $store['name'] ?></a> </p>
                                    <!-- <p><?php //echo substr($store['description-abrv'], 0, 35); ?> <a href="<?php //echo SURL."stores/details/".$store['id'] ?>">more</a></p> -->     
                                 </div>
                              </div>
                              <br>
                              <div class="row">
                                 <div class="col-md-12">
                                    <a href="<?php echo SURL."stores/details/".$store['id'] ?>" style="color: #000"><b><?php echo $store['cashback_text'] ?></b></a>
                                 </div>
                              </div>
                              <br>
                              <div class="row">
                                 <div class="col-md-12">
                                    <a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank" ?> <button class="btn btn-danger btn-block" style="font-size:10px;">SHOP STORES</button></a> <br>
                                    <a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank" ?> <button class="btn btn-danger btn-block" style="font-size:10px;">Shop Now</button></a>
                                 </div>
                              </div>
                              <br>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php if(($rows+5)%4 == 0){ ?>
               </div>
               <?php } 
                  ?>
               <?php
                  $index += 1;
                  $rows++;
                          }
                       ?>
                       <?php $f = true; $g = true; $h = true;
$i = true; $j = true; $k = true;$l = true;$m = true;$n = true;$o = true;$p = true; $row=0;
foreach ($stores2 as $store) {
                      ?>
               <?php if($rows%4 == 0){ ?>
               <div class="row">
                  <?php } ?>
                  
						<?php if(substr($store['name'], 0, 1) == 'F' AND $f == true){
						?><div class="">
							<a id="F" class="btn btn-number btn-number-page" href="#0">F</a>
							</div>
              	<?php $f = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'G' AND $g == true){
						?><div class="">
							<a id="G" class="btn btn-number btn-number-page" href="#0">G</a>
							</div>
              <?php $g = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'H' AND $h == true){
						?><div class="">
							<a id="H" class="btn btn-number btn-number-page" href="#0">H</a>
							</div>
              <?php $h = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'I' AND $i == true){
						?><div class="">
							<a id="I" class="btn btn-number btn-number-page" href="#0">I</a>
							</div>
              <?php $i = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'J' AND $j == true){
						?><div class="">
							<a id="J" class="btn btn-number btn-number-page" href="#0">J</a>
							</div>
              <?php $j = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'K' AND $k == true){
						?><div class="">
							<a id="K" class="btn btn-number btn-number-page" href="#0">K</a>
							</div>
              <?php $k = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'L' AND $l == true){
						?><div class="">
							<a id="L" class="btn btn-number btn-number-page" href="#0">L</a>
							</div>
              <?php $l = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'M' AND $m == true){
						?><div class="">
							<a id="M" class="btn btn-number btn-number-page" href="#0">M</a>
							</div>
              <?php $m = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'N' AND $n == true){
						?><div class="">
							<a id="N" class="btn btn-number btn-number-page" href="#0">N</a>
							</div>
              <?php $n = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'O' AND $o == true){
						?><div class="">
							<a id="O" class="btn btn-number btn-number-page" href="#0">O</a>
							</div>
              <?php $o = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'P' AND $p == true){
						?><div class="">
							<a id="P" class="btn btn-number btn-number-page" href="#0">P</a>
							</div>
              <?php $p = false; } ?>
                  
                  <div class="col-md-3 col-xs-6 col-sm-6">
                     <div class="row">
                        <div class="panel bee_panels">
                           <div class="panel-body">
                              <div class="row">
                                 <div class="col-md-12">
                                    <a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank"> <img style="height:50px !important;" src="<?php echo $store['logo_thumb'] ?>" alt="<?php echo $store['name'] ?>" class="img-responsive">   </a>
                                 </div>
                              </div>
                              <br>
                              <br>
                              <div class="row">
                                 <div class="col-md-12">
                                    <p><a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank" ?><?php echo $store['name'] ?></a> </p>
                                    <!-- <p><?php //echo substr($store['description-abrv'], 0, 35); ?> <a href="<?php //echo SURL."stores/details/".$store['id'] ?>">more</a></p> -->     
                                 </div>
                              </div>
                              <br>
                              <div class="row">
                                 <div class="col-md-12">
                                    <a href="<?php echo SURL."stores/details/".$store['id'] ?>" style="color: #000"><b><?php echo $store['cashback_text'] ?></b></a>
                                 </div>
                              </div>
                              <br>
                              <div class="row">
                                 <div class="col-md-12">
                                    <a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank" ?> <button class="btn btn-danger btn-block" style="font-size:10px;">SHOP STORES</button></a> <br>
                                    <a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank" ?> <button class="btn btn-danger btn-block" style="font-size:10px;">Shop Now</button></a>
                                 </div>
                              </div>
                              <br>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php if(($rows+5)%4 == 0){ ?>
               </div>
               <?php } 
                  ?>
               <?php
                  $index += 1;
                  $rows++;
                          } ?>
				                       <?php $q = true; $r = true; $s = true;
$t = true; $u = true; $v = true; $w = true; $x = true;$y = true;$z = true; 
$row=0;
foreach ($stores3 as $store) {
                      ?>
               <?php if($rows%4 == 0){ ?>
               <div class="row">
                  <?php } ?>
                  
						<?php if(substr($store['name'], 0, 1) == 'Q' AND $q == true){
						?><div class="">
							<a id="Q" class="btn btn-number btn-number-page" href="#0">Q</a>
							</div>
              	<?php $q = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'R' AND $r == true){
						?><div class="">
							<a id="R" class="btn btn-number btn-number-page" href="#0">R</a>
							</div>
              <?php $r = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'S' AND $s == true){
						?><div class="">
							<a id="S" class="btn btn-number btn-number-page" href="#0">S</a>
							</div>
              <?php $s = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'T' AND $t == true){
						?><div class="">
							<a id="T" class="btn btn-number btn-number-page" href="#0">T</a>
							</div>
              <?php $t = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'U' AND $u == true){
						?><div class="">
							<a id="U" class="btn btn-number btn-number-page" href="#0">U</a>
							</div>
              <?php $u = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'V' AND $v == true){
						?><div class="">
							<a id="V" class="btn btn-number btn-number-page" href="#0">V</a>
							</div>
              <?php $v = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'W' AND $w == true){
						?><div class="">
							<a id="W" class="btn btn-number btn-number-page" href="#0">W</a>
							</div>
              <?php $w = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'X' AND $x == true){
						?><div class="">
							<a id="X" class="btn btn-number btn-number-page" href="#0">X</a>
							</div>
              <?php $x = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'Y' AND $y == true){
						?><div class="">
							<a id="Y" class="btn btn-number btn-number-page" href="#0">Y</a>
							</div>
              <?php $y = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'Z' AND $z == true){
						?><div class="">
							<a id="Z" class="btn btn-number btn-number-page" href="#0">Z</a>
							</div>
              <?php $z = false; } ?>
                  
                  <div class="col-md-3 col-xs-6 col-sm-6">
                     <div class="row">
                        <div class="panel bee_panels">
                           <div class="panel-body">
                              <div class="row">
                                 <div class="col-md-12">
                                    <a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank"> <img style="height:50px !important;" src="<?php echo $store['logo_thumb'] ?>" alt="<?php echo $store['name'] ?>" class="img-responsive">   </a>
                                 </div>
                              </div>
                              <br>
                              <br>
                              <div class="row">
                                 <div class="col-md-12">
                                    <p><a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank" ?><?php echo $store['name'] ?></a> </p>
                                    <!-- <p><?php //echo substr($store['description-abrv'], 0, 35); ?> <a href="<?php //echo SURL."stores/details/".$store['id'] ?>">more</a></p> -->     
                                 </div>
                              </div>
                              <br>
                              <div class="row">
                                 <div class="col-md-12">
                                    <a href="<?php echo SURL."stores/details/".$store['id'] ?>" style="color: #000"><b><?php echo $store['cashback_text'] ?></b></a>
                                 </div>
                              </div>
                              <br>
                              <div class="row">
                                 <div class="col-md-12">
                                    <a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank" ?> <button class="btn btn-danger btn-block" style="font-size:10px;">SHOP STORES</button></a> <br>
                                    <a href="<?php echo s3path('/transfer/store/'.$store['id'].''); ?>" target="_blank" ?> <button class="btn btn-danger btn-block" style="font-size:10px;">Shop Now</button></a>
                                 </div>
                              </div>
                              <br>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php if(($rows+5)%4 == 0){ ?>
               </div>
               <?php } 
                  ?>
               <?php
                  $index += 1;
                  $rows++;
                          } ?>
				
											
            </div>
         </div>
      </div>
   <!--   
	  <nav class="text-center">
		   <ul class="pagination pagination-lg" role="navigation">
			  <?php /* $count=$count/12; 
				$sSURL=s3path('/stores/search');
				$totalp =	ceil($count);
				$startClass = "";
				$endClass = "";
				$start = $page;
				$end = $page+4;
				
				if($page==1)
				{
					$startClass = "disabled";
					$start = 1;
					$end = 5;
				}
				if($page+3>= $totalp)
				{
					$endClass = "disabled";
					$start = $totalp-3;
					$end = $totalp+1;
				}
				
				echo '<li class="'.$startClass.'" role="presentation"><a rel="nofollow" role="button" href='.$sSURL.'?page='.($page-1).'  aria-label="Previous"><i class="fa fa-chevron-left" aria-hidden="true"></i><span class="sr-only">previous</span></a></li>';
				for($i=$start; $i<$end; $i++)
				{
					if($i==$page){ 
					echo '<li class="active" role="presentation"><a rel="nofollow" role="button" href='.$sSURL.'?page='.$i.' aria-label="Page #{i}">'.$i.'</a></li>';

					}
					else 
					{
					echo '<li role="presentation"><a rel="nofollow" role="button" href='.$sSURL.'?page='.$i.' aria-label="Page #{i}">'.$i.'</a></li>';
					}
				}
				echo '<li class="'.$endClass.'" role="presentation"><a rel="nofollow" role="button" href='.$sSURL.'?page='.($page+1).' aria-label="Next"><i class="fa fa-chevron-right" aria-hidden="true"></i><span class="sr-only">next</span></a></li>';
			*/	?>
		   </ul>
		 </nav>
   
   -->
   </div>
</section>
<!--    <div class="BGLeftCol">
   page Title 
   <div id="pageTitle" >
      <div id="pageTitleLeft"></div>
      <h1>Cash Back Stores</h1>
      <div id="pageTitleRight"></div>
      <div id="titleNav" class="small">
          <a class="pad" href="/stores/search">ALL</a>
          <a href="/stores/search?q=0">#</a>
   <?php for ($ord = ord('a'); $ord <= ord('z'); $ord++) : ?>
   <?php $chr = chr($ord) ?>
   <?php $url = "/stores/search/?q=$chr" . ($category ? "&category=$category" : "") ?>
              <a class="uppercase" href="<?php echo escape($url, 'html_attr') ?>"><?php echo $chr ?></a>
   <?php endfor ?>
      </div>
   </div>
   /page Title 
   
   Left side 
   <div id="facetNav">
      <div id="category">
          <div class="facet" >
              <div id="category-bt" class="cat-bg">
                  <div id="cat-left-curve"><img src="<?php echo s3path("/images/cat-left-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
                  <div id="cat-right-curve"><img src="<?php echo s3path("/images/cat-right-curve.jpg") ?>" width="4" height="35" alt="** PLEASE DESCRIBE THIS IMAGE **"/></div>
                  <div class="parent">Jump to a Store</div>
              </div>
   
              <div id="category-bg">
                  <div class="child">
                      <div style="clear:both;height:5px;"></div>
                      <div style="margin-left:10px;margin-bottom:10px;">
                          <select name="merchant" id="merchantSelect" onchange="if(this.options[this.selectedIndex].value !=''){window.location=this.options[this.selectedIndex].value}">
                              <option selected="selected" value="">ALL</option>
                              {store_list}
                                  <option value="/stores/details/{id}">{name}</option>
                              {/store_list}
                          </select>
                      </div>
   
                      <div class="sub-category-txt">Store category</div>
                      <div id="sub-category-bg">
                          <div class="child">
                              <div class="holder osX">
                                  <div id="pane1" class="scroll-pane">
                                      <ul class="bullets">
                                          <li><a href="/stores/search">ALL</a></li>
   <?php foreach ($categories as $category) : ?>
                                                  <li><a href="<?php echo escape("/stores/search?category=" . $category['id'], 'html_attr') ?>"><?php echo escape($category['name']) ?></a></li>
   <?php endforeach ?>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div style="clear:both;height:5px;"></div>
                  </div>
              </div>
          </div>
   
   
      </div>
   </div>
   /Left side
   
   Right side 
   
   
   <?php
      $index = 0;
      $ad = 0;
      foreach ($stores as $store) {
          ?>
           <div class="couponList inactive" >
           <div class="logo" >
           <a href="/stores/details/<?php echo $store['id'] ?>"><img class="cdn-image"
   onload="
      var width=100;
   var height=32;
   var ratio= Math.min(width/this.width, height/this.height);
   var nwidth=ratio*this.width;
   var nheight=ratio*this.height;
   this.width=nwidth;
   this.height=nheight;"
   src="<?php echo $store['logo_thumb'] ?>" alt="<?php echo $store['name'] ?>"></a>
          </div>
   
          <div class="desc">
          <h3><a href="/stores/details/<?php echo $store['id'] ?>" title="<?php echo $store['name'] ?>"><?php echo $store['name'] ?></a></h3>
   <?php echo $store['description-abrv'] ?> <a class="moreLink" href="/stores/details/<?php echo $store['id'] ?>">more ›</a>
          </div>
   
          <div class="coupons">
   <?php if ($store['coupons']) : ?>
                  <div class="coupon dot"><a href="/stores/details/<?php echo $store['id'] ?>"><?php echo $store['coupons'] ?> Coupons</a></div>
   <?php else : ?>
                  <div class="coupon"></div>
   <?php endif ?>
          </div>
   
          <div class="CashBack" style="border:0px solid #000;"><div class="CashBack-Bt1 BtnCBOrangeBg" <?php if (empty($store['cashback_text'])) : ?>style="visibility:hidden"<?php endif ?>><a href="/stores/details/<?php echo $store['id'] ?>" rel="nofollow"><span class="CashBack-value value"><?php echo $store['cashback_text'] ?></span></a></div></div>
              <div class="ShopStore" style><div class="ShopStore-Bt"><a class="button" href="/stores/details/<?php echo $store['id'] ?>" rel="nofollow">SHOP STORE</a></div></div>
      </div>
   
   <?php
      $index += 1;
      }
      ?>
   <div style="border:1px solid #000;float:right;position:relative;margin-right:4px;">
   <script type='text/javascript'>
   OA_show(7);
   </script><noscript><a target='_blank' href='http://50.16.95.24/openx/www/delivery/ck.php?n=a88fd39'><img border='0' alt='' src='http://50.16.95.24/openx/www/delivery/avw.php?zoneid=7&amp;n=a88fd39' /></a></noscript>
   <!--<img src="<?php echo s3path("/images/rightbanner.jpg") ?>">
          </div>
   <div class="pag">
   
   
   <div id="Pagination" class="pagination-controls"></div>
   <div class="pagination-info">Showing results <strong>{start}</strong> to <strong>{end}</strong> of <strong>{count}</strong></div>
   </div>
      <div style="clear: both;"></div>
              </div>-->

<script>
   $(document).ready(function () {
       var isInit = true;
       function pageselectCallback(page_index, jq) {
   
           if (isInit) {
               isInit = false;
               return false;
           }
           // Get number of elements per pagination page from form
           var items_per_page = $('#items_per_page').val();
   
           var length = {count};
           var max_elem = Math.min((page_index + 1) * items_per_page, length);
           var newcontent = '';
           var page = jq.find(".current")[0].textContent;
           if (page == undefined) {
               page = jq.find(".current")[0].innerText;
           }
           if (page == "Prev") {
               page = "1";
           }
           var pat = new RegExp("page=[0-9]*");
           if (pat.test(document.URL)) {
               window.location = (document.URL).replace(pat, "page=" + page);
           } else {
               var pat = new RegExp("[?]");
               if (pat.test(document.URL)) {
                   window.location = (document.URL) + "&page=" + page;
               } else {
                   window.location = (document.URL) + "?page=" + page;
               }
           }
           // Iterate through a selection of the content and build an HTML string
           for (var i = page_index * items_per_page; i < max_elem; i++)
           {
           }
   
           // Replace old content with new content
   
           // Prevent click eventpropagation
           return false;
       }
   
       function getOptions() {
           var opt = {callback: pageselectCallback};
           var page = {page_index};
                   opt["current_page"] = {page_index};
           opt["num_edge_entries"] = 1;
           opt["num_display_entries"] = 5;
           opt["prev_show_always"] = false;
           opt["next_show_always"] = false;
           opt["prev_text"] = "Prev <<";
           opt["next_text"] = "Next >>";
           opt["ellipse_text"] = "<span class='spacer'>...</span>";
                   opt["items_per_page"] = {limit};
           opt["link_to"] = document.URL;
           return opt;
       }
   
       // When document has loaded, initialize pagination and form
       // Create pagination element with options from form
       var optInit = getOptions();
               $("#Pagination").pagination({count}, optInit);
   });
</script>
<!-- Right side -->
<!-- /content -->
<!-- footer -->
{footer}
{footer_script}
<!-- /footer -->