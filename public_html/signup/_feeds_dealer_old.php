<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>


<?php

// Randy added the following //
// DEFINING VARIABLES FROM THE REQUEST   //



$PHP_SELF = $_SERVER['PHP_SELF'];

if(!empty($_REQUEST['status']))
	$status = $_REQUEST['status'];
else
	$status = "";



if(!empty($_REQUEST['id']))
	$id = $_REQUEST['id'];
else
	$id = "";

if(!empty($_REQUEST['name']))
	$name = $_REQUEST['name'];
else
	$name = "";

if(!empty($_REQUEST['dba']))
	$dba = $_REQUEST['dba'];
else
	$dba = "";

if(!empty($_REQUEST['business']))
	$business = $_REQUEST['business'];
else
	$business = "";

if(!empty($_REQUEST['ein']))
	$ein = $_REQUEST['ein'];
else
	$ein = "";

if(!empty($_REQUEST['no_of_stores']))
	$no_of_stores = $_REQUEST['no_of_stores'];
else
	$no_of_stores = "";


if(!empty($_REQUEST['years']))
	$years = $_REQUEST['years'];
else
	$years = "";


if(!empty($_REQUEST['industry']))
	$industry = $_REQUEST['industry'];
else
	$industry = "";

if(!empty($_REQUEST['address1']))
	$address1 = $_REQUEST['address1'];
else
	$address1 = "";


if(!empty($_REQUEST['address2']))
	$address2 = $_REQUEST['address2'];
else
	$address2 = "";


if(!empty($_REQUEST['city']))
	$city = $_REQUEST['city'];
else
	$city = "";

if(!empty($_REQUEST['state']))
	$state = $_REQUEST['state'];
else
	$state = "";

if(!empty($_REQUEST['zip']))
	$zip = $_REQUEST['zip'];
else
	$zip = "";

if(!empty($_REQUEST['zip']))
	$zip = $_REQUEST['zip'];
else
	$zip = "";


if(!empty($_REQUEST['billing_address1']))
	$billing_address1 = $_REQUEST['billing_address1'];
else
	$billing_address1 = "";


if(!empty($_REQUEST['billing_address2']))
	$billing_address2 = $_REQUEST['billing_address2'];
else
	$billing_address2 = "";

if(!empty($_REQUEST['billing_city']))
	$billing_city = $_REQUEST['billing_city'];
else
	$billing_city = "";


if(!empty($_REQUEST['billing_state']))
	$billing_state = $_REQUEST['billing_state'];
else
	$billing_state = "";


if(!empty($_REQUEST['billing_zip']))
	$billing_zip = $_REQUEST['billing_zip'];
else
	$billing_zip = "";


if(!empty($_REQUEST['phone']))
	$phone = $_REQUEST['phone'];
else
	$phone = "";


if(!empty($_REQUEST['fax']))
	$fax = $_REQUEST['fax'];
else
	$fax = "";

if(!empty($_REQUEST['poc_f_name']))
	$poc_f_name = $_REQUEST['poc_f_name'];
else
	$poc_f_name = "";


if(!empty($_REQUEST['poc_m_name']))
	$poc_m_name = $_REQUEST['poc_m_name'];
else
	$poc_m_name = "";


if(!empty($_REQUEST['poc_l_name']))
	$poc_l_name = $_REQUEST['poc_l_name'];
else
	$poc_l_name = "";



if(!empty($_REQUEST['poc_title']))
	$poc_title = $_REQUEST['poc_title'];
else
	$poc_title = "";


if(!empty($_REQUEST['poc_email']))
	$poc_email = $_REQUEST['poc_email'];
else
	$poc_email = "";


if(!empty($_REQUEST['poc_phone']))
	$poc_phone = $_REQUEST['poc_phone'];
else
	$poc_phone = "";

if(!empty($_REQUEST['poc_fax']))
	$poc_fax = $_REQUEST['poc_fax'];
else
	$poc_fax = "";


if(!empty($_REQUEST['topdog_name']))
	$topdog_name = $_REQUEST['topdog_name'];
else
	$topdog_name = "";


if(!empty($_REQUEST['topdog_title']))
	$topdog_title = $_REQUEST['topdog_title'];
else
	$topdog_title = "";


if(!empty($_REQUEST['dl_no']))
	$dl_no = $_REQUEST['dl_no'];
else
	$dl_no = "";


if(!empty($_REQUEST['dl_ex']))
	$dl_ex = $_REQUEST['dl_ex'];
else
	$dl_ex = "";


if(!empty($_REQUEST['vst_no']))
	$vst_no = $_REQUEST['vst_no'];
else
	$vst_no = "";


if(!empty($_REQUEST['vst_ex']))
	$vst_ex = $_REQUEST['vst_ex'];
else
	$vst_ex = "";



if(!empty($_REQUEST['cc_type']))
	$cc_type = $_REQUEST['cc_type'];
else
	$cc_type = "";



if(!empty($_REQUEST['cc_name']))
	$cc_name = $_REQUEST['cc_name'];
else
	$cc_name = "";

if(!empty($_REQUEST['cc_no']))
	$cc_no = $_REQUEST['cc_no'];
else
	$cc_no = "";




if(!empty($_REQUEST['cc_ex']))
	$cc_ex = $_REQUEST['cc_ex'];
else
	$cc_ex = "";



if(!empty($_REQUEST['bd_name']))
	$bd_name = $_REQUEST['bd_name'];
else
	$bd_name = "";


if(!empty($_REQUEST['bd_routing']))
	$bd_routing = $_REQUEST['bd_routing'];
else
	$bd_routing = "";


if(!empty($_REQUEST['bd_account']))
	$bd_account = $_REQUEST['bd_account'];
else
	$bd_account = "";

?>


<?php    if (!empty($errors)) { ?>



       <table align="center" border="0" cellpadding="0" cellspacing="0">
          <tr>
           <td class="error">The following fields were incorrect/incomplete:<br /><ul><?php $errors?></ul></td>
          </tr>
		  <tr><td colspan="2">&nbsp;</td></tr>
</table>





<?php } ?>




	<form method="post" action="<?php $PHP_SELF?>">
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="ae_id" value="<?php echo $ae_id; ?>" />
		<input type="hidden" name="status" value="<?php echo $status; ?>" />
<table width="550" align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		
      <td class="big" align="center" colspan="2"><b><u><font size="5">Feed Company 
        Information</font></u></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	 
	<tr>
		
      <td width="175" align="right" class="header"><span class="style1">*</span> 
        Feed Company Name:&nbsp;</td>
		<td class="normal"><input type="text" name="name" size="50" value="<?php $name?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Account #:&nbsp;</td>
		<td class="normal"><input type="text" name="dba" size="50" value="<?php $name?>" /></td>
	</tr>
	  
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Industry:&nbsp;</td>
		<td class="normal"><select name="industry">
			<option value='' <?php if ($industry == '') echo 'selected'; ?>>Choose One</option>
			<option value="Aircraft" <?php if ($industry == 'Aircraft') echo 'selected'; ?>>Aircraft</option>
			<option value="Motorcycle" <?php if ($industry == 'Motorcycle') echo 'selected'; ?>>Motorcycle</option>
			<option value="Marine" <?php if ($industry == 'Marine') echo 'selected'; ?>>Marine</option>
			<option value="Power Sports" <?php if ($industry == 'Power Sports') echo 'selected'; ?>>Power Sports</option>
			<option value="Automotive" <?php if ($industry == 'Automotive') echo 'selected'; ?>>Automotive</option>
			<option value="RV" <?php if ($industry == 'RV') echo 'selected'; ?>>RV</option>
			<option value="Truck" <?php if ($industry == 'Truck') echo 'selected'; ?>>Truck</option>
			<option value="Fleet" <?php if ($industry == 'Fleet') echo 'selected'; ?>>Fleet</option>
			<option value="Rental" <?php if ($industry == 'Rental') echo 'selected'; ?>>Rental</option>
			<option value="Financial" <?php if ($industry == 'Financial') echo 'selected'; ?>>Financial</option>
			<option value="Other" <?php if ($industry == 'Other') echo 'selected'; ?>>Other</option></select></td>
	</tr>
	<tr>
      <td align="right" class="header">Inventory Management Company:&nbsp;</td>
	  <td class="normal"><input type="text" name="feed_provider" size="50" value="<?php $feed_provider?>" /></td>
    </tr>
	 
	</table>

<table width="550" align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		
      <td class="big" align="center" colspan="2"><b><u><font size="5">Feed Companies 
        - Point of Contact Information</font></u></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Contact Name:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_f_name" size="15" value="<?php $poc_f_name?>" />
		<input type="text" name="poc_m_name" size="2" value="<?php $poc_m_name?>" />
		<input type="text" name="poc_l_name" size="15" value="<?php $poc_l_name?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Contact Title:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_title" size="25" value="<?php $poc_title?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Contact Email:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_email" size="25" value="<?php $poc_email?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Contact Phone:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_phone" size="25" maxlength="12"  value="<?php $poc_phone?>" />
		*Phone Format: 000-000-0000</td>
	</tr>
	<tr>
		
      <td width="175" align="right" class="header"><span class="style1">*</span> 
        Contact ph.Extension #:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_phone" size="25" maxlength="12"  value="<?php $poc_phone?>" />
      </td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Contact Cell:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_cell" size="25" maxlength="12"  value="<?php $poc_cell?>" />
		*Phone Format: 000-000-0000</td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Contact Fax:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_fax" size="25" maxlength="12" value="<?php $poc_fax?>" />
		*Fax Format: 000-000-0000</td>
	</tr>
	 
	
</table>
 
<table width="600" align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td align="center" class="normal" colspan="2">
			<?php if ($status != 'pending') { echo "<input type='submit' name='submit' value='Submit Information'>"; } ?>
			<?php if (!isset($id)) { echo "&nbsp;&nbsp;&nbsp;<input type='reset' value='Clear'>"; } ?>
&nbsp;&nbsp;&nbsp;		</td>
	</tr>
</table>
<input type="hidden" name="invoice" value="yes" />
<input type="hidden" name="charter_member" value="yes" />
</form>
    <map name="Map">
      <area shape="rect" coords="11,3,126,55" href="http://www.americanexpress.com" target="_blank">
      <area shape="rect" coords="146,7,216,52" href="http://www.visa.com" target="_blank">
      <area shape="rect" coords="232,8,305,53" href="http://www.mastercard.com" target="_blank">
      <area shape="rect" coords="320,8,393,53" href="http://www.discovercard.com" target="_blank">
    </map>
