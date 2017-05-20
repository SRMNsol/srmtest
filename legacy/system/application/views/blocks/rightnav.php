{total}

<div class="row">
    <div class="boxi"><h5 class="adminpadding"> Referrals </h5></div>
    <div class="accounts2">
        <div class="space20"></div>
        <!-- <h4>Reffral Overview</h4> -->

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding"><span class="label label-info">Direct</span></h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding"> {referralcountdirect} </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding"><span class="label label-warning">Indirect </span></h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding"> {referralcountindirect} </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding"><span class="label label-danger">Total</span></h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding"> <?php echo $total[0]['referralcountdirect'] + $total[0]['referralcountindirect']?> </h4>
            </div>
        </div>

    </div>
</div>
<!-- Breakeerrr -->
<div class="row" style="margin-bottom: 15px;">
    <div class="boxi"><h5 class="adminpadding"> Cash back</h5></div>

    <div class="account12">
        <div class="row">
            <div class="space20"></div>

        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding"><span class="label label-danger">Pending</span></h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding">${pending}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding"><span class="label label-info">Available</span></h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 id='available' class="adminpadding">${available}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding"><span class="label label-warning">Processing</span></h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 id='processing' class="adminpadding">${processing}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding"><span class="label label-success">Paid</span></h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <h4 class="adminpadding">${paid}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button id='request-payment' type="button" class="btn btn-success btn-block">Request a Payment</button>
                <h5 class="adminpadding">You need an additional $10.00 to request a payment</h5>
            </div>
        </div>
    </div>

</div>

{/total}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>

$('#request-payment').click(function(){

var processing=$('#processing').text();
processing=processing.replace('$','');
var avail=$('#available').text();
var sendavail=avail.replace('$','');

if(avail=='$0.00')
{
	alert('No available amount');
	return false;
}
    $.ajax({
            type: "POST",
            url: "account/procestoavail",
            data: {processing: processing, available: sendavail},
            success: function(data, dataType)
            {
				
				
               alert('Request Submitted Successfully');
			  window.location.reload();
            }
});
});
</script>



