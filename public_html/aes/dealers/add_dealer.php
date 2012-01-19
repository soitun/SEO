<?php

$skip_privs = 1;
 include('../../../include/session.php');
//    include('../../../include/defs.php');     //
include('../../../include/states.php');
include('../../../include/db.php');
db_connect();

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: http://'.$_SERVER['SERVER_NAME'].'/');
	exit;
}

if (isset($save)) {

	if (!isset($pmt_method))
			$pmt_method = array();
		else
			$payment_method = implode(",", $pmt_method);

	db_do("INSERT INTO dealers SET address1='$address1', address2='$address2', bd_account='$bd_account', " .
		"bd_name='$bd_name', bd_routing='$bd_routing', billing_address1='$billing_address1', " .
		"billing_address2='$billing_address2', billing_city='$billing_city', billing_state='$billing_state', " .
		"billing_zip='$billing_zip', business='$business', cc_ex='$cc_ex', cc_name='$cc_name', cc_no='$cc_no', " .
		"cc_type='$cc_type', city='$city', dba='$dba', dl_ex='$dl_ex', dl_no='$dl_no', ein='$ein', fax='$fax', " .
		"industry='$industry', name='$name', phone='$phone', poc_email='$poc_email', poc_f_name='$poc_f_name', poc_m_name='$poc_m_name', " .
		"poc_fax='$poc_fax', poc_l_name='$poc_l_name', poc_phone='$poc_phone', poc_title='$poc_title', state='$state', " .
      "poc2_email='$poc2_email', poc2_f_name='$poc2_f_name', poc2_m_name='$poc2_m_name', " .
			"poc2_fax='$poc2_fax', poc2_l_name='$poc2_l_name', poc2_phone='$poc2_phone', poc2_title='$poc2_title'," .
		"topdog_name='$topdog_name', topdog_title='$topdog_title', vst_ex='$vst_ex', vst_no='$vst_no', " .
		"years='$years', zip='$zip', payment_method='$payment_method', charter_member='$charter_member', invoice='$invoice', no_of_stores='$no_of_stores', type='$type', feed_provider='$feed_provider',
		modified=NOW(), created=modified, status='saved', ae_id='$ae_id', notes='$notes'");

		header('Location: index.php');
		exit;
}


elseif (isset($submit)) {
	$address1		= trim($address1);
	$address2		= trim($address2);
	$bd_account		= trim($bd_account);
	$bd_name		= trim($bd_name);
	$bd_routing		= trim($bd_routing);
	$billing_address1 = trim($billing_address1);
	$billing_address2 = trim($billing_address2);
	$billing_city	= trim($billing_city);
	$billing_state	= trim($billing_state);
	$billing_zip	= trim($billing_zip);
	$business		= trim($business);
	$cc_ex			= trim($cc_ex);
	$cc_name		= trim($cc_name);
	$cc_no			= trim($cc_no);
	$cc_type		= trim($cc_type);
	$city			= trim($city);
	$dba			= trim($dba);
	$dl_ex			= trim($dl_ex);
	$dl_no			= trim($dl_no);
	$ein			= trim($ein);
	$fax			= trim($fax);
	$industry		= trim($industry);
	$name			= trim($name);
	$phone			= trim($phone);
	$poc_email		= trim($poc_email);
	$poc_f_name		= trim($poc_f_name);
	$poc_fax		= trim($poc_fax);
	$poc_m_name		= trim($poc_m_name);
	$poc_l_name		= trim($poc_l_name);
	$poc_phone		= trim($poc_phone);
	$poc_title		= trim($poc_title);
	$state			= trim($state);
	$topdog_name	= trim($topdog_name);
	$topdog_title	= trim($topdog_title);
	$vst_ex			= trim($vst_ex);
	$vst_no			= trim($vst_no);
	$years			= trim($years);
	$zip  			= trim($zip);
   $type          = trim($type);
   $feed_provider = trim($feed_provider);

	$errors = '';

	if (empty($name))
		$errors .= '<li>Dealership Name</li>';
	if (empty($dba))
		$errors .= '<li>Doing Business As</li>';
	if (empty($business))
		$errors .= '<li>Type of Business</li>';
	if (empty($ein))
		$errors .= '<li>Federal EIN Number</li>';
	if (empty($years))
		$errors .= '<li>Years of Business</li>';
	if (empty($industry))
		$errors .= '<li>Industry</li>';

	if (empty($poc_f_name))
		$errors .= '<li>Contact First Name</li>';
	if (empty($poc_l_name))
		$errors .= '<li>Contact Last Name</li>';
	if (empty($poc_title))
		$errors .= '<li>Contact Title</li>';
	if (empty($poc_email) || !ereg("^.+@.+\\..+$", $poc_email))
		$errors .= '<li>Contact Email</li>';
	if (empty($poc_phone))
		$errors .= '<li>Contact Phone</li>';
	if (empty($topdog_name))
		$errors .= '<li>Owner Name</li>';
	if (empty($topdog_title))
		$errors .= '<li>Owner Title</li>';


	if (empty($vst_ex))
		$errors .= '<li>Vendor/State Tax Expiration Date</li>';
	if (empty($vst_no))
		$errors .= '<li>Vendor/State Tax Number</li>';

	if (empty($bd_name) || empty($bd_routing) || empty($bd_account))
	{
		if (empty($cc_ex))
			$errors .= '<li>Credit Card Expiration Date</li>';
		if (empty($cc_type))
			$errors .= '<li>Type of Credit Card</li>';
		if (empty($cc_name))
			$errors .= '<li>Name on Credit Card</li>';
		if (empty($cc_no))
			$errors .= '<li>Credit Card Number</li>';
	}

	if (empty($cc_ex) || empty($cc_type) || empty($cc_name) || empty($cc_no))
	{
		if (empty($bd_name))
			$errors .= '<li>Bank Draft Name</li>';
		if (empty($bd_routing))
			$errors .= '<li>Bank Draft Routing</li>';
		if (empty($bd_account))
			$errors .= '<li>Bank Draft Account</li>';
	}

	if (empty($address1)) {
		$errors .= '<li>Address</li>';
		$address2 = '';
	}
	if (empty($city))
		$errors .= '<li>City</li>';
	if (empty($state))
		$errors .= '<li>State</li>';
	if (empty($zip))
		$errors .= '<li>Zip</li>';
	if (empty($phone))
		$errors .= '<li>Phone</li>';

	if (empty($billing_address1)) {
		$errors .= '<li>Billing Address</li>';
		$billing_address2 = '';
	}
	if (empty($billing_city))
		$errors .= '<li>Billing City</li>';
	if (empty($billing_state))
		$errors .= '<li>Billing State</li>';
	if (empty($billing_zip))
		$errors .= '<li>Billing Zip</li>';
   if (empty($type))
      $errors .= '<li>Type (Franchise/Independent)</li>';

	if (empty($errors)) {

		if (!isset($pmt_method))
			$pmt_method = array();
		else
			$payment_method = implode(",", $pmt_method);

		db_do("INSERT INTO dealers SET address1='$address1', address2='$address2', bd_account='$bd_account', " .
			"bd_name='$bd_name', bd_routing='$bd_routing', billing_address1='$billing_address1', " .
			"billing_address2='$billing_address2', billing_city='$billing_city', billing_state='$billing_state', " .
			"billing_zip='$billing_zip', business='$business', cc_ex='$cc_ex', cc_name='$cc_name', cc_no='$cc_no', " .
			"cc_type='$cc_type', city='$city', dba='$dba', dl_ex='$dl_ex', dl_no='$dl_no', ein='$ein', fax='$fax', " .
			"industry='$industry', name='$name', phone='$phone', poc_email='$poc_email', poc_f_name='$poc_f_name', poc_m_name='$poc_m_name', " .
			"poc_fax='$poc_fax', poc_l_name='$poc_l_name', poc_phone='$poc_phone', poc_title='$poc_title', state='$state', " .
         "poc2_email='$poc2_email', poc2_f_name='$poc2_f_name', poc2_m_name='$poc2_m_name', " .
			"poc2_fax='$poc2_fax', poc2_l_name='$poc2_l_name', poc2_phone='$poc2_phone', poc2_title='$poc2_title'," .
			"topdog_name='$topdog_name', topdog_title='$topdog_title', vst_ex='$vst_ex', vst_no='$vst_no', " .
			"years='$years', zip='$zip', payment_method='$payment_method', charter_member='$charter_member', invoice='$invoice', no_of_stores='$no_of_stores',
			type='$type', feed_provider='$feed_provider', modified=NOW(), created=modified, status='pending', ae_id='$ae_id', notes='$notes'");

		#$id = db_insert_id();
		#$msg = "A new dealer has registered and requires your approval.

#http://$SITE_NAME/admin/dealers/edit.php?id=$id
#";
		#mail($SITE_CONTACT, 'New dealer registration', $msg,
		    #$EMAIL_FROM);

		header('Location: index.php?s=pending');
		exit;
	}

	db_disconnect();
}
else {

	if(isset($id)) {
		header('Location: index.php');
		exit;
	}

	$result = db_do("SELECT id FROM users WHERE username='$username'");
	list($user_id) = db_row($result);
	db_free($result);

	$result = db_do("SELECT id FROM aes WHERE user_id='$user_id'");
	list($ae_id) = db_row($result);
	db_free($result);

}


$title = 'Dealer / Financial Company Application';

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?><?php include('_links.php'); ?>
<p align="center" class="big"><b>AE Add A Dealer</b></p>
  <?php include('_form_dealer.php'); ?>
  <?php include('../footer.php'); ?>
 </body>
</html>