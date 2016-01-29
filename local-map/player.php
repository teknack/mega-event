<?php
//require "connect.php";
$faction/*=$_SESSION['faction']*/;
$faction=1;	//temporary!! don't forget to remove!!
$playerid/*=$_SESSION['tek_emailid']*/;
$playerid=1; //temporary!! don't forget to remove!! 
$moveCostFood=6;
$moveCostWater=8;
/*number of troops garrisonable by fortification level
1-10
2-13
3-16
4-20
5-24
6-26
7-30
8-35
*/

function getStats(){
	//require "../db_access/db.php";
	connect();
	$playerid = $_SESSION["tek_emailid"];
	setTable("player");

	//$query = "SELECT faction,food,food_regen,water,water_regen,power,power_regen,metal,metal_regen,wood,wood_regen,total FROM player WHERE tek_emailid='".$playerid."';";
	//$res = mysqli_query($dbconn,$query);
	//$res = mysqli_fetch_assoc($res);	
	$res=fetchAll($playerid);
	//alert(var_dump($res));
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
function queryResource($resource,$value)
{
	global $conn,$playerid;
	$sql="SELECT $resource FROM player WHERE tek_emailid='$playerid'";
	$res=$conn->query($sql);
	$row=$res->fetch_assoc();
	$reso=intval($row[$resource]);
	if($value>$reso)
	{
		echo "<br>not enough";
		return false;
	}
	else
		return true;
}
function deductResource($resource,$value)   //use to reduce resource on some action give resource name and value resp.
{
	global $conn,$playerid;
	if(!queryResource($resource,$value))
	{
		echo "<br>not enough";
		return false;
	}
	else
	{
		echo "<br>enough";
		$sql="UPDATE `player` SET $resource=$resource-'$value' WHERE tek_emailid='$playerid'";	
			if($conn->query($sql)===false)
			{
				echo "error: ".$conn->error;
			}
		return true;
	}
}
function move($srcRow,$srcCol,$destRow,$destCol,$quantity) //move works in 2 steps, first select troops from an occupied slot  
{       		                                           //then select the slot to move the troops to 
	$distance=max(abs($srcRow-$destRow),abs($srcCol-$destCol));
	$sroot="x,y";
	$droot="x,z";
	$enemy; //enemy playerid
	$etroops=0; //enemy total troop strength at the destination slot
	$obperk=0; //open battle perk level of each enemy
	$ambushSurvive=false;
	global $conn,$moveCostFood,$moveCostPower,$playerid;
	$sql="SELECT root FROM grid WHERE row=$srcRow and col=$srcCol;"; //the query for root column decide if movement is within 
										 //the faction occupied region
	if($res=$conn->query($sql))
	{
		$conn->error;
	}
	if($res->num_rows>0)											  
	{
		while($row=$res->fetch_assoc())
		{
			$sroot=$row['root'];
		}
	}
	$sql="SELECT root FROM grid WHERE row=$destRow and col=$destCol;";
	if($res=$conn->query($sql))
	{
		$conn->error;
	}
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
	$waterCost=$distance*$moveCostWater;
	$troopExist=false;
	$sql="SELECT troops FROM grid WHERE row=$srcRow and col=$srcCol;"; //check if required troops present in grid table
	$res=$conn->query($sql);
	if($res->num_rows>0)
	{
		$row=$res->fetch_assoc();
		if($row['troops']<$quantity)
		{
			$troopExist=false;
		}
		else
		{
			$troopExist=true;
		}
	}
	$sql="SELECT playerid,quantity FROM troops WHERE row=$srcRow and col=$srcCol;"; //check if required troops present 
	$res=$conn->query($sql);                                                        //in troops table												
	if($res->num_rows>0)
	{
		$row=$res->fetch_assoc();
		if($row['quantity']<$quantity or $row['playerid']!=$playerid)
		{
			if(!$troopExist) //troops not enough or not present in both tables
			{
				$_SESSION['response']="You don't have those many troops. You have ".$row['troops']." soldiers.
				Create more soldier(s)!";
				unset($_SESSION['selectedRow']);
				unset($_SESSION['selectedCol']);
				unset($_SESSION['selectedTroops']);
				return;
			} 
		}
	}
	else if(!$troopExist)
	{
		$_SESSION['response']="You don't have those many troops. You have ".$row['troops']." soldiers.
				Create more soldiers!";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	//number of required troops exist
	if(!queryResource("food",$foodCost))
	{
		echo "here but don't know how";
		$_SESSION['response']="You don't have the required resources(food).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	if(!queryResource("water",$waterCost))
	{
		$_SESSION['response']="You don't have the required resources(power).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	deductResource("food",$foodCost);
	deductResource("water",$waterCost); 
	//resources validated
	/*open battle sim*/
	$troopDistribution=[[]];
	$sql="SELECT playerid,quantity FROM troops WHERE row=$destRow and col=$destCol;";
	$res=$conn->query($sql);
	if($res->num_rows>0)
	{
		$i=0;
		while($row=$res->fetch_assoc())
		{
			$enemy=$row['playerid'];
			$otroops=$row['quantity']; //number of troops of one enemy occupant
			$sql1="SELECT open,ttype FROM research WHERE playerid=$enemy;";
			$res1=$conn->query($sql1);
			$r=$res1->fetch_assoc();
			$obperk=$r['open'];
			if($obperk==1)
			{
				$hiddenTroops=0.25*$otroops; //25% percent troops hidden and are twice as effective
				$otroops+=$hiddenTroops;
			}
			else if($obperk==2)
			{
				$hiddenTroops=0.5*$otroops; //50% percent troops hidden and are twice as effective
				$otroops+=$hiddenTroops;	
			}
			else if($obperk==3)
			{
				$hiddenTroops=$otroops; //100% percent troops hidden and are twice as effective
				$otroops+=$hiddenTroops;
			}
			$lvl=$row['ttype'];      
			$lvl=explode(":", $lvl);
			$level=$lvl[1];
			$troopDistribution[$i]['troops']=$otroops-$hiddenTroops;
			$troopDistribution[$i]['playerid']=$enemy;
			$otroops=$otroops*$level;
			$etroops+=$otroops;
			$i++;
		}
		$sql="SELECT ttype FROM research WHERE playerid=$playerid;";
		$res1=$conn->query($sql);
		$row=$res1->fetch_assoc();
		$flvl=$row['ttype'];
		$flvl=explode(":", $flvl);
		$flevel=$flvl[1];
		$quantity*=$flevel;
		if($quantity>$etroops) //player troops survive the ambush
		{
			$ambushSurvive=true;
			$quantity=$quantity-$etroops;
			$quantity/=$flevel;
			$quantity=floor($quantity);
			$sql2="DELETE FROM troops WHERE row=$destCol and col=$destCol;";
			if($conn->query($sql2)===false)
			{
				var_dump($sql2);
				echo "<br> error: ".$conn->error;
			}
			/*message to all*/
		}
		else //enemy ambush wins
		{
			$ambushSurvive=false;
			$quantity/=$flevel;
			for($i=0;$i<count($troopDistribution);$i++)
			{
				$loss=floor($troopDistribution[$i]['troops']/$quantity);
				$id=$troopDistribution['playerid']; //deducting troops as battle losses
				$sql2="UPDATE troops SET quantity=quantity-$loss WHERE playerid=$id and row=$destRow and col=$destCol;";
				if($conn->query($sql2)===false)
				{
					var_dump($sql2);
					echo "<br> error: ".$conn->error;		
				}
			}
			$sql2="DELETE FROM troops WHERE quantity<=0;";
			if($conn->query($sql2)===false)
			{
				var_dump($sql2);
				echo "<br> error: ".$conn->error;		
			}
			/*message to all*/
			$_SESSION['response']="Your troops were ambushed!.There were no survivors :-(";
		}
	}
	else
	{
		$enemy=0;
		$etroops=0;
		$ebperk=0;
	}
	/*it ends here*/
	$sql="SELECT occupied FROM grid WHERE row=$srcRow and col=$srcCol;"; 
	$res=$conn->query($sql);
	if($res->num_rows>0)  //player moving from settled slot
	{

		$row=$res->fetch_assoc();
		if($row['occupied']==$playerid)
		{
			$sql="SELECT occupied FROM grid WHERE row=$destRow and col=$destCol";
			$res2=$conn->query($sql);
			$r=$res2->fetch_assoc();
			if($r['occupied']!=$playerid) //player moving form settled to unoccupied/allied slot
			{
				$sql="SELECT quantity FROM troops WHERE row=$destRow and col=$destCol;"; //check if troops are already present
				$res1=$conn->query($sql);
				if($res1->num_rows==0)
				{
					$sql="INSERT INTO troops (row,col,playerid,quantity) VALUES ($destRow,$destCol,'$playerid',$quantity);";
					if($conn->query($sql)==false)
						echo "error(114) : ".$conn->error."<br>";
				}
				else
				{
					$sql="UPDATE troops SET quantity=quantity+$quantity WHERE row=$destRow and col=$destCol;";
					if($conn->query($sql)==false)
						echo "error (119): ".$conn->error."<br>";
				} 
				$sql="UPDATE grid SET troops=troops-$quantity WHERE row=$srcRow and col=$srcCol;";
				if($conn->query($sql)===false)
					echo "error (124 wala): ".$conn->error."<br>";
				if($ambushSurvive==true)
				{
					$_SESSION['response']="There was an ambush on your troops and you lost a few soldiers<br>
					                       moved ".$quantity." soldiers! by ".$distance;	
				}
				else
				{
					$_SESSION['response']="moved ".$quantity." soldiers! by ".$distance;
				}
			}
			else //player moves from occupied slot to occupied slot
			{
				$sql="UPDATE grid SET troops=troops-$quantity WHERE row=$srcRow and col=$srcCol";
				if($conn->query($sql)==false)
						echo "error(131) : ".$conn->error."<br>";
				$sql="UPDATE grid SET troops=troops-$quantity WHERE row=$destRow and col=$destCol";
				if($conn->query($sql)==false)
						echo "error(135) : ".$conn->error."<br>";
				if($ambushSurvive==true)
				{
					$_SESSION['response']="There was an ambush on your troops and you lost a few soldiers<br>
					                       moved ".$quantity." soldiers! by ".$distance;	
				}
				else
				{
					$_SESSION['response']="moved ".$quantity." soldiers! by ".$distance;
				}
			}
		}
		else //player moving stationed troops
		{
			$sql="SELECT occupied FROM grid WHERE row=$destRow and col=$destCol";
			$res2=$conn->query($sql);
			$r=$res2->fetch_assoc();
			if($r['occupied']!=$playerid) //player moves from unoccupied/allied slots to unoccupied/allied slots
			{
				$sql="UPDATE troops SET quantity=quantity-$quantity WHERE row=$srcRow and col=$srcCol;";
				if($conn->query($sql)==false)
					echo "error (143): ".$conn->error."<br>";
				$sql="SELECT quantity FROM troops WHERE row=$destRow and col=$destCol;"; //check if troops are already present
				$res1=$conn->query($sql);
				if($res1->num_rows==0)
				{
					$sql="INSERT INTO troops (row,col,playerid,quantity) VALUES ($destRow,$destCol,'$playerid',$quantity);";
					if($conn->query($sql)==false)
						echo "error(150) : ".$conn->error."<br>";
				}
				else
				{
					$sql="UPDATE troops SET quantity=quantity+$quantity WHERE row=$destRow and col=$destCol;";
					if($conn->query($sql)==false)
						echo "error (156): ".$conn->error."<br>";
				}
				$sql="DELETE FROM troops WHERE quantity<=0";
				if($conn->query($sql)==false)
					echo "error(160) : ".$conn->error;
				if($ambushSurvive==true)
				{
					$_SESSION['response']="There was an ambush on your troops and you lost a few soldiers<br>
					                       moved ".$quantity." soldiers! by ".$distance;	
				}
				else
				{
					$_SESSION['response']="moved ".$quantity." soldiers! by ".$distance;
				}
			}
			else //move troops from unoccupied/allied slots to occupied slot
			{
				$sql="UPDATE troops SET quantity=quantity-$quantity WHERE row=$srcRow and col=$srcCol;";
				if($conn->query($sql)==false)
					echo "error (192): ".$conn->error."<br>";
				$sql="UPDATE grid SET troops=troops+$quantity WHERE row=$destRow and col=$destCol;";
				if($conn->query($sql)==false)
					echo "error (195): ".$conn->error."<br>";
				$sql="DELETE FROM troops WHERE quantity<=0";
				if($conn->query($sql)==false)
					echo "error(160) : ".$conn->error;
				if($ambushSurvive==true)
				{
					$_SESSION['response']="There was an ambush on your troops and you lost a few soldiers<br>
					                       moved ".$quantity." soldiers! by ".$distance;	
				}
				else
				{
					$_SESSION['response']="moved ".$quantity." soldiers! by ".$distance;
				}
			}
		}
	}
	unset($_SESSION['selectedRow']);
	unset($_SESSION['selectedCol']);
	unset($_SESSION['selectedTroops']);
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
	global $conn,$playerid,$faction;
	$settleWoodCost=20;
	$settleMetalCost=30;
	$settlePowerCost=15;
	if(!queryResource("wood",$settleWoodCost)) //settling resources
	{
		echo "here but don't know how";
		$_SESSION['response']="You don't have the required resources(wood).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	if(!queryResource("power",$settlePowerCost))
	{
		$_SESSION['response']="You don't have the required resources(power).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	if(!queryResource("metal",$settleMetalCost))
	{
		$_SESSION['response']="You don't have the required resources(metal).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	} 
	deductResource("wood",$settleWoodCost);
	deductResource("metal",$settleMetalCost);
	deductResource("power",$settlePowerCost); 
	$roots= array();
	$root=$row.",".$col;
	$troopCount;
	$sql="SELECT row,col,fortification,root FROM grid WHERE (row=$row-1 or row=$row or row=$row+1) and (col=$col-1 or col=$col or col=$col+1);";
	$res=$conn->query($sql); //query to get all the neighbouring slots to the given slot.
	if($res->num_rows>0)
	{
		$i=0;
		while($ro=$res->fetch_assoc())
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
		while($ro=$res->fetch_assoc())
		{
			$troopCount=$ro['quantity'];
		}
	}
	$roots=condenseArray($roots); //refer line 54
	$j=0;
	while($j<count($roots)) //sets the root of all neighbouring slots if occupied as the root of the given slot
	{
		var_dump($roots);
		echo "<br>";
		$r=$roots[$j];
		$sql="UPDATE grid SET root='$root' WHERE root='$r'";
		if(!$conn->query($sql) === TRUE)
		{
			var_dump($sql);
			echo "<br>";
			echo "error: ".$conn->error."<br>";
		}
		$j++;
		$sql="UPDATE grid SET occupied=$playerid,faction=$faction,fortification=1, root='$root',troops=$troopCount 
		      WHERE row=$row and col=$col;";
		if(!$conn->query($sql) === TRUE)
		{
			var_dump($sql);
			echo "<br>";
			echo "error: ".$conn->error."<br>";
		}
		$sql="DELETE FROM troops WHERE row=$row and col=$col";
		if(!$conn->query($sql) === TRUE)
		{
			var_dump($sql);
			echo "<br>";
			echo "error: ".$conn->error."<br>";
		}
	}
	$_SESSION['response']="successfully settled.";
}
function createTroops($row,$col,$quantity)
{
	global $conn;
	$createTroopCostFoodBase="10";
	$createTroopCostWaterBase="13";
	$createTroopCostPowerBase="4";
	$createTroopCostFood=$quantity*$createTroopCostFoodBase;
	$createTroopCostWater=$quantity*$createTroopCostWaterBase;
	$createTroopCostPower=$quantity*$createTroopCostPowerBase;
	if(!queryResource("food",$createTroopCostFood))
	{
		$_SESSION['response']="You don't have the required resources(food).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	if(!queryResource("water",$createTroopCostWater))
	{
		$_SESSION['response']="You don't have the required resources(water).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	if(!queryResource("power",$createTroopCostPower))
	{
		$_SESSION['response']="You don't have the required resources(power).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	deductResource("food",$createTroopCostFood);
	deductResource("water",$createTroopCostWater);
	deductResource("power",$createTroopCostPower);
	$sql="UPDATE grid SET troops=troops+$quantity WHERE row=$row and col=$col;";
	if($conn->query($sql)==false)
	{
		echo "error(160) : ".$conn->error;
		$_SESSION['response']="error in query";
	}
	else
		$_SESSION['response']="created ".$quantity." troops.";
}
function fortify($row,$col)/*pending*/
{
	global $conn,$playerid;
	$fortifyWoodCost=array();
	$fortifyMetalCost=array();
	$fortifyPowerCost=array();
	$sql="SELECT fortification FROM grid WHERE row=$row and col=$col;";
	$res=$conn->query($sql);
	$level=$res['fortification'];
	if(!queryResource("wood",$fortifyWoodCost[$level-1]))
	{
		$_SESSION['response']="You don't have the required resources(food).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	if(!queryResource("metal",$fortifyMetalCost[$level-1]))
	{
		$_SESSION['response']="You don't have the required resources(water).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	if(!queryResource("power",$fortifyPowerCost[$level-1]))
	{
		$_SESSION['response']="You don't have the required resources(power).";
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
		unset($_SESSION['selectedTroops']);
		return;
	}
	deductResource("wood",$fortifyWoodCost[$level-1]);
	deductResource("metal",$fortifyMetalCost[$level-1]);
	deductResource("power",$fortifyPowerCost[$level-1]);
	//validated resources
	$sql="UPDATE grid SET fortification=fortification+1 WHERE row=$row and col=$col;";
	if($conn->query($sql)==false)
	{
		echo "error(160) : ".$conn->error;
		$_SESSION['response']="error in query";
	}
	else
		$_SESSION['response']="fortified to level : ".$level+1;
}
if(isset($_POST['settle']))
{
	$row=testVar($_POST['row']);
	$col=testVar($_POST['col']);
	settle($row,$col);
	header("location:index.php");
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
	$_SESSION['selectedTroops']=$quantity;
	header("location:index.php");
}
if(isset($_POST["scout"]))
{
	if(isset($_SESSION['selectedRow']) and !empty($_SESSION['selectedRow']))
	{
		unset($_SESSION['selectedRow']);
		unset($_SESSION['selectedCol']);
	}
	include "scout.php";
	scout(testVar($_POST['row']),testVar($_POST['col']));
	header("location:index.php");
}
if(isset($_POST['move']))
{
	if(isset($_SESSION['selectedTroops']) and !empty($_SESSION['selectedTroops']))
	{
		$quantity=$_SESSION['selectedTroops'];
		unset($_SESSION['selectedTroops']);
	}
	else
	{
		$quantity=1;
	}
	$srcrow=$_SESSION['selectedRow'];
	$srccol=$_SESSION['selectedCol'];
	$row=$_POST['row'];
	$col=$_POST['col'];
	//echo $quantity;
	move($srcrow,$srccol,$row,$col,$quantity);
	header("location:index.php");
}
if(isset($_POST['attack']))
{
	if(isset($_SESSION['selectedTroops']) and !empty($_SESSION['selectedTroops']))
	{
		$quantity=$_SESSION['selectedTroops'];
		unset($_SESSION['selectedTroops']);
	}
	else
	{
		$quantity=1;
	}
	$srcrow=$_SESSION['selectedRow'];
	$srccol=$_SESSION['selectedCol'];
	$row=$_POST['row'];
	$col=$_POST['col'];
	//echo $quantity;
	attack($srcrow,$srccol,$row,$col,$quantity);
	header("location:index.php");
}
if(isset($_POST['create_troops']))
{
	$row=$_POST['row'];
	$col=$_POST['col'];
	if(isset($_POST['quantity']) and !empty($_POST['quantity']))
	{
		$quantity=$_POST['quantity'];
	}
	else
		$quantity=1;
	createTroops($row,$col,$quantity);
	header("location:index.php");
}
?>
