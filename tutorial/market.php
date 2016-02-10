<?php
include "../db_access/db.php";
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
			<b>Gold : 100</b>
			<center>
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
						<td>10</td>
					</tr>
					<tr>
						<td>Food</td>
						<td align="center">5</td>
						<td><input name="food_quant" id="food_quant" type="number" placeholder="amount of food"/></td>
						<td>10</td>
					</tr>
					<tr>
						<td>Water</td>
						<td align="center">5</td>
						<td><input name="water_quant" id="water_quant" type="number" placeholder="amount of water"/></td>
						<td>20</td>
					</tr>
					<tr>
						<td>Metal</td>
						<td align="center">5</td>
						<td><input name="metal_quant" id="metal_quant" type="number" placeholder="amount of metal"/></td>
						<td>10</td>
					</tr>
					<tr>
						<td>Power</td>
						<td align="center">5</td>
						<td><input name="power_quant" id="power_quant" type="number" placeholder="amount of power"/></td>
						<td>20</td>
					</tr>
				</table>
				<br>
				<center>
					<button name="buy" type="submit">Buy</button> <button name="sell" type="submit">Sell</button>
				</center>
			</center>
		</div>
		<hr>
		<div id="Explanation">
			This is a <b>PLAYER-DRIVEN</b> market.<br>
			<ul>
			<li>This means that, whatever you and other players do, change the exchange rate of the goods.</li>
			<li>The <i>gold</i> that you see on the top left is actually the number of points you scored in other events (initially, it will be 0).</li>
			<li>This means that if you want to trade, you better start playing the other games as well.</li>
			<li>The Inventory column displays the resources you currently have collected</li>
			</ul>
		</div>
	</body>
</html>
