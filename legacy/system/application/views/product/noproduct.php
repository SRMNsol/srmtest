{header}
<body>
<div id="container">
    <!-- Navigation bar -->
	<?php if($this->db_session->userdata('login')['login']){ ?>

<?php $this->load->view('blocks/admin-topbar'); ?>
<?php }else{ ?>
    {nav_bar}
<?php } ?>

    <!-- content -->
    <!-- page Title -->
	<br><br>
	<center>
    <DIV id=content class=BGNoCol>
        <DIV id=pageTitle>
            <DIV id=pageTitleLeft></DIV>
            <H1>We Found 0 Stores Matching {search}</H1>
            <DIV id=pageTitleRight></DIV>
        </DIV>

        <DIV id=error>
            <table cellspacing=0 cellpadding=0 style="margin-left:10px;">
                <tr>
                    <td><img src="<?php /* echo s3path("/images/sorry_bee.jpg") */ ?> http://s3.amazonaws.com/static-dev.beesavy.com/images/sorry_bee.jpg"></td>
                    <td>
                        <P>
                            Sorry, we did not find any results that matched your search query</P>
                    </td>
                </tr>
            </table>
            <DIV style="CLEAR: both"></DIV>
        </DIV>

        <DIV style="HEIGHT: 10px; CLEAR: both"></DIV>
    </DIV>
	</center>

    <!-- Right side -->


    <!-- /content -->
    <!-- footer -->
    {footer}
    <!-- /footer -->

    <SCRIPT type=text/javascript
            src="<?php echo s3path("/Extrabux_com%20-%20Page%20Not%20Found_files/extrabux.main.layout.7120.js") ?>"></SCRIPT>

    <SCRIPT type=text/javascript>_qoptions = {qacct: "p-1cqtECMNlCeJ2"};</SCRIPT>

    <SCRIPT type=text/javascript
            src="<?php echo s3path("/Extrabux_com%20-%20Page%20Not%20Found_files/quant.js") ?>"></SCRIPT>

    <SCRIPT type=text/javascript
            src="Extrabux_com%20-%20Page%20Not%20Found_files/pixel"></SCRIPT>

    <SCRIPT type=text/javascript>
        /* <![CDATA[ */
        var google_conversion_id = 1062158219;
        var google_conversion_language = "en";
        var google_conversion_format = "3";
        var google_conversion_color = "666666";
        var google_conversion_label = "5y5nCKGR_QEQi_-8-gM";
        var google_conversion_value = 0;
        /* ]]> */
    </SCRIPT>

    <SCRIPT type=text/javascript
            src="<?php echo s3path("/Extrabux_com%20-%20Page%20Not%20Found_files/conversion.js") ?>">
    </SCRIPT>
    <NOSCRIPT>
        <DIV style="DISPLAY: inline"><IMG
                    style="BORDER-BOTTOM-STYLE: none; BORDER-RIGHT-STYLE: none; BORDER-TOP-STYLE: none; BORDER-LEFT-STYLE: none"
                    alt="" src="<?php echo s3path("/Extrabux_com%20-%20Page%20Not%20Found_files/1062158219.gif") ?>"
                    width=1
                    height=1></DIV>
    </NOSCRIPT>


</body>
</html>
