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
	$sql="SELECT troops FROM grid WHERE row=$srcRow and col=$srcCol and playerid='$playerid';";
		$res=$conn->query($sql);
		if(!$res)
			echo $conn->error;
		$r=$res->fetch_assoc();
		echo $r;

?>