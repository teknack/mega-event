<?php
//This file serves as a temporary re-directing transition page...
//include "../db_access/db.php";
session_start();
//include "./player.php";
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width. initial scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../maincss/mainstyle.css">	
	<link rel="stylesheet" type="text/css" href="./css/local.css">
	<title>Test page</title>
	<script src="action.js"></script>
</head>

<body>

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
					<li class="active"><a href="#">Local</a></li>
					<li><a href="../market/index.php">Market</a></li>
					<li><a href="#">Research</a></li>
					<li><a href="./resources.php">Collect</a></li>
					<li><a href="../world-map/canvas1.html">World Map <span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a></li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- <div id="playgroup">   Unsure if you need this SID. Let me know -->

	<div class="container white-bg">
		<div class="row" id="main">
			<div id="localplay" class="col-md-6 bigpart">
				<canvas id="mapCanvas" width="540" height="540">
					Your browser does not support the canvas element.
				</canvas>
				<canvas id="canvas" width="540" height="540">
					Your browser does not support the canvas element.
				</canvas>
			</div>

			<div class="col-md-3 littlepart">
				<div class="panel panel-default">
					<div id="bottom_action" class="panel-body">
						<form action="player.php" method="POST">
							<input type="hidden" name="topLeft" id="topLeft">
							<input type="hidden" name="row" id="row">
							<input type="hidden" name="col" id="col">
							<input type="number" name="quantity" id="quantity">
						</form> <!-- Is this okay SID? I moved the end of form tag before the divs -->
						<div id="action">
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-body">
						<div id="cost">
						</div>
					</div>
				</div>
			</div>
						<!-- </form> -->
			<div class="col-md-3 littlepart">
				<div class="panel panel-default">
					<div class="panel-body">
						<div id="bottom_hint">
							<?php
								if(isset($_SESSION['response']))
								{
									echo $_SESSION['response'];
									unset($_SESSION['response']);
								}
							?>
						</div>
						<div id="rc"> <!-- What does this do SID? -->

						</div>
					</div>
				</div>
			
				<div class="panel panel-default">
					<div class="panel-body">	
						<form method="POST" action="shift.php">
							<table id="nav_buttons" border=0 align="center">
								<tr>
									<td></td>
									<td align="center"><button name="up" id="up"></button></td>
									<td></td>
								</tr>
								<tr>
									<td align="center"><button name="left" id="left"></button></td>
									<td align="center"><button name="world-map" id="world"></button></td>
									<td align="center"><button name="right" id="right"></button></td>
								</tr>
								<tr>
									<td></td>
									<td align="center"><button name="down" id="down"></button></td>
									<td></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="white-bg" id="ctxMenu" style="display:none;">
		<form id="ctxForm" action="player.php" method="post">
			<div id="action1"></div>
				<input type="hidden" name="row" id="row1">
				<input type="hidden" name="col" id="col1">
				<label for="quantity1">Q:</label>
				<input type="number" name="quantity" id="quantity1">
			
		</form>
	</div>
	<div class="white-bg">
		<input type="hidden"  id="scoutRow">
		<input type="hidden"  id="scoutCol">
		<input type="hidden"  id="side">
	</div>
	<?php 
		//some request method
		$res=$_SESSION['coord'];
		$x=$res[0];
		$y=$res[1];
		if(isset($_SESSION['side']))
		{
			$r=intval($_SESSION['scoutRow']);
			$c=intval($_SESSION["scoutCol"]);
			$side=$_SESSION["side"];
			echo "$side";
			echo "<script>document.getElementById('scoutRow').value=$r</script>";
			echo "<script>document.getElementById('scoutCol').value=$c</script>";
			echo "<script>document.getElementById('side').value='$side'</script>";
			unset($_SESSION['side']);
			unset($_SESSION['scoutRow']);
			unset($_SESSION['scoutCol']);
		}
		echo "<script>document.getElementById('topLeft').value='$x,$y'</script>" 
	?>


	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
</body>
</html>
