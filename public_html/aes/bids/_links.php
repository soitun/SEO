

<?php

if(!empty($_REQUEST['did']))
	$did = $_REQUEST['did'];
else
	$did = "";



?>

<p align="center" class="normal">[ <a href="index.php?did=<?php $did?>"> Bids for Open Auctions</a> | <a href="won.php?did=<?php $did?>">Bids for Auctions Won</a> | <a href="all.php?did=<?php $did?>">All Bids</a> ]</p>
