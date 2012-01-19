<?php



if(!empty($_REQUEST['nav_links']))
	$nav_links = $_REQUEST['nav_links'];
else
	$nav_links = "";


?>
<?php
#
# Copyright (c) 2005 Debbie Matthews
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
# $srp: godealertodealer.com/htdocs/aes/auctions.php,v 1.8 2002/09/03 00:35:40 steve Exp $
#


if (empty($s)) {
	$status = 'open';
	$s='open';
	}
else
	$status = $s;

include('../../include/session.php');

$page_title = 'District Manager ' . ucfirst($status) . ' Auctions';
$page_link = 'docs/chp5.php#Chp5_Auctions'.ucfirst($status);

include('../../include/db.php');
db_connect();


$result = db_do("SELECT count(auctions.id ), dealers.id, dealers.name, aes.first_name, aes.last_name " .
				" FROM auctions, dms, aes, dealers, users " .
				" WHERE users.username = '$username' " .
				" AND dms.user_id = users.id " .
				" AND aes.dm_id = dms.id " .
				" AND dealers.ae_id = aes.id " .
				" AND auctions.dealer_id = dealers.id " .
				" AND auctions.status='$status' " .
				" GROUP BY dealers.id ORDER BY aes.last_name ");

?>

<html>
 <head>
  <title><?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('header.php'); ?><?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?> <?php if ($status=='closed' || $status=='pulled') echo "(past year)"; ?></b></p>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="50%">
   <tr><td colspan="3"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td class="normal"><b><u>Account Executive</u></b></td>
    <td class="header"><b><u>Dealership Name</u></b></td>
    <td class="header"><b><u>Number of Auctions</u></b></td>
   </tr>
<?php
	while (list($num_auctions, $did, $name, $first_name, $last_name) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
   <td class="normal"><?php echo "$first_name $last_name"; ?></td>
    <td class="normal"><a href="auctions/index.php?did=<?php echo $did; ?>&s=<?php echo $s; ?>">
      <?php tshow($name); ?>
    </a></td>
    <td class="normal"><?php tshow($num_auctions); ?></td>
   </tr>
<?php
	}
?>
</table>
<?php
db_free($result);
db_disconnect();
include('footer.php');
?>