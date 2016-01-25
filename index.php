<?php
/*
 * Homepage
 * Meant as welcome page to start/continue game
 * may also act as a dashboard of sorts
 */
include "./db_access/db.php";

if (isset($_POST) && !empty($_POST))
{
	connect();
	
	if (checkPlayerExists($_POST["username"],"player"))
	{
		alert("welcome back ".$_POST["username"]."");
		$_SESSION["tek_emailid"] = $_POST["username"];
		disconnect();
		redirect("./world-map/canvas1.html");
	}
	else
	{
		alert("Setting you up!");
		$_SESSION["tek_emailid"] = $_POST["username"];
		disconnect();
		redirect("./setup.php");
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
	</body>
</html>
