<?php

$page_title = 'District Manager\'s AE Info';

include('../../include/session.php');
include('../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}
if (!isset($s)) {
	$s='active'; }

if (isset($order)) {
	if ($order=='name') {
		$order = ' ORDER BY name ASC, created DESC';
	}
	if ($order=='address') {
		$order = ' ORDER BY address';
	}
	if ($order=='city') {
		$order = ' ORDER BY city';
	}			
	if ($order=='state') {
		$order = ' ORDER BY state';
	}			
	if ($order=='zip') {
		$order = ' ORDER BY zip';
	}
	if ($order=='phone') {
		$order = ' ORDER BY phone';
	}			
	if ($order=='created') {
		$order = ' ORDER BY created';		
	}			
}
else
	$order = ' ORDER BY created DESC, name ASC';

if ($did == 0)
	$sql = "SELECT COUNT(*) FROM dmreports WHERE ae_id='$ae_id'";
else
	$sql = "SELECT COUNT(*) FROM dmreports WHERE name='$dealer_name'";

include('../../include/list.php');

if ($did == 0) {
	$result = db_do("SELECT id, ae_id, comments, name, address, city, state, zip, phone, poc_1_name, poc_1_title, poc_1_direct, poc_1_cell, poc_1_email, 
			poc_2_name, poc_2_title, poc_2_direct, poc_2_cell, poc_2_email, poc_3_name, poc_3_title, poc_3_direct, poc_3_cell, poc_3_email, 
			DATE_FORMAT(meeting, '%a, %b %D at %l %p'), DATE_FORMAT(created, '%b %d, %Y %l:%i %p') FROM dmreports WHERE ae_id='$ae_id' $order LIMIT $_start, $limit"); 
} else {
	$result_d = db_do("SELECT name FROM dealers WHERE id='$did'"); 
	list($dealer_name) = db_row($result_d);

	$result = db_do("SELECT id, ae_id, comments, name, address, city, state, zip, phone, poc_1_name, poc_1_title, poc_1_direct, poc_1_cell, poc_1_email, 
			poc_2_name, poc_2_title, poc_2_direct, poc_2_cell, poc_2_email, poc_3_name, poc_3_title, poc_3_direct, poc_3_cell, poc_3_email, 
			DATE_FORMAT(meeting, '%a, %b %D at %l %p'), DATE_FORMAT(created, '%b %d, %Y') FROM dmreports WHERE name='$dealer_name' $order LIMIT $_start, $limit"); 
}

?>
<html>
 <head>
  <title><?php $page_title?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('header.php'); ?>
<?php include('_links.php'); ?>
<br>
<table align="center" border="0" cellspacing="0" cellpadding="2" width="95%">
<?php if ($did == 0) { ?>
   <tr><td colspan="9"><?php echo $nav_links; ?></td></tr>
   <tr> 
    <td class="header"><b>AE Name</b></td>
	<td class="header"><b><a href="reports.php?ae_id=<?php $ae_id?>&order=name">Dealer Name</a></b></td>
    <td class="header"><b><a href="reports.php?ae_id=<?php $ae_id?>&order=address">Address</a></b></td>
    <td class="header"><b><a href="reports.php?ae_id=<?php $ae_id?>&order=city">City</a></b></td>
    <td class="header"><b><a href="reports.php?ae_id=<?php $ae_id?>&order=state">State</a></b></td>
    <td class="header"><b><a href="reports.php?ae_id=<?php $ae_id?>&order=zip">Zip</a></b></td>
	<td class="header"><b><a href="reports.php?ae_id=<?php $ae_id?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="reports.php?ae_id=<?php $ae_id?>&order=created">Date</a></b></td>
   </tr>  
<?php } else { ?>
	<tr><td colspan="9"><?php echo $nav_links; ?></td></tr>
	<tr>
    <td class="header"><b>AE Name</b></td>
	<td class="header"><b><a href="reports.php?did=<?php $did?>&order=name">Dealer Name</a></b></td>
    <td class="header"><b><a href="reports.php?did=<?php $did?>&order=address">Address</a></b></td>
    <td class="header"><b><a href="reports.php?did=<?php $did?>&order=city">City</a></b></td>
    <td class="header"><b><a href="reports.php?did=<?php $did?>&order=state">State</a></b></td>
    <td class="header"><b><a href="reports.php?did=<?php $did?>&order=zip">Zip</a></b></td>
	<td class="header"><b><a href="reports.php?did=<?php $did?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="reports.php?did=<?php $did?>&order=created">Date</a></b></td>
   </tr> 
<?php }
	$bgcolor = '#FFFFFF';
	while (list($id, $ae_id, $comments, $name, $address, $city, $state, $zip, $phone, 
				$poc_1_name, $poc_1_title, $poc_1_direct, $poc_1_cell, $poc_1_email, 
				$poc_2_name, $poc_2_title, $poc_2_direct, $poc_2_cell, $poc_2_email, 
				$poc_3_name, $poc_3_title, $poc_3_direct, $poc_3_cell, $poc_3_email, 
				$meeting, $created) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		
		$result_ae = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM aes WHERE id='$ae_id'"); 
		list($ae_name) = db_row($result_ae);
?>
	<tr bgcolor="<?php $bgcolor?>">
		<td class="normal"><?php tshow($ae_name); ?></td>
		<td class="normal"><?php tshow($name); ?></td>
		<td class="normal"><?php tshow($address); ?></td>
		<td class="normal"><?php tshow($city); ?></td>
		<td class="normal"><?php tshow($state); ?></td>
		<td class="normal"><?php tshow($zip); ?></td>
		<td class="normal"><?php tshow($phone); ?></td>
		<td class="normal"><?php tshow($created); ?></td>
	</tr>
	<tr bgcolor="<?php $bgcolor?>">
		<td class="normal" colspan="9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php tshow($comments); ?>
		&nbsp;&nbsp;("Tentative" Follow-up on: <?php $meeting?>)</td>
	</tr>
	<tr bgcolor="<?php $bgcolor?>">
		<td>&nbsp;</td>
		<td class="normal" colspan="1">POC #1 = &nbsp;<?php echo "$poc_1_name, $poc_1_title"; ?></td>
		<td class="normal" colspan="1"><?php echo "Direct #: $poc_1_direct"; ?></td>
		<td class="normal" colspan="1"><?php echo "Cell #: $poc_1_cell"; ?></td>
		<td class="normal" colspan="9"><?php echo "Email: $poc_1_email"; ?></td>
	</tr>
	<tr bgcolor="<?php $bgcolor?>">
		<td>&nbsp;</td>
		<td class="normal" colspan="1">POC #2 = &nbsp;<?php echo "$poc_2_name, $poc_2_title"; ?></td>
		<td class="normal" colspan="1"><?php echo "Direct #: $poc_2_direct"; ?></td>
		<td class="normal" colspan="1"><?php echo "Cell #: $poc_2_cell"; ?></td>
		<td class="normal" colspan="9"><?php echo "Email: $poc_2_email"; ?></td>
	</tr>
	<tr bgcolor="<?php $bgcolor?>">
		<td>&nbsp;</td>
		<td class="normal" colspan="1">POC #3 = &nbsp;<?php echo "$poc_3_name, $poc_3_title"; ?></td>
		<td class="normal" colspan="1"><?php echo "Direct #: $poc_3_direct"; ?></td>
		<td class="normal" colspan="1"><?php echo "Cell #: $poc_3_cell"; ?></td>
		<td class="normal" colspan="9"><?php echo "Email: $poc_3_email"; ?></td>
	</tr>
<?php } ?>
</table>
<?php include('footer.php'); ?>