<?php

include('../include/defs.php');
include('../include/defineVars.php'); //JJM 08/28/2010
extract(defineVars("username"));

$title = 'Forgot Password';

if (!empty($username)) {
	include('../include/db.php');

	db_connect();
   $result = db_do("UPDATE users SET password = '1234'
                    WHERE username = '$username' LIMIT 1");

	$result = db_do("SELECT email, password FROM users WHERE " .
	    "username='$username' AND status='active'");

	if ($result && db_num_rows($result) == 1) {
		list($email, $password) = db_row($result);
		$msg = "Hello,

A user has requested that the password for this account be reset.

        username: $username
        password: $password

Please log into the Go DEALER to DEALER site and change your password soon!
In order to access the auctions to buy, sell, or simply browse all the
great deals you'll need to have these handy.

If you did NOT request this email, please login to Go DEALER to DEALER
using your new password and immediately change your password, and we're
sorry for the inconvenience.

Thanks,
Go DEALER to DEALER
";
		mail("$email", "GoDEALERtoDEALER password information",
		    $msg, $EMAIL_FROM);
	}

	db_free($result);
	db_disconnect();

	header('Location: reminder.php');
	exit;
}
?>

<html>
 <head>
  <title><?php $title?></title>
  <link rel="stylesheet" type="text/css" href="site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('header.php'); ?>
  <br />
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
   <tr>
    <td align="center">
     <form method="post" action="<?php $PHP_SELF?>">
      <table align="center" border="0" cellpadding="1" cellspacing="0">
       <tr>
        <td align="center" class="huge" colspan="2"><b><?php $title?></b></td>
       </tr>
       <tr><td colspan="2">&nbsp;</td></tr>
       <tr>
        <td align="right" class="big"><b>Your Username:&nbsp;</b></td>
        <td class="big"><input type="text" name="username" size="32"></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td class="big"><input type="submit" name="submit" value=" Send Reminder "></td>
       </tr>
      </table>
     </form>
    </td>
    <td>&nbsp;</td>
   </tr>
   <tr><td>&nbsp;</td></tr>
   <tr>
    <td align="center" class="small" colspan="2"><i><?php include('footer.php'); ?></i></td>
   </tr>
  </table>
 </body>
<html>
