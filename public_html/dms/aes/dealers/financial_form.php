<?php

include('../../../../include/session.php');
include('../../../../include/db.php');
db_connect();
include('../../../../include/defs.php');

$title = 'Application Form';

if (empty($did) || $did <= 0) {
	header("Location: index.php?id=$id");
	exit;
}

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$result = db_do("SELECT id FROM users WHERE username='$username'");
	list($user_id) = db_row($result);
	db_free($result);
	
	$result = db_do("SELECT id FROM aes WHERE user_id='$user_id'");
	list($ae_id) = db_row($result);
	db_free($result);
	
	$result = db_do("SELECT id FROM dealers WHERE ae_id='$ae_id' AND id='$did'");
	
	if (db_num_rows($result) <= 0) {
		$result = db_do("SELECT id FROM dms WHERE user_id='$user_id'");
		list($dm_id) = db_row($result);
		db_free($result);
		
		$result = db_do("SELECT dealers.id FROM dealers, aes, dms WHERE dealers.ae_id=aes.id " .
		"AND aes.dm_id = dms.id AND dealers.id='$did'");
	}
	
	if (db_num_rows($result) <= 0) {
		header("Location: index.php?id=$id");
		exit;
	}

	$result = db_do("SELECT name, address1, address2, city, state, zip, topdog_name, topdog_title, status,
					fb_name, fb_address1, fb_address2, fb_city, fb_state, fb_zip, fb_phone, fb_fax, fb_account FROM dealers WHERE id=$did"); 

	list($name, $address1, $address2, $city, $state, $zip, $topdog_name, $topdog_title, $status,
			$fb_name, $fb_address1, $fb_address2, $fb_city, $fb_state, $fb_zip, $fb_phone, $fb_fax, $fb_account) = db_row($result);
			
	if ($status != 'pending') {
		header("Location: index.php?id=$id");
		exit;
	}

	db_disconnect();
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
<style>
.supermini {font-size: 7pt}
.mini {font-size: 8pt}
.short {font-size: 10pt}
.medium {font-size: 11pt}
.large {
	font-family: Arial, Verdana, Helvetica, sans-serif;
	font-size: 18pt;
	font-weight: bold;
}
</style>
 </head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br />
<table width="650" align="center" cellpadding="0" cellspacing="0">
	<tr><td colspan="2"><img src="../../../images/Logo-White.gif"></td>
	</tr>
	<tr>
	  <td align="center" class="normal" colspan="2"><b>610A Morrison Rd.<br>Gahanna, OH 43230<br>Phone: (614) 575-0001<br>Fax: (614) 577-9998</b></td>
  	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  <td align="center" class="large" colspan="2"><b>Request for Release of<br>Account / Financial Information</b></td>
  	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="2">Date:&nbsp;<b><?=date('m/d/Y')?></b></td>
	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="2">Bank / Financial Institution Name:&nbsp;<b><?=$fb_name?></b></td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="2">Address:&nbsp;<b><?=$fb_address1?> <?=$fb_address2?></b></td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">City, State:&nbsp;<b><?=$fb_city?>,  <?=$fb_state?></b></td>
		<td width="50%" class="medium" align="left">Zip Code:&nbsp;<b><?=$fb_zip?></b></td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">Phone:&nbsp;<b><?=$fb_phone?></b></td>
		<td width="50%" class="medium" align="left">Fax:&nbsp;<b><?=$fb_fax?></b></td>
	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>	
	<tr>
		<td align="left" class="medium" colspan="2">Applicant Dealership / Company:&nbsp;<b><?=$name?></b></td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="2">Address:&nbsp;<b><?=$address1?> <?=$address2?></b></td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">City, State:&nbsp;<b><?=$city?>,  <?=$state?></b></td>
		<td width="50%" class="medium" align="left">Zip Code:&nbsp;<b><?=$zip?></b></td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="2">Account #:&nbsp;<b><?=$fb_account?></b></td>
	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td class="short" colspan="2">Dear Sir or Madam:</td>
	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td class="short" colspan="2">Your bank/financial institution has been listed by the dealer/company above as its 
		principal banking and or credit reference.  Go Dealer to Dealer is a �Members Only Online Auction Service�.  Membership 
		applicants must demonstrate that they are financially responsible companies.  Applicants must provide evidence of 
		their financial /credit standing.</td>
	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td class="short" colspan="2">We would appreciate it if you would provide the information requested below.  This 
		information is for business purposes only and will be kept confidential.  Your prompt reply will assist us in 
		serving our mutual customer.</td>
	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td class="short" colspan="2"><b><i>I hereby give my written consent to Go Dealer to Dealer to run a credit check 
		and obtain a credit report on me and my dealership/company.  I also give my consent to the bank/company listed above 
		to release credit and financial information to Go Dealer To Dealer.  Any charges associated with these services should 
		be billed directly to the account holder.</i></b></td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">Printed Name:&nbsp;<b><?=$topdog_name?></b></td>
		<td width="50%" class="medium" align="left">Title:&nbsp;<b><?=$topdog_title?></b></td>
	</tr>
	<tr>
	  <td colspan="2"><b><br>Authorized<br>Agent's Signature:</b>_____________________________________________&nbsp;<b>Date:</b>_______________</td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" class="supermini" colspan="2"><span class="mini"><b>Go Dealer to Dealer� Membership / User Agreement Form 1000</b></span><br>
						Copyright� GO DEALER TO DEALER L.L.C. ALL RIGHTS RESERVED<br>
						NO UNAUTHORIZED REPRODUCTION IS PERMITTED
		</td>
	</tr>
</table>
</body>
</html>