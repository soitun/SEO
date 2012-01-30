<?php
$PHP_SELF = $_SERVER['PHP_SELF']; //JJM Added 1/4/2010

include("../../../include/defineVars.php");
extract(defineVars("s","dir","sort","status","stats","filter",
				   "Auction_Title","Auction_Number","Dealership",
				   "search","category","submit","QUERY_STRING"));


if (empty($s))
	$status = 'closed';
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

if ($sort)
	$SortListBy = $sort;
else
	$SortListBy = "dealers.name, charges.created";

if ($status == 'open')
	$page_title = 'Unpaid by the Month';
elseif ($status == 'closed')
	$page_title = 'Paid by the Month';

include('../../../include/db.php');
db_connect();

if(!isset($stats)) {
	if(empty($filter)) {
		$result = db_do("SELECT auctions.title, charges.id, charges.auction_id, charges.dealer_id,
				charges.fee, charges.fee_type, DATE_FORMAT(charges.created, '%Y%m%d'), dealers.name
			FROM auctions, charges, dealers
			WHERE charges.status='$status' AND charges.auction_id=auctions.id AND
				charges.dealer_id=dealers.id AND charges.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)
			ORDER BY $SortListBy $dir");
	} else {
		$field = $$category;
		$result = db_do("SELECT auctions.title, charges.id, charges.auction_id, charges.dealer_id,
				charges.fee, charges.fee_type, DATE_FORMAT(charges.created, '%Y%m%d'), dealers.name
			FROM auctions, charges, dealers
			WHERE charges.status='$status' AND charges.auction_id=auctions.id AND
				charges.dealer_id=dealers.id AND $field LIKE \"%$search%\" AND charges.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)
			ORDER BY $SortListBy $dir");
	}
} else {
	if(empty($filter)) {
		$result = db_do("SELECT auctions.title, charges.id, charges.auction_id, charges.dealer_id,
				charges.fee, charges.fee_type, DATE_FORMAT(charges.created, '%Y%m%d'), dealers.name
			FROM auctions, charges, dealers
			WHERE charges.status='$status' AND charges.auction_id=auctions.id AND
				charges.dealer_id=dealers.id AND charges.created LIKE '$stats%'
			ORDER BY $SortListBy $dir");
	} else {
		$field = $$category;
		$result = db_do("SELECT auctions.title, charges.id, charges.auction_id, charges.dealer_id,
				charges.fee, charges.fee_type, DATE_FORMAT(charges.created, '%Y%m%d'), dealers.name
			FROM auctions, charges, dealers
			WHERE charges.status='$status' AND charges.auction_id=auctions.id AND
				charges.dealer_id=dealers.id AND $field LIKE \"%$search%\" AND charges.created LIKE '$stats%'
			ORDER BY $SortListBy $dir");
	}
}
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css"
  title="site" />

  <script type="text/javascript">

  function hilite_row(rid) {

      row = document.getElementById(rid);
      checkbox = document.getElementById('check_' + rid);

      color = row.bgcolor;

      if(checkbox.checked) {
         row.setAttribute('bgcolor', '#7FFF00');
      } else {
         row.setAttribute('bgcolor', row.getAttribute('old_bg'));
      }

  }

  </script>

 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
<?php include('_links.php'); ?><?php include('_links_months.php'); ?>
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
  <form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
    <input type="hidden" name="filter" value="true" />
    <input type="hidden" name="Auction_Title" value="auctions.title" />
    <input type="hidden" name="Auction_Number" value="charges.auction_id" />
    <input type="hidden" name="Dealership" value="dealers.name" />
    <table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Search:</td>
        <td><input type="text" name="search" size="20" maxlength="100" /></td>
        <td><select size="1" name="category"><option>Auction_Title</option><option>Auction_Number</option><option>Dealership</option></td>
        <td><input type="submit" value="Submit" /></td>
        <td><a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" title="Clear your search filter">Clear results</a></td>
      </tr>
    </table>
  </form>
  <form action="process.php" method="post">
   <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
    <tr>
     <td align="center" class="big">No charges found.</td>
    </tr>
<?php
} else {
?>
    <tr>
     <td class="header"><a href="?s=<?php echo $status; ?>&sort=charges.id<?php if(isset($stats)) { echo "&statsphp $stats"; } ?>&dir=<?php if($sort == 'charges.id') { echo $otherdir; } else { echo $dir; } ?>"><b>Invoice Number</b></a></td>

     <td class="header">Paid</td>

     <td align="right" class="header"><a href="?s=<?php echo $status; ?>&sort=charges.fee<?php if(isset($stats)) { echo "&statsphp $stats"; } ?>&dir=<?php if($sort == 'charges.fee') { echo $otherdir; } else { echo $dir; } ?>"><b>Fee (US $)</b></a></td>
     <td align="left" class="header"><a href="?s=<?php echo $status; ?>&sort=charges.fee_type<?php if(isset($stats)) { echo "&statsphp $stats"; } ?>&dir=<?php if($sort == 'charges.fee_type') { echo $otherdir; } else { echo $dir; } ?>"><b>Fee Type</b></a></td>
	 <td class="header"><a href="?s=<?php echo $status; ?>&sort=auctions.title<?php if(isset($stats)) { echo "&statsphp $stats"; } ?>&dir=<?php if($sort == 'auctions.title') { echo $otherdir; } else { echo $dir; } ?>"><b>Auction Title</b></a></td>
     <td class="header"><a href="?s=<?php echo $status; ?>&sort=charges.auction_id<?php if(isset($stats)) { echo "&statsphp $stats"; } ?>&dir=<?php if($sort == 'charges.auction_id') { echo $otherdir; } else { echo $dir; } ?>"><b>Auction #</b></a></td>
     <td class="header"><a href="?s=<?php echo $status; ?>&sort=dealers.name<?php if(isset($stats)) { echo "&statsphp $stats"; } ?>&dir=<?php if($sort == 'dealers.name') { echo $otherdir; } else { echo $dir; } ?>"><b>Dealership</b></a></td>
    </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($title, $cid, $aid, $did, $fee, $fee_type, $created, $dealer)
	    = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$invoice_num = "$created-$cid";
?>
    <tr bgcolor="<?php echo $bgcolor; ?>" id="<?php echo $cid?>" old_bg="<?php echo $bgcolor; ?>">
     <td class="normal"><?php echo $invoice_num; ?></td>
     <td class="normal"><input type="checkbox" name="pay[]" id="check_<?php echo $cid?>" value="<?php echo $cid; ?>" onclick="javascript: hilite_row(<?php echo $cid?>);" /></td>
     <td align="right" class="normal"><?php tshow($fee); ?></td>
     <td align="left" class="normal"><?php tshow($fee_type); ?></td>
     <td class="normal"><a href="../auctions/auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
     <td align="center" class="normal"><?php echo $aid; ?></td>
     <td class="normal"><a href="../dealers/edit.php?id=<?php echo $did; ?>"><?php tshow($dealer); ?></a></td>
    </tr>
<?php
	}
}

if(mysql_num_rows($result) > 0) {
   ?>
   <tr>
      <td>&nbsp;</td>
      <td><input type="submit" value="Pay" onclick="javascript: return confirm('Are you sure you want to pay the highlighted items?');"/></td>
   </tr>
   <?php
}
db_free($result);
db_disconnect();
?>
      </table>
 </body>
</html>
