

<?php

$PHP_SELF = $_SERVER['PHP_SELF'];

if(!empty($_REQUEST['id']))
	$id = $_REQUEST['id'];
else
	$id = "";

if(!empty($_REQUEST['fb_name']))
	$fb_name = $_REQUEST['fb_name'];
else
	$fb_name = "";

 if(!empty($_REQUEST['fb_address1']))
 	$fb_address1 = $_REQUEST['fb_address1'];
 else
 	$fb_address1 = "";



if(!empty($_REQUEST['fb_address2']))
	$fb_address2 = $_REQUEST['fb_address2'];
else
	$fb_address2 = "";

if(!empty($_REQUEST['fb_city']))
	$fb_city = $_REQUEST['fb_city'];
else
	$fb_city = "";

if(!empty($_REQUEST['fb_city']))
	$fb_city = $_REQUEST['fb_city'];
else
	$fb_city = "";

if(!empty($_REQUEST['fb_phone ']))
	$fb_phone  = $_REQUEST['fb_phone '];
else
	$fb_phone  = "";

if(!empty($_REQUEST['fb_fax']))
	$fb_fax = $_REQUEST['fb_fax'];
else
	$fb_fax = "";

if(!empty($_REQUEST['fb_account']))
	$fb_account = $_REQUEST['fb_account'];
else
	$fb_account = "";

if(!empty($_REQUEST['fb_zip']))
	$fb_zip = $_REQUEST['fb_zip'];
else
	$fb_zip = "";

if(!empty($_REQUEST['name']))
	$name = $_REQUEST['name'];
else
	$name = "";

?>






<?php if (!empty($errors)) { ?>
       <table align="center" border="0" cellpadding="0" cellspacing="0">
          <tr>
           <td class="error">The following fields were incorrect/incomplete:<br /><ul><?php $errors?></ul></td>
          </tr>
		  <tr><td colspan="2">&nbsp;</td></tr>
         </table>
<?php } ?>
	<form method="post" action="<?php $PHP_SELF?>">
		<input type="hidden" name="id" value="<?php echo $id; ?>" />

<table align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td class="big" align="center" colspan="2"><b><u>Finanical Bank Information</u></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="right" class="header">Dealer Name:&nbsp;</td>
		<td class="normal"><?php $name?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Name:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_name" size="25" value="<?php $fb_name?>" /></td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Address:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_address1" size="25" value="<?php $fb_address1?>" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="normal"><input type="text" name="fb_address2" size="25" value="<?php $fb_address2?>" /></td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank City:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_city" size="25" maxlength="25" value="<?php $fb_city?>" /></td>
  </tr>
	<tr>
		<td align="right" class="header">Financial Bank State:&nbsp;</td>
		<td class="normal">
			<select name="fb_state">
			<option value="" selected>Choose State</option>
				<?php
					reset($STATES);
					while (list($key, $value) = each($STATES)) {
						echo "          <option value=\"$key\"";
						if ($fb_state == $key)
						echo " selected";
						echo ">$value</option>\n";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Zip Code:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_zip" size="25" value="<?php $fb_zip?>" /></td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Phone Number:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_phone" size="25" maxlength="12" value="<?php $fb_phone?>" />
		*Phone Format: 000-000-0000</td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Fax:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_fax" size="25"  maxlength="12" value="<?php $fb_fax?>">
		*Fax Format: 000-000-0000</td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Account#:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_account" size="25"  maxlength="12" value="<?php $fb_account?>"></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td align="center" class="normal" colspan="2"><input type="submit" name="submit" value=" Submit">
		</td></tr>
</table>
</form>
