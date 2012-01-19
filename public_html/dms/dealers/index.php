
<?php
include('../../../include/session.php');
extract(defineVars("id", "order", "saved", "nav_links"));


$page_title = 'AE Dealer Info';
$page_link = '../docs/chp4.php#Chp4_DealerInfo';

include('../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

if (isset($order)) {
	if ($order=='dname') {
		$order = " ORDER BY dealers.dba"; }
	if ($order=='loc') {
		$order = " ORDER BY dealers.state, dealers.city"; }
	if ($order=='pname') {
		$order = " ORDER BY dealers.poc_l_name, dealers.poc_f_name"; }
	if ($order=='aname') {
		$order = " ORDER BY aes.last_name, aes.first_name"; }
	if ($order=='pemail') {
		$order = " ORDER BY dealers.poc_email"; }
	if ($order=='phone') {
		$order = " ORDER BY dealers.phone"; }
	if ($order=='created') {
		$order = " ORDER BY dealers.created"; }
}

if (isset($submit)) {
	if ($category=='POC Name') {
		$order = " AND (dealers.poc_l_name LIKE '%$search%' OR dealers.poc_f_name LIKE '%$search%')".$order; }
	else {
		$order = " AND dealers.dba LIKE '%$search%'".$order; }
}
if (!isset($s)) {
	$s='all'; }

if ($s=='all') {
	$result = db_do("SELECT dealers.id, aes.id, CONCAT(aes.first_name, ' ', aes.last_name), CONCAT(dealers.poc_f_name, ' ', dealers.poc_l_name), dealers.poc_email, dealers.dba, dealers.phone, dealers.city, dealers.state, DATE_FORMAT(dealers.created, '%d-%b-%Y'), dealers.status FROM dealers, users, aes, dms WHERE users.username = '$username' and dms.user_id = users.id and dms.id=aes.dm_id and dealers.ae_id = aes.id".$order); 	}
else {
	$result = db_do("SELECT dealers.id, aes.id, CONCAT(aes.first_name, ' ', aes.last_name), CONCAT(dealers.poc_f_name, ' ', dealers.poc_l_name), dealers.poc_email, dealers.dba, dealers.phone, dealers.city, dealers.state, DATE_FORMAT(dealers.created, '%d-%b-%Y'), dealers.status FROM dealers, users, aes, dms WHERE users.username = '$username' and dms.user_id = users.id and dms.id=aes.dm_id and dealers.ae_id = aes.id AND dealers.status='$s'".$order); }

$pending = array();
$active = array();
$suspended = array();

while ($row = db_row($result)) {
	switch ($row['status']) {
	case 'pending':
		$pending[] = $row;
		break;
	case 'active':
		$active[] = $row;
		break;
	case 'suspended':
		$suspended[] = $row;
		break;
	case 'saved':
		$saved[] = $row;
		break;
	}
}

db_free($result);
db_disconnect();

?>

<html>
	<head>
		<title><?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
	</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<?php include('_links.php'); ?>
<br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include ('_links_dealer.php'); ?>
<br>
<center>
<form action="index.php?s=<?=$s?>" method="post">
Search:
<input type="text" name="search">
<select name="category">
<option>POC Name</option>
<option>Dealership Name</option>
</select>
<input type="submit" name="submit" value="Submit">
</form>
</center>
<br>
<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php if (count($active) > 0) { ?>
	 <tr><td class="big" colspan="5"><u><b>Active Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>

   <tr>
    <td>&nbsp;</td>
   <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=aname">Account Executive</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>


<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($active)) {
		list($id, $ae_id, $ae_name, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="../aes/charges/invoice.php?did=<?php echo $id; ?>&id=<?php echo $ae_id; ?>">charges</a> | <a href="../aes/users/index.php?did=<?php echo $id; ?>&id=<?php echo $ae_id; ?>">users</a><br><a href="../aes/auctions/index.php?did=<?php echo $id; ?>&id=<?php echo $ae_id; ?>">auctions</a> | <a href="../aes/vehicles/index.php?did=<?php echo $id; ?>&id=<?php echo $ae_id; ?>">items</a></td>
	<td class="normal"><?php echo $ae_name; ?></td>
    <td class="normal"><?php tshow($name); ?></td>
	<td class="normal"><?php tshow($city); echo ", "; tshow($state); ?></td>
    <td class="normal"><?php tshow($poc_name); ?></td>
    <td class="normal"><?php tshow($poc_email); ?></td>
	<td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
?>
<?php } else { if (isset($s) && $s == 'active') {?>
	 <tr><td class="big" colspan="5"><u><b>No Active Dealers</b></u></td></tr>
<?php } } ?>
<?php if (count($pending) > 0) {
	if ($s=='all') { ?>
	  <tr><td class="header" colspan="9"><br><hr></td></tr><?php } ?>
	 <tr><td class="big" colspan="5"><br><u><b>Pending Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
	<td class="normal"><b><a href="index.php?s=<?php echo $s; ?>&order=aname">Account Executive</td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($pending)) {
		list($id, $ae_id, $ae_name, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td width="120" align="left" class="small">
	&bull;&nbsp;<a href="../aes/edit_dealer.php?did=<?php echo $id; ?>">Edit Dealer Info</a><br>
	&bull;&nbsp;<a href="../aes/application_form.php?id=<?php echo $id; ?>">Print Application Form</a><br>
</td>
	<td class="normal"><?php echo $ae_name; ?></td>
    <td class="normal"><?php tshow($name); ?></td>
	<td class="normal"><?php tshow($city); echo ", "; tshow($state); ?></td>
    <td class="normal"><?php tshow($poc_name); ?></td>
    <td class="normal"><?php tshow($poc_email); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
?>
<?php } else { if (isset($s) && $s == 'pending') {?>
	<tr>
		<td class="big" colspan="5"><br><u><b>No Pending Dealers</b></u></td>
	</tr>
<?php } } ?>
<?php if (count($suspended) > 0) {
	if ($s=='all') { ?>
 <tr><td class="header" colspan="9"><br><hr></td></tr><?php } ?>
 <tr><td class="big" colspan="5"><br><u><b>Suspended Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
	<td class="normal"><b><a href="index.php?s=<?php echo $s; ?>&order=aname">Account Executive</a></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($suspended)) {
		list($id, $ae_id, $ae_name, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="../aes/charges/invoice.php?did=<?php echo $id; ?>&id=<?php echo $ae_id; ?>">charges</a> | <a href="../aes/users/index.php?did=<?php echo $id; ?>&id=<?php echo $ae_id; ?>">users</a><br><a href="../aes/auctions/index.php?did=<?php echo $id; ?>&id=<?php echo $ae_id; ?>">auctions</a> | <a href="../aes/vehicles/index.php?did=<?php echo $id; ?>&id=<?php echo $ae_id; ?>">items</a></td>
	<td class="normal"><?php echo $ae_name; ?></td>
    <td class="normal"><?php tshow($name); ?></td>
	<td class="normal"><?php tshow($city); echo ", "; tshow($state); ?></td>
    <td class="normal"><?php tshow($poc_name); ?></td>
    <td class="normal"><?php tshow($poc_email); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
?>
<?php } else { if (isset($s) && $s == 'suspended') {?>
	 <tr>
    <td class="big" colspan="5"><br><u><b>No Suspended Dealers</b></u></td>
   </tr>
<?php } } ?>
<?php if (count($saved) > 0) {
	if ($s=='all') { ?>
 <tr><td class="header" colspan="9"><br><hr></td></tr><?php } ?>
 <tr><td class="big" colspan="5"><br><u><b>Saved Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
   <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=aname">Account Executive</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($saved)) {
		list($id, $ae_id, $ae_name, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="../aes/edit_dealer.php?did=<?php echo $id; ?>">edit</a> |
	<a href="../aes/remove_dealer.php?did=<?=$id?>">remove</a></td>
	<td class="normal"><?php echo $ae_name; ?></td>
    <td class="normal"><?php tshow($name); ?></td>
	<td class="normal"><?php tshow($city); echo ", "; tshow($state); ?></td>
    <td class="normal"><?php tshow($poc_name); ?></td>
    <td class="normal"><?php tshow($poc_email); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
?>
<?php } else { if ($s == 'saved') { ?>
	 <tr>
    <td class="big" colspan="5"><br><u><b>No Saved Dealers</b></u></td>
   </tr>
<?php } } ?>

</table>
<?php
	include('../footer.php');
?>