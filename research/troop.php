<?php
include "../db_access/db.php";

function getCost($level)
{
	switch($level)
	{
		case 1:
		echo("Wood: <br>");
		echo("Food: <br>");
		echo("
		break;
		
		case 2:
		break;
		
		case 3:
		break;
		
		case 4:
		break;
	}
}

connect();

setTable("research");

//get current level
$troop_level = fetch($_SESSION["tek_emailid"],"troop_strength");

setTable("player");
//get wood
$wood = fetch($_SESSION["tek_emailid"],"wood");
//get food
$food = fetch($_SESSION["tek_emailid"],"food");
//get energy
$energy = fetch($_SESSION["tek_emailid"],"energy");
//get water
$water = fetch($_SESSION["tek_emailid"],"water");
//get metal
$metal = fetch($_SESSION["tek_emailid"],"metal");

switch($troop_level)
{
	case 0:
	break;
	
	case 1:
	break;
	
	case 2:
	break;
	
	case 3:
	break;
}

?>
<html>
	<head>
		<title>Research -> Troop Strengthening</title>
	</head>
	
	<body>
		<div id="top">
			<h1>Troop Strengthening Research</h1>
		</div>
		<div id="content">
		Level: <?php echo($troop_level); ?><br>
		Next Level:
			
		</div>
	</body>
</html>
