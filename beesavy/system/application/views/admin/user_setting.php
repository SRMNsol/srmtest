
	<FORM id="min-time" method=post action=/admin_panel/set_setting >
				<input name="setting" value="purchase_exempt" type="hidden">
				<input name="id" value="{id}" type="hidden">
<label for="newsletter">Exempt from purchase requirement</label>
<INPUT type="checkbox" id=newsletter name="value" onchange="$.post('/admin_panel/set_setting', 
                        $('#min-time').serialize());return false;"
    <?php if($purchase_exempt) echo"checked=1"?> type=checkbox />	</FORM>
	<FORM id="referee" method=post action=/admin_panel/set_setting_text onsubmit="$.post('/admin_panel/set_setting_text', 
    $('#referee').serialize());return false;"
    >
				<input name="setting" value="parent_id" type="hidden">
				<input name="id" value="{id}" type="hidden">
<label for="newsletter">Referred By: </label>
<INPUT type="text" id=newsletter name="value" value="{parent_id}" />
<input type="submit" />    </FORM>
<div id="error"></div>
