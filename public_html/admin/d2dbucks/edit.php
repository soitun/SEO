<?php

if(!empty($_REQUEST['dm_id']))
	$dm_id = $_REQUEST['dm_id'];
else
	$dm_id = "";

if(!empty($_REQUEST['ae_id']))
	$ae_id = $_REQUEST['ae_id'];
else
	$ae_id = "";

if(!empty($_REQUEST['dealer_id']))
	$dealer_id = $_REQUEST['dealer_id'];
else
	$dealer_id = "";

if(!empty($_REQUEST['id']))
	$id = $_REQUEST['id'];
else
	$id = "";



?>





<?php

include('../../../include/db.php');
db_connect();

$page_title = 'Edit D2DBucks';

if (isset($submit)) {
	db_do("UPDATE d2dbucks SET dm_id='$dm_id', ae_id='$ae_id', dealer_id='$dealer_id' WHERE id='$id'");

	header('Location: index.php');
	exit;
}
else
{
	$result = db_do("SELECT d2dbucks.id, d2dbucks.serial_id, d2dbucks.amount, d2dbucks.status, DATE_FORMAT(d2dbucks.modified, '%d-%b-%Y')
					FROM d2dbucks WHERE id='$id'");
	list($id, $serial_num, $amount, $status, $modified) = db_row($result);
}

include('../header.php');

?>
<html>
 <head>
	<script language="JavaScript" type="text/JavaScript">
	function ChooseMenu(targ,selObj,restore){
	  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;}
	</script>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <br><p align="center" class="big"><b><?=$page_title?></b></p><br>
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
			<td class="normal"><?=$amount?></td>
		</tr>
		<tr>
			<td class="header" align="right">District Manager:</td><td class="normal">
				<form method="post">
					<select onChange="ChooseMenu('parent',this,0)">

<?php	if(isset($dm_id))
		{
			$result = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM dms WHERE id='$dm_id' and status='active'");
			list($dm_name) = db_row($result);
			echo "<option value='?id=$id&dm_id=$dm_id' selected>$dm_name</option>";
		}

		if(!isset($dm_id))
			echo "<option value='?id=$id&'>Choose One</option>";

		$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name) FROM dms ORDER BY last_name");
		while (list($dmid, $dmname) = db_row($result))
			echo "<option value='?id=$id&dm_id=$dmid'>$dmname</option>";
?>
					</select>
				</form>
			</td>
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
			echo "<option value='?id=$id&dm_id=$dm_id&ae_id=$ae_id' selected>$aename</option>";
		}

		echo "<option value='?id=$id&dm_id=$dm_id&ae_id=0&dealer_id=0'>Leave Unassigned</option>";

		if(isset($dm_id))
		{
			$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name) FROM aes WHERE dm_id='$dm_id' and status='active' ORDER BY last_name");
			while (list($aeid, $aename) = db_row($result))
				echo "<option value='?id=$id&dm_id=$dm_id&ae_id=$aeid'>$aename</option>";
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
			echo "<option value='?id=$id&dm_id=$dm_id&ae_id=$ae_id&dealer_id=$dealer_id' selected>$dealer_name</option>";
		}

		echo "<option value='?id=$id&dm_id=$dm_id&ae_id=$ae_id&dealer_id=0'>Leave Unassigned</option>";

		if(isset($ae_id))
		{
			$result = db_do("SELECT id, name FROM dealers WHERE ae_id='$ae_id' and status='active' ORDER BY name");
			while (list($dealerid, $dealername) = db_row($result))
				echo "<option value='?id=$id&dm_id=$dm_id&ae_id=$ae_id&dealer_id=$dealerid'>$dealername</option>";
		}

	echo "			</select>
				</form>
			</td>
		</tr>";

db_free($result);
?>
</table>

	<p><form method="post">
			<input type="hidden" name="dm_id" value="<?=$dm_id?>" />
			<input type="hidden" name="ae_id" value="<?=$ae_id?>" />
			<input type="hidden" name="dealer_id" value="<?=$dealer_id?>" />
			<p align="center"><input class="header" type="submit" value="  Update  " name="submit">
		</form>
<?php db_disconnect(); ?>