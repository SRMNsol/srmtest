<html>
<head>
		<style type="text/css" title="currentStyle">
			@import "/css/demo_page.css";
			@import "/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="/script_files/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="/script_files/jquery.dataTables.js"></script>
		<script type="text/javascript"  language="javascript" charset="utf-8">
			$(document).ready(function() {
				$('#user-table').dataTable( {
					"bPaginate": false,
					"bLengthChange": false,
					"bFilter": true,
					"bInfo": false,
					"bAutoWidth": false } );
            });
		</script>
</head>
<body>

<p>Set default user (enter valid email)</p>
<form action="/admin_panel/setDefault" method="get">
<label for="current_default">Current:</label>
<input disabled="disabled" id="current_default" value="{default_user}"></input>
<br/>
<label for="new_default">New:</label>
<input type=text name="user" id="new_default" />
<br />
<button type="submit" >Submit</button>
</form>


<!--
<p>Set min user activity level (days)</p>
<form action="/admin_panel/setActivityLevel" method="get">
<label for="current_default">Current:</label>
<input disabled="disabled" id="current_default" value="{min_activity}"></input>
<br/>
<label for="new_default">New:</label>
<input type=text name="min" id="new_default" />
<br />
<button type="submit" >Submit</button>
</form>
-->

<p>User</p>
<div id="user-info">
</div>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="user-table">
	<thead>
		<tr>
			<th>ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Alias</th>
            <th>Select</th>
		</tr>
	</thead>
	<tbody>
{users}
		<tr>
			<td>{id}</td>
			<td>{first_name}</td>
			<td>{last_name}</td>
			<td>{email}</td>
			<td>{alias}</td>
            <td><a href="#_" uid="{id}" onclick="$.get('/admin_panel/user_info', {id:this.attributes['uid'].nodeValue}, function(data){
$('#user-info').html(data);
});">Select</a></td>
		</tr>
{/users}
    </tbody>
</table>




</body>
</html>
