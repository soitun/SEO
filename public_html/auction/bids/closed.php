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
# $srp: godealertodealer.com/htdocs/auction/bids/closed.php,v 1.9 2002/09/03 00:40:32 steve Exp $
#

include('../../../include/session.php');
extract(defineVars( "q", "page_title", "no_menu"));    // Added by RJM 1/4/10

if (!has_priv('buy', $privs)) {
	header('Location: ../menu.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$sql = "SELECT COUNT(*)
		FROM auctions, bids, users
		WHERE auctions.id=bids.auction_id AND auctions.status!='open' AND bids.dealer_id='$dealer_id' AND bids.user_id=users.id
		GROUP BY bids.auction_id";

$help_page = "chp5_check.php";

include('../../../include/list.php');
include('../header.php');

$result = db_do("SELECT bids.auction_id, auctions.title, auctions.winning_bid, auctions.reserve_price, max(bids.id), auctions.chaching,
					max(bids.current_bid), users.username, auctions.status, auctions.vehicle_id FROM auctions, bids, users
				WHERE auctions.id=bids.auction_id AND auctions.status!='open' AND bids.dealer_id='$dealer_id' AND bids.user_id=users.id
				GROUP BY bids.auction_id
				ORDER BY auctions.id DESC
				LIMIT $_start, $limit");
?>
  <br>
  <p align="center" class="big"><b> Bids for Closed Auctions</b></p>
<?php include('_links.php'); ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="left" class="big" colspan="7">&nbsp;No bids found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="7"><?php echo $nav_links; ?></td></tr>
   <tr>
   	<td>&nbsp;</td>
	<td>&nbsp;</td>
    <td class="header">Auction Title</td>
    <td class="header">Auction #</td>
    <td class="header">Bidder</td>
    <td class="header">Status</td>
    <td class="header">Current Bid</td>
    <td class="header">Maximum Bid</td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($aid, $title, $winning_bid, $reserve_price, $cid, $chaching, $bid,
	    $un, $status, $vid) = db_row($result)) {

		$result_max = db_do("SELECT bids.maximum_bid FROM bids, auctions WHERE $cid=bids.id");
		list($maximum_bid) = db_row($result_max);
		db_free($result_max);

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

		if ($status == 'pulled')
			$outcome = 'pulled';
		elseif ($winning_bid == $cid && $chaching == '1')
			$outcome = 'won';
		else
			$outcome = 'lost';

		$bid = number_format($bid, 2);
		$maximum_bid = number_format($maximum_bid, 2);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
   	<td class="normal">
<?php
	$result_offer = db_do("SELECT id FROM alerts WHERE auction_id='$aid' AND from_user='0' AND to_user='$userid' AND status='pending'");
	if (db_num_rows($result_offer) > 0) { ?>
	<a href="makeoffer.php?id=<?php echo $aid; ?>"><font color="#FF0000">make offer</font></a>
<?php } ?></td>
	<td align="center" valign="middle"><a href="../auction.php?id=<?php echo $aid; ?>"><?php $pic?></a></td>
    <td class="normal"><a href="../auction.php?id=<?php echo $aid; ?>"><?php echo $title; ?></a></td>
    <td align="center" class="normal"><?php echo $aid; ?></td>
    <td class="normal"><?php echo $un; ?></td>
    <td class="normal"><?php echo $outcome; ?></td>
    <td align="right" class="normal">US $<?php echo $bid; ?></td>
    <td align="right" class="normal">US $<?php echo $maximum_bid; ?></td>
   </tr>
<?php
	}
}
db_free($result);
db_disconnect();
?>
  </table>
<?php include('../footer.php'); ?>