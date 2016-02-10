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
	
	//$player["wood"] = $player["wood"] - $values["wood_quant"];
	
	//setTable("market");
	//update("wood_demand",$wood_demand,"id=1");
}

if ($values["water_quant"] > 0)
{
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
	
	//update("water_demand",$water_demand,"id=1");
}

if ($values["metal_quant"] > 0)
{
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
	
	//update("metal_demand",$metal_demand,"id=1");
}

if ($values["power_quant"] > 0)
{
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
	
	//update("power_demand",$power_demand,"id=1");
}

if ($values["food_quant"] > 0)
{
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
		<title>Market -> Buy</title>
	</head>

	<body>
		<div id="top">
			<h1>Market -> Buy</h1>
		</div>
		<hr>
		<div id="content">
			<center>
				<table border="1">
					<tr>
						<th>
							Resource
						</th>
						<th>
							Quantity
						</th>
						<th>
							Cost
						</th>
					</tr>
					<tr>
						<tr>
						<td>Wood</td>
						<td><?php echo($values["wood_quant"]) ?></td>
						<td align="center"><?php echo($costs["wood"]) ?></td>
					</tr>
					<tr>
						<td>Food</td>
						<td><?php echo($values["food_quant"]) ?></td>
						<td align="center"><?php echo($costs["food"]) ?></td>
					</tr>
					<tr>
						<td>Water</td>
						<td><?php echo($values["water_quant"]) ?></td>
						<td align="center"><?php echo($costs["water"]) ?></td>
					</tr>
					<tr>
						<td>Metal</td>
						<td><?php echo($values["metal_quant"]) ?></td>
						<td align="center"><?php echo($costs["metal"]) ?></td>
					</tr>
					<tr>
						<td>Power</td>
						<td><?php echo($values["power_quant"]) ?></td>
						<td align="center"><?php echo($costs["power"]) ?></td>
					</tr>
					<tr>
						<th align="center">
							Total
						</th>
						<th>
							
						</th>
						<th align="center">
							<?php echo(getTotal()) ?>
						</th>
					</tr>
				</table>
				<br>
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
				<br>
				<form action="index.php">
					<button type="submit">Return</button>
				</form>
			</center>
		</div>
	</body>

</html>
