<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{header}
<body>
<div id="container">
<!-- Header -->      
{banner}
<!-- /Header -->

<!-- Navigation bar -->
{nav_bar}
<!-- /Navigation bar -->



<!-- content -->
		<!-- page Title -->
 		
		<DIV id=content class=BGNoCol>
<DIV id=pageTitle>
<DIV id=pageTitleLeft></DIV>
<H1>All Stores</H1>
<DIV id=pageTitleRight></DIV>
<DIV id=titleNav class=small><A href="/stores/{action}/0">#</A> 
<A class=uppercase href="/stores/{action}/a">a</A> <A 
class=uppercase href="/stores/{action}/b">b</A> <A 
class=uppercase href="/stores/{action}/c">c</A> <A 
class=uppercase href="/stores/{action}/d">d</A> <A 
class=uppercase href="/stores/{action}/e">e</A> <A 
class=uppercase href="/stores/{action}/f">f</A> <A 
class=uppercase href="/stores/{action}/g">g</A> <A 
class=uppercase href="/stores/{action}/h">h</A> <A 
class=uppercase href="/stores/{action}/i">i</A> <A 
class=uppercase href="/stores/{action}/j">j</A> <A 
class=uppercase href="/stores/{action}/k">k</A> <A 
class=uppercase href="/stores/{action}/l">l</A> <A 
class=uppercase href="/stores/{action}/m">m</A> <A 
class=uppercase href="/stores/{action}/n">n</A> <A 
class=uppercase href="/stores/{action}/o">o</A> <A 
class=uppercase href="/stores/{action}/p">p</A> <A 
class=uppercase href="/stores/{action}/q">q</A> <A 
class=uppercase href="/stores/{action}/r">r</A> <A 
class=uppercase href="/stores/{action}/s">s</A> <A 
class=uppercase href="/stores/{action}/t">t</A> <A 
class=uppercase href="/stores/{action}/u">u</A> <A 
class=uppercase href="/stores/{action}/v">v</A> <A 
class=uppercase href="/stores/{action}/w">w</A> <A 
class=uppercase href="/stores/{action}/x">x</A> <A 
class=uppercase href="/stores/{action}/y">y</A> <A 
class=uppercase href="/stores/{action}/z">z</A> </DIV></DIV>
<div id=sitemap>
    <ul class=sitemap-col>
    <?php foreach ($stores1 as $store) { ?>
        <li><a href="/transfer/store/<?php echo $store['id'] ?><?php echo $skip ?>" target="_blank"><?php echo escape($store['name']) ?></a></li>
    <?php } ?>
    </ul>
    <ul class=sitemap-col>
    <?php foreach ($stores2 as $store) { ?>
        <li><a href="/transfer/store/<?php echo $store['id'] ?><?php echo $skip ?>" target="_blank"><?php echo escape($store['name']) ?></a></li>
    <?php } ?>
    </ul>
    <ul class=sitemap-col>
    <?php foreach ($stores3 as $store) { ?>
        <li><a href="/transfer/store/<?php echo $store['id'] ?><?php echo $skip ?>" target="_blank"><?php echo escape($store['name']) ?></a></li>
    <?php } ?>
    </ul>
</div>
<DIV style="HEIGHT: 10px; CLEAR: both"></DIV></DIV>
		

       <!-- Right side -->



<!-- /content -->

         
      
<!-- footer -->  
{footer}
<!-- /footer --> 




  </body>
  </html>
