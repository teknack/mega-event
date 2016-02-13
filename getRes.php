<?php
/*
 * ajax code for admin-main.php :: do not mess with this code please
 */

include "./db_access/db.php";

function getDemand($resource)
{
	global $conn,$demands;
	
	$query = "SELECT ".$resource."_demand FROM market;";
	$res = mysqli_query($conn,$query);
	$res = mysqli_fetch_assoc($res);
	
	return($res[$resource."_demand"]);
}

function getSum($resource)
{
	global $conn;
	
	$query = "SELECT SUM(".$resource."_regen) FROM player;";
	$res = mysqli_query($conn,$query);
	$res = mysqli_fetch_assoc($res);
	//var_dump($res);
	return($res["SUM(".$resource."_regen)"]);
}

function getGold()
{
	setTable("player");
	echo(fetch($_SESSION["tek_emailid"],"gold"));
	$_SESSION["gold"] = fetch($_SESSION["tek_emailid"],"gold");
}

function woodCost($quant=1)
{
	$demand = getDemand("wood");
	$_SESSION["wood_demand"] = $demand;
	$supply = getSum("wood");
	
	$value = ($demand/$supply)*$quant;
	//echo($value."[".$demand."/".$supply."]");
	//echo($value);
	return(round($value,2));
}

function waterCost($quant=1)
{
	$demand = getDemand("water");
	$_SESSION["water_demand"] = $demand;
	$supply = getSum("water");
	
	$value = ($demand/$supply)*$quant;
	//echo($value."[".$demand."/".$supply."]");
	//echo($value);
	return(round($value,2));
}

function foodCost($quant=1)
{
	$demand = getDemand("food");
	$_SESSION["food_demand"] = $demand;
	$supply = getSum("food");
	
	$value = ($demand/$supply)*$quant;
	//echo($value."[".$demand."/".$supply."]");
	//echo($value);
	return(round($value,2));
}

function metalCost($quant=1)
{
	$demand = getDemand("metal");
	$_SESSION["metal_demand"] = $demand;
	$supply = getSum("metal");
	
	$value = ($demand/$supply)*$quant;
	//echo($value."[".$demand."/".$supply."]");
	//echo($value);
	return(round($value,2));
}

function powerCost($quant=1)
{
	$demand = getDemand("power");
	$_SESSION["power_demand"] = $demand;
	$supply = getSum("power");
	
	$value = ($demand/$supply)*$quant;
	//echo($value."[".$demand."/".$supply."]");
	//echo($value);
	return(round($value,2));
}

$conn = connect();
setTable("market");

echo("".woodCost().",".foodCost().",".waterCost().",".powerCost().",".metalCost()."");
disconnect();
?>
