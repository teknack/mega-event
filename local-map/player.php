<?php
require "../db_access/db.php"
require "connect.php"
$faction/*=$_SESSION['faction']*/;
$faction=1;	//temporary!! don't forget to remove!!
$playerid/*=$_SESSION['tek_emailid']*/;
$playerid=1; //temporary!! don't forget to remove!! 
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
function max($x,$y)    //finds the greater of the two numbers
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
function move($srcRow,$srcCol,$destRow,$destCol,$quantity) //move works in 2 steps, first select troops from an occupied slot  
{                                                //then select the slot to move the troops to 
	$distance=max(abs($srcRow-$destRow),abs($srcCol-$destCol));
	$foodCost=$distance*$moveCostFood;
	$powerCost=$distance*$moveCostPower;
	deductResource("food",$foodCost);
	deductResource("power",$powerCost);

}
function condenseArray($arr) //removes duplicates and would reduce load on server as little as it already is..
{
	$ar=array();
	$ar[0]=$arr[0];
	$j=1;
	for($i=1;$i<count($arr);$i++)
	{
		//$ar[$j]=$arr[$i];
		//unset($arr[$i]);
		if(array_search($arr[$i],$ar) ===false)
		{
			$ar[$j]=$arr[$i];
			$j++;
		}
	}
	return $ar;
}
function settle($row,$col) //occupies selected slot **incomplete transferring troops from troops table to grid table**
{
	$roots[8];
	$root=$row.",".$col;
	$row[8];
	$col[8];
	$sql="SELECT row,col,fortification,root FROM grid WHERE (row=$row-1 or row=$row or row=$row+1) and (col=$col-1 or col=$col or col=$col+1);";
	$res=$conn->query($sql); //query to get all the neighbouring slots to the given slot.
	if($res->num_rows>0)
	{
		$i=0;
		while($ro=$conn->fetch_assoc())
		{
			if($ro['fortification']>0 and !($ro['row']===$row and $ro['col']===$col))
			{
				$roots[$i]=$ro['root'];
			}
		}
	}
	$roots=condenseArray($roots); //refer line 54
	$j=0;
	while($j<$roots.count()) //sets the root of all neighbouring slots if occupied as the root of the given slot
	{
		$r=$roots[$j];
		$sql="UPDATE grid SET fortification=1,root=$root  WHERE root=$r";
		if(!$conn->query($sql) === TRUE)
		{
			echo "error: ".$conn->error;
		}
		$j++;
	}
}
function getActions($row,$col)  //AJAX FUNCTION!!! **maybe will add action cost with actions**
{
	$sql="SELECT * FROM grid WHERE row=$row and col=$col;";
	$res=$conn->query($sql);
	$sql1="SELECT playerid FROM troops WHERE row=$row and col=$col and playerid=$playerid;";
	$res1=$conn->query($sql1);
	$fortification=0;
	$occupant="0";
	$faction="1";
	$output="[";
	if($res->num_rows>0)
	{
		while($row = $res->fetch_assoc())
		{
			if($row['faction']!=$faction)  //enemy faction
			{
				$output=$output.'{"action":"scout"},{"action":"attack"}]';
			}
			else if($row['faction']==$faction) //allied faction
			{
				if($row['occupant']==$playerid) //player occupied 
				{
					$output=$output.'{"action":"fortify"},{"action":"select troops"}]';		
				}
				else
				{
					if($res1->num_rows>0) //player troops stationed
					{
						$output=$output.'{"action":"settle"},{"action":"select troops"}]'		
					}
					else
						$output=$output.'{"action":"scout"}]';
				}
			}
		}
	}
	echo $output;
}
?>
