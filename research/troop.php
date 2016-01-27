<?php
include "../db_access/db.php";

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


?>
<html>
	<head>
		<title>Research -> Troop Strengthening</title>
	</head>
	
	<body>
		
	</body>
</html>
