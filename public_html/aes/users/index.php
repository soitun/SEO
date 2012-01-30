<?php
include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

if (empty($did) || $did <= 0) {
	header('Location: index.php');
	exit;
}

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: http://' . $_SERVER['SERVER_NAME']);
	exit;
}

$dealers_array = findDEALERforAE($ae_id);
if (!in_array($did, $dealers_array)) {
	header('Location: http://' . $_SERVER['SERVER_NAME']);
	exit;
}

$page_title = 'Account Executive - Dealer Users';

$result = db_do("SELECT name, address1, address2, city, state, zip FROM dealers WHERE id='$did'");
list($dealer, $address1, $address2, $city, $state, $zip) = db_row($result);
db_free($result);

$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name) as name, email, username, phone, title, privs, status FROM users WHERE dealer_id='$did' ORDER BY last_name, first_name");

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
<?php include('../header.php'); ?><?php include('_links.php'); ?><br>
<table align="center" border="0" cellspacing="0" cellpadding="0">
<tr><td align="center" class="huge"><?php $dealer?></td></tr>
<tr><td align="center" class="normal">&nbsp;<br><?php $address1." ".$address2?></td></tr>
<tr><td align="center" class="normal"><?php $city.", ".$state." ".$zip?></td></tr>
</table><br>
<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php if (count($pending) > 0) { ?>
   <tr>
    <td class="big" colspan="5"><u><b>Pending Users</b></u></td>
   </tr>
   <tr> 
    <td class="header"><b>Name</b></td>
    <td class="header"><b>Email</b></td>
		<td class="header"><b>Username</b></td>
    <td class="header"><b>Phone</b></td>
    <td class="header"><b>Title</b></td>
    <td class="header"><b>Privileges</b></td>
   </tr>
<?php
$bgcolor = '#FFFFFF';

while (list(, $row) = each($pending)) {
	list($id, $name, $email, $uname, $phone, $title, $privs) = $row;
	$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><?php tshow($email); ?></td>
		<td class="normal"><?php tshow($uname); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($title); ?></td>
    <td class="normal"><?php tshow($privs); ?></td>
   </tr>
<?php } ?>
   <tr><td colspan="5">&nbsp;</td></tr>
<?php } else { ?>
	 <tr>
    <td class="big" colspan="5"><u><b>No Pending Users</b></u></td>
   </tr>
<?php } ?>
<?php if (count($active) > 0) { ?>
   <tr>
    <td class="big" colspan="5"><u><b>Active Users</b></u></td>
   </tr>
   <tr> 
   <?php if ($_SESSION['limited'] == 1) : ?>
   <td class="header"><b>Become</b></td>
   <?php endif; ?>
    <td class="header"><b>Name</b></td>
    <td class="header"><b>Email</b></td>
		<td class="header"><b>Username</b></td>
    <td class="header"><b>Phone</b></td>
    <td class="header"><b>Title</b></td>
    <td class="header"><b>Privileges</b></td>
   </tr>
<?php
$bgcolor = '#FFFFFF';

while (list(, $row) = each($active)) {
	list($id, $name, $email, $uname, $phone, $title, $privs) = $row;
	$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <?php if ($_SESSION['limited'] == 1) : ?>
    <td class="normal"><a href="become.php?id=<?php echo $id ?>">(become)</a></td>
    <?php endif; ?>
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><?php tshow($email); ?></td>
		<td class="normal"><?php tshow($uname); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($title); ?></td>
    <td class="normal"><?php tshow($privs); ?></td>
   </tr>
<?php } ?>
   <tr><td colspan="5">&nbsp;</td></tr>
<?php } else { ?>
	 <tr>
    <td class="big" colspan="5"><u><b>No Active Users</b></u></td>
   </tr>
<?php } ?>
<?php if (count($suspended) > 0) { ?>
   <tr>
    <td class="big" colspan="5"><u><b>Suspended Users</b></u></td>
   </tr>
   <tr> 
    <td class="header"><b>Name</b></td>
    <td class="header"><b>Email</b></td>
		<td class="header"><b>Username</b></td>
    <td class="header"><b>Phone</b></td>
    <td class="header"><b>Title</b></td>
    <td class="header"><b>Privileges</b></td>
   </tr>
<?php
$bgcolor = '#FFFFFF';

while (list(, $row) = each($suspended)) {
	list($id, $name, $email, $uname, $phone, $title, $privs) = $row;
	$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><?php tshow($email); ?></td>
		<td class="normal"><?php tshow($uname); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($title); ?></td>
    <td class="normal"><?php tshow($privs); ?></td>
   </tr>
<?php } ?>
<?php } else { ?>
	 <tr>
    <td class="big" colspan="5"><u><b>No Suspended Users</b></u></td>
   </tr>
<?php } ?>
  </table>
<?php
	include('../footer.php');
?>
