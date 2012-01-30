
<?php

if(!empty($_REQUEST['id']))
	$id = $_REQUEST['id'];
else
	$id = "";

if(!empty($_REQUEST['order']))
	$order = $_REQUEST['order'];
else
	$order = "";





?>

<?php
#
# Copyright (c) 2002 Steve Price
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions
# are met:
#
# 1. Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
# 2. Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
# ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
# FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
# DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
# OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
# HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
# LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
# OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
# SUCH DAMAGE.
#
# $srp: godealertodealer.com/htdocs/aes/dealers.php,v 1.8 2002/09/03 00:35:40 steve Exp $
#
include('../../../../include/session.php');
include('../../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}
$check=false;
$ae_array = findAEforDM($dm_id);
foreach ($ae_array as $ae) {
	if (in_array($ae, $ae_array)) {
		$check=true;
	}
}
if (!$check) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

if (isset($order)) {
	if ($order=='dname') {
		$order = ' ORDER BY dba';
	}
	if ($order=='loc') {
		$order = ' ORDER BY state, city';
	}
	if ($order=='pname') {
		$order = ' ORDER BY poc_l_name, poc_f_name';
	}
	if ($order=='pemail') {
		$order = ' ORDER BY poc_email';
	}
	if ($order=='phone') {
		$order = ' ORDER BY phone';
	}
	if ($order=='created') {
		$order = ' ORDER BY created';
	}
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
	$result = db_do("SELECT id, CONCAT(poc_f_name, ' ', poc_l_name), poc_email, dba,
				phone, city, state, DATE_FORMAT(created, '%d-%b-%Y'), status
				FROM dealers WHERE ae_id='$id'".$order); }
else {
	$result = db_do("SELECT id, CONCAT(poc_f_name, ' ', poc_l_name), poc_email, dba,
				phone, city, state, DATE_FORMAT(created, '%d-%b-%Y'), status
				FROM dealers WHERE ae_id='$id' AND dealers.status='$s'".$order); }

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

$result_ae_name = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM aes WHERE aes.id='$id'");
list($ae_name) = db_row($result_ae_name);
$page_title = "AE $ae_name's Dealer Info";

db_free($result);
db_disconnect();
?>

<html>
 <head>
  <title><?php $page_title?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../../header.php'); ?>
<?php include('_links.php'); ?>
<br>
<p align="center" class="big"><b><?php $page_title?></b></p>
<?php include ('_links_dealer.php'); ?>
<br>
<center>
<form action="index.php?id=<?php $id?>&s=<?php $s?>" method="post">
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
   <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>

<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($active)) {
		list($did, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="../charges/invoice.php?id=<?php $id?>&did=<?php $did?>">charges</a> | <a href="../users/index.php?id=<?php $id?>&did=<?php $did?>">users</a>
	<br><a href="../auctions/index.php?id=<?php $id?>&did=<?php $did?>">auctions</a> | <a href="../vehicles/index.php?id=<?php $id?>&did=<?php $did?>">items</a> | <a href="../bids/index.php?id=<?php $id?>&did=<?php $did?>">bids</a></td>
    <td class="normal"><?php tshow($name); ?></td>
	<td class="normal"><?php tshow($city); echo ", "; tshow($state); ?></td>
    <td class="normal"><?php tshow($poc_name); ?></td>
    <td class="normal"><a href="mailto:<?php tshow($poc_email); ?>"><?php tshow($poc_email); ?></a></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
?>
<?php } else { if ($s == 'active') {?>
	 <tr><td class="big" colspan="5"><u><b>No Active Dealers</b></u></td></tr>
<?php } } ?>
<?php if (count($pending) > 0) {
	if ($s=='all' && count($active)>0) { ?>
	  <tr><td class="header" colspan="9"><br><hr></td></tr><?php } ?>
	 <tr><td class="big" colspan="5"><br><u><b>Pending Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
   <td>&nbsp;</td>
   <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($pending)) {
		list($did, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td width="120" align="left" class="small">
	&bull;&nbsp;<a href="edit_dealer.php?id=<?php $id?>&did=<?php $did?>">Edit Dealer Info</a><br>
	&bull;&nbsp;<a href="application_form.php?id=<?php $id?>&did=<?php $did?>">Print Application Form</a><br>
	</td>
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
<?php } else { if ($s == 'pending') {?>
	<tr>
		<td class="big" colspan="5"><br><u><b>No Pending Dealers</b></u></td>
	</tr>
<?php } } ?>
<?php if (count($suspended) > 0) {
	if ($s=='all' && (count($active)>0 || count($pending)>0)) { ?>
 <tr><td class="header" colspan="9"><br><hr></td></tr><?php } ?>
 <tr><td class="big" colspan="5"><br><u><b>Suspended Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
   <td>&nbsp;</td>
   <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($suspended)) {
		list($did, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="../charges/invoice.php?id=<?php $id?>&did=<?php $did?>">charges</a> | <a href="../users/index.php?id=<?php $id?>&did=<?php $did?>">users</a>
	<br><a href="../auctions/index.php?id=<?php $id?>&did=<?php $did?>">auctions</a> | <a href="../vehicles/index.php?id=<?php $id?>&did=<?php $did?>">items</a></td>
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
<?php } else { if ( $s == 'suspended') {?>
	 <tr>
    <td class="big" colspan="5"><br><u><b>No Suspended Dealers</b></u></td>
   </tr>
<?php } } ?>
<?php if (count($saved) > 0) {
	if ($s=='all' && (count($active)>0 || count($pending)>0 || count($suspended)>0)) { ?>
 <tr><td class="header" colspan="9"><br><hr></td></tr><?php } ?>
 <tr><td class="big" colspan="5"><br><u><b>Saved Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
   <td>&nbsp;</td>
   <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?id=<?php $id?>&s=<?php $s?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($saved)) {
		list($did, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="edit_dealer.php?id=<?php $id?>&did=<?php $did?>">edit</a> |
	<a href="remove_dealer.php?id=<?php $id?>&did=<?php $did?>">remove</a></td>
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
<?php } else { if ( $s == 'saved') { ?>
	 <tr>
    <td class="big" colspan="5"><br><u><b>No Saved Dealers</b></u></td>
   </tr>
<?php } } ?>

  </table>
<?php
	include('../../footer.php');
?>