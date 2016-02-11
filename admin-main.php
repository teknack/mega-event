<?php
/*
 * Admin page!
 * Used by us to mess around and see stats
 */
include "./db_access/db.php";
 
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != true)
{
	alert("nice try... Go play");
	die(redirect("http://teknack.in"));
}

//gameUnset();

if (isset($_POST) && !empty($_POST))
{
	connect();

	if (!isset($_SESSION["in_game"]))
	{
		if (checkPlayerExists($_POST["username"],"player"))
		{
			alert("welcome back ".$_POST["username"]."");
			$_SESSION["tek_emailid"] = $_POST["username"];
			$_SESSION["faction"] = fetch($_SESSION["tek_emailid"],"faction");
			disconnect();
			$_SESSION["admin"] = null;
			header("location:landing/index.html");
		}
		else
		{
			alert("Setting you up!");
			$_SESSION["tek_emailid"] = $_POST["username"];
			var_dump($_SESSION);
			alert("hold");
			disconnect();
			$_SESSION["admin"] = null;
			redirect("./setup.php");
		}
	}
	else if (isset($_SESSION["in_game"]))
	{
		var_dump($_SESSION);
		alert("welcome back ".$_POST["username"]."");
		disconnect();
		$_SESSION["admin"] = null;
		redirect("./world-map/canvas1.html");
	}
}

?>
<html>

	<head>
		<title>ADMIN</title>
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
