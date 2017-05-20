

	<div id="tabBorder"></div>
<?php if(empty($reftransactions)){ 
    echo "<p style='width:600px;font-size:1.5em;text-align:center;padding-top:20px;'>You currently have no referral cash back earnings. <a class='title' href='/info/lm_referral'>Spread the buzz</a> about BeeSavy to earn referral cash back forever!</p>";
}else{ ?>
	<table class="matrix" id="profile">
		<thead>
			<tr>
				<th class="header">Month</th>
				<th class="header">Level</th>
				<th class="header">Status</th>
				<th class="header">Cash Back</th>	
			</tr>
		</thead>
		<tbody>
		{reftransactions}
		<tr><td>{date}</td><td>{level}</td><td>{status}</td><td>${cashback}</td></tr>
		{/reftransactions}        
        </tbody>
    </table>
<?php } ?>
    </div>
