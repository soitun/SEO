<?php


/* --not needed here...  $_SESSION is the session variable.  username comes from the session.
if(!empty($_REQUEST['username']))
	$username = $_REQUEST['username'];
else
	$username = "";

if(!empty($_REQUEST['_SESSION']))
	$_SESSION = $_REQUEST['_SESSION'];
else
	$_SESSION = "";
*/



?>



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
# $srp: godealertodealer.com/htdocs/header.php,v 1.2 2002/09/03 00:35:02 steve Exp $
#
?>

<map name="homenav">
 <area shape="rect" coords="32,32,306,64" href="/">
</map>

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


<table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td><img src="/images/i1_dms.gif" height="78" width="738" border="0" ismap usemap="#homenav" /></td>
  <td width="100%" background="/images/i2.gif">&nbsp;</td>
 </tr>
</table>
<table bgcolor="#000066" border="0" cellspacing="0" cellpadding="3" width="100%">
      <tr>
       <td width="20%"><font color="#FFFFFF" size="-1"><?php echo date("M j, Y g:i A T"); ?></font></td>
       <td align="center" class="menu" width="60%"><font color="#FFFFFF">
		[ <a class="menu" href="http://<?php echo $_SERVER['SERVER_NAME']?>/dms/index.php">District Manager Home</a> |
		<a class="menu" href="http://<?php echo $_SERVER['SERVER_NAME']?>/dms/message">Send a Message</a> |
		<a class="menu" href="http://<?php echo $_SERVER['SERVER_NAME']?>/dms/tools">Online Tools</a> |
      <?php
      if ($_SESSION['access_level'] > 2) {
            ?>
            <a class="menu" href="../rms/">Regional Manager Home</a> |
            <?php
      }
      ?>
		<a class="menu" href="http://<?php echo $_SERVER['SERVER_NAME']?>/auction/logout.php">LOGOUT</a> ]</font></td>
       <td align="right" width="20%"><font color="#FFFFFF" size="-1">Logged in as <?php $username?>
	   	<script language="Javascript1.2">
		document.write('<span id="session_time"></span><br>');
		</script>
	   </font></td>
      </tr>
</table>
