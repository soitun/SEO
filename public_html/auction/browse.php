<?php

include('../../include/session.php');
require('../../include/db.php');
db_connect();

$sql = "SELECT COUNT(*) FROM auctions, vehicles WHERE auctions.category_id='$id' AND auctions.status='open' AND auctions.vehicle_id=vehicles.id";

include('../../include/list.php');

if (!empty($id)) {
	if ($id == "all")
		$result = db_do("SELECT id FROM categories WHERE parent_id='0' AND deleted='0'");
	else
		$result = db_do("SELECT id FROM categories WHERE id='$id' AND deleted='0'");
	if (db_num_rows($result) <= 0)
		$id = 0;

	db_free($result);
} else
	$id = 0;

$per_page = 50;
$help_page = "chp5_place.php";

include('header.php');
?>
  <br>
<table width="100%" border="0" cellpadding="2" cellspacing="0">
 <tr bgcolor="#EEEEEE">
  <td class="big"><b>
<?php
$_id = $id;
$nav = '';

while ($_id != all) {
	$result = db_do("SELECT name, parent_id FROM categories WHERE " .
	    "id='$_id' AND deleted='0'");
	if (list($name, $pid) = db_row($result)) {
		if (empty($nav))
		    $nav = "&gt;&nbsp;$name";
		else
		    $nav = "&gt;&nbsp;<a href=\"browse.php?idphp $_id\">" .
		        "$name</a> $nav";
		$_id = $pid;
	} else
		$_id = 0; // make sure we don't loop forever
}

echo "   <a href=\"browse.php\">All Categories</a> $nav\n";
?>
  </b></td>
 </tr>
 <tr>
  <td align="center" class="error"><br>To view and place bids<br><br>Click on items below<br></td>
 </tr>
 <tr>
  <td>
   <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
     <td><font size="-1">
<?php
 ## Where old code displayed the sub_parent
?>
     &nbsp;</font></td>
    </tr>
   </table>
  </td>
 </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
 <tr>
  <td>
   <table align="center" width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr align="center" bgcolor="#000066">
	 <td>&nbsp;</td>
     <td align="left"><font size="-1" color="#FFFFFF">Auction Title</font></td>
     <td><font size="-1" color="#FFFFFF">Year</font></td>
     <td align="left"><font size="-1" color="#FFFFFF">Make</font></td>
     <td align="left"><font size="-1" color="#FFFFFF">Model</font></td>
     <td><font size="-1" color="#FFFFFF">Miles/Hours</font></td>
     <td><font size="-1" color="#FFFFFF">Highest bid</font></td>
     <td><font size="-1" color="#FFFFFF"># of bids</font></td>
     <td><font size="-1" color="#FFFFFF">Ends in</font></td>
    </tr>
<?php
if ($id == "all")
	$result = db_do("SELECT COUNT(*) FROM auctions WHERE status='open'");
else
	$result = db_do("SELECT COUNT(*) FROM auctions WHERE category_id='$id' AND status='open'");
list($total) = db_row($result);
db_free($result);

if ($total > 0) {
	// retrieve records corresponding to passed page number
	if (empty($page) || $page < 1)
		$page = 1;

	if (empty($lines) || $lines < 1)
		$lines = $per_page;

	// determine limits for SQL query
	$left_limit = ($page - 1) * $lines;

	// determine number of pages
	$pages = (int)($total / $lines);
	if (($total % $lines) > 0)
		++$pages;

if ($id == "all"){
	$result = db_do("SELECT auctions.id, auctions.title, " .
	    "auctions.current_bid, auctions.minimum_bid, " .
	    "auctions.reserve_price, auctions.ends, vehicles.make, " .
	    "vehicles.model, vehicles.year, vehicles.miles, " .
	    "vehicles.id FROM auctions, vehicles WHERE auctions.status='open' AND " .
	    "auctions.vehicle_id=vehicles.id ORDER BY auctions.starts DESC " .
	    "LIMIT $_start, $limit" );
}
else {
	$result = db_do("SELECT auctions.id, auctions.title, " .
	    "auctions.current_bid, auctions.minimum_bid, " .
	    "auctions.reserve_price, auctions.ends, vehicles.make, " .
	    "vehicles.model, vehicles.year, vehicles.miles, " .
	    "vehicles.id FROM auctions, vehicles WHERE " .
	    "auctions.category_id='$id' AND auctions.status='open' AND " .
	    "auctions.vehicle_id=vehicles.id ORDER BY auctions.starts DESC " .
	    "LIMIT $_start, $limit" );
}

	$bgColor = "#FFFFFF";
	while (list($aid, $title, $bid, $starting_price, $reserve_price, $ends,
	    $make, $model, $year, $miles, $vid) = db_row($result)) {
		/* current bid of this auction */

		if($bid == 0)
			$bid = $starting_price;
		$current_bid = $bid;
		$bid = number_format($bid, 2);

		/* number of bids for this auction */
		$tmp_res = db_do("SELECT COUNT(*) FROM bids WHERE auction_id='$aid'" );
		list($num_bids) = db_row($tmp_res);

		if ($reserve_price != 0)
			$reserved_price = " <IMG SRC=\"images/r.gif\"> ";
		else
			$reserved_price = "";


		$timeleft = timeleft($ends);
		if (empty($timeleft) || $timeleft < 0)
			$timeleft = '<font color="#FF0000">closed</font>';

		$bgColor = ($bgColor == "#EEEEEE") ? "#FFFFFF" : "#EEEEEE";

		$r = db_do("SELECT photo_id FROM vehicles WHERE id='$vid'");
		list($photo_id) = db_row($r);
		db_free($r);

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<img src="uploaded/thumbnails/'.$photo_id.'.jpg" alt="Click here to view photo" border="0">';
		else
			$pic = '';
?>
    <tr align="center" valign="middle" bgcolor="<?php echo $bgColor; ?>">
	 <td align="center" valign="middle"><a href="auction.php?id=<?php $aid?>"><?php $pic?></a></td>
     <td align="left" class="normal"><a href="auction.php?id=<?php $aid?>"><?php tshow($title); ?></a>
	 	<?php if ($current_bid >= $reserve_price && $reserve_price > 0) { echo "<br><font color=#009900>(reserve met)</font>"; }
				elseif ($reserve_price <= 0) { echo "<br><font color=#009900>(no reserve)</font>"; }?></td>
     <td class="normal"><?php tshow($year); ?></td>
     <td class="normal"><?php tshow($make); ?></td>
     <td class="normal"><?php tshow($model); ?></td>
     <td class="normal"><?php tshow($miles); ?></td>
     <td align="center" class="normal">US $<?php tshow($bid); ?></td>
     <td class="normal"><?php tshow($num_bids); ?></td>
     <td class="normal"><?php tshow($timeleft); ?></td>
    </tr>
<?php
	}

	db_free($result);

} else {
	echo '       <tr align="center"><td colspan="5"><font ' .
	    'size="-1">No active auctions for this category' .
	    "</font></td></tr>\n";
}
?>
	<tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   </table>
  </td>
 </tr>
</table>
<br />

<?php include('footer.php'); ?>
