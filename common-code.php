<?php
/* TO BE FINISHED
 * Code To update Mega event score table, please do not modify unless you speak to someone from mega event team
 * Tank you :D 
 */
include "./db_access/db.php"; //REMINDER : change this path during final deployment
 
function ($dbconn,$table,$score,$player)
{
	$query = "SELECT ".$colname." FROM ".$table." WHERE tek_emailid='".$_SESSION["tek_emailid"]."';";
	
	$res = mysqli_query($dbconn,$query);
	
	$res = mysqli_fetch_assoc($res);
	
	mysqli_close($dbconn);
	
	connect();
	
	setTable("CommonTable");
	
	if (checkPlayerExists($player,"CommonTable"))
	{
		$val = fetch($player,"CommonTable",$colname);
		
		
	}
	
} 
?>
