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

connect();
setTable("player");
if (checkPlayerExists($_SESSION["tek_emailid"],"player"))
{
	alert("You already exist in the game, go back and play :P");
	redirect("./index.php");
}
else
{
	insert("tek_emailid",$_SESSION["tek_emailid"]);
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
		</div>
		<div style="float:right">
			<h4>Faction 2</h4>
		</div>
	</body>
</html>
