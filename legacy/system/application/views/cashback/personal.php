	<div id="tabBorder"></div>
<?php if(empty($transactions)){ 
    echo "<p style='font-size:1.5em;text-align:center;padding-top:20px;'>You currently have no cash back earnings. Shop now to start earning cash back!</p>";
}else{ ?>
	<table class="matrix" id="profile">
		<thead>
			<tr>
				<th class="header">Month</th>
				<th class="header">Status</th>
				<th class="header">Store</th>
				<th class="header">Order#</th>
				<th class="header">Total</th>
				<th class="header">Cash Back</th>	
			</tr>
		</thead>
		<tbody>
		{transactions}
		<tr><td>{report_date}</td><td>{status}</td><td>{merchant}</td><td>{order_id}</td><td>${amount}</td><td>${cashback}</td></tr>
		{/transactions}        
        </tbody>
    </table>
<?php } ?>
    </div>
