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
# $srp: godealertodealer.com/htdocs/auction/vehicles/index.php,v 1.21 2003/02/03 03:22:08 steve Exp $
#

include('../../../include/db.php');
db_connect();

extract(defineVars("s","dir","sort","filter","category","Item_Title","Stock_Number",
				   "Year","Make","Model","search","PHP_SELF","QUERY_STRING","did")); //JJM 08/30/2010

if (empty($s))
	$status = 'active';
else
	$status = $s;

if (empty($dir))
	$dir = 'asc';

if($dir == 'asc')
{
  $otherdir = 'desc';
}
else
{
  $otherdir = 'asc';
}

if(!empty($_REQUEST['sort']))
	$SortListBy = $_REQUEST['sort'];
else
	$SortListBy = "id";



if(empty($filter))
{
    $sql = "SELECT COUNT(*) FROM vehicles WHERE status='$status' AND dealer_id='$did'";
}
else
{
    $field = $$category;
    $sql = "SELECT COUNT(*) FROM vehicles WHERE status='$status' AND dealer_id='$did' AND $field LIKE \"%$search%\"";
}

include('../../../include/list.php');

if(empty($filter))
{
	$result = db_do("SELECT id, category_id, short_desc, year, vin, hin, make, model, sell_price, stock_num, status
			FROM vehicles
			WHERE status='$status' AND dealer_id='$did'
			ORDER BY $SortListBy $dir LIMIT $_start, $limit");
}
else
{
    $field = $$category;
	$result = db_do("SELECT id, category_id, short_desc, year, vin, hin, make, model, sell_price, stock_num, status
			FROM vehicles
			WHERE status='$status' AND dealer_id='$did' AND $field LIKE \"%$search%\"
			ORDER BY $SortListBy $dir LIMIT $_start, $limit");
}

$result_dealer_name = db_do("SELECT name FROM dealers WHERE id='$did'");
list($dealer_name) = db_row($result_dealer_name);

$page_title = "Items for $dealer_name";
?>
<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
<?php include('_links_items.php'); ?>
<p align="center" class="big"><b><?php $page_title?></b></p>
<form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
    <input type="hidden" name="filter" value="true" />
	<input type="hidden" name="Item_Title" value="short_desc" />
    <input type="hidden" name="Stock_Number" value="stock_num" />
	<input type="hidden" name="Year" value="year" />
    <input type="hidden" name="Make" value="make" />
    <input type="hidden" name="Model" value="model" />
    <table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Search:</td>
        <td><input type="text" name="search" size="20" maxlength="100" /></td>
        <td><select size="1" name="category"><option>Item_Title</option><option>Stock_Number</option><option>Year</option><option>Make</option><option>Model</option></select></td>
        <td><input type="submit" value="Submit" /></td>
        <td><a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" title="Clear your search filter">Clear results</a></td>
      </tr>
    </table>
  </form>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php

if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No items found.</td>
   </tr>
<?php
} else {
?>
	<tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
	<tr>
		<td class="header"><b>Your Options</b></td>
		<td class="header"><b>Auction Status</b></td>
		<td class="header"><b><a href="?did=<?php $did?>&s=<?php $status?>&sort=category_id&dir=<?php if($sort == 'category_id') { echo $otherdir; } else { echo $dir; } ?>">Category</a></b></td>
		<td class="header"><b><a href="?did=<?php $did?>&s=<?php $status?>&sort=stock_num&dir=<?php if($sort == 'stock_num') { echo $otherdir; } else { echo $dir; } ?>">Stock Number</a></b></td>
		<td class="header" nowrap><b><a href="?did=<?php $did?>&s=<?php $status?>&sort=short_desc&dir=<?php if($sort == 'short_desc') { echo $otherdir; } else { echo $dir; } ?>">Item Title</a></b></td>
		<td class="header"><b><a href="?did=<?php $did?>&s=<?php $status?>&sort=year&dir=<?php if($sort == 'year') { echo $otherdir; } else { echo $dir; } ?>">Year</a></b></td>
		<td class="header"><b><a href="?did=<?php $did?>&s=<?php $status?>&sort=make&dir=<?php if($sort == 'make') { echo $otherdir; } else { echo $dir; } ?>">Make</a></b></td>
		<td class="header"><b><a href="?did=<?php $did?>&s=<?php $status?>&sort=model&dir=<?php if($sort == 'model') { echo $otherdir; } else { echo $dir; } ?>">Model</a></b></td>
		<td class="header"><b>VIN/HIN</a></b></td>
		<td class="header"><b><?php if ($status == 'sold') echo 'Sale Amount'; ?></b></td>
	</tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($vid, $cid, $short_desc, $year, $vin, $hin, $make, $model,
	    $sell_price, $stock_num, $status) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$r = db_do("SELECT status FROM auctions WHERE vehicle_id='$vid' ");
		list($auction_status) = db_row($r);
		db_free($r);

		$r = db_do("SELECT name FROM categories WHERE id='$cid'");
		list($categories_id) = db_row($r);
		db_free($r);

?>
	<tr bgcolor="<?php echo $bgcolor; ?>">
		<td class="normal"><a href="view.php?vid=<?php $vid?>&did=<?php $did?>">view</a></td>
		<td class="normal"><?php tshow($auction_status); ?></td>
		<td class="normal"><?php tshow($categories_id); ?></td>
		<td class="normal"><?php tshow($stock_num); ?></td>
		<td class="normal"><?php tshow($short_desc); ?></td>
		<td class="normal"><?php tshow($year); ?></td>
		<td class="normal"><?php tshow($make); ?></td>
		<td class="normal"><?php tshow($model); ?></td>
		<td class="normal"><?php echo "$vin $hin"; ?></td>
		<td align="right" class="normal"><?php if ($status == 'sold') echo '$' . number_format($sell_price, 2); ?></td>
	</tr>
<?php
	}
}
db_free($result);
db_disconnect();
?>
  </table>
 </body>
</html>
