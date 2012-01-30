<?php
include('../../../include/session.php');
include('../../../include/db.php');
extract(defineVars("sort","delbox", "dir", "filter", "aid", "all", "submit", "filter", "Stock_Number", "Auction_Title", "Username")); //JJM 1/12/2010 JJM added

function deleteFromAuctionList ($id)
{
  db_do("UPDATE auctions SET active='no' WHERE id='$id'" );
  return;
}

if (empty($dir))
	$dir = 'asc';

if ($dir == 'asc')
  $otherdir = 'desc';
else
  $otherdir = 'asc';

if (!empty($sort))
	$SortListBy = $sort;
else
	$SortListBy = "auctions.id, auctions.current_bid";

$page_title = 'Pulled Auctions';
$help_page = "chp6_activate.php";

db_connect();

if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (count($delbox) > 0) {
	$count=count($delbox);
	for ($i=0;$i<$count;$i++)
		 deleteFromAuctionList($delbox[$i]);

	header("Location: pulled.php");
	exit();
}

if(empty($filter))
	$sql = "SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id' AND status='pulled' AND auctions.active='yes'";
else {
    $field = $$category;
	$sql = "SELECT COUNT(*) FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='pulled' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id=auctions.vehicle_id AND auctions.active='yes' AND $field LIKE \"%$search%\""; }


include('../../../include/list.php');
include('../header.php');

if(empty($filter))
	$result = db_do("SELECT auctions.id, auctions.title, DATE_FORMAT(auctions.modified, '%a %c/%e/%y %l:%i%p'),
				categories.name, users.username, vehicles.stock_num, vehicles.photo_id, vehicles.id
			FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='pulled' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id=auctions.vehicle_id AND auctions.active='yes'
			ORDER BY $SortListBy $dir, auctions.id LIMIT $_start, $limit");
else {
    $field = $$category;
	$result = db_do("SELECT auctions.id, auctions.title, DATE_FORMAT(auctions.modified, '%a %c/%e/%y %l:%i%p'),
				categories.name, users.username, vehicles.stock_num, vehicles.photo_id, vehicles.id
			FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='pulled' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id=auctions.vehicle_id AND auctions.active='yes' AND $field LIKE \"%$search%\"
			ORDER BY $SortListBy $dir, auctions.id LIMIT $_start, $limit"); }

?>
<br><p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links.php'); ?><br><br>

<form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
<input type="hidden" name="filter" value="true" />
<input type="hidden" name="Stock_Number" value="vehicles.stock_num" />
<input type="hidden" name="Auction_Title" value="auctions.title" />
<input type="hidden" name="Username" value="users.username" />
<table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td>Search:</td>
		<td>
			<input type="text" name="search" size="20" maxlength="100" />
		</td>
		<td>
			<select size="1" name="category">
				<option>Stock_Number</option>
				<option>Auction_Title</option>
				<option>Username</option></td>
		<td>
			<input type="submit" value="Submit" />
		</td>
		<td>
			<a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" title="Clear your search filter">Clear results</a>
		</td>
	</tr>
</table>
</form>

<table align="center" border="0" cellpadding="5" cellspacing="0" width="95%">
<?php if (db_num_rows($result) <= 0) { ?>
	<tr><td align="center" class="big">No auctions found.</td></tr>
<?php } else { ?>
	<tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
	<tr align="center">
		<td class="header">Options</td>
		<td class="header" align="center">Delete<br><a href="<?php echo $PHP_SELF . '?' . $_SERVER['QUERY_STRING']; ?>&all=true">Check All</a></td>
		<td class="header"><a href="?sort=categories.name&dir=<?php if($sort == 'categories.name') { echo $otherdir; } else { echo $dir; } ?>">Category</a></td>
		<td class="header"><a href="?sort=vehicles.stock_num&dir=<?php if($sort == 'vehicles.stock_num') { echo $otherdir; } else { echo $dir; } ?>">Stock #</a></td>
		<td class="header"><a href="?sort=auctions.title&dir=<?php if($sort == 'auctions.title') { echo $otherdir; } else { echo $dir; } ?>">Auction Title</a></td>
		<td class="header"><a href="?sort=auctions.modified&dir=<?php if($sort == 'auctions.modified') { echo $otherdir; } else { echo $dir; } ?>">Pull Date</a></td>
		<td class="header"><a href="?sort=users.username&dir=<?php if($sort == 'users.username') { echo $otherdir; } else { echo $dir; } ?>">Username</a></td>
	</tr>
	<form action="pulled.php" method="POST">
<?php
	$bgcolor = '#FFFFFF';
	while (list($aid, $title, $pull_date, $category, $un, $stock_num, $photo_id, $vid) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<img src="../uploaded/thumbnails/'.$photo_id.'.jpg" border="0">';
		else
			$pic = '';
?>
   <input type="hidden" name="aid" value="<?php echo $aid; ?>" />
	<tr bgcolor="<?php echo $bgcolor; ?>">
		<td align="center" class="small"><?php tshow($pic); ?><br>
<?php

$result_active = db_do("SELECT auctions.status FROM auctions, vehicles WHERE vehicles.idphp $vid AND vehicles.id=auctions.vehicle_id ");

$current = '';
while (list($status) = db_row($result_active)) {
	if ($status == 'open' || $status == 'pending')
		$current = 'no';
}

if ( $current == 'no')
	echo "currently re-listed";
else { ?>
			<a class="standout" href="../auctions/add.php?vid=<?php echo $vid; ?>">re-list auction</a><?php } ?></td>
		<td class="small" align="center"><input type="checkbox" name="delbox[]" <?php if ($all) echo "checked"; ?> value=<?php $aid?> /></td>
		<td class="small" align="center"><?php tshow($category); ?></td>
		<td class="normal"><?php tshow($stock_num); ?></td>
		<td class="normal"><a href="../auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
		<td class="normal" align="center"><?php tshow($pull_date); ?></td>
		<td class="normal"><?php tshow($un); ?></td>
	</tr>
<?php } ?>
	<tr><td></td><td align="center"><input type="submit" name="submit" value="Delete"></td></tr>
<?php }
db_free($result);
db_disconnect();
?>
	</form>
  </table>
<?php include('../footer.php'); ?>
