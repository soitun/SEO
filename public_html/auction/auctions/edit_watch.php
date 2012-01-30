<?php

$page_title = 'Set up Email Reminder';
$help_page = "chp6_activate.php";

include('../../../include/session.php');
include('../../../include/defs.php');

extract(defineVars("z", "q", "no_menu", "id","vid","aid","title","photo","cid",
					"subcid1","subcid2","tleft","timeleft","ends","starts_month",
					"starts_day","starts_year","starts_hour","submit","exit"));    //JJM added 6/17/2010 need variables

if (!has_priv('buy', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($id) || $id <= 0) {
	header('Location: ..');
	exit;
}

include('../../../include/db.php');
db_connect();

if (isset($exit)) {
	header('Location: watch.php');
	exit;
}
elseif (isset($submit)) {

	$now  = time();
	$later = strtotime($tleft);
	$then = mktime($starts_hour, 0, 0, $starts_month, $starts_day, $starts_year);

	if ($now >= $then)
		$errors .= '<li>You must choose a future time for your reminder email.</li>';

	if ($then >= $later)
		$errors .= '<li>You must choose time before the end of the auction.</li>';

	if (empty($errors)) {
		db_do("UPDATE watch_list SET reminder=FROM_UNIXTIME('$then') + 0 WHERE idphp $id");

		header("Location: ../auction.php?idphp $aid");
		exit;
	}
} else {

	$result = db_do("SELECT watch_list.user_id, watch_list.auction_id, watch_list.reminder, auctions.id, auctions.vehicle_id,
						auctions.category_id, auctions.subcategory_id1, auctions.subcategory_id2, auctions.title,
						auctions.description, DATE_FORMAT(auctions.ends, '%W %M %e, %Y %l:%i %p'), auctions.ends, auctions.status
						FROM auctions, watch_list WHERE watch_list.id='$id' AND auctions.id=watch_list.auction_id");
	if (db_num_rows($result) <= 0) {
		db_free($result);
		header('Location: ..');
		exit;
	}
	else {
		list($wuser_id, $wid, $reminder, $aid, $vid, $cid, $subcid1, $subcid2, $title, $description, $ends, $tleft, $status) = db_row($result);

		$result = db_do("SELECT id FROM photos WHERE vehicle_id='$vid' ORDER BY id LIMIT 1");
		list($photo) = db_row($result);
	}

	db_free($result);

	if ($userid != $wuser_id) {
		header('Location: ..');
		exit;
	}


	$starts_year	= substr($reminder,  0, 4);
	$starts_month	= substr($reminder,  5, 2);
	$starts_day		= substr($reminder,  8, 2);
	$starts_hour	= substr($reminder,  11, 2);
	$starts_min		= substr($reminder, 14, 2);
	$starts_sec		= substr($reminder, 17, 2);

	$timeleft = timeleft($tleft);
	if (empty($timeleft) || $timeleft < 0)
		$timeleft = "<font color=#FF0000><b>closed</b></font>";
	if ($status == 'pulled')
		$timeleft = "<font color=#000099><b>pulled</b></font>";
}

include('../header.php');
?>

  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links.php'); ?>
<br /><?php
include('_form_watch.php');
include('../footer.php');
db_disconnect();
?>
