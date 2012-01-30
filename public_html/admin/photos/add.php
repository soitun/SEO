<?php
include('../../../include/db.php');
db_connect();

extract(defineVars("vid","submit","MAX_FILE_SIZE")); //JJM 9/7/2010
$files = $_FILES['files']; //JJM 9/11/2010 -- necessary to get the files that are uploaded

if (empty($vid) || $vid <= 0) {
	header('Location: ../items/index.php');
	exit;
}

$result = db_do("SELECT dealer_id, short_desc FROM vehicles WHERE id='$vid'");
list($did, $title) = db_row($result);
db_free($result);


$prefix		= $_SERVER['DOCUMENT_ROOT'].'auction/uploaded';  //JJM 9/7/2010
$max_file_size 	= 1024 * 1024;
$thumbnail_size	= '144x144';
$preferred_type	= '.jpg';
$allowed_types	= array("image/bmp", "image/gif", "image/jpeg", "image/pjpeg", "image/png");

if (isset($submit)) {
	$old_mask = umask(007);

	for ($i = 0; $i < count($files); $i++) {
		$filename = $files['name'][$i];

		//JJM 07/07/2010 - added to display errors to users
		if ($files['error'][$i] == '2')
		{
		error_log("Sorry your file named {$files['name'][$i]} exceeded the file limit.  Please resize and upload again.");
			$uploadErrors .= "Sorry your file named {$files['name'][$i]} exceeded the file limit.  Please resize and upload again.<br>";
			continue;
		}

		if ($files['error'][$i] == '4' ||
		    !in_array($files['type'][$i], $allowed_types))
			continue;

		db_do("INSERT INTO photos SET vehicle_id='$vid', " .
	    "modified=NOW(), created=modified");
		$id = db_insert_id();

		list($width, $height) = getImageSize($files['tmp_name'][$i]);

		if ($width > 500 || $height > 400)
			system("convert -geometry 500x400 " . $files['tmp_name'][$i] . " $prefix/$id.jpg");
		else
			system("convert " . $files['tmp_name'][$i] . " $prefix/$id.jpg");

		$orig_img = imagecreatefromjpeg("../uploaded/$id.jpg");
			$width = imagesx($orig_img);
			$height = imagesy($orig_img);
			$new_height = ($height/$width)*65;
			$new_width = 65;

		if ($new_height > 100)
			$new_height = 100;

		$new_img = imagecreatetruecolor($new_width,$new_height);
		imagecopyresized($new_img,$orig_img,0,0,0,0,$new_width,$new_height,imagesx($orig_img),imagesy($orig_img));

		imagejpeg($new_img, "../uploaded/thumbnails/$id.jpg");
	}

	if(empty($uploadErrors)) //JJM 07/07/2010 - added to display errors to users
	{
		db_disconnect();
		umask($old_mask);

		header("Location: index.php?vidphp $vid");
		exit;
	}
}

$has_bid = 'no';
$status = 'closed';
$r = db_do("SELECT id, status, current_bid, reserve_price FROM auctions WHERE vehicle_idphp $vid ORDER BY created DESC, status DESC LIMIT 1");
if (db_num_rows($r) > 0) {
	list($aid, $status, $current_bid, $reserve_price) = db_row($r);
	if ($status == 'open')
		if ($current_bid > 0)
			$has_bid = 'yes';
}
db_free($r);

$result = db_do("SELECT COUNT(*) FROM photos WHERE vehicle_idphp $vid");
list($num_photos) = db_row($result);

$help_page = "chp6_activate.php";

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br>
  <p align="center" class="big"><b>Manage Photos</b></p>
  <p align="center" class="normal">[ <a href="..">Home</a>
  	| <a href=\"../items/edit.php?idphp $vid\">Edit This Item</a>
	<?php if ($num_photos > 0)
		echo " | <a href=\"index.php?vidphp $vid\">This Item's Images</a>";
	if ($status=='open')
		echo " | <a href=\"../auctions/edit_open.php?idphp $aid\">Edit This Auction</a>";
	elseif ($status=='pending')
		echo " | <a href=\"../auctions/edit.php?idphp $aid\">Edit This Auction</a>";
	?> ]</p>
<p align="center" class="notice">No identifiable company information or advertising is permitted in your photos<br />or listings.  (Ref: Go Dealer To Dealer Membership Agreement, Paragraph 4.4, 4)</p>
  <p align="center" class="header"><?php echo $title; ?></p>
  <p align="center" class="normal"><span id="StatusLine">Select images to upload for this item.</span></p>
  <form action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data" method="POST">
   <input type="hidden" name="vid" value="<?php echo $vid; ?>" />
   <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>">
   <table align="center" border="0" cellpadding="5" cellspacing="0">
    <tr>
     <td class="header">Image #1:</td>
     <td class="header"><input name="files[]" type="file" size="35"></td>
    </tr>
    <tr>
     <td class="header">Image #2:</td>
     <td class="header"><input name="files[]" type="file" size="35"></td>
    </tr>
    <tr>
     <td class="header">Image #3:</td>
     <td class="header"><input name="files[]" type="file" size="35"></td>
    </tr>
    <tr>
     <td class="header">Image #4:</td>
     <td class="header"><input name="files[]" type="file" size="35"></td>
    </tr>
    <tr>
     <td class="header">Image #5:</td>
     <td class="header"><input name="files[]" type="file" size="35"></td>
    </tr>
    <tr>
     <td align="center" colspan="2"><input onClick="DisplayMessage()" type="submit" name="submit" value=" Upload "></td>
    </tr>
   </table>
  </form>
<?php db_disconnect(); ?>
