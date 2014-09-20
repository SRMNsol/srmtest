<?php

/**
 * Define available ad units
 */
function googletag_adunits() {
    static $adUnits = [
        'BS_account_300x600'   => [[300, 600], 'div-gpt-ad-1410546596995-0'],
        'BS_account_728x90_1'  => [[728, 90],  'div-gpt-ad-1410546596995-1'],
        'BS_account_728x90_2'  => [[728, 90],  'div-gpt-ad-1410546596995-2'],
        'BS_compare_336x280_1' => [[336, 280], 'div-gpt-ad-1410546596995-3'],
        'BS_compare_336x280_2' => [[336, 280], 'div-gpt-ad-1410546596995-4'],
        'BS_compare_728x90'    => [[728, 90],  'div-gpt-ad-1410546596995-5'],
        'BS_coupon_300x600_1'  => [[300, 600], 'div-gpt-ad-1410546596995-6'],
        'BS_coupon_300x600_2'  => [[300, 600], 'div-gpt-ad-1410546596995-7'],
        'BS_coupon_728x90'     => [[728, 90],  'div-gpt-ad-1410546596995-8'],
        'BS_help_160x600'      => [[160, 600], 'div-gpt-ad-1410546596995-9'],
        'BS_help_728x90_1'     => [[728, 90],  'div-gpt-ad-1410546596995-10'],
        'BS_help_728x90_2'     => [[728, 90],  'div-gpt-ad-1410546596995-11'],
        'BS_home_250x250'      => [[250, 250], 'div-gpt-ad-1410546596995-12'],
        'BS_home_728x90_1'     => [[728, 90],  'div-gpt-ad-1410546596995-13'],
        'BS_home_728x90_2'     => [[728, 90],  'div-gpt-ad-1410546596995-14'],
        'BS_home_728x90_3'     => [[728, 90],  'div-gpt-ad-1410546596995-15'],
        'BS_home_728x90_4'     => [[728, 90],  'div-gpt-ad-1410546596995-16'],
        'BS_login_486x60'      => [[468, 60],  'div-gpt-ad-1410546596995-17'],
        'BS_search_160x600_1'  => [[160, 600], 'div-gpt-ad-1410546596995-18'],
        'BS_search_160x600_2'  => [[160, 600], 'div-gpt-ad-1410546596995-19'],
        'BS_search_728x90'     => [[728, 90],  'div-gpt-ad-1410546596995-20'],
        'BS_stores_160x600_1'  => [[160, 600], 'div-gpt-ad-1410546596995-21'],
        'BS_stores_160x600_2'  => [[160, 600], 'div-gpt-ad-1410546596995-22'],
        'BS_stores_728x90'     => [[728, 90],  'div-gpt-ad-1410546596995-23'],
    ];

    return $adUnits;
}

/**
 * Return googletag HEAD script
 */
function googletag_head() {

    $slots = implode(PHP_EOL, array_map(function($adUnit, $name) {
        $width = $adUnit[0][0];
        $height = $adUnit[0][1];
        $id = $adUnit[1];
        return "googletag.defineSlot('/45213388/$name', [$width, $height], '$id').addService(googletag.pubads());";
    }, googletag_adunits(), array_keys(googletag_adunits())));

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
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
    googletag.pubads().collapseEmptyDivs();
});
</script>
<!-- /googletag -->
TAG;
}

/**
 * Display ad body tag
 */
function googletag_ad($name, $margin = 10, $float = 'left') {
    $adUnits = googletag_adunits();
    if (!isset($adUnits[$name])) {
        throw Exception(sprintf("Undefined ad unit %s", $name));
    }

    $width = $adUnits[$name][0][0];
    $height = $adUnits[$name][0][1];
    $id = $adUnits[$name][1];

    return <<<TAG
<div style="width:100%; height:{$height}px; float:{$float}; margin:{$margin}px 0;">
    <div style='width:{$width}px; height:{$height}px; margin:auto; background-color:#fff;'>
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
