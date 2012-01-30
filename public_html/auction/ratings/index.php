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
# $srp: godealertodealer.com/htdocs/auction/ratings/index.php,v 1.2 2002/09/03 00:40:33 steve Exp $
#

include('../../../include/session.php');

if (!has_priv('buy', $privs)) {
	header('Location: ../menu.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$page_title = "Rate Sellers";
$help_page = "chp7.php#Chp7_Ratesellers";

include('../header.php');

$result = db_do("SELECT auctions.id, auctions.title, auctions.current_bid, auctions.vehicle_id " .
    "FROM auctions, bids WHERE auctions.status='closed' AND " .
    "auctions.chaching=1 AND auctions.winning_bid=bids.id AND " .
    "bids.dealer_id='$dealer_id' ORDER BY ends DESC");

$auctions = array();
while (list($id, $title, $bid, $vid) = db_row($result)) {
	$r = db_do("SELECT COUNT(*) FROM ratings WHERE auction_id='$id'");
	list($count) = db_row($r);

	if (!$count)
		$auctions[] = array($id, $title, $bid, $vid);
}
?>

  <p align="center" class="big"><b>Rate Sellers</b></p>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
<?php
if (!count($auctions)) {
?>
   <tr>
    <td align="center" class="big">No sellers left to rate.</td>
   </tr>
<?php
} else {
?>
   <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
    <td class="header">Auction Title</td>
    <td class="header">Your Bid</td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list(, $val) = each($auctions)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		list($aid, $title, $bid, $vid) = $val;
		$bid = number_format($bid, 2);

		$rr = db_do("SELECT photo_id FROM vehicles WHERE id='$vid'");
		list($photo_id) = db_row($rr);
		db_free($rr);

		$rr = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($rr);
		db_free($rr);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<img src="../uploaded/thumbnails/'.$photo_id.'.jpg" alt="Click here to view photo" border="0">';
		else
			$pic = '';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><a href="rate.php?id=<?php $aid?>">rate seller</a></td>
	<td align="center" valign="middle"><a href="../auction.php?id=<?php $aid?>"><?php $pic?></a></td>
    <td class="normal"><a href="../auction.php?id=<?php echo $aid; ?>"><?php echo $title; ?></a></td>
    <td align="right" class="normal">US $<?php echo $bid; ?></td>
   </tr>
<?php
	}
}
?>
  </table>
<?php include('../footer.php'); ?>
