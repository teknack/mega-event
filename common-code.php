<?php
/* TO BE FINISHED
 * Code To update Mega event score table, please do not modify unless you speak to someone from mega event team
 * Tank you :D 
 */
include "./db_access/db.php"; //REMINDER : change this path during final deployment
 
function ($gamename,$score,$player)
{
	connect();
	
	setTable("CommonTable");
	
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
		
		update($colname,$new_val,"tek_emailid=".$player);
	}
	else
	{
		insert($colname,$val);
	}
	
	disconnect();
}

function getScores() //may not be needed
{
	connect();
	setTable("CommonTable");
	disconnect();
}

function harvest($player) //may not be needed
{
	$scores = getScores(); //returns assoc array with scores from each event
}
?>
