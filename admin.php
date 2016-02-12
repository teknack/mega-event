<?php
include "./db_access/db.php";
//session_start();
function testVar($input="")
{
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);

	return ($input);
}
	
	if (isset($_POST) && !empty($_POST))
	{
		$username = testVar($_POST["username"]);
		$password = testVar($_POST["password"]);
		
		if ($username === "Nischal" || $username === "Jacques" || $username === "Siddhant")
		{
			if ($password === "ThreeGandus")
			{
				$_SESSION["admin"] = true;
				header("location: ./admin-main.php");
			}
		} 
	}
?>
<html>
	<head>
		<title>:: MEGA ADMIN :: Login</title>
	</head>
	
	<body>
		<center><h1>:: MEGA ADMIN LOGIN ::</h1></center>
			<center>
				<form action="" method="POST">
					<input type="text" name="username" placeholder="Username"/>
					<input type="password" name="password" placeholder="Password"/>
					<button type="submit">Login</button>
				</form>
			</center>
	</body>
</html>
