<?php


$playerid;
/*$food=$water=$power=$metal=$wood;
$food_regen=$water_regen=$power_regen=$metal_regen=$wood_regen;
*/
function getStats(){
	global $playerid, $dbconn;
	
	connect();
	$playerid = 2; // $_SESSION["tek_emailid"];
	setTable("player");

	$query = "SELECT faction,food,food_regen,water,water_regen,power,power_regen,metal,metal_regen,wood,wood_regen,total FROM player WHERE tek_emailid=".$playerid.";";
	
	$res = mysqli_query($dbconn,$query);
	$res = mysqli_fetch_assoc($res);	

	//exiting
	setTable("grid");
	disconnect();
	return($res);
}


?>