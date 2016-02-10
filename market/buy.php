<?php
include "../db_access/db.php";

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
		$wood_demand = $wood_demand + 1;
	}
	else
	{
		$wood_demand = $wood_demand + floor($values["wood_quant"]/50);
	}
	
	//$player["wood"] = $player["wood"] + $values["wood_quant"];
	
	//setTable("market");
	//update("wood_demand",$wood_demand,"id=1");
}

if ($values["water_quant"] > 0)
{
	if ($values["water_quant"] < 50)
	{
		$water_demand = $water_demand + 1;
	}
	else
	{
		$water_demand = $water_demand + floor($values["water_quant"]/50);
	}
	
	//update("water_demand",$water_demand,"id=1");
}

if ($values["metal_quant"] > 0)
{
	if ($values["metal_quant"] < 50)
	{
		$metal_demand = $metal_demand + 1;
	}
	else
	{
		$metal_demand = $metal_demand + floor($values["metal_quant"]/50);
	}
	
	//update("metal_demand",$metal_demand,"id=1");
}

if ($values["power_quant"] > 0)
{
	if ($values["power_quant"] < 50)
	{
		$power_demand = $power_demand + 1;
	}
	else
	{
		$power_demand = $power_demand + floor($values["power_quant"]/50);
	}
	
	//update("power_demand",$power_demand,"id=1");
}

if ($values["food_quant"] > 0)
{
	if ($values["food_quant"] < 50)
	{
		$food_demand = $food_demand + 1;
	}
	else
	{
		$food_demand = $food_demand + floor($values["food_quant"]/50);
	}
	
	//update("food_demand",$food_demand,"id=1");
}

disconnect();

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
	update("wood",fetch($_SESSION["tek_emailid"],"wood")+floor($values["wood_quant"]),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("food",fetch($_SESSION["tek_emailid"],"food")+floor($values["food_quant"]),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("water",fetch($_SESSION["tek_emailid"],"water")+floor($values["water_quant"]),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("power",fetch($_SESSION["tek_emailid"],"power")+floor($values["power_quant"]),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("metal",fetch($_SESSION["tek_emailid"],"metal")+floor($values["metal_quant"]),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("gold",fetch($_SESSION["tek_emailid"],"gold")-floor(getTotal()),"tek_emailid='".$_SESSION["tek_emailid"]."'");
	disconnect();
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
					if ($_SESSION["gold"] < getTotal())
					{
						echo("INSUFFICIENT FUNDS");
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
<?php
unset($_SESSION["values"]);
unset($_SESSION["costs"]);
?>
