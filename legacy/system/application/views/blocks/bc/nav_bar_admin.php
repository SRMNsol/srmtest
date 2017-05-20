   <section id="admin-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-xs-12 col-sm-12">
                        <a href="<?php echo SURL?>"> <img src="<?php echo ASSETURL?>/images/logo.png" alt="" class="img-responsive"></a>
                    </div>  
                    <!-- <div class="col-md-6 col-xs-6 col-sm-2 hideonsm">
                        <ul class="">
                            <li>  <img src="../img/facebooktop.png" class="img-responsive">  </li>
                            <li> <img src="../img/twittertop.png" class="img-responsive"> </li>
                            <li> <img src="../img/youtubetop.png" class="img-responsive"> </li>    
                        </ul>
                    </div> -->
                    <div class="col-md-4 col-xs-12 col-sm-12 pull-right">
                        <ul class="options">
                            <li> Welcome</li>
                            <li><a href="account.php">Account </a> </li>
                            <li > <a href="#"> Logout </a> </li> 
                            <li> <a href="<?php echo SURL?>info/how"> Help </a> </li>     
                        </ul>
                    </div>    
                </div>    
            </div>
        </section>

<section id="admin_nav">
<div class="container">
<nav class="navbar navbar-inverse bee_admin_nav">
    <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        
    </div>
    
    <div class="collapse navbar-collapse js-navbar-collapse">
        
        <ul class="nav navbar-nav">
            <li class="dropdown mega-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">SHOP BY CATEGORY<span class="fa fa-caret-down pull-right" style=" position: relative; top: 5px; left: 5px;"></span></a>
                
                <ul class="dropdown-menu mega-dropdown-menu row">
                    <li class="col-sm-4">
                        <ul>
                            <!-- <li class="dropdown-header"><a href="#">Annuities</a></li> -->
                            <!-- <li class="divider"></li> -->
                            <!-- <li class="dropdown-subheader">Trading Grid</li> -->
                            <li><a href="#">Acedemics & Media</a></li>
                            <li><a href="#">Music</a></li>
                            <li><a href="#">Automotives</a></li>
                            <!-- <li class="divider"></li> -->
                            <li><a href="#">Business Office</a></li>
                            <li><a href="#">Flowers</a></li>
                            <li><a href="#">Power Sports</a></li>
                            <li><a href="#">Officers</a></li>
                        </ul>
                    </li>
                    <li class="col-sm-4">
                        <ul>
                            <!-- <li class="dropdown-header">Retirement</li> -->
                            <!-- <li class="divider"></li> -->
                            <li><a href="#">Clothing</a></li>
                            <li><a href="#">Fashion</a></li>
                            <li><a href="#">Food</a></li>
                            <li><a href="#">Computers</a></li>
                            <li><a href="#">General Stpres</a></li>
                            <li><a href="#">Kids & Baby</a></li>
                        </ul>
                    </li>
                    <li class="col-sm-4">
                        <ul>
                            <li class="dropdown-header"></li>
                            <!-- <li class="divider"></li> -->
                            <li><a href="#">Jewelry</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Food & Garment</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

   
        </ul>
        <div class="col-sm-1"></div>
        <form class="navbar-form navbar-left col-sm-6" role="search">
            <div class="form-group">
            <span style="color: #fff; padding-right: 5px;">FIND A STORE </span>  <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <ul class="nav navbar-nav navbar-right col-sm-4">
        <div class="navbar-form pull-right">
            <a type="submit" class="btn btn-default" href="<?php echo SURL?>stores/search">SHOP BY STORE</a>
            <a type="submit" class="btn btn-default" href="<?php echo SURL?>stores/storelist">ALL STORES</a>
        </div>
        </ul>
    </div><!-- /.nav-collapse -->
</nav>
</div>



</section>