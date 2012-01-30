

<?php

$PHP_SELF = $_SERVER['PHP_SELF'];




if(!empty($_REQUEST['bgcolor']))
	$bgcolor = $_REQUEST['bgcolor'];
else
	$bgcolor = "";


if(!empty($_REQUEST['auction_requests_total']))
	$auction_requests_total = $_REQUEST['auction_requests_total'];
else
	$auction_requests_total = "";


if(!empty($_REQUEST['make_offers_total']))
	$make_offers_total = $_REQUEST['make_offers_total'];
else
	$make_offers_total = "";


if(!empty($_REQUEST['bids_total']))
	$bids_total = $_REQUEST['bids_total'];
else
	$bids_total = "";


if(!empty($_REQUEST['abc']))
	$abc = $_REQUEST['abc'];
else
	$abc = "";


if(!empty($_REQUEST['abc']))
	$abc = $_REQUEST['abc'];
else
	$abc = "";


if(!empty($_REQUEST['abc']))
	$abc = $_REQUEST['abc'];
else
	$abc = "";



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

if($_GET['stats'] == date('Y-m')) {
   unset($_GET['stats']);
   unset($stats);
}
$page_title = 'AE Dealer Stats';
$page_link = '../docs/chp4.php#Chp4_DealerStats';

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: https://$_SERVER[SERVER_NAME]');
	exit;
}

if(!isset($stats)) {
   $stats = date('Y-m');
}

$active_items_total=0;
$open_auctions_total=0;
$opened_auctions_total=0;
$pulled_auctions_total=0;
$sold_auctions_total=0;
$bought_auctions_total=0;
$fees_total=0;

$result = db_do("SELECT dealers.id, dealers.dba as name, dealers.rating FROM aes, dealers, users
				WHERE users.username='$username' AND aes.user_id=users.id AND dealers.ae_id = aes.id AND dealers.status='active'");

?>

<html>
	<head>
		<title><?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
	</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?><?php include('_links.php'); ?>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p><br>
<?php include('_links_months.php'); ?>
<font class="huge">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Active Dealers</u></font><br><br>
	<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
		<tr align="center" class="header">
			<td align="left">Dealership Name</td>
			<td>Active Items</td>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?><td>Auction Requests</td> <?php } ?>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?><td>Make Offers</td><?php } ?>
         <td># Bids</td>
	 <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?><td>Open Auctions</td><?php } ?>
			<td>Created Auctions</td>
			<td>Pulled Auctions</td>
			<td>Sold Auctions</td>
			<td>Bought Auctions</td>
			<td align="right">Charges</td>
		</tr>
	<?php while (list($dealer_id, $name, $rating) = db_row($result)) {
         if($stats=='last30') {

				$result_open_auctions = db_do("SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id' AND status='open'");
				list($open_auctions) = db_row($result_open_auctions);

				$result_opened_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE dealer_id='$dealer_id' AND starts >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($opened_auctions) = db_row($result_opened_auctions);

				$result_pulled_auctions = db_do("SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id'
					AND status='pulled' AND modified >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($pulled_auctions) = db_row($result_pulled_auctions);

				$result_sold_auctions = db_do("SELECT COUNT(*) FROM auctions, bids WHERE auctions.dealer_id='$dealer_id'
					AND auctions.chaching=1 AND bids.id=auctions.winning_bid AND bids.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($sold_auctions) = db_row($result_sold_auctions);

				$result_bought_auctions = db_do("SELECT COUNT(*) FROM auctions, bids WHERE bids.dealer_id='$dealer_id'
					AND auctions.chaching=1 AND bids.id=auctions.winning_bid AND bids.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($bought_auctions) = db_row($result_bought_auctions);

            $result_fees = db_do("SELECT SUM(fee) FROM charges WHERE dealer_id='$dealer_id' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($fees) = db_row($result_fees);
				if (!isset($fees)) { $fees = 0.00; }

            $result_bids = db_do("SELECT COUNT(*) FROM bids WHERE dealer_id = '$dealer_id' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
            list($bids) = db_row($result_bids);
			}
			else {
				$result_active_items = db_do("SELECT COUNT(*) FROM vehicles WHERE dealer_id='$dealer_id' AND status='active'");
				list($active_items) = db_row($result_active_items);

				$result_open_auctions = db_do("SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id' AND status='open'");
				list($open_auctions) = db_row($result_open_auctions);

				$result_opened_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE '$stats'=substring(starts,1,7) AND dealer_id='$dealer_id'");
				list($opened_auctions) = db_row($result_opened_auctions);

				$result_pulled_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE '$stats'=substring(modified,1,7) AND dealer_id='$dealer_id' AND status='pulled'");
				list($pulled_auctions) = db_row($result_pulled_auctions);

				$result_sold_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE '$stats'=substring(created,1,7) AND dealer_id='$dealer_id' AND chaching=1");
				list($sold_auctions) = db_row($result_sold_auctions);

				$result_bought_auctions = db_do("SELECT COUNT(*) FROM auctions, bids
					WHERE '$stats'=substring(auctions.modified,1,7) AND bids.dealer_id='$dealer_id' AND auctions.chaching=1 AND bids.id=auctions.winning_bid");
				list($bought_auctions) = db_row($result_bought_auctions);

			 $result_fees = db_do("SELECT SUM(fee) FROM charges WHERE dealer_id='$dealer_id' AND '$stats'=substring(created,1,7)");
				list($fees) = db_row($result_fees);
				if (!isset($fees)) { $fees = 0.00;	}

            $result_bids = db_do("SELECT COUNT(*) FROM bids WHERE dealer_id = '$dealer_id' AND SUBSTRING(created,1,7) = '$stats'");
            list($bids) = db_row($result_bids);
			}

         $result_make_offer = db_do("SELECT COUNT( a.id ) FROM alerts a, users u
         WHERE a.auction_id > 0 AND a.title IS NULL AND a.offer_value > 0 AND a.to_user = u.id AND u.dealer_id ='$dealer_id' AND a.status = 'pending'");
         list($make_offers) = db_row($result_make_offer);

         $result_active_items = db_do("SELECT COUNT(*) FROM vehicles WHERE dealer_id='$dealer_id' AND status='active'");
         list($active_items) = db_row($result_active_items);

         $result_request_auctions = db_do("SELECT COUNT(*) FROM request_auction ra, vehicles v WHERE ra.vehicle_id = v.id AND v.dealer_id='$dealer_id'");
         list($auction_requests) = db_row($result_request_auctions);



			$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF'; ?>
		<tr align="center" bgcolor="<?php $bgcolor?>" class="normal">
			<td align="left"><?php $name?></td>
			<td><?php $active_items?></td>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?> <td><?php $auction_requests?></td> <?php } ?>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?> <td><?php $make_offers?></td> <?php } ?>
         <td><?php $bids?></td>
	 <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?> <td><?php $open_auctions?></td> <?php } ?>
			<td><?php $opened_auctions?></td>
			<td><?php $pulled_auctions?></td>
			<td><?php $sold_auctions?></td>
			<td><?php $bought_auctions?></td>
			<td align="right">$<?=number_format($fees, 2)?></td>
		</tr>
	<?php
         $auction_requests_total += $auction_requests;
         $make_offers_total += $make_offers;
         $bids_total += $bids;
			$active_items_total+php $active_items;
			$open_auctions_total+php $open_auctions;
			$opened_auctions_total+php $opened_auctions;
			$pulled_auctions_total+php $pulled_auctions;
			$sold_auctions_total+php $sold_auctions;
			$bought_auctions_total+php $bought_auctions;
			$fees_total+php $fees;
	} ?>
		<tr><td colspan="9"><hr></td></tr>
		<tr align="center" class="header">
			<td align="center">Totals</td>
			<td><?php $active_items_total?></td>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?><td><?php $auction_requests_total?></td><?php } ?>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?><td><?php $make_offers_total?></td><?php } ?>
         <td><?php $bids_total?></td>
	<?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?> <td><?php $open_auctions_total?></td> <? } ?>
			<td><?php $opened_auctions_total?></td>
			<td><?php $pulled_auctions_total?></td>
			<td><?php $sold_auctions_total?></td>
			<td><?php $bought_auctions_total?></td>
			<td align="right">US $<?=number_format($fees_total, 2)?></td>
		</tr>
      <tr align="center" class="header">
         <td align="left">Dealership Name</td>
         <td>Active Items</td>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?><td>Auction Requests</td> <?php } ?>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?><td>Make Offers</td> <?php } ?>
         <td># Bids</td>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?><td>Open Auctions</td><?php } ?>
         <td>Created Auctions</td>
         <td>Pulled Auctions</td>
         <td>Sold Auctions</td>
         <td>Bought Auctions</td>
         <td align="right">Charges</td>
      </tr>
	</table>

<?

$active_items_total=0;
$auction_requests_total = 0;
$make_offers_total = 0;
$bids_total = 0;
$open_auctions_total=0;
$opened_auctions_total=0;
$pulled_auctions_total=0;
$sold_auctions_total=0;
$bought_auctions_total=0;
$fees_total=0;

$result = db_do("SELECT dealers.id, dealers.name, dealers.rating FROM aes, dealers, users
				WHERE users.username='$username' AND aes.user_id=users.id AND dealers.ae_id = aes.id AND dealers.status='suspended'");

?>

<br><br><font class="huge">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Suspended Dealers</u></font><br><br>
	<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
		<tr align="center" class="header">
			<td align="left">Dealership Name</td>
			<td>Active Items</td>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?><td>Auction Requests</td> <?php } ?>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?><td>Make Offers</td> <?php } ?>
         <td># Bids</td>
	<?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?><td>Open Auctions</td><?php } ?>
			<td>Created Auctions</td>
			<td>Pulled Auctions</td>
			<td>Sold Auctions</td>
			<td>Bought Auctions</td>
			<td align="right">Charges</td>
		</tr>
	<?php while (list($dealer_id, $name, $rating) = db_row($result)) {

			if($stats == 'last30') {
				$result_active_items = db_do("SELECT COUNT(*) FROM vehicles WHERE dealer_id='$dealer_id' AND status='active'");
				list($active_items) = db_row($result_active_items);

				$result_open_auctions = db_do("SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id' AND status='open'");
				list($open_auctions) = db_row($result_open_auctions);

				$result_opened_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE dealer_id='$dealer_id' AND starts >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($opened_auctions) = db_row($result_opened_auctions);

				$result_pulled_auctions = db_do("SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id'
					AND status='pulled' AND modified >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($pulled_auctions) = db_row($result_pulled_auctions);

				$result_sold_auctions = db_do("SELECT COUNT(*) FROM auctions, bids WHERE auctions.dealer_id='$dealer_id'
					AND auctions.chaching=1 AND bids.id=auctions.winning_bid AND bids.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($sold_auctions) = db_row($result_sold_auctions);

				$result_bought_auctions = db_do("SELECT COUNT(*) FROM auctions, bids WHERE bids.dealer_id='$dealer_id'
					AND auctions.chaching=1 AND bids.id=auctions.winning_bid AND bids.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($bought_auctions) = db_row($result_bought_auctions);

            $result_fees = db_do("SELECT SUM(fee) FROM charges WHERE dealer_id='$dealer_id' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($fees) = db_row($result_fees);
				if (!isset($fees)) { $fees = 0.00; }

            $result_bids = db_do("SELECT COUNT(*) FROM bids WHERE dealer_id = '$dealer_id' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
            list($bids) = db_row($result_bids);
			}
			else {
				$result_active_items = db_do("SELECT COUNT(*) FROM vehicles WHERE dealer_id='$dealer_id' AND status='active'");
				list($active_items) = db_row($result_active_items);

				$result_open_auctions = db_do("SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id' AND status='open'");
				list($open_auctions) = db_row($result_open_auctions);

				$result_opened_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE '$stats'=substring(starts,1,7) AND dealer_id='$dealer_id'");
				list($opened_auctions) = db_row($result_opened_auctions);

				$result_pulled_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE '$stats'=substring(modified,1,7) AND dealer_id='$dealer_id' AND status='pulled'");
				list($pulled_auctions) = db_row($result_pulled_auctions);

				$result_sold_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE '$stats'=substring(created,1,7) AND dealer_id='$dealer_id' AND chaching=1");
				list($sold_auctions) = db_row($result_sold_auctions);

				$result_bought_auctions = db_do("SELECT COUNT(*) FROM auctions, bids
					WHERE '$stats'=substring(auctions.modified,1,7) AND bids.dealer_id='$dealer_id' AND auctions.chaching=1 AND bids.id=auctions.winning_bid");
				list($bought_auctions) = db_row($result_bought_auctions);

				$result_fees = db_do("SELECT SUM(fee) FROM charges
					WHERE '$stats'=substring(created,1,7) AND '$stats'=substring(created,1,7) AND dealer_id='$dealer_id' and charges.status='open'");
				list($fees) = db_row($result_fees);
				if (!isset($fees)) { $fees = 0.00;	}

            $result_bids = db_do("SELECT COUNT(*) FROM bids WHERE dealer_id = '$dealer_id' AND SUBSTRING(created,1,7) = '$stats'");
			}

         $result_make_offer = db_do("SELECT COUNT( a.id ) FROM alerts a, users u
         WHERE a.auction_id >0 AND a.title IS NULL AND a.offer_value > 0 AND a.to_user = u.id AND u.dealer_id ='$dealer_id' AND a.status = 'pending'");
         list($make_offers) = db_row($result_make_offer);

         $result_active_items = db_do("SELECT COUNT(*) FROM vehicles WHERE dealer_id='$dealer_id' AND status='active'");
         list($active_items) = db_row($result_active_items);

         $result_request_auctions = db_do("SELECT COUNT(*) FROM request_auction WHERE dealer_id='$dealer_id'");
         list($auction_requests) = db_row($result_request_auctions);

			$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF'; ?>
		<tr align="center" bgcolor="<?php $bgcolor?>" class="normal">
			<td align="left"><?php $name?></td>
			<td><?php $active_items?></td>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?> <td><?php $auction_requests?></td> <?php } ?>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?> <td><?php $make_offers?></td> <?php } ?>
         <td><?php $bids?></td>
	<?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?><td><?php $open_auctions?></td><?php } ?>
			<td><?php $opened_auctions?></td>
			<td><?php $pulled_auctions?></td>
			<td><?php $sold_auctions?></td>
			<td><?php $bought_auctions?></td>
			<td align="right">$<?=number_format($fees, 2)?></td>
		</tr>
	<?php
			$active_items_total+php $active_items;
         $make_offers_total += $make_offers;
         $bids_total += $bids;
         $active_items_total+php $active_items;
			$open_auctions_total+php $open_auctions;
			$opened_auctions_total+php $opened_auctions;
			$pulled_auctions_total+php $pulled_auctions;
			$sold_auctions_total+php $sold_auctions;
			$bought_auctions_total+php $bought_auctions;
			$fees_total+php $fees;
	} ?>
		<tr><td colspan="9"><hr></td></tr>
		<tr align="center" class="header">
			<td align="center">Totals</td>
			<td><?php $active_items_total?></td>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?><td><?php $auction_requests_total?></td><?php } ?>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?><td><?php $make_offers_total?></td><?php } ?>
         <td><?php $bids_total?></td>
	<?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?><td><?php $open_auctions_total?></td><?php } ?>
			<td><?php $opened_auctions_total?></td>
			<td><?php $pulled_auctions_total?></td>
			<td><?php $sold_auctions_total?></td>
			<td><?php $bought_auctions_total?></td>
			<td align="right">US $<?=number_format($fees_total, 2)?></td>
		</tr>
      <tr align="center" class="header">
         <td align="left">Dealership Name</td>
         <td>Active Items</td>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?><td>Auction Requests</td> <?php } ?>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m'))  { ?><td>Make Offers</td> <?php } ?>
         <td># Bids</td>
         <?if(!isset($_GET['stats']) || $_GET['stats'] == date('Y-m')) { ?><td>Open Auctions</td><?php } ?>
         <td>Created Auctions</td>
         <td>Pulled Auctions</td>
         <td>Sold Auctions</td>
         <td>Bought Auctions</td>
         <td align="right">Charges</td>
      </tr>
	</table>

<?php db_disconnect();
include('../footer.php'); ?>
</body>
</html>
