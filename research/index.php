<?php
/*
 * Research
 * allows to increase level and explore more things
 * 
 * research types:
 * - Troop Strength [Strength of troop doubles -> double the number of troops trained]
 * - Fortification level
 * - Aquatic Civilization
 * - Improved Crop Harvest
 * - Improved Water gathering
 * - Improved Wood 
 * - Improved Metal
 * - Improved 
 * 
 * - Faction
 * - Civilization
 * - Troops
 * - Battle
 */
include "../db_access/db.php";
$troop = array();
$level = array();
function getLevel($col)
{
	global $level;
	$col = testVar($col);
	$conn = connect();
	$query = "SELECT ".$col." FROM research WHERE playerid='".$_SESSION["tek_emailid"]."';";
	$res = mysqli_query($conn,$query);
	$res = mysqli_fetch_assoc($res);
	//disconnect();
	$level[$col] = $res[$col];
	return($res[$col]);
}

function getTroopLevel()
{
	global $troop;
	$conn = connect();
	$query = "SELECT ttype FROM research WHERE playerid='".$_SESSION["tek_emailid"]."';";
	$res = mysqli_query($conn,$query);
	$res = mysqli_fetch_assoc($res);
	//disconnect();
	
	if ($res["ttype"] == "n:0")
	{
		$troop["s"] = 0;
		$troop["w"] = 0;
	}
	else
	{
		$op = split(",",$res["ttype"]);
		$troop["s"] = split(":",$op[0])[1];
		$troop["w"] = split(":",$op[1])[1];
	}
	return($troop);
}

function defenseNextLevelInfo($level)
{
	$ret = "";
	
	switch($level+1)
	{
		case 1:
			$ret = "1% more difficult to attack per soldier in occupied slot<br><b>Costs</b>: 4800 Power | 4000 wood";
		break;
		
		case 2:
			$ret = "2% more difficult to attack per soldier in occupied slot<br><b>Costs</b>: 4800 Power | 4000 wood | 4000 metal";
		break;
		
		case 3:
			$ret = "3% more difficult to attack per soldier in occupied slot<br><b>Costs</b>: 9600 Power | 8000 metal";
		break;
	}
	
	return($ret);
}

function openBattleNextLevelInfo($level)
{
	$ret = "";
	
	switch($level+1)
	{
		case 1:
			$ret = "hides 25% of troops from enemy's scout. Hidden troops twice as effective<br><b>Costs</b>: 4800 Power";
		break;
		
		case 2:
			$ret = "hides 50% of troops from enemy's scout.<br><b>Costs</b>: 4800 Power | 8000 wood";
		break;
		
		case 3:
			$ret = "hides 100% of troops from enemy's scout. Immune to attack from others on same slot<br><b>Costs</b>: 9600 power | 4000 wood | 400 metal";
		break;
	}
	
	return($ret);
}

function stealthNextLevelInfo($level)
{
	$ret="";
	
	switch($level+1)
	{
		case 1:
			$ret = "3% chance of attack success per troop, 10% more loot plundered<br><b>Costs</b>: 4800 power | 4800 food";
		break;
		
		case 2:
			$ret = "3% chance of attack success per troop, 20% more loot plundered<br><b>Costs</b>: 9600 power | 4000 wood";
		break;
		
		case 3:
			$ret = "3% chance of attack success per troop, 40% more loot plundered<br><b>Costs</b>: 9600 power | 8000 wood";
		break;
		
		case 4:
			$ret = "3% chance of attack success per troop, 60% more loot plundered<br><b>Costs</b>: 9600 power | 8000 wood | 4000 metal";
		break;
		
		case 5:
			$ret = "3% chance of attack success per troop, 80% more loot plundered<br><b>Costs</b>: 9600 power | 8000 wood | 8000 metal";
		break;
		
		case 6:
			$ret = "4% chance of attack success per troop, 90% more loot plundered<br><b>Costs</b>: 9600 power | 12000 wood | 8000 metal";
		break;
		
		case 7:
			$ret = "5% chance of attack success per troop, 100% more loot plundered<br><b>Costs</b>: 9600 power | 12000 wood | 12000 metal";
		break;
	}
	
	return($ret);
}

function warriorNextLevelInfo($level)
{
	$ret="";
	
	switch($level+1)
	{
		case 1:
			$ret = "5% chance of attack success per troop, maximum of 90% troops lost on victory<br><b>Costs</b>: 4800 power | 4800 food";
		break;
		
		case 2:
			$ret = "5% chance of attack success per troop, maximum of 80% troops lost on victory<br><b>Costs</b>: 9600 power | 4000 wood";
		break;
		
		case 3:
			$ret = "5% chance of attack success per troop, maximum of 70% troops lost on victory<br><b>Costs</b>: 9600 power | 8000 wood";
		break;
		
		case 4:
			$ret = "5% chance of attack success per troop, maximum of 60% troops lost on victory<br><b>Costs</b>: 9600 power | 8000 wood | 4000 metal";
		break;
		
		case 5:
			$ret = "5% chance of attack success per troop, maximum of 50% troops lost on vitory<br><b>Costs</b>: 9600 power | 8000 wood | 8000 metal";
		break;
		
		case 6:
			$ret = "5% chance of attack success per troop, maximum of 40% troops lost on victory<br><b>Costs</b>: 9600 power | 12000 wood | 8000 metal";
		break;
		
		case 7:
			$ret = "6% chance of attack success per troop<br><b>Costs</b>: 9600 power | 12000 wood | 12000 metal";
		break;
	}
	
	return($ret);
}

function factionPerkOneNextLevelInfo($level)
{
	$ret="";
	
	if (!isset($_SESSION["faction"]))
	{
		setTable("player");
		connect();
		$_SESSION["faction"] = fetch($_SESSION["tek_emailid"],"faction");
		//disconnect();
	}
	
	if ($_SESSION["faction"] == "1")
	{
		switch($level+1)
		{
			case 1:
				$ret="+10% plunder bonus on successful attack<br><b>Costs</b>: 4800 power | 4800 food";
			break;
			
			case 2:
				$ret="+15% plunder bonus on successful attack<br><b>Costs</b>: 9600 power | 9600 food | 4000 metal";
			break;
			
			case 3:
				$ret="+30% plunder bonus on successful attack<br><b>Costs</b>: 9600 power | 9600 food | 8000 metal";
			break;
		}
		
		
		
	}
	else if ($_SESSION["faction"] == "2")
	{
		switch($level+1)
		{
			case 1:
				$ret="-10% on Settle Cost<br><b>Costs</b>: 4800 power | 4800 food";
			break;
			
			case 2:
				$ret="-20% on Settle Cost<br><b>Costs</b>: 9600 power | 9600 food | 4000 metal";
			break;
			
			case 3:
				$ret="-30% on Settle Cost<br><b>Costs</b>: 9600 power | 9600 food | 8000 metal";
			break;
		}
	}
	return($ret);
}

function factionPerkTwoNextLevelInfo($level)
{
	$ret="";
	
	if (!isset($_SESSION["faction"]))
	{
		setTable("player");
		connect();
		$_SESSION["faction"] = fetch($_SESSION["tek_emailid"],"faction");
		//disconnect();
	}
	
	if ($_SESSION["faction"] == "1")
	{
		switch($level+1)
		{
			case 1:
				$ret="If ally troops in neighbouring slots, 10% of the ally troops assist in attack/defence<br><b>Costs</b>: 4800 power | 4800 food";
			break;
			
			case 2:
				$ret="If ally troops in neighbouring slots, 30% of the ally troops assist in attack/defence<br><b>Costs</b>: 9600 power | 9600 food | 4000 metal";
			break;
			
			case 3:
				$ret="If ally troops in neighbouring slots, 50% of the ally troops assist in attack/defence<br><b>Costs</b>: 9600 power | 9600 food | 8000 metal";
			break;
		}
	}
	else if ($_SESSION["faction"] == "2")
	{
		switch($level+1)
		{	
			case 1:
				$ret="Scout cost is 50% of original cost<br><b>Costs</b>: 4800 power | 4800 food";
			break;
			
			case 2:
				$ret="Scout cost is 25% of original cost<br><b>Costs</b>: 9600 power | 9600 food | 4000 metal";
			break;
			
			case 3:
				$ret="No Scout cost! :D<br><b>Costs</b>: 9600 power | 9600 food | 8000 metal";
			break;
		}
	}
	
	return($ret);
}

function civPerkOneNextLevelInfo($level)
{
	$ret="";
	
	switch($level+1)
	{
		case 1:
			$ret="-10% move cost<br><b>Costs</b>: 4800 power | 4800 food";
		break;
		
		case 2:
			$ret="-20% move cost<br><b>Costs</b>: 4800 power | 4000 wood";
		break;
		
		case 3:
			$ret="-30% move cost<br><b>Costs</b>: 9600 power | 4000 metal";
		break;
	}
	
	return($ret);
}

function civPerkTwoNextLevelInfo($level)
{
	$ret="";
	
	switch($level+1)
	{
		case 1:
			$ret="+1 base points to use on settling<br><b>Costs</b>: 4800 power | 4800 food";
		break;
		
		case 2:
			$ret="+2 base points to use on settling<br><b>Costs</b>: 4800 power | 4000 wood";
		break;
		
		case 3:
			$ret="+3 base points to use on settling<br><b>Costs</b>: 9600 power | 4000 metal";
		break;
		
		case 3:
			$ret="You Can now settle on Mountains!<br><b>Costs</b>: 10000 power | 5000 wood |5000 metal";
		break;
	}
	
	return($ret);
}

function deductResource($resource,$amount)
{
	connect();
	setTable("player");
	$data = fetchAll($_SESSION["tek_emailid"]);
	$data[$resource] = $data[$resource] - $amount;
	update($resource,$data[$resource],"tek_emailid='".$_SESSION["tek_emailid"]."'");
	disconnect();
}

function getPlayerResources()
{
	connect();
	setTable("player");
	$_SESSION["resources"] = fetchAll($_SESSION["tek_emailid"]);
	
	//disconnect();
}

function levelUpDefense()
{
	connect();
	$level = getLevel("defence");
	setTable("research");
	switch($level)
	{
		case 0: //level 0 -> 1 : 480 Power | 400 wood
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["wood"] >= 4000)
			{
				$level=$level+1;
				update("defence",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("wood",4000);
			}
			else //not enough resources
			{
				alert("Insufficient funds");
			}
		break;
		
		case 1: //level 1 -> 2 :  480 Power | 400 wood | 400 metal
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["wood"] >= 4000 && $_SESSION["resources"]["metal"] >= 4000)
			{
				$level=$level+1;
				update("defence",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("wood",4000);
				deductResource("metal",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 2: //level 2 -> 3 :  960 Power | 800 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 8000)
			{
				$level=$level+1;
				update("defence",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("metal",8000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
	}
}

function levelUpOpen()
{
	$level = getLevel("open");
	setTable("research");
	switch($level)
	{
		case 0: //level 0 -> 1 : 480 Power
			if ($_SESSION["resources"]["power"] >= 4800)
			{
				$level=$level+1;
				update("open",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
			}
			else //not enough resources
			{
				alert("Insufficient funds");
			}
		break;
		
		case 1: //level 1 -> 2 :  480 Power | 800 wood
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["wood"] >= 8000)
			{
				$level=$level+1;
				update("open",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("wood",8000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 2: //level 2 -> 3 :  960 Power | 400 wood | 400 metal
			if ($_SESSION["resources"]["power"] >= 960 && $_SESSION["resources"]["metal"] >= 4000 && $_SESSION["resources"]["wood"] >= 4000)
			{
				$level=$level+1;
				update("open",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",4000);
				deductResource("metal",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
	}
}

function levelUpStealth()
{
	$level = getTroopLevel();
	setTable("research");
	switch($level["s"])
	{
		case 0: //level 0 -> 1 : 480 Power | 480 food
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["food"] >= 4800)
			{
				$level["s"]=$level["s"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("food",4800);
			}
			else //not enough resources
			{
				alert("Insufficient funds");
			}
		break;
		
		case 1: //level 1 -> 2 :  960 Power | 400 wood
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["wood"] >= 4000)
			{
				$level["s"]=$level["s"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 2: //level 2 -> 3 :  960 Power | 800 wood
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["wood"] >= 8000)
			{
				$level["s"]=$level["s"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",8000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 3: //level 3 -> 4 :  960 Power | 800 wood | 400 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 4000 && $_SESSION["resources"]["wood"] >= 8000)
			{
				$level["s"]=$level["s"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",8000);
				deductResource("metal",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 4: //level 4 -> 5 :  960 Power | 800 wood | 800 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 8000 && $_SESSION["resources"]["wood"] >= 8000)
			{
				$level["s"]=$level["s"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",8000);
				deductResource("metal",8000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 5: //level 5 -> 6 :  960 Power | 1200 wood | 800 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 8000 && $_SESSION["resources"]["wood"] >= 12000)
			{
				$level["s"]=$level["s"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",12000);
				deductResource("metal",8000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 6: //level 6 -> 7 :  960 Power | 1200 wood | 1200 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 12000 && $_SESSION["resources"]["wood"] >= 12000)
			{
				$level["s"]=$level["s"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",12000);
				deductResource("metal",12000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
	}
}

function levelUpWarrior()
{
	$level = getTroopLevel();
	setTable("research");
	switch($level["w"])
	{
		case 0: //level 0 -> 1 : 480 Power | 480 food
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["food"] >= 4800)
			{
				$level["w"]=$level["w"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("food",4800);
			}
			else //not enough resources
			{
				alert("Insufficient funds");
			}
		break;
		
		case 1: //level 1 -> 2 :  960 Power | 400 wood
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["wood"] >= 4000)
			{
				$level["w"]=$level["w"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 2: //level 2 -> 3 :  960 Power | 800 wood
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["wood"] >= 8000)
			{
				$level["w"]=$level["w"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",8000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 3: //level 3 -> 4 :  960 Power | 800 wood | 400 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 4000 && $_SESSION["resources"]["wood"] >= 8000)
			{
				$level["w"]=$level["w"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",8000);
				deductResource("metal",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 4: //level 4 -> 5 :  960 Power | 800 wood | 800 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 8000 && $_SESSION["resources"]["wood"] >= 8000)
			{
				$level["w"]=$level["w"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",8000);
				deductResource("metal",8000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 5: //level 5 -> 6 :  960 Power | 1200 wood | 800 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 8000 && $_SESSION["resources"]["wood"] >= 12000)
			{
				$level["w"]=$level["w"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",12000);
				deductResource("metal",8000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 6: //level 6 -> 7 :  960 Power | 1200 wood | 1200 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 12000 && $_SESSION["resources"]["wood"] >= 12000)
			{
				$level["w"]=$level["w"]+1;
				$value="s:".$level["s"].",w:".$level["w"];
				update("ttype","'".$value."'","playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("wood",12000);
				deductResource("metal",12000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
	}
}

function levelUpFactionPerkOne()
{
	$level = getLevel("faction1");
	setTable("research");
	switch($level)
	{
		case 0: //level 0 -> 1 : 480 Power | 480 food
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["food"] >= 4800)
			{
				$level=$level+1;
				update("faction1",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("food",4800);
			}
			else //not enough resources
			{
				alert("Insufficient funds");
			}
		break;
		
		case 1: //level 1 -> 2 :  480 Power | 960 food | 400 metal
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["food"] >= 9600 && $_SESSION["resources"]["metal"] >= 4000)
			{
				$level=$level+1;
				update("faction1",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("food",9600);
				deductResource("metal",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 2: //level 2 -> 3 :  960 Power | 960 food | 800 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 8000 && $_SESSION["resources"]["food"] >= 9600)
			{
				$level=$level+1;
				update("faction1",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("food",9600);
				deductResource("metal",8000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
	}
}

function levelUpFactionPerkTwo()
{
	$level = getLevel("faction2");
	setTable("research");
	switch($level)
	{
		case 0: //level 0 -> 1 : 480 Power | 480 food
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["food"] >= 4800)
			{
				$level=$level+1;
				update("faction2",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("food",4800);
			}
			else //not enough resources
			{
				alert("Insufficient funds");
			}
		break;
		
		case 1: //level 1 -> 2 :  480 Power | 960 food | 400 metal
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["food"] >= 9600 && $_SESSION["resources"]["metal"] >= 4000)
			{
				$level=$level+1;
				update("faction2",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("food",9600);
				deductResource("metal",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 2: //level 2 -> 3 :  960 Power | 960 food | 800 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 8000 && $_SESSION["resources"]["food"] >= 9600)
			{
				$level=$level+1;
				update("faction2",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("food",9600);
				deductResource("metal",8000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
	}
}

function levelUpCivPerkOne()
{
	$level = getLevel("civperk1");
	setTable("research");
	switch($level)
	{
		case 0: //level 0 -> 1 : 480 Power | 480 food
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["food"] >= 4800)
			{
				$level=$level+1;
				update("civperk1",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("food",4800);
			}
			else //not enough resources
			{
				alert("Insufficient funds");
			}
		break;
		
		case 1: //level 1 -> 2 :  480 Power | 400 wood
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["food"] >= 4000)
			{
				$level=$level+1;
				update("civperk1",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("food",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 2: //level 2 -> 3 :  960 Power 400 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 4000)
			{
				$level=$level+1;
				update("civperk1",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("metal",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
	}
}

function levelUpCivPerkTwo()
{
	$level = getLevel("civperk2");
	setTable("research");
	switch($level)
	{
		case 0: //level 0 -> 1 : 480 Power | 480 food
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["food"] >= 4800)
			{
				$level=$level+1;
				update("civperk2",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("food",4800);
			}
			else //not enough resources
			{
				alert("Insufficient funds");
			}
		break;
		
		case 1: //level 1 -> 2 :  480 Power | 400 wood
			if ($_SESSION["resources"]["power"] >= 4800 && $_SESSION["resources"]["food"] >= 4000)
			{
				$level=$level+1;
				update("civperk2",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",4800);
				deductResource("food",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 2: //level 2 -> 3 :  960 Power 400 metal
			if ($_SESSION["resources"]["power"] >= 9600 && $_SESSION["resources"]["metal"] >= 4000)
			{
				$level=$level+1;
				update("civperk2",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",9600);
				deductResource("metal",4000);
			}
			else
			{
				alert("Insufficient funds");
			}
		break;
		
		case 2: //level 3 -> 4 :  1000 power | 500 wood |500 metal
			if ($_SESSION["resources"]["power"] >= 10000 && $_SESSION["resources"]["metal"] >= 5000 && $_SESSION["resources"]["wood"] >= 5000)
			{
				$level=$level+1;
				update("civperk2",$level,"playerid='".$_SESSION["tek_emailid"]."'");
				deductResource("power",10000);
				deductResource("wood",5000);
				deductResource("metal",5000);
			}
			else
			{
				alert("Insufficient funds"); 
			}
		break;
	}
}

if (isset($_POST) && !empty($_POST))
{
	connect();
	
	getPlayerResources();
	
	if (isset($_POST["defense_research"]))
	{
		levelUpDefense();
	}
	else if (isset($_POST["open_research"]))
	{
		levelUpOpen();
	}
	else if (isset($_POST["stealth_research"]))
	{
		levelUpStealth();
	}
	else if (isset($_POST["warrior_research"]))
	{
		levelUpWarrior();
	}
	else if (isset($_POST["faction1_research"]))
	{
		levelUpFactionPerkOne();
	}
	else if (isset($_POST["faction2_research"]))
	{
		levelUpFactionPerkTwo();
	}
	else if (isset($_POST["civperk1_research"]))
	{
		levelUpCivPerkOne();
	}
	else if (isset($_POST["civperk2_research"]))
	{
		levelUpCivPerkTwo();
	}
	
	disconnect();
}

?>
<html>

	<head>
		<title>Research</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">    
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">  
		<link href='https://fonts.googleapis.com/css?family=Josefin+Slab:400,700' rel='stylesheet' type='text/css'>
		<link type="text/css" rel="stylesheet" href="../maincss/mainstyle.css"> 
		<link type="text/css" rel="stylesheet" href="../maincss/research.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	</head>

	<body>

		<nav class="navbar">
		<div class="container-fluid">
			<!-- Menu items -->
			<div>
				<!-- Menu right items -->
				<ul class="nav nav-tabs navbar-nav navbar-right">
					<li><a href="../local-map/resources.php">Collect</a></li>
					<li><a href="../local-map/index.php">Local</a></li>
					<li><a href="../market/index.php">Market</a></li>
					<li class="active"><a href="../research/index.php">Research</a></li>
					<li><a href="../world-map/canvas1.html">World Map <span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a></li>
				</ul>
			</div>
		</div>
	</nav>

		<div class="container">
			
			<div class="page-header">
				<h1 style="color: #ffffb3">Research</h1>
			</div>

			<form action="" method="POST">
			<div class="innerpart well well-lg">
				<table class="table">
					<thead>
						<tr>
							<th>Name <?php alert(getPlayerName($_SESSION["tek_emailid"])); ?></th>
							<th>Current Level</th>
							<th>Next Level Info</th>
							<th>Next Level</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="center"><b>Defence</b></td>
							<td align="center"><?php echo(getLevel("defence")) ?>/3</td>
							<td align="center"><?php echo(defenseNextLevelInfo($level["defence"]))?></td>
							<td align="center"><button name="defense_research" type="submit">Research</button></td>
						</tr>
						<tr>
							<td align="center"><b>Open Battle</b></td>
							<td align="center"><?php echo(getLevel("open")) ?>/3</td>
							<td align="center"><?php echo(openBattleNextLevelInfo($level["open"])) ?></td>
							<td align="center"><button name="open_research" type="submit">Research</button></td>
						</tr>
						<tr>
							<td align="center"><b>Stealth Troop</b></td>
							<td align="center"><?php getTroopLevel(); echo($troop["s"]); ?>/7</td>
							<td align="center"><?php echo(stealthNextLevelInfo($troop["s"])) ?></td>
							<td align="center"><button name="stealth_research" type="submit">Research</button></td>
						</tr>
						<tr>
							<td align="center"><b>Warrior Troop</b></td>
							<td align="center"><?php echo($troop["w"]) ?>/7</td>
							<td align="center"><?php echo(warriorNextLevelInfo($troop["w"])) ?></td>
							<td align="center"><button name="warrior_research" type="submit">Research</button></td>
						</tr>
						<tr>
							<td align="center"><b>Faction Perk 1</b></td>
							<td align="center"><?php echo(getLevel("faction1")) ?>/3</td>
							<td align="center"><?php echo(factionPerkOneNextLevelInfo($level["faction1"])) ?></td>
							<td align="center"><button name="faction1_research" type="submit">Research</button></td>
						</tr>
						<tr>
							<td align="center"><b>Faction Perk 2</b></td>
							<td align="center"><?php echo(getLevel("faction2")) ?>/3</td>
							<td align="center"><?php echo(factionPerkTwoNextLevelInfo($level["faction2"])) ?></td>
							<td align="center"><button name="faction2_research" type="submit">Research</button></td>
						</tr>
						<tr>
							<td align="center"><b>Civilisation Perk 1</b></td>
							<td align="center"><?php echo(getLevel("civperk1")) ?>/3</td>
							<td align="center"><?php echo(civPerkOneNextLevelInfo($level["civperk1"])) ?></td>
							<td align="center"><button name="civperk1_research" type="submit">Research</button></td>
						</tr>
						<tr>
							<td align="center"><b>Civilisation Perk 2</b></td>
							<td align="center"><?php echo(getLevel("civperk2")) ?>/3</td>
							<td align="center"><?php echo(civPerkTwoNextLevelInfo($level["civperk2"])) ?></td>
							<td align="center"><button name="civperk2_research" type="submit">Research</button></td>
						</tr>
					</tbody>
				</table>
			</div>
			</form>
		</div>


		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	
	</body>
	
</html>
