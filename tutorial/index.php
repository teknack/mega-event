<html>

<head>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<title>Test page</title>
	<script src="tut.js"></script>
</head>

<body>
	<div id="playerinfo" >
		<!--<h2>Stats</h2><br> -->
		<!--<table border="2" style="width : 50%">
			<tr>-->
				<div id="leftward">					
					<span id="food">Food : </span>
					<span id="water">Water :</span>
					<span id="power">Power :</span>
					<span id="metal">Metal :</span>
					<span id="wood">Wood :</span>
				</div>
				<span>
					<form action="resources.php" method="POST"> 
						<button type="submit" id="resource">Collect Resources</button>
						<button type="submit" id="start">START GAME</button>
					</form>
				</span>
		<!--	</tr>
		</table>	-->
		
	</div>
	<br><br>
	<div id="playgroup" >
		<table id="play" height="50%" width="100%" border="1">
			<tr>
				<td>
					<div id="localplay" class="playarea" align="center">
						<canvas id="canvas" width="450" height="450" style="border:1px solid #c3c3c3;">
							Your browser does not support the canvas element.
						</canvas>
					</div>
				</td>
				<td>
					<div id="tutorials" class="playarea" align="center">
						<button type="submit" id="basics">basics</button><br><br>
						<button type="submit" id="scouting">scouting</button><br><br>
						<button type="submit" id="selMove">selecting and moving troops</button><br><br>
						<button type="submit" id="creAttack">settle,create troops and attack</button><br><br>
						<button type="submit" id="research">research</button><br><br>
						<button type="submit" id="redeem">redeeming score in mega-event</button><br><br>
						<button type="submit" id="market">market</button><br><br>
					</div>
				</td>
				<td width="50%">
					<div id="prompt" class="playarea"> </div>
				</td>
			</tr>
		</table>
	</div>
	<hr>
	<div id="bottomgroup" border=1>
		<table id="bottomTable"> 
			<tr>
				<td>
					<div id="bottom_action" style="float:left">
							<div>
								<input type="hidden" name="action" id="action">
								<input type="hidden" name="row" id="row">
								<input type="hidden" name="col" id="col">
								<input type="number" name="quantity" id="quantity">
							</div>
							<div id="actions">
								<div id="player">
									<button id='cTroops' onmousemove="find()">create troops</button><br>
	        						<button id='sTroops'>select troops</button><br>
	        						<button id='fortify'>fortify</button><br>
	        					</div>
	        					<div id="splayer">
	        						<button id='move'>move</button><br>
	        					</div>
	        					<div id="ally">
	        						<button id='sTroops1'>select troops</button>
        							<button id='scout'>scout</button><br>
        						</div>
        						<div id="sally">
        							<button id='scout1'>scout</button><br>
        							<button id='move1'>move</button><br>
        						</div>
        						<div id="neutral">
        							<button id='sTroops2'>select troops</button>
        							<button id='scout2'>scout</button><br>
        							<button id='settle'>settle</button><br>
        						</div>
        						<div id="sneutral">
        							<button id='scout3'>scout</button><br>
        							<button id='move2'>move</button><br>
        						</div>
        						<div id="enemy">
        							<button id='scout4'>scout</button><br>
        						</div>
        						<div id="sEnemy">
        							<button id='scout5'>scout</button><br>
        							<button id='attack'>attack</button><br>
        						</div>
							</div>
					</div>
				</td>
				<td>
					<table id="hint">
						<tr>
							<td>
								<div id="bottom_hint">
									
								</div>
							</td>
							<td>
								<div id="rc">
									
								</div>
							</td>
						</tr>
	
					</table>
				</td>
				<td>
					<div style="float:right">
						<form method="POST" action="shift.php">
							<table id="nav_buttons" border=0 align="center">
								<tr>
									<td></td>
									<td align="center"><button type="submit" name="up">UP</button></td>
									<td></td>
								</tr>
								<tr>
									<td align="center"><button name="left">LEFT</button></td>
									<td align="center"><button name="world-map">WORLD MAP</button></td>
									<td align="center"><button name="right">RIGHT</button></td>
								</tr>
								<tr>
									<td></td>
									<td align="center"><button name="down">DOWN</button></td>
									<td></td>
								</tr>
							</table>
						</form>
					</div>
				</td>
			</tr>		
		</table>
	</div>
	<div id="contextMenu">
		<form id="ctxForm" action="player.php" method="post">
		</form>
	</div>
</body>
</html>