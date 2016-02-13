<?php

?>
<html>

	<head>
		<title>Research</title>
	</head>

	<body>
		<div id="top">
			<h1>Research</h1>
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
					<td align="center"><b>Defense</b></td>
					<td align="center">0</td>
					<td align="center">1% more difficult to attack per soldier in occupied slot<br><b>Costs</b>: 480 Power | 400 wood</td>
					<td align="center"><button name="defense_research" type="submit">Research</button></td>
				</tr>
				<tr>
					<td align="center"><b>Open Battle</b></td>
					<td align="center">0</td>
					<td align="center">hides 25% of troops from enemy's scout. Hidden troops twice as effective<br><b>Costs</b>: 480 Power</td>
					<td align="center"><button name="open_research" type="submit">Research</button></td>
				</tr>
				<tr>
					<td align="center"><b>Stealth Troop</b></td>
					<td align="center">0</td>
					<td align="center">3% chance of attack success per troop, 10% more loot plundered<br><b>Costs</b>: 480 power | 480 food</td>
					<td align="center"><button name="stealth_research" type="submit">Research</button></td>
				</tr>
				<tr>
					<td align="center"><b>Warrior Troop</b></td>
					<td align="center">0</td>
					<td align="center">5% chance of attack success per troop, maximum of 90% troops lost on victory<br><b>Costs</b>: 480 power | 480 food</td>
					<td align="center"><button name="warrior_research" type="submit">Research</button></td>
				</tr>
				<tr>
					<td align="center"><b>Faction Perk 1</b></td>
					<td align="center">0</td>
					<td align="center">Scout cost is 50% of original cost<br><b>Costs</b>: 480 power | 480 food</td>
					<td align="center"><button name="faction1_research" type="submit">Research</button></td>
				</tr>
				<tr>
					<td align="center"><b>Faction Perk 2</b></td>
					<td align="center">0</td>
					<td align="center">If ally troops in neighbouring slots, 10% of the ally troops assist in attack/defence<br><b>Costs</b>: 480 power | 480 food</td>
					<td align="center"><button name="faction2_research" type="submit">Research</button></td>
				</tr>
				<tr>
					<td align="center"><b>Civilisation Perk 1</b></td>
					<td align="center">0</td>
					<td align="center">-10% move cost<br><b>Costs</b>: 480 power | 480 food</td>
					<td align="center"><button name="civperk1_research" type="submit">Research</button></td>
				</tr>
				<tr>
					<td align="center"><b>Civilisation Perk 2</b></td>
					<td align="center">0</td>
					<td align="center">+1 base points to use on settling<br><b>Costs</b>: 480 power | 480 food</td>
					<td align="center"><button name="civperk2_research" type="submit">Research</button></td>
				</tr>
			</table>
		</div>
	</body>
	<hr>
	<div id="explanation">
		<b>Research</b>
		<ul>
			<li>This is the Research page</li>
			<li>Here, you'll be able to upgrade certain bonuses throughout the game</li>
			<li>The different categories are listed in the <b>Name</b> column</li>
			<li>The current level of the bonus is in the <b>Current Level</b> column</li>
			<li>The information regarding the next level's bonus and it's resource cost is in the <b>Next Level Info</b> column</li>
			<li>Lastly, the button which does the research (provided you have sufficient resources) is in the <b>Next Level</b> column</li>
		</ul>
	</div>
</html>
