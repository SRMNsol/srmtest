<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
</head>
<body>

    <div style="background:#fff;border: 1px solid #999;	margin:0 auto;width:800px;float:left;">
		<div style="border:0px solid #000;padding-top:15px;padding-left:15px;"><img src="<? echo base_url() ?>images/header-beesavy-logo.gif"/></div>
        <div style="border:0px solid #000;padding-top:15px;padding-left:15px;"><img src="<? echo base_url() ?>images/newsletter-div.gif"/></div>
		<div style="border:0px solid #999;	margin:0 auto;float:left;padding:15px;">
<p style="margin-top:10px;margin-left:10px;margin-bottom:10px;font-size:15px;font-family:arial;color:#000;">Hi {first_name} {last_name},
</p>
<p style="margin-top:10px;margin-left:10px;margin-bottom:10px;font-size:15px;font-family:arial;color:#000;">Your <a href="/stores/details/{merchant_id}" style="color:#e86800;font-weight:normal;text-decoration:underline;">{merchant_name}</a> purchase of ${amount} on {date} (order #{order_id}) has been reported to BeeSavy. <br/>
Your <strong>${cashback_amount} Cash Back </strong>has been posted to your BeeSavy account.
</p>

<p style="margin-top:10px;margin-left:10px;margin-bottom:10px;font-size:15px;font-family:arial;color:#000;">To view your purchase, please visit <a href="" style="color:#e86800;font-weight:normal;text-decoration:underline;"><? echo base_url() ?>account</a>
</p>

<p style="margin-top:10px;margin-left:10px;margin-bottom:10px;font-size:15px;font-family:arial;color:#000;">Thanks,<br/><br/><br/>
</p>

<p style="margin-top:10px;margin-left:10px;margin-bottom:10px;font-size:15px;font-family:arial;color:#000;">The BeeSavy Team<br/>
<a href="<? echo base_url()?>" style="color:#e86800;font-weight:normal;text-decoration:underline;">www.beesavy.com</a>
</p>


	</div>
</div>

</body>
</html>
