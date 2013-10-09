	<div id="tabBorder"></div>
<?php if(empty($transactions)){ 
    echo "<p style='font-size:1.5em;text-align:center;padding-top:20px;'>You currently have no cash back earnings. Shop now to start earning cash back!</p>";
}else{ ?>
	<table class="matrix" id="profile">
		<thead>
			<tr>
				<th class="header">Month</th>
				<th class="header">Type</th>
				<th class="header">Status</th>
				<th class="header">Cash Back</th>	
				<th class="header">Payment Date</th>
			</tr>
		</thead>
		<tbody>
		{transactions}
		<tr><td>{month}</td><td>{transtype}</td><td>{status}</td><td>${cashback}</td><td>{date}</td></tr>
		{/transactions}        
		{reftransactions}
		<tr bgcolor=#000><td>{month}</td><td>{transtype}</td><td>{status}</td><td>${cashback}</td><td>N/A</td></tr>
		{/reftransactions}        
        </tbody>
    </table>
<?php } ?>
    </div>
