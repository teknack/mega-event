<?php

?>
<html>
	
	<head>
		<title>market tutorial</title>
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
						<th>Inventory</th>
					</tr>
					<tr>
						<td>Wood</td>
						<td align="center">5</td>
						<td><input name="wood_quant" id="wood_quant" type="number" placeholder="amount of wood"/></td>
						<td><?php echo(fetch($_SESSION["tek_emailid"],"wood"))?></td>
					</tr>
					<tr>
						<td>Food</td>
						<td align="center">5</td>
						<td><input name="food_quant" id="food_quant" type="number" placeholder="amount of food"/></td>
						<td><?php echo(fetch($_SESSION["tek_emailid"],"food"))?></td>
					</tr>
					<tr>
						<td>Water</td>
						<td align="center">5</td>
						<td><input name="water_quant" id="water_quant" type="number" placeholder="amount of water"/></td>
						<td><?php echo(fetch($_SESSION["tek_emailid"],"water"))?></td>
					</tr>
					<tr>
						<td>Metal</td>
						<td align="center">5</td>
						<td><input name="metal_quant" id="metal_quant" type="number" placeholder="amount of metal"/></td>
						<td><?php echo(fetch($_SESSION["tek_emailid"],"metal"))?></td>
					</tr>
					<tr>
						<td>Power</td>
						<td align="center">5</td>
						<td><input name="power_quant" id="power_quant" type="number" placeholder="amount of power"/></td>
						<td><?php echo(fetch($_SESSION["tek_emailid"],"power"))?></td>
					</tr>
				</table>
				<br>
				<center>
					<button name="buy" type="submit">Buy</button> <button name="sell" type="submit">Sell</button>
				</center>
				</form>
			</center>
		</div>
	</body>
</html>
