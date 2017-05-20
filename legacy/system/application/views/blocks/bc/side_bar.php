<?php
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
    <div id="category">
        <div>
            <form id="facetForm" name="facetForm" action="/search" method="get">
                <input type="hidden" name="q" value="" />
                <input type="hidden" name="page" id="page" value="" />
                <div <?php echo $parentstates['how']?> ><a <?php echo $states['how']?> href="<?php echo SURL?>info/how" style='cursor:pointer'><div class="HelpFullBox">How It Works</div></a></div>
                <div <?php echo $parentstates['lm']?> ><a <?php echo $states['lm']?> href="<?php echo SURL?>info/lm_overview" style='cursor:pointer'><div class="HelpFullBox">Learn More</div></a></div>
                <?php if ($states['lm'] != '') : ?>
                <script type="text/javascript">
                    $(document).ready(function (){
                        $('.Sub li a[href=<?php echo SURL?>info/<?php echo $info?>]').addClass('ActiveSub');
                    });
                </script>
                <div class="child" >
                    <ul class="Sub">
                        <li><a href="<?php echo SURL?>info/lm_overview">Overview</a></li>
                        <li><a href="<?php echo SURL?>info/lm_cashback">Cash Back</a></li>
                        <li><a href="<?php echo SURL?>info/lm_compare">Compare Prices</a></li>
                        <li><a href="<?php echo SURL?>info/lm_shop">Shop By Store</a></li>
                        <li><a href="<?php echo SURL?>info/lm_guide">Build Your Hive</a></li>
                        <li><a href="<?php echo SURL?>info/lm_referral" >Referral Cash Back</a></li>
                        <li><a href="<?php echo SURL?>info/lm_join">Join For Free</a></li>
                    </ul>
                </div>
                <?php endif ?>
                <div <?php echo $parentstates['faq']?>><a <?php echo $states['faq']?> href="<?php echo SURL?>info/faq" style='cursor:pointer'><div class="HelpFullBox">FAQ's</div></a></div>
                <div <?php echo $parentstates['aboutus']?>><span><a <?php echo $states['aboutus']?> href="<?php echo SURL?>info/aboutus" style='cursor:pointer'><div class="HelpFullBox">About Us</div></a></span></div>
                <div <?php echo $parentstates['privacy']?> ><span><a <?php echo $states['privacy']?> href="<?php echo SURL?>info/privacy" style='cursor:pointer'><div class="HelpFullBox">Privacy Policy</div></a></span></div>
                <div <?php echo $parentstates['terms']?> ><span><a <?php echo $states['terms']?> href="<?php echo SURL?>info/terms" style='cursor:pointer'><div class="HelpFullBox">Terms of Service</div></a></span></div>
                <div <?php echo $parentstates['contact']?> ><span><a <?php echo $states['contact']?> href="<?php echo SURL?>info/contact" style='cursor:pointer'><div class="HelpFullBox">Contact Us</div></a></span></div>
            </form>
        </div>
        <?php echo googletag_ad('BS_help_160x600') ?>
    </div>
</div>
