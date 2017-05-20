
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
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php echo googletag_head() ?>

<!-- pinterest -->
<link rel="shortcut icon" href="<?php echo s3path("/images/favicon.ico") ?>" />

	<meta charset="UTF-8">
	<meta name="author" content="nSol">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="Save money on millions of products from thousands of top online stores at BeeSavy.com with comparison shopping, cash back, and coupons." />
	<meta name="keywords" content="HTML,CSS,XML,JavaScript">
	<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="p:domain_verify" content="625b87a98e72ecd64457d22d9521191d"/>

<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/css/bootstrap.min.css") ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/css/font-awesome.css") ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/css/animate.css") ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo s3path("/styles/css/style.css") ?>">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<?php if (in_array($this->router->class, ["product", "stores", "coupon"])) { ?>
    <script>
        $(function() {
            // this initialises the demo scollpanes on the page.
            $('#pane1').jScrollPane({ showArrows: true, scrollbarWidth: 15, arrowSize: 16 });
            $('#pane2').jScrollPane({ showArrows: true, scrollbarWidth: 15, arrowSize: 16 });
        });
    </script>
<?php } ?>

<?php if ($this->router->class == "coupon") { ?>
    <script type="text/javascript" src="<?php echo s3path("/zeroclipboard/ZeroClipboard.js") ?>"></script>
    <script>
        $(function() {
            ZeroClipboard.setMoviePath('<?php echo s3path("/zeroclipboard/ZeroClipboard.swf") ?>');
            var clips = [];

            function startZC() {
                var elements = $(".couponList");
                var container = $(".couponList .click-contain");
                var buttons = $(".couponList .click-button");
                var text = $(".couponList .click-text");
                for (var i = 0; i < elements.length; i++) {
                    var clip = new ZeroClipboard.Client();
                    clip.setHandCursor(true);

                    clip.addEventListener('load', function (client) {
                        debugstr("Flash movie loaded and ready.");
                    });
                    var newval = text[i].text;
                    if (newval == undefined) {
                        newval = text[i].innerHTML;
                    }
                    var newlink = buttons[i].href;

                    var cb = function callback(someclip, sometext) {
                        return function(client) {
                            someclip.setText(sometext);
                        };
                    };
                    var my_complete = function(someurl) {
                        return function(client) {
                            window.open(someurl);
                        };
                    };

                    clip.addEventListener('mouseOver', cb(clip, newval));
                    clip.addEventListener('onComplete', my_complete(newlink));
                    clip.glue(buttons[i], container[i]);
                    clips.push(clip);
                }
            }
            startZC();
        });
    </script>

    <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-4329126-1']);
    _gaq.push(['_setCustomVar', 5, 'Member', 81230, 3]);
    _gaq.push(['_trackPageview']);
    (function() {
        var ga = document.createElement('script');
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        ga.setAttribute('async', 'true');
        document.documentElement.firstChild.appendChild(ga);
    })();
    </script><script async src="<?php echo s3path("/images/ga.js") ?>"></script>
<?php } ?>

</head>
