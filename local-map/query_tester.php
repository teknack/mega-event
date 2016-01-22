<?php
	include "connect.php";
	$row=0;
	$col=8;
	$row[8];

	$sql="SELECT root FROM grid WHERE (row=$row-1 or row=$row or row=$row+1) and (col=$col-1 or col=$col or col=$col+1);";//add query
	if($conn->query($sql)===false)
		echo "no go : ".$conn->error;
	else
		echo "good to go";
?>