<?php

if(!empty($cid))
{
	$result = db_do("SELECT name FROM categories WHERE id=$cid");
	list($z) = db_row($result);
}

if(!empty($subcid1))
{
	$result = db_do("SELECT name FROM categories WHERE id=$subcid1");
	list($y) = db_row($result);
}

if(!empty($subcid2))
{
	$result = db_do("SELECT name FROM categories WHERE id=$subcid2");
	list($x) = db_row($result);
}


?>
  </p>

<?php	if (!empty($errors)) { ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
		<td class="error">The following errors occurred:<br /><ul><?php echo $errors; ?></ul></td>
   </tr>
</table>
<?php } ?>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <input type="hidden" name="id" value="<?php echo $id; ?>" />
   <table align="center" border="0" cellspacing="0" cellpadding="2">
	  <tr>
		<td align="right" class="error" valign="top">NOTE:</td>
		<td align="left" class="error">The items marked with an asterisk ( * ) are REQUIRED!</td>
	</tr>

    <tr>
		<td align="right" class="header">Category:</td><td class="normal">
     	<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
     	<input type="hidden" name="subcid1" value="<?php echo $subcid1; ?>" />
     	<input type="hidden" name="subcid2" value="<?php echo $subcid2; ?>" />
			<?php
				if (isset($z)) echo "$z";
			if (isset($y) AND $subcid1 > 1)
			{
				echo " : $y ";
				if (isset ($x) AND $subcid2 > 1)
				echo " : $x";
			}?>
		</td>
    </tr>

	<tr>
		<td align="right" class="header"><font color="red"> * </font>Auction Title:</td>
		<td class="normal"><i>This value will also be used for any Auction Title. 55 characters allowed here.</i><br />
			<input type="text" name="short_desc" value="<?php echo $short_desc; ?>" maxlength="55" size="65"></td>
    </tr>

	<tr>
		<td align="right" class="header"><font color="red"> * </font>Year:</td>
		<td class="normal"><select name="year">
			<?php
				if ($year == '')
					echo "<option value='' selected>Choose One</option>";
				else
					echo "<option value=$year selected>$year</option>";
				?>
			<?php
				for ( $count=(date('Y')+2); $count>1899; $count-- )
					echo "<option value=\"$count\">$count</option>";
			?>
         </select></td>
    </tr>

    <tr>
		<td align="right" class="header"><font color="red"> * </font>Manufacturer:</td>
		<td class="normal">
<?php if (($cid == 16 && $subcid1 > 1 && $y != "Other") || $cid == 2567) {
			echo $y; ?>
			<input type="hidden" name="make" value="<?php echo $y; ?>" size="60">
<?php }
elseif (($cid == 15 || $cid == 2481) && $subcid1 > 1 && $y != "Other") {
			echo $y; ?>
			<input type="hidden" name="make" value="<?php echo $y; ?>" size="60">
<?php }
elseif ($cid == 14 && $y == "Personal Watercraft" && $x != "Other") {
			echo $x; ?>
			<input type="hidden" name="make" value="<?php echo $y; ?>" size="60">
<?php }
elseif (($cid == 12 && $subcid1 > 1 && $y != "Other") || ($cid == 2075 && $y != "Other")) {
			echo $y; ?>
			<input type="hidden" name="make" value="<?php echo $y; ?>" size="60">
<?php }
else { ?>
			<input type="text" name="make" value="<?php echo $make; ?>" size="60">
<?php } ?>
		</td>
    </tr>

    <tr>
		<td align="right" class="header"><font color="red"> * </font>Model:</td>
		<td class="normal">
<?php if (($cid == 16 && $subcid2 > 1 && $x != "Other") || $cid == 2567) {
			echo $x; ?>
			<input type="hidden" name="model" value="<?php echo $x; ?>" size="60">
<?php }
elseif ((($cid == 15 || $cid == 2481) && $subcid2 > 1 && $x != "Other") || ($cid == 2075 && $x != "Other")) {
			echo $x; ?>
			<input type="hidden" name="model" value="<?php echo $x; ?>" size="60">
<?php }
else { ?>
			<input type="text" name="model" value="<?php echo $model; ?>" size="60">
<?php } ?>
		</td>
    </tr>

	<tr>
		<td align="right" class="header">Series:</td>
		<td class="normal"><input type="text" name="series" value="<?php echo $series; ?>" size="60"></td>
    </tr>

<?php if ($cid != 14 && $cid != 2567) { ?>
    <tr>
		<td align="right" class="header"><font color="red"> * </font>VIN:</td>
		<td class="normal"><i>Note: If this item does not have a VIN, please enter Does Not Apply</i><br />
			<input type="text" name="vin" value="<?php echo $vin; ?>" size="35">
		</td>
    </tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>HIN:</td>
		<td class="normal"><i>Note: If this item does not have a HIN, please enter Does Not Apply</i><br />
			<input type="text" name="hin" value="<?php echo $hin; ?>" size="35">
		</td>
    </tr>
<?php } ?>

	<tr>
		<td align="right" class="header">Stock Number:</td>
		<td class="normal"><input type="text" name="stock_num" value="<?php echo $stock_num; ?>" size="20"></td>
    </tr>

<?php if ($cid != 14 && $cid != 11 && $cid != 19 && $cid != 2075 && $cid != 2567 && $cid != 12 || $subcid1 == 2820) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Miles:</td>
		<td class="normal"><i>Specify the miles as a whole number without any commas.</i><br />
		<input type="text" name="miles" value="<?php echo $miles; ?>" size="15" /></td>
	</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 11 || $cid == 2567) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Hours:</td>
		<td class="normal"><i>Specify the hours as a whole number without any commas.</i><br>
		<input type="text" name="hours" value="<?php echo $hours; ?>" size="15" />
		&nbsp;&nbsp;<input type="checkbox" name="hours_unknown" value="yes" <?php if ($hours_unknown == 'yes') echo 'checked'; ?>><i>Check if hours are Unknown</i>
		</td>
	</tr>
<?php } ?>

<?php if ($cid == 2075 || $cid == 12) { ?>
<tr>
   <td align="right" class="header"><font color="red"> * </font>Miles:</td>
   <td class="normal"><i>Specify the miles or hours as a whole number without any commas.</i><br>
         <input type="text" name="miles" value="<?php echo $miles; ?>" size="15" />&nbsp;
         <b>Hours:</b>
         <input type="text" name="hours" value="<?php echo $hours; ?>" size="15" />
         &nbsp;&nbsp;<input type="checkbox" name="hours_unknown" value="yes" <?php if ($hours_unknown == 'yes') echo 'checked'; ?>><i>Check if Unknown</i>
         </td>
      </tr>
<?php } ?>

<?php if ($cid == 13) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Body:</td>
		<td class="normal">
			<select name="body">
				<option value='' <?php if ($body == '') echo 'selected'; ?>>Choose One</option>
				<option value='Bus' <?php if ($body == 'Bus') echo 'selected'; ?>>Bus</option>
				<option value='Coupe' <?php if ($body == 'Coupe') echo 'selected'; ?>>Coupe</option>
				<option value='Hatchback' <?php if ($body == 'Hatchback') echo 'selected'; ?>>Hatchback</option>
				<option value='Sedan' <?php if ($body == 'Sedan') echo 'selected'; ?>>Sedan</option>
				<option value='Truck' <?php if ($body == 'Truck') echo 'selected'; ?>>Truck</option>
				<option value='Van' <?php if ($body == 'Van') echo 'selected'; ?>>Van</option>
				<option value='Wagon' <?php if ($body == 'Wagon') echo 'selected'; ?>>Wagon</option>
				<option value='Other' <?php if ($body == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
    </tr>
<?php } ?>
<?php if ($subcid1 == 235 || $subcid1 == 236 || $subcid1 == 237 || $subcid1 == 238 || $subcid1 == 240
          || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) : ?>
   <tr>
		<td align="right" class="header"><font color="red">*</font> Axels:</td>
		<td class="normal">
			<select name="axels">
				<option value='' <?php if ($axels == '') echo 'selected'; ?>>Choose One</option>
				<option value='1' <?php if ($axels == '1') echo 'selected'; ?>>One</option>
				<option value='2' <?php if ($axels == '2') echo 'selected'; ?>>Two</option>
				<option value='3' <?php if ($axels == '3') echo 'selected'; ?>>Three</option>
			</select>
		</td>
    </tr>
<?php endif; ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Hull Material:</td>
		<td class="normal">
			<select name="body">
				<option value='' <?php if ($body == '') echo 'selected'; ?>>Choose One</option>
				<option value='Fiberglass' <?php if ($body == 'Fiberglass') echo 'selected'; ?>>Fiberglass</option>
				<option value='Metal' <?php if ($body == 'Metal') echo 'selected'; ?>>Metal</option>
				<option value='Plastic' <?php if ($body == 'Plastic') echo 'selected'; ?>>Plastic</option>
				<option value='Wood' <?php if ($body == 'Wood') echo 'selected'; ?>>Wood</option>
				<option value='Inflatable' <?php if ($body == 'Inflatable') echo 'selected'; ?>>Inflatable</option>
				<option value='Composite' <?php if ($body == 'Composite') echo 'selected'; ?>>Composite</option>
				<option value='Other' <?php if ($body == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
    </tr>
<?php } ?>
<?php if ($cid == 15) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Body:</td>
		<td class="normal">
			<select name="body">
				<option value='' <?php if ($body == '') echo 'selected'; ?>>Choose One</option>
				<option value='Off Road' <?php if ($body == 'Off Road') echo 'selected'; ?>>Off Road</option>
				<option value='Street' <?php if ($body == 'Street') echo 'selected'; ?>>Street</option>
				<option value='Enduro' <?php if ($body == 'Enduro') echo 'selected'; ?>>Enduro</option>
            <option value='Motocross' <?php if ($body == 'Motocross') echo 'selected'; ?>>Motocross</option>
            <option value='Dual Sport' <?php if ($body == 'Dual Sport') echo 'selected'; ?>>Dual Sport</option>
				<option value='Other' <?php if ($body == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
    </tr>
<?php } ?>
<?php if ($cid == 16) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Body:</td>
		<td class="normal">
			<select name="body">
				<option value='' <?php if ($body == '') echo 'selected'; ?>>Choose One</option>
				<option value='Convertible' <?php if ($body == 'Convertible') echo 'selected'; ?>>Convertible</option>
				<option value='Coupe' <?php if ($body == 'Coupe') echo 'selected'; ?>>Coupe</option>
				<option value='Hatchback' <?php if ($body == 'Hatchback') echo 'selected'; ?>>Hatchback</option>
				<option value='Sedan' <?php if ($body == 'Sedan') echo 'selected'; ?>>Sedan</option>
				<option value='Sport Utility' <?php if ($body == 'Sport Utility') echo 'selected'; ?>>Sport Utility</option>
				<option value='Truck' <?php if ($body == 'Truck') echo 'selected'; ?>>Truck</option>
				<option value='Van' <?php if ($body == 'Van') echo 'selected'; ?>>Van</option>
				<option value='Wagon' <?php if ($body == 'Wagon') echo 'selected'; ?>>Wagon</option>
				<option value='Other' <?php if ($body == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
    </tr>
<?php } ?>
<?php if ($cid == 18) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Body:</td>
		<td class="normal">
			<select name="body">
				<option value='' <?php if ($body == '') echo 'selected'; ?>>Choose One</option>
				<option value='Engine' <?php if ($body == 'Engine') echo 'selected'; ?>>Engine</option>
				<option value='Towed' <?php if ($body == 'Towed') echo 'selected'; ?>>Towed</option>
				<option value='Other' <?php if ($body == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
    </tr>
<?php } ?>
<?php if ($cid == 19 && $subcid1 != 2820) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Body:</td>
		<td class="normal">
          <select name="body">
            <option value='' <?php if ($body == '') echo 'selected'; ?>>Choose One</option>
            <option value='Camper' <?php if ($body == 'Camper') echo 'selected'; ?>>Camper</option>
			<option value='Flat' <?php if ($body == 'Flat') echo 'selected'; ?>>Flat</option>
            <option value='Open' <?php if ($body == 'Open') echo 'selected'; ?>>Open</option>
            <option value='Box' <?php if ($body == 'Box') echo 'selected'; ?>>Box</option>
            <option value='Other' <?php if ($body == 'Other') echo 'selected'; ?>>Other</option>
          </select>
	</td>
    </tr>
<?php } ?>
<?php if ($cid == 13 || $cid == 16 || $cid == 17) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Engine:</td>
		<td class="normal">
			<select name="engine">
            <option value="">Choose One</option>
				<option value='4 Cylinders' <?php if ($engine == '4 Cylinders') echo 'selected'; ?>>4 Cylinders</option>
				<option value='1 Cylinders' <?php if ($engine == '1 Cylinders') echo 'selected'; ?>>1 Cylinder</option>
				<option value='2 Cylinders' <?php if ($engine == '2 Cylinders') echo 'selected'; ?>>2 Cylinders</option>
				<option value='3 Cylinders' <?php if ($engine == '3 Cylinders') echo 'selected'; ?>>3 Cylinders</option>
				<option value='5 Cylinders' <?php if ($engine == '5 Cylinders') echo 'selected'; ?>>5 Cylinders</option>
				<option value='6 Cylinders' <?php if ($engine == '6 Cylinders') echo 'selected'; ?>>6 Cylinders</option>
				<option value='8 Cylinders' <?php if ($engine == '8 Cylinders') echo 'selected'; ?>>8 Cylinders</option>
				<option value='10 Cylinders' <?php if ($engine == '10 Cylinders') echo 'selected'; ?>>10 Cylinders</option>
				<option value='12 Cylinders' <?php if ($engine == '12 Cylinders') echo 'selected'; ?>>12 Cylinders</option>
				<option value='Rotary' <?php if ($engine == 'Rotary') echo 'selected'; ?>>Rotary</option>
				<option value='Electric' <?php if ($engine == 'Electric') echo 'selected'; ?>>Electric</option>
				<option value='Other' <?php if ($engine == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
	</tr>
<?php } ?>
<?php if ($cid == 12 || $cid == 15 || $cid == 2075 || $cid == 2481) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Engine:</td>
		<td class="normal">
			<select name="engine">
				<option value='' <?php if ($engine == '') echo 'selected'; ?>>Choose One</option>
				<option value='2 Stroke' <?php if ($engine == '2 Stroke') echo 'selected'; ?>>2 Stroke</option>
				<option value='4 Stroke' <?php if ($engine == '4 Stroke') echo 'selected'; ?>>4 Stroke</option>
				<option value='Other' <?php if ($engine == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
	</tr>
<?php } ?>
<?php if ($cid == 11) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Engine:</td>
		<td class="normal">
			<select name="engine">
				<option value='' <?php if ($engine == '') echo 'selected'; ?>>Choose One</option>
				<option value='Prop' <?php if ($engine == 'Prop') echo 'selected'; ?>>Prop</option>
				<option value='Jet' <?php if ($engine == 'Jet') echo 'selected'; ?>>Jet</option>
				<option value='Glider' <?php if ($engine == 'Glider') echo 'selected'; ?>>Glider</option>
				<option value='Other' <?php if ($engine == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
	</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Engine Type:</td>
		<td class="normal">
			<select name="engine">
				<option value='' <?php if ($engine == '') echo 'selected'; ?>>Choose One</option>
				<option value='Outboard' <?php if ($engine == 'Outboard') echo 'selected'; ?>>Outboard</option>
				<option value='Twin Outboard' <?php if ($engine == 'Twin Outboard') echo 'selected'; ?>>Twin Outboard</option>
				<option value='Inboard' <?php if ($engine == 'Inboard') echo 'selected'; ?>>Inboard</option>
				<option value='In-Out' <?php if ($engine == 'In-Out') echo 'selected'; ?>>In-Out</option>
				<option value='Twin In-Out' <?php if ($engine == 'Twin In-Out') echo 'selected'; ?>>Twin In-Out</option>
				<option value='Jet' <?php if ($engine == 'Jet') echo 'selected'; ?>>Jet</option>
				<option value='Sail' <?php if ($engine == 'Sail') echo 'selected'; ?>>Sail</option>
				<option value='V-Drive' <?php if ($engine == 'V-Drive') echo 'selected'; ?>>V-Drive</option>
				<option value='Manual' <?php if ($engine == 'Manual') echo 'selected'; ?>>Manual</option>
				<option value='Other' <?php if ($engine == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
	</tr>
<?php } ?>
<?php if ($cid != 19 || $subcid1 == 2820) { ?>
	<tr>
		<td align="right" class="header">Engine Size:</td>
		<td>
			<input type="text" name="engine_size" value="<?php echo $engine_size; ?>" /></td>
	</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Engine Make:</td>
		<td class="normal">
			<select name="engine_make">
				<option value='' <?php if ($engine_make == '') echo 'selected'; ?>>Choose One</option>
				<option value='Caterpillar' <?php if ($engine_make == 'Caterpillar') echo 'selected'; ?>>Caterpillar</option>
				<option value='Evinrude' <?php if ($engine_make == 'Evinrude') echo 'selected'; ?>>Evinrude</option>
				<option value='Force' <?php if ($engine_make == 'Force') echo 'selected'; ?>>Force</option>
				<option value='Honda' <?php if ($engine_make == 'Honda') echo 'selected'; ?>>Honda</option>
				<option value='Johnson' <?php if ($engine_make == 'Johnson') echo 'selected'; ?>>Johnson</option>
				<option value='Mariner' <?php if ($engine_make == 'Mariner') echo 'selected'; ?>>Mariner</option>
				<option value='MerCruiser' <?php if ($engine_make == 'MerCruiser') echo 'selected'; ?>>MerCruiser</option>
				<option value='Mercury' <?php if ($engine_make == 'Mercury') echo 'selected'; ?>>Mercury</option>
				<option value='Motor Guide' <?php if ($engine_make == 'Motor Guide') echo 'selected'; ?>>Motor Guide</option>
				<option value='Polaris' <?php if ($engine_make == 'Polaris') echo 'selected'; ?>>Polaris</option>
				<option value='Suzuki' <?php if ($engine_make == 'Suzuki') echo 'selected'; ?>>Suzuki</option>
				<option value='Volvo Penta' <?php if ($engine_make == 'Volvo Penta') echo 'selected'; ?>>Volvo Penta</option>
				<option value='Yamaha' <?php if ($engine_make == 'Yamaha') echo 'selected'; ?>>Yamaha</option>
				<option value='Other' <?php if ($engine_make == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
	</tr>
<?php } ?>

<?php if ($cid != 19 || $subcid1 == 2820) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Fuel Type:</td>
		<td>
			<select name="fuel_type">
				<option value='' <?php if ($fuel_type == '') echo 'selected'; ?>>Choose One</option>
				<option value='Gas' <?php if ($fuel_type == 'Gas') echo 'selected'; ?>>Gas</option>
				<option value='diesel' <?php if ($fuel_type == 'diesel') echo 'selected'; ?>>Diesel</option>
				<option value='Hybrid' <?php if ($fuel_type == 'Hybrid') echo 'selected'; ?>>Hybrid</option>
				<option value='Electric' <?php if ($fuel_type == 'Electric') echo 'selected'; ?>>Electric</option>
				<option value='Natural Gas' <?php if ($fuel_type == 'Natural Gas') echo 'selected'; ?>>Natural Gas</option>
				<option value='Aviation' <?php if ($fuel_type == 'Aviation') echo 'selected'; ?>>Aviation</option>
				<option value='Hydrogen' <?php if ($fuel_type == 'Hydrogen') echo 'selected'; ?>>Hydrogen</option>
				<option value='Wind' <?php if ($fuel_type == 'Wind') echo 'selected'; ?>>Wind</option>
				<option value='Other' <?php if ($fuel_type == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
	</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567 || $subcid1 == 2820) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Drive Train:</td>
		<td>
			<select name="drive_train">
				<option value='' <?php if ($drive_train == '') echo 'selected'; ?>>Choose One</option>
				<option value='Jet' <?php if ($drive_train == 'Jet') echo 'selected'; ?>>Jet</option>
				<option value='Prop' <?php if ($drive_train == 'Prop') echo 'selected'; ?>>Prop</option>
				<option value='Sail' <?php if ($drive_train == 'Sail') echo 'selected'; ?>>Sail</option>
				<option value='Other' <?php if ($drive_train == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
	</tr>
<?php } ?>
<?php if ($cid == 13 || $cid == 16 || $cid == 17 || $cid == 18) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Drive Train:</td>
		<td>
			<select name="drive_train">
				<option value='' <?php if ($drive_train == '') echo 'selected'; ?>>Choose One</option>
				<option value='Front WD' <?php if ($drive_train == 'Front WD') echo 'selected'; ?>>Front WD</option>
				<option value='Rear WD' <?php if ($drive_train == 'Rear WD') echo 'selected'; ?>>Rear WD</option>
				<option value='4WD' <?php if ($drive_train == '4WD') echo 'selected'; ?>>4WD</option>
				<option value='All WD' <?php if ($drive_train == 'All WD') echo 'selected'; ?>>All WD</option>
				<option value='Other' <?php if ($drive_train == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
	</tr>
<?php } ?>
<?php if ($cid == 15 || $cid == 2481) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Drive Train:</td>
		<td>
			<select name="drive_train">
				<option value='' <?php if ($drive_train == '') echo 'selected'; ?>>Choose One</option>
				<option value='Shaft' <?php if ($drive_train == 'Shaft') echo 'selected'; ?>>Shaft</option>
				<option value='Belt' <?php if ($drive_train == 'Belt') echo 'selected'; ?>>Belt</option>
				<option value='Chain' <?php if ($drive_train == 'Chain') echo 'selected'; ?>>Chain</option>
				<option value='Other' <?php if ($drive_train == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
	</tr>
<?php } ?>
<?php if ($cid != 14 && $cid != 11 && $cid != 19 && $cid != 2567 || $subcid1 == 2820) { ?>
	<tr>
     <td align="right" class="header"><font color="red"> * </font>Transmission:</td>
		<td>
			<select name="transmission">
				<option value='' <?php if ($transmission == '') echo 'selected'; ?>>Choose One</option>
				<option value='Automatic' <?php if ($transmission == 'Automatic') echo 'selected'; ?>>Automatic</option>
				<option value='Manual' <?php if ($transmission == 'Manual') echo 'selected'; ?>>Manual</option>
				<option value='Semi-Automatic' <?php if ($transmission == 'Semi-Automatic') echo 'selected'; ?>>Semi-Automatic</option>
				<option value='Other' <?php if ($transmission == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
    </tr>
<?php } ?>

<?php if ($cid == 14 || $cid == 11 || $cid == 2567) { ?>
	<tr>
		<td align="right" class="header">Horsepower:</td>
		<td>
			<input type="text" name="horsepower" value="<?php echo $horsepower; ?>" size="15" /><i> (enter 0 if not applicable)</i></td>
	</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Use:</td>
		<td>
			<select name="boat_use">
				<option value='' <?php if ($boat_use == '') echo 'selected'; ?>>Choose One</option>
				<option value='Fresh Water' <?php if ($boat_use == 'Fresh Water') echo 'selected'; ?>>Fresh Water</option>
				<option value='Salt Water' <?php if ($boat_use == 'Salt Water') echo 'selected'; ?>>Salt Water</option>
				<option value='Both Fresh-Salt Water' <?php if ($boat_use == 'Both Fresh-Salt Water') echo 'selected'; ?>>Both Fresh-Salt Water</option>
			</select>
		</td>
	</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Boat Length:</td>
		<td class="normal">
			<input type="text" name="length" value="<?php echo $length; ?>" /><i> in ft</i></td>
		</td>
	</tr>
<?php } ?>

<?php if ($subcid1 == 235 || $subcid1 == 236 || $subcid1 == 237 || $subcid1 == 238 || $subcid1 == 240
          || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) : ?>
   <tr>
		<td align="right" class="header"><font color="red"> * </font>Length:</td>
		<td class="normal">
			<input type="text" name="length" value="<?php echo $length; ?>" /><i> in ft</i></td>
		</td>
	</tr>

   <tr>
		<td align="right" class="header">Max Load:</td>
		<td class="normal">
			<input type="text" name="maxload" value="<?php echo $maxload; ?>" /><i>Numbers only</i></td>
		</td>
	</tr>

<?php endif; ?>

<?php if ($cid == 14 || $cid == 11 || $cid == 2567) { ?>
	<tr>
		<td align="right" class="header">Max Seating Capacity:</td>
		<td>
			<input type="text" name="seating" value="<?php echo $seating; ?>" /></td>
	</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 14 && $cid != 2567 || $subcid1 == 2820) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Seat Surface:</td>
		<td>
			<select name="seats">
				<option value='' <?php if ($seats == '') echo 'selected'; ?>>Choose One</option>
				<option value='Leather' <?php if ($seats == 'Leather') echo 'selected'; ?>>Leather</option>
				<option value='Cloth' <?php if ($seats == 'Cloth') echo 'selected'; ?>>Cloth</option>
				<option value='Vinyl' <?php if ($seats == 'Vinyl') echo 'selected'; ?>>Vinyl</option>
				<option value='Other' <?php if ($seats == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
	</tr>
<?php } ?>
<?php if (($cid != 12 && $cid != 15 && $cid != 19 && $cid != 2075 && $cid != 2481 && $cid != 2567) ||
         ($subcid1 == 239 || $subcid1 == 234 || $subcid1 == 2820)) { ?>
	<tr>
		<td align="right" class="header">Interior Color:</td>
		<td class="normal">
          <select name="interior_color">
            <option value='' <?php if ($interior_color == '') echo 'selected'; ?>>Choose
            One</option>
            <option value='Beige' <?php if ($interior_color == 'Beige') echo 'selected'; ?>>Beige</option>
            <option value='Black' <?php if ($interior_color == 'Black') echo 'selected'; ?>>Black</option>
            <option value='Blue' <?php if ($interior_color == 'Blue') echo 'selected'; ?>>Blue</option>
            <option value='Brown' <?php if ($interior_color == 'Brown') echo 'selected'; ?>>Brown</option>
            <option value='Burgundy' <?php if ($interior_color == 'Burgundy') echo 'selected'; ?>>Burgundy</option>
            <option value='Champagne' <?php if ($interior_color == 'Champagne') echo 'selected'; ?>>Champagne</option>
            <option value='Charcoal' <?php if ($interior_color == 'Charcoal') echo 'selected'; ?>>Charcoal</option>
            <option value='Cream' <?php if ($interior_color == 'Cream') echo 'selected'; ?>>Cream</option>
            <option value='Dark Green' <?php if ($interior_color == 'Dark Green') echo 'selected'; ?>>Dark
            Green</option>
            <option value='Gold' <?php if ($interior_color == 'Gold') echo 'selected'; ?>>Gold</option>
            <option value='Green' <?php if ($interior_color == 'Green') echo 'selected'; ?>>Green</option>
            <option value='Grey' <?php if ($interior_color == 'Grey') echo 'selected'; ?>>Grey</option>
            <option value='Light Green' <?php if ($interior_color == 'Light Green') echo 'selected'; ?>>Light
            Green</option>
			<option value='Maroon' <?php if ($interior_color == 'Maroon') echo 'selected'; ?>>Maroon</option>
            <option value='Mult-color' <?php if ($interior_color == 'Mult-color') echo 'selected'; ?>>Mult-color</option>
            <option value='Offwhite' <?php if ($interior_color == 'Offwhite') echo 'selected'; ?>>Offwhite</option>
            <option value='Orange' <?php if ($interior_color == 'Orange') echo 'selected'; ?>>Orange</option>
            <option value='Other' <?php if ($interior_color == 'Other') echo 'selected'; ?>>Other</option>
            <option value='Pink' <?php if ($interior_color == 'Pink') echo 'selected'; ?>>Pink</option>
            <option value='Purple' <?php if ($interior_color == 'Purple') echo 'selected'; ?>>Purple</option>
            <option value='Red' <?php if ($interior_color == 'Red') echo 'selected'; ?>>Red</option>
            <option value='Silver' <?php if ($interior_color == 'Silver') echo 'selected'; ?>>Silver</option>
            <option value='Tan' <?php if ($interior_color == 'Tan') echo 'selected'; ?>>Tan</option>
            <option value='Turquiose' <?php if ($interior_color == 'Turquiose') echo 'selected'; ?>>Turquiose</option>
            <option value='Unavailable' <?php if ($interior_color == 'Unavailable') echo 'Unavailable'; ?>>Blue</option>
            <option value='White' <?php if ($interior_color == 'White') echo 'selected'; ?>>White</option>
            <option value='Yellow' <?php if ($interior_color == 'Yellow') echo 'selected'; ?>>Yellow</option>
            <option value='None' <?php if ($interior_color == 'None') echo 'selected'; ?>>None</option>
          </select>
</td>
    </tr>
<?php } ?>
	<tr>
     <td align="right" class="header"><font color="red"> * </font>Exterior Color:</td>
		<td class="normal">
			<select name="exterior_color">
				<option value='' <?php if ($exterior_color == '') echo 'selected'; ?>>Choose One</option>
				<option value='Beige' <?php if ($exterior_color == 'Beige') echo 'selected'; ?>>Beige</option>
				<option value='Black' <?php if ($exterior_color == 'Black') echo 'selected'; ?>>Black</option>
				<option value='Blue' <?php if ($exterior_color == 'Blue') echo 'selected'; ?>>Blue</option>
				<option value='Brown' <?php if ($exterior_color == 'Brown') echo 'selected'; ?>>Brown</option>
				<option value='Burgundy' <?php if ($exterior_color == 'Burgundy') echo 'selected'; ?>>Burgundy</option>
				<option value='Champagne' <?php if ($exterior_color == 'Champagne') echo 'selected'; ?>>Champagne</option>
				<option value='Charcoal' <?php if ($exterior_color == 'Charcoal') echo 'selected'; ?>>Charcoal</option>
				<option value='Cream' <?php if ($exterior_color == 'Cream') echo 'selected'; ?>>Cream</option>
				<option value='Dark Green' <?php if ($exterior_color == 'Dark Green') echo 'selected'; ?>>Dark Green</option>
				<option value='Gold' <?php if ($exterior_color == 'Gold') echo 'selected'; ?>>Gold</option>
				<option value='Green' <?php if ($exterior_color == 'Green') echo 'selected'; ?>>Green</option>
				<option value='Grey' <?php if ($exterior_color == 'Grey') echo 'selected'; ?>>Grey</option>
				<option value='Light Green' <?php if ($exterior_color == 'Light Green') echo 'selected'; ?>>Light Green</option>
				<option value='Maroon' <?php if ($exterior_color == 'Maroon') echo 'selected'; ?>>Maroon</option>
				<option value='Mult-color' <?php if ($exterior_color == 'Mult-color') echo 'selected'; ?>>Mult-color</option>
				<option value='Offwhite' <?php if ($exterior_color == 'Offwhite') echo 'selected'; ?>>Offwhite</option>
				<option value='Orange' <?php if ($exterior_color == 'Orange') echo 'selected'; ?>>Orange</option>
				<option value='Other' <?php if ($exterior_color == 'Other') echo 'selected'; ?>>Other</option>
				<option value='Pink' <?php if ($exterior_color == 'Pink') echo 'selected'; ?>>Pink</option>
				<option value='Purple' <?php if ($exterior_color == 'Purple') echo 'selected'; ?>>Purple</option>
				<option value='Red' <?php if ($exterior_color == 'Red') echo 'selected'; ?>>Red</option>
				<option value='Silver' <?php if ($exterior_color == 'Silver') echo 'selected'; ?>>Silver</option>
				<option value='Tan' <?php if ($exterior_color == 'Tan') echo 'selected'; ?>>Tan</option>
				<option value='Turquiose' <?php if ($exterior_color == 'Turquiose') echo 'selected'; ?>>Turquiose</option>
				<option value='Unavailable' <?php if ($exterior_color == 'Unavailable') echo 'Unavailable'; ?>>Blue</option>
				<option value='White' <?php if ($exterior_color == 'White') echo 'selected'; ?>>White</option>
				<option value='Yellow' <?php if ($exterior_color == 'Yellow') echo 'selected'; ?>>Yellow</option>
				<option value='None' <?php if ($exterior_color == 'None') echo 'selected'; ?>>None</option>
			</select>
		</td>
    </tr>
<?php if ($cid != 14 && $cid != 2075  && $cid != 2567) { ?>
	<tr>
		<td align="right" class="header">Wheel Size:</td>
		<td class="normal">
			<input type="text" name="wheel_size" value="<?php echo $wheel_size; ?>" /><i> in inches</i>
		</td>
	</tr>
<?php } ?>
<?php if ($subcid1 == 235 || $subcid1 == 236 || $subcid1 == 237 || $subcid1 == 238 || $subcid1 == 240) : ?>
	<tr>
		<td align="right" class="header">Hitch:</td>
		<td class="normal">
			<select name="hitch">
				<option value='' <?php if ($hitch == '') echo 'selected'; ?>>Choose One</option>
				<option value='Class A' <?php if ($hitch == 'Class A') echo 'selected'; ?>>Class A</option>
				<option value='Class B' <?php if ($hitch == 'Class B') echo 'selected'; ?>>Class B</option>
				<option value='Class C' <?php if ($hitch == 'Class C') echo 'selected'; ?>>Class C</option>
			</select>
		</td>
    </tr>
<?php endif; ?>
<?php if ($subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) : ?>
	<tr>
		<td align="right" class="header">Max Sleeping Capacity:</td>
		<td class="normal">
			<input type="text" name="sleep_no" value="<?php echo $sleep_no; ?>" />
		</td>
   </tr>
   <?php endif; ?>
   <?php if($cid != 2075) { ?>
	<tr>
		<td align="right" class="header"><font color="red"> * </font>Title:</td>
		<td class="normal">
			<select name="title">
				<option value='' <?php if ($title == '') echo 'selected'; ?>>Choose One</option>
				<option value='New' <?php if ($title == 'New') echo 'selected'; ?>>New</option>
				<option value='Used' <?php if ($title == 'Used') echo 'selected'; ?>>Used</option>
				<option value='Reconditioned' <?php if ($title == 'Reconditioned') echo 'selected'; ?>>Reconditioned</option>
			</select>
		</td>
    </tr>

	<tr>
		<td align="right" class="header">Title Status:</td>
		<td class="normal">
			<select name="title_status">
				<option value='' <?php if ($title_status == '') echo 'selected'; ?>>Choose One</option>
				<option value='Clear' <?php if ($title_status == 'Clear') echo 'selected'; ?>>Clear</option>
				<option value='Duplicate' <?php if ($title_status == 'Duplicate') echo 'selected'; ?>>Duplicate</option>
				<option value='Flood' <?php if ($title_status == 'Flood') echo 'selected'; ?>>Flood</option>
				<option value='Salvage' <?php if ($title_status == 'Salvage') echo 'selected'; ?>>Salvage</option>
				<option value='Other' <?php if ($title_status == 'Other') echo 'selected'; ?>>Other</option>
			</select>
		</td>
    </tr>
  <?php } else { ?>
   <tr>
      <td align="right" valign="top" class="header">Registered:</td>
      <td class="normal"><input type="checkbox" name="registered" value="Yes" <?php if($warranty == 'Yes') echo 'checked'; ?> />Registered</td>
   </tr>
  <?php } //ENDIF ?>
	<tr>
		<td align="right" valign="top" class="header">Check All that Apply:</td>
		<td class="normal"><input type="checkbox" name="warranty" value="Yes" <?php if ($warranty == 'Yes') echo 'checked'; ?>>Warranty<br>
			<input type="checkbox" name="certified" value="Yes" <?php if ($certified == 'Yes') echo 'checked'; ?>>Certified<br>
         <?php if ($subcid1 != 235 && $subcid1 != 236 && $subcid1 != 237 && $subcid1 != 238 && $subcid1 != 234 && $subcid1 != 239) : ?>
			<input type="checkbox" name="security_system" value="Yes" <?php if ($security_system == 'Yes') echo 'checked'; ?>>Security System<br>
         <?php endif; ?>
			<?php if ($cid != 17 && $cid != 19 || $subcid1 == 2820) { ?>
			<input type="checkbox" name="gps" value="Yes" <?php if ($gps == 'Yes') echo 'checked'; ?>>GPS/Navigation System<br>
			<?php } ?>
			<?php if ($cid != 11 && $cid != 14 && $cid != 19 && $cid != 2567 || $subcid1 == 2820) { ?>
			<input type="checkbox" name="hitch" value="Yes" <?php if ($hitch == 'Yes') echo 'checked'; ?>>Hitch<br>
			<?php } ?>
			<?php if ($cid == 14 || $cid == 2567) { ?>
			<input type="checkbox" name="trailer" value="Yes" <?php if ($trailer == 'Yes') echo 'checked'; ?>>Trailer Included<br>
			<input type="checkbox" name="fish_finder" value="Yes" <?php if ($fish_finder == 'Yes') echo 'checked'; ?>>Fish Finder<br>
			<input type="checkbox" name="depth_finder" value="Yes" <?php if ($depth_finder == 'Yes') echo 'checked'; ?>>Depth Finder<br>
			<?php } ?>
			<?php if ($cid == 19 && ($subcid1 != 235 && $subcid1 != 236 && $subcid1 != 237 && $subcid1 != 238 && $subcid1 != 234 && $subcid1 != 239 && $subcid1 != 2820)) { ?>
			<input type="checkbox" name="slide_out" value="Yes" <?php if ($slide_out == 'Yes') echo 'checked'; ?>>Slide Out<br>
			<?php } ?>
         <?php if ($cid != 15 && $cid != 12 && $cid != 2075 && $cid != 2481 && $cid != 2567 && $subcid1 != 235 && $subcid1 != 236 && $subcid1 != 237 && $subcid1 != 238) { ?>
			<input type="checkbox" name="ac_yn" value="Yes" <?php if ($ac_yn == 'Yes') echo 'checked'; ?>>Air Conditioning<br>
			<?php } ?>
			<?php if ($cid == 15 || $cid == 2481) { ?>
			<input type="checkbox" name="stereo" value="Yes" <?php if ($stereo  == 'Yes') echo 'checked'; ?>>Stereo<br>
			<input type="checkbox" name="bags" value="Yes" <?php if ($bags == 'Yes') echo 'checked'; ?>>Bags
			<?php } ?>
         <?php if($cid == 2075) { ?>
         <input type="checkbox" name="hand_warmers" value="Yes" <?php if($hand_warmers == 'yes') echo 'checked'; ?> />Hand Warmers<br />

         <input type="checkbox" name="studded" value="Yes" <?php if($studded == 'yes') echo 'checked'; ?> />Studded<br />

         <input type="checkbox" name="cover" value="Yes" <?php if($cover == 'yes') echo 'checked'; ?> />Cover Included<br />

         <input type="checkbox" name="am_exhaust" value="Yes" <?php if($am_exhaust == 'yes') echo 'checked'; ?> />Aftermarket Exhaust<br />

         <input type="checkbox" name="sno_trailer" value="Yes" <?php if($sno_trailer == 'yes') echo 'checked'; ?> />Street Trailer<br />
         <?php } ?>

         <?php if ($subcid1 == 235 || $subcid1 == 236 || $subcid1 == 237 || $subcid1 == 238 || $subcid1 == 234 || $subcid1 == 239) : ?>
         <input type="checkbox" name="t_brakes" value="Yes" <?php if($t_brakes == 'yes') echo 'checked'; ?> />Brakes<br />
         <input type="checkbox" name="t_toungejack" value="Yes" <?php if($t_toungejack == 'yes') echo 'checked'; ?> />Tounge Jack<br />

         <?php endif; ?>
		</td>
    </tr>
<?php if ($cid == 14 || $cid == 2567) { ?>
	<tr>
		<td colspan="2" align="left" class="header" valign="top"><hr></td>
	</tr>
	<tr>
		<td align="right" class="normal">If Trailer is Included:&nbsp;</td>
		<td class="normal">&nbsp;</td>
	</tr>
	<tr>
		<td align="right" class="header">Trailer Year:</td>
		<td class="normal"><select name="trailer_year">
			<?php
				if ($trailer_year == '' || !($trailer_year > 0))
					echo "<option value='' selected>Choose One</option>";
				else
					echo "<option value=$trailer_year selected>$trailer_year</option>";
				?>
			<?php
				for ( $count=2010; $count>1899; $count-- )
					echo "<option value=\"$count\">$count</option>";
				echo "<option value=\"\">Remove</option>";
			?>
         </select></td>
    </tr>
	<tr>
		<td align="right" class="header">Trailer Type:</td>
		<td class="normal">
			<select name="trailer_type">
				<option value='' <?php if ($trailer_type == '') echo 'selected'; ?>>Choose One</option>
				<option value='Bunk' <?php if ($trailer_type == 'Bunk') echo 'selected'; ?>>Bunk</option>
				<option value='Roller' <?php if ($trailer_type == 'Roller') echo 'selected'; ?>>Roller</option>
				<option value='Pontoon Bunk' <?php if ($trailer_type == 'Pontoon Bunk') echo 'selected'; ?>>Pontoon Bunk</option>
				<option value='Pontoon Centerlift' <?php if ($trailer_type == 'Pontoon Centerlift') echo 'selected'; ?>>Pontoon Centerlift</option>
				<option value='Composite Bunk' <?php if ($trailer_type == 'Composite Bunk') echo 'selected'; ?>>Composite Bunk</option>
				<option value='Other' <?php if ($trailer_type == 'Other') echo 'selected'; ?>>Other</option>
				<option value=''>None</option>
			</select>
		</td>
    </tr>
	<tr>
		<td align="right" class="header">Trailer Axles:</td>
		<td class="normal"><select name="trailer_axle">
			<?php
				if ($trailer_axle == '')
					echo "<option value='' selected>Choose One</option>";
				else
					echo "<option value=$trailer_axle selected>$trailer_axle</option>";
				?>
			<?php
				for ( $count=1; $count<=3; $count++ )
					echo "<option value=\"$count\">$count</option>";
			?>
         </select></td>
    </tr>
	<tr>
		<td align="right" class="header">Trailer Material:</td>
		<td class="normal">
			<select name="trailer_material">
				<option value='' <?php if ($trailer_material == '') echo 'selected'; ?>>Choose One</option>
				<option value='Aluminum' <?php if ($trailer_material == 'Aluminum') echo 'selected'; ?>>Aluminum</option>
				<option value='Galvanized' <?php if ($trailer_material == 'Galvanized') echo 'selected'; ?>>Galvanized</option>
				<option value='Steel' <?php if ($trailer_material == 'Steel') echo 'selected'; ?>>Steel</option>
				<option value='Color Match Steel' <?php if ($trailer_material == 'Color Match Steel') echo 'selected'; ?>>Color Match Steel</option>
				<option value='Other' <?php if ($trailer_material == 'Other') echo 'selected'; ?>>Other</option>
				<option value='' >None</option>
			</select>
		</td>
    </tr>
	<tr>
		<td align="right" class="header">Trailer Brakes:</td>
		<td class="normal">
			<select name="trailer_brakes">
				<option value='' <?php if ($trailer_brakes == '') echo 'selected'; ?>>Choose One</option>
				<option value='Drum 1 axle' <?php if ($trailer_brakes == 'Drum 1 axle') echo 'selected'; ?>>Drum 1 axle</option>
				<option value='Drum 3 axle' <?php if ($trailer_brakes == 'Drum 3 axle') echo 'selected'; ?>>Drum 3 axle</option>
				<option value='Disc 1 axle' <?php if ($trailer_brakes == 'Disc 1 axle') echo 'selected'; ?>>Disc 1 axle</option>
				<option value='Disc 2 axle' <?php if ($trailer_brakes == 'Disc 2 axle') echo 'selected'; ?>>Disc 2 axle</option>
				<option value='Disc 3 axle' <?php if ($trailer_brakes == 'Disc 3 axle') echo 'selected'; ?>>Disc 3 axle</option>
				<option value='Electric 1 axle' <?php if ($trailer_brakes == 'Electric 1 axle') echo 'selected'; ?>>Electric 1 axle</option>
				<option value='Electric 2 axle' <?php if ($trailer_brakes == 'Electric 2 axle') echo 'selected'; ?>>Electric 2 axle</option>
				<option value='Electric 3 axle' <?php if ($trailer_brakes == 'Electric 3 axle') echo 'selected'; ?>>Electric 3 axle</option>
				<option value='Other' <?php if ($trailer_brakes == 'Other') echo 'selected'; ?>>Other</option>
				<option value=''>None</option>
			</select>
		</td>
    </tr>
	<tr>
		<td align="right" class="header">Spare Tire:&nbsp;</td>
		<td class="normal"><input type="checkbox" name="trailer_spare" value="Yes" <?php if ($trailer_spare == 'Yes') echo 'checked'; ?>>Included</td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="header" valign="top"><hr></td>
	</tr>
<?php } ?>
    <tr>
		<td align="right" class="header" valign="top"><font color="red"> * </font>Description:</td>
		<td class="normal"><i>Give a complete description of this item.  <br>The better the description the more apt you are to sell this item.</i><br /><textarea name="long_desc" rows="10" cols="50" wrap="virtual"><?php echo $long_desc; ?></textarea></td>
    </tr>
	<tr>
		<td colspan="2" align="center" class="header" valign="top"><hr></td>
	</tr>
	<tr>
		<td align="right" class="header" valign="top"></td>
	</tr>

	<tr>
		<td colspan="2" align="center" class="big" valign="top"><b>Wholesale Item Location</b></td>
	</tr>

	<tr>
		<td align="right" class="header"><font color="red"> * </font>City:</td>
		<td class="normal"><input type="text" name="city" value="<?php echo $city; ?>" size="35"></td>
    </tr>

	<tr>
		<td align="right" class="header"><font color="red"> * </font>State:&nbsp;</td>
		<td class="normal">
			<select name="state">
				<?php
				include('../../../include/states.php');

				reset($STATES);
				while (list($key, $value) = each($STATES)) {
					echo "     <option value=\"$key\"";
					if ($state == $key)
					echo " selected";
					echo ">$value</option>\n";
				}
				?>
			</select>
		</td>
    </tr>

    <tr>
		<td align="right" class="header"><font color="red"> * </font>Zip:</td>
		<td class="normal"><input type="text" name="zip" value="<?php echo $zip; ?>" size="35"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="header" valign="top"><hr></td>
	</tr>

<?php

if (!isset($pmt_method))
	$pmt_method = array();
?>
	<tr>
		<td align="right" class="header" valign="top"><font color="red"> * </font>Accepted Payment Methods:</td>
		<td class="normal">
			<input type="checkbox" name="pmt_method[]" value="Cash" <?php if (in_array("Cash", $pmt_method)) echo 'checked'; ?>>Cash
			<input type="checkbox" name="pmt_method[]" value="Money Order" <?php if (in_array("Money Order", $pmt_method)) echo 'checked'; ?>>Money Order<br>
			<input type="checkbox" name="pmt_method[]" value="Cashiers Check" <?php if (in_array("Cashiers Check", $pmt_method)) echo 'checked'; ?>>Cashiers Check
			<input type="checkbox" name="pmt_method[]" value="Personal Check" <?php if (in_array("Personal Check", $pmt_method)) echo 'checked'; ?>>Personal Check
			<input type="checkbox" name="pmt_method[]" value="Corporate Check" <?php if (in_array("Corporate Check", $pmt_method)) echo 'checked'; ?>>Corporate Check<br>
			<input type="checkbox" name="pmt_method[]" value="Visa" <?php if (in_array("Visa", $pmt_method)) echo 'checked'; ?>>Visa
			<input type="checkbox" name="pmt_method[]" value="MasterCard" <?php if (in_array("MasterCard", $pmt_method)) echo 'checked'; ?>>MasterCard
			<input type="checkbox" name="pmt_method[]" value="American Express" <?php if (in_array("American Express", $pmt_method)) echo 'checked'; ?>>American Express
			<input type="checkbox" name="pmt_method[]" value="Discover" <?php if (in_array("Discover", $pmt_method)) echo 'checked'; ?>>Discover<br>
			<input type="checkbox" name="pmt_method[]" value="PayPal" <?php if (in_array("PayPal", $pmt_method)) echo 'checked'; ?>>PayPal
			<input type="checkbox" name="pmt_method[]" value="BidPay" <?php if (in_array("BidPay", $pmt_method)) echo 'checked'; ?>>BidPay
			<input type="checkbox" name="pmt_method[]" value="Wire Transfer" <?php if (in_array("Wire Transfer", $pmt_method)) echo 'checked'; ?>>Wire Transfer
	  </td>
    </tr>
	<tr>
		<td colspan="2" align="center" class="header" valign="top"><hr></td>
	</tr>
	<tr>
		<td align="right" class="header" valign="top">Comments:</td>
		<td class="normal"><i>These comments are for your information and your records only.</i><br /><textarea name="comments" rows="2" cols="50" wrap="virtual"><?php echo $comments; ?></textarea></td>
    </tr>
    <tr>
		<td colspan="2">&nbsp;</td>
	</tr>
    <tr>
		<td colspan="2" align="center" class="normal"><input type="submit" name="submit" value="Continue >>>" /></td>
    </tr>
</table>