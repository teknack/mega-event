<?php
/*
 * Research
 * allows to increase level and explore more things
 * 
 * research types:
 * - Troop Strength [Strength of troop doubles -> double the number of troops trained]
 * - Fortification level
 * - Aquatic Civilization
 * - Improved Crop Harvest
 * - Improved Water gathering
 * - Improved Wood 
 * - Improved Metal
 * - Improved 
 */

if (isset($_POST) && !empty($_POST))
{
	if (isset($_POST["troop_strength"]))
	{
		redirect("troop.php");
	}
	else if (isset($_POST["fortification"]))
	{
		redirect("fortification.php");
	}
}

?>
<html>

	<head>
		<title>Research</title>
	</head>

	<body>
		<div id="top">
			Research
		</div>
		<hr>
		<div id="content">
			<form action="" method="POST">
			<div class="item">
				<div style="float:left">
					Troop Strength
				</div>
				<div style="float:right">
					<button type="submit" name="troop_strength">Upgrade</button>
				</div>
			</div>
			<br>
			<br>
			<div class="item">
				<div style="float:left">
					City Fortification
				</div>
				<div style="float:right">
					<button type="submit" name="fortification">Upgrade</button>
				</div>
			</div>
			</form>
		</div>
	</body>
	
</html>
