<?php
/* TO BE FINISHED
 * Code To update Mega event score table, please do not modify unless you speak to someone from mega event team
 * Tank you :D 
 */
include "db_access/db.php"; //REMINDER : change this path during final deployment
 
function sendScore($gamename,$score,$player)
{
	connect();
	
	setTable("commontable");
	
	switch($tablename)
	{
		case "into-darkness":
			$colname = "id";
		break;
		
		case "treasure-hunt":
			$colname = "th";
		break;
		
		case "follow-the-route":
			$colname = "ftt";
		break;
		
		case "camouflage":
			$colname = "c";
		break;
		
		case "sixty-seconds":
			$colname = "ss";
		break;
		
		case "reflexe":
			$colname = "r";
		break;
		
		case "KIC-Quiz":
			$colname = "kq";
		break;
		
		case "auction-it":
			$colname = "ai";
		break;
		
		case "acoustica":
			$colname = "acoustica";
		break;
		
		case "snakes":
			$colname = "s";
		break;
		
		case "antivirus":
			$colname = "a";
		break;
		
		case "mugshots":
			$colname = "m";
		break;
	}
	
	if (checkPlayerExists($player,"CommonTable")) //($player,"tek16_megaevent.commontable"))
	{
		$val = fetch($player,$colname);
		
		$new_val = $val + $score;
		
		update($colname,$new_val,"tek_emailid='".$player."'");
	}
	else
	{
		insert($colname,$val);
	}
	
	disconnect();
}

function getScores() //fetch total points 
{
	global $dbconn;
	$check = false;
	if ($dbconn === "")
	{
		connect();
		$check=true;
	}
	
	setTable("CommonTable");//("tek16_megaevent.commontable");
	$scores = fetchAll($_SESSION["tek_emailid"]);

	if ($check === true)
	{
		disconnect();
	}
	
	return($scores);
}

function harvest($player) //return's the "gold"
{
	global $dbconn;
	
	if ($dbconn === "")
	{
		connect();
		$check=true;
	}
	
	$scores = getScores(); //returns assoc array with scores from each event
	
	$sum = $scores["id"] + $scores["th"] + $scores["ftt"] + $scores["c"] + $scores["ss"] + $scores["r"] + $scores["kq"] + $scores["ai"] + $scores["acoustica"] + $scores["s"] + $scores["a"] + $scores["m"];
	
	setTable("player");
	
	$val = fetch($player,"gold");
		
	$new_val = $val + $sum;
	
	update("gold",$new_val,"tek_emailid='".$player."'");
	
	setTable("CommonTable");//("tek16_megaevent.commontable");
	
	/*
	foreach ($scores as $key=>$val)
	{
		update("$key",fetch($_SESSION["tek_emailid"],"$key") - $val,"tek_emailid='".$_SESSION["tek_emailid"]."'");
	}
	*/
	
	update("id",fetch($_SESSION["tek_emailid"],"id") - $scores["id"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("th",fetch($_SESSION["tek_emailid"],"th") - $scores["th"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("ftt",fetch($_SESSION["tek_emailid"],"ftt") - $scores["ftt"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("c",fetch($_SESSION["tek_emailid"],"c") - $scores["c"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("ss",fetch($_SESSION["tek_emailid"],"ss") - $scores["ss"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("r",fetch($_SESSION["tek_emailid"],"r") - $scores["r"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("kq",fetch($_SESSION["tek_emailid"],"kq") - $scores["kq"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("ai",fetch($_SESSION["tek_emailid"],"ai") - $scores["ai"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("acoustica",fetch($_SESSION["tek_emailid"],"acoustica") - $scores["acoustica"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("s",fetch($_SESSION["tek_emailid"],"s") - $scores["s"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("a",fetch($_SESSION["tek_emailid"],"a") - $scores["a"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	update("m",fetch($_SESSION["tek_emailid"],"m") - $scores["m"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	
	if ($check === true)
	{
		disconnect();
	}
}
?>
