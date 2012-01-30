<?php

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$ae_array = findAEforDM($dm_id);
$check = false;
foreach ($ae_array as $ae) {
	$dealers_array = findDEALERforAE($ae);
	if (in_array($did, $dealers_array)) {
		$check=true;
		$idphp $ae;
      break;
	}
}	
if (!$check) {
	header('Location: https://www.godealertodealer.com');
	exit;
}		

if (empty($s))
	$status = 'active';
else
	$status = $s;

$result = db_do("SELECT id, name FROM categories WHERE deleted='0'");
$categories = array();
while (list($cid, $name) = db_row($result))
	$categories[$cid] = $name;
db_free($result);

$sql = "SELECT COUNT(*) FROM vehicles WHERE dealer_id='$dealer_id'";

if (isset($s)) {
	$result = db_do("SELECT auctions.id, auctions.category_id, auctions.title, vehicles.year, 
		vehicles.vin, vehicles.make, vehicles.model, vehicles.sell_price, vehicles.stock_num, auctions.status
		FROM auctions, vehicles 
		WHERE vehicles.dealer_id='$did' AND auctions.vehicle_id=vehicles.id AND auctions.status='$s'
		ORDER BY auctions.category_id, auctions.title, auctions.id, vehicles.year"); }
else {
	$result = db_do("SELECT auctions.id, auctions.category_id, auctions.title, vehicles.year, 
		vehicles.vin, vehicles.make, vehicles.model, vehicles.sell_price, vehicles.stock_num, auctions.status
		FROM auctions, vehicles 
		WHERE vehicles.dealer_id='$did' AND auctions.vehicle_id=vehicles.id 
		ORDER BY auctions.category_id, auctions.title, auctions.id, vehicles.year"); }
$dealerresult = db_do("SELECT id, name FROM dealers WHERE status='active' and id='$did'");
list($_id, $name) = db_row($dealerresult);

$page_title = "Dealership $name's Auctions";
?>
<html>
 <head>
  <title>Account Executive: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?php $page_title?></b></p><br>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No items found.</td>
   </tr>
<?php
} else {
?>
   <tr> 
    <td class="header"><b>Your Options</b></td>
		<td class="header"><b>Auction Status</b></td>
    <td class="header"><b>Category</b></td>
		<td class="header"><b>Stock Number</b></td>
    <td class="header" nowrap><b>Item Title</b></td>
    <td class="header"><b>Year</b></td>
    <td class="header"><b>Make</b></td>
    <td class="header"><b>Model</b></td>
    <td class="header"><b>VIN</b></td>
    <td class="header"><b><?php if ($status == 'sold') echo 'Sale Amount'; ?></b></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($aid, $cid, $short_desc, $year, $vin, $make, $model,
	    $sell_price, $stock_num, $auction_status) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
	 <td class="normal">
     <a href="auction.php?id=<?php $id?>&aid=<?php $aid?>">view</a>
    </td>
		<td class="normal"><?php tshow($auction_status); ?></td>
    <td class="normal"><?php tshow($categories[$cid]); ?></td>
		<td class="normal"><?php tshow($stock_num); ?></td>
    <td class="normal"><?php tshow($short_desc); ?></td>
    <td class="normal"><?php tshow($year); ?></td>
    <td class="normal"><?php tshow($make); ?></td>
    <td class="normal"><?php tshow($model); ?></td>
    <td class="normal"><?php tshow($vin); ?></td>
    <td align="right" class="normal"><?php if ($status == 'sold') echo '$' . number_format($sell_price, 2); ?></td>
   </tr>
<?php
	}
}
db_free($result);

db_disconnect();
?>
</table>
<br>
<center>
<?php
	include('../footer.php');
?>
</center>

