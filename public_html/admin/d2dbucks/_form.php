<table class="header" align="center" border="0" cellpadding="2" cellspacing="4">
<?php
echo "<tr>
		<td class=\"header\" align=\"right\">District Manager:</td>
		<td class=\"normal\">
			<form method=\"post\">
				<select onChange=\"ChooseMenu('parent',this,0)\">";
		
	if(isset($dm_id))
		{
			$result = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM dms WHERE id='$dm_id' and status='active'");
			list($dm_name) = db_row($result);
			echo "<option value='?dm_id=$dm_id' selected>$dm_name</option>";
		}
		
		echo "<option value='?'>Leave Unassigned</option>";
	
		$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name) FROM dms ORDER BY last_name");
		while (list($dmid, $dmname) = db_row($result))
			echo "<option value='?dm_id=$dmid'>$dmname</option>";
			
	echo "			</select>
				</form>
			</td>
		</tr>";

	### DROP DOWN TABLE 2

	echo "<tr>
			<td class=\"header\" align=\"right\">Account Executive:</td><td class=\"normal\">
				<form method=\"post\">
					<select onChange=\"ChooseMenu('parent',this,0)\">";
	
		if(isset($ae_id) && $ae_id!=0)
		{
			$result = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM aes WHERE id='$ae_id'");
			list($aename) = db_row($result);
			echo "<option value='?dm_id=$dm_id&ae_id=$ae_id' selected>$aename</option>";
		}
		
		echo "<option value='?dm_id=$dm_id&ae_id=0&dealer_id=0'>Leave Unassigned</option>";
		
		if(isset($dm_id))
		{
			$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name) FROM aes WHERE dm_id='$dm_id' and status='active' ORDER BY last_name");
			while (list($aeid, $aename) = db_row($result))
				echo "<option value='?dm_id=$dm_id&ae_id=$aeid'>$aename</option>";
		}
			
		echo "		</select>
				</form>
			</td>
		</tr>";
			
	### DROP DOWN TABLE 3

	echo "<tr>
			<td class=\"header\" align=\"right\">Dealership:</td><td class=\"normal\">
				<form method=\"post\">
					<select onChange=\"ChooseMenu('parent',this,0)\">";

		if(isset($dealer_id) && $dealer_id!=0)
		{
			$result = db_do("SELECT name FROM dealers WHERE id='$dealer_id'");
			list($dealer_name) = db_row($result);
			echo "<option value='?dm_id=$dm_id&ae_id=$ae_id&dealer_id=$dealer_id' selected>$dealer_name</option>";
		}
		
		echo "<option value='?dm_id=$dm_id&ae_id=$ae_id&dealer_id=0'>Leave Unassigned</option>";
		
		if(isset($ae_id))
		{
			$result = db_do("SELECT id, name FROM dealers WHERE ae_id='$ae_id' and status='active' ORDER BY name");
			while (list($dealerid, $dealername) = db_row($result))
				echo "<option value='?dm_id=$dm_id&ae_id=$ae_id&dealer_id=$dealerid'>$dealername</option>";
		}

	echo "			</select>
				</form>
			</td>
		</tr>";
?>
<form action="<?=$PHP_SELF?>" method="post">
	<input type="hidden" name="dm_id" value="<?=$dm_id?>" />
	<input type="hidden" name="ae_id" value="<?=$ae_id?>" />
	<input type="hidden" name="dealer_id" value="<?=$dealer_id?>" />
	<tr>
		<td align="right">Start Serial #:</td>
		<td><input name="serial_id_start" type="text" size="25"></td>
	</tr>
	<tr>
		<td align="right">End Serial #:</td>
		<td><input name="serial_id_end" type="text" size="25"></td>
	</tr>
	<tr>
		<td align="right">Amount $:</td>
		<td><input name="amount" type="text" size="25"></td>
	</tr>
	<tr>
		<td align="center" colspan="2"><br><input class="header" type="submit" value="  Update  " name="submit"></td>
	</tr>	
</form>
</table><p align="center">
<?php db_disconnect(); ?>