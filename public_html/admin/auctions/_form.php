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
# $srp: godealertodealer.com/htdocs/auction/auctions/_form.php,v 1.19 2004/04/19 16:15:09 steve Exp $
#
?>

<?php if (!empty($errors)) { ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td class="error">The following errors occurred:<br /><ul><?php echo $errors; ?></ul></td>
   </tr>
  </table>
<?php }

if(isset($cid))
{
	$result = db_do("SELECT name FROM categories WHERE idphp $cid");
	list($z) = db_row($result);
}

if(isset($subcid1))
{
	$result = db_do("SELECT name FROM categories WHERE idphp $subcid1");
	list($y) = db_row($result);
}

if(isset($subcid2))
{
	$result = db_do("SELECT name FROM categories WHERE idphp $subcid2");
	list($x) = db_row($result);
}
?>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <input type="hidden" name="vid" value="<?php echo $vid; ?>" />
   <input type="hidden" name="id" value="<?php echo $id; ?>" />
   <input type="hidden" name="in" value="<?php echo $in; ?>" />

   <table align="center" border="0" cellspacing="0" cellpadding="2">
    <tr>
		<td align="right" class="header">Category:</td><td class="normal">
     	<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
     	<input type="hidden" name="subcid1" value="<?php echo $subcid1; ?>" />
     	<input type="hidden" name="subcid2" value="<?php echo $subcid2; ?>" />
     	<?php
     		echo "$z";
		if (isset($y) AND $subcid1 > 1)
		{
			echo " : $y ";
			if (isset ($x) AND $subcid2 > 1)
			echo " : $x";
		}
		?>
		</td>
    </tr>
	<tr>
    <tr>
     <td align="right" class="header">Auction Title:</td>
     <td class="normal"><input type="text" name="title" value="<?php echo $title; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header" valign="top">Description:</td>
     <td class="normal"><textarea name="description" rows="10" cols="50" wrap="virtual"><?php echo $description; ?></textarea></td>
    </tr>
	<tr>
     <td align="right" class="header" valign="top">Condition:</td>
     <td class="normal"><textarea name="condition" rows="10" cols="50" wrap="virtual"><?php echo $condition; ?></textarea></td>
    </tr>
    <tr>
     <td align="right" class="header">Bid price starts at:</td>
     <td class="normal"><input type="text" name="minimum_bid" value="<?php echo $minimum_bid; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">Bid Increment:</td>
     <td class="normal">
      <select name="bid_increment">
<?php
$result = db_do("SELECT increment FROM increments ORDER BY increment");
while (list($a) = db_row($result)) {
	$a_show = number_format($a, 2);
?>
       <option value="<?php echo $a; ?>" <?php if ($bid_increment == $a) echo 'selected'; ?>><?php tshow($a_show); ?></option>
<?php
}

db_free($result);
?>
      </select>
     </td>
    </tr>
    <tr>
     <td align="right" class="header">Auction Starts:</td>
     <td class="normal">

	<input type="hidden" name="starts_month" value="<?php echo $starts_month; ?>" />
	<input type="hidden" name="starts_day" value="<?php echo $starts_day; ?>" />
    <input type="hidden" name="starts_year" value="<?php echo $starts_year; ?>" />
    <input type="hidden" name="starts_hour" value="<?php echo $starts_hour; ?>" />
	<input type="hidden" name="ends_month" value="<?php echo $ends_month; ?>" />
	<input type="hidden" name="ends_day" value="<?php echo $ends_day; ?>" />
    <input type="hidden" name="ends_year" value="<?php echo $ends_year; ?>" />
    <input type="hidden" name="ends_hour" value="<?php echo $ends_hour; ?>" />

      <select name="starts_month">
       <option value="01" <?php if ($starts_month == '01') echo 'selected'; ?>>January</option>
       <option value="02" <?php if ($starts_month == '02') echo 'selected'; ?>>February</option>
       <option value="03" <?php if ($starts_month == '03') echo 'selected'; ?>>March</option>
       <option value="04" <?php if ($starts_month == '04') echo 'selected'; ?>>April</option>
       <option value="05" <?php if ($starts_month == '05') echo 'selected'; ?>>May</option>
       <option value="06" <?php if ($starts_month == '06') echo 'selected'; ?>>June</option>
       <option value="07" <?php if ($starts_month == '07') echo 'selected'; ?>>July</option>
       <option value="08" <?php if ($starts_month == '08') echo 'selected'; ?>>August</option>
       <option value="09" <?php if ($starts_month == '09') echo 'selected'; ?>>September</option>
       <option value="10" <?php if ($starts_month == '10') echo 'selected'; ?>>October</option>
       <option value="11" <?php if ($starts_month == '11') echo 'selected'; ?>>November</option>
       <option value="12" <?php if ($starts_month == '12') echo 'selected'; ?>>December</option>
      </select>
      <select name="starts_day">
       <option value="01" <?php if ($starts_day == '01') echo 'selected'; ?>>1</option>
       <option value="02" <?php if ($starts_day == '02') echo 'selected'; ?>>2</option>
       <option value="03" <?php if ($starts_day == '03') echo 'selected'; ?>>3</option>
       <option value="04" <?php if ($starts_day == '04') echo 'selected'; ?>>4</option>
       <option value="05" <?php if ($starts_day == '05') echo 'selected'; ?>>5</option>
       <option value="06" <?php if ($starts_day == '06') echo 'selected'; ?>>6</option>
       <option value="07" <?php if ($starts_day == '07') echo 'selected'; ?>>7</option>
       <option value="08" <?php if ($starts_day == '08') echo 'selected'; ?>>8</option>
       <option value="09" <?php if ($starts_day == '09') echo 'selected'; ?>>9</option>
       <option value="10" <?php if ($starts_day == '10') echo 'selected'; ?>>10</option>
       <option value="11" <?php if ($starts_day == '11') echo 'selected'; ?>>11</option>
       <option value="12" <?php if ($starts_day == '12') echo 'selected'; ?>>12</option>
       <option value="13" <?php if ($starts_day == '13') echo 'selected'; ?>>13</option>
       <option value="14" <?php if ($starts_day == '14') echo 'selected'; ?>>14</option>
       <option value="15" <?php if ($starts_day == '15') echo 'selected'; ?>>15</option>
       <option value="16" <?php if ($starts_day == '16') echo 'selected'; ?>>16</option>
       <option value="17" <?php if ($starts_day == '17') echo 'selected'; ?>>17</option>
       <option value="18" <?php if ($starts_day == '18') echo 'selected'; ?>>18</option>
       <option value="19" <?php if ($starts_day == '19') echo 'selected'; ?>>19</option>
       <option value="20" <?php if ($starts_day == '20') echo 'selected'; ?>>20</option>
       <option value="21" <?php if ($starts_day == '21') echo 'selected'; ?>>21</option>
       <option value="22" <?php if ($starts_day == '22') echo 'selected'; ?>>22</option>
       <option value="23" <?php if ($starts_day == '23') echo 'selected'; ?>>23</option>
       <option value="24" <?php if ($starts_day == '24') echo 'selected'; ?>>24</option>
       <option value="25" <?php if ($starts_day == '25') echo 'selected'; ?>>25</option>
       <option value="26" <?php if ($starts_day == '26') echo 'selected'; ?>>26</option>
       <option value="27" <?php if ($starts_day == '27') echo 'selected'; ?>>27</option>
       <option value="28" <?php if ($starts_day == '28') echo 'selected'; ?>>28</option>
       <option value="29" <?php if ($starts_day == '29') echo 'selected'; ?>>29</option>
       <option value="30" <?php if ($starts_day == '30') echo 'selected'; ?>>30</option>
       <option value="31" <?php if ($starts_day == '31') echo 'selected'; ?>>31</option>
      </select>
      <select name="starts_year">
<?php
$foo = date('Y');
if (!isset($starts_year))
	$starts_year = '2003';
for ($y = $foo - 2; $y <= $foo + 2; $y++) {
?>
       <option value="<?php echo $y; ?>" <?php if ($starts_year == $y) echo 'selected'; ?>><?php echo $y; ?></option>
<?php
}
?>
      </select>
      <select name="starts_hour">
       <option value="0" <?php if ($starts_hour == '00') echo 'selected'; ?>>12:00 AM</option>
       <option value="1" <?php if ($starts_hour == '01') echo 'selected'; ?>>1:00 AM</option>
       <option value="2" <?php if ($starts_hour == '02') echo 'selected'; ?>>2:00 AM</option>
       <option value="3" <?php if ($starts_hour == '03') echo 'selected'; ?>>3:00 AM</option>
       <option value="4" <?php if ($starts_hour == '04') echo 'selected'; ?>>4:00 AM</option>
       <option value="5" <?php if ($starts_hour == '05') echo 'selected'; ?>>5:00 AM</option>
       <option value="6" <?php if ($starts_hour == '06') echo 'selected'; ?>>6:00 AM</option>
       <option value="7" <?php if ($starts_hour == '07') echo 'selected'; ?>>7:00 AM</option>
       <option value="8" <?php if ($starts_hour == '08') echo 'selected'; ?>>8:00 AM</option>
       <option value="9" <?php if ($starts_hour == '09') echo 'selected'; ?>>9:00 AM</option>
       <option value="10" <?php if ($starts_hour == '10') echo 'selected'; ?>>10:00 AM</option>
       <option value="11" <?php if ($starts_hour == '11') echo 'selected'; ?>>11:00 AM</option>
       <option value="12" <?php if ($starts_hour == '12') echo 'selected'; ?>>12:00 PM</option>
       <option value="13" <?php if ($starts_hour == '13') echo 'selected'; ?>>1:00 PM</option>
       <option value="14" <?php if ($starts_hour == '14') echo 'selected'; ?>>2:00 PM</option>
       <option value="15" <?php if ($starts_hour == '15') echo 'selected'; ?>>3:00 PM</option>
       <option value="16" <?php if ($starts_hour == '16') echo 'selected'; ?>>4:00 PM</option>
       <option value="17" <?php if ($starts_hour == '17') echo 'selected'; ?>>5:00 PM</option>
       <option value="18" <?php if ($starts_hour == '18') echo 'selected'; ?>>6:00 PM</option>
       <option value="19" <?php if ($starts_hour == '19') echo 'selected'; ?>>7:00 PM</option>
       <option value="20" <?php if ($starts_hour == '20') echo 'selected'; ?>>8:00 PM</option>
       <option value="21" <?php if ($starts_hour == '21') echo 'selected'; ?>>9:00 PM</option>
       <option value="22" <?php if ($starts_hour == '22') echo 'selected'; ?>>10:00 PM</option>
       <option value="23" <?php if ($starts_hour == '23') echo 'selected'; ?>>11:00 PM</option>
      </select>&nbsp;<?php echo date('T') . ' <i>(GMT' . date('O') . ')</i>'; ?>
     </td>
    </tr>
    <tr>
     <td align="right" class="header">Auction Ends:</td>
     <td class="normal">
      <select name="ends_month">
       <option value="01" <?php if ($ends_month == '01') echo 'selected'; ?>>January</option>
       <option value="02" <?php if ($ends_month == '02') echo 'selected'; ?>>February</option>
       <option value="03" <?php if ($ends_month == '03') echo 'selected'; ?>>March</option>
       <option value="04" <?php if ($ends_month == '04') echo 'selected'; ?>>April</option>
       <option value="05" <?php if ($ends_month == '05') echo 'selected'; ?>>May</option>
       <option value="06" <?php if ($ends_month == '06') echo 'selected'; ?>>June</option>
       <option value="07" <?php if ($ends_month == '07') echo 'selected'; ?>>July</option>
       <option value="08" <?php if ($ends_month == '08') echo 'selected'; ?>>August</option>
       <option value="09" <?php if ($ends_month == '09') echo 'selected'; ?>>September</option>
       <option value="10" <?php if ($ends_month == '10') echo 'selected'; ?>>October</option>
       <option value="11" <?php if ($ends_month == '11') echo 'selected'; ?>>November</option>
       <option value="12" <?php if ($ends_month == '12') echo 'selected'; ?>>December</option>
      </select>
      <select name="ends_day">
       <option value="01" <?php if ($ends_day == '01') echo 'selected'; ?>>1</option>
       <option value="02" <?php if ($ends_day == '02') echo 'selected'; ?>>2</option>
       <option value="03" <?php if ($ends_day == '03') echo 'selected'; ?>>3</option>
       <option value="04" <?php if ($ends_day == '04') echo 'selected'; ?>>4</option>
       <option value="05" <?php if ($ends_day == '05') echo 'selected'; ?>>5</option>
       <option value="06" <?php if ($ends_day == '06') echo 'selected'; ?>>6</option>
       <option value="07" <?php if ($ends_day == '07') echo 'selected'; ?>>7</option>
       <option value="08" <?php if ($ends_day == '08') echo 'selected'; ?>>8</option>
       <option value="09" <?php if ($ends_day == '09') echo 'selected'; ?>>9</option>
       <option value="10" <?php if ($ends_day == '10') echo 'selected'; ?>>10</option>
       <option value="11" <?php if ($ends_day == '11') echo 'selected'; ?>>11</option>
       <option value="12" <?php if ($ends_day == '12') echo 'selected'; ?>>12</option>
       <option value="13" <?php if ($ends_day == '13') echo 'selected'; ?>>13</option>
       <option value="14" <?php if ($ends_day == '14') echo 'selected'; ?>>14</option>
       <option value="15" <?php if ($ends_day == '15') echo 'selected'; ?>>15</option>
       <option value="16" <?php if ($ends_day == '16') echo 'selected'; ?>>16</option>
       <option value="17" <?php if ($ends_day == '17') echo 'selected'; ?>>17</option>
       <option value="18" <?php if ($ends_day == '18') echo 'selected'; ?>>18</option>
       <option value="19" <?php if ($ends_day == '19') echo 'selected'; ?>>19</option>
       <option value="20" <?php if ($ends_day == '20') echo 'selected'; ?>>20</option>
       <option value="21" <?php if ($ends_day == '21') echo 'selected'; ?>>21</option>
       <option value="22" <?php if ($ends_day == '22') echo 'selected'; ?>>22</option>
       <option value="23" <?php if ($ends_day == '23') echo 'selected'; ?>>23</option>
       <option value="24" <?php if ($ends_day == '24') echo 'selected'; ?>>24</option>
       <option value="25" <?php if ($ends_day == '25') echo 'selected'; ?>>25</option>
       <option value="26" <?php if ($ends_day == '26') echo 'selected'; ?>>26</option>
       <option value="27" <?php if ($ends_day == '27') echo 'selected'; ?>>27</option>
       <option value="28" <?php if ($ends_day == '28') echo 'selected'; ?>>28</option>
       <option value="29" <?php if ($ends_day == '29') echo 'selected'; ?>>29</option>
       <option value="30" <?php if ($ends_day == '30') echo 'selected'; ?>>30</option>
       <option value="31" <?php if ($ends_day == '31') echo 'selected'; ?>>31</option>
      </select>
      <select name="ends_year">
<?php
$foo = date('Y');
for ($y = $foo - 2; $y <= $foo + 2; $y++) {
?>
       <option value="<?php echo $y; ?>" <?php if ($ends_year == $y) echo 'selected'; ?>><?php echo $y; ?></option>
<?php
}
?>
      </select>
      <select name="ends_hour">
       <option value="0" <?php if ($ends_hour == '00') echo 'selected'; ?>>12:00 AM</option>
       <option value="1" <?php if ($ends_hour == '01') echo 'selected'; ?>>1:00 AM</option>
       <option value="2" <?php if ($ends_hour == '02') echo 'selected'; ?>>2:00 AM</option>
       <option value="3" <?php if ($ends_hour == '03') echo 'selected'; ?>>3:00 AM</option>
       <option value="4" <?php if ($ends_hour == '04') echo 'selected'; ?>>4:00 AM</option>
       <option value="5" <?php if ($ends_hour == '05') echo 'selected'; ?>>5:00 AM</option>
       <option value="6" <?php if ($ends_hour == '06') echo 'selected'; ?>>6:00 AM</option>
       <option value="7" <?php if ($ends_hour == '07') echo 'selected'; ?>>7:00 AM</option>
       <option value="8" <?php if ($ends_hour == '08') echo 'selected'; ?>>8:00 AM</option>
       <option value="9" <?php if ($ends_hour == '09') echo 'selected'; ?>>9:00 AM</option>
       <option value="10" <?php if ($ends_hour == '10') echo 'selected'; ?>>10:00 AM</option>
       <option value="11" <?php if ($ends_hour == '11') echo 'selected'; ?>>11:00 AM</option>
       <option value="12" <?php if ($ends_hour == '12') echo 'selected'; ?>>12:00 PM</option>
       <option value="13" <?php if ($ends_hour == '13') echo 'selected'; ?>>1:00 PM</option>
       <option value="14" <?php if ($ends_hour == '14') echo 'selected'; ?>>2:00 PM</option>
       <option value="15" <?php if ($ends_hour == '15') echo 'selected'; ?>>3:00 PM</option>
       <option value="16" <?php if ($ends_hour == '16') echo 'selected'; ?>>4:00 PM</option>
       <option value="17" <?php if ($ends_hour == '17') echo 'selected'; ?>>5:00 PM</option>
       <option value="18" <?php if ($ends_hour == '18') echo 'selected'; ?>>6:00 PM</option>
       <option value="19" <?php if ($ends_hour == '19') echo 'selected'; ?>>7:00 PM</option>
       <option value="20" <?php if ($ends_hour == '20') echo 'selected'; ?>>8:00 PM</option>
       <option value="21" <?php if ($ends_hour == '21') echo 'selected'; ?>>9:00 PM</option>
       <option value="22" <?php if ($ends_hour == '22') echo 'selected'; ?>>10:00 PM</option>
       <option value="23" <?php if ($ends_hour == '23') echo 'selected'; ?>>11:00 PM</option>
      </select>&nbsp;<?php echo date('T') . ' <i>(GMT' . date('O') . ')</i>'; ?>
     </td>
    </tr>
    <tr>
     <td align="right" class="header">Reserve Price:</td>
     <td class="normal"><input type="text" name="reserve_price" value="<?php echo $reserve_price; ?>" size="35">
	 <input type="hidden" name="reserve_price_orig" value="<?php echo $reserve_price_orig; ?>"><i>(optional - seller's lowest acceptable price)</i></td>
    </tr>
    <tr>
     <td align="right" class="header">Buy Now Price:</td>
     <td class="normal"><input type="text" name="buy_now_price" value="<?php echo $buy_now_price; ?>" size="35">
	 <input type="hidden" name="buy_now_price_orig" value="<?php echo $buy_now_price_orig; ?>"><i>(optional)</i></td>
    </tr>
    <tr>
     <td class="header">Who pays transport?</td>
     <td class="normal">
	 <?php if (empty($bid_count) || ($bid_count == 0)) { ?>
			<select name="pays_transport">
				<option value="Buyer - 100%" <?php if (empty($pays_transport) || $pays_transport == 'Buyer - 100%') echo 'selected'; ?>>Buyer - 100%</option>
				<option value="Seller - up to 50 miles" <?php if ($pays_transport == 'Seller - up to 50 miles') echo 'selected'; ?>>Seller - up to 50 miles</option>
				<option value="Seller - up to 100 miles" <?php if ($pays_transport == 'Seller - up to 100 miles') echo 'selected'; ?>>Seller - up to 100 miles</option>
				<option value="Seller - in my state" <?php if ($pays_transport == 'Seller - in my state') echo 'selected'; ?>>Seller - in my state</option>
			</select>
	 <?php } else { ?>
			<?php $pays_transport?>
	 <?php } ?>
     </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
<?php if (ereg('add.php', $PHP_SELF)) { ?>
    <tr>
     <td>&nbsp;</td>
     <td class="big"><font color="#FF0000"><b>Please take this opportunity to edit and confirm the accuracy<br />of your auction information.</b></font></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
     <td>&nbsp;</td>
     <td class="big">I have confirmed the accuracy of my auction information.</td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td class="normal"><input type="submit" name="submit" value=" Please Create My Auction "></td>
    </tr>
<?php } else { ?>
    <tr>
     <td>&nbsp;</td>
     <td class="normal"><input type="submit" name="submit" value="<?php echo $page_title; ?>" /></td>
    </tr>
<?php } ?>
   </table>
  </form>
