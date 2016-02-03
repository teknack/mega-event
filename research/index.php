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
	disconnect();
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
	disconnect();
	
	$op = split(",",$res["ttype"]);
	$troop["s"] = split(":",$op[0])[1];
	$troop["w"] = split(":",$op[1])[1];
}

function defenseNextLevelInfo($level)
{
	$ret = "";
	
	switch($level+1)
	{
		case 1:
			$ret = "1% more difficult to attack per solder in occupied slot";
		break;
		
		case 2:
			$ret = "2% more difficult to attack per solder in occupied slot";
		break;
		
		case 3:
			$ret = "3% more difficult to attack per solder in occupied slot";
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
			$ret = "hides 25% of troops from enemy's scout. Hidden troops twice as effective";
		break;
		
		case 2:
			$ret = "hides 50% of troops from enemy's scout.";
		break;
		
		case 3:
			$ret = "hides 100% of troops from enemy's scout. Immune to attack from others on same slot";
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
			$ret = "3% chance of attack success per troop, 10% more loot plundered";
		break;
		
		case 2:
			$ret = "3% chance of attack success per troop, 20% more loot plundered";
		break;
		
		case 3:
			$ret = "3% chance of attack success per troop, 40% more loot plundered";
		break;
		
		case 4:
			$ret = "3% chance of attack success per troop, 60% more loot plundered";
		break;
		
		case 5:
			$ret = "3% chance of attack success per troop, 80% more loot plundered";
		break;
		
		case 6:
			$ret = "4% chance of attack success per troop, 90% more loot plundered";
		break;
		
		case 7:
			$ret = "5% chance of attack success per troop, 100% more loot plundered";
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
			$ret = "5% chance of attack success per troop, maximum of 90% troops lost on victory";
		break;
		
		case 2:
			$ret = "5% chance of attack success per troop, maximum of 80% troops lost on victory";
		break;
		
		case 3:
			$ret = "5% chance of attack success per troop, maximum of 70% troops lost on victory";
		break;
		
		case 4:
			$ret = "5% chance of attack success per troop, maximum of 60% troops lost on victory";
		break;
		
		case 5:
			$ret = "5% chance of attack success per troop, maximum of 50% troops lost on vitory";
		break;
		
		case 6:
			$ret = "5% chance of attack success per troop, maximum of 40% troops lost on victory";
		break;
		
		case 7:
			$ret = "6% chance of attack success per troop";
		break;
	}
	
	return($ret);
}

function factionOneNextLevelInfo($level)
{
	$ret="";
	
	switch($level+1)
	{
		case 1:
			$ret="Scout cost is 50% of original cost";
		break;
		
		case 2:
			$ret="Scout cost is 25% of original cost";
		break;
		
		case 3:
			$ret="No Scout cost! :D";
		break;
	}
	
	return($ret);
}

function factionTwoNextLevelInfo($level)
{
	$ret="";
	
	switch($level+1)
	{
		case 1:
			$ret="Scout cost is 50% of original cost";
		break;
		
		case 2:
			$ret="Scout cost is 25% of original cost";
		break;
		
		case 3:
			$ret="No Scout cost! :D";
		break;
	}
	
	return($ret);
}

?>
<html>

	<head>
		<title>Research</title>
	</head>

	<body>
		<div id="top">
			Research
		</div>
		<hr>
		<div id="content">
			<table border=1>
				<tr>
					<th>Name</th>
					<th>Current Level</th>
					<th>Next Level Info</th>
					<th>Next Level</th>
				</tr>
				<tr>
					<td><b>Defense</b></td>
					<td><?php echo(getLevel("defensive")) ?></td>
					<td><?php echo(defenseNextLevelInfo($level["defensive"]))?></td>
					<td></td>
				</tr>
				<tr>
					<td><b>Open Battle</b></td>
					<td><?php echo(getLevel("open")) ?></td>
					<td><?php echo(openBattleNextLevelInfo($level["open"])) ?></td>
					<td></td>
				</tr>
				<tr>
					<td><b>Stealth Troop</b></td>
					<td><?php getTroopLevel(); echo($troop["s"]); ?></td>
					<td><?php echo(stealthNextLevelInfo($troop["s"])) ?></td>
					<td></td>
				</tr>
				<tr>
					<td><b>Warrior Troop</b></td>
					<td><?php echo($troop["w"]) ?></td>
					<td><?php echo(warriorNextLevelInfo($troop["w"])) ?></td>
					<td></td>
				</tr>
				<tr>
					<td><b>Faction Perk 1</b></td>
					<td><?php echo(getLevel("faction1")) ?></td>
					<td><?php echo(factionOneNextLevelInfo($level["faction1"])) ?></td>
					<td></td>
				</tr>
				<tr>
					<td><b>Faction Perk 2</b></td>
					<td><?php echo(getLevel("faction2")) ?></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><b>Civilisation Perk</b></td>
					<td><?php echo(getLevel("civperk")) ?></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		</div>
	</body>
	
</html>
