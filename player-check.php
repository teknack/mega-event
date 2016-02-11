<?php
/*
 * used to decide if plyaer exists in the game yet or no
 */

include "./db_access/db.php";

if (checkPlayerExists($_SESSION["tek_emailid"],"player"))
{
	$_SESSION["faction"] = getFaction($_SESSION["tek_emailid"]);
	redirect("./world-map/canvas1.html");
}
else
{
	alert("setting you up!");
	redirect("./setup.php");
}

?>
