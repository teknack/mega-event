<?php
session_start();
require "../db_access/db.php";
require "connect.php";
$faction/*=$_SESSION['faction']*/;
$faction=1;	//temporary!! don't forget to remove!!
$playerid/*=$_SESSION['tek_emailid']*/;
$playerid=1; //temporary!! don't forget to remove!! 
$moveCostFood=100;
$moveCostPower=50;
$isTroopSelected=false;
$quantity=0;
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
/*function max($x,$y)    //finds the greater of the two numbers
{
	if($x>$y)
		return $x;
	else
		return $y;
}*/
function deductResource($resource,$value)   //use to reduce resource on some action give resource name and value resp.
{
	$sql="UPDATE `player` SET $resource='$value' WHERE tek_emailid=$playerid";	
	if($conn->query($sql)===false)
	{
		echo "error: ".$conn->error;
	}
}
function move($srcRow,$srcCol,$destRow,$destCol,$quantity) //move works in 2 steps, first select troops from an occupied slot  
{       		                                           //then select the slot to move the troops to 
	$distance=max(abs($srcRow-$destRow),abs($srcCol-$destCol));
	$sroot="x,y";
	$droot="x,z";
	$sql="SELECT root FROM grid WHERE row=$srcRow and col=$srcCol;"; //the query for root column decide if movement is within 
	if($res->num_rows>0)											 //the faction occupied region 
	{
		while($row=$res->fetch_assoc())
		{
			$sroot=$row['root'];
		}
	}
	$sql="SELECT root FROM grid WHERE row=$destRow and col=$destCol;";
	if($res->num_rows>0)
	{
		while($row=$res->fetch_assoc())
		{
			$droot=$row['root'];
		}
	}
	if($sroot==$droot)
	{
		$distance/=2;
	}
	$foodCost=$distance*$moveCostFood;
	$powerCost=$distance*$moveCostPower;
	$sql="SELECT occupant FROM grid WHERE row=$srcRow and col=$srcCol and troops>0;";
	$res=$conn->query($sql);
	if($res->num_rows>0)  //player moving from settled slot to unoccupied slot
	{
		$row=$res->fetch_assoc();
		if($row['occupant']==$playerid)
		{
			$sql="INSERT INTO troops (row,col,playerid,quantity) VALUES ($destRow,$destCol,'$playerid',$quantity);
				  UPDATE grid SET troops=troops-$quantity WHERE row=$srcRow and col=$srcCol;";
			if($conn->query($sql)==false)
				echo "error : ".$conn->error;
			deductResource("food",$foodCost);
			deductResource("power",$powerCost);
		}
	}
	else //player moving from stationed troops
	{
		$sql="UPDATE grid SET troops=troops-$quantity WHERE row=$srcRow and col=$srcCol;
			  UPDATE grid SET troops=troops+$quantity WHERE row=$destRow and col=$destCol;";
		if($conn->query($sql)==false)
			echo "error : ".$conn->error;
		deductResource("food",$foodCost);
		deductResource("power",$powerCost);
	}
	unset($_SESSION['selectedRow']);
	unset($_SESSION['selectedCol']);
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
	$troopCount;
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
	$sql="SELECT quantity FROM troops WHERE row=$row and col=$col and playerid=$playerid;"; //find number of troops already stationed
	$res=$conn->query($sql); //query to get all the neighbouring slots to the given slot.
	if($res->num_rows>0)
	{
		while($ro=$conn->fetch_assoc())
		{
			$troopCount=$ro['quantity'];
		}
	}
	$roots=condenseArray($roots); //refer line 54
	$j=0;
	while($j<$roots.count()) //sets the root of all neighbouring slots if occupied as the root of the given slot
	{
		$r=$roots[$j];
		$sql="UPDATE grid SET fortification=1,root=$root,troops=$troopCount  WHERE root=$r";
		if(!$conn->query($sql) === TRUE)
		{
			echo "error: ".$conn->error;
		}
		$j++;
	}
}
if(isset($_POST['settle']))
{
	$row=testVar($_POST['row']);
	$col=testVar($_POST['col']);
	settle($row,$col);
}
if(isset($_POST['select_troops']))
{
	$row=testVar($_POST['row']);
	$col=testVar($_POST['col']);
	$row=$_POST['row'];
	$col=$_POST['col'];
	$_SESSION['selectedRow']=$row;
	$_SESSION['selectedCol']=$col;
	$quantity=$_POST['quantity'];
}
if(isset($_POST["scout"]))
{
	alert("scout");
	include "./scout.php";
	scoutv2(testVar($_POST['row']),testVar($_POST['col']));
}
if (isset($_POST["attack"]))
{
	
}
if(isset($_POST['move']))
{
	$srcrow=$_SESSION['selectedRow'];
	$srccol=$_SESSION['selectedCol'];
	move($srcrow,$srccol,$row,$col);
}
if(isset($_POST['attack']))
{

}
if(isset($_POST['create_troops']))
{
	
}
?>
