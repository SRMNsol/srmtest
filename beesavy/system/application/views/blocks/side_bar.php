<?
$states = array(
    'how'=>'',
    'lm'=>'',
    'faq'=>'',
    'aboutus'=>'',
    'terms'=>'',
    'privacy'=>'',
    'contact'=>''
);
$parentstates = array(
    'how'=>'class="parent" ',
    'lm'=>'class="parent" ',
    'faq'=>'class="parent" ',
    'aboutus'=>'class="parent" ',
    'terms'=>'class="parent" ',
    'privacy'=>'class="parent" ',
    'contact'=>'class="parent" '
);
foreach($states as $state=>$value){
    if(strpos($info, $state)!==false){
        $states[$state] = 'id="active" ';
        $parentstates[$state] = 'class="parentActive" ';
    }
}
?>


<div id="facetNav">
<div id="catagory">
	<div>     
		<form id="facetForm" name="facetForm" action="/search" method="get">
 		<input type="hidden" name="q" value="" />
		<input type="hidden" name="page" id="page" value="" />
        <div <? echo $parentstates['how']?> ><a <? echo $states['how']?> href="/info/how" style='cursor:pointer'><div class="HelpFullBox">How It Works</div></a></div>
        <div <? echo $parentstates['lm']?> ><a <? echo $states['lm']?> href="/info/lm_overview" style='cursor:pointer'><div class="HelpFullBox">Learn More</div></a></div>
<?php if($states['lm']!=''){?>
<script type="text/javascript">
$(document).ready(function (){
$('.Sub li a[href=/info/<?php echo $info?>]').addClass('ActiveSub');
});
</script>
<div class="child" >
			<ul class="Sub">
			<li><a href="/info/lm_overview">Overview</a></li>
			<li><a href="/info/lm_cashback">Cash Back</a></li>
			<li><a href="/info/lm_compare">Compare Prices</a></li>
			<li><a href="/info/lm_shop">Shop By Store</a></li>
			<li><a href="/info/lm_coupon">Coupon Savings</a></li>
			<li><a href="/info/lm_referral" >Referral Cash Back</a></li>
			<li><a href="/info/lm_join">Join For Free</a></li>			
			</ul>	
            </div>
<? }?>
		<div <? echo $parentstates['faq']?>><a <? echo $states['faq']?> href="/info/faq" style='cursor:pointer'><div class="HelpFullBox">FAQ's</div></a></div>
		<div <? echo $parentstates['aboutus']?>><span><a <? echo $states['aboutus']?> href="/info/aboutus" style='cursor:pointer'><div class="HelpFullBox">About Us</div></a></span></div>
		<div <? echo $parentstates['privacy']?> ><span><a <? echo $states['privacy']?> href="/info/privacy" style='cursor:pointer'><div class="HelpFullBox">Privacy Policy</div></a></span></div>
		<div <? echo $parentstates['terms']?> ><span><a <? echo $states['terms']?> href="/info/terms" style='cursor:pointer'><div class="HelpFullBox">Terms of Service</div></a></span></div>			
		<div <? echo $parentstates['contact']?> ><span><a <? echo $states['contact']?> href="/info/contact" style='cursor:pointer'><div class="HelpFullBox">Contact Us</div></a></span></div>
		</form>
		</div>
    </div> 
</div>
