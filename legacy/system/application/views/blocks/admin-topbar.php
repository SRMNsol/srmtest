
<body>
    <section id="bee_topbar">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="show_mob_tab_only">
                        <a class="navbar-brand " href="<?php echo s3path('/');?>"><img class="img-responsive" src="<?php echo s3path("/images/mega_logo.png") ?>"></a>
                    </div>
                </div>
                <div class="col-md-5 col-sm-6 col-xs-12">
                    <form class="navbar-form" action="<?php echo s3path('/search'); ?>" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for Store" name="q">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-12">
                    <ul class="options bee_login">
                        
                        <li><a  href="<?php echo s3path('/account'); ?>">Account </a> </li>
                        <li > <a href="<?php echo s3path('/account/logout'); ?>"> Logout </a> </li> 
                        <li> <a class="ative" href="<?php echo s3path('/info/how'); ?>"> Help </a> </li>     
                    </ul>
                </div>
            </div>
        </div>
    </section>

	<section id="bee_nav">
        <nav class="navbar navbar-default bee_navbar">
            <div class="container">
                <div class="navbar-header">
                  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <div class="show_tv_only">
                    <a class="navbar-brand bee_mega_logo" href="<?php echo s3path('/');?>"><img class="img-responsive" src="<?php echo s3path("/images/mega_logo.png") ?>"></a>
                </div>
                
                </div>
                <div class="collapse navbar-collapse js-navbar-collapse">
                    <div class="row">
                   
                    <div class="col-md-10">    
                  <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown mega-dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">SHOP BY CATEGORY <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>

                     <ul class="dropdown-menu mega-dropdown-menu row">
                                                
                                            <?php 
                                             $r=0;
                                            foreach ($categories as $category) : ?>
                                                
                                                <?php    
                                                if($r==0){
                                                echo '<li class="col-sm-4"><ul>';
                                            } 
                                                 if($r % 5 == 0 && $r !=0){
                                            echo '</ul></li><li class="col-sm-4">
                                                   <ul>';
                                                } 
                                                
                                                ?>
                                             <li><a href="<?php echo SURL?>product/category?category=<?php echo escape($category['id'], 'html_attr') ?>"><?php echo escape($category['name']) ?></a></li>  
                                             
                                            <?php $r++; endforeach ?>

                                        </ul></li>

                                    </ul>

                    </li>
                  <!--  <li><a href="allstores.html">FIND A STORE</a></li> -->
                    <li><a href="<?php echo SURL?>stores/search">SHOP BY STORE</a></li>
                    <li><a href="<?php echo SURL?>stores/storelist">ALL STORES</a></li>
                  </ul>
                </div>
                <div class="col-md-2"></div>
                </div>
                </div>
                <!-- /.nav-collapse -->
            </div>
        </nav>
    </section>
	