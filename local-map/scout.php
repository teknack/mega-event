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
	$slot=getSlot($row,$col); //contains occupied,fortification,troops,faction
	
	if ($slot["occupied"] === $_SESSION["tek_emailid"])
	{
		alert("This is your own territory \n check your console");
	}
	else
	{
		alert("Check your console");
	}
		
	consoleLog("Occupied : ".$slot["occupied"]);
	consoleLog("Fortification : ".$slot["fortification"]);
	consoleLog("Troops : ".$slot["troops"]);
	consoleLog("Faction : ".$slot["faction"]);
}

?>
