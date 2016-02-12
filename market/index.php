<?php
/*
 * Market
 * Player-based economy
 * DEMAND AND SUPPLY, BITCHACHOS!
 */
include "../common-code.php"; //contains db.php
harvest($_SESSION["tek_emailid"]);
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
		$costs["food"] = foodCost($_POST["food_quant"]);
		$costs["wood"] = woodCost($_POST["wood_quant"]);
		$costs["water"] = waterCost($_POST["water_quant"]);
		$costs["power"] = powerCost($_POST["power_quant"]);
		$costs["metal"] = metalCost($_POST["metal_quant"]);
		$_SESSION["costs"] = $costs;
		redirect("sell.php");
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
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial scale=1">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	    <link rel="stylesheet" type="text/css" href="../maincss/mainstyle.css">
	    <link rel="stylesheet" type="text/css" href="./market.css">
	</head>

	<body>

		<nav class="navbar">
			<div class="container-fluid">

				<!-- Menu items -->
				<div>
								
					<!-- Menu right items -->
					<ul class="nav nav-tabs navbar-nav navbar-right">
						<li><a href="../local-map/index.php">Local</a></li>
						<li class="active"><a href="#">Market</a></li>
						<li><a href="#">Research</a></li>
						<li><a href="../local-map/resources.php">Collect</a></li>
						<li><a href="../world-map/canvas1.html">World Map <span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a></li>
					</ul>
				</div>
			</div>
		</nav>

		<!--Heading and Gold part -->
		<div class="container">	

			<div class="row">			
				<div class="page-header">
				<h1>Marketplace</h1>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3 pull-right">
					<h3 style="color: #fefeb0; font-family: Georgia;">Gold: <?php getGold() ?></h3>
				</div>
				<div class="inner-wrapper col-md-6 col-md-offset-3">
					<div class="form-group">
						<form action="" method="POST">
							<table class="table">
								<thead>
									<tr>
										<th>Resource</th>
										<th>Cost (gold per unit)</th>
										<th>Amount</th>
										<th>Inventory</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="col-md-1">Wood</td>
										<td class="col-md-1"><?php echo(round(woodCost(),2)) ?></td>
										<td class="col-md-1"><input class="form-control input-lg" name="wood_quant" type="number"/></td>
										<td class="col-md-1"><?php echo(fetch($_SESSION["tek_emailid"],"wood"))?></td>
									</tr>
									<tr>
										<td class="col-md-1">Food</td>
										<td class="col-md-1"><?php echo(round(foodCost(),2)) ?></td>
										<td class="col-md-1"><input class="form-control input-lg" name="food_quant" type="number"/></td>
										<td class="col-md-1"><?php echo(fetch($_SESSION["tek_emailid"],"food"))?></td>
									</tr>
									<tr>
										<td class="col-md-1">Water</td>
										<td class="col-md-1"><?php echo(round(waterCost(),2)) ?></td>
										<td class="col-md-1"><input class="form-control input-lg" name="water_quant" type="number"/></td>
										<td class="col-md-1"><?php echo(fetch($_SESSION["tek_emailid"],"water"))?></td>
									</tr>
									<tr>
										<td class="col-md-1">Power</td>
										<td class="col-md-1"><?php echo(round(powerCost(),2)) ?></td>
										<td class="col-md-1"><input class="form-control input-lg" name="power_quant" type="number"/></td>
										<td class="col-md-1"><?php echo(fetch($_SESSION["tek_emailid"],"power"))?></td>
									</tr>
									<tr>
										<td class="col-md-1">Metal</td>
										<td class="col-md-1"><?php echo(round(metalCost(),2)) ?></td>
										<td class="col-md-1"><input class="form-control input-lg" name="metal_quant" type="number"/></td>
										<td class="col-md-1"><?php echo(fetch($_SESSION["tek_emailid"],"metal"))?></td>
									</tr>
								</tbody>
							</table>	
						
							<button type="submit" class="btn btn-default btn-lg col-md-2 col-md-offset-3" name="buy"><b>Buy</b></button>
							<button type="submit" class="btn btn-default btn-lg col-md-2 col-md-offset-1" name="sell"><b>Sell</b></button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>

</html>
