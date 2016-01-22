<?php
	include "connect.php";
	$row=0;
	$col=8;
	$sql="UPDATE grid SET fortification=1 WHERE row=$row and col=$col";//add query
	if($conn->query($sql)===false)
		echo "no go";
	else
		echo "good to go";