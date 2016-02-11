<?php
require "../db_access/db.php";
require "connect.php";
$playerid=$_SESSION['tek_emailid'];
$faction=$_SESSION['faction'];
if(!isset($_SESSION['faction']))
	$_SESSION['faction']=getFaction($playerid);
$size=9;



if(isset($_GET['row']) and isset($_GET['col']))
{
	map($_GET['row'],$_GET['col']);
	//map(25,50);
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
		if($fortification!=0)
		{
			$troops=0;
		}
		else //for searching unoccupied slots with player troops
		{
			$row=$r['row'];
			$col=$r['col'];
			$sql="SELECT quantity FROM troops WHERE row=$row and col=$col and playerid='$playerid';";
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

	$sql="SELECT * FROM player WHERE tek_emailid='$playerid'";
	$res=$conn->query($sql);
	$r=$res->fetch_assoc();
	$food=$r['food'];
	$foodRegen=$r['food_regen'];
	$water=$r['water'];
	$waterRegen=$r['water_regen'];
	$power=$r['power'];
	$powerRegen=$r['power_regen'];
	$metal=$r['metal'];
	$metalRegen=$r['metal_regen'];
	$wood=$r['wood'];
	$woodRegen=$r['wood_regen'];
	$output.='{"player":"'.$playerid.'","faction":"'.$faction.'","food":"'.$food.'","foodr":"'.$foodRegen.'","water":"'.$water.'",
               "waterr":"'.$waterRegen.'","power":"'.$power.'","powerr":"'.$powerRegen.'","metal":"'.$metal.'","metalr":"'.$metalRegen.'",
               "wood":"'.$wood.'","woodr":"'.$woodRegen.'"}]';
	echo $output;
}
