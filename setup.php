<?php
/*
 * Setup.php 
 * Used for newcomers only.
 * i.e. if the player doesn't exist in the "player" table, he/she isnt in the game... yet >:D
 * 
 * Initial Regen values and starting values are set here
 * Faction is chosen here
 */ 

include "./db_access/db.php";
alert($_SESSION["tek_emailid"]);
var_dump($_SESSION);
connect();
setTable("player");
if (checkPlayerExists($_SESSION["tek_emailid"],"player")) //does a check to see if player has aready picked a faction
{
	$faction = fetch($_SESSION["tek_emailid"],"faction");
	if ($faction == "1" || $faction == "2")
	{
		alert("You already exist in the game, go back and play :P");
		redirect("./index.php");
	}
}
disconnect();

if (isset($_POST) && !empty($_POST)) //creates player and sets faction before redirecting to index.php
{
	connect();
	setTable("player");
	if(isset($_POST["faction1"]))
	{
		alert("you have picked faction 1");
		insert("tek_emailid,faction,collect","'".$_SESSION["tek_emailid"]."',1,".time()); //set current time as "collect" value in db
		$_SESSION["collect_time"] = time();
		$_SESSION["faction"] = "1";
		
		if (!checkPlayerExists($_SESSION["tek_emailid"],"research")) //includes player in reseach table
		{
			setTable("research");
			insert("playerid",$_SESSION["tek_emailid"]);
		}
		
		disconnect();
		redirect("world-map/canvas1.html");
	}
	else if (isset($_POST["faction2"])) //same as above
	{
		alert("you have picked faction 2");
		insert("tek_emailid,faction,collect","'".$_SESSION["tek_emailid"]."',2,".time());
		$_SESSION["collect_time"] = time();
		$_SESSION["faction"] = "2";
		
		if (!checkPlayerExists($_SESSION["tek_emailid"],"research"))
		{
			setTable("research");
			insert("playerid",$_SESSION["tek_emailid"]);
		}
		
		disconnect();
		redirect("world-map/canvas1.html");
	}
	else
	{
		alert("lolwut");
	}
}
?>
<html>
	<head>
		<title>Welcome!</title>
	</head>
	
	<body>
		<div id="top" align="center">
			Welcome to the Mega Event
		</div>
		<hr>
		<div id="content" align="center">
			The world is a bleak place, and as is humanity's tendency, people started to band together, forming communities and gathering resources to rebuild some semblance of the previous modern society.<br>
			Weeks pass. Some groups dissolve due to internal strife, some groups merged together with others.<br>
			<b>However</b><br>
			Two main groups surface, two factions which overshadowed the other minor factions - either adding them to their faction, or annhilating them.<br>
			It is up to you to choose who you wish to join and support. In this battle between factions, your role could be pivotal...<br>
		</div>
		<div style="float:left">
			<h4>Faction 1</h4>
			<form action="" method="POST">
				<button type="submit" name="faction1">Faction 1</button>
		</div>
		<div style="float:right">
			<h4>Faction 2</h4>
			<button type="submit" name="faction2">Faction 2</button>
			</form>
		</div>
	</body>
</html>
