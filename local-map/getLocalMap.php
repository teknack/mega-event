<?php
session_start();
require "connect.php";
$playerid=$_SESSION['tek_emailid'];
$faction=1;/*$_SESSION['faction'];*/
$size=9;

if(isset($_GET['row']))
{
	map($_GET['row'],$_GET['col']);
	//map(0,7);
}

function map($row,$col)
{
	global $conn,$playerid,$faction;
	$output='[';
	$sql="SELECT row,col,occupied,fortification,troops,faction FROM grid 
	WHERE row>=$row and row<($row+9) and col>=$col and col<($col+9) ORDER BY row ASC;";
	$res=$conn->query($sql);
	if(!$res)
		echo "error : ".$conn->error;
	while($r=$res->fetch_assoc())
	{
		$row1=$r['row'];
		$col1=$r['col'];	
		$occupied=$r['occupied'];
		$fortification=$r['fortification'];
		$faction1=$r['faction'];
		if($fortification>0)
		{
			$troops=0;
		}
		else //for searching unoccupied slots with player troops
		{
			$row=$r['row'];
			$col=$r['col'];
			$sql="SELECT quantity FROM troops WHERE row=$row and col=$col and playerid=$playerid;";
			$res1=$conn->query($sql);
			if($res1->num_rows>0)
			{
				$occupied=0;
				$fortification=0;
				$faction1=0;
				$r1=$res1->fetch_assoc();
				$troops=$r1['quantity'];
			}
			else
			{
				$occupied=0;
				$fortification=0;
				$faction1=0;
				$troops=0;	
			}
		}
		$output.='{"row":"'.$row1.'","col":"'.$col1.'","occupied":"'.$occupied.'",
		"fortification":"'.$fortification.'","faction":"'.$faction1.'","troops":"'.$troops.'"},';
	}
	$output.='{"player":"'.$playerid.'","faction":"'.$faction.'"}]';	
	echo $output;
}
