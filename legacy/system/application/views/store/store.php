

{header}
<body>
<div id="container">
    <!-- Navigation bar -->
	<?php if($this->db_session->userdata('login')['login']){ ?>

<?php $this->load->view('blocks/admin-topbar'); ?>
<?php }else{ ?>
    <?php $this->load->view('blocks/nav_bar'); ?>
<?php } 

?>
<style>
    .head_class {

        background: #c43016;
        color: #fff;
        padding: 10px 0px;

    }

    #border_id {
        border-right: solid 5px #c43016;
        border-left: solid 5px #c43016;
        border-bottom: solid 5px #c43016;
        padding-bottom: 15px !important;
    }

    .c_class {
        margin-right: 10px;
        cursor: pointer;
    }

    .main_box_border {
        border: solid 2px #ddd;
        margin-top: 5%;
        padding: 15px 15px 15px;
        border-radius: 5px !important
    }

    .pp_class {
        margin: 10px;
    }

    .my_btn {

        background-color: #d9534f;
        color: #fff;
        padding: 10px 30px;
    }

    .my_btn:hover {

        color: #fff;
        background-color: #c9302c;
        border-color: #ac2925;
    }

    .header_border_class {
        border-right: solid 2px #ddd;
        border-left: solid 2px #ddd;
        border-bottom: solid 2px #ddd;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .img_center img {
        margin: 20px auto 15px;

    }
</style>
<style type="text/css">
.img-responsive.img-list {
    margin-left: 34% !important;
}
</style>
   
    <!-- content -->


    <section id="detail_new">
        <div class="space30"></div>
        <div class="container">
            <div class="row">

                <div class="col-md-12 no-padding" id="border_id">
                    <h4 class="text-center head_class">{store_name} Cash Back & Coupons <span class="pull-right"><i
                                    class="fa fa-twitter c_class"></i><i class="fa fa-facebook c_class"></i><i
                                    class="fa fa-inbox c_class"></i></span></h4>
                    <div class="col-md-9">

                        <div class="main_box_border">
                            <div class="row">
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-6 no-padding">
                                        <a href="<?php echo s3path("/stores/details/{id}") ?>"><img
                                                    style="padding: 0px 10px 10px 10px;width: 50%; " src="{logo_thumb}" class="img-responsive"
                                                    onload="
                            var width = 100;
                            var height = 32;
                            var ratio= Math.min(width/this.width, height/this.height);
                            var nwidth = ratio*this.width;
                            var nheight = ratio*this.height;
                            this.width = nwidth;
                            this.height = nheight;"
                                                    alt="{cashback_text}"
                                                    onerror="this.src="<?php echo s3path("/../images/no-image-100px.gif") ?>
                                            ""/></a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a class="btn btn-default my_btn"
                                           href="<?php echo s3path('/transfer/store/{id}'); ?>" target="_blank"
                                           rel="nofollow">
                                            <?php if ($store['cashback_text']) : ?>
                                            Shop <?php echo escape($store['cashback_text']) ?> Cashback
                                            <?php else : ?>
                                            Go to shop
                                            <?php endif ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <p class="pp_class"><?php
                                foreach (explode("\n", $description) as $line) {
                                    echo escape($line) . '<br>';
                                }
                                ?></p>
                        </div>

                        <div class="space30"></div>
                        <div style="background-color: rgba(0, 0, 0, 0.05);">
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- All Stores Detail -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9625495144632502"
     data-ad-slot="5783756572"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
                        </div>
                    </div>


                    <div class="BGNoCol">

                        <!-- page Title -->
                    </div>
                    <!-- /page Title -->
                    <div class="col-md-3">


                        <div class="header_border_class">
                            <h4 class="head_class text-center" style="margin-top: 16%;">Top Stores</h4>

                            <div class="img_center">
                                {top_stores}
                                <a href=<?php echo s3path("/stores/details/{id}"); ?>><img src="{logo_thumb}" class="img-responsive img-list" onload="
                    var width = 100;
                    var height = 32;
                    var ratio= Math.min(width/this.width, height/this.height);
                    var nwidth = ratio*this.width;
                    var nheight = ratio*this.height;
                    this.width = nwidth;
                    this.height = nheight;"
                                                                  alt="{cashback_text}"
                                                             onerror="this.src="<?php echo s3path("images/no-image.jpg") ?>
                                    ""/></a>
                                {/top_stores}
                            </div>
                        </div>

                        <?php echo googletag_ad('BS_stores_160x600_1') ?>
                        <?php echo googletag_ad('BS_stores_160x600_2') ?>

                    </div>
                </div>
            </div>
        </div>
</div>
</section>

<div id="merchantView" style="width:700px; display:none;">
    <div id="storeInfo">
        <div id="description">
            <div id="logo">
                <a class="transfer-link" href="/transfer/store/{id}" target="_blank" rel="nofollow">
                    <img class="cdn-image" style="padding: 10px;" src="{logo_thumb}" onload="
                            var width = 100;
                            var height = 32;
                            var ratio= Math.min(width/this.width, height/this.height);
                            var nwidth = ratio*this.width;
                            var nheight = ratio*this.height;
                            this.width = nwidth;
                            this.height = nheight;"
                         alt="** PLEASE DESCRIBE THIS IMAGE **"
                         onerror="this.src="<?php echo s3path("/../images/no-image-100px.gif") ?>""/>
                </a>
            </div>
            <div class="ShopCashBack">
                <div class="ShopCashBack-Bt BtnSCBOrangeBg">
                    <a class="BtnCBBlackTxt button" href="/transfer/store/{id}" target="_blank" rel="nofollow">
                        <?php if ($store['cashback_text']) : ?>
                        Shop <?php echo escape($store['cashback_text']) ?> Cashback
                        <?php else : ?>
                        Go to shop
                        <?php endif ?>
                    </a>
                </div>
            </div>
            <div style="margin-top: 15px; clear: both;"><?php
                foreach (explode("\n", $description) as $line) {
                    echo escape($line) . '<br>';
                }
                ?></div>
            <div style="margin-top: 15px; clear: both;"><?php echo escape($restrictions) ?></div>
        </div>
    </div>

    <?php if ($coupons) { ?>
    <ul class="tabs">
        <li><a class="active" href="#coupons">Store Coupons</a></li>
    </ul>
    <div id="tabBorder" style="width: 680px;"></div>
    <div class="tab-container">
        <div style="display: block;" id="coupons" class="tab-content">


            <?php
            $index = 0;
            $ad = 0;
            foreach ($coupons as $coupon) {
            ?>
            <div class="couponList inactive" style="width: 680px; margin-right: 0pt; margin-left: 20px;">
                <div class="logo">
                    <a class="transfer-link" href="/transfer/coupon/<?php echo $coupon['cid'] ?>" target="_blank"
                       rel="nofollow">
                        <img class="cdn-image" src="<?php echo $coupon['logo_thumb'] ?>" onload="
                                var width = 100;
                                var height = 32;
                                var ratio = Math.min(width/this.width, height/this.height);
                                var nwidth = ratio*this.width;
                                var nheight = ratio*this.height;
                                this.width = nwidth;
                                this.height = nheight;"
                             alt="** PLEASE DESCRIBE THIS IMAGE **"
                             onerror="this.src="<?php echo s3path("/../images/no-image-100px.gif") ?>""/>
                    </a>
                </div>
                <div class="cInfo">
                    <h3><a class="transfer-link" href="/transfer/coupon/<?php echo $coupon['cid'] ?>" target="_blank"
                           rel="nofollow"><?php echo $coupon['name'] ?></a></h3>
                    <div class="details">
                        Expires <?php echo $coupon['expiration'] ?> <?php echo $coupon['code_prefix'] ?><font
                                color=black><b><?php echo $coupon['code'] ?></b></font>
                        <br/>
                        <div class="BottomSpace">
                            <a target='_blank' href='/social/coupon/facebook/<?php echo $coupon['cid'] ?>'><img
                                        src="<?php echo s3path("/images/facebook-refer.png") ?>"
                                        alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
                            <a target='_blank' href='/social/coupon/twitter/<?php echo $coupon['cid'] ?>'><img
                                        src="<?php echo s3path("/images/twitter-refer.png") ?>"
                                        alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
                            <a onClick="$.get($(this).attr('href'),function(data){document.location=data;});return false;"
                               href='/social/coupon/email/<?php echo $coupon['cid'] ?>'><img
                                        src="<?php echo s3path("/images/email-refer.png") ?>"
                                        alt='** PLEASE DESCRIBE THIS IMAGE **'/></a>
                        </div>
                    </div>
                </div>

                <div class="CtA">
                    <table cellspacing=0 cellpadding=0>
                        <tr>
                            <td>
                                <div class="ClickToCopyCode">
                                    <div style="position:relative" class="click-contain ClickToCopyCode-Bt"><a
                                                class="click-button button"
                                                href="/transfer/coupon/<?php echo $coupon['cid'] ?>" target="_blank"
                                                rel="nofollow"><?php echo $coupon['action_text'] ?></a></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="instructions"><?php echo $coupon['code_prefix'] ?><a
                                            class="click-text couponCode transfer-link" href="" target="_blank"
                                            rel="nofollow"><?php echo $coupon['code'] ?></a></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php
            $index++;
            }
            ?>

            <div style="clear: both;"></div>
        </div>
    </div>
    <div class="pag">
        <div id="Pagination" class="pagination-controls"></div>
        <div class="pagination-info">Showing results <strong><?php echo escape($start) ?></strong> to
            <strong><?php echo escape($end) ?></strong> of <strong><?php echo escape($count) ?></strong></div>
    </div>
</div>
<?php } ?>

<div style="clear: both;"></div>
<div style="clear: both; height: 10px;"></div>
</div>

<script>
    $(document).ready(function () {
        // pagination
        var isInit = true;

        function pageselectCallback(page_index, $) {
            if (isInit) {
                isInit = false;
                return false;
            }

            var page = page_index + 1;
            var pat = new RegExp("page=[0-9]*");
            if (pat.test(document.URL)) {
                window.location = (document.URL).replace(pat, "page=" + page);
            }
            else {
                var pat = new RegExp("[?]");
                if (pat.test(document.URL)) {
                    window.location = (document.URL) + "&page=" + page;
                } else {
                    window.location = (document.URL) + "?page=" + page;
                }
            }

            // Prevent click eventpropagation
            return false;
        }

        // When document has loaded, initialize pagination and form
        // Create pagination element with options from form
        $("#Pagination").pagination(<?php echo escape($count) ?>, {
            callback: pageselectCallback,
            current_page: <?php echo escape($page - 1) ?>,
            num_edge_entries: 1,
            num_display_entries: 5,
            prev_show_always: false,
            next_show_always: false,
            prev_text: "Prev <<",
            next_text: "Next >>",
            ellipse_text: "<span class='spacer'>...</span>",
            items_per_page: <?php echo escape($limit) ?>,
            link_to: document.URL
        });

    });
</script>


<!-- /content -->
<!-- footer -->
{footer_script}
{footer}
<!-- /footer -->


</body>
</html>
