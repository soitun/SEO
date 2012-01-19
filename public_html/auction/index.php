<?php

$PHP_SELF = $_SERVER['PHP_SELF'];


?>



<?php

include('../../include/session.php');
include('../../include/db.php');
db_connect();
      extract(defineVars("q"));


if (!empty($_GET['showmethemoney']) && $_GET['showmethemoney'] == 'bamf') {
   echo '<pre>';
   print_r($_GET);
   print_r($_POST);
   print_r($_SESSION);
   echo '</pre>';
   die();
}



$no_menu = 1;
$page_title = "Auction Home";
$help_page = "index.php";
include('header.php');
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
 <tr valign="top">
  <td bgcolor="#EEEEEE" width="20%">
   <table border="0" cellpadding="3" cellspacing="0" width="100%">
    <tr>
     <td align="center" bgcolor="#000066"><font color="#FFFFFF" size="-1"><b>My Control Panel</b></font></td>
    </tr>
    <tr>
      <td class="normal"><?php include('_menu.php'); ?></td>
    </tr>

   </table>
  </td>








  <td valign="top" width="60%">
   <table border="0" cellpadding="5" cellspacing="0" width="100%">
    <tr valign="top">
     <td>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tr>
        <td>
         <b>Recently created auctions</b>
		 <br>
         <table border="0" cellpadding="2" cellspacing="0" width="100%">
<?php
$result = db_do("SELECT auctions.id, auctions.title, auctions.vehicle_id, vehicles.photo_id, CONCAT(vehicles.city, ', ', vehicles.state), DATE_FORMAT(auctions.starts, '%b %e, %Y " .
    "%k:%i'), auctions.current_bid, auctions.reserve_price FROM auctions, vehicles WHERE vehicles.id=auctions.vehicle_id AND auctions.status='open' ORDER BY auctions.starts DESC LIMIT 10");

$i = 0;
$bgcolor = "#EEEEEE";

while(list($id, $title, $vid, $photo_id, $location, $starts, $current_bid, $reserve_price) = db_row($result)) {
	$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid' ORDER BY id LIMIT 1");
	list($photoid) = db_row($r);
	db_free($r);

	if ($photo_id == 0)
		$photo_id = $photoid;

	if ($photo_id > 0)
		$pic = '<img src="uploaded/thumbnails/'.$photo_id.'.jpg" alt="" border="0">';
	else
		$pic = '';

	?>
		<tr valign="middle" bgcolor="<?=$bgcolor?>">
			<td width="110" valign="middle"><font size="-1"><?=$starts?></font></td>
			<td align="center" valign="middle"><a href="auction.php?id=<?=$id?>"><?=$pic?></a></td>
			<td valign="middle"><font size="-1"> <a href="auction.php?id=<?=$id?>"><?=$title?></a>
				<?php if ($current_bid >= $reserve_price && $reserve_price > 0) { echo "<br><font color=#009900>(reserve met)</font>"; }
				elseif ($reserve_price <= 0) { echo "<br><font color=#009900>(no reserve)</font>"; }?> </font></td>
			<td align="left" class="normal"><?=$location?></td>
		</tr>
<?php
	$i++;
	$bgcolor = ($bgcolor == "#FFFFFF") ? "#EEEEEE" : "#FFFFFF";
}

db_free($result);

if ($i > 0)
	echo "<tr><td align=\"center\" bgcolor=\"$bgcolor\" colspan=\"6\"><font size=\"-1\"><a href=\"recent.php\">More...</a></font></td></tr>\n";
?>
         </table>
        </td>
       </tr>
      </table>
     </td>
    </tr>
    <tr valign="top">
     <td>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tr>
        <td><hr />
         <b>Highest bids</b><br />
         <table border="0" cellpadding="2" cellspacing="0" width="100%">
<?php
$result = db_do("SELECT auctions.id, MAX(bids.current_bid) as max_bid, auctions.title, auctions.vehicle_id, photo_id,
				CONCAT(vehicles.city, ', ', vehicles.state), auctions.current_bid, auctions.reserve_price
				FROM bids, auctions, vehicles WHERE auctions.status='open' AND auctions.id=bids.auction_id AND auctions.vehicle_id=vehicles.id
				GROUP BY auctions.id ORDER BY max_bid DESC LIMIT 10");

$i = 0;
$bgcolor = "#EEEEEE";
while(list($auction, $max_bid, $title, $vid, $photo_id, $location, $current_bid, $reserve_price) = db_row($result)) {
	$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
	list($photoid) = db_row($r);
	db_free($r);

	if ($photo_id == 0)
		$photo_id = $photoid;

	if ($photo_id > 0)
		$pic = '<img src="uploaded/thumbnails/'.$photo_id.'.jpg" alt="" border="0">';
	else
		$pic = '';

	?>
		<tr valign="middle" bgcolor="<?=$bgcolor?>">
			<td width="100" valign="middle"><font size="-1">$<?=number_format($max_bid, 2)?></font></td>
			<td align="center" valign="middle"><a href="auction.php?id=<?=$auction?>"><?=$pic?></a></td>
			<td valign="middle"><font size="-1"> <a href="auction.php?id=<?=$auction?>"><?=$title?></a>
				<?php if ($current_bid >= $reserve_price && $reserve_price > 0) { echo "<br><font color=#009900>(reserve met)</font>"; }
				elseif ($reserve_price <= 0) { echo "<br><font color=#009900>(no reserve)</font>"; }?> </font></td>
			<td align="left" class="normal"><?=$location?></td>
		</tr>
<?php
        $i++;
	$bgcolor = ($bgcolor == "#FFFFFF") ? "#EEEEEE" : "#FFFFFF";
}

db_free($result);

if ($i > 0)
	echo "<tr><td align=\"center\" bgcolor=\"$bgcolor\" colspan=\"6\"><font size=\"-1\"><a href=\"highest.php\">More...</a></font></td></tr>\n";
?>
         </table>
        </td>
       </tr>
      </table>
     </td>
    </tr>
    <tr valign="top">
     <td>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tr>
        <td><hr />
         <b>Ending soon!</b><br />
         <table border="0" cellpadding="2" cellspacing="0" width="100%">
<?php
$i = 0;
$bgcolor = "#EEEEEE";
$result = db_do("SELECT auctions.ends, auctions.id, auctions.title, auctions.vehicle_id, vehicles.photo_id,
				CONCAT(vehicles.city, ', ', vehicles.state), auctions.current_bid, auctions.reserve_price
				FROM auctions, vehicles WHERE auctions.status='open' AND auctions.vehicle_id=vehicles.id ORDER BY ends LIMIT 10");

while(list($ends, $id, $title, $vid, $photo_id, $location, $current_bid, $reserve_price) = db_row($result)) {
	$timeleft = timeleft($ends);
	if (empty($timeleft) || $timeleft < 0)
		$timeleft = '<font color="#FF0000">closed</font>';

	$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
	list($photoid) = db_row($r);
	db_free($r);

	if ($photo_id == 0)
		$photo_id = $photoid;

	if ($photo_id > 0)
		$pic = '<img src="uploaded/thumbnails/'.$photo_id.'.jpg" alt="" border="0">';
	else
		$pic = '';

	?>
		<tr valign="middle" bgcolor="<?=$bgcolor?>">
			<td width="100" valign="middle"><font size="-1"><?=$timeleft?></font></td>
			<td align="center" valign="middle"><a href="auction.php?id=<?=$id?>"><?=$pic?></a></td>
			<td valign="middle"><font size="-1"> <a href="auction.php?id=<?=$id?>"><?=$title?></a>
				<?php if ($current_bid >= $reserve_price && $reserve_price > 0) { echo "<br><font color=#009900>(reserve met)</font>"; }
				elseif ($reserve_price <= 0) { echo "<br><font color=#009900>(no reserve)</font>"; }?> </font></td>
			<td align="left" class="normal"><?=$location?></td>
		</tr>
<?php
        $i++;
	$bgcolor = ($bgcolor == "#FFFFFF") ? "#EEEEEE" : "#FFFFFF";
}

db_free($result);

if ($i > 0)
	echo "<tr><td align=\"center\" bgcolor=\"$bgcolor\" colspan=\"6\"><font size=\"-1\"><a href=\"ending.php\">More...</a></font></td></tr>\n";
?>
         </table>
        </td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
   <br>
  </td>
  <td width="20%" valign="top" bgcolor="#EEEEEE">
   <table border="0" cellpadding="3" cellspacing="0" width="100%">
    <tr>
     <td align="center" bgcolor="#000066"><font color="#FFFFFF" size="-1"><b>News</b></font></td>
    </tr>
    <tr valign="top" BGCOLOR="#EEEEEE">
     <td>
<?php
$result = db_do("SELECT id, title FROM news WHERE status='active' ORDER BY created LIMIT 10");
while(list($id, $title) = db_row($result))
	echo "      <font size=\"-1\"><a href=\"news.php?id=$id\">$title</a><br />\n";
db_free($result);
?>
      </ul>
     </td>
    </tr>
   </table>
  </td>
 </tr>
</table>

<?php
db_disconnect();
include('footer.php');
?>