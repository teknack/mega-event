<html>

<head>
	
	<title>Tutorial page</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width. initial scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../maincss/mainstyle.css">
    <link rel="stylesheet" type="text/css" href="./css/local.css">
	<script src="tut.js"></script>
</head>

<body>
	
	
	<!-- New navbar -->
	<!-- Top Navigation bar with status information -->

	<nav class="navbar">
		<div class="container-fluid">
			<!-- Menu items -->
			<div>
				<ul class="nav navbar-nav">
					<li><p class="navbar-text"><img class="navimage" src="./css/image/foodnew.png"><span id="food">Food : </span></p></li>
					<li><p class="navbar-text"><img class="navimage" src="./css/image/waternew.png"><span id="water">Water: </span></p></li>
					<li><p class="navbar-text"><img class="navimage" src="./css/image/powernew.png"><span id="power">Power: </span></p></li>
					<li><p class="navbar-text"><img class="navimage" src="./css/image/metalnew.png"><span id="metal">Metal: </span></p></li>
					<li><p class="navbar-text"><img class="navimage" src="./css/image/woodnew.png"><span id="wood">Wood: </span></p></li>
				</ul>
			
				<!-- Menu right items -->
				<ul class="nav nav-tabs navbar-nav navbar-right">
					<li><a href="../landing/index.html">Return</a></li>
					<li class="active"><a href="#">Local</a></li>
					<li><a href="../landing/index.html">Return</a></li>
					<li><a href="../landing/index.html">Return</a></li>
					<li><a href="../landing/index.html">Return <span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<!-- Canvas Part -->
	<div class="container white-bg">
		<div class="row" id="main">
			<div id="localplay" class="col-md-5 bigpart">
				<canvas id="mapCanvas" width="540" height="540">
					Your browser does not support the canvas element.
				</canvas>
				<canvas id="canvas" width="540" height="540">
					Your browser does not support the canvas element.
				</canvas>
			</div>
	
	<!-- -->
	
		<div class="col-md-4 littlepart">
			<div id="rc" style="background: rgba(255,255,255,0.6)">
			</div>
			<div class="panel panel-default">
				<div id="tutorials" class="panel-body" align="center">
					<button type="submit" id="basics">basics</button><br><br>
					<button type="submit" id="scouting">scouting</button><br><br>
					<button type="submit" id="tileTypes">tile types and bonuses</button><br><br>
					<button type="submit" id="selMove">selecting and moving troops</button><br><br>
					<button type="submit" id="selMove2">selecting and moving troops-II</button><br><br>
					<button type="submit" id="settling">settling</button><br><br>
					<button type="submit" id="creatingTroops">creating troops</button><br><br>
					<button type="submit" id="attacking">attacking</button><br><br>
					<button type="submit" id="research">research</button><br><br>
					<button type="submit" id="market">market and getting more resources</button><br><br>
				</div>
			</div>
			<div class="panel panel-default">
					<div id="prompt" class="panel-body"> </div>
			</div>
		</div>
	
		<div class="col-md-3 littlepart" id="bottomgroup">
			<div id="bottom_action">
				<input type="hidden" name="action" id="action">
				<input type="hidden" name="row" id="row">
				<input type="hidden" name="col" id="col">
				<input type="number" name="quantity" id="quantity">
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
			<div id="bottom_hint">
				<?php
					if(isset($_SESSION['result']))
					{
						if($_SESSION['result'])
							echo "you won!!";
						else
							echo "you  lost :( try again";
					}
				?>
			</div>

				
		</div>

		<br><br>
		<div class="row">
			<div class="col-md-3">
				<form method="" action="">
					<table id="nav_buttons" border=0 align="center">
						<tr>
							<td></td>
							<td align="center"><button type="button" name="up" id="up"></button></td>
							<td></td>
						</tr>
						<tr>
							<td align="center"><button type="button" name="left" id="left"></button></td>
							<td align="center"><button type="button" name="world-map" id="world"></button></td>
							<td align="center"><button type="button" name="right" id="right"></button></td>
						</tr>
						<tr>
							<td></td>
							<td align="center"><button type="button" name="down" id="down"></button></td>
							<td></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		
		
	</div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
</body>
</html>
