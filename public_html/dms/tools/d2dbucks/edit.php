<?php


include('../../../../include/session.php');
include('../../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$result = db_do("SELECT COUNT(*) FROM d2dbucks WHERE id='$id' and dm_id='$dm_id'");
if (db_num_rows($result) == 0) {
	header('Location: index.php');
	exit;
}

$page_title = 'Edit D2DBucks';

if (isset($submit)) {
	db_do("UPDATE d2dbucks SET dm_id='$dm_id', ae_id='$ae_id', dealer_id='$dealer__id' WHERE id='$id'");
	
	header('Location: index.php');
	exit;
}
else
{
	$result = db_do("SELECT d2dbucks.id, d2dbucks.serial_id, d2dbucks.amount, CONCAT(dms.first_name, ' ', dms.last_name), 
					d2dbucks.status, DATE_FORMAT(d2dbucks.modified, '%d-%b-%Y') FROM d2dbucks, dms WHERE d2dbucks.id='$id' and dms.id='$dm_id'");
	list($id, $serial_num, $amount, $dm_name, $status, $modified) = db_row($result);
}

include('../../header.php');

?>
<html>
 <head>
	<script language="JavaScript" type="text/JavaScript">
	function ChooseMenu(targ,selObj,restore){
	  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;}
	</script>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <br><p align="center" class="big"><b><?php $page_title?></b></p><br>
<?php



### DROP DOWN TABLE 1
?><p>
	<table align="center" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td class="header" align="right">Serial #:</td>
			<td class="normal"><?=str_pad($serial_num, 5, "0", STR_PAD_LEFT)?></td>
		</tr>
		<tr>
			<td class="header" align="right">Amount $:</td>
			<td class="normal"><?php $amount?></td>
		</tr>
		<tr>
			<td class="header" align="right">District Manager:</td>
			<td class="normal"><?php $dm_name?></td>
		</tr>	

	
<?php
	### DROP DOWN TABLE 2

	echo "<tr>
			<td class=\"header\" align=\"right\">Account Executive:</td><td class=\"normal\">
				<form method=\"post\">
					<select onChange=\"ChooseMenu('parent',this,0)\">";
	
		if(isset($ae_id) && $ae_id!=0)
		{
			$result = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM aes WHERE id='$ae_id'");
			list($aename) = db_row($result);
			echo "<option value='?idphp $id&dm_idphp $dm_id&ae_idphp $ae_id' selected>$aename</option>";
		}
		
		echo "<option value='?idphp $id&dm_idphp $dm_id&ae_id=0&dealer_id=0'>Leave Unassigned</option>";
		
		if(isset($dm_id))
		{
			$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name) FROM aes WHERE dm_id='$dm_id' and status='active' ORDER BY last_name");
			while (list($aeid, $aename) = db_row($result))
				echo "<option value='?idphp $id&dm_idphp $dm_id&ae_idphp $aeid'>$aename</option>";
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

		if(isset($dealer__id) && $dealer__id!=0)
		{
			$result = db_do("SELECT name FROM dealers WHERE id='$dealer__id'");
			list($dealername) = db_row($result);
			echo "<option value='?idphp $id&dm_idphp $dm_id&ae_idphp $ae_id&dealer__idphp $dealer__id' selected>$dealername</option>";
		}
		
		echo "<option value='?idphp $id&dm_idphp $dm_id&ae_idphp $ae_id&dealer__id=0'>Leave Unassigned</option>";
		
		if(isset($ae_id))
		{
			$result = db_do("SELECT id, name FROM dealers WHERE ae_id='$ae_id' and status='active' ORDER BY name");
			while (list($dealerid, $dealername) = db_row($result))
				echo "<option value='?idphp $id&dm_idphp $dm_id&ae_idphp $ae_id&dealer__idphp $dealerid'>$dealername</option>";
		}

	echo "			</select>
				</form>
			</td>
		</tr>";
		
db_free($result);
?>
</table>

	<p><form method="post">
			<input type="hidden" name="dm_id" value="<?php $dm_id?>" />
			<input type="hidden" name="ae_id" value="<?php $ae_id?>" />
			<input type="hidden" name="dealer__id" value="<?php $dealer__id?>" />
			<p align="center"><input class="header" type="submit" value="  Update  " name="submit">
		</form>
<?php db_disconnect(); 
include('../../footer.php'); ?>