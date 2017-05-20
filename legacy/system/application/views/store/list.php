{header}
    <!-- Navigation bar -->
	<?php if($this->db_session->userdata('login')['login']){ ?>

<?php $this->load->view('blocks/admin-topbar'); ?>
<?php }else{ ?>
   <?php $this->load->view('blocks/nav_bar'); ?>
<?php }
 ?>
 

 
 <style type='text/css'>
 
.btn-number{padding: 7px 12px !important;}

 </style>
<div class="space20"></div>
<section id="bee_all">
    <div class="container">
	
	
	                <div class="row row-padding">
                    <div class="col-md-3">
                        <h3><b>All Stores</b></h3>
                    </div>
                    <div class="col-md-6">
            <div style="background-color: rgba(0, 0, 0, 0.05);">
            	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- All Stores -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="1353556975"
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
                                <li><a class="btn-number-page" href="#U"> <img src=<?php echo s3path("/img/icon/U.png");?>></a></li>
                                <li><a class="btn-number-page" href="#V"> <img src=<?php echo s3path("/img/icon/V.png");?>></a></li>
                                <li><a class="btn-number-page" href="#X"> <img src=<?php echo s3path("/img/icon/X.png");?>></a></li>
                                <li><a class="btn-number-page" href="#Y"> <img src=<?php echo s3path("/img/icon/Y.png");?>></a></li>
                                <li><a class="btn-number-page" href="#Z"> <img src=<?php echo s3path("/img/icon/Z.png");?>></a></li>
                               
                            </ul>  
                </div>    
            </div>
        </div>
       
	
       
        <div class="row">
		  <?php $flag = true; $a = true;
			$b = true; $c = true; $d = true; $e = true;
			$row=0;

		  if ($stores1) { ?>
            <?php foreach($stores1 as $key => $store){ ?>
            
            <?php if($row%4==0)  {?>
            <div class="row">
            <?php } ?>
              <div class="col-md-3">

			
                    
						<?php if(is_numeric(substr($store['name'], 0, 1)) AND $flag == true){
						?>
							<a id="#" class="btn btn-number btn-number-page" href="#0">#</a>
								<?php $flag = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'A' AND $a == true){
						?>
							<a id="A" class="btn btn-number btn-number-page" href="#0">A</a>
							<?php $a = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'B' AND $b == true){
						?>
							<a id="B" class="btn btn-number btn-number-page" href="#0">B</a>
							<?php $b = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'C' AND $c == true){
						?>
							<a id="C" class="btn btn-number btn-number-page" href="#0">C</a>
							<?php $c = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'D' AND $d == true){
						?>
							<a id="D" class="btn btn-number btn-number-page" href="#0">D</a>
							<?php $d = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'E' AND $e == true){
						?>
							<a id="E" class="btn btn-number btn-number-page" href="#0">E</a>
							<?php $e = false; } ?>
                        <br>
                           <ul class="">
                            <li><a href="details/<?php echo $store['id'] ?>"> <p> <?php echo $store['name'] ?>  </p></a><p><small><?php echo $store['cashback_text'];?> Cash Back</small></p></li>
                        </ul>
                    </div> 
                    
                    
            <?php if(($row+5)%4==0)  {?>
            </div>
            <?php } ?>
			<?php $row=$row+1;} ?>
        <?php } ?>
		

		<?php $f = true; $g = true; $h = true;
$i = true; $j = true; $k = true;$l = true;$m = true;$n = true;$o = true;$p = true; $row=0;



		  if ($stores1) { ?>
            <?php foreach($stores2 as $key => $store){ ?>
              <?php if($row%4==0)  {?>
            <div class="row">
            <?php } ?>
			<div class="col-md-3 row-padding">
                      
						<?php if(substr($store['name'], 0, 1) == 'F' AND $f == true){
						?>
							<a id="F" class="btn btn-number btn-number-page" href="#0">F</a>
								<?php $f = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'G' AND $g == true){
						?>
							<a id="G" class="btn btn-number btn-number-page" href="#0">G</a>
							<?php $g = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'H' AND $h == true){
						?>
							<a id="H" class="btn btn-number btn-number-page" href="#0">H</a>
							<?php $h = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'I' AND $i == true){
						?>
							<a id="I" class="btn btn-number btn-number-page" href="#0">I</a>
							<?php $i = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'J' AND $j == true){
						?>
							<a id="J" class="btn btn-number btn-number-page" href="#0">J</a>
							<?php $j = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'K' AND $k == true){
						?>
							<a id="K" class="btn btn-number btn-number-page" href="#0">K</a>
							<?php $k = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'L' AND $l == true){
						?>
							<a id="L" class="btn btn-number btn-number-page" href="#0">L</a>
							<?php $l = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'M' AND $m == true){
						?>
							<a id="M" class="btn btn-number btn-number-page" href="#0">M</a>
							<?php $m = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'N' AND $n == true){
						?>
							<a id="N" class="btn btn-number btn-number-page" href="#0">N</a>
							<?php $n = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'O' AND $o == true){
						?>
							<a id="O" class="btn btn-number btn-number-page" href="#0">O</a>
							<?php $o = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'P' AND $p == true){
						?>
							<a id="P" class="btn btn-number btn-number-page" href="#0">P</a>
							<?php $p = false; } ?>
                        <br>
                        <ul class="">
                            <li><a href="details/<?php echo $store['id'] ?>"> <p> <?php echo $store['name'] ?>  </p></a><p><small><?php echo $store['cashback_text'];?> Cash Back</small></p></li>
                        </ul>
                    </div> 
                    
                     <?php if(($row+5)%4 == 0){ ?>
            </div>
            <?php } $row++; ?>
                    
			<?php } ?>
        <?php } ?> 
		<?php $q = true; $r = true; $s = true;
$t = true; $u = true; $v = true; $w = true; $x = true;$y = true;$z = true; 
$row=0;
		  if ($stores1) { ?>
            <?php foreach($stores3 as $key => $store){ ?>
             <?php if($row%4==0)  {?>
            <div class="row">
            <?php } ?>
			<div class="col-md-3">
                     
						<?php if(substr($store['name'], 0, 1) == 'Q' AND $q == true){
						?>
							<a id="Q" class="btn btn-number btn-number-page" href="#0">Q</a>
								<?php $q = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'R' AND $r == true){
						?>
							<a id="R" class="btn btn-number btn-number-page" href="#0">R</a>
							<?php $r = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'S' AND $s == true){
						?>
							<a id="S" class="btn btn-number btn-number-page" href="#0">S</a>
							<?php $s = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'T' AND $t == true){
						?>
							<a id="T" class="btn btn-number btn-number-page" href="#0">T</a>
							<?php $t = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'U' AND $u == true){
						?>
							<a id="U" class="btn btn-number btn-number-page" href="#0">U</a>
							<?php $u = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'V' AND $v == true){
						?>
							<a id="V" class="btn btn-number btn-number-page" href="#0">V</a>
							<?php $v = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'W' AND $w == true){
						?>
							<a id="W" class="btn btn-number btn-number-page" href="#0">W</a>
							<?php $w = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'X' AND $x == true){
						?>
							<a id="X" class="btn btn-number btn-number-page" href="#0">X</a>
							<?php $x = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'Y' AND $y == true){
						?>
							<a id="Y" class="btn btn-number btn-number-page" href="#0">Y</a>
							<?php $y = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'Z' AND $z == true){
						?>
							<a id="Z" class="btn btn-number btn-number-page" href="#0">Z</a>
							<?php $z = false; } ?>
                        <br>
                        <ul class="">
                            <li><a href="details/<?php echo $store['id'] ?>"> <p> <?php echo $store['name'] ?>  </p></a><p><small><?php echo $store['cashback_text'];?> Cash Back</small></p></li>
                        </ul>
                    </div> 
                     <?php if(($row+5)%4 == 0)  {?>
            </div>
            <?php } 
			
			$row=$row+1;
			?>
			<?php } ?>
        <?php } ?>    


    </div>
        
</section>

<!--
<DIV id=sitemap>
    <UL class=sitemap-col>
        <?php if ($stores1) { ?>
            {stores1}
            <LI><A href="/stores/details/{id}">{name}</A></LI>
            {/stores1}
        <?php } ?>
    </UL>
    <UL class=sitemap-col>
        <?php if ($stores2) { ?>
            {stores2}
            <LI><A href="/stores/details/{id}">{name}</A></LI>
            {/stores2}
        <?php } ?>
    </UL>
    <UL class=sitemap-col>
        <?php if ($stores3) { ?>
            {stores3}
            <LI><A href="/stores/details/{id}">{name}</A></LI>
            {/stores3}
        <?php } ?>
    </UL>
</DIV>
-->
<!-- Right side -->



<!-- /content -->


<section id="bee_back_to_top">
<div id="back-to-top" class="back-to-top"></div>

</section>






<!-- footer -->  
{footer}
<!-- /footer --> 
{footer_script}




