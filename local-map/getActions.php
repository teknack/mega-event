<?php
//session_start();
require "connect.php";
$playerid=1;/*$_SESSION['tek_emailid']*/
$faction=1;/*$_SESSION['faction']*/
function getActions($row,$col)  //AJAX FUNCTION!!! **maybe will add action cost with actions**
{
	include "scout.php";
	if(!isset($row))
	{
		$row=0;
		$col=8;
	}
	global $playerid,$conn;
	$sql="SELECT occupied,faction FROM grid WHERE row=$row and col=$col;";
	if(!$res=$conn->query($sql))
	{
		echo "error: ".$conn->error;
	}
	$sql1="SELECT playerid,quantity FROM troops WHERE row=$row and col=$col and playerid=$playerid;";
	$res1=$conn->query($sql1);
	$fortification=0;
	$occupant="0";
	$faction="1";
	$output="[";
	if($res->num_rows>0)
	{
		while($row = $res->fetch_assoc())
		{
			if($row['faction']!=$faction and $row['faction']!=0)  //enemy faction
			{
				//echo $row['faction'];
				if(isset($_SESSION['selectedRow']) and !empty($_SESSION['selectedCol']))
				{
					$output=$output.'{"action":"scout"},{"action":"attack"},{"visible":"false"}]';
				}
				else
					$output=$output.'{"action":"scout"},{"visible":"false"}]';
			}
			else if($row['faction']==$faction) //allied faction
			{
				if($row['occupied']==$playerid) //player occupied 
				{
					if(isset($_SESSION['selectedRow']) and !empty($_SESSION['selectedCol']))  
					{
						if($_SESSION['selectedRow']==$row and $_SESSION['selectedCol']==$col)//player selects already
						{                                                                    //selected occupied slot
							unset($_SESSION['selectedRow']);
							unset($_SESSION['selectedCol']);
						}
						else
						{
							$output=$output.'{"action":"move"},{"visible":"false"}]';
							scout($row,$col);
						}
					}
					else
					{
						$output=$output.'{"action":"scout"},{"action":"fortify"},{"action":"select_troops"},
						                 {"action":"create_troops"},{"visible":"true"}]';
						scout($row,$col);
					}		
				}
				else //occupied by allies
				{
					if($res1->num_rows>0) //player troops stationed
					{
						if(isset($_SESSION['selectedRow']) and !empty($_SESSION['selectCol'])) 
						{																	   
							if($_SESSION['selectedRow']==$row and $_SESSION['selectedCol']==$col)//player selects already
							{																	 //selected troops 
								unset($_SESSION['selectedRow']);
								unset($_SESSION['selectedCol']);
							}
							else
							{
								$output=$output.'{"action":"move"},{"visible":"false"}]';
								scout($row,$col);
							}
						}
						else
						{
							$output=$output.'{"action":"select_troops"},{"visible":"true"}]';
							scout($row,$col);
						}		
					}
					else //player troops not present
					{
						if(isset($_SESSION['selectedRow']) and !empty($_SESSION['selectedCol']))
						{
							$output=$output.'{"action":"scout"},{"action":"move"},{"visible":"false"}]';	
						}
						else
						{
							$output=$output.'{"action":"scout"},{"visible":"false"}]';
						}
					}
				}
			}
			else //player selects unoccupied slot
			{
				if(isset($_SESSION['selectedRow']) and !empty($_SESSION['selectedCol']))
				{
					$output=$output.'{"action":"scout"},{"action":"move"},{"visible":"false"}]';	
				}
				else
				{
					$r=$res1->fetch_assoc();
					if($r['quantity']>0)
					{
						$output=$output.'{"action":"select_troops"},{"action":"settle"}
						                 ,{"visible":"false"}]';
						scout($row,$col);	
					}
					else
					{
						$output=$output.'{"action":"scout"},{"visible":"false"}]';
					}
				}
			}
		}
	}
	echo $output;
}
//if(isset($_REQUEST['row']) and !empty($_REQUEST['row']))
{
	$row=$_REQUEST['row'];
	$col=$_REQUEST['col'];
	getActions($row,$col);
}
?>