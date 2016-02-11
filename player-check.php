<?php
/*
 * used to decide if plyaer exists in the game yet or no
 */

include "./db_access/db.php";
connect();
if (checkPlayerExists($_SESSION["tek_emailid"],"player"))
{
	$_SESSION["faction"] = getFaction($_SESSION["tek_emailid"]);
	disconnect();
	redirect("./world-map/canvas1.html");
}
else
{
	alert("setting you up!");
	disconnect();
	redirect("./setup.php");
}

?>
