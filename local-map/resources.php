<?php
include "../db_access/db.php";
//include "../Sid/time_trail.php";

function elapsedTime() //calculates time elapsed since last resource collect - all in seconds
{
	connect();
	setTable("player");
	
	if (!isset($_SESSION["collect_time"]))
	{
		$_SESSION["collect_time"] = fetch($_SESSION["tek_emailid"],"collect"); //seconds
	}
	
	$curr_time = time(); //seconds
	$old_time = $_SESSION["collect_time"]; //also in seconds
	
	echo("Last collect: ".floor($old_time/60)." Minutes<br>");
	echo("Now: ".floor($curr_time/60)." Minutes<br>");

	$diff = $curr_time - $old_time;
	
	if ($diff < 60)
	{
		echo("Time Diff: ".$diff." Seconds<br>");
	}
	else
	{
		echo("Time Diff: ".floor($diff/60)." Minutes<br>");
	}
	
	disconnect();
	return($diff);
}

$diff_min = floor(elapsedTime()/60);
if ($diff_min >= 60)
{
	$_SESSION["collect_time"]=time();
}
else
{
	$_SESSION["collect_time"]= 60*floor(time()/60); //sets time to the last whole minute, converts to minute, floors it and then returns to seconds
}

//Fetch current resources
$playerid = $_SESSION["tek_emailid"];

connect();
setTable("player");
$query = "SELECT faction,food,food_regen,water,water_regen,power,power_regen,metal,metal_regen,wood,wood_regen,total FROM player 
WHERE tek_emailid='".$playerid."';";
$res = mysqli_query($dbconn,$query);
$res = mysqli_fetch_assoc($res);

$food_regen = $res["food_regen"];
$water_regen = $res["water_regen"];
$power_regen = $res["power_regen"];
$wood_regen = $res["wood_regen"];
$metal_regen = $res["metal_regen"];

$food = $res["food"] + floor($food_regen * $diff_min);
$water = $res["water"] + floor($water_regen * $diff_min);
$power = $res["power"] + floor($power_regen * $diff_min);
$wood = $res["wood"] + floor($wood_regen * $diff_min);
$metal = $res["metal"] + floor($metal_regen * $diff_min);
echo $food;
echo $metal;
echo $water;
echo $wood;
echo $power;
update("food",$food,"tek_emailid='".$playerid."'");
update("wood",$wood,"tek_emailid='".$playerid."'");
update("water",$water,"tek_emailid='".$playerid."'");
update("power",$power,"tek_emailid='".$playerid."'");
update("metal",$metal,"tek_emailid='".$playerid."'");
update("collect",$_SESSION["collect_time"],"tek_emailid='".$playerid."'");

alert("Done");
redirect("index.php");
?>
