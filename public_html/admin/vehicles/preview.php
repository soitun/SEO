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
# $srp: godealertodealer.com/htdocs/auction/auction.php,v 1.32 2003/07/30 15:27:53 steve Exp $
#


$page_title = "Preview Auction for Vehicle #$id";
$help_page = "chp5_place.php";


if (empty($id) || $id <= 0) {
	header('Location: ../index.php');
	exit;
}

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$result = db_do("SELECT id FROM vehicles WHERE id='$id' AND dealer_id='$dealer_id'");
if (db_num_rows($result) <= 0) {
	 db_free($result);
	header('Location: ../vehicles/index.php');
	exit;
}

$result = db_do("SELECT categories.name, vehicles.dealer_id, vehicles.year, " .
    		"vehicles.vin, vehicles.make, vehicles.model, vehicles.city, " .
    		"vehicles.state, vehicles.zip, vehicles.photo_id, vehicles.condition_report, " .
    		"vehicles.miles, vehicles.stock_num, vehicles.series, vehicles.body, "  .
			"vehicles.engine, vehicles.transmission, vehicles.interior_color, vehicles.exterior_color, "  .
			"vehicles.warranty, vehicles.title, vehicles.title_status, vehicles.certified, " .
			"vehicles.short_desc, vehicles.long_desc, ".
				"vehicles.seats, vehicles.fuel_type, vehicles.drive_train, vehicles.engine_size, vehicles.engine_make," .
				"vehicles.wheel_size, vehicles.payment_method, vehicles.horsepower, vehicles.hin, " .
				"vehicles.hours, vehicles.trailer, vehicles.length, vehicles.seating, vehicles.boat_use, " . 
				"vehicles.engine_mech, vehicles.transmission_mech, vehicles.exhaust, vehicles.tires, " . 
				"vehicles.brakes, vehicles.steering, vehicles.ac, vehicles.prop, " . 
				"vehicles.gauges, vehicles.plumbing, vehicles.hvac, vehicles.a_seats, vehicles.kitchen, vehicles.bathroom, " . 
				"vehicles.furniture, vehicles.hood, vehicles.roof, vehicles.front, vehicles.rear, vehicles.starboard, " .
				"vehicles.port, vehicles.stern, vehicles.bow, vehicles.b_trailer, " .
				"vehicles.front_seats, vehicles.rear_seats, vehicles.carpet,  " . 
				"vehicles.headliner, vehicles.dash, vehicles.electronics, " . 
				"vehicles.paint, vehicles.hood, vehicles.r_f_fender, vehicles.l_f_fender, " . 
				"vehicles.r_door, vehicles.l_door, vehicles.f_fender, vehicles.r_fender, " . 
				"vehicles.r_rear, vehicles.l_rear, vehicles.trunk, vehicles.f_bumper, vehicles.r_bumper, vehicles.s_bumper, " . 
				"vehicles.grille, vehicles.tongue, vehicles.hitch, vehicles.glass, vehicles.frame, vehicles.hull, " . 
				"vehicles.gps, vehicles.fish_finder, vehicles.depth_finder, vehicles.security_system, ". 
				"vehicles.slide_out, vehicles.ac_yn, vehicles.sleep_no FROM " .
    "categories, vehicles WHERE vehicles.id='$id' AND " .
    "vehicles.category_id=categories.id ");

if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}
$vid=$id;
list($category, $did, $year, $vin, $make, $model, $city, $state, $zip,
    $photo, $condition, $miles, $stock_num, $series, $body, $engine, $transmission, $interior_color,
	$exterior_color, $warranty, $title_item, $title_status, $certified, $veh_short_desc, $veh_long_desc,
		$seats, $fuel_type, $drive_train, $engine_size, $engine_make,
		$wheel_size, $payment_method, $horsepower, $hin,
		$hours, $trailer, $length, $seating, $boat_use, 
		$engine_mech, $transmission_mech, $exhuast, $tires, 
		$brakes, $steering, $ac, $prop, 
		$gauges, $plumbing, $hvac, $a_seats, $kitchen, $bathroom, 
		$furniture, $hood, $roof, $front, $rear, $starboard, 
		$port, $stern, $bow, $b_trailer, 
		$front_seats, $rear_seats, $carpet,
		$headliner, $dash, $electronics, 
		$paint, $hood, $r_f_fender, $l_f_fender, 
		$r_door, $l_door, $f_fender, $r_fender, 
		$r_rear, $l_rear, $trunk, $f_bumper, $r_bumper, $s_bumper, 
		$grille, $tongue, $hitch, $glass, $frame, $hull, 
		$gps, $fish_finder, $depth_finder, $security_system, $slide_out, $ac_yn, $sleep_no) = db_row($result);
db_free($result);

$description_report = array("VIN" => $vin, "HIN" => $hin, "Stock Number" => $stock_num, 
		"Boat Length" => $length, "Use" => $boat_use, "Body" => $body, "Exterior Color" => $exterior_color, 
		"Interior Color" => $interior_color, "Seat Surface" => $seats, "Max Seating Capacity" => $seating, "Wheel Size" => $wheel_size, 
		"Miles" => $miles, "Hours" => $hours, "Engine" => $engine, 
		"Engine Size" => $engine_size, "Engine Make" => $engine_make, "Horsepower" => $horsepower, 
		"Drive Train" => $drive_train, "Transmission" => $transmission, "Fuel Type" => $fuel_type, 
		"Title" => $title_item, "Title Status" => $title_status, "Warranty" => $warranty, 
		"Certified" => $certified, "GPS/Navigation System" => $gps, "Security System" => $security_system, 
		"Hitch" => $hitch, "Trailer Included" => $trailer, "Fish Finder" => $fish_finder, 
		"Depth Finder" => $depth_finder, "Slide Out" => $slide_out, "Air Conditioning" => $ac_yn, "Max Sleeping Capacity" => $sleep_no);
				
$condition_report = array("Engine" => $engine_mech, "Transmission" => $transmission_mech, "Exhuast" => $exhuast, 
				"Tires" => $tires, "Brakes" => $brakes, "Steering" => $steering, "Prop" => $prop, 
				"Gauges" => $gauges, "plumbing" => $plumbing, "A/C" => $ac, "HVAC" => $hvac, 
				"Front Seats" => $front_seats, "Rear Seats" => $rear_seats, "Seats" => $a_seats,
				"Headliner" => $headliner, "Carpet" => $carpet,  "Dash" => $dash, 
				"Kitchen" => $kitchen, "Bathroom" => $bathroom, "Furniture" => $furniture, "Electronics" => $electronics, 
				"Paint" => $paint, "Hood" => $hood, "R Front Fender" => $r_f_fender, "L Front Fender" => $l_f_fender, 
				"Roof" => $roof, "Front" => $front, "Rear" => $rear, "Starboard" => $starboard, "Port" => $port,
				"Stern" => $stern, "Bow" => $bow, "Trailer" => $b_trailer, 
				"Right Door" => $r_door, "Left Door" => $l_door, "Front Fender" => $f_fender, "Rear Fender" => $r_fender, 
				"Right Rear" => $r_rear, "Left Rear" => $l_rear, "Trunk" => $trunk, "Front Bumper" => $f_bumper, 
				"Rear Bumper" => $r_bumper, "Side Bumper" => $s_bumper, "Grille" => $grille, "Tongue" => $tongue, 
				"Glass" => $glass, "Frame" => $frame, "Hull" => $hull);

if (empty($photo)) {
	$result = db_do("SELECT id FROM photos WHERE vehicle_id='$vid' " .
	    "ORDER BY id LIMIT 1");

	if (db_num_rows($result) == 1)
		list($photo) = db_row($result);

	db_free($result);
}

if (!empty($photo) && file_exists("../uploaded/$photo.jpg")) {
	$image = "<img src=\"../uploaded/$photo.jpg\">";

	$result = db_do("SELECT caption FROM photos WHERE id='$photo'");
	list($caption) = db_row($result);
	db_free($result);
} else
	$image = '&nbsp;';

include('../header.php');
?>
<p align="center" class="big"><b>View / Place Your Bid</b></p>
<br />
<p align="center" class="big"><b><u><?php echo $category; ?></u></b>
  <br><br>&nbsp;
<table align="center" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td class="big"><b><nobr><?php echo $title; ?></nobr></b></td>
    <td align="right" class="big">Preview Auction for Vehicle #<?php echo $id; ?></td>
  </tr>
  <tr>
    <td class="normal" colspan="2"><nobr><?php echo "$year $make $model"; ?></nobr></td>
 </tr>
 <tr>
  <td class="normal" width="625" colspan="2"><?php echo $image; ?><br />
          <?php echo $caption; ?></td>
  </tr>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="normal" colspan="2" align="center"><b>Item Description </b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php
  		$first_column = TRUE;
		do {
			if (current($description_report)) {
				if ($first_column == TRUE) {
					echo "<tr><td width='50%' class=normal>".key($description_report).": <b>".current($description_report)."</b></td>";
					$first_column = FALSE;
				}
				else {
					echo "<td width='50%' class=normal>".key($description_report).": <b>".current($description_report)."</b></td></tr>";
					$first_column = TRUE;
				}
			}
			next($description_report);
			
			if(key($description_report) == "Miles" || key($description_report) == "Title"){
				if ($first_column = TRUE)
					echo "<tr>";
				echo "<td>&nbsp;</td></tr>";
				$first_column = TRUE;
			}
								
				
		}while (key($description_report));
?>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="normal" colspan="2"><b>Item Description</b></td>
  </tr>
  <tr>
    <td colspan="2" class="normal"><?php echo $veh_long_desc; ?></td>
  </tr>
  <?php if (!empty($add_description)) { ?>
  <td colspan="2">&nbsp;</td>
  <tr>
    <td class="normal" colspan="2"><b>The dealer added the following information on <?php echo $desc_mod ?></b></td>
  </tr>
  <tr>
    <td colspan="2" class="normal"><?php echo $add_description; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td class="small" colspan="2"><hr></td>
  </tr>
  <tr>
    <td class="normal" colspan="2" align="center"><b>Condition Report </b></td>
  </tr>
  <td class="normal" colspan="2"><b>Item Condition</b></td>
  </tr>
  <tr>
    <td colspan="2" class="normal"><?php echo $condition; ?></td>
  </tr>
  <?php if (!empty( $add_condition)) { ?>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="normal" colspan="2"><b>The dealer added the following information on <?php echo $cond_mod ?></b></td>
  </tr>
  <tr>
    <td colspan="2" class="normal"><?php echo $add_condition; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
</table>
<table align="center" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td align="center" bgcolor="#00cc00"><font color="#FFFFFF"><b>&nbsp;Excellent&nbsp;</b></font></td>
			<td align="center" bgcolor="#0000cc"><font color="#FFFFFF"><b>&nbsp;Good&nbsp;</b></font></td>
			<td align="center" bgcolor="#ffff00"><b>&nbsp;Average&nbsp;</b></font></td>
			<td align="center" bgcolor="#cc0000"><font color="#FFFFFF"><b>&nbsp;Poor&nbsp;</b></font></td>
		</tr>
</table><br>
 <table align="center" border="0" cellpadding="4" cellspacing="0">
 <tr>
  <td colspan="2" class="normal"><b><u>Mechanics</u></b></td>
 </tr>
  <?php
  		$any_ratings = FALSE;
  		do {
			$a = explode(',', current($condition_report), 2);
			if(key($condition_report) == "Front Seats") {
				if ($any_ratings == FALSE)
					echo "<td colspan=3 class=normal align=left>&nbsp;&nbsp;No Ratings for this section</td>";
				echo "<tr><td colspan=3 class=normal><b><u>Interior</u></b></td></tr>";
				$any_ratings = FALSE;
			}				
			if(key($condition_report) == "Paint") {
				if ($any_ratings == FALSE)
						echo "<td colspan=3 class=normal align=left>&nbsp;&nbsp;No Ratings for this section</td>";
				echo "<tr><td colspan=3 class=normal><b><u>Exterior</u></b></td></tr>";	
				$any_ratings = FALSE;
			}			
			$p1 = $a[0]; $p2 = $a[1];
			if($p1 != "Not Rated" && $p1 != ""){
				$any_ratings = TRUE;
				echo "<tr><td class=normal><b>&nbsp;&nbsp;".key($condition_report).":</b></td>";
				if ($p1 == "Excellent")
					echo "<td align=center bgcolor=#00cc00><font color=#FFFFFF><b>E</b></font></td><td>";
				if ($p1 == "Good")
					echo "<td align=center bgcolor=#0000cc><font color=#FFFFFF><b>G</b></font></td><td>";
				if ($p1 == "Average")
					echo "<td align=center bgcolor=#ffff00><b>A</b></font></td><td>";
				if ($p1 == "Poor")
					echo "<td align=center bgcolor=#cc0000><font color=#FFFFFF><b>P</b></font></td><td>";
				if ($p2 != "")
					echo $p2;
				echo "</td></tr>";
			}
		}while (next($condition_report));
		if ($any_ratings == FALSE)
			echo "<tr><td colspan=3 class=normal align=left>&nbsp;&nbsp;No Ratings for this section</td></tr>";?>
 </table>
 <table align="center" border="0" cellpadding="4" cellspacing="0">  <?php
$result = db_do("SELECT id, caption FROM photos WHERE vehicle_id='$vid' AND " .
    "id!='$photo'");
if (db_num_rows($result) > 0) {
?>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normal"><b>Additional Pictures</b></td>
  </tr>
  <?php
	while (list($pid, $caption) = db_row($result)) {
?>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="normal" colspan="2"><img src="../uploaded/<?php echo $pid; ?>.jpg"><br />
        <?php echo $caption; ?></td>
  </tr>
  <?php
	}
}

db_free($result);
db_disconnect();
?>
  <tr>
    <td class="small" colspan="2"></td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="normal">
      <?php
if ($views <= 9999)
	$views = sprintf("%04d", $views);

for ($i = 0; $i < strlen($views); $i++)
	echo '<img src="../../digits/' . $views[$i] . '.gif">';
?>
    </td>
  </tr>
</table>
<?php include('../footer.php'); ?>