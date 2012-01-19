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
# $srp: godealertodealer.com/htdocs/auction/header.php,v 1.18 2003/02/11 00:35:31 steve Exp $
#

$result = db_do("SELECT COUNT(*) FROM dealers WHERE status='active'");
list($num_users) = db_row($result);
db_free($result);

$result = db_do("SELECT COUNT(*) FROM auctions WHERE status='open'");
list($num_auctions) = db_row($result);
db_free($result);

$result = db_do("SELECT COUNT(*) FROM vehicles WHERE status='active'");
list($num_vehicles) = db_row($result);
db_free($result);
?>

<html>
 <head>
<?php if ($PHP_SELF == '/auction/auction.php') { ?>
  <meta http-equiv="Pragma" content="no-cache">
<?php } ?>
  <title><?=$page_title?></title>
  <link rel="stylesheet" type="text/css" href="/site.css" title="site" />
  <script type="text/javascript" language="JavaScript">
<!--
function goElsewhere(there) {
	window.location = there;
}
//-->
  </script>

<script language="JavaScript" type="text/JavaScript">
function ChooseMenu(targ,selObj,restore){
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;}
</script>

<script language="Javascript1.2"> 
var check = 1800;

function countDown(){ 
	var minute=Math.ceil(check/60);
	if (check>0) {
		check--;
	}
	session_time.innerHTML = (" (min. left: "+minute+")");
	setTimeout("countDown()",1000);		
} 

function resetCounter() {
	check=1800;
	setTimeout("countDown()",1000);
}
</script>


 </head>
 <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <map name="logo_map"><area shape="rect" coords="30,30,313,69" href="/auction/"></map>
  <table border="0" cellspacing="0" cellpadding="0" width="100%">
   <tr> 
    <td>
     <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr> 
       <td><img src="/images/i1.gif" height="78" width="738" border="0" usemap="#logo_map" /></td>
       <td width="100%" background="/images/i2.gif" />&nbsp;</td>
      </tr>
     </table>
     <table bgcolor="#000066" border="0" cellspacing="0" cellpadding="3" width="100%">
      <tr>
       <td width="20%"><font color="#FFFFFF" size="-1"><?php echo date("M j, Y g:i A T"); ?></font></td>
       <td align="center" class="menu" width="60%"><font color="#FFFFFF">
        [&nbsp;<a class="menu" href="/auction/index.php">HOME</a>&nbsp;|
        <a class="menu" href="/auction/menu.php">CONTROL PANEL</a>&nbsp;|
        <a class="menu" href="/auction/feedback.php">CONTACT US</a>&nbsp;|
        <a class="menu" href="/auction/logout.php">LOGOUT</a>&nbsp;]
        </font></td>
       <td align="right" width="20%"><font color="#FFFFFF" size="-1">Logged in as <?=$username?>
	   	<script language="Javascript1.2"> 
		document.write('<span id="session_time"></span><br>');
		</script>
		</font></td>
      </tr>
     </table>
     <table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="5" width="100%">
      <tr>
       <td class="normal" valign="top" nowrap>
        <form action="/auction/search.php" method="post">
         <input type="text" name="q" value="<?php echo $q; ?>" size="15">&nbsp;<input type="submit" name="submit" value="Search"><br />
         <a href="/auction/advsearch.php">Advanced Search</a>
        </form>
       </td>
       <td valign="top">
        <form action="/auction/browse.php" method="GET">
         <select NAME="id">
          <option value="0">All categories</option>
<?php
$result = db_do("SELECT id, name FROM categories WHERE parent_id='0' AND " .
    "deleted='0' ORDER BY name");
while (list($a, $b) = db_row($result))
	echo "          <option value=\"$a\">$b</option>\n";
db_free($result);
?>
         </select>&nbsp;<input type="submit" value="Browse">
        </form>
       </td>
       <td align="right" valign="top"><font size="-1"><b><?=$num_users?></b> <font size="-2">DEALERS</font> | <b><?=$num_auctions?></b> <font size="-2">AUCTIONS</font> | <b><?=$num_vehicles?></b> <font size="-2">VEHICLES</font></font></td>
      </tr>
      <tr> 
      </tr>
     </table>
<?php if (!$no_menu) { ?>
     <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr valign="top">
       <td bgcolor="#EEEEEE" width="20%">
       </td>
       <td>
<?php } ?>