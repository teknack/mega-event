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
					<span>Food : </span>
					<span>Water :</span>
					<span>Power :</span>
					<span>Metal :</span>
					<span>Wood : </span>
					
				</div>
				<span>
					<form action="resources.php" method="POST"> 
						<button type="submit" id="resource">Collect Resources</button>
					</form>
				</span>
		<!--	</tr>
		</table>	-->
		
	</div>
	<br><br>
	<div id="playgroup">
		<div id="leftbanner" class="playarea"> </div>
		<div id="localplay" class="playarea" align="center">
			<canvas id="canvas" width="500" height="500" style="border:1px solid #c3c3c3;">
				Your browser does not support the canvas element.
			</canvas>
		</div>
		<div id="rightbanner" class="playarea"> </div>
	</div>
	<hr>
	<div id="bottomgroup" border=1>
		<table id="bottomTable"> 
			<tr>
				<td>
					<div id="bottom_action" style="float:left">
							<div>
								<input type="hidden" name="row" id="row">
								<input type="hidden" name="col" id="col">
								<input type="number" name="quantity" id="quantity">
							</div>
							<div id="action">
								<div id="player">
									<button id='cTroops'>create troops</button><br>
	        						<button id='sTroops'>select troops</button><br>
	        						<button id='sTroops'>fortify</button><br>
	        					</div>
	        					<div id="ally">
        							<button id='scout'>scout</button><br>
        						</div>
        						<div id="enemy">
        							<button id='scout'>scout</button><br>
        						</div>
        						<div id="sEnemy">
        							<button id='scout'>scout</button><br>
        							<button id='attack'>attack</button><br>
        						</div>
							</div>
					</div>
				</td>
				<td>
					<div id="bottom_hint">
						
					</div><br>
					<div id="prompt">

					</div>
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