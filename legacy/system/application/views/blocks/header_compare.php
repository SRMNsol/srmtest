<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="Save money on millions of products from thousands of top online stores at BeeSavy.com with comparison shopping, cash back, and coupons." />
<title>BeeSavy – Taking the sting out of online shopping</title>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23342317-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = "text/javascript"; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<link rel="shortcut icon" href="<?php echo s3path("/images/favicon.ico") ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/main.css") ?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/home.css") ?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/results.css") ?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/button.css") ?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/view.css") ?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/colorbox.css") ?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo s3path("/css/matrix_table.css") ?>" media="screen"/>

<script type="text/javascript" src="<?php echo s3path("/script_files/jquery_004.js") ?>"></script>
<script type="text/javascript" src="<?php echo s3path("/colorbox/jquery.colorbox.js") ?>"></script>
<script type="text/javascript" src="<?php echo s3path("/script_files/nav_bar.js") ?>"></script>
<script type="text/javascript" src="<?php echo s3path("/zeroclipboard/ZeroClipboard.js") ?>"></script>
<script type="text/javascript" src="<?php echo s3path("/script_files/jquery.dataTables.js") ?>"></script>
<script type="text/javascript" src="<?php echo s3path("/script_files/money.js") ?>"></script>

<script type="text/javascript">
$(document).ready(function(){
    $(".make-home").colorbox();

    ZeroClipboard.setMoviePath('<?php echo s3path("/zeroclipboard/ZeroClipboard.swf") ?>');
    var clips = [];

    function startZC() {
        var elements = $(".couponList");
        var container = $(".couponList .click-contain");
        var buttons = $(".couponList .click-button");
        var text = $(".couponList .click-text")
        for(var i = 0; i < elements.length; i++){
            var clip = new ZeroClipboard.Client();
            clip.setHandCursor(true);

            clip.addEventListener('load', function (client) {
                debugstr("Flash movie loaded and ready.");
            });
            var newval = text[i].text;
            if(newval == undefined){
                newval = text[i].innerHTML;
            }
            var newlink = buttons[i].href;

            var cb = function callback(someclip, sometext){
                return function(client){
                    someclip.setText(sometext);
                };
            };
            var my_complete = function(someurl){
                return function(client){
                    window.open(someurl);
                };
            };

            clip.addEventListener('mouseOver', cb(clip, newval));
            clip.addEventListener('onComplete', my_complete(newlink) );
            clip.glue( buttons[i], container[i]);
            clips.push(clip);
        }
    }
    startZC();

    $('#matrix-products').dataTable( {
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bSearch":false,
        "aoColumns":[
            null,
            null,
            null,
            null,
            {"sType":"tax"},
            {"sType":"p"},
            {"bSortable":false}
        ],
        "aaSorting":[[5,"asc"]],
        "bAutoWidth": false
    });

});
</script>
</head>
