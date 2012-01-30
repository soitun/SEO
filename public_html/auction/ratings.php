<?php

include('../../include/session.php');
include('../../include/db.php');

extract(defineVars("id","dealer_id","bgcolor")); //JJM added


if (isset($id))
	$page_title = "Seller Rating for Auction #$id";
else
	$page_title = "Your Seller Rating";

$help_page = "chp7.php#Chp7_Ratesellers";

db_connect();
include('header.php');

if (isset($id)) {
	$result = db_do("SELECT dealer_id FROM auctions WHERE id='$id'");
	list($seller_id) = db_row($result);
}
else
	$seller_id = $dealer_id;

?>  <br />

<p align="center" class="big"><b><?php echo $page_title; ?></b></p><p><br>
<table align="center" border="0" cellspacing="1" cellpadding="4">
  <tr align="center" class="normal">
  	<td><b>Auction Category</b></td>
    <td width="35"><b>Time</b></td>
    <td width="35"><strong>Desc</strong></td>
	<td width="35"><b>Cond</b></td>
    <td width="35"><b>Avail</b></td>
    <td width="35"><b>Pay</b></td>
    <td width="35"><b>Trans</b></td>
    <td width="35"><b>Prof</b></td>
	<td width="0" bgcolor="#FFFFFF"></td>
	<td width="35"><b>Avg</b></td>
  </tr>
<?php
$result = db_do("SELECT COUNT(*) FROM ratings WHERE seller_id='$seller_id'");
list($num_of_ratings) = db_row($result);

$result = db_do("SELECT answered, total, timeliness, accuracy, availability, prompt_payment, ".
				"prompt_transport, vehicle_condition, professionalism, ".
				"comments, auction_id FROM ratings WHERE seller_id='$seller_id' ORDER BY id DESC LIMIT 0, 19");
$num_of_ratings_show = db_num_rows($result);
while (list($answered, $total, $timeliness, $accuracy, $availability, $prompt_payment,
	 $prompt_transport, $condition, $professionalism, $comments, $auction_id) = db_row($result))
{

$result_cid = db_do("SELECT category_id FROM auctions WHERE idphp $auction_id");
list($category_id) = db_row($result_cid);

if (isset($category_id)){
	$result_cname = db_do("SELECT name FROM categories WHERE idphp $category_id");
	list($category) = db_row($result_cname);
}
else
	$category = "Auction older than 60 Days";


$bgcolor = ($bgcolor == '#E6E6E6') ? '#FFFFFF' : '#E6E6E6';
$average = number_format($total/$answered,2);
?>
  <tr class="normal" align="center" bgcolor="<?php echo $bgcolor; ?>">
  	<td align="left"><?php echo $category; ?></td>
    <td width="35"><?php echo $timeliness; ?></td>
    <td width="35"><?php echo $accuracy; ?></td>
	<td width="35"><?php echo $condition; ?></td>
    <td width="35"><?php echo $availability; ?></td>
    <td width="35"><?php echo $prompt_payment; ?></td>
    <td width="35"><?php echo $prompt_transport; ?></td>
    <td width="35"><?php echo $professionalism; ?></td>
	<td bgcolor="#FFFFFF"></td>
	<td width="35"><?php echo $average; ?></td>
  </tr>


<?php }
$result = db_do("SELECT avg(timeliness), avg(accuracy), avg(availability), avg(prompt_payment), ".
				"avg(prompt_transport), avg(vehicle_condition), avg(professionalism) ".
				"FROM ratings WHERE seller_id='$seller_id' GROUP BY seller_id");
list($timeliness, $accuracy, $availability, $prompt_payment,
	 $prompt_transport, $condition, $professionalism) = db_row($result);
$bgcolor = '#E6E6E6';
$timeliness = number_format($timeliness,2);
$accuracy = number_format($accuracy,2);
$availability = number_format($availability,2);
$prompt_payment = number_format($prompt_payment,2);
$prompt_transport = number_format($prompt_transport,2);
$condition = number_format($condition,2);
$professionalism = number_format($professionalism,2);

?>
  <tr><td></td></tr>
  <tr class="normal" align="center" bgcolor="CCCCFF">
  	<td bgcolor="#FFFFFF"><b>Complete Seller Averages<br>For Each Column:</b></td>
    <td width="35"><?php tshow($timeliness); ?></td>
    <td width="35"><?php tshow($accuracy); ?></td>
    <td width="35"><?php tshow($condition); ?></td>
    <td width="35"><?php tshow($availability); ?></td>
    <td width="35"><?php tshow($prompt_payment); ?></td>
    <td width="35"><?php tshow($prompt_transport); ?></td>
    <td width="35"><?php tshow($professionalism); ?></td>
	<td bgcolor="#FFFFFF"></td>
	<td width="35" bgcolor="#3333FF"><font color="#FFFFFF"><b>
		<?php
		$result = db_do("SELECT rating FROM dealers WHERE id='$seller_id'");
		list($rating) = db_row($result);
		echo $rating;
		?>
	</b></font></td>
  </tr>
</table>
<table width="550" border="0" align="center" cellpadding="4" cellspacing="1">
	<tr align="center" class="normal">
  		<td><b>Showing <?php $num_of_ratings_show?> of <?php $num_of_ratings?> Ratings</b></td>
	</tr>
</table><br><br>
<table width="550" border="0" align="center" cellpadding="4" cellspacing="1">
	<tr align="center" class="normal">
  		<td><i>*Note: Complete Seller Averages is  from ALL AUCTIONS, not just the ones displayed.<br>
			<b>Time</b>=Timeliness of Initial Contact, <b>Desc</b>=Accuracy of Item Description,<br>
			<b>Cond</b>=Accuracy of Item Condition, <b>Avail</b>=Availability of Title/Certificate,<br>
			<b>Pay</b>=Prompt Payment Coordination, <b>Trans</b>=Prompt Transport Coordination,<br>
	  <b>Prof</b>=Overall Professionalism, <b>Avg</b>=Average for that particular auction.</i></td>
	</tr>
</table>

<?php

db_free($result);


#db_free($result);
db_disconnect();
include('footer.php');
?>
