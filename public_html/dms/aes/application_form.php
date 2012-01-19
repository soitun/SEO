<?php

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();
include('../../../include/defs.php');

$title = 'Application Form';

if (empty($id) || $id <= 0) {
	header('Location: dealers.php');
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
	
	$result = db_do("SELECT id, dm_id FROM aes WHERE user_id='$user_id'");
	list($ae_id, $dm_id) = db_row($result);
	db_free($result);
	
	if($dm_id != $user_id) {
		$result = db_do("SELECT id FROM dealers WHERE id='$id'");
		if (db_num_rows($result) <= 0) {
			header('Location: dealers.php');
			exit;
		}
	}

	$result = db_do("SELECT d.address1, d.address2, d.bd_account, d.bd_name, d.bd_routing, d.billing_address1, d.billing_address2, 
			d.billing_city, d.billing_state, d.billing_zip, d.business, d.cc_ex, d.cc_name, d.cc_no, d.cc_type, d.city, d.dba, 
			d.dl_ex, d.dl_no, d.ein, d.fax, d.industry, d.name, d.phone, d.poc_email, d.poc_f_name, d.poc_fax, d.poc_l_name, 
			d.poc_phone, d.poc_title, d.state, d.topdog_name, d.topdog_title, d.vst_ex, d.vst_no, d.years, d.zip, d.status, d.feed_provider, CONCAT(ae.first_name, ' ', ae.last_name) AS ae_name FROM dealers d, aes ae  WHERE d.id = '$id' AND ae.id = d.ae_id"); 

	list($address1, $address2, $bd_account, $bd_name, $bd_routing, $billing_address1, $billing_address2, 
			$billing_city, $billing_state, $billing_zip, $business, $cc_ex, $cc_name, $cc_no, $cc_type, $city, $dba, 
			$dl_ex, $dl_no, $ein, $fax, $industry, $name, $phone, $poc_email, $poc_f_name, $poc_fax, $poc_l_name, 
			$poc_phone, $poc_title, $state, $topdog_name, $topdog_title, $vst_ex, $vst_no, $years, $zip, $status, $feed_provider, $ae_name) = db_row($result);

			
	if ($status != 'pending') {
		header('Location: dealers.php');
		exit;
	}
	
	db_disconnect();
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
<style>
.supermini {font-size: 7pt}
.mini {font-size: 8pt}
.short {font-size: 10pt}
.medium {font-size: 11pt}
.large {
	font-size: 24pt;
	font-weight: bold;
	font-style: italic;
}
</style>
 </head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br />
<table width="650" align="center" cellpadding="0" cellspacing="0">
	<tr><td colspan="2"><img src="../../../images/Logo-White.gif"></td></tr>
	<tr>
	  <td align="center" colspan="2"><span class="large">Application Form</span></td>
  </tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td align="left" class="medium"> Business (Legal) Name:&nbsp;<b><?=$name?></b></td>
		<td align="right" class="medium">AE Name:&nbsp;<b><?=$ae_name?></b></td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="2">DBA:&nbsp;<b><?=$dba?></b></td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="2">Type of Business:&nbsp;<b><?=$business?></b></td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">Corporation's Federal EIN#:&nbsp;<b><?=$ein?></b></td>
		<td width="50%" class="medium" align="left">Years of Business:&nbsp;<b><?=$years?></b></td>
	</tr>
	<tr>
		<td align="left" class="medium">Industry:&nbsp;<b><?=$industry?></b></td>
		<td align="left" class="medium">Feed Provider:&nbsp;<b><?=$feed_provider?></b></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
	<tr>
		<td align="center" class="medium" colspan="2"><b><u>Dealership/Finacial Company's Address:</u></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="2">Physical Address:&nbsp;<b><?=$address1?> <?=$address2?></b></td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">City, State:&nbsp;<b><?=$city?>,  <?=$state?></b></td>
		<td width="50%" class="medium" align="left">Zip Code:&nbsp;<b><?=$zip?></b></td>
	</tr>
	<tr>
		<td align="left" class="medium" colspan="2">Billing Address:&nbsp;<b><?=$billing_address1?> <?=$billing_address2?></b></td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">Billing City, State:&nbsp;<b><?=$billing_city?>, <?=$billing_state?></b></td>
		<td width="50%" class="medium" align="left">Billing Zip Code:&nbsp;<b><?=$billing_zip?></b></td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">Phone:&nbsp;<b><?=$phone?></b></td>
		<td width="50%" class="medium" align="left">Fax:&nbsp;<b><?=$fax?></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">Dealer License #:&nbsp;<b><?=$dl_no?></b></td>
		<td width="50%" class="medium" align="left">Expiration Date:&nbsp;<b><?=$dl_ex?></b></td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">Vendor / State Tax #:&nbsp;<b><?=$vst_no?></b></td>
		<td width="50%" class="medium" align="left">Expiration Date:&nbsp;<b><?=$vst_ex?></b></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2"><hr></td></tr>
	<tr>
		<td align="center" class="medium" colspan="2"><b><u>Point of Contact</u></b></td>
	</tr>
	<tr>
		<td colspan="2"><span class="short"><b>Authorized user ot delegate authority for this dealership 
		for the use of the Go Dealer To Dealer web site.</b></span></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">Name:&nbsp;<b><?=$poc_f_name?> <?=$poc_m_name?> <?=$poc_l_name?></b></td>
		<td width="50%" class="medium" align="left">Title:&nbsp;<b><?=$poc_title?></b></td>
	</tr>
	<tr>		
		<td align="left" class="medium" colspan="2">Email Address:&nbsp;<b><?=$poc_email?></b></td>
	</tr>
	<tr>
		<td width="50%" class="medium" align="left">Phone:&nbsp;<b><?=$poc_phone?></b></td>
		<td width="50%" class="medium" align="left">Fax:&nbsp;<b><?=$poc_fax?></b></td>
	</tr>
	<tr><td colspan="2"><hr></tr></td></tr>
	<tr>
		<td align="center" class="medium" colspan="2"><b><u>Electronic Payment</u></b></td>
	</tr>
	<tr>
		<td class="medium" align="center"><b><i><u>Credit/Debit Card</u></i></b></td>
		<td class="medium" align="center"><b><i><u>Bank Account Draft</u></i></b></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td width="50%">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td class="medium" align="left">Credit Card Type:&nbsp;<b><?=$cc_type?></b></td>
				</tr>
		</table>
		</td>
		<td>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td class="medium" align="left">Name of Bank:&nbsp;<b><?=$bd_name?></b></td>
				</tr>
			<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	  <td colspan="2"><hr></td>
	</tr>
	<tr>
		<td colspan="2"><span class="short"><b>I have read and fully accept the terms and conditions contained 
			within the Dealer To Dealer L.L.C. dba Go Dealer To Dealer ("GDTD") Membership / User Agreement 
			and this Application Form.  I certify all of the information submitted in this application is true 
			and complete.  I authorize GDTD to bill my listed account monthly for payment for any and all fees 
			related to my GDTD account and to obtain information from others concerning the undersigned's respective 
			credit standings and other relevant information impacting this application.</b></span></td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  <td colspan="2"><b>Signature:</b>________________________________________________________________________</td>
	</tr>
	<tr>
	  <td width="50%" class="medium" align="left"><b>Printed Name:</b>____________________________</td>
	  <td width="50%" class="medium" align="left"><b>Title:</b>_______________&nbsp;
	  											  <b>Date:</b>_______________</td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" class="supermini" colspan="2"><strong>Fax this signed form and copy of Dealer's License or State Tax ID to: (435) 487-6709 </strong></td>
	</tr>
</table>
</body>
</html>