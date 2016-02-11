<?php
/*
 * Similar mechanism to buy.php, except demand is decreased for each set of 50 units
 */
  
include "../db_access/db.php";

 //check if player refreshes page
 if (!isset($_SESSION["wood_demand"]))
 {
	 redirect("index.php");
 }

function getTotal()
{
	global $costs;
	$total = $costs["power"] + $costs["food"] + $costs["water"] + $costs["metal"] + $costs["wood"];
	return($total);
}

connect();

$values = $_SESSION["values"];
$costs = $_SESSION["costs"];
//var_dump($values);

$wood_demand = $_SESSION["wood_demand"];
$water_demand = $_SESSION["water_demand"];
$metal_demand = $_SESSION["metal_demand"];
$power_demand = $_SESSION["power_demand"];
$food_demand = $_SESSION["food_demand"];
unset($_SESSION["wood_demand"]);
unset($_SESSION["water_demand"]);
unset($_SESSION["metal_demand"]);
unset($_SESSION["power_demand"]);
unset($_SESSION["food_demand"]);

setTable("player");
$player = fetchAll($_SESSION["tek_emailid"]);
setTable("market");

if ($values["wood_quant"] > 0)
{
	if ($wood_demand - $values["wood_quant"] >= 1)
	{
		$wood_demand = $wood_demand - $values["wood_quant"];
	}
	else
	{
		$wood_demand = 1;
	}
	
	/*
	if ($values["wood_quant"] < 50)
	{
		if ($wood_demand -1 >= 1)
		{
			$wood_demand = $wood_demand - 1;
		}
		else
		{
			$wood_demand = 1;
		}
	}
	else
	{
		if (($wood_demand - floor($values["wood_quant"]/50)) >= 1)
		{
			$wood_demand = $wood_demand - floor($values["wood_quant"]/50);
		}
		else
		{
			$wood_demand = 1;
		}
	}
	*/
	//$player["wood"] = $player["wood"] - $values["wood_quant"];
	
	//setTable("market");
	//update("wood_demand",$wood_demand,"id=1");
}

if ($values["water_quant"] > 0)
{
	
	if ($water_demand - $values["water_quant"] >= 1)
	{
		$water_demand = $water_demand - $values["water_quant"];
	}
	else
	{
		$water_demand = 1;
	}
	
	/*
	if ($values["water_quant"] < 50)
	{
		if ($water_demand -1 >= 1)
		{
			$water_demand = $water_demand - 1;
		}
		else
		{
			$water_demand = 1;
		}
	}
	else
	{
		if (($water_demand - floor($values["water_quant"]/50)) >= 1)
		{
			$water_demand = $water_demand - floor($values["water_quant"]/50);
		}
		else
		{
			$water_demand = 1;
		}
	}
	*/
	//update("water_demand",$water_demand,"id=1");
}

if ($values["metal_quant"] > 0)
{
	if ($metal_demand - $values["metal_quant"] >= 1)
	{
		$metal_demand = $metal_demand - $values["metal_quant"];
	}
	else
	{
		$metal_demand = 1;
	}
	
	/*
	if ($values["metal_quant"] < 50)
	{
		if ($metal_demand -1 >= 1)
		{
			$metal_demand = $metal_demand - 1;
		}
		else
		{
			$metal_demand = 1;
		}
	}
	else
	{
		if (($metal_demand - floor($values["metal_quant"]/50)) >= 1)
		{
			$metal_demand = $metal_demand - floor($values["metal_quant"]/50);
		}
		else
		{
			$metal_demand = 1;
		}
	}
	*/
	//update("metal_demand",$metal_demand,"id=1");
}

if ($values["power_quant"] > 0)
{
	if ($power_demand - $values["power_quant"] >= 1)
	{
		$power_demand = $power_demand - $values["power_quant"];
	}
	else
	{
		$power_demand = 1;
	}
	
	/*
	if ($values["power_quant"] < 50)
	{
		if ($power_demand -1 >= 1)
		{
			$power_demand = $power_demand - 1;
		}
		else
		{
			$power_demand = 1;
		}
	}
	else
	{
		if (($power_demand - floor($values["power_quant"]/50)) >= 1)
		{
			$power_demand = $power_demand - floor($values["power_quant"]/50);
		}
		else
		{
			$power_demand = 1;
		}
	}
	*/
	//update("power_demand",$power_demand,"id=1");
}

if ($values["food_quant"] > 0)
{
	if ($food_demand - $values["food_quant"] >= 1)
	{
		$food_demand = $food_demand - $values["food_quant"];
	}
	else
	{
		$food_demand = 1;
	}
	
	/*	
	if ($values["food_quant"] < 50)
	{
		if ($food_demand -1 >= 1)
		{
			$food_demand = $food_demand - 1;
		}
		else
		{
			$food_demand = 1;
		}
	}
	else
	{
		if (($food_demand - floor($values["food_quant"]/50)) >= 1)
		{
			$food_demand = $food_demand - floor($values["food_quant"]/50);
		}
		else
		{
			$food_demand = 1;
		}
	}
	*/
	//update("food_demand",$food_demand,"id=1");
}

disconnect();

function check()
{
	connect();
	setTable("player");
	global $values;
	
	$player_wood = fetch($_SESSION["tek_emailid"],"wood");
	$player_water = fetch($_SESSION["tek_emailid"],"water");
	$player_food = fetch($_SESSION["tek_emailid"],"food");
	$player_metal = fetch($_SESSION["tek_emailid"],"metal");
	$player_power = fetch($_SESSION["tek_emailid"],"power");
	
	if ($values["wood_quant"] >= $player_wood)
	{
		alert("not enough wood");
		return(false);
	}
	else if ($values["food_quant"] >= $player_food)
	{
		alert("not enough food");
		return(false);
	}
	else if ($values["water_quant"] >= $player_water)
	{
		alert("not enough water");
		return(false);
	}
	else if ($values["metal_quant"] >= $player_metal)
	{
		alert("not enough metal");
		return(false);
	}
	else if ($values["power_quant"] >= $player_power)
	{
		alert("not enough power");
		return(false);
	}
	else
	{
		return(true);
	}
}

function proceed()
{
	connect();
	
	global $wood_demand,$water_demand,$metal_demand,$power_demand,$food_demand;
	global $values;
	
	setTable("market");
	update("wood_demand",$wood_demand,"id=1");
	update("water_demand",$water_demand,"id=1");
	update("metal_demand",$metal_demand,"id=1");
	update("power_demand",$power_demand,"id=1");
	update("food_demand",$food_demand,"id=1");
	
	setTable("player");
	update("wood",fetch($_SESSION["tek_emailid"],"wood")-floor($values["wood_quant"]),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("food",fetch($_SESSION["tek_emailid"],"food")-floor($values["food_quant"]),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("water",fetch($_SESSION["tek_emailid"],"water")-floor($values["water_quant"]),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("power",fetch($_SESSION["tek_emailid"],"power")-floor($values["power_quant"]),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("metal",fetch($_SESSION["tek_emailid"],"metal")-floor($values["metal_quant"]),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("gold",fetch($_SESSION["tek_emailid"],"gold")+floor(getTotal()),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	disconnect();
	
	//UNSET ALL THE THINGS!
	unset($_SESSION["values"]);
	unset($_SESSION["costs"]);
	unset($_SESSION["food_demand"]);
	unset($_SESSION["wood_demand"]);
	unset($_SESSION["water_demand"]);
	unset($_SESSION["power_demand"]);
	unset($_SESSION["metal_demand"]);
	unset($_SESSION["food_quant"]);
	unset($_SESSION["power_quant"]);
	unset($_SESSION["wood_quant"]);
	unset($_SESSION["metal_quant"]);
	unset($_SESSION["water_quant"]);
}
?>
<html>

	<head>
		<title>Market -> Sell</title>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width. initial scale=1">

	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	    <link rel="stylesheet" type="text/css" href="../maincss/mainstyle.css">
	    <link rel="stylesheet" type="text/css" href="./market.css">
	</head>

	<body>
		<div class="container">	

			<div class="row">			
				<div class="page-header">
				<h1>Marketplace -> Sell</h1>
				</div>
			</div>

			<div class="row">
				<div class="inner-wrapper col-md-6 col-md-offset-3">
					<div class="form-group">
						
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Resource</th>
										<th>Quantity</th>
										<th>Cost</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="col-md-1">Wood</td>
										<td class="col-md-1"><?php echo($values["wood_quant"]) ?></td>
										<td class="col-md-1"><?php echo($costs["wood"]) ?></td>
									</tr>
									<tr>
										<td class="col-md-1">Food</td>
										<td class="col-md-1"><?php echo($values["food_quant"]) ?></td>
										<td class="col-md-1"><?php echo($costs["food"]) ?></td>
									</tr>
									<tr>
										<td class="col-md-1">Water</td>
										<td class="col-md-1"><?php echo($values["water_quant"]) ?></td>
										<td class="col-md-1"><?php echo($costs["water"]) ?></td>
									</tr>
									<tr>
										<td class="col-md-1">Power</td>
										<td class="col-md-1"><?php echo($values["power_quant"]) ?></td>
										<td class="col-md-1"><?php echo($costs["power"]) ?></td>
									</tr>
									<tr>
										<td class="col-md-1">Metal</td>
										<td class="col-md-1"><?php echo($values["metal_quant"]) ?></td>
										<td class="col-md-1"><?php echo($costs["metal"]) ?></td>
									</tr>
									<tr>
										<th>Total</th>
										<th></th>
										<th><?php echo(getTotal()) ?></th>
									</tr>
								</tbody>
							</table>	
						<h4 class="col-md-offset-4">
							<?php
								if (check() === False)
								{
									echo("INSUFFICIENT RESOURCES");
								}
								else
								{
									proceed();
									echo("TRANSACTION SUCCESSFUL");
								}
							?>
						</h4>
						<form action="index.php" >
							<button type="submit" class="btn btn-default btn-lg col-md-2 col-md-offset-6"><b>Return</b></button>
						</form>
					</div>
				</div>
			</div>

		</div>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>

</html>
<?php
unset($_SESSION["values"]);
unset($_SESSION["costs"]);
?>