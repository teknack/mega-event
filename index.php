<?php
/*
 * Homepage
 * Meant as welcome page to start/continue game
 * may also act as a dashboard of sorts
 */
include "./db_access/db.php";
gameUnset(); //in db.php, unsets non-essential variables
//session_unset(); //Clears out the Session variable :: DANGEROUS! :: Is there an alternative??
if (isset($_POST) && !empty($_POST))
{
	connect();
	
	if (!isset($_SESSION["in_game"]))
	{
		if (checkPlayerExists($_POST["username"],"player"))
		{
			alert("welcome back ".$_POST["username"]."");
			$_SESSION["tek_emailid"] = $_POST["username"];
			//$_SESSION["in_game"] = True;
			disconnect();
			redirect("./world-map/canvas1.html");
		}
		else
		{
			alert("Setting you up!");
			$_SESSION["tek_emailid"] = $_POST["username"];
			var_dump($_SESSION);
			alert("hold");
			disconnect();
			redirect("./setup.php");
		}
	}
	else if (isset($_SESSION["in_game"]))
	{
		var_dump($_SESSION);
		alert("welcome back ".$_POST["username"]."");
		disconnect();
		redirect("./world-map/canvas1.html");
	}
}

?>
<html>

	<head>
		<title>Home page</title>
	</head>

	<body>
		<form action="" method="POST">
			<input type="text" name="username" placeholder="tek_emailid"/>
			<button type="submit">Submit</button>
		</form>
		<hr>
		<?php var_dump($_SESSION);?>
	</body>
</html>
