<?php


include('../../../../include/session.php');
include('../../../../include/db.php');
db_connect();

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$result = db_do("SELECT COUNT(*) FROM d2dbucks WHERE id='$id' and ae_id='$ae_id'");
if (db_num_rows($result) == 0) {
	header('Location: index.php');
	exit;
}

$page_title = 'Edit D2DBucks';

if (isset($submit)) {
	db_do("UPDATE d2dbucks SET dealer_id='$dealer__id' WHERE id='$id'");
	
	header('Location: index.php');
	exit;
}
else
{
	$result = db_do("SELECT d2dbucks.id, d2dbucks.serial_id, d2dbucks.amount, CONCAT(dms.first_name, ' ', dms.last_name), 
					CONCAT(aes.first_name, ' ', aes.last_name), d2dbucks.status, DATE_FORMAT(d2dbucks.modified, '%d-%b-%Y') 
					FROM d2dbucks, dms, aes WHERE d2dbucks.id='$id' and dms.id='$dm_id' and aes.id='$ae_id'");
	list($id, $serial_num, $amount, $dm_name, $ae_name, $status, $modified) = db_row($result);
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
			<td class="header" align="right">District Manager:</td>
			<td class="normal"><?=$dm_name?></td>
		</tr>
		<tr>
			<td class="header" align="right">Account Executive:</td>
			<td class="normal"><?=$ae_name?></td>
		</tr>	

<?			
	### DROP DOWN TABLE 3

	echo "<tr>
			<td class=\"header\" align=\"right\">Dealership:</td><td class=\"normal\">
				<form method=\"post\">
					<select onChange=\"ChooseMenu('parent',this,0)\">";

		if(isset($dealer__id) && $dealer__id!=0)
		{
			$result = db_do("SELECT name FROM dealers WHERE id='$dealer__id'");
			list($dealername) = db_row($result);
			echo "<option value='?id=$id&dm_id=$dm_id&ae_id=$ae_id&dealer__id=$dealer__id' selected>$dealername</option>";
		}
		
		echo "<option value='?id=$id&dm_id=$dm_id&ae_id=$ae_id&dealer__id=0'>Leave Unassigned</option>";
		
		if(isset($ae_id))
		{
			$result = db_do("SELECT id, name FROM dealers WHERE ae_id='$ae_id' and status='active' ORDER BY name");
			while (list($dealerid, $dealername) = db_row($result))
				echo "<option value='?id=$id&dm_id=$dm_id&ae_id=$ae_id&dealer__id=$dealerid'>$dealername</option>";
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
			<input type="hidden" name="dealer__id" value="<?=$dealer__id?>" />
			<p align="center"><input class="header" type="submit" value="  Update  " name="submit">
		</form>
<?php db_disconnect(); 
include('../../footer.php'); ?>