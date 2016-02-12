<?php
	include "../db_access/db.php";
	validate();
	
	//value = 3 + [research]*[percentage]
	$conn = connect();
	
	$query="SELECT civperk2 FROM research WHERE playerid='".$_SESSION["tek_emailid"]."';";
	$res = mysqli_query($conn,$query);
	$res = mysqli_fetch_assoc($res);
	$research_level = $res["civperk2"];
	//echo($research_level);
	
	$battery = $_SESSION["battery"];
	$val = 3 + floor((3+$research_level)*($battery/100));
	$_SESSION["regen_points"] = $val;
	disconnect();
	
	redirect("../local-map/regeneration/regen.php");
?>
