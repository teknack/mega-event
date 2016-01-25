<?php
session_start();
require "connect.php";
$playerid=1;/*$_SESSION['tek_emailid']*/
$faction=1;/*$_SESSION['faction']*/
function getActions($row,$col)  //AJAX FUNCTION!!! **maybe will add action cost with actions**
{
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
			if($row['faction']!=$faction and $row['faction']!=0)  //enemy faction
			{
				//echo $row['faction'];
				if(isset($_SESSION['selectedRow']) and !empty($_SESSION['selectedCol']))
				{
					$output=$output.'{"action":"scout"},{"action":"attack"}]';
				}
				else
					$output=$output.'{"action":"scout"}]';
			}
			else if($row['faction']==$faction) //allied faction
			{
				if($row['occupied']==$playerid) //player occupied 
				{
					if(isset($_SESSION['selectedRow']) and !empty($_SESSION['selectedCol'])) //player selects already 
																							 //selected occupied slot 
					{
						if($_SESSION['selectedRow']==$row and $_SESSION['selectedCol']==$col)
						{
							unset($_SESSION['selectedRow']);
							unset($_SESSION['selectedCol']);
						}
					}
					$output=$output.'{"action":"fortify"},{"action":"select_troops"},{"action":"create_troops"}]';		
				}
				else //occupied by allies
				{
					if($res1->num_rows>0) //player troops stationed
					{
						if(isset($_SESSION['selectedRow']) and !empty($_SESSION['selectCol'])) //player selects already
						{																	   //selected troops 
							if($_SESSION['selectedRow']==$row and $_SESSION['selectedCol']==$col)
							{
								unset($_SESSION['selectedRow']);
								unset($_SESSION['selectedCol']);
							}
						}
						$output=$output.'{"action":"settle"},{"action":"select troops"}]';		
					}
					else //player troops not present
					{
						if(isset($_SESSION['selectedRow']) and !empty($_SESSION['selectedCol']))
						{
							$output=$output.'{"action":"scout"},{"action":"move"}]';	
						}
						else
							$output=$output.'{"action":"scout"}]';
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