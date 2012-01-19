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
# $srp: godealertodealer.com/htdocs/auction/auctions/all.php,v 1.9 2002/09/03 00:40:30 steve Exp $
#

include('../../../include/session.php');
extract(defineVars("id", "add", "delbox", "wid", "submit")); //JJM 1/13/2010

function deleteFromWatchList ($id)
{
  db_do("DELETE FROM watch_list WHERE id='$id'" );
   return;
}

$page_title = 'My Watch List';
$help_page = "chp7.php#Chp7_MyWatchList";



if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

include('../../../include/db.php');
db_connect();

if ($add=="1") {
	 $count=count($delbox);
   for ($i=0;$i<$count;$i++) {
	 		 deleteFromWatchList($delbox[$i]);
	 }
	 header("Location: watch.php");
	 exit();
}

$sql = "SELECT COUNT(*) " .
        		"FROM watch_list, auctions, categories, users " .
            "WHERE watch_list.user_id = '$userid' AND " .
						"watch_list.auction_id = auctions.id AND " .
						"auctions.category_id = categories.id AND " .
						"auctions.user_id = users.id";

include('../../../include/list.php');
include('../header.php');

$result = db_do("SELECT watch_list.id, auctions.id, auctions.title, auctions.status, " .
		 	 			"DATE_FORMAT( auctions.ends, '%Y-%m-%d %T' ), UNIX_TIMESTAMP(auctions.ends),
						DATE_FORMAT( watch_list.reminder, '%Y-%m-%d %T' ), auctions.current_bid, " .
						"categories.name, users.username, auctions.vehicle_id " .
        		"FROM watch_list, auctions, categories, users " .
            "WHERE watch_list.user_id = '$userid' AND " .
						"watch_list.auction_id = auctions.id AND " .
						"auctions.category_id = categories.id AND " .
						"auctions.user_id = users.id " .
            "ORDER BY auctions.ends DESC, auctions.id " );
?>
  <br>
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
<?php
if (db_num_rows($result) <= 0) {
$num_results = 0;
?>
   <tr>
    <td align="center" colspan="8" class="big">No watched auctions found.</td>
   </tr>
<?php
} else {
$num_results = db_num_rows($result);
?>
   <tr><td colspan="8"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td class="header"></td>
	<td class="header" align="center">Select <br>to Delete</td>
    <td class="header">Category</td>
	<td>&nbsp;</td>
    <td class="header">Auction Title</td>
    <td class="header">Status</td>
    <td class="header">High Bid</td>
	<td class="header">End of Auction</td>
	<td class="header">Email Reminder</td>
   </tr>
	 <form action="watch.php?add=1" method="POST">
<?php
	$bgcolor = '#FFFFFF';
	while (list($wid, $aid, $title, $status, $ends, $ends_time, $reminder, $high_bid, $category, $un, $vid)
	    = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$r = db_do("SELECT photo_id FROM vehicles WHERE id='$vid'");
		list($photo_id) = db_row($r);
		db_free($r);

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<img src="../uploaded/thumbnails/'.$photo_id.'.jpg" alt="Click here to view photo" border="0">';
		else
			$pic = '';

		if ($high_bid <= 0)
			$high_bid = '<center>-&nbsp;-</center>';
		else
			$high_bid = number_format($high_bid, 2);

		$now = time();
		if($ends_time < $now) {
			$ends = "Ended";
			$status = 'closed';
		}
		if ($status == 'pulled' ) {
			$ends = "N/A";
			$reminder = "";
		}
		if ($status == 'closed' || $status == 'pulled')
			$status = "<b>$status</b>";
?>
	<input type="hidden" name="wid" value="<?php echo $wid; ?>" />
   <tr bgcolor="<?php echo $bgcolor; ?>">
   	<td align="right" class="normal"><?php if ($status != '<b>closed</b>' && $status != '<b>pulled</b>') { ?>
		<a href="edit_watch.php?id=<?=$wid?>">edit</a><?php } ?></td>
	<td align="center" class="normal"><input type="checkbox" name="delbox[]" value=<?=$wid?> /></td>
    <td class="normal"><?php tshow($category); ?></td>
	<td align="center" valign="middle"><a href="../auction.php?id=<?=$aid?>"><?=$pic?></a></td>
    <td class="normal"><a href="../auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
    <td class="normal"><?php tshow($status); ?></td>
    <td class="normal"><?php tshow($high_bid); ?></td>
	<td class="normal"><?php tshow($ends); ?></td>
	<td class="normal"><?php if ($status != '<b>closed</b>') tshow($reminder); ?></td>
   </tr>
<?php
	}
}
?>
<?php
if ($num_results > 0) {
?>
	<tr><td colspan="1"></td><td colspan="7" align="left"><input type="submit" name="submit" value="Delete"></td></tr>
<?php }
db_free($result);
db_disconnect();
?>
	</form>
  </table>
<?php include('../footer.php'); ?>