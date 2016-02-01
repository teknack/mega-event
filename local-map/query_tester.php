<?php
	include "connect.php";
	$playerid=0;
	$quantity=1;
	$srcRow=1;
	$srcCol=10;
	$destRow=1;
	$destCol=9;
	$val;
	// for($i=0;$i<50;$i++)
	// {
	// 	echo rand(0,100)."<br>";
	// }
	$enemy=2;
	$message=" ohh yeah";
	$sql="UPDATE player SET message='message'+'$message' WHERE tek_emailid=$enemy;";
		if($conn->query($sql)===false)
			echo "error (1270): ".$conn->error;

?>