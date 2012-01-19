<?php

/**
* $Id: edit.php 532 2006-09-12 16:28:59Z kaneda $
*/

$page_title = 'Update Pending Auction';
$help_page = "chp6_activate.php";

include('../../../include/session.php');

extract(defineVars("z", "q", "no_menu", "id", "in",
"title", "description", "condition", "current_bid", "minimum_bid",
"minimum_bid_orig", "reserve_price", "reserve_price_orig", "buy_now_price",
"buy_now_price_orig", "buy_now_end", "invoice", "pays_transport", "submit",
"starts_hour", "starts_month", "starts_day", "starts_year", "ends_hour",
"ends_month", "ends_day", "ends_year", "bid_increment", "no_reserve",
"id", "vid", "cid", "subcid1", "subcid2"));    //JJM added 1/21/2010 need variables

if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($id) || $id <= 0) {
	header('Location: pending.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$result = db_do("SELECT id FROM auctions WHERE id='$id' AND " .
    "dealer_id='$dealer_id' AND status='pending'");
if (db_num_rows($result) <= 0) {
	header('Location: pending.php');
	exit;
}

db_free($result);

$title         = trim($title);
$description   = trim($description);
$condition	   = trim($condition);
$minimum_bid   = fix_price($minimum_bid);
$reserve_price = fix_price($reserve_price);
$buy_now_price = fix_price($buy_now_price);
$buy_now_end   = fix_price($buy_now_end);
$errors        = '';

if (isset($submit)) {
	if (empty($title))
		$errors .= '<li>You must specify a title.</li>';

	if (empty($description))
		$errors .= '<li>You must describe this auction.</li>';

	if (empty($condition))
		$errors .= '<li>You must specify a condition for this auction.</li>';

	if (!empty($reserve_price) && $reserve_price != 0 && $reserve_price < $minimum_bid)
		$errors .= '<li>Your reserve price must be higher or equal to the minimum bid.</li>';

	if (!empty($buy_now_price) && $buy_now_price != 0 && $buy_now_price < $minimum_bid)
		$errors .= '<li>Your buy now price must be higher of equal to the minimum bid.</li>';

	if ((empty($buy_now_price) || ($buy_now_price <= 1)) && $invoice)
		$errors .= '<li>You must specify a buy now price to disable bidding.</li>';

	#$now  = time();
	#$then = mktime($starts_hour, 0, 0, $starts_month, $starts_day,
	#    $starts_year);

	#if ($now > $ends)
	#	$errors .= '<li>You must choose a future start date.</li>';

	if (empty($errors)) {
		if (($no_reserve != 'yes' && $reserve_price == 0) || ($no_reserve == 'yes' && $reserve_price > 0))
			$errors .= '<li>Please check your Reserve Price.</li>
						<br>If you do not want your auction to have a Reserve, Please check the \'<span class="header">Verify NO RESERVE</span>\' box.
						<br>Otherwise enter a Reserve Price greater than $0.00, and leave the checkbox empty.<br>&nbsp;';
	}

	if (empty($errors)) {
	#	$starts = "$starts_year-$starts_month-$starts_day $starts_hour:00";
	#	$ends   = date('Y-m-d H:i', strtotime("+$duration days $then));

		if (empty($reserve_price))
			$reserve_price = 0;

		$buy_now_end = $buy_now_price - $bid_increment;
		if ($buy_now_end < 0)
			$buy_now_end = 0;

		db_do("UPDATE auctions SET title='$title', description='$description', condition_report='$condition', minimum_bid='$minimum_bid',
		reserve_price='$reserve_price', buy_now_price='$buy_now_price', bid_increment='$bid_increment',
		pays_transport='$pays_transport', buy_now_end='$buy_now_end' WHERE id='$id'");

		$id = db_insert_id();
		db_disconnect();

		header("Location: preview.php?id=$id");
		exit;
	}
} else {
	$result = db_do("SELECT category_id, subcategory_id1, subcategory_id2, title, description, condition_report,
					minimum_bid, reserve_price, buy_now_price, bid_increment, DATE_FORMAT(starts, '%a, %e %M %Y %h:%i %p'), disable_bid,
					DATE_FORMAT(ends, '%a, %e %M %Y %h:%i %p'), duration, pays_transport, buy_now_end
					FROM auctions WHERE id='$id'");
	list($cid, $subcid1, $subcid2, $title, $description, $condition,
		$minimum_bid, $reserve_price, $buy_now_price, $bid_increment, $starts, $invoice,
		$ends, $duration, $pays_transport, $buy_now_end)
	    = db_row($result);

	$buy_now_price_orig = $buy_now_price;
	$reserve_price_orig = $reserve_price;

	db_free($result);

	$starts_year  = substr($starts, 0, 4);
	$starts_month = substr($starts, 4, 2);
	$starts_day   = substr($starts, 6, 2);
	$starts_hour  = substr($starts, 8, 2);
}

$title         = stripslashes($title);
$description   = stripslashes($description);
$condition	   = stripslashes($condition);
$minimum_bid   = stripslashes($minimum_bid);
$reserve_price = RemoveNonNumericChar($reserve_price);
$buy_now_price = RemoveNonNumericChar($buy_now_price);
$buy_now_end   = RemoveNonNumericChar($buy_now_end);


include('../header.php');
?>

  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php
include('_links.php');
include('_form.php');
include('../footer.php');
db_disconnect();
?>