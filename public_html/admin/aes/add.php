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
# $srp: godealertodealer.com/htdocs/admin/aes/add.php,v 1.1 2002/10/15 05:44:47 steve Exp $
#

include('../../../include/db.php');
db_connect();

extract(defineVars("un","uid","pw","email","first_name","last_name",
				   "address1","address2","city","zip","phone","fax",
				   "ssn","limited","submit","id","dm_id","un2","status",
				   "limited","submit")); //JJM 8/30/2010

$page_title = 'Add Account Executive';

$skip_privs = 1;
include('../../../include/session.php');

if (!is_array($_privs))
	$_privs = array();

$un   			= trim($un);
$pw         = trim($pw);
$email      = trim($email);
$first_name = trim($first_name);
$last_name  = trim($last_name);
$address1   = trim($address1);
$address2   = trim($address2);
$city       = trim($city);
$zip        = trim($zip);
$phone      = trim($phone);
$fax        = trim($fax);
$ssn        = trim($ssn);
$limited        = trim($limited);
$errors     = '';

if (isset($submit)) {
  if (empty($un))
		$errors .= '<li>You must supply a username.</li>';

	if (empty($pw))
		$errors .= '<li>You must supply a password.</li>';

	if (!ereg("^.+@.+\\..+$", $email))
		$errors .= '<li>You must supply a valid email address.</li>';

	if (empty($first_name))
		$errors .= '<li>You must supply a first name.</li>';

	if (empty($last_name))
		$errors .= '<li>You must supply a last name.</li>';

	if (empty($address1)) {
		$address2 = '';
		$errors .= '<li>You must supply an address.</li>';
	}

	if (empty($city))
		$errors .= '<li>You must supply a city.</li>';

	if (empty($zip))
		$errors .= '<li>You must supply a zipcode.</li>';

	$phone = clean_phone_number($phone);
	if (empty($phone))
		$errors .= '<li>You must supply a valid phone number.</li>';

	$fax = clean_phone_number($fax);

	if (empty($ssn))
		$errors .= '<li>You must supply a Social Security Number.</li>';

	$result = db_do("SELECT id FROM users WHERE username='$un'");
	if (db_num_rows($result) > 0)
		$errors .= '<li>Username already exists.</li>';
	db_free($result);

	if (empty($errors)) {
		$_privs[] = 'acctexec';
		$p = encode_privs($_privs);

     db_do("INSERT INTO users SET dealer_id='0', username='$un', password='$pw', email='$email', first_name='$first_name', last_name='$last_name',
	 		address1='$address1', address2='$address2', city='$city', state='$state', zip='$zip', phone='$phone', fax='$fax',
			privs='$p', status='$status', modified=NOW(), created=modified");

		 $result = db_do("SELECT id FROM users WHERE username='$un'");
		 list($uid) = db_row($result);

		db_do("INSERT INTO aes SET dm_id='$dm_id', user_idphp $uid, email='$email', first_name='$first_name', last_name='$last_name',
			address1='$address1', address2='$address2', city='$city', state='$state', zip='$zip', phone='$phone', fax='$fax',
			ssn='$ssn', status='$status', limited='$limited', modified=NOW(), created=modified");

		db_disconnect();

		header('Location: index.php');
		exit;
	}
} else {
	$useridresult = db_do("SELECT id, username FROM users WHERE status='active' and locate('acctexec', privs) > 0");
}

$email      = stripslashes($email);
$first_name = stripslashes($first_name);
$last_name  = stripslashes($last_name);
$address1   = stripslashes($address1);
$address2   = stripslashes($address2);
$city       = stripslashes($city);
$zip        = stripslashes($zip);
$phone      = stripslashes($phone);
$fax        = stripslashes($fax);
$ssn        = stripslashes($ssn);
$limited 	= stripslashes($limited);


if (empty($status))
	$status = 'active';
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
<?php include('_links.php'); ?>
  <p align="center" class="big"><b>Add User</b></p>
<?php include('_form.php'); ?>
 </body>
</html>
