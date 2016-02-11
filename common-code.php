<?php
/* TO BE FINISHED
 * Code To update Mega event score table, please do not modify unless you speak to someone from mega event team
 * Tank you :D 
 */
include "./db_access/db.php"; //REMINDER : change this path during final deployment
 
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
	
	if (checkPlayerExists($player,"CommonTable"))
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
	
	if ($dbconn === "")
	{
		connect();
		$check=true;
	}
	
	setTable("CommonTable");
	$scores = fetchAll($_SESSION["tek_emailid"]);

	if ($check === true)
	{
		disconnect();
	}
	
	return($scores);
}

function harvest($player) //may not be needed
{
	global $dbconn;
	
	if ($dbconn === "")
	{
		connect();
		$check=true;
	}
	
	$scores = getScores(); //returns assoc array with scores from each event
	
	$sum = $scores["id"] + $scores["th"] + $scores["ftt"] + $scores["c"] + $score["ss"] + $score["r"] + $score["kq"] + $score["ai"] + $score["acoustica"] + $score["s"] + $score["a"] + $score["m"];
	
	setTable("player");
	
	$val = fetch($player,"gold");
		
	$new_val = $val + $sum;
	
	update("gold",$new_val,"tek_emailid='".$player."'");
	
	setTable("commontable");
	
	foreach ($score as $key => $val)
	{
		update("$key",fetch($_SESSION["tek_emailid"],"$key") - $val,"tek_emailid='".$_SESSION["tek_emailid"]."'");
	}
	
	//update("id",fetch($_SESSION["tek_emailid"],"id") - $score["id"],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	
	if ($check === true)
	{
		disconnect();
	}
}
?>
