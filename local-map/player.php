<?php
require "../db_access/db.php";
require "connect.php";
$playerid;
$moveCostFood=100;
$moveCostPower=50;
/*$food=$water=$power=$metal=$wood;
$food_regen=$water_regen=$power_regen=$metal_regen=$wood_regen;
*/
function getStats(){
	global $dbconn;
	
	connect();
	$playerid = 2; // $_SESSION["tek_emailid"];
	setTable("player");

	$query = "SELECT faction,food,food_regen,water,water_regen,power,power_regen,metal,metal_regen,wood,wood_regen,total FROM player 
	WHERE tek_emailid=".$playerid.";";
	
	$res = mysqli_query($dbconn,$query);
	$res = mysqli_fetch_assoc($res);	

	//exiting
	setTable("grid");
	disconnect();
	return($res);
}

function maxOf($x,$y)    //finds the greater of the two numbers
{
	if($x>$y)
		return $x;
	else
		return $y;
}
function deductResource($resource,$value)   //use to reduce resource on some action give resource name and value  resp.
{
	$sql="UPDATE `player` SET $resource='$value' WHERE tek_emailid=$playerid";	
	if($conn->query($sql)===false)
	{
		echo "error: ".$conn->error;
	}
}
function move($srcRow,$srcCol,$destRow,$destCol)
{
	$distance=maxOf(abs($srcRow-$destRow),abs($srcCol-$destCol));
	$foodCost=$distance*$moveCostFood;
	$powerCost=$distnace*$moveCostPower;
	deductResource("food",$foodCost);
	deductResource("power",$powerCost);  
}
function settle($row,$col) //occupies selected slot ***incomplete***
{
	$root=array(1);
	$row[8];
	$col[8];
	$sql="SELECT row,col,fortification,root FROM grid WHERE (row=$row-1 or row=$row or row=$row+1) and (col=$col-1 or col=$col or col=$col+1);";
	$res=$conn->query($sql);
	if($res->num_rows>0)
	{
		$i=0;
		while($ro=$conn->fetch_assoc())
		{
			if($ro['fortification']>0 and ($ro['row']===$row and $ro['col']===$col))
			{
				$root[$i]=$ro['root'];
			}
		}
	}
	$j=0;
	while($j<$root.count())
	{
		$r=$root[$j];
		$sql="UPDATE grid SET fortification=1,root=$r  WHERE row=$row and col=$col";
		if(!$conn->query($sql) === TRUE)
		{
			echo "error: ".$conn->error;
		}
		$j++;
	}
}	
function getActions($row,$col)
{
	$sql="SELECT * FROM grid WHERE row=$row and col=$col;";
	$res=$conn->query($sql);
	$fortification=0;
	$occupant="0";
	$faction="1";
	if($res->num_rows>0)
	{
		while($row = $res->fetch_assoc())
		{

		}
	}
}
?>
