<?php

/**
 * Define available ad units
 */
function googletag_adslots() {
    static $adslots = [
        'BS_account_300x600'   => ['width' => 300, 'height' => 600, 'id' => 'div-gpt-ad-1410546596995-0',  'collapse' => false],
        'BS_account_728x90_1'  => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-1',  'collapse' => false],
        'BS_account_728x90_2'  => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-2',  'collapse' => false],
        'BS_compare_336x280_1' => ['width' => 336, 'height' => 280, 'id' => 'div-gpt-ad-1410546596995-3',  'collapse' => false],
        'BS_compare_336x280_2' => ['width' => 336, 'height' => 280, 'id' => 'div-gpt-ad-1410546596995-4',  'collapse' => false],
        'BS_compare_728x90'    => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-5',  'collapse' => false],
        'BS_coupon_300x600_1'  => ['width' => 300, 'height' => 600, 'id' => 'div-gpt-ad-1410546596995-6',  'collapse' => false],
        'BS_coupon_300x600_2'  => ['width' => 300, 'height' => 600, 'id' => 'div-gpt-ad-1410546596995-7',  'collapse' => false],
        'BS_coupon_728x90'     => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-8',  'collapse' => false],
        'BS_help_160x600'      => ['width' => 160, 'height' => 600, 'id' => 'div-gpt-ad-1410546596995-9',  'collapse' => false],
        'BS_help_728x90_1'     => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-10', 'collapse' => false],
        'BS_help_728x90_2'     => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-11', 'collapse' => false],
        'BS_home_250x250'      => ['width' => 250, 'height' => 250, 'id' => 'div-gpt-ad-1410546596995-12', 'collapse' => false],
        'BS_home_728x90_1'     => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-13', 'collapse' => true],
        'BS_home_728x90_2'     => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-14', 'collapse' => true],
        'BS_home_728x90_3'     => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-15', 'collapse' => true],
        'BS_home_728x90_4'     => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-16', 'collapse' => false],
        'BS_login_486x60'      => ['width' => 468, 'height' => 60,  'id' => 'div-gpt-ad-1410546596995-17', 'collapse' => false],
        'BS_search_160x600_1'  => ['width' => 160, 'height' => 600, 'id' => 'div-gpt-ad-1410546596995-18', 'collapse' => false],
        'BS_search_160x600_2'  => ['width' => 160, 'height' => 600, 'id' => 'div-gpt-ad-1410546596995-19', 'collapse' => false],
        'BS_search_728x90'     => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-20', 'collapse' => false],
        'BS_stores_160x600_1'  => ['width' => 160, 'height' => 600, 'id' => 'div-gpt-ad-1410546596995-21', 'collapse' => false],
        'BS_stores_160x600_2'  => ['width' => 160, 'height' => 600, 'id' => 'div-gpt-ad-1410546596995-22', 'collapse' => false],
        'BS_stores_728x90'     => ['width' => 728, 'height' => 90,  'id' => 'div-gpt-ad-1410546596995-23', 'collapse' => false],
    ];

    return $adslots;
}

/**
 * Return googletag HEAD script
 */
function googletag_head() {

    $slots = implode(PHP_EOL, array_map(function($slot, $name) {
        $width = $slot['width'];
        $height = $slot['height'];
        $id = $slot['id'];
        return "googletag.defineSlot('/45213388/$name', [$width, $height], '$id').addService(googletag.pubads())"
          . ($slot['collapse'] ? '.setCollapseEmptyDiv(true, true)' : '')
          . ";";
    }, googletag_adslots(), array_keys(googletag_adslots())));

    return <<<TAG
<!-- googletag -->
<script type='text/javascript'>
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
    var gads = document.createElement('script');
    gads.async = true;
    gads.type = 'text/javascript';
    var useSSL = 'https:' == document.location.protocol;
    gads.src = (useSSL ? 'https:' : 'http:') +
    '//www.googletagservices.com/tag/js/gpt.js';
    var node = document.getElementsByTagName('script')[0];
    node.parentNode.insertBefore(gads, node);
})();
</script>

<script type='text/javascript'>
    googletag.cmd.push(function() {
    $slots
    googletag.pubads().collapseEmptyDivs();
    googletag.enableServices();
});
</script>
<!-- /googletag -->
TAG;
}

/**
 * Display ad body tag
 */
function googletag_ad($name, $float = 'left') {
    $slots = googletag_adslots();
    if (!isset($slots[$name])) {
        throw Exception(sprintf("Undefined ad unit %s", $name));
    }

    $width = $slots[$name]['width'];
    $height = $slots[$name]['height'];
    $id = $slots[$name]['id'];

    return <<<TAG
<div style="width:100%; float:{$float};">
    <div style='width:{$width}px; margin:auto;'>
        <!-- $name -->
        <div id='$id' style='width:{$width}px; height:{$height}px;'>
            <script type='text/javascript'>
                googletag.cmd.push(function() { googletag.display('$id'); });
            </script>
        </div>
    </div>
</div>
TAG;
}