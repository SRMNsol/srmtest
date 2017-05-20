{header}
    <!-- Navigation bar -->
	<?php if($this->db_session->userdata('login')['login']){ ?>

<?php $this->load->view('blocks/admin-topbar'); ?>
<?php }else{ ?>
    {nav_bar}
<?php }
 ?>

<section id="bee_all">
    <div class="container">
        <div class="row row-padding">
            <div class="col-md-6">
                <h3 class="allstores-head"><b>All Stores</b></h3>
                <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a>
            </div>
            <div class="col-md-6">
                <form class="navbar-form pull-right"  action="<?php echo s3path('/search'); ?>" role="search">
                    <div class="input-group add-on">
                        <input class="form-control" placeholder="Search by Store" name="q" id="srch-term" type="text">
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

                    <ul class="pagination ">

                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=a">A</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=b">B</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=c">C</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=d">D</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=e">E</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=f">F</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=g">G</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=h">H</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=i">I</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=j">J</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=k">K</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=l">L</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=m">M</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=n">N</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=o">O</a></li> 
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=p">P</a></li> 
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=q">Q</a></li> 
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=r">R</a></li> 
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=s">S</a></li> 
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=t">T</a></li> 
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=u">U</a></li> 
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=v">V</a></li> 
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=w">W</a></li> 
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=x">X</a></li> 
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=y">Y</a></li>
                        <li><a class="btn-number-page" href="<?php echo s3path('/stores/search'); ?>?q=z">Z</a></li>             

                    </ul>  
                </div>    
            </div>


        </div>
        <div class="row">
		  <?php $flag = true; $a = true;
$b = true; $c = true; $d = true; $e = true;

		  if ($stores1) { ?>
            <?php foreach($stores1 as $key => $store){ ?>
			<div class="col-md-3">
                        <!-- <button type="button" class="btn btn-number"><img src="img/icon/#.png"></button> -->
						<?php if(is_numeric(substr($store['name'], 0, 1)) AND $flag == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">#</a>
								<?php $flag = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'A' AND $a == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">A</a>
							<?php $a = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'B' AND $b == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">B</a>
							<?php $b = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'C' AND $c == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">C</a>
							<?php $c = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'D' AND $d == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">D</a>
							<?php $d = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'E' AND $e == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">E</a>
							<?php $e = false; } ?>
                        <br>
                        <ul class="">
                            <li><a href="details/<?php echo $store['id'] ?>"> <p> <?php echo $store['name'] ?>  </p></a><p><small><?php echo $store['cashback_text'];?> Cash Back</small></p></li>
                        </ul>
                    </div> 
			<?php } ?>
        <?php } ?>
		
		<?php $f = true; $g = true; $h = true;
$i = true; $j = true; $k = true;$l = true;$m = true;$n = true;$o = true;$p = true; 

		  if ($stores1) { ?>
            <?php foreach($stores2 as $key => $store){ ?>
			<div class="col-md-3">
                        <!-- <button type="button" class="btn btn-number"><img src="img/icon/#.png"></button> -->
						<?php if(substr($store['name'], 0, 1) == 'F' AND $f == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">F</a>
								<?php $f = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'G' AND $g == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">G</a>
							<?php $g = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'H' AND $h == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">H</a>
							<?php $h = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'I' AND $i == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">I</a>
							<?php $i = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'J' AND $j == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">J</a>
							<?php $j = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'K' AND $k == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">K</a>
							<?php $k = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'L' AND $l == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">L</a>
							<?php $l = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'M' AND $m == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">M</a>
							<?php $m = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'N' AND $n == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">N</a>
							<?php $n = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'O' AND $o == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">O</a>
							<?php $o = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'P' AND $p == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">P</a>
							<?php $p = false; } ?>
                        <br>
                        <ul class="">
                            <li><a href="details/<?php echo $store['id'] ?>"> <p> <?php echo $store['name'] ?>  </p></a><p><small><?php echo $store['cashback_text'];?> Cash Back</small></p></li>
                        </ul>
                    </div> 
			<?php } ?>
        <?php } ?> 
		<?php $q = true; $r = true; $s = true;
$t = true; $u = true; $v = true; $w = true; $x = true;$y = true;$z = true; 

		  if ($stores1) { ?>
            <?php foreach($stores3 as $key => $store){ ?>
			<div class="col-md-3">
                        <!-- <button type="button" class="btn btn-number"><img src="img/icon/#.png"></button> -->
						<?php if(substr($store['name'], 0, 1) == 'Q' AND $q == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">Q</a>
								<?php $q = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'R' AND $r == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">R</a>
							<?php $r = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'S' AND $s == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">S</a>
							<?php $s = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'T' AND $t == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">T</a>
							<?php $t = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'U' AND $u == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">U</a>
							<?php $u = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'V' AND $v == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">V</a>
							<?php $v = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'W' AND $w == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">W</a>
							<?php $w = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'X' AND $x == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">X</a>
							<?php $x = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'Y' AND $y == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">Y</a>
							<?php $y = false; } ?>
						<?php if(substr($store['name'], 0, 1) == 'Z' AND $z == true){
						?>
							<a class="btn btn-number btn-number-page" href="#0">Z</a>
							<?php $z = false; } ?>
                        <br>
                        <ul class="">
                            <li><a href="details/<?php echo $store['id'] ?>"> <p> <?php echo $store['name'] ?>  </p></a><p><small><?php echo $store['cashback_text'];?> Cash Back</small></p></li>
                        </ul>
                    </div> 
			<?php } ?>
        <?php } ?>    


    </div>
</section>


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
<!-- Right side -->



<!-- /content -->



<!-- footer -->  
{footer}
<!-- /footer --> 
{footer_script}
