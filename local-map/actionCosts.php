<!--
This file is used to store action cost and functions which are used to display
action cost before they are actually performed
 -->


<?php
session_start();
require "actionCostValues.php"; //to get resoruce cost
require "connect.php";
$playerid=$_SESSION['tek_emailid'];
$faction=$_SESSION['faction'];
if(!isset($_SESSION['faction']))
	$faction=2;
$func="possible function values";

function createTroops()
{
	global $createTroopCostFoodBase,$createTroopCostWaterBase,$createTroopCostPowerBase;

	$quantity=$_REQUEST['quantity'];
	$foodCost=$quantity*$createTroopCostFoodBase;
	$waterCost=$quantity*$createTroopCostWaterBase;
	$powerCost=$quantity*$createTroopCostPowerBase;

	echo "Create $quantity soldiers<br>Food:$foodCost<br>Water:$waterCost<br>power:$powerCost<br>";
}

function move()
{
	global $moveCostFood,$moveCostWater,$moveCostPower,$conn,$playerid,$func;
	$destRow=$_REQUEST['row'];
	$destCol=$_REQUEST['col'];
	$srcRow=$_SESSION['selectedRow'];
	$srcCol=$_SESSION['selectedCol'];
	$distance=max(abs($srcRow-$destRow),abs($srcCol-$destCol));
	if($func=="move")
	{
		$sql="SELECT root FROM grid WHERE row=$srcRow and col=$srcCol;"; //the query for root column decide if movement is within
										 //the faction occupied region
		if($res=$conn->query($sql))
		{
			$conn->error;
		}
		if($res->num_rows>0)
		{
			while($row=$res->fetch_assoc())
			{
				$sroot=$row['root'];
			}
		}
		$sql="SELECT root FROM grid WHERE row=$destRow and col=$destCol;";
		if($res=$conn->query($sql))
		{
			$conn->error;
		}
		if($res->num_rows>0)
		{
			while($row=$res->fetch_assoc())
			{
				$droot=$row['root'];
			}
		}
		if($sroot==$droot)
		{
			$distance/=2;
		}
	}
	$foodCost=$distance*$moveCostFood;
	$waterCost=$distance*$moveCostWater;
	$powerCost=$distance*$moveCostPower;
	echo "Move/Attack<br>Food:$foodCost<br>Water:$waterCost<br>Power:$powerCost<br>";
}

function fortify()
{
	global $playerid,$conn,$fortifyWoodCost,$fortifyMetalCost,$fortifyPowerCost;

	$row=$_REQUEST['row'];
	$col=$_REQUEST['col'];
	$sql="SELECT fortification FROM grid WHERE row=$row and col=$col;";
	$res=$conn->query($sql);
	$r=$res->fetch_assoc();
	$fortification=$r['fortification'];
	if ($fortification != "-9")
	{
		$woodCost=$fortifyWoodCost[$fortification-1];
		$metalCost=$fortifyMetalCost[$fortification-1];
		$powerCost=$fortifyPowerCost[$fortification-1];
		echo "Fortify<br>Wood:$woodCost<br>Metal:$metalCost<br>Power:$powerCost<br>";
	}
}

function settle()
{
	global $settleWoodCost,$settleMetalCost,$settlePowerCost;

	echo "Settle<br>Wood:$settleWoodCost<br>Metal:$settleMetalCost<br>Power:$settlePowerCost<br>";
}

function scout()
{
	global $scoutCostFood,$scoutCostWater;

	echo "Scout<br>Food:$scoutCostFood<br>Water:$scoutCostWater";
}

$func=$_REQUEST['action'];
if($func=="settle")
{
	settle();
}
else if($func=="fortify")
{
	fortify();
}
else if($func=="createTroops")
{
	createTroops();
}
else if($func=="move" or $func=="attack")
{
	move();
}
else if($func=="scout")
{
	scout();
}
?>
