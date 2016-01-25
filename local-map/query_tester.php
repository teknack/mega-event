<?php
	include "connect.php";
	$playerid=0;
	$quantity=1;
	$srcRow=0;
	$srcCol=8;
	$destRow=0;
	$destCol=10;
	$sql="INSERT INTO troops (row,col,playerid,quantity) VALUES ($destRow,$destCol,$playerid,$quantity);"
	/*UPDATE grid SET troops=troops-$quantity WHERE row=$srcRow and col=$srcCol;"*/;//add query
	if($conn->query($sql)===false)
		echo "no go : ".$conn->error;
	else
		echo "good to go";

?>