<?php
include "../db_access/db.php";
//include "../Sid/time_trail.php";

function elapsedTime() //calculates time elapsed since last resource collect
{
	if (!isset($_SESSION["collect_time"]))
	{
		$_SESSION["collect_time"] = time();
	}
	
	$curr_time = time();
	$old_time = $_SESSION["collect_time"];
	
	echo("Last collect: ".($old_time/60)." Minutes<br>");
	echo("Now: ".($curr_time/60)." Minutes<br>");

	$diff = $curr_time - $old_time;
	
	if ($diff < 60)
	{
		echo("Time Diff: ".$diff);
	}
	else
	{
		echo("Time Diff: ".($diff/60)." Minutes");
	}
	return($diff);
}

$diff_min = floor(elapsedTime()/60);
$_SESSION["collect_time"]=time();

//Fetch current resources
connect();
$playerid = $_SESSION["tek_emailid"];
setTable("player");

$query = "SELECT faction,food,food_regen,water,water_regen,power,power_regen,metal,metal_regen,wood,wood_regen,total FROM player 
WHERE tek_emailid=".$playerid.";";

$res = mysqli_query($dbconn,$query);
$res = mysqli_fetch_assoc($res);

$food_regen = $res["food_regen"];
$water_regen = $res["water_regen"];
$power_regen = $res["power_regen"];
$wood_regen = $res["wood_regen"];

$food = $res["food"] + floor($food_regen * $diff_main);
$water = $res["water"] + floor($water_regen * $diff_min);
$power = $res["power"] + floor($power_regen * $diff_min);
$wood = $res["wood"] + floor($wood_regen * $diff_min);

update("food",$food,"tek_emailid='".$playerid."'");
update("wood",$wood,"tek_emailid='".$playerid."'");
update("water",$water,"tek_emailid='".$playerid."'");
update("power",$power,"tek_emailid='".$playerid."'");
alert("Done");
?>
