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
	$message="0:1:5:2:4:";
	$message=explode(":", $message);
	for($i=0;$i<count($message);$i++)
	{
		echo $message[$i]."<bR>";
	}
?>