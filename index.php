<?php
#DB connectivity test
include "./db_access/db.php";

if (isset($_POST) && !empty($_POST))
{
	if (isset($_POST["player1"]))
	{
		alert("Welcome, player1");
		$_SESSION["tek_emailid"]=1;
	}
	else if (isset($_POST["player2"]))
	{
		alert("Welcome, player 2");
		$_SESSION["tek_emailid"]=2;
	}
	redirect("./world-map/canvas1.html");
}

//connect();
//var_dump(getSlot(1,1));
?>
<html>
	<head>
	</head>
	
	<body>
		<form action="" method="POST">
			Player : <button type="submit" name="player1">Player 1</button> <button type="submit" name="player2">Player 2</button>
		</form>
		
		<!--
		<form action="./local-map" method="POST">
			<input name="player" type="text" placeholder="Player name"/><br>
			<input name="x" type="text" placeholder="selected x coordinate"/><br>
			<input name="y" type="text" placeholder="selected y coordinate"/><br>
			<button type="submit">Submit</button>
		</form>
		-->
	</body>
</html>
