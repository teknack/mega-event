<?php
require "../db_access/db.php"

$playerid;
$moveCostFood=100;
$moveCostPower=50;
/*$food=$water=$power=$metal=$wood;
$food_regen=$water_regen=$power_regen=$metal_regen=$wood_regen;
*/
function getStats(){
	global $dbconn;
	
	connect();
	$playerid = 2; // $_SESSION["tek_emailid"];
	setTable("player");

	$query = "SELECT faction,food,food_regen,water,water_regen,power,power_regen,metal,metal_regen,wood,wood_regen,total FROM player 
	WHERE tek_emailid=".$playerid.";";
	
	$res = mysqli_query($dbconn,$query);
	$res = mysqli_fetch_assoc($res);	

	//exiting
	setTable("grid");
	disconnect();
	return($res);
}
function max($x,$y)    //finds the greater of the two numbers
{
	if($x>$y)
		return $x;
	else
		return $y;
}
function deductResource($resource,$value)   //use to reduce resource on some action give resource name and value  resp.
{
	$sql="UPDATE `player` SET $resource='$value' WHERE tek_emailid=$playerid";	
	if($dbconn->query($sql)===false)
	{
		echo "error: ".dbconn->error;
	}
}
function move($srcRow,$srcCol,$destRow,$destCol)
{
	$distance=max(abs($srcRow-$destRow),abs($srcCol-$destCol));
	$foodCost=$distance*$moveCostFood;
	$powerCost=$distnace*$moveCostPower;
	deductResource("food",$foodCost);
	deductResource("power",$powerCost);  
}
function settle() //occupies selected slot ***incomplete***
{
	
}	
?>
