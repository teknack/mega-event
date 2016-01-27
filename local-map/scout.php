<?php

function scout($row,$col) //Used to check the details of the column at $row,$col
{
	connect();
	
	setTable("grid");
	
	$slot=getSlot($row,$col);
	
	return($slot);
}

function scoutv2($row,$col)
{
	connect();
	setTable("grid");
	$troops=0;
	$slot=getSlot($row,$col); //contains occupied,fortification,troops,faction
	if($slot['troops']==0)
	{
		echo "here";
		$s=getSlotTroops($row,$col);
		var_dump($s);
		$troops=$s;
		var_dump($troops);
	}
	else
	{
		$troops=$slot['troops'];
	}
	/*
	if ($slot["occupied"] === $_SESSION["tek_emailid"])
	{
		alert("This is your own territory \n check your console");
	}
	else
	{
		alert("Check your console");
	}
	*/
	
	$_SESSION["response"] = "Occupied : ".$slot["occupied"]."<br>"."Fortification : ".$slot["fortification"]."<br>"."Troops : ".$troops."<br>"."Faction : ".$slot["faction"]."<br>";
	consoleLog("Occupied : ".$slot["occupied"]);
	consoleLog("Fortification : ".$slot["fortification"]);
	consoleLog("Troops : ".$slot["troops"]);
	consoleLog("Faction : ".$slot["faction"]);
	header("location:index.php");
}

?>
