<?php
#
# Copyright (c) 2006 Go DEALER to DEALER
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
# $srp: godealertodealer.com/htdocs/auction/bids/index.php,v 1.14 2003/05/15 16:40:12 Exp $
#

include('../../../include/session.php');
extract(defineVars( "q", "page_title", "no_menu"));    // Added by RJM 1/4/10

if (!has_priv('buy', $privs)) {
	header('Location: ../menu.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$sql = "SELECT COUNT(DISTINCT(auction_id)) FROM auctions, bids WHERE " .
    "bids.dealer_id='$dealer_id' AND bids.auction_id=auctions.id AND " .
    "auctions.status='open'";

$help_page = "chp5_check.php";

include('../../../include/list.php');
include('../header.php');

$result = db_do("SELECT bids.auction_id, auctions.title, auctions.winning_bid, auctions.reserve_price, auctions.vehicle_id
				FROM auctions, bids
				WHERE auctions.id=bids.auction_id AND auctions.status='open' AND bids.dealer_id='$dealer_id'
				GROUP BY bids.auction_id
				ORDER BY auctions.id DESC LIMIT $_start, $limit");
?>
  <br>
  <p align="center" class="big"><b> Bids for Open Auctions</b></p>
<?php include('_links.php'); ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No bids found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
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
	while (list($aid, $title, $winning_bid, $reserve_price, $vid) = db_row($result)) {

		$result_max = db_do("SELECT bids.id, bids.current_bid, bids.maximum_bid, users.username FROM bids, users
			WHERE bids.dealer_id='$dealer_id' AND bids.auction_id='$aid' AND bids.user_id=users.id
			ORDER BY bids.current_bid DESC, bids.maximum_bid DESC");

		list($highest_bid, $bid, $maximum_bid, $un) = db_row($result_max);
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

		if ($winning_bid == $highest_bid) {
			if ($bid >= $reserve_price)
				$outcome = 'winning';
			else
				$outcome = 'reserve not met';
		} else
			$outcome = 'losing';

		$bid = number_format($bid, 2);
		$maximum_bid = number_format($maximum_bid, 2);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
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