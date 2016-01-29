<?php
/*
 * Market
 * Player-based economy
 * DEMAND AND SUPPLY, BITCHACHOS!
 */
include "../db_access/db.php";
$conn = connect();
$demands = array();

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
	return($value);
}

function waterCost($quant=1)
{
	$demand = getDemand("water");
	$_SESSION["water_demand"] = $demand;
	$supply = getSum("water");
	
	$value = ($demand/$supply)*$quant;
	//echo($value."[".$demand."/".$supply."]");
	//echo($value);
	return($value);
}

function foodCost($quant=1)
{
	$demand = getDemand("food");
	$_SESSION["food_demand"] = $demand;
	$supply = getSum("food");
	
	$value = ($demand/$supply)*$quant;
	//echo($value."[".$demand."/".$supply."]");
	//echo($value);
	return($value);
}

function metalCost($quant=1)
{
	$demand = getDemand("metal");
	$_SESSION["metal_demand"] = $demand;
	$supply = getSum("metal");
	
	$value = ($demand/$supply)*$quant;
	//echo($value."[".$demand."/".$supply."]");
	//echo($value);
	return($value);
}

function powerCost($quant=1)
{
	$demand = getDemand("power");
	$_SESSION["power_demand"] = $demand;
	$supply = getSum("power");
	
	$value = ($demand/$supply)*$quant;
	//echo($value."[".$demand."/".$supply."]");
	//echo($value);
	return($value);
}

if (isset($_POST) && !empty($_POST))
{
	if (isset($_POST["buy"]))
	{
		$_SESSION["values"] = $_POST; //unset after use
		$costs["food"] = foodCost($_POST["food_quant"]);
		$costs["wood"] = woodCost($_POST["wood_quant"]);
		$costs["water"] = waterCost($_POST["water_quant"]);
		$costs["power"] = powerCost($_POST["power_quant"]);
		$costs["metal"] = metalCost($_POST["metal_quant"]);
		$_SESSION["costs"] = $costs;
		redirect("buy.php");
	}
	else if (isset($_POST["sell"]))
	{
		$_SESSION["values"] = $_POST; //unset after use
		redirect("sell.php");
	}
	else if (isset($_POST["check"]))
	{
		$_SESSION["values"] = $_POST;
		echo("<script>window.open('check.php')</script>");
	}
	else
	{
		alert("lolwut >_>");
	}
}
?>
<html>

	<head>
		<title>Marketplace</title>
	</head>

	<body>
		<div id="top">
			<h1>Marketplace</h1>
		</div>
		<hr>
		<div id="content">
			<b>Gold : <?php getGold() ?></b>
			<center>
				<form action="" method="POST">
				<table border = 1>
					<tr>
						<th>Resource</th>
						<th>Cost (gold per unit)</th>
						<th>Amount</th>
					</tr>
					<tr>
						<td>Wood</td>
						<td align="center"><?php echo(woodCost()) ?></td>
						<td><input name="wood_quant" id="wood_quant" type="number" placeholder="amount of wood"/></td>
					</tr>
					<tr>
						<td>Food</td>
						<td align="center"><?php echo(foodCost()) ?></td>
						<td><input name="food_quant" id="food_quant" type="number" placeholder="amount of food"/></td>
					</tr>
					<tr>
						<td>Water</td>
						<td align="center"><?php echo(waterCost()) ?></td>
						<td><input name="water_quant" id="water_quant" type="number" placeholder="amount of water"/></td>
					</tr>
					<tr>
						<td>Metal</td>
						<td align="center"><?php echo(metalCost()) ?></td>
						<td><input name="metal_quant" id="metal_quant" type="number" placeholder="amount of metal"/></td>
					</tr>
					<tr>
						<td>Power</td>
						<td align="center"><?php echo(powerCost()) ?></td>
						<td><input name="power_quant" id="power_quant" type="number" placeholder="amount of power"/></td>
					</tr>
				</table>
				<br>
				<center>
					<button name="buy" type="submit">Buy</button> <button name="sell" type="submit">Sell</button> <button name="check" type="submit">Check</button>
				</center>
				</form>
			</center>
		</div>
	</body>

</html>
