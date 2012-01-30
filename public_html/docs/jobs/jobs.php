<?php


if(!empty($_REQUEST['city']))
	$city = $_REQUEST['city'];
else
	$city = "";

?>




<?php

include('../../../include/db.php');
db_connect();

if (isset($id)) {

	$result = db_do("SELECT title, description, DATE_FORMAT(modified, '%W %M %e, %Y %l:%i %p') FROM jobs WHERE id='$id'");
	if (db_num_rows($result) == 0) {
		header('Location: index.php');
		exit;
	}
} else
	$result = db_do("SELECT id, title FROM jobs WHERE locations LIKE \"%$city%\"");

$citycaps = ucfirst($city);
?>
<html>
 <head>
  <title>GoDealerToDealer.com :::::: Job Opportunities</title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
<style type="text/css">
<!--
BODY { background: #000000; color: #FFFFFF; }
a:link {font-family:Arial, Helvetica, sans-serif;font-weight: bold;color:#FFFFFF;text-decoration:none;margin-top:0px;margin-bottom:0px;}
a:visited {font-family:Arial, Helvetica, sans-serif;font-weight: bold;color:#FFFFFF;text-decoration:none;margin-top:0px;margin-bottom:0px;}
a:hover {
	text-decoration:underline;
	color:#FF9900;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
//-->
 </style>
 </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../../header.php'); ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td background="../../images/index/4.gif"><img src="../../images/index/3.gif" height="32" width="738" /></td>
		<td width="100%" background="../../images/index/4.gif">&nbsp;</td>
	</tr>
</table>
<?php if (isset($id)) { ?>
	<table border="0" cellpadding="0" cellspacing="0" align="center"  width="450">
		<tr>
			<?php list ($title, $description, $modified) = db_row($result); ?>
			<td align="center" class="huge">
			<?php echo "<b><u>$title</u></b><br><br>"; ?></td>
		</tr>
		<tr>
			<td align="left" class="normal"><br>
			<?php echo "$description<br><br>"; ?><br></td>
		</tr>
		<tr>
			<td align="center" class="normal"><br>
			<?php echo "<font size='6'><a href=\"mailto:jobs@godealertodealer.com?subjectphp $title - $citycaps\">Submit Resume</a></font><br><br><br><br>";
				echo "If you do not have a email application installed on your computer<br>
						Please send your resume to: <u>jobs@godealertodealer.com</u><br>
						and place the job title and city the subject.<br><br>";
				echo "Posted On: $modified<br>"; ?><br></td>
		</tr>
	</table>
<? } else { ?>
	<table border="0" cellpadding="0" cellspacing="0" align="center"  width="100%">
		<tr>
			<td align="center" class="normal">
				<br><b><u>We have the following openings in <?php echo $citycaps; ?>:</u></b><br><br><br>
				<?php while (list ($id, $title) = db_row($result))
					echo "<a href='jobs.php?cityphp $city&idphp $id'>$title</a><br>";?><br><br><br>
			</td>
		</tr>
	</table>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td colspan="2"><img src="../../images/index/6.gif" height="35" width="738" /></td>
		<td background="../../images/index/7.gif" width="100%"></td>
	</tr>
	<tr>
		<td colspan="2"><img src="../../images/index/8.gif" height="68" width="738" /></td>
		<td background="../../images/index/9.gif" width="100%"></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" colspan="3" class="small"><font color="#FFFFFF"><i><?php include('../../footer.php'); ?></i></font></td>
	</tr>
</table>
</body>
</html>
